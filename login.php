<?php
require_once('classes/database.php');
$con = new database();
session_start();


if (isset($_SESSION['username'])){
  header('location:index.php');
}


if (isset($_POST['login'])) {
  $Username=$_POST['Username'];
  $Pass_word=$_POST['Pass_word'];
  $result=$con->check($Username, $Pass_word);
  
  if ($result) {
      if ($result['Username'] == $_POST['Username'] && $result['Pass_word'] == $_POST['Pass_word']){
          $_SESSION['username'] = $result['Username'];
      
          header('location:index.php');
          }
  else {echo "error";}
      }
      else {echo "error";}
   }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="styles.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
    }
    .login-container {
      max-width: 400px;
      margin: 0 auto;
      margin-top: 100px;
      background-color: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.2);
    }
    .login-container h2 {
      color: #ff6b81;
    }
    .form-group label {
      color: #636e72;
    }
    .form-control {
      border-color: #b2bec3;
    }
    .btn-login {
      background-color: #ff6b81;
      border-color: #ff6b81;
      color: #fff;
    }
    .btn-login:hover {
      background-color: #e84393;
      border-color: #e84393;
    }
  </style>
</head>
<body>
 
<div class="container-fluid login-container rounded shadow">
  <h2 class="text-center mb-4">Login</h2>
 
  <form method="post">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" name="Username" placeholder="Enter username">
    </div>
    <div class="form-group">
      <label for="Pass_word">Password:</label>
      <input type="password" class="form-control" name="Pass_word" placeholder="Enter password">
    </div>
   

    <div class="container">
      <div class="row gx-1">
        <div class="col"> <input type="submit" name="login" class="btn btn-danger btn-block" value="Login"></div>
        <div class="col"><a href="signup.php"class="btn btn-danger btn-block">Sign Up</a></div>
      </div>
    </div>


  </form></div>
  
 
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>