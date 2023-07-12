<?php
    $host = "localhost";  
    $user = "id21021115_angelorecio";  
    $password = 'Angelorecio69!';  
    $db_name = "id21021115_phonebookdb";  
      
    $con = mysqli_connect($host, $user, $password, $db_name);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
?>

