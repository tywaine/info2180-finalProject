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

$contactId = null;

if(isset($_GET['id'])){
    $contactId = $_GET['id'];
    $_SESSION['contactId'] = $contactId;
}
else{
    $contactId = $_SESSION['contactId'];
}

$contact = Contact::getContactById($contactId);
$createdByUser = User::getUserById($contact->getCreatedBy());
$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    if ($contactId && $comment) {
        Note::addNote($contactId, $comment, $_SESSION['user_id']);
        $response['status'] = 'success';
        $response['message'] = 'Note added successfully';
    }
    else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to add note';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
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
            <p class="date-info">Created on <?php echo htmlspecialchars($contact->getCreatedAtFormatted() . ' by ' . $createdByUser->getFirstName() . ' ' . $createdByUser->getLastName()); ?></p>
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
                <p><?php echo htmlspecialchars(User::getUserById($contact->getAssignedTo())->getFirstName() . ' ' . User::getUserById($contact->getAssignedTo())->getLastName()); ?></p>
            </div>
        </div>
    </div>

    <div class="notes-section">
        <h3>Notes</h3><br>
        <div class="notes-list">
            <?php foreach (Note::getNotesByContactId($contactId) as $note): ?>
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
        <form id="noteForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <textarea id="comment" name="comment" placeholder="Enter details here" required></textarea>
            <button type="submit">Add Note</button>
        </form>
    </div>
</div>
</body>
</html>

