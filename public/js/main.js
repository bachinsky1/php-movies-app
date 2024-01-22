const modal = document.getElementById("movieInfoModal");


window.onclick = (event) => {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

const showMovieInfo = (movieId) => {
    fetch("/movie-info/" + movieId)
        .then((response) => response.json())
        .then((movie) => {
            const movieInfoContent = `
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">${movie.title}</h3>
                    <p class="text-md mb-2"><span class="font-bold">Year:</span> ${
                        movie.release_year
                    }</p>
                    <p class="text-md mb-2"><span class="font-bold">Format:</span> ${
                        movie.format
                    }</p>
                    <p class="text-md"><span class="font-bold">Actors:</span> ${movie.actors.join(
                        ", "
                    )}</p>
                </div>
            `;

            document.getElementById("movieInfoContent").innerHTML = movieInfoContent;
            modal.style.display = "block";
        });
};

const showModal = (modalId) => {
    const modal = document.getElementById(modalId);
    modal.style.display = "block";
};

const closeModal = (modalId) => {
    const modal = document.getElementById(modalId);
    modal.style.display = "none";
};

window.addEventListener("click", (event) => {
    if (event.target.classList.contains("modal")) {
        event.target.style.display = "none";
    }
});
