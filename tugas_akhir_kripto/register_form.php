<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                <img class="img" src="assets/asset2.jpg" style="height: 500px; width:500px; border-top-left-radius: 7px; border-bottom-left-radius: 7px;" alt="picture">
            </div>

            <div class="col">
                <div class="right_page" style="padding: 20px; padding-top: 50px;">
                    <center>
                        <h4 style="color: gray; margin-bottom: 20px;">SIGN UP</h4>
                    </center>

                    <center>
                        <div class="text-black" style="margin-bottom:10px;">
                            <?php
                                if (isset($_GET['pesan'])) {
                                    if ($_GET['pesan'] == "gagal") {
                                        echo "Login gagal username dan password salah!";
                                    } else if ($_GET['pesan'] == "logout") {
                                        echo "Anda berhasil logout";
                                    } else if ($_GET['pesan'] == "belum_login") {
                                        echo "Anda harus login untuk mengakses halaman admin";
                                    }
                                }
                            ?>
                        </div>
                    </center>

                    <center>
                        <form action="register_process.php" method="POST" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control" style="border-radius: 40px; height:50px;" id="exampleInputUsername" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" style="border-radius: 40px; height:50px;" id="exampleInputEmail" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" style="border-radius: 40px; height:50px;" placeholder="Password" id="exampleInputPassword1" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirm_password" class="form-control" style="border-radius: 40px; height:50px;" placeholder="Confirm Password" id="exampleInputConfirmPassword" required>
                            </div>

                            <button type="submit" class="btn btn-outline-primary" style="border-radius: 40px; height:50px; width: 425px;">Register</button>
                        </form>

                        <div class="mt-3">
                            <center>
                                <p>Already have an account? <a href="login_form.php" style="font-weight: bold; color: #633e35; text-decoration: none;">Login</a></p>
                            </center>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        function validateForm() {
            var password = document.getElementById("exampleInputPassword1").value;
            var confirmPassword = document.getElementById("exampleInputConfirmPassword").value;

            if (password !== confirmPassword) {
                alert("Password dan Confirm Password tidak cocok!");
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
