<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
    <link rel="stylesheet" href="../assets/css/addUser.css">
</head>
<body>
<div class="main-add">
    <div class="top-add">
        <img src="../assets/images/dolphin.jpg" alt="">
        <p>Dolphin CRM</p>
    </div>

    <div class="content-add">
        <div class="left-add">

            <a href="../index.php">
                <img src="../assets/images/home.png" alt="">
                Home
            </a>
            <a href="">
                <img src="../assets/images/contact.jpeg" alt="">
                New Contact
            </a>
            <a href="">
                <img src="../assets/images/users.jpg" alt="">
                Users
            </a>
            <a href="">
                <img src="../assets/images/logout.png" alt="">
                Logout
            </a>
        </div>

        <div class="right-add">
            <div class="login-add">
                <h1>New User</h1>
                <form class="user-form-add">

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
                            <input type="email" id="email" name="username" placeholder="Enter Email" required>
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
</div>

</body>
</html>
