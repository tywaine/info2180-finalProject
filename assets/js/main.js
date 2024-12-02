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
