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
    <aside class= "sidebar">
        <ul>
            <li > <span class="material-symbols-outlined">
                    home
                    </span>Home</li>
            <li ><span class="material-symbols-outlined">
                    account_circle
                    </span>New Contact</li>
            <li > <span class="material-symbols-outlined">
                    group
                    </span>Users</li>
            <hr>
            <li ><span class="material-symbols-outlined">
                    login
                    </span>Logout</li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="content" id="mainContent">
        <!-- The Main Content is dynamically shown here -->

    </main>
<script src="assets/js/main.js" type="text/javascript"></script>
</body>
</html>
