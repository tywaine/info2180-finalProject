<?php
// Email = admin@project2.com
// Password = password123
session_start();
include_once '../config/database.php';
include_once '../models/user.php';
use app\models\User;
User::setConnection($conn);

$error_message = '';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($email) || empty($password)) {
        if (empty($email) && empty($password)) {
            $error_message = "Please enter both email and password.";
        } elseif (empty($password)) {
            $error_message = "Password is required.";
        } else {
            $error_message = "Email is required.";
        }
    }
    else{
        $user = User::isValidCredentials($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['lastname'] = $user->getLastname();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['role'] = $user->getRole();

            session_regenerate_id(true);
            header('Location: ../');
            exit;
        }
        else {
            $error_message = "Invalid credentials";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<div class="main">
    <?php include '../includes/header.php'; ?>

    <div class="login">
        <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <h1>Login</h1>
            <div class="form-content">
                <input type="email" id="email" name="email" placeholder="Email address" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
            </div>
            <div class="form-content">
                <input type="password" id="password" name="password" placeholder="Password" required />
            </div>
            <button type="submit">Login</button>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <p class="text">Copyright &copy; <?php echo date("Y"); ?> Dolphin CRM</p>
        </form>
    </div>
</div>
</body>
</html>


<?php

?>