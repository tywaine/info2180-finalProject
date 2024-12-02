<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>

    <?php
    require_once('../../models/contact.php');
    use app\models\Contact;

    
    $contact = Contact::getContactById($contactId);

    ?>

    <form method="post" action="../../controllers/contactController.php?action=edit">
        <input type="hidden" name="id" value="<?php echo $mockContact->getId(); ?>">
        
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $mockContact->getTitle(); ?>" required><br>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo $mockContact->getFirstName(); ?>" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo $mockContact->getLastName(); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $mockContact->getEmail(); ?>" required><br>

        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo $mockContact->getTelephone(); ?>"><br>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company" value="<?php echo $mockContact->getCompany(); ?>"><br>

        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="Sales Lead" <?php echo $mockContact->getType() === 'Sales Lead' ? 'selected' : ''; ?>>Sales Lead</option>
            <option value="Support" <?php echo $mockContact->getType() === 'Support' ? 'selected' : ''; ?>>Support</option>
        </select><br>

        <label for="assigned_to">Assigned To:</label>
        <input type="number" id="assigned_to" name="assigned_to" value="<?php echo $mockContact->getAssignedTo(); ?>"><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
