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
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" />
</head>
<body>
    <header>
        <div class="dolpin">🐬 Dolphin CRM</div>
    </header>
    <aside class="sidebar">
        <ul>
            <!-- Remove the href="#" and just use data-target to load the content dynamically -->
            <li><a href="javascript:void(0)" class="sidebar-link" data-target="home.php"><span class="material-symbols-outlined">home</span>Home</a></li>
            <li><a href="javascript:void(0)" class="sidebar-link" data-target="views/newContact.php"><span class="material-symbols-outlined">account_circle</span>New Contact</a></li>
            <li><a href="javascript:void(0)" class="sidebar-link" data-target="views/viewUsers.php"><span class="material-symbols-outlined">group</span>Users</a></li>
            <hr>
            <li><a href="javascript:void(0)" class="sidebar-link" data-target="views/logout.php"><span class="material-symbols-outlined">login</span>Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content" id="mainContent">
        <!-- The Main Content is dynamically shown here -->
    </main>

<script src="assets/js/main.js" type="text/javascript"></script>
</body>
</html>
