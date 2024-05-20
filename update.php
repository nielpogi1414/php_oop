<?php
require_once('classes/database.php');
$con = new database();

if (empty($id = $_POST['id'])) {
     header('location:login.php');
    }
    
    
    else{
        $id = $_POST['id'];
        $data = $con->viewdata($id);
    }
    

    if(isset($_POST['update'])) {
      //user information 
      $firstname = isset($_POST['firstName'])? $_POST['firstName'] : '';
      $lastname = isset($_POST['lastName'])? $_POST['lastName'] : '';
      $birthday = isset($_POST['Birthday'])? $_POST['Birthday'] : '';
      $sex = isset($_POST['Sex'])? $_POST['Sex'] : '';
      $username = isset($_POST['username'])? $_POST['username'] : '';
      $passwords = isset($_POST['passwords'])? $_POST['passwords'] : '';
      $confirm = isset($_POST['c_pass'])? $_POST['c_pass'] : '';
      
      //address information
      $street = isset($_POST['street'])? $_POST['street'] : '';
      $barangay = isset($_POST['barangay'])? $_POST['barangay'] : '';
      $city = isset($_POST['city'])? $_POST['city'] : '';
      $province = isset($_POST['province'])? $_POST['province'] : '';
      $user_id = $_POST['id'];
  
      echo $user_id;
  
      if(1 == 1) {

          if ($con->updateUser($user_id ,$firstname, $lastname, $birthday, $sex, $username, $passwords)) {
          // Update user address
          echo 'im here';
          if ($con->updateUserAddress($user_id, $street, $barangay, $city, $province)) {
              // Both updates successful, redirect to a success page or display a success message
              header('location:index.php');
              exit();
              
          } else {
              // User address update failed
              $error = "Error occurred while updating user address. Please try again.";
           }
      } else {
          // User update failed
          $error = "Error occurred while updating user information. Please try again.";
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Page</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./includes/style.php">

</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="container custom-container rounded-3 shadow my-5 p-3 px-5">
  <h3 class="text-center mt-4"> Hello, <?php echo $data['FirstName']?>!</h3>
  <form method="POST">
    <!-- Personal Information -->
    <div class="card mt-4">
      <div class="card-header bg-info text-white">Personal Information</div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6 col-sm-12">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" value="<?php echo $data['FirstName'];?>" name="firstName"  placeholder="Enter first name">
          </div>
          <div class="form-group col-md-6 col-sm-12">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" name="lastName" value="<?php echo $data['LastName'];?>" placeholder="Enter last name">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="Birthday">Birthday:</label>
            <input type="date" class="form-control" value="<?php echo $data['Birthday'];?>"name="Birthday">
          </div>
          <div class="form-group col-md-6">
            <label for="Sex">Sex:</label>
            <select class="form-control" name="Sex">
            <option value="Male" <?php if ($data['Sex'] === 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($data['Sex'] === 'Female') echo 'selected'; ?>>Female</option>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" class="form-control" name="username" value="<?php echo $data['Username'];?>"  placeholder="Enter username">
          
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" value="<?php echo $data['Pass_word'];?>"  name="passwords" placeholder="Enter password">
        </div>
        <div class="form-group">
          <label for="c_pass">Confirm Password:</label>
          <input type="password" class="form-control" value="<?php echo $data['Pass_word'];?>"  name="c_pass" placeholder="Confirm password">
        </div>
      </div>
    </div>
    
    <!-- Address Information -->
    <div class="card mt-4">
      <div class="card-header bg-info text-white">Address Information</div>
      <div class="card-body">
        <div class="form-group">
          <label for="street">Street:</label>
          <input type="text" class="form-control" name="street" value="<?php echo $data['user_add_street'];?>"  placeholder="Enter street">
        </div>
        <div class="form-row">
    <div class="form-group col-md-6">
        <label for="barangay">Barangay:</label>
        <input type="text" class="form-control" name="barangay" value="<?php echo isset($data['user_add_barangay'])? $data['user_add_barangay'] : '';?>" placeholder="Enter barangay">
    </div>
    <div class="form-group col-md-6">
        <label for="city">City:</label>
        <input type="text" class="form-control" name="city" value="<?php echo isset($data['user_add_city'])? $data['user_add_city'] : '';?>" placeholder="Enter city">
    </div>
</div>
        <div class="form-group">
          <label for="province">Province:</label>
          <input type="text" class="form-control" name="province" value="<?php echo $data['user_add_province'];?> " placeholder="Enter province">
        </div>
      </div>
    </div>
    
    <!-- Submit Button -->

    
    <div class="container">
    <div class="row justify-content-center gx-0">
        <div class="col-lg-3 col-md-4"> 
        <input type="hidden" name="id" value="<?php echo $data['user_id']; ?>">
            <input type="submit" name="update" class="btn btn-outline-primary btn-block mt-4" value="Update">

        </div>
        <div class="col-lg-3 col-md-4"> 
            <a class="btn btn-outline-danger btn-block mt-4" href="index2.php">Go Back</a>
        </div>
    </div>
</div>


  </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<!-- Bootsrap JS na nagpapagana ng danger alert natin -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>