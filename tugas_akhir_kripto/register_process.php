<?php
include 'connect.php';

$id = '';
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Hashing password dengan SHA256
$hash = hash('sha256', $password);

// Insert user ke dalam database
$stmt = mysqli_query($connect, "INSERT INTO user (id_user, username, email, password) VALUES ('$id', '$username', '$email', '$hash')");

// Cek apakah insert berhasil
if ($stmt) {
    header("Location: login_form.php?pesan=register_success"); // Redirect ke halaman login jika berhasil
} else {
    echo "Error: " . mysqli_error($connect); // Menampilkan error jika insert gagal
}
?>
