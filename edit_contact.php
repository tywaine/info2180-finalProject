<?php
// Include database connection
include('config/database.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $company = $_POST['company'];
    $type = $_POST['type'];
    
    $sql = "UPDATE Contacts SET title='$title', firstname='$firstname', lastname='$lastname', email='$email',
            telephone='$telephone', company='$company', type='$type' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Contact updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
    Contact ID: <input type="number" name="id"><br>
    Title: <input type="text" name="title"><br>
    First Name: <input type="text" name="firstname"><br>
    Last Name: <input type="text" name="lastname"><br>
    Email: <input type="email" name="email"><br>
    Telephone: <input type="text" name="telephone"><br>
    Company: <input type="text" name="company"><br>
    Type: <input type="text" name="type"><br>
    <input type="submit" value="Update Contact">
</form>
