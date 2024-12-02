<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List</title>
</head>
<body>
    <h1>Contact List</h1>
    <a href="new.php">Add New Contact</a>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once('../../models/contact.php');
            use app\models\Contact;

            $contacts = Contact::getContacts();

            foreach ($contacts as $contact) {
                echo "<tr>";
                echo "<td>" . $contact->title . "</td>";
                echo "<td>" . $contact->firstname . " " . $contact->lastname . "</td>";
                echo "<td>" . $contact->email . "</td>";
                echo "<td>";
                echo "<a href='view.php?id=" . $contact->id . "'>View</a> | ";
                echo "<a href='edit.php?id=" . $contact->id . "'>Edit</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
