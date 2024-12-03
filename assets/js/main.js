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
            e.preventDefault(); // Prevent any default behavior (if any)
            loadContent('views/addUser.php'); // Load the content for adding a new user
        });
    }
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

    async function handleFormSubmit(form) {
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
            });

            const result = await response.text();
            const errorMessage = document.getElementById('errorMessageAddUser');

            if (response.ok) {
                if (result.includes('Successfully Created User')) {
                    loadContent('views/viewUsers.php');
                } else {
                    errorMessage.textContent = 'Failed to create user.';
                }
            } else {
                errorMessage.textContent = 'Error submitting form.';
            }
        } catch (error) {
            console.error('Error submitting form:', error);
        }
    }

    document.body.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.id === 'userForm') {
            e.preventDefault(); // Prevent default form submission
            handleFormSubmit(form).then(() => {
                // Additional logic if needed after form submission
            }).catch(error => {
                console.error('Error handling form submission:', error);
            });
        }
    });

    // Set default content
    loadContent('views/viewUsers.php');
});

