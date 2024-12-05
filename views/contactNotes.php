<?php
session_start();
include_once '../config/database.php';
include_once '../models/contact.php';
include_once '../models/user.php';
include_once '../models/note.php';

use app\models\Contact;
use app\models\User;
use app\models\Note;

Contact::setConnection($conn);
User::setConnection($conn);
Note::setConnection($conn);
User::loadUsers();
Contact::loadContacts();

$contacts = null;

if(isset($_GET['id'])){
    $contactId = $_GET['id'];
    $_SESSION['contactId'] = $contactId;
}
else{
    $contactId = $_SESSION['contactId'];
}

$contact = Contact::getContactById($contactId);
$notes = Note::getNotesByContactId($contactId);
$assignedToUser = User::getUserById($contact->getAssignedTo());

$response = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['comment'])) {
        $comment = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($contactId && $comment) {
            Note::addNote($contactId, $comment, $_SESSION['user_id']);
            // Return success response as JSON
            echo json_encode(['status' => 'success', 'message' => 'Note added successfully']);
        } else {
            // Return failure response as JSON
            echo json_encode(['status' => 'error', 'message' => 'Failed to add note']);
        }
    }

    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Notes</title>
    <link rel="stylesheet" href="assets/css/contactNotes.css">
</head>
<body>
<div class="main-contact">
    <div class="note-header">
        <div class="header-info">
            <h1><?php echo htmlspecialchars($contact->getTitle() . '. ' . $contact->getFirstName() . ' ' . $contact->getLastName()); ?></h1>
            <p class="date-info">Created on <?php echo htmlspecialchars($contact->getCreatedAtFormatted() . ' by ' . User::getUserById($contact->getCreatedBy())->getFirstName() . ' ' . User::getUserById($contact->getCreatedBy())->getLastName()); ?></p>
            <p class="date-info">Updated on <?php echo htmlspecialchars($contact->getUpdatedAtFormatted()); ?></p>
        </div>
        <div class="header-buttons">
            <button class="add-btn" id="btnAssignToMe">
                Assign to me
            </button>
            <button class="add-btn" id="btnSwitchType">
                Switch to <?php echo $contact->getTypeOpposite() ?>
            </button>
        </div>
    </div>

    <div class="contact-info">
        <div class="info-row">
            <div class="info-item">
                <strong>Email</strong>
                <p><?php echo htmlspecialchars($contact->getEmail()); ?></p>
            </div>
            <div class="info-item">
                <strong>Telephone</strong>
                <p><?php echo htmlspecialchars($contact->getTelephone()); ?></p>
            </div>
        </div>
        <div class="info-row">
            <div class="info-item">
                <strong>Company</strong>
                <p><?php echo htmlspecialchars($contact->getCompany()); ?></p>
            </div>
            <div class="info-item">
                <strong>Assigned To</strong>
                <p><?php echo htmlspecialchars($assignedToUser->getFirstName() . ' ' . $assignedToUser->getLastName()); ?></p>
            </div>
        </div>
    </div>

    <div class="notes-section">
        <h3>Notes</h3>
        <div class="notes-list">
            <?php foreach ($notes as $note): ?>
                <div class="note">
                    <p><strong><?php echo htmlspecialchars(User::getUserById($note->getCreatedBy())->getFirstName() . ' ' . User::getUserById($note->getCreatedBy())->getLastName()); ?></strong></p>
                    <p><?php echo nl2br(htmlspecialchars($note->getComment())); ?></p>
                    <p class="note-date"><?php echo htmlspecialchars($note->getCreatedAtFormatted()); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="add-note">
        <h3>Add a note about <?php echo htmlspecialchars($contact->getFirstName()); ?></h3>
        <form id="addNoteForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <textarea name="comment" placeholder="Enter details here" required></textarea>
            <button type="submit">Add Note</button>
        </form>
        <div id="responseMessage"></div>
    </div>

</div>
</body>
</html>

