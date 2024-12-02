
/*
function loadContent(page) {
    const contentDiv = document.getElementById('mainContent');

    let xhr = new XMLHttpRequest();

    xhr.open('GET', page, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            contentDiv.innerHTML = xhr.responseText;
        }
        else {
            contentDiv.innerHTML = '<p>Error loading content.</p>';
        }
    };

    // Send the request
    xhr.send();
}

// Event listeners for navigation buttons
document.getElementById('homeBtn').addEventListener('click', function() {
    loadContent('../../views/dashboard.php');
});

document.getElementById('newContactBtn').addEventListener('click', function() {
    loadContent('../../views/newContact.php');
});

document.getElementById('addUserBtn').addEventListener('click', function() {
    loadContent('../../views/addUser.php');
});


loadContent('../../views/contact.php');

 */

function loadContent(url) {
    const mainContent = document.getElementById('mainContent'); // The container for the main content

    // Show loading spinner or text while the content is being loaded
    mainContent.innerHTML = 'Loading...';

    // Create an AJAX request to fetch the new content
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text(); // We assume the response is HTML
        })
        .then(data => {
            // Replace the content of the main section with the new content
            mainContent.innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading content:', error);
            mainContent.innerHTML = 'There was an error loading the content.';
        });
}

document.addEventListener("DOMContentLoaded", function () {
    // Get all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior

            const target = this.getAttribute('data-target'); // Get the target from data-attribute
            if (target === 'views/logout.php') {
                window.location.href = target; // Redirect to logout if the target is logout.php
            } else {
                loadContent(target); // Call the function to load content dynamically
            }
        });
    });

    // Initial content load
    loadContent('views/viewUsers.php');
});
