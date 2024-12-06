<?php
// Database connection settings (Change this to match your credentials
$db_server = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "dolphin_crm";

try {
    // Establish connection
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    // Check if connection is successful
    if (!$conn) {
        // Output the error message if connection fails
        throw new mysqli_sql_exception("Connection failed: " . mysqli_connect_error());
    }

    // Connection was successful, you can use $conn to query the database
    // You can close the connection here if necessary, but it's not required for a simple script
    // mysqli_close($conn);

} catch (mysqli_sql_exception $ex) {
    // Display detailed error message
    echo "Could not connect to the database. Error: " . $ex->getMessage();
}