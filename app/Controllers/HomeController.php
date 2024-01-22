<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Actor;

class HomeController extends BaseController
{
    public function index()
    {
        // Get a list of movies from the database
        // Sort them by name
        $movies = Movie::orderBy('title', 'asc')->get();

        $this->view('home', ['movies' => $movies]);
    }

    public function searchByTitle()
    {
        $title = $this->sanitize($_POST['title']) ?? '';
        $movies = Movie::where('title', 'like', "%{$title}%")->get();
        $this->view('home', ['movies' => $movies]);
    }

    public function searchByActor()
    {
        $actorName = $this->sanitize($_POST['actor']) ?? '';
        [$firstName, $lastName] = explode(' ', $actorName, 2) + [null, null];

        $actors = Actor::with('movies')->where('first_name', 'like', "%{$firstName}%")
            ->where('last_name', 'like', "%{$lastName}%")
            ->get();

        $movies = [];
        foreach ($actors as $actor) {
            $movies = array_merge($movies, $actor->movies->toArray());
        }


        $this->view('home', ['movies' => $movies]);
    }

    public function login()
    {
        $this->view('login');
    }

    public function getMovieInfo($movieId)
    {
        $movie = Movie::with('actors')->findOrFail($movieId);

        // We create an array where each element is the “First Name Last Name” of the actor
        $actorsNames = $movie->actors->map(function ($actor) {
            return $actor->first_name . ' ' . $actor->last_name;
        })->toArray();

        return json_encode([
            'title' => $movie->title,
            'release_year' => $movie->release_year,
            'format' => $movie->format,
            'actors' => $actorsNames
        ]);
    }

    public function addMovie()
    {
        // Receiving data from the request
        $title = $this->sanitize($_POST['title']);
        $releaseYear = intval($_POST['release_year']);
        $format = $this->sanitize($_POST['format']);
        $stars = array_map('trim', explode(',', $_POST['stars'])); // Convert a string to an array

        // Create a new movie
        $movie = Movie::create([
            'title' => $title,
            'release_year' => intval($releaseYear),
            'format' => $format,
        ]);

        // Process actors
        foreach ($stars as $starName) {
            // Get the actor's first and last name
            [$firstName, $lastName] = explode(' ', $starName, 2) + [null, null];

            // Check for first and last name
            if ($firstName === null || $lastName === null) {
                // Skip the actor if first or last name is not specified
                continue;
            }

            // Check if such an actor already exists
            $actor = Actor::firstOrCreate([
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);
            // Linking the film and the actor
            $movie->actors()->syncWithoutDetaching($actor->id);
        }

        // Redirect to the page with movies
        header('Location: /');
    }


    public function deleteMovie($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $movie->delete();

        header('Location: /');
    }

    public function authenticate()
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die('CSRF token validation failed');
        }

        // Get data from the request
        $login = $_POST['login'];
        $password = $_POST['password'];

        $user = User::where('login', $login)->first();
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            header('Location: /');
        } else {
            $this->view('login');
        }
    }


    public function importMovies()
    {
        // Check if the file has been uploaded
        if (!isset($_FILES['movies_file'])) {
            header('Location: /');
        }

        // Read the contents of the file
        $content = file_get_contents($_FILES['movies_file']['tmp_name']);

        // Process each movie
        $movies = $this->parseMovies($content);
        $allActorNames = [];
        foreach ($movies as $movieData) {
            foreach ($movieData['stars'] as $starName) {
                $allActorNames[] = $starName;
            }
        }

        // Get or create all actors at once to reduce database queries
        $actors = collect($allActorNames)->mapWithKeys(function ($starName) {
            [$firstName, $lastName] = explode(' ', $starName, 2) + [null, null];
            $actor = Actor::firstOrCreate([
                'first_name' => $firstName,
                'last_name' => $lastName
            ]);
            return [$starName => $actor->id];
        });

        foreach ($movies as $movieData) {
            // Check if such a movie already exists in the database
            $movie = Movie::where('title', $movieData['title'])
                ->where('release_year', $movieData['release_year'])
                ->first();
            if (!$movie) {
                // Create a new movie
                $movie = Movie::create([
                    'title' => $movieData['title'],
                    'release_year' => intval($movieData['release_year']),
                    'format' => $movieData['format']
                ]);
            }

            // Prepare actor IDs for the movie
            $actorIds = collect($movieData['stars'])->map(function ($starName) use ($actors) {
                return $actors[$starName];
            })->all();

            // Update connections between movie and actors, avoiding duplication
            $movie->actors()->syncWithoutDetaching($actorIds);
        }

        header('Location: /');
    }


    private function parseMovies($content)
    {
        // Divide the content into blocks by movie
        $movieBlocks = explode("\n\n", trim($content));
        $movies = [];

        foreach ($movieBlocks as $block) {
            $lines = explode("\n", trim($block));
            $movieData = [
                'title' => $this->sanitize(str_replace('Title: ', '', $lines[0])),
                'release_year' => $this->sanitize(str_replace('Release Year: ', '', $lines[1])),
                'format' => $this->sanitize(str_replace('Format: ', '', $lines[2])),
                'stars' => array_map('trim', explode(',', $this->sanitize(str_replace('Stars: ', '', $lines[3]))))
            ];
            $movies[] = $movieData;
        }

        return $movies;
    }

    private function sanitize($input)
    {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        $_SESSION = [];
        session_destroy();

        header('Location: /login');
    }

}
