<?php
session_start();
include_once 'config/database.php';

if (isset($_SESSION['user_id'])) {
    header("Location: views/dashboard.php");
}
else{
    header("Location: views/login.php");
}

exit();