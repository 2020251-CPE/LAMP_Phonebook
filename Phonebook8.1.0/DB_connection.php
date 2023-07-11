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




<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user["password"])) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION["user"] = $email;
            header("Location: index.php");
            exit();
        } else {
            $errorMessage = "Password does not match";
        }
    } else {
        $errorMessage = "Email does not match";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
      body {
        background-image: linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)), url(https://i.imgur.com/OPYWhOa.jpg);
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: Arial, sans-serif;
        background-attachment: fixed;
      }

      .container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff87;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        margin-top: 100px;
      }

      .container h1 {
        text-align: center;
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
        margin-top: -17px;
      }

      .form-group {
        margin-bottom: 15px;
      }

      .form-group input[type="email"],
      .form-group input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
      }

      .form-group input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .form-group input[type="submit"]:hover {
        background-color: #45a049;
      }

      .register-link {
        text-align: center;
        margin-top: 10px;
      }

      .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 14px;
      }

      .alert.alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <img src="assets/img/team/d.png" class="img-fluid" alt style="width: 200px; padding-left:95px;">
      <h1>Welcome to Jesie's website!</h1>
      <?php
      if (isset($errorMessage)) {
          echo "<div class='alert alert-danger'>$errorMessage</div>";
      }
      ?>
      <form action="login.php" method="post">
        <div class="form-group">
          <input type="email" placeholder="Enter Email:" name="email">
        </div>
        <div class="form-group">
          <input type="password" placeholder="Enter Password:" name="password">
        </div>
        <div class="form-group">
          <input type="submit" value="login" name="login">
        </div>
      </form>
      <div class="register-link">
        <p>Not registered yet? <a href="registration.php">Register Here</a></p>
        
      </div>
    </div>
  </body>
</html>