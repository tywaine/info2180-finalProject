<?php
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
            User::loadUsers();
            header('Location: dashboard.php');
            exit;
        }
        else {
            echo "Invalid credentials.";
        }
    }
}

?>

<!--Fix this up for me Maurice -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dolphin CRM</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <?php include_once '../includes/header.php'; ?>
    </header>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <h2>Login</h2>
        <label for="email"></label><br>
        <input id="email" type="email" name="email" placeholder="Email address"><br>
        <label for="password"></label><br>
        <input id="password" type="password" name="password" placeholder="Password"><br><br>
        <input type="submit" name="login" value="Login"><br>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </form>

    <?php include_once '../includes/footer.php'; ?>
    <script src="../assets/js/main.js"></script>
</body>

</html>

<?php

?>
