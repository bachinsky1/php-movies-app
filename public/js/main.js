const modal = document.getElementById("movieInfoModal");
const errorContainer = document.getElementById("errorContainer");
const errorList = document.getElementById("errorList");

const showError = (message) => {
    errorList.innerText = `${message}`;
    errorContainer.classList.remove('hidden');
};

const clearError = () => {
    errorContainer.classList.add('hidden');
    errorList.innerText = '';
};

const checkForErrorInURL = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        showError(error);
        urlParams.delete('error');
        const newUrl = urlParams.toString() ? `${window.location.pathname}?${urlParams}` : window.location.pathname;
        window.history.replaceState({}, '', newUrl);
    }
};


window.addEventListener("DOMContentLoaded", (event) => {
    checkForErrorInURL();
});

window.onclick = (event) => {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

const showMovieInfo = async (movieId) => {
    try {
        const response = await fetch("/movie-info/" + movieId);
        const movie = await response.json();

        const movieInfoContent = `
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-4">${movie.title}</h3>
                <p class="text-md mb-2"><span class="font-bold">Year:</span> ${movie.release_year}</p>
                <p class="text-md mb-2"><span class="font-bold">Format:</span> ${movie.format}</p>
                <p class="text-md"><span class="font-bold">Actors:</span> ${movie.actors.join(", ")}</p>
            </div>
        `;

        document.getElementById("movieInfoContent").innerHTML = movieInfoContent;
        modal.style.display = "block";
    } catch (error) {
        console.error("Failed to fetch movie info:", error);
    }
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
