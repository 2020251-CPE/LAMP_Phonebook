<?php
session_start();
require_once 'DB_connection.php';
try{
// Fetch contacts from the database
$sql = "SELECT phonebook.id, phonebook.name, phonebook.middleName, phonebook.lastName, 
	phonebook.number, phonebook.email, phonebook.address, 
	phonebook.notes, accounts.userEmail
FROM phonebook
INNER JOIN accounts ON phonebook.ownerID=accounts.id
WHERE accounts.userEmail = '".$_SESSION["user"]."';
";
$result = mysqli_query($con, $sql);
$contacts = array();
while ($row = mysqli_fetch_assoc($result)) {
    $contacts[] = $row;
}

// Return contacts as JSON
header('Content-Type: application/json');
echo json_encode($contacts);
}catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
?>
