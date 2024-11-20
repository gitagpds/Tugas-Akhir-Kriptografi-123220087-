<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #b4a496;
        }
    </style>
</head>

<body>
    <div class="boxes" style="background-color: white;">
        <div class="row align-items-start">
            <div class="col">
                <img class="img" src="assets/asset1.jpeg" style="height: 500px; width:500px; border-top-left-radius: 7px; border-bottom-left-radius: 7px;" alt="picture">
            </div>

            <div class="col">
                <div class="right_page" style="padding: 20px;  padding-top: 50px;">
                    <center>
                        <h4 style="color: gray; margin-bottom: 20px;">WELCOME TO MY MUSEUM!</h4>
                    </center>

                    <center> 
                <div class="text-black " style="margin-bottom:10px;">
                <?php
                    if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == "gagal") {
                                echo "<p class='alert alert-danger'>Login gagal, username atau password salah!</p>";
                        } elseif ($_GET['pesan'] == "logout") {
                                echo "<p class='alert alert-success'>Anda berhasil logout</p>";
                        } elseif ($_GET['pesan'] == "belum_login") {
                                echo "<p class='alert alert-warning'>Anda harus login terlebih dahulu untuk mengakses halaman ini</p>";
                        }
                        }
                ?>

            </div>
                    </center>

                    <center>
                        <form action="login_process.php" method="POST">
                            <div class="mb-3">
                                <input type="username" name="username" class="form-control" style="border-radius: 40px; height:50px;" id="exampleInputEmail1" placeholder="Username" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" style="border-radius: 40px; height:50px;"placeholder="Password" id="exampleInputPassword1">
                            </div>

                            <button type="submit" class="btn btn-outline-primary" style="border-radius: 40px; height:50px; width: 425px;">Login</button>
                        </form>

                        <div class="mt-3">
                            <center>
                                <p>Don't have an account? <a href="register_form.php" style="font-weight: bold; color: #633e35; text-decoration: none;">Register</a></p>
                            </center>
                        </div>

                    </center>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>