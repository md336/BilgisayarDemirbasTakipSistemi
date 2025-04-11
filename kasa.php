
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasa Bilgileri</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
<div class="col text-right mt-3">
<a href="personel.php" class="btn btn-primary">Personel Bilgilerine Git</a>
            <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
        </div>
    <h2 class="mt-4">Kasa Bilgilerini Gir</h2>
    <?php
// Veritabanı bağlantısı
$servername = "localhost";
$username = "root"; // Veritabanı kullanıcı adınızı girin
$password = ""; // Veritabanı şifrenizi girin
$database = "kasa"; // Veritabanı adınızı girin

$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Form verileri kaydedildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $kasademirbasno = $_POST['kasademirbasno'];
    $calisansicil = $_POST['calisansicil'];
    $isletim = $_POST['isletim'];
    $marka_model = $_POST['marka_model'];
    $ram = $_POST['ram'];
    $sabit_disk = $_POST['sabit_disk'];
    $ekran = $_POST['ekran'];
    $pc_model = $_POST['pc_model'];
    $islemci_hizi = $_POST['islemci_hizi'];
    $cekirdek = $_POST['cekirdek'];
    $monitör_boyutu = $_POST['monitor_boyutu']; // Değişken adını 'monitor_boyutu' olarak güncelledim

    // Veritabanına ekleme sorgusu
    $stmt = $conn->prepare("INSERT INTO kasa (kasademirbasno, calisansicil, isletim, marka_model, ram, sabit_disk, ekran, pc_model, islemci_hizi, cekirdek, monitor_boyutu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssis", $kasademirbasno, $calisansicil, $isletim, $marka_model, $ram, $sabit_disk, $ekran, $pc_model, $islemci_hizi, $cekirdek, $monitör_boyutu); // Değişken adını 'monitor_boyutu' olarak güncelledim

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Kayıt başarıyla eklendi!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Hata: ' . $stmt->error . '</div>';
    }

    $stmt->close();
}


// Silme işlemi gerçekleştirildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['kasademirbasno'])) {
    $kasademirbasno = $_POST['kasademirbasno'];

    // Silme sorgusu
    $stmt = $conn->prepare("DELETE FROM kasa WHERE kasademirbasno = ?");
    $stmt->bind_param("s", $kasademirbasno);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Kayıt başarıyla silindi!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Hata: ' . $stmt->error . '</div>';
    }

    $stmt->close();
}

?>

    <!-- Form -->
    <form method="post" action="">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
            <label for="kasademirbasno">Kasa Demirbaş No:</label>
            <input type="text" class="form-control" id="kasademirbasno" name="kasademirbasno" required>
        </div>
        <div class="form-group">
            <label for="calisansicil">Çalışan Sicil:</label>
            <input type="text" class="form-control" id="calisansicil" name="calisansicil" required>
        </div>
        <div class="form-group">
            <label for="isletim">İşletim Sistemi:</label>
            <input type="text" class="form-control" id="isletim" name="isletim" required>
        </div>
        <div class="form-group">
            <label for="marka_model">Marka Model:</label>
            <input type="text" class="form-control" id="marka_model" name="marka_model" required>
        </div>
        <div class="form-group">
            <label for="ram">RAM:</label>
            <input type="text" class="form-control" id="ram" name="ram" required>
        </div>
        <div class="form-group">
            <label for="sabit_disk">Sabit Disk:</label>
            <input type="text" class="form-control" id="sabit_disk" name="sabit_disk" required>
        </div>
        <div class="form-group">
            <label for="ekran">Ekran:</label>
            <input type="text" class="form-control" id="ekran" name="ekran" required>
        </div>
        <div class="form-group">
            <label for="pc_model">PC Model:</label>
            <input type="text" class="form-control" id="pc_model" name="pc_model" required>
        </div>
        <div class="form-group">
            <label for="islemci_hizi">İşlemci Hızı:</label>
            <input type="text" class="form-control" id="islemci_hizi" name="islemci_hizi" required>
        </div>
        <div class="form-group">
            <label for="cekirdek">Çekirdek:</label>
            <input type="number" class="form-control" id="cekirdek" name="cekirdek" required>
        </div>
        <div class="form-group">
            <label for="monitor_boyutu">Monitör Boyutu:</label>
            <input type="text" class="form-control" id="monitor_boyutu" name="monitor_boyutu" required>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>

    <h2 class="mt-4">Kayıtlı Kasa Bilgileri</h2>
    <?php
    // Kayıtları listeleme
    $result = $conn->query("SELECT * FROM kasa");

    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>ID</th><th>Kasa Demirbaş No</th><th>Çalışan Sicil</th><th>İşletim Sistemi</th><th>Marka Model</th><th>RAM</th><th>Sabit Disk</th><th>Ekran</th><th>PC Model</th><th>İşlemci Hızı</th><th>Çekirdek</th><th>Monitör Boyutu</th><th>Sil</th></tr></thead>';
        echo '<tbody>';
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            if (isset($row["id"])) {
                echo '<td>' . $row["id"] . '</td>';
            } else {
                echo '<td>---</td>'; // ID tanımlı değilse, yerine '---' yazdır
            }
            echo '<td>' . $row["kasademirbasno"] . '</td>';
            echo '<td>' . $row["calisansicil"] . '</td>';
            echo '<td>' . $row["isletim"] . '</td>';
            echo '<td>' . $row["marka_model"] . '</td>';
            echo '<td>' . $row["ram"] . '</td>';
            echo '<td>' . $row["sabit_disk"] . '</td>';
            echo '<td>' . $row["ekran"] . '</td>';
            echo '<td>' . $row["pc_model"] . '</td>';
            echo '<td>' . $row["islemci_hizi"] . '</td>';
            echo '<td>' . $row["cekirdek"] . '</td>';
            echo '<td>' . $row["monitor_boyutu"] . '</td>'; 
        
            echo '<td>
            <form method="post" action="">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="kasademirbasno" value="' . $row["kasademirbasno"] . '">
    <button type="submit" class="btn btn-danger btn-sm">Sil</button>
</form>

          </td>';
    


            echo '</tr>';
        }
        
        echo '</tbody></table>';
    } else {
        echo '<div class="alert alert-info" role="alert">Henüz kayıtlı donanım bulunmamaktadır.</div>';
    }

    $conn->close();
    ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
