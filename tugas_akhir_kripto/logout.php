<?php
session_start();
session_unset(); // Hapus semua session
session_destroy(); // Hancurkan session
header("location: login_form.php?pesan=logout");
exit();
?>
