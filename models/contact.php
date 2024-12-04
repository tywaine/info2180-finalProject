<?php
namespace app\models;

class Contact {
    private static $conn;
    private $id;
    private $title;
    private $firstname;
    private $lastname;
    private $email;
    private $telephone;
    private $company;
    private $type;
    private $assigned_to;
    private $created_by;
    private $created_at;
    private $updated_at;
    private static $contacts = [];

    public function __construct($id, $title, $firstname, $lastname, $email, $telephone,  $company, $type, $assigned_to, $created_by, $created_at, $updated_at) {
        $this->id = $id;
        $this->title = $title;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->company = $company;
        $this->type = $type;
        $this->assigned_to = $assigned_to;
        $this->created_by = $created_by;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        if (!self::contactExists($id)) {
            self::$contacts[$id] = $this;
        }
    }

    public static function setConnection($conn) {
        self::$conn = $conn;
    }

    public static function contactExists($id): bool{
        return isset(self::$contacts[$id]);
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getType() {
        return $this->type;
    }

    public function getAssignedTo() {
        return $this->assigned_to;
    }

    public function getCreatedBy() {
        return $this->created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public static function isValidTelephone($telephone): bool {
        return preg_match('/^\d{3}-\d{4}$|^\d{3}-\d{3}-\d{4}$/', $telephone);
    }

    public static function getContacts(): array
    {
        return self::$contacts;
    }

    public static function getContactById($id) {
        if (isset(self::$contacts[$id])) {
            return self::$contacts[$id];
        }

        return null;
    }

    public static function loadContacts() {
        $query = "SELECT * FROM Contacts";
        $result = mysqli_query(self::$conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $fetchedContacts = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($fetchedContacts as $contact) {
                self::$contacts[$contact['id']] = new Contact(
                    $contact['id'],
                    $contact['title'],
                    $contact['firstname'],
                    $contact['lastname'],
                    $contact['email'],
                    $contact['telephone'],
                    $contact['company'],
                    $contact['type'],
                    $contact['assigned_to'],
                    $contact['created_by'],
                    $contact['created_at'],
                    $contact['updated_at']
                );
            }
        }
    }

    public static function addContact($title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by): bool{
        $query = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = mysqli_prepare(self::$conn, $query);
        if (!$stmt) {
            echo "Failed to prepare statement: " . mysqli_error(self::$conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, 'sssssssii', $title, $firstname, $lastname, $email, $telephone, $company, $type, $assigned_to, $created_by);

        return mysqli_stmt_execute($stmt);
    }

    public static function updateContact($id, $type, $assigned_to): bool{
        $query = "UPDATE Contacts SET type = ?, assigned_to = ?, updated_at = NOW() WHERE id = ?";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $type, $assigned_to, $id);

        return mysqli_stmt_execute($stmt);
    }

    // NEW METHODS FOR NOTES FUNCTIONALITY

    public static function getNotesByContactId($contact_id): array{
        $query = "SELECT * FROM Notes WHERE contact_id = ?";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $contact_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $notes = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $notes[] = [
                'id' => $row['id'],
                'author' => $row['author'],
                'note' => $row['note'],
                'created_at' => $row['created_at']
            ];
        }

        return $notes;
    }

    public static function addNoteToContact($contact_id, $author, $note): bool{
        $query = "INSERT INTO Notes (contact_id, author, note, created_at)
                  VALUES (?, ?, ?, NOW())";

        $stmt = mysqli_prepare(self::$conn, $query);
        if (!$stmt) {
            echo "Failed to prepare statement: " . mysqli_error(self::$conn);
            return false;
        }

        mysqli_stmt_bind_param($stmt, 'iss', $contact_id, $author, $note);

        return mysqli_stmt_execute($stmt);
    }

    public static function emailExist($email): bool{
        $query = "SELECT * FROM Contacts WHERE email = ?";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return true;
        }

        return false;
    }

    public static function telephoneExist($telephone): bool{
        $query = "SELECT * FROM Contacts WHERE telephone = ?";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $telephone);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            return true;
        }

        return false;
    }

}
