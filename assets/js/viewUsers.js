function loadContent(url) {
    const mainContent = document.getElementById('viewUsers');

    mainContent.innerHTML = 'Loading...';

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            return response.text();
        })
        .then(data => {
            mainContent.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading content:', error);
            mainContent.innerHTML = 'There was an error loading the content.';
        });
}

document.addEventListener("DOMContentLoaded", function () {
    const addUserBtn = document.getElementById('addUserButton');

    if (addUserBtn) {
        addUserBtn.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent any default behavior (if any)
            loadContent('addUser.php'); // Load the content for adding a new user
        });
    }
});