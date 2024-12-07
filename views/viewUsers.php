<?php
session_start();
include("../config/database.php");
include_once '../models/user.php';
use app\models\User;
User::setConnection($conn);
User::loadUsers();
$users = User::getUsers();

?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width= device width, initial-scale= 1.0 ">
    <title>View User </title>
    <link rel="stylesheet" href="../assets/css/viewUser.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" />
    <!-- insert icons here -->
</head>
<body>
<section id="viewUsers" class="sect">

    <div class="tableSection">

        <div class="tableHeading">
            <h1>Users</h1>
            <button class="addbtn" id="addUserButton">
                <span class="material-symbols-outlined">add</span> Add User
            </button>
        </div>

        <div class=" tableincontainer">
            <table class="user-table" >
                <thead class="th">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="name"><?php echo htmlspecialchars($user->getFirstName()) . ' ' . htmlspecialchars($user->getLastName()); ?></td>
                            <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($user->getRole()); ?></td>
                            <td><?php echo htmlspecialchars($user->getCreatedAt()); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr >
                        <td class= "name"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
</body>
</html>
