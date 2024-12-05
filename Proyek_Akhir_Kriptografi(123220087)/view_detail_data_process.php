<?php

session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("location: login_form.php?pesan=belum_login");
    exit();
}

include 'connect.php';

// Mendapatkan id_koleksi dari POST
$id_koleksi = isset($_POST['id_koleksi']) ? $_POST['id_koleksi'] : null;

if (!$id_koleksi) {
    die("ID Koleksi tidak ditemukan.");
}

// Query untuk mengambil data koleksi dari database
$query = "SELECT * FROM data_museum WHERE id_koleksi = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $id_koleksi);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan untuk ID Koleksi tersebut.");
}

// DEKRIPSI TEKS

// Fungsi dekripsi Caesar Cipher
function caesarDecrypt($text, $shift) {
    $result = "";
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        
        if (ctype_alpha($char)) {
            // Cek apakah hurufnya kapital atau tidak
            $asciiOffset = (ctype_upper($char)) ? 65 : 97;  // Offset untuk huruf kapital (A=65) atau kecil (a=97)
            $result .= chr((ord($char) - $asciiOffset - $shift + 26) % 26 + $asciiOffset);
        } else {
            $result .= $char;  // Jika bukan huruf, tambahkan karakter tanpa perubahan
        }
    }
    return $result;
}

function desDecrypt($data, $key) {
    $method = 'DES-CBC';
    $key = substr(hash('md5', $key, true), 0, 8); // Kunci DES 8 byte
    $iv = str_repeat("\0", openssl_cipher_iv_length($method)); // IV kosong
    
    // Decode base64
    $decodedData = base64_decode($data);
    if ($decodedData === false) {
        return false; // Gagal decode base64
    }

    // Dekripsi
    $decrypted = openssl_decrypt($decodedData, $method, $key, OPENSSL_RAW_DATA, $iv);
    return $decrypted !== false ? $decrypted : null; // Pastikan hasil valid
}

// Pastikan data terenkripsi dari database benar
$nama_koleksi_encrypted = $data['nama_koleksi']; // Nama koleksi terenkripsi
$deskripsi_koleksi_encrypted = $data['deskripsi_koleksi']; // Deskripsi koleksi terenkripsi

// DEKRIPSI TEKS (Caesar Cipher dan DES)
$key_for_des = $_POST['key_for_text2']; // Kunci DES
$key_for_caesar = (int)$_POST['key_for_text1']; // Kunci Caesar Cipher

if ($key_for_des) {
    // Dekripsi menggunakan DES
    $nama_koleksi_des = desDecrypt($nama_koleksi_encrypted, $key_for_des);
    $deskripsi_koleksi_des = desDecrypt($deskripsi_koleksi_encrypted, $key_for_des);
    
    // Validasi jika dekripsi gagal
    if ($nama_koleksi_des === null || $deskripsi_koleksi_des === null) {
        die("Gagal mendekripsi dengan DES. Periksa kunci atau format data.");
    }
}

// Dekripsi menggunakan Caesar Cipher jika DES berhasil
if ($nama_koleksi_des && $deskripsi_koleksi_des) {
    $nama_koleksi = caesarDecrypt($nama_koleksi_des, $key_for_caesar);
    $deskripsi_koleksi = caesarDecrypt($deskripsi_koleksi_des, $key_for_caesar);
    
    // Validasi jika dekripsi Caesar gagal
    if (empty($nama_koleksi) || empty($deskripsi_koleksi)) {
        die("Data tidak dapat didekripsi dengan Caesar Cipher.");
    }
} else {
    die("Data tidak valid untuk dekripsi.");
}

// DEKRIPSI GAMBAR - STEGANOGRAFI

// Fungsi untuk mengekstraksi pesan dari gambar menggunakan LSB decoding
function decryptImageMessage($imagePath) {
    $img = imagecreatefrompng($imagePath);
    if (!$img) {
        return "Gagal memuat gambar.";
    }

    $width = imagesx($img);
    $height = imagesy($img);

    $messageBits = '';
    $realMessage = '';

    // Ekstrak LSB dari setiap pixel
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $messageBits .= (string)($r & 1);
            $messageBits .= (string)($g & 1);
            $messageBits .= (string)($b & 1);

            // Konversi bit menjadi karakter setiap 8 bit
            while (strlen($messageBits) >= 8) {
                $byte = substr($messageBits, 0, 8);
                $char = chr(bindec($byte));
                $messageBits = substr($messageBits, 8);

                // Cek untuk akhir pesan
                if ($char === '|') {
                    imagedestroy($img); // Cleanup
                    return $realMessage;
                }
                $realMessage .= $char;
            }
        }
    }

    imagedestroy($img);
    return $realMessage ? $realMessage : "Tidak ada pesan tersembunyi.";
}

// Ambil data terenkripsi dari database
$nama_gambar_encoded = $data['nama_gambar_encoded']; // Nama file gambar
$imagePath = 'encoded_images/' . $nama_gambar_encoded;

// Dekripsi pesan tersembunyi dari gambar
$decodedMessage = decryptImageMessage($imagePath);

// Fungsi dekripsi file
// DEKRIPSI FILE
// Fungsi dekripsi file menggunakan AES-256
function decryptFile($filePath, $key) {
    $method = 'aes-256-cbc';
    $key = hash('sha256', $key, true); // Hash the key to 256 bits

    if (!file_exists($filePath)) {
        return "File tidak ditemukan.";
    }

    // Baca isi file
    $fileContents = file_get_contents($filePath);
    if ($fileContents === false) {
        return "Gagal membaca file.";
    }

    // Pisahkan data terenkripsi dan IV
    $decodedContents = base64_decode($fileContents);
    if ($decodedContents === false) {
        return "Data file tidak valid (gagal decode Base64).";
    }

    $parts = explode("::", $decodedContents);
    if (count($parts) !== 2) {
        return "Format file terenkripsi tidak valid.";
    }

    [$encryptedData, $iv] = $parts;

    // Dekripsi data
    $decryptedData = openssl_decrypt($encryptedData, $method, $key, 0, $iv);
    if ($decryptedData === false) {
        return "Gagal mendekripsi file. Pastikan kunci enkripsi benar.";
    }

    return $decryptedData;
}

// Proses dekripsi file
$nama_file_encoded = $data['nama_file_encoded']; // Nama file terenkripsi dari database
$filePath = 'encoded_files/' . $nama_file_encoded; // Path file terenkripsi
$key_for_file = $_POST['key_for_file']; // Ambil kunci dari input form

if (empty($nama_file_encoded) || !file_exists($filePath)) {
    $decryptedFilePreview = "File terenkripsi tidak ditemukan.";
} else {
    // Dekripsi file dengan kunci
    $decryptedFileContents = decryptFile($filePath, $key_for_file);
    if (is_string($decryptedFileContents) && strpos($decryptedFileContents, "Gagal") !== false) {
        $decryptedFilePreview = $decryptedFileContents; // Tampilkan pesan error jika ada
    } else {
        // Simpan file hasil dekripsi
        $decryptedFilePath = 'decoded_files/decoded_' . $nama_file_encoded;
        file_put_contents($decryptedFilePath, $decryptedFileContents);

        // Buat preview isi file
        $decryptedFilePreview = htmlspecialchars(substr($decryptedFileContents, 0, 500)) . (strlen($decryptedFileContents) > 500 ? "..." : "");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decrypted Data</title>
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
        }
        .back-btn {
            position: absolute;
            top: 67px;
            right: 130px;
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
    <div class="container">
        <a href="view_data.php" class="back-btn">Back</a>

        <h3 style="margin-bottom:20px;">DETAIL KOLEKSI</h3>
        <table class="table table-bordered">
            <tr><td><strong>ID Koleksi</strong></td><td><?= htmlspecialchars($data['id_koleksi']) ?></td></tr>
            <tr><td><strong>Nama Koleksi</strong></td><td><?= htmlspecialchars($nama_koleksi) ?></td></tr>
            <!--<tr><td><strong>Deskripsi Koleksi</strong></td><td><?= htmlspecialchars($deskripsi_koleksi) ?></td></tr>-->
            <tr><td><strong>Asal Koleksi</strong></td><td><?= htmlspecialchars($data['asal_koleksi']) ?></td></tr>
            <tr><td><strong>Tahun Ditemukan</strong></td><td><?= htmlspecialchars($data['tahun_ditemukan']) ?></td></tr>
            <tr><td><strong>Kondisi Koleksi</strong></td><td><?= htmlspecialchars($data['kondisi_koleksi']) ?></td></tr>
            <tr><td><strong>Kategori Koleksi</strong></td><td><?= htmlspecialchars($data['kategori_koleksi']) ?></td></tr>
            <tr><td><strong>Nama Penemu</strong></td><td><?= htmlspecialchars($data['nama_penemu']) ?></td></tr>
        </table>

        <div style="margin-top:20px;">
            <h4 style="margin-bottom:20px;">GAMBAR KOLEKSI</h4>
            <img src="<?= 'encoded_images/' . $nama_gambar_encoded ?>" alt="Gambar Koleksi" class="img-fluid" />
        </div>

        <div style="margin-top:20px;">
            <h4>PESAN TERSEMBUNYI PADA GAMBAR (DESKRIPSI KOLEKSI)</h4>
            <p><?= htmlspecialchars($decodedMessage) ?></p>
        </div>

        <div style="margin-top:20px;">
            <h4>FILE YANG DIENKRIPSI</h4>
            <p><strong>Preview:</strong> <?= $decryptedFilePreview ?></p>
            <?php if (isset($decryptedFilePath) && file_exists($decryptedFilePath)): ?>
                <a href="<?= $decryptedFilePath ?>" download class="btn btn-primary">Download Decrypted File</a>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
