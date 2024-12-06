<?php
namespace app\models;

class Contact {
    private static $conn;
    private int $id;
    private string $title;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $telephone;
    private string $company;
    private string $type;
    private int $assigned_to;
    private int $created_by;
    private string $created_at;
    private string $updated_at;
    private static array $contacts = [];

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

    public function setType($type):void{
        $this->type = $type;
    }

    public function getAssignedTo() {
        return $this->assigned_to;
    }

    public function setAssignedTo($assigned_to):void{
        $this->assigned_to = $assigned_to;
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

    public function getTypeOpposite(): string{
        if(strtolower($this->getType()) == "support"){
            return "Sales Lead";
        }
        else{
            return "Support";
        }
    }

    public function getCreatedAtFormatted():string {
        $timestamp = strtotime($this->getCreatedAt());
        return date('F j, Y', $timestamp);
    }


    public function getUpdatedAtFormatted():string {
        $timestamp = strtotime($this->getUpdatedAt());
        return date('F j, Y', $timestamp);
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

    private static function clearContacts() {
        self::$contacts = [];
    }

    public static function loadContacts() {
        $query = "SELECT * FROM Contacts";
        $result = mysqli_query(self::$conn, $query);
        self::clearContacts();

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

    public function update($type, $assigned_to): bool{
        $this->setType($type);
        $this->setAssignedTo($assigned_to);
        $id = $this->getId();

        $query = "UPDATE Contacts SET type = ?, assigned_to = ?, updated_at = NOW() WHERE id = ?";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $type, $assigned_to, $id);

        return mysqli_stmt_execute($stmt);
    }

    public static function updateContact($id, $type, $assigned_to): bool{
        if(self::contactExists($id)){
            $contact = self::getContactById($id);
            $contact->setType($type);
            $contact->setAssignedTo($assigned_to);
        }

        $query = "UPDATE Contacts SET type = ?, assigned_to = ?, updated_at = NOW() WHERE id = ?";
        $stmt = mysqli_prepare(self::$conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $type, $assigned_to, $id);

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
