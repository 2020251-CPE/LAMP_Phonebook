<?php
require_once 'DB_connection.php';

// Fetch contacts from the database
$sql = "SELECT * FROM phonebook;";
$result = mysqli_query($con, $sql);
$contacts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $contacts[] = $row;
}

// Return contacts as JSON
header('Content-Type: application/json');
echo json_encode($contacts);
?>
