function loadContent(url) {
    const mainContent = document.getElementById('mainContent');

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
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const target = this.getAttribute('data-target');
            if (target === 'views/logout.php') {
                window.location.href = target;
            } else {
                loadContent(target);
            }
        });
    });

    // It is set to viewUsers right now since I dont have the dashboard.
    loadContent('views/viewUsers.php');
});
