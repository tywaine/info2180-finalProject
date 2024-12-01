<?php
session_start();
include_once 'config/database.php';
include_once 'models/user.php';
use app\models\User;

if (!isset($_SESSION['user_id'])) {
    header("Location: views/login.php");
    exit();
}
User::setConnection($conn);
User::loadUsers();
include_once 'views/dashboard.php';
