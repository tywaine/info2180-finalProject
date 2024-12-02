<?php
require_once('../models/contact.php');
use app\models\Contact;

// Include database configuration
require_once('../config/database.php');

// Establish database connection
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);

// Check if the connection failed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pass the database connection to the Contact model
Contact::setConnection($conn);

// Handle actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'create':
            createContact();
            break;
        case 'edit':
            editContact();
            break;
        case 'view':
            viewContact();
            break;
        case 'addNote':
            addNote();
            break;
        default:
            echo "Invalid action.";
    }
}

function createContact() {
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

        if (Contact::addContact($title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by)) {
            echo "Contact created successfully.";
            header("Location: /views/contacts/list.php");
            exit;
        } else {
            echo "Failed to create contact.";
        }
    }
}

function editContact() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $company = $_POST['company'];
        $type = $_POST['type'];
        $assigned_to = $_POST['assigned_to'];
        $updated_at = date('Y-m-d H:i:s');

        if (Contact::updateContact($id, $type, $assigned_to, $updated_at)) {
            echo "Contact updated successfully.";
            header("Location: /views/contacts/view.php?id=$id");
            exit;
        } else {
            echo "Failed to update contact.";
        }
    }
}

function viewContact() {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo "Contact ID is required.";
        exit;
    }

    $contact = Contact::getContactById($id);
    $notes = Contact::getNotesByContactId($id);

    include('../views/contacts/view.php');
}

function addNote() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contact_id = $_POST['contact_id'];
        $note = $_POST['note'];
        $author = $_POST['author'];

        if (empty($note)) {
            echo "Note cannot be empty.";
            exit;
        }

        if (Contact::addNoteToContact($contact_id, $author, $note)) {
            echo "Note added successfully.";
            header("Location: /views/contacts/view.php?id=$contact_id");
            exit;
        } else {
            echo "Failed to add note.";
        }
    }
}
?>
