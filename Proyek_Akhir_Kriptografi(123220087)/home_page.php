<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, arahkan ke halaman login
    header("location: login_form.php?pesan=belum_login");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #b4a496;
        }

        .img {
            height: 300px;
            width: 300px;
            border-radius: 7px;
        }

        .link {
            text-decoration: none;
            font-weight: bold;
            color: #624c3e;
            font-size: 1.5rem;
        }

        .link:hover {
            color: #8b5e3c;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            display: block;
            width: 100px;
            padding: 8px 10px;
            background-color: #de3131;
            color: white;
            font-weight: bold;
            font-size: 18px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="boxes" style="background-color: white; padding: 20px;">
        <!-- Logout Button -->
         <a href="logout.php" class="logout-btn">Logout</a>

        <div class="row align-items-center">
            <!-- Left Column -->
            <div class="col text-center" style="margin-top: 70px;">
                <a href="input_data.php">
                    <img class="img" src="assets/asset3.jpg" alt="Input Data">
                </a>
                <p style="margin-top: 20px;">
                    <a href="input_data.php" class="link">Input Data Museum</a>
                </p>
            </div>

            <!-- Right Column -->
            <div class="col text-center" style="margin-top: 70px;">
                <a href="view_data.php">
                    <img class="img" src="assets/asset4.jpg" alt="View Data">
                </a>
                <p style="margin-top: 20px;">
                    <a href="view_data.php" class="link">View Data Museum</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
