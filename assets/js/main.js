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
        e.preventDefault();

        if (form.id === 'userForm') {
            handleFormSubmit(form, 'addUser').then(() => {
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
        }
        if (form.id === 'contactForm') {
            handleFormSubmit(form, 'addContact').then(() => {
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
        }
        if (form.id === 'noteForm') {
            handleFormSubmit(form, 'addNote').then(() => {
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
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
                attachAddNoteFormListener()
                attachContactNotesButtonListeners()
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

function attachContactNotesButtonListeners() {
    const assignToMeButton = document.getElementById('btnAssignToMe');
    const switchTypeButton = document.getElementById('btnSwitchType');

    if (assignToMeButton) {
        assignToMeButton.addEventListener('click', function(e) {
            e.preventDefault();
            sendAction('assignToMe');
        });
    }

    if (switchTypeButton) {
        switchTypeButton.addEventListener('click', () => {
            sendAction('switchType');
        });
    }

    function sendAction(action) {
        fetch('views/contactNotes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action: action }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    //location.reload();
                    loadContent('views/contactNotes.php'); // Reload the notes view
                }
                else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred');
            });
    }
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

function attachAddNoteFormListener(){
    const form = document.querySelector('#noteForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleFormSubmit(form, 'addNote');
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

        if (response.ok && result.status === 'success') {
            $('#temporaryMessage')
                .removeClass('error')
                .addClass('success')
                .text(result.message)
                .fadeIn()
                .delay(400)
                .fadeOut();

            if(pageName === 'addNote'){
                loadContent('views/contactNotes.php')
                return;
            }

            await sleep(900)

            loadContent((pageName === 'addUser') ? 'views/viewUsers.php' : 'views/home.php');
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

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}