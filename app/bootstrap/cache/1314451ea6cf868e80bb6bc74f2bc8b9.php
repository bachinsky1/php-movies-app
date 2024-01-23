<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
        <link href="/css/styles.css" rel="stylesheet">
        <link href="/css/css.css" rel="stylesheet">
    </head>

    <body class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out">
            <nav>
                <a href="/" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">Movies list</a>
            </nav>
        </div>
        <!-- Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex justify-between items-center p-4 shadow-md">
                <div></div>
                <a href="/logout" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Logout</a>
            </header>
            <!-- Main content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="mx-auto px-6 py-8">
                    <div id="errorContainer" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 w-full" role="alert">
                        <strong class="font-bold">Error! </strong>
                        <span id="errorList" class="block sm:inline"></span>
                    </div>
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-4xl font-semibold">Movies list</h1>
                        <div>
                            <button onclick="showModal('importMoviesModal')" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">Importing movies</button>
                            <button onclick="showModal('addMovieModal')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Add a movie</button>
                            <button onclick="showModal('searchMovieModal')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">Search by name</button>
                            <button onclick="showModal('searchActorModal')" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Search by actor</button>
                        </div>
                    </div>
                    <div class="bg-white shadow-md rounded my-6">
                        <table class="text-left w-full border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">ID</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Name</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Year</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Format</th>
                                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light"></th>
                                </tr>
                            </thead>
                            <tbody> 
                                <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                                <tr class="hover:bg-grey-lighter">
                                    <td class="py-4 px-6 border-b border-grey-light"><?php echo e($movie['id']); ?></td>
                                    <td class="py-4 px-6 border-b border-grey-light"><?php echo e($movie['title']); ?></td>
                                    <td class="py-4 px-6 border-b border-grey-light"><?php echo e($movie['release_year']); ?></td>
                                    <td class="py-4 px-6 border-b border-grey-light"><?php echo e($movie['format']); ?></td>
                                    <td class="py-4 px-6 border-b border-grey-light flex items-center justify-end space-x-2">
                                        <button onclick="showMovieInfo(<?php echo e($movie['id']); ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Details</button>
                                        <form action="/delete-movie/<?php echo e($movie['id']); ?>" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                        </form>
                                    </td>
                                </tr> 

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <!-- Footer -->
            <footer class="p-4 shadow-md">
                <div class="flex items-center justify-center space-x-2">Company name</div>
            </footer>
        </div>
        <!-- Modals -->
        <!-- Add movie -->
        <div id="addMovieModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
            <div class="modal-content p-5 bg-white mx-auto my-20 max-w-lg rounded shadow-lg">
                <h2 class="text-xl mb-4">Add movie</h2>
                <form action="/add-movie" method="POST" class="space-y-4">
                    <div>
                        <label for="title" class="block">Film name:</label>
                        <input type="text" id="title" name="title" class="w-full p-2 border rounded" required>
                    </div>
                    <div>
                        <label for="release_year" class="block">Year:</label>
                        <input type="number" id="release_year" min="1899" name="release_year" class="w-full p-2 border rounded" required>
                    </div>
                    <div>
                        <label for="format" class="block">Format:</label>
                        <select id="format" name="format" class="w-full p-2 border rounded" required>
                            <option value="VHS">VHS</option>
                            <option value="DVD">DVD</option>
                            <option value="Blu-ray">Blu-ray</option>
                        </select>
                    </div>
                    <div>
                        <label for="stars" class="block">Actors (separate names names with commas):</label>
                        <input type="text" id="stars" name="stars" class="w-full p-2 border rounded" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add movie</button>
                </form>
            </div>
        </div>
        <!-- Search film by name -->
        <div id="searchMovieModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
            <div class="modal-content p-5 bg-white mx-auto my-20 max-w-lg rounded shadow-lg">
                <h2 class="text-xl mb-4">Search film by name</h2>
                <form action="/search-by-title" method="POST" class="space-y-4">
                    <div>
                        <input type="text" name="title" placeholder="Movie name" class="w-full p-2 border rounded">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                </form>
            </div>
        </div>
        <!-- Search film by actor -->
        <div id="searchActorModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
            <div class="modal-content p-5 bg-white mx-auto my-20 max-w-lg rounded shadow-lg">
                <h2 class="text-xl mb-4">Search film by actor</h2>
                <form action="/search-by-actor" method="POST" class="space-y-4">
                    <div>
                        <input type="text" name="actor" placeholder="Actor name" class="w-full p-2 border rounded">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
                </form>
            </div>
        </div>
        <!-- Info about film -->
        <div id="movieInfoModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
            <div class="modal-content p-5 bg-white mx-auto my-20 max-w-lg rounded shadow-lg">
                <div id="movieInfoContent">
                    
                </div>
            </div>
        </div>
        <!-- Import movie from file -->
        <div id="importMoviesModal" class="modal hidden fixed z-10 inset-0 overflow-y-auto">
            <div class="modal-content p-5 bg-white mx-auto my-20 max-w-lg rounded shadow-lg">
                <h2 class="text-xl mb-4">Importing movies from a file</h2>
                <form action="/import-movies" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <input type="file" name="movies_file" class="w-full p-2 border rounded" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Import</button>
                </form>
            </div>
        </div>
        <script src="/js/main.js"></script>
    </body>

</html><?php /**PATH /var/www/app/resources/views/home.blade.php ENDPATH**/ ?>