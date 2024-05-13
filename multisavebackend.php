<!-- To be added in the multisave.php -->

<?php

require_once('classes/database.php');

$con = new database();
if (isset($_POST['adduser'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $confirm = $_POST['c_pass'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    
    if ($password == $confirm) {
        // Passwords match, proceed with signup
        $user_id = $con->signupUser($username, $password); // Insert into users table and get user_id
        if ($user_id) {
            // Signup successful, insert address into users_address table
            if ($con->insertAddress($user_id, $city, $province)) {
                // Address insertion successful, redirect to login page
                header('location:login.php');
                exit();
            } else {
                // Address insertion failed, display error message
                $error = "Error occurred while signing up. Please try again.";
            }
        } else {
            // User insertion failed, display error message
            $error = "Error occurred while signing up. Please try again.";
        }
    } else {
        // Passwords don't match, display error message
        $error = "Passwords did not match. Please try again.";
    }
}
