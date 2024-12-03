<?php
include_once('../../config/database.php');
require_once('../../models/contact.php');
use app\models\Contact;

// Mock data for now (replace with real data when database is connected) // Replace with the actual contact ID from the request
$mockContact = new Contact(1, 'Dr.', 'Jelena', 'Smith', 'jelenaannalise@gmail.com', '8765959883', 'FSC', 'Sales Lead', 2, 1, '2024-12-02 14:00:00', '2024-12-02 14:00:00');
$notes
// Replace $mockContact with actual loaded contact when database is connected:
// $contact = Contact::getContactById($contactId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
</head>
<body>
    <h1>Contact Details</h1>
    <p><strong>Title:</strong> <?php echo $mockContact->getTitle(); ?></p>
    <p><strong>Full Name:</strong> <?php echo $mockContact->getFirstName() . ' ' . $mockContact->getLastName(); ?></p>
    <p><strong>Email:</strong> <?php echo $mockContact->getEmail(); ?></p>
    <p><strong>Telephone:</strong> <?php echo $mockContact->getTelephone(); ?></p>
    <p><strong>Company:</strong> <?php echo $mockContact->getCompany(); ?></p>
    <p><strong>Type:</strong> <?php echo $mockContact->getType(); ?></p>
    <p><strong>Assigned To:</strong> <?php echo $mockContact->getAssignedTo(); ?></p>
    <p><strong>Created By:</strong> <?php echo $mockContact->getCreatedBy(); ?></p>
    <p><strong>Created At:</strong> <?php echo $mockContact->getCreatedAt(); ?></p>
    <p><strong>Updated At:</strong> <?php echo $mockContact->getUpdatedAt(); ?></p>

    <h2>Notes</h2>
<ul>
    <strong></strong>
    <?php echo htmlspecialchars($note['note']); ?>
    <em>(<?php echo $note['created_at']; ?>)</em>
</ul>

<h3>Add Note</h3>
<form method="post" action="../../controllers/contactController.php?action=addNote">
    <textarea name="note" rows="4" cols="50" placeholder="Write your note here..." required></textarea><br>
    <input type="hidden" name="contact_id" value="<?php echo $contact->getId(); ?>">
    <input type="text" name="author" placeholder="Your Name" required><br>
    <button type="submit">Add Note</button>
</form>

    <a href="/views/contacts/list.php">Back to Contacts</a>
</body>
</html>
