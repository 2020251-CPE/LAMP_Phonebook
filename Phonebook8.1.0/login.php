<?php
    session_start();
    if (isset($_SESSION["user"])){
    header("Location: welcome.php");
    exit();
    }
    
    if(isset($_POST["login"])){
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "DB_connection.php";
        $sql = "SELECT * FROM Account WHERE email = '$email'";
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            if(strcmp($password,$user["password"])){
                if (!isset($_SESSION)){
                    session_start();
                }
                $_SESSION["user"] = $email;
                header("Location: welcome.php");
                exit();
            }else{
            $errorMessage = "Password does not Match";
            }
        }else{
         $errorMessage = "Email does not Match";
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
    <!-- ======= Hero Section ======= -->
  <section id="hero" class="align-items-center">
    <div class="container">
        <form action="index.php" method="POST">
          <h3>Login</h3>
          <label for="username">Email:</label>
          <input type="text" id="email" name="email" placeholder="Input Email here" required>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" placeholder="Input password here" required>
          <input type="submit" value="Login"><br>
          <a href="">Don't have an Account yet? Sign In!</a>
        </form>
        <br>
    </div>
  </section><!-- End Hero -->
</body>
</html>