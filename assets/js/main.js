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

    document.body.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.id === 'userForm') {
            e.preventDefault();
            handleFormSubmit(form, 'addUser').then(() => {
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
        }
        if (form.id === 'contactForm') {
            e.preventDefault();
            handleFormSubmit(form, 'addContact').then(() => {
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
        }

        if (form.id === 'noteForm') {
            e.preventDefault();
            handleNoteSubmit(form);
        }
    });

    // If you want to experiment how you view looks on the main page, Change this.
    loadContent('views/home.php');
});

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

            if(url === 'views/viewUsers.php'){
                attachAddUserButtonListener();
            }

            if(url === 'views/addUser.php'){
                attachAddUserFormListener()
            }

            if(url === 'views/addContact.php'){
                attachAddContactFormListener()
            }

            if(url === 'views/home.php'){
                attachAddContactButtonListener()
                attachFilterButtonListener()
            }

            if(url === 'views/contactNotes.php'){
                attachNoteSubmitFormListener()
            }

        })
        .catch(error => {
            console.error('Error loading content:', error);
            mainContent.innerHTML = 'There was an error loading the content.';
        });
}


// Function to attach event listener for Add User button
function attachAddUserButtonListener() {
    const addUserButton = document.getElementById('addUserButton');

    if (addUserButton) {
        addUserButton.addEventListener('click', function (e) {
            e.preventDefault();
            loadContent('views/addUser.php');
        });
    }
}

function attachAddContactButtonListener() {
    const addContactButton = document.getElementById('addContactButton');

    if (addContactButton) {
        addContactButton.addEventListener('click', function (e) {
            e.preventDefault();
            loadContent('views/newContact.php');
        });
    }

    const viewLinks = document.querySelectorAll('.view-link');

    viewLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const target = this.getAttribute('data-target');
            loadContent(target);
        });
    });

}

function attachAddUserFormListener() {
    const form = document.querySelector('#userForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleFormSubmit(form, 'addUser');
        });
    }
}

function attachAddContactFormListener() {
    const form = document.querySelector('#contactForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleFormSubmit(form, 'addContact');
        });
    }
}

function attachNoteSubmitFormListener(){
    const form = document.querySelector('#addNoteForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleNoteSubmit(form);
        });
    }
}


async function handleFormSubmit(form, pageName) {
    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if(pageName === 'addUser'){

            if (response.ok && result.status === 'success') {
                $('#temporaryMessage')
                    .removeClass('error')
                    .addClass('success')
                    .text(result.message)
                    .fadeIn()
                    .delay(400)
                    .fadeOut();

                await sleep(900)
                loadContent('views/viewUsers.php');
            }
            else {
                $('#temporaryMessage')
                    .removeClass('success')
                    .addClass('error')
                    .text(result.message)
                    .fadeIn()
                    .delay(1500)
                    .fadeOut();
            }
        }
        else{
            if (response.ok && result.status === 'success') {
                $('#temporaryMessage')
                    .removeClass('error')
                    .addClass('success')
                    .text(result.message)
                    .fadeIn()
                    .delay(400)
                    .fadeOut();

                await sleep(900)
                loadContent('views/home.php');
            }
            else {
                $('#temporaryMessage')
                    .removeClass('success')
                    .addClass('error')
                    .text(result.message)
                    .fadeIn()
                    .delay(1500)
                    .fadeOut();
            }
        }
    } catch (error) {
        console.error('Error submitting form:', error);
    }
}

function attachFilterButtonListener() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const loggedInUserId = window.loggedInUserId;
    const rows = document.querySelectorAll('.user-table tbody tr');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const filter = this.getAttribute('data-filter');

            rows.forEach(row => {
                const type = row.getAttribute('data-type');
                const assignedTo = row.getAttribute('data-assigned-to');

                if (filter === 'all' || type === filter ||
                    (filter === 'assigned-to-me' && assignedTo === String(loggedInUserId))) {
                    row.style.display = ''; // Show row
                }
                else {
                    row.style.display = 'none'; // Hide row
                }
            });
        });
    });
}

function handleNoteSubmit(form) {
    // Serialize form data using jQuery
    const formData = $(form).serialize();

    // Send AJAX request
    $.ajax({
        url: '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', // The PHP file handling the form
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#responseMessage').html('<p style="color: green;">' + response.message + '</p>');

                loadContent('views/contactNotes.php');
            } else {
                $('#responseMessage').html('<p style="color: red;">' + response.message + '</p>');
            }
        },
        error: function() {
            $('#responseMessage').html('<p style="color: red;">There was an error processing your request.</p>');
        }
    });
}


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}