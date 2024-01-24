<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Movie;
use App\Models\Actor;

class HomeController extends BaseController
{

    public function index($sort = null)
    {
        $movies = Movie::all();
        $moviesArray = $movies->toArray();
        $collator = new \Collator('uk_UA');

        if ($sort === 'z-a') {
            usort($moviesArray, function ($a, $b) use ($collator) {
                return $collator->compare($b['title'], $a['title']); // Sorting Z-A
            });
        } else {
            usort($moviesArray, function ($a, $b) use ($collator) {
                return $collator->compare($a['title'], $b['title']); // Sort A-Z (or default)
            });
        }

        $this->view('home', ['movies' => $moviesArray]);
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
        [$firstName, $lastName] = array_pad(explode(' ', $actorName, 2), 2, null);
    
        if (!$lastName) {
            $actors = Actor::with('movies')
                ->where(function($query) use ($firstName) {
                    $query->where('first_name', 'like', "%{$firstName}%")
                          ->orWhere('last_name', 'like', "%{$firstName}%");
                })
                ->get();
        } else {
            $actors = Actor::with('movies')
                ->where(function($query) use ($firstName, $lastName) {
                    $query->where('first_name', 'like', "%{$firstName}%")
                          ->where('last_name', 'like', "%{$lastName}%");
                })
                ->get();
        }
    
        $movies = $actors->flatMap(function ($actor) {
            return $actor->movies;
        })->unique('id')->values()->all();
    
        $this->view('home', ['movies' => $movies]);
    }
    
    public function login()
    {
        $this->view('login');
    }

    public function getMovieInfo($movieId)
    {
        $movie = Movie::with('actors')->findOrFail($movieId);

        // Create an array where each element is the “First Name Last Name” of the actor
        $actorsNames = $movie->actors->map(function ($actor) {
            // If the last name is not specified (null), we return only the first name
            if (is_null($actor->last_name)) {
                return $actor->first_name;
            }
            // Otherwise, return "First Name Last Name"
            return $actor->first_name . ' ' . $actor->last_name;
        })->toArray();

        return json_encode([
            'title' => $movie->title,
            'release_year' => $movie->release_year,
            'format' => $movie->format,
            'actors' => $actorsNames
        ]);
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

    public function addMovie()
    {
        // Retrieving data from a request
        $title = $this->sanitize($_POST['title']);
        $releaseYear = intval($_POST['release_year']);
        $format = $this->sanitize($_POST['format']);
        $stars = array_map('trim', explode(',', $_POST['stars']));

        // Checking the validity of the movie title
        if (!$this->isValidTitle($title)) {
            header('Location: /?error=invalid_title');
            return;
        }

        // Checking the validity of the year of release
        if (!$this->isValidReleaseYear($releaseYear)) {
            header('Location: /?error=invalid_release_year');
            return;
        }

        // Checking for the existence of a film
        if ($this->isMovieExists($title)) {
            header('Location: /?error=movie_exists');
            return;
        }

        // Actor processing
        foreach ($stars as $starName) {
            [$firstName, $lastName] = explode(' ', $starName, 2) + [null, null];

            // If the actor's first or last name has not been validated, we abort execution
            if (!$this->isValidActorName($firstName) || ($lastName && !$this->isValidActorName($lastName))) {
                header('Location: /?error=invalid_actor_name');
                return;
            }
        }

        // Making a new film
        $movie = Movie::create([
            'title' => $title,
            'release_year' => $releaseYear,
            'format' => $format,
        ]);

        // The process of associating a film with actors
        foreach ($stars as $starName) {
            [$firstName, $lastName] = explode(' ', $starName, 2) + [null, null];
            $actor = Actor::firstOrCreate([
                'first_name' => $firstName,
                'last_name' => $lastName ?: null
            ]);
            // Linking the film and the actor
            $movie->actors()->syncWithoutDetaching($actor->id);
        }

        header('Location: /');
    }

    public function importMovies()
    {
        // Checking for an uploaded file
        if (!isset($_FILES['movies_file'])) {
            header('Location: /?error=no_file_uploaded');
            exit;
        }

        $file = $_FILES['movies_file'];
        $validationError = $this->validateMovieFile($file);
        if ($validationError) {
            header("Location: /?error=$validationError");
            exit;
        }

        // Reading the contents of a file
        $content = file_get_contents($_FILES['movies_file']['tmp_name']);

        // Processing of each film
        $movies = $this->parseMovies($content);

        foreach ($movies as $movieData) {
            $releaseYear = intval($movieData['release_year']);
            if (
                !$this->isValidTitle($movieData['title'])
                || !$this->isValidReleaseYear($releaseYear)
                || $this->isMovieExists($movieData['title'])
            ) {
                continue; // Skip a movie if the release year is not valid, the movie already exists, or the title is empty
            }

            // Actor Name Validation
            foreach ($movieData['stars'] as $starName) {
                [$firstName, $lastName] = explode(' ', $starName, 2) + [null, null];
                // var_dump($this->isValidActorName($firstName), $this->isValidActorName($lastName));
                if (!$this->isValidActorName($firstName) || ($lastName && !$this->isValidActorName($lastName))) {
                    continue 2; // Skip the current movie completely if the actor's name is not validated
                }
            }

            // Creating a new movie if all actor names are validated
            $movie = Movie::create([
                'title' => $movieData['title'],
                'release_year' => intval($movieData['release_year']),
                'format' => $movieData['format']
            ]);

            // The process of associating a film with actors
            foreach ($movieData['stars'] as $starName) {
                [$firstName, $lastName] = explode(' ', $starName, 2) + [null, null];
                $actor = Actor::firstOrCreate([
                    'first_name' => $firstName,
                    'last_name' => $lastName ?: null
                ]);
                $movie->actors()->syncWithoutDetaching($actor->id);
            }
        }

        header('Location: /');
    }

    private function isValidActorName($name)
    {
        $trimmedName = trim($name);
        if (empty($trimmedName)) {
            return false;
        }
        return preg_match('/^[a-zA-Zа-яА-ЯіІїЇєЄґҐьЬ’\-\s]+$/u', $trimmedName);
    }

    private function validateMovieFile($file)
    {
        // Check for file format (must be .txt)
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (strtolower($fileExtension) !== 'txt') {
            return 'invalid_file_format';
        }

        // Checking that the file is not empty
        if ($file['size'] <= 0) {
            return 'empty_file';
        }

        // Reading the contents of a file
        $content = file_get_contents($file['tmp_name']);
        // Checking that the file matches the expected structure
        if (!preg_match('/(Title: .+\nRelease Year: \d+\nFormat: .+\nStars: .+\n\n)+/', $content)) {
            return 'invalid_file_structure';
        }

        // If all checks pass, return null
        return null;
    }

    private function isValidTitle($title)
    {
        $trimmedTitle = trim($title);
        return !empty($trimmedTitle);
    }

    private function isMovieExists($title)
    {
        $existingMovie = Movie::where('title', $title)->first();
        return $existingMovie !== null;
    }

    private function isValidReleaseYear($releaseYear)
    {
        $currentYear = date("Y");
        return $releaseYear >= 1900 && $releaseYear <= intval($currentYear);
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
