<?php
// Include the database connection file
include 'DB_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];

    // Update the contact details in the database
    $query = "UPDATE phonebook SET 
        name = '$name', 
        middleName='$mname', 
        lastName='$lname', 
        number = '$number', 
        email = '$email', 
        address = '$address', 
        notes = '$notes'
            WHERE id = '$id'";
    $result = mysqli_query($con, $query);

    if ($result) {
        // Update successful
        header("Location: phonebook.php");
        
        exit();
    } else {
        // Update failed
        echo "Error updating contact: " . mysqli_error($con);
    }
} else {
    // Form not submitted
    echo "Form not submitted.";
}

// Close the database connection
mysqli_close($con);
?>
