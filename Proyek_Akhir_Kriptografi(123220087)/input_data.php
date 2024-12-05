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
    <title>Input Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        .formbox {
            width: 1000px;
            height: 630px;
            margin: 50px auto;
            background-color: #dfd6cc;
            padding: 20px;
            border-radius: 10px;
        }
        .form-control {
            max-width: 100%; /* Membatasi lebar input */
        }

        .form-select {
            max-width: 100%; /* Membatasi lebar input */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: #000;
            border-radius: 50%;
            padding: 10px;
        }

        .submit-btn {
            position: absolute;
            top: 620px;
            right: 780px;
            display: block;
            width: 100px;
            padding: 8px 10px;
            background-color: #fcd46c;
            color: black;
            font-weight: bold;
            font-size: 17px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }

        .back-btn {
            position: absolute;
            top: 620px;
            right: 650px;
            display: block;
            width: 100px;
            padding: 8px 10px;
            background-color: #a0de99;
            color: black;
            font-weight: bold;
            font-size: 17px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            border: 2px solid black;
        }
    </style>
</head>

<body style="background-color: #95796a">
    <div class="formbox">
         <a href="home_page.php" class="back-btn">Back</a>

        <div class="text-center mb-4" style="font-size: 30px; font-weight: bold;">
            ---- INPUT DATA KOLEKSI MUSEUM ----
        </div>

        <form method="POST" action="input_data_process.php" enctype="multipart/form-data">
            <div id="formCarousel" class="carousel slide" data-bs-interval="false">
                <div class="carousel-inner">
                    <!-- Section 1: Koleksi -->
                    <div class="carousel-item active" style="margin-left:80px;">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="nama_koleksi" class="form-label">Nama Koleksi</label>
                                <input required type="text" class="form-control" name="nama_koleksi" id="nama_koleksi"
                                    placeholder="Isi nama koleksi">
                            </div>
                            <div class="col-md-5">
                                <label for="asal_koleksi" class="form-label">Asal Koleksi</label>
                                <input required type="text" class="form-control" name="asal_koleksi" id="asal_koleksi"
                                    placeholder="Isi asal koleksi">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="tahun_ditemukan" class="form-label">Tahun Ditemukan</label>
                                <input required type="text" class="form-control" name="tahun_ditemukan" id="tahun_ditemukan"
                                    placeholder="Isi tahun saat koleksi ditemukan">
                            </div>
                            <div class="col-md-5">
                                <label for="nama_penemu" class="form-label">Nama Penemu</label>
                                <input required type="text" class="form-control" name="nama_penemu" id="nama_penemu"
                                    placeholder="Isi nama penemu">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="kondisi_koleksi" class="form-label">Kondisi Koleksi</label>
                                <select required class="form-select" name="kondisi_koleksi" id="kondisi_koleksi">
                                    <option selected>Pilih kondisi koleksi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label for="kategori_koleksi" class="form-label">Kategori Koleksi</label>
                                <select required class="form-select" name="kategori_koleksi" id="kategori_koleksi">
                                    <option selected>Pilih kategori koleksi</option>
                                    <option value="Seni">Seni</option>
                                    <option value="Sejarah">Sejarah</option>
                                    <option value="Teknologi">Teknologi</option>
                                    <option value="Budaya">Budaya</option>
                                    <option value="Alam">Alam</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3" style="width:800px;">
                            <label for="deskripsi_koleksi" class="form-label">Deskripsi Koleksi</label>
                            <textarea required class="form-control" name="deskripsi_koleksi" id="deskripsi_koleksi" rows="3"
                                placeholder="Isi deskripsi koleksi"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label for="key_for_text1" class="form-label">Key (Caesar Cipher - Angka)</label>
                                <input required type="number" class="form-control" name="key_for_text1" id="key_for_text1"
                                    placeholder="Masukkan key" min="1" max="25">
                            </div>

                            <div class="col-md-5">
                                <label for="key_for_text2" class="form-label">Key (DES - 8 Karakter)</label>
                                <input required type="text" class="form-control" name="key_for_text2" id="key_for_text2" 
                                    placeholder="Masukkan key" maxlength="8" minlength="8" oninput="validateKeyLength(this)">
                            </div>

                        </div>
                    </div>

                    <!-- Section 2: Gambar dan Files-->
                    <div class="carousel-item" style="margin-left:180px; margin-top:30px;">
                        <div class="mb-3" style="width:600px;">
                            <label for="gambar_koleksi" class="form-label">Gambar Koleksi</label>
                            <input required type="file" class="form-control" name="gambar_koleksi" id="gambar_koleksi"
                                accept="image/*">
                        </div>

                        <div class="mb-3" style="width:600px;">
                            <label for="dokumen" class="form-label">Dokumen Pendukung</label>
                            <input type="file" class="form-control" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx,.txt">
                        </div>

                        <div class="row mb-3" style="width:620px;">
                            <div class="col-md-5">
                            <label for="key_for_file" class="form-label">Key (AES256 - 32 Karakter)</label>
                            <input required type="text" class="form-control" name="key_for_file" id="key_for_file"
                                placeholder="Masukkan key" maxlength="32" minlength="32" oninput="validateKeyLength(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit" class="submit-btn">Submit</button>
            </div>

        </form>
    </div>

    <!-- Navigation Buttons -->
    <button class="carousel-control-prev" type="button" data-bs-target="#formCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#formCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

    <script>
        document.getElementById('key_for_text1').addEventListener('input', function () {
        const input = this;
        const min = parseInt(input.min, 10);
        const max = parseInt(input.max, 10);
        const value = parseInt(input.value, 10);

        // Koreksi nilai di luar batas
        if (value < min) input.value = min;
        if (value > max) input.value = max;
    });
    </script>

    <script>
    function validateKeyLength(input) {
        if (input.value.length > 8) {
            input.value = input.value.slice(0, 8); // Potong jika lebih dari 8 karakter
        }
    }

    // Tambahkan validasi saat form dikirimkan
    document.querySelector('form').addEventListener('submit', function (event) {
        const keyInput = document.getElementById('key_for_text2');
        if (keyInput.value.length !== 8) {
            event.preventDefault(); // Batalkan pengiriman form
            alert('Kunci harus tepat 8 karakter!');
        }
    });
    </script>

    <script>
    function validateKeyLength(input) {
        if (input.value.length > 32) {
            input.value = input.value.slice(0, 32); // Potong jika lebih dari 32 karakter
        }
    }

    // Tambahkan validasi saat form dikirimkan
    document.querySelector('form').addEventListener('submit', function (event) {
        const keyInput = document.getElementById('key_for_file');
        if (keyInput.value.length !== 32) {
            event.preventDefault(); // Batalkan pengiriman form
            alert('Kunci harus tepat 32 karakter!');
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
