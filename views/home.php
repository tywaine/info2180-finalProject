<?php
include("../config/database.php");
include_once '../models/contact.php';
use app\models\Contact;
Contact::setConnection($conn);
Contact::loadContacts();
$contacts = Contact::getContacts();
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width= device width, initial-scale= 1.0 ">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" />
</head>
<body>
<section id="viewUsers" class="sect">
    <div class="tableSection">

        <div class="tableHeading">
            <h1>Dashboard</h1>

            <button class="addbtn" id="addContactButton">
                <span class="material-symbols-outlined">add</span> Add Contact
            </button>
        </div>

        <div class=" tableincontainer">
            <div class="filter-section">
                <span class="name">Filter By:</span>
                <button id="btnAllFilter" class="filter-btn" data-filter="all">All</button>
                <button class="filter-btn" data-filter="sales lead">Sales Leads</button>
                <button class="filter-btn" data-filter="support">Support</button>
                <button class="filter-btn" data-filter="assigned-to-me">Assigned to me</button>
            </div>
            <table class="user-table" >
                <thead class="th">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th> Type</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($contacts)): ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr
                            data-type="<?php echo htmlspecialchars(strtolower($contact->getType())); ?>"
                            data-assigned-to="<?php echo htmlspecialchars($contact->getAssignedTo()); ?>"
                        >
                        <td class="name"><?php echo htmlspecialchars($contact->getTitle()) . '. ' . htmlspecialchars($contact->getFirstName()) . ' ' . htmlspecialchars($contact->getLastName()); ?></td>
                            <td><?php echo htmlspecialchars($contact->getEmail()); ?></td>
                            <td><?php echo htmlspecialchars($contact->getCompany()); ?></td>
                            <td class="contactType">
                                <?php if (strtolower($contact->getType()) === 'support'): ?>
                                    <span class="support-btn">SUPPORT</span>
                                <?php else: ?>
                                    <span class="sales-lead-btn">SALES LEAD</span>
                                <?php endif; ?>
                            </td>
                            <td><a class="view-link" data-target="views/contactNotes.php?id=<?php echo htmlspecialchars($contact->getId()); ?>">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class= "name"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
</body>
</html>

