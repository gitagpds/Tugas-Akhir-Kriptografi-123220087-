<?php
session_start();

include 'connect.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("location: login_form.php?pesan=belum_login");
    exit();
}

$username = $_SESSION['username'];

// Function for Caesar Cipher Encryption
function caesarEncrypt($text, $shift) {
    $result = "";
    // Hapus strtolower($text); agar huruf kapital tetap dipertahankan
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            // Mengecek apakah karakter adalah huruf kapital atau tidak
            $asciiOffset = (ctype_upper($char)) ? 65 : 97; // Offset untuk huruf kapital dan kecil
            $result .= chr(((ord($char) - $asciiOffset + $shift) % 26) + $asciiOffset);
        } else {
            $result .= $char; // Tidak memodifikasi karakter selain huruf
        }
    }
    return $result;
}

// Function for DES Encryption
function desEncrypt($data, $key) {
    $method = 'DES-CBC';
    $key = substr(hash('md5', $key, true), 0, 8); // Kunci DES 8 byte
    $iv = str_repeat("\0", openssl_cipher_iv_length($method)); // IV kosong
    
    // Enkripsi
    $encrypted = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encrypted); // Simpan hasil terenkripsi dalam Base64
}

// Function for Super Encryption (Caesar + DES)
function superEncrypt($text, $caesarShift, $desKey) {
    $caesarEncrypted = caesarEncrypt($text, $caesarShift);
    return desEncrypt($caesarEncrypted, $desKey);
}

// Function for AES Encryption
function aesEncrypt($data, $key) {
    $method = 'aes-256-cbc';
    $key = hash('sha256', $key, true); // Hash the key to 256 bits
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)); // Generate IV
    
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
    if ($encrypted === false) {
        return false;
    }

    // Gabungkan IV dan data terenkripsi, pisahkan dengan delimiter "::"
    return base64_encode($encrypted . "::" . $iv);
}

// Convert text message to binary
function toBin($text) {
    $binary = '';
    for ($i = 0; $i < strlen($text); $i++) {
        $binary .= str_pad(decbin(ord($text[$i])), 8, '0', STR_PAD_LEFT);
    }
    return $binary;
}

// Convert binary string back to text
function toString($binary) {
    $text = '';
    for ($i = 0; $i < strlen($binary); $i += 8) {
        $text .= chr(bindec(substr($binary, $i, 8)));
    }
    return $text;
}

// Function to embed message into image using LSB encoding
function lsbEncrypt($imagePath, $message) {
    $binaryMessage = toBin($message) . toBin('|'); // Tambahkan terminator '|'

    $image = imagecreatefromstring(file_get_contents($imagePath));
    $width = imagesx($image);
    $height = imagesy($image);

    $messageLength = strlen($binaryMessage);
    $messageIndex = 0;

    // Iterate through image pixels and encode message in the LSB of each color channel
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            if ($messageIndex >= $messageLength) {
                break 2; // Stop if message fully encoded
            }

            $rgb = imagecolorat($image, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            if ($messageIndex < $messageLength) {
                $r = ($r & 0xFE) | (int)$binaryMessage[$messageIndex++];
            }
            if ($messageIndex < $messageLength) {
                $g = ($g & 0xFE) | (int)$binaryMessage[$messageIndex++];
            }
            if ($messageIndex < $messageLength) {
                $b = ($b & 0xFE) | (int)$binaryMessage[$messageIndex++];
            }

            $newColor = imagecolorallocate($image, $r, $g, $b);
            imagesetpixel($image, $x, $y, $newColor);
        }
    }

    $encodedImagePath = 'encoded_images/' . pathinfo($imagePath, PATHINFO_FILENAME) . '_encoded.png';
    imagepng($image, $encodedImagePath);
    imagedestroy($image);

    return $encodedImagePath;
}

// Get POST data from form
$nama_koleksi = $_POST['nama_koleksi'];
$deskripsi_koleksi = $_POST['deskripsi_koleksi'];
$asal_koleksi = $_POST['asal_koleksi'];
$tahun_ditemukan = $_POST['tahun_ditemukan'];
$kondisi_koleksi = $_POST['kondisi_koleksi'];
$kategori_koleksi = $_POST['kategori_koleksi'];
$nama_penemu = $_POST['nama_penemu'];
$key_for_text1 = $_POST['key_for_text1'];
$key_for_text2 = $_POST['key_for_text2'];
$key_for_file = $_POST['key_for_file'];

// Encrypt inputs
$encrypted_nama_koleksi = superEncrypt($nama_koleksi, (int)$key_for_text1, $key_for_text2);
$encrypted_deskripsi_koleksi = superEncrypt($deskripsi_koleksi, (int)$key_for_text1, $key_for_text2);

// Directory paths
$encoded_images_dir = "encoded_images/";
$encoded_files_dir = "encoded_files/";

// Ensure directories exist
if (!is_dir($encoded_images_dir)) {
    mkdir($encoded_images_dir, 0755, true);
}
if (!is_dir($encoded_files_dir)) {
    mkdir($encoded_files_dir, 0755, true);
}

// Process image
$original_image_name = $_FILES['gambar_koleksi']['name'];
$image_path = $_FILES['gambar_koleksi']['tmp_name'];
$encoded_image_path = lsbEncrypt($image_path, $deskripsi_koleksi); // Encoding the message in the image
$encoded_image_name = pathinfo($original_image_name, PATHINFO_FILENAME) . "_encoded.png";

// Move encoded image
rename($encoded_image_path, $encoded_images_dir . $encoded_image_name);

// Process file
$original_file_name = $_FILES['dokumen']['name'];
$encoded_file_name = null;
if (isset($_FILES['dokumen']) && $_FILES['dokumen']['error'] == 0) {
    $fileContent = file_get_contents($_FILES['dokumen']['tmp_name']);
    $encrypted_file = aesEncrypt($fileContent, $key_for_file);
    $encoded_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . "_encoded." . pathinfo($original_file_name, PATHINFO_EXTENSION);
    file_put_contents($encoded_files_dir . $encoded_file_name, $encrypted_file);
}

// Insert encrypted data into the database
$query = "INSERT INTO data_museum 
          (nama_koleksi, deskripsi_koleksi, asal_koleksi, tahun_ditemukan, kondisi_koleksi, kategori_koleksi, nama_penemu, gambar_koleksi, nama_gambar_asli, nama_gambar_encoded, dokumen, nama_file_asli, nama_file_encoded) 
          VALUES 
          ('$encrypted_nama_koleksi', '$encrypted_deskripsi_koleksi', '$asal_koleksi', '$tahun_ditemukan', '$kondisi_koleksi', '$kategori_koleksi', '$nama_penemu', '$encoded_images_dir$encoded_image_name', '$original_image_name', '$encoded_image_name', '$encoded_files_dir$encoded_file_name', '$original_file_name', '$encoded_file_name')";

$result = mysqli_query($connect, $query);

// Check if insert was successful
if ($result) {
    header("Location: home_page.php?pesan=input_data_sukses");
} else {
    echo "Error: " . mysqli_error($connect);
}
?>
