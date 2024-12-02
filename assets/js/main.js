function loadContent(page) {
    const contentDiv = document.getElementById('mainContent');

    // Create a new XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // Set up the request (GET or POST) and the PHP file
    xhr.open('GET', page, true);

    // Define the response type and behavior after receiving data
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Insert the response (view file content) into the main content area
            contentDiv.innerHTML = xhr.responseText;
        } else {
            contentDiv.innerHTML = '<p>Error loading content.</p>';
        }
    };

    // Send the request
    xhr.send();
}

// Event listeners for navigation buttons
document.getElementById('homeBtn').addEventListener('click', function() {
    loadContent('../../views/contact.php');
});

document.getElementById('newContactBtn').addEventListener('click', function() {
    loadContent('../../views/newContact.php');
});

document.getElementById('addUserBtn').addEventListener('click', function() {
    loadContent('../../views/addUser.php');
});

// Load default content
loadContent('../../views/contact.php'); // Load home page content by default
