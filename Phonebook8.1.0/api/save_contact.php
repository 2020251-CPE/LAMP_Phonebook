<?php
session_start();
require_once 'DB_connection.php';
try{
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name =  $_POST['name'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO phonebook (name, middleName, lastName,  number, email, address, notes, ownerID) 
            VALUES ('$name', '$mname', '$lname','$number', '$email', '$address', '$notes',
            (SELECT id FROM accounts WHERE userEmail = '".$_SESSION["user"]."'));";
    if (mysqli_query($con, $sql)) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'error' => mysqli_error($con));
    }
    echo json_encode($response);
} else {
    echo 'Invalid request';
}
    
}catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
?>