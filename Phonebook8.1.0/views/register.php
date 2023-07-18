<?php
    session_start();
    $errorMessage="";
    
    if(isset($_POST["Register"])){
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        if (empty($name) || empty($password) || empty($email)) {
        $errorMessage= "Please fill in all fields.";
        } else {
            require_once $_SERVER['DOCUMENT_ROOT']."/api/DB_connection.php";
            $sql = "INSERT INTO `accounts` (`name`, `email`, `password`) VALUES ('$name', '$email', ' $password');";
            $result = mysqli_query($con, $sql);
        
            if ($result) {
                $_SESSION["user"] = $email;
                header("Location: /");
                exit();
            } else {
                $errorMessage = "Error: " . mysqli_error($conn);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Arsha Bootstrap Template - Index</title><!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    body {
        background: #37517e;
    }
    .container {
      opacity: 85%;
      max-width: 400px;
      margin: 0 auto;
      padding: 40px;
      background-color: #ffffff;
      border: 1px solid #dddddd;
      border-radius: 5px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }
    h2,h3 {
      text-align: center;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #dddddd;
      border-radius: 5px;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #4caf50;
      color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <section id="hero" class="align-items-center">
    <div class="container">
        <form action="/register" method="POST">
          <h3>Register</h3>
          <label for="username">Name:</label>
          <input type="text" id="name" name="name" placeholder="Input Email here" required>
          <label for="email">Email:</label>
          <input type="text" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" id="email" name="email" placeholder="Input Email here" required>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" placeholder="Input password here" required>
          <input type="submit" value="Register" name="Register"><br>
          <p><?php echo $errorMessage; ?></p>
        </form>
        <a href="/register">Already have an Account? Log In Here</a><br>
        <br>
    </div>
  </section>
</body>
</html>