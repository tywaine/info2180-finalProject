<?php
// Include database connection
include('config/database.php');



// If the form is submitted, insert the contact into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $company = $_POST['company'];
    $type = $_POST['type'];
    $assigned_to = $_POST['assigned_to'];
    $created_by = $_POST['created_by'];

    $sql = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by)
            VALUES ('$title', '$firstname', '$lastname', '$email', '$telephone', '$company', '$type', $assigned_to, $created_by)";

    if ($conn->query($sql) === TRUE) {
        echo "New contact added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<form method="post">
    Title: <input type="text" name="title"><br>
    First Name: <input type="text" name="firstname"><br>
    Last Name: <input type="text" name="lastname"><br>
    Email: <input type="email" name="email"><br>
    Telephone: <input type="text" name="telephone"><br>
    Company: <input type="text" name="company"><br>
    Type: <input type="text" name="type"><br>
    Assigned To: <input type="number" name="assigned_to"><br>
    Created By: <input type="number" name="created_by"><br>
    <input type="submit" value="Add Contact">
</form>
