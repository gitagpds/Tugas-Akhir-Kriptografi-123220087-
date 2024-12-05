<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Jika tidak, arahkan ke halaman login
    header("location: login_form.php?pesan=belum_login");
    exit();
}

include 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data Museum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .table-container {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        thead th, tbody td {
            text-align: center; /* Mengatur teks di header dan isi tabel menjadi rata tengah */
            vertical-align: middle; /* Memastikan teks berada di tengah secara vertikal */
        }
        .image-thumbnail {
            width: 100px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }

        .back-btn {
            position: absolute;
            top: 70px;
            right: 140px;
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
<body>
    <div class="container table-container">
        <a href="home_page.php" class="back-btn">Back</a>

        <h2 class="text-center mb-4">DATA KOLEKSI MUSEUM</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Koleksi</th>
                    <th>Asal Koleksi</th>
                    <th>Tahun Ditemukan</th>
                    <th>Deskripsi Koleksi</th>
                    <th>Gambar Koleksi</th>
                    <th>Dokumen</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data dari tabel data_museum
                $query = "SELECT * FROM data_museum";
                $result = $connect->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>[TERENKRIPSI]</td>';
                        echo '<td>' . $row['asal_koleksi'] . '</td>';
                        echo '<td>' . $row['tahun_ditemukan'] . '</td>';
                        echo '<td>[TERENKRIPSI]</td>';
                        echo '<td>[TERENKRIPSI]</td>';
                        echo '<td>[TERENKRIPSI]</td>';
                        echo '<td>
                                <a href="view_detail_data.php?id_koleksi=' . $row['id_koleksi'] . '" class="btn btn-primary btn-sm">View Detail Data</a>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7" class="text-center">Tidak ada data</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>