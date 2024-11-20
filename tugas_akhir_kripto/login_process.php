<?php
include 'connect.php';
session_start();
if (isset($_SESSION['username'])) {
    header("location: home_page.php");
}

// Get username and password from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Hash the input password using SHA256
$hash = hash('sha256', $password);

// Query the database to check if the username and password match
$query = mysqli_query($connect, "SELECT * FROM `user` WHERE username='$username' AND password = '$hash'");

// Check if a record was found with the matching username and password
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    // If login is successful, set session variable and redirect to home page
    $_SESSION['username'] = $username;
    header("location: home_page.php");
    exit();
} else {
    // If login fails, show error message and redirect back to login form
    header("location: login_form.php?pesan=gagal");
    exit();
}
?>