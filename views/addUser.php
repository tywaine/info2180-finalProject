<?php
session_start();
include_once '../config/database.php';
include_once '../models/user.php';
use app\models\User;

User::setConnection($conn);

$response = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

    $isPasswordValid = User::validatePassword($password);
    $emailDoesntExist = !User::emailExist($email);

    if ($firstName && $lastName && $email && $role && $password) {
        if($isPasswordValid && $emailDoesntExist){
            User::addUser($firstName, $lastName, $email, $role, $password);
            $response['status'] = 'success';
            $response['message'] = 'Successfully Created User';
        }
        else if(!$isPasswordValid) {
            $response['status'] = 'error';
            $response['message'] = 'Invalid Password (At least one number, one letter, one capital letter, and at least 8 characters long)';
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Email already exists';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
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
    <link rel="stylesheet" href="assets/css/addUser.css">
</head>
<body>
    <div class="main-add">
        <div class="right-add">
            <br><br>
            <h1>New User</h1>
            <div class="login-add">

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
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
