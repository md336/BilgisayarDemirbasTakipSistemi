<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Veritabanı bağlantısı kurulur
$servername = "localhost";
$username = "donanım";
$password = "12345";
$database = "donanım";

$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrol edilir
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['donanım_id'])) {
    $donanim_id = $_POST['donanım_id'];

    // Silme işlemi gerçekleştirilir
    $sql = "DELETE FROM donanım WHERE id = $donanım_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Kayıt başarıyla silindi!";
    } else {
        $_SESSION['message'] = "Hata: " . $conn->error;
    }

    $conn->close();
    header("Location: donanım.php");
    exit();
} else {
    header("Location: donanım.php");
    exit();
}
?>
