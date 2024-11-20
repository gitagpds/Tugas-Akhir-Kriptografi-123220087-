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

// Fungsi dekripsi Caesar Cipher
function caesarDecrypt($text, $shift) {
    $result = "";
    $text = strtolower($text); // Pastikan huruf kecil
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $result .= chr(((ord($char) - 97 - $shift + 26) % 26) + 97);
        } else {
            $result .= $char;
        }
    }
    return $result;
}

// Fungsi dekripsi DES
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

// Fungsi dekripsi file
function decryptFile($filePath, $key) {
    $method = 'AES-256-CBC';
    $ivLength = openssl_cipher_iv_length($method);
    $fileContents = file_get_contents($filePath);

    if ($fileContents === false) {
        return false;
    }

    // Ekstrak IV dan data terenkripsi
    $iv = substr($fileContents, 0, $ivLength);
    $encryptedData = substr($fileContents, $ivLength);

    // Dekripsi
    $decryptedData = openssl_decrypt($encryptedData, $method, $key, OPENSSL_RAW_DATA, $iv);
    return $decryptedData !== false ? $decryptedData : null;
}

// Ambil data terenkripsi dari database
$nama_file_encoded = $data['nama_file_encoded']; // Nama file terenkripsi
$key_for_file = $_POST['key_for_file']; // Kunci untuk file
$filePath = 'encoded_files/' . $nama_file_encoded;

// Dekripsi file
$decryptedFileContents = decryptFile($filePath, $key_for_file);
if ($decryptedFileContents === null) {
    $decryptedFilePreview = "Gagal mendekripsi file.";
} else {
    $decryptedFilePreview = htmlspecialchars(substr($decryptedFileContents, 0, 500)) . (strlen($decryptedFileContents) > 500 ? "..." : "");
    $decryptedFilePath = 'decoded_files/decoded_' . $nama_file_encoded;
    file_put_contents($decryptedFilePath, $decryptedFileContents);
}

// Dekripsi data
$key_for_des = $_POST['key_for_text2']; // Kunci untuk DES
$nama_koleksi_encrypted = $data['nama_koleksi'];
$deskripsi_koleksi_encrypted = $data['deskripsi_koleksi'];

// Dekripsi dengan DES
$nama_koleksi_des = desDecrypt($nama_koleksi_encrypted, $key_for_des);
$deskripsi_koleksi_des = desDecrypt($deskripsi_koleksi_encrypted, $key_for_des);

if ($nama_koleksi_des === null || $deskripsi_koleksi_des === null) {
    die("Gagal mendekripsi dengan DES. Periksa kunci atau format data.");
}

// Dekripsi hasil DES dengan Caesar Cipher
$key_for_caesar = (int)$_POST['key_for_text1']; // Kunci untuk Caesar
$nama_koleksi = caesarDecrypt($nama_koleksi_des, $key_for_caesar);
$deskripsi_koleksi = caesarDecrypt($deskripsi_koleksi_des, $key_for_caesar);

// Ambil data terenkripsi dari database
$nama_gambar_encoded = $data['nama_gambar_encoded']; // Nama file gambar terenkripsi

// Deklarasikan variabel kunci untuk gambar
$key_for_picture = isset($_POST['key_for_picture']) ? $_POST['key_for_picture'] : null;
if (!$key_for_picture) {
    die("Kunci untuk gambar tidak ditemukan.");
}

// Function to decrypt the AES encrypted message from image
function decryptImageMessage($imagePath, $key_for_picture) {
    // Load the image
    $img = imagecreatefrompng($imagePath);
    if (!$img) {
        return "Gagal memuat gambar.";
    }

    $width = imagesx($img);
    $height = imagesy($img);

    $messageBits = '';
    $realMessage = '';

    // Extract LSB from each pixel
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // Capture the LSB from each color channel
            $messageBits .= (string)($r & 1);
            $messageBits .= (string)($g & 1);
            $messageBits .= (string)($b & 1);

            // Convert bits to characters every 8 bits
            while (strlen($messageBits) >= 8) {
                $byte = substr($messageBits, 0, 8);
                $char = chr(bindec($byte));
                $messageBits = substr($messageBits, 8); // Remove used bits

                // Check for end of message (| is the terminator)
                if ($char === '|') {
                    imagedestroy($img); // Clean up image memory
                    return $realMessage;
                }
                $realMessage .= $char;
            }
        }
    }

    imagedestroy($img); // Clean up image memory
    return $realMessage ? $realMessage : "Tidak ada pesan tersembunyi yang valid.";
}

function aesDecrypt($encryptedMessage, $key_for_picture) {
    $method = 'AES-256-CBC';
    $ivLength = openssl_cipher_iv_length($method);
    $iv = substr($encryptedMessage, 0, $ivLength);
    $encryptedData = substr($encryptedMessage, $ivLength);

    // Decrypt the message using AES-256-CBC
    $decryptedMessage = openssl_decrypt($encryptedData, $method, $key_for_picture, OPENSSL_RAW_DATA, $iv);
    return $decryptedMessage !== false ? $decryptedMessage : null;
}

// Fungsi dekripsi AES untuk gambar
$imagePath = 'encoded_images/' . $data['nama_gambar_encoded'];
$encryptedMessage = decryptImageMessage($imagePath, $key_for_picture);


// Check for valid encrypted message
if ($encryptedMessage === "Tidak ada pesan tersembunyi yang valid.") {
    echo "No hidden message found in the image.";
} else {
    // Decrypt the message using AES and the provided key
    $decryptedMessage = aesDecrypt($encryptedMessage, $key_for_picture);

    if ($decryptedMessage === null) {
        echo "Failed to decrypt the message.";
    } else {
        // Display the decrypted message
        echo "Decrypted Message: " . htmlspecialchars($decryptedMessage);
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
            <tr><td><strong>Deskripsi Koleksi</strong></td><td><?= htmlspecialchars($deskripsi_koleksi) ?></td></tr>
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
            <h4>PESAN TERSEMBUNYI (MESSAGE)</h4>
            <p><?= htmlspecialchars($decodedMessage) ?></p>
        </div>

        <div style="margin-top:20px;">
            <h4>FILE YANG DIENKRIPSI</h4>
            <p><strong>Preview:</strong> <?= $decryptedFilePreview ?></p>
            <?php if ($decryptedFileContents !== null): ?>
                <a href="<?= $decryptedFilePath ?>" download class="btn btn-primary">Download Decrypted File</a>
            <?php endif; ?>
        </div>

    </div>
</body>
</html>
