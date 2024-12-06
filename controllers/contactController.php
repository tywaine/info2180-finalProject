<?php
session_start();
include_once '../config/database.php';
include_once '../models/contact.php';

use app\models\Contact;

Contact::setConnection($conn);
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

$response = [];

if(isset($_GET["action"])){
    $action = $_GET["action"];

    if ($action === 'assignToMe') {
        $userId = $_SESSION['user_id'];

        if ($contactId && $userId && $contact) {
            if($contact->getAssignedTo() == $userId){
                $response['status'] = 'error';
                $response['message'] = 'Contact is already assigned to you';
            }
            else if ($contact->update($contact->getType(), $userId)) {
                $response['status'] = 'success';
                $response['message'] = 'Contact successfully assigned to you';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to assign contact';
            }
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Unknown assignToMe error';
        }
    }
    elseif ($action === 'switchType') {
        if ($contactId) {
            $newType = $contact->getTypeOpposite();
            $success = $contact->update($newType, $contact->getAssignedTo());
            if ($success) {
                $response['status'] = 'success';
                $response['message'] = 'Contact type switched to ' . $newType;
            }
            else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to switch contact type';
            }
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Unknown switchType error';
        }
    }
    else{
        $response['status'] = 'error';
        $response['message'] = 'Invalid action';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
