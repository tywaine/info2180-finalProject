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
            handleFormSubmit(form).then(() => {
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
        }
    });

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

function attachAddUserFormListener() {
    const form = document.querySelector('#userForm');
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await handleFormSubmit(form);
        });
    }
}

async function handleFormSubmit(form) {
    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        const errorMessage = document.getElementById('errorMessageAddUser');

        if (response.ok && result.status === 'success') {
            loadContent('views/viewUsers.php');
        }
        else {
            errorMessage.textContent = result.message;
        }
    } catch (error) {
        console.error('Error submitting form:', error);
    }
}