<?php
session_start();
include('config/database.php');
include_once 'models/user.php';
use \app\models\User;

if (!isset($_SESSION['user_id'])) {
    header("Location: views/login.php");
    exit();
}

User::setConnection($conn);
User::loadUsers();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="main-container">
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <a class="nav-link" id="homeBtn">
            <img src="assets/images/home.png" alt="Home" class="nav-icon">
            <span>Home</span>
        </a>
        <a class="nav-link" id="newContactBtn">
            <img src="assets/images/contact.jpeg" alt="New Contact" class="nav-icon">
            <span>New Contact</span>
        </a>
        <a class="nav-link" id="usersBtn">
            <img src="assets/images/users.jpg" alt="Users" class="nav-icon">
            <span>Users</span>
        </a>
        <a href="views/logout.php" class="nav-link">
            <img src="assets/images/logout.png" alt="Logout" class="nav-icon">
            <span>Logout</span>
        </a>
    </nav>

    <!-- Main Content -->
    <main class="content" id="mainContent">
        <!-- The Main Content is dynamically shown here -->

    </main>
</div>
<script src="assets/js/main.js" type="text/javascript"></script>
</body>
</html>
