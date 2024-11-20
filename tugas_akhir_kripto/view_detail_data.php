<?php

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, arahkan ke halaman login
    header("location: login_form.php?pesan=belum_login");
    exit();
}

include 'connect.php';

// Mendapatkan id_koleksi dari URL
$id_koleksi = isset($_GET['id_koleksi']) ? $_GET['id_koleksi'] : null;

if ($id_koleksi) {
    // Query untuk mengambil data berdasarkan id_koleksi
    $query = "SELECT * FROM data_museum WHERE id_koleksi = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $id_koleksi);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
} else {
    die("ID Koleksi tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Museum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .left-panel, .right-panel {
            flex: 1;
        }
        .right-panel {
            max-width: 300px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .table {
            width: 100%;
        }

        .back-btn {
            position: absolute;
            top: 520px;
            right: 120px;
            display: block;
            width: 300px;
            padding: 8px 10px;
            background-color: #a0de99;
            color: black;
            font-weight: bold;
            font-size: 17px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Panel Kiri: Menampilkan Data -->
        <div class="left-panel">
            <h4>DETAIL KOLEKSI</h4>
            <table class="table table-bordered">
                <tr><td><strong>ID Koleksi</strong></td><td><?= $data['id_koleksi'] ?></td></tr>
                <tr><td><strong>Nama Koleksi</strong></td><td>[TERENKRIPSI]</td></tr>
                <tr><td><strong>Deskripsi Koleksi</strong></td><td>[TERENKRIPSI]</td></tr>
                <tr><td><strong>Asal Koleksi</strong></td><td><?= $data['asal_koleksi'] ?></td></tr>
                <tr><td><strong>Tahun Ditemukan</strong></td><td><?= $data['tahun_ditemukan'] ?></td></tr>
                <tr><td><strong>Kondisi Koleksi</strong></td><td><?= $data['kondisi_koleksi'] ?></td></tr>
                <tr><td><strong>Kategori Koleksi</strong></td><td><?= $data['kategori_koleksi'] ?></td></tr>
                <tr><td><strong>Nama Penemu</strong></td><td><?= $data['nama_penemu'] ?></td></tr>
                <tr><td><strong>Gambar Koleksi</strong></td><td>[TERENKRIPSI]</td></tr>
                <tr><td><strong>Nama Gambar Asli</strong></td><td><?= $data['nama_gambar_asli'] ?></td></tr>
                <tr><td><strong>Nama Gambar Terenkripsi</strong></td><td><?= $data['nama_gambar_encoded'] ?></td></tr>
                <tr><td><strong>Dokumen</strong></td><td>[TERENKRIPSI]</td></tr>
                <tr><td><strong>Nama File Asli</strong></td><td><?= $data['nama_file_asli'] ?></td></tr>
                <tr><td><strong>Nama File Terenkripsi</strong></td><td><?= $data['nama_file_encoded'] ?></td></tr>
            </table>
        </div>

        <!-- Panel Kanan: Form Input Key -->
        <div class="right-panel">
            <h4>FORM KEY DECRYPT</h4>
            <form action="view_detail_data_process.php" method="POST">
                <input type="hidden" name="id_koleksi" value="<?= $id_koleksi ?>">
                
                <!-- Decrypt Nama dan Deskripsi -->
                <div class="form-group">
                    <label for="key_for_text1" style="margin-bottom:10px;">Key (Caesar Cipher - Angka)</label>
                    <input type="text" class="form-control" id="key_for_text1" name="key_for_text1" placeholder="Key Caesar Cipher">
                </div>

                <!-- Decrypt Nama dan Deskripsi -->
                <div class="form-group">
                    <label for="key_for_text2" style="margin-bottom:10px;">Key (DES - 8 Karakter)</label>
                    <input type="text" class="form-control" id="key_for_text2" name="key_for_text2" placeholder="Key DES">
                </div>

                <!-- Decrypt Gambar -->
                <div class="form-group">
                    <label for="key_for_picture" style="margin-bottom:10px;">Key (LSB)</label>
                    <input type="text" class="form-control" id="key_for_picture" name="key_for_picture" placeholder="Key LSB">
                </div>

                <!-- Decrypt Dokumen -->
                <div class="form-group">
                    <label for="key_for_file" style="margin-bottom:10px;">Key (AES-256)</label>
                    <input type="text" class="form-control" id="key_for_file" name="key_for_file" placeholder="Key AES-256">
                </div>

                <!-- Tombol Decrypt -->
                <button type="submit" class="btn btn-primary w-100 mt-3">Decrypt</button>
                <a href="view_data.php" class="back-btn">Back</a>
            </form>
        </div>
    </div>
</body>
</html>
