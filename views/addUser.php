<?php
session_start();
include_once '../config/database.php';
include_once '../models/user.php';
use app\models\User;

User::setConnection($conn);

$error_message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = [];
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

    if($firstName && $lastName && $email && $role && $password){
        if (User::validatePassword($password)) {
            User::addUser($firstName, $lastName, $email, $role, $password);
            $response['status'] = 'success';
            $response['message'] = 'Successfully Created User';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid Password (At least one number, one letter, one capital letter, and at least 8 characters long)';
        }

        // Return JSON response if it's an AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode($response);
            exit;
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
    <link rel="stylesheet" href="assets/css/addUser.css">
</head>
<body>
<div class="main-add">
        <div class="right-add">
            <div class="login-add">
                <h1>New User</h1>
                <form id="userForm" class="user-form-add" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <div class="info-add">
                        <div class="user-content-add">
                            <label for="firstName">First name</label>
                            <input type="text" id="firstName" name="firstName" placeholder="Enter First Name" required>
                        </div>
                        <div class="user-content-add">
                            <label for="lastName">Last name</label>
                            <input type="text" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                        </div>
                    </div>

                    <div class="info-add">
                        <div class="user-content-add">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter Email" required>
                        </div>
                        <div class="user-content-add">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                    </div>
                    <div class="info-add">
                        <div class="user-content-add">
                            <label for="role">Role</label>
                            <select id="role" name="role">
                                <option value="Member">Member</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="info-add">
                        <div class="user-content-button-add">
                            <button type="submit">Save</button>
                        </div>
                        <?php if ($error_message): ?>
                            <div id="errorMessageAddUser" class="error-message"><?php echo $error_message; ?></div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
