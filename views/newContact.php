<?php
session_start();
include_once '../config/database.php';
include_once '../models/contact.php';
include_once '../models/user.php';
use app\models\Contact;
use app\models\User;

Contact::setConnection($conn);
User::setConnection($conn);
User::loadUsers();
$users = User::getUsers();

$response = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $telephone = filter_input(INPUT_POST, "telephone", FILTER_SANITIZE_SPECIAL_CHARS);
    $company = filter_input(INPUT_POST, "company", FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_SPECIAL_CHARS);
    $assignedTo = filter_input(INPUT_POST, "assignedTo", FILTER_SANITIZE_NUMBER_INT);

    $emailDoesntExist = !Contact::emailExist($email);
    $telephoneDoesntExist = !Contact::telephoneExist($telephone);
    $validTelephone = Contact::isValidTelephone($telephone);

    if ($title && $firstName && $lastName && $email && $telephone && $company && $type && $assignedTo) {
        if($emailDoesntExist && $validTelephone && $telephoneDoesntExist){
            Contact::addContact($title, $firstName, $lastName, $email, $telephone, $company, $type, $assignedTo, $_SESSION['user_id']);
            $response['status'] = 'success';
            $response['message'] = 'Successfully Created Contact';
        }
        else if(!$validTelephone){
            $response['status'] = 'error';
            $response['message'] = 'Incorrect telephone format (###-#### or ###-###-####)';
        }
        else if(!$telephoneDoesntExist){
            $response['status'] = 'error';
            $response['message'] = 'Telephone already exists';
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Email already exists';
        }
    }
    else {
        $response['status'] = 'error';
        $response['message'] = 'Unknown Error occurred.';
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
    <link rel="stylesheet" href="assets/css/addContact.css">
</head>
<body>
<div class="main-add">
    <div class="right-add">
        <br><br>
        <h1>New Contact</h1><br>
        <div class="login-add">

            <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                <!-- Title -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <select id="title" name="title" required>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                        <option value="Dr">Dr</option>
                        <option value="Prof">Prof</option>
                    </select>
                </div>

                <!-- First Column: First and Last Name -->
                <div class="info-add">
                    <div class="user-content-add">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>
                    </div>
                    <div class="user-content-add">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                    </div>
                </div>

                <!-- Second Column: Email and Telephone -->
                <div class="info-add">
                    <div class="user-content-add">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="user-content-add">
                        <label for="telephone">Telephone</label>
                        <input type="text" id="telephone" name="telephone" placeholder="Enter Telephone" required>
                    </div>
                </div>

                <!-- Third Column: Company and Type -->
                <div class="info-add">
                    <div class="user-content-add">
                        <label for="company">Company</label>
                        <input type="text" id="company" name="company" placeholder="Enter Company Name" required>
                    </div>
                    <div class="user-content-add">
                        <label for="type">Type</label>
                        <select id="type" name="type" required>
                            <option value="Sales Lead">Sales Lead</option>
                            <option value="Support">Support</option>
                        </select>
                    </div>
                </div>

                <!-- Assigned To -->
                <div class="info-add assigned-row">
                    <div class="user-content-add">
                        <label for="assignedTo">Assigned To</label>
                        <select id="assignedTo" name="assignedTo" required>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo htmlspecialchars($user->getId()); ?>">
                                    <?php echo htmlspecialchars($user->getFirstName()) . ' ' . htmlspecialchars($user->getLastName()); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="info-add">
                    <div class="user-content-button-add">
                        <button type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
