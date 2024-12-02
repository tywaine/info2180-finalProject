<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Contact</title>
</head>
<body>
    <h1>Create a New Contact</h1>
    <form method="post" action="../../controllers/contactController.php?action=create">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required><br>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone"><br>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company"><br>

        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="Sales Lead">Sales Lead</option>
            <option value="Support">Support</option>
        </select><br>

        <label for="assigned_to">Assigned To:</label>
        <input type="number" id="assigned_to" name="assigned_to" required><br>

        <label for="created_by">Created By:</label>
        <input type="number" id="created_by" name="created_by" value="1"><!-- Replace '1' with the logged-in user's ID if applicable -->
        <br>

        <button type="submit">Save</button>
    </form>
</body>
</html>
