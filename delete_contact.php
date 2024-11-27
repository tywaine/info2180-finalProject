<?php
// Include database connection
include('config/database.php');



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM Contacts WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Contact deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="post">
    Contact ID: <input type="number" name="id"><br>
    <input type="submit" value="Delete Contact">
</form>
