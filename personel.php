<?php include('session_check.php'); ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çalışan Bilgi Formu</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Hafif gri tonu */
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mt-4">Çalışan Bilgi Formu</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="ad">Ad:</label>
            <input type="text" class="form-control" id="ad" name="ad" required>
        </div>
        <div class="form-group">
            <label for="soyad">Soyad:</label>
            <input type="text" class="form-control" id="soyad" name="soyad" required>
        </div>
        <div class="form-group">
            <label for="sicil_no">Sicil No:</label>
            <input type="text" class="form-control" id="sicil_no" name="sicil_no" required>
        </div>
        <div class="form-group">
            <label for="unvan">Ünvan:</label>
            <input type="text" class="form-control" id="unvan" name="unvan" required>
        </div>
        <div class="form-group">
            <label for="bolum">Bölüm:</label>
            <input type="text" class="form-control" id="bolum" name="bolum" required>
        </div>
        <div class="form-group">
            <label for="e_posta">E-posta:</label>
            <input type="email" class="form-control" id="e_posta" name="e_posta" required>
        </div>
        <div class="form-group">
            <label for="oda_numarasi">Oda Numarası:</label>
            <input type="text" class="form-control" id="oda_numarasi" name="oda_numarasi" required>
        </div>
        <div class="form-group">
            <label for="ise_baslama_tarihi">İşe Başlama Tarihi:</label>
            <input type="date" class="form-control" id="ise_baslama_tarihi" name="ise_baslama_tarihi" required>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>

    <hr>

    <h2 class="mt-4">Kaydedilen Çalışanlar</h2>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Sicil No</th>
            <th>Ünvan</th>
            <th>Bölüm</th>
            <th>E-posta</th>
            <th>Oda Numarası</th>
            <th>İşe Başlama Tarihi</th>
            <th>İşlem</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // Veritabanı bağlantısı kurulur
    $servername = "localhost";
    $username = "muhammed";
    $password = "12345";
    $database = "personeller";

    $conn = new mysqli($servername, $username, $password, $database);

    // Bağlantı kontrol edilir
    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Kaydedilen çalışanları sorgula
    $sql = "SELECT * FROM personellerveri";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['ad'] . "</td>";
            echo "<td>" . $row['soyad'] . "</td>";
            echo "<td>" . $row['sicil_no'] . "</td>";
            echo "<td>" . $row['unvan'] . "</td>";
            echo "<td>" . $row['bolum'] . "</td>";
            echo "<td>" . $row['e_posta'] . "</td>";
            echo "<td>" . $row['oda_numarasi'] . "</td>";
            echo "<td>" . $row['ise_baslama_tarihi'] . "</td>";
            echo "<td>
                    <a href='duzenle.php?id=" . $row['id'] . "' class='btn btn-primary'>Düzenle</a>
                    <a href='sil.php?id=" . $row['id'] . "' class='btn btn-danger' onclick=\"return confirm('Bu kaydı silmek istediğinizden emin misiniz?')\">Sil</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='9'>Kaydedilen çalışan bulunamadı.</td></tr>";
    }
    $conn->close();
    ?>
    </tbody>
</table>

</div>

<div style="position: fixed; top: 10px; right: 10px;">
    <a href="donanım.php" class="btn btn-primary">Donanım</a>
</div>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>






<?php
// Veritabanı bağlantısı kurulur
$servername = "localhost";
$username = "muhammed";
$password = "12345";
$database = "personeller";

$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrol edilir
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Formdan gelen verileri işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $sicil_no = $_POST['sicil_no'];
    $unvan = $_POST['unvan'];
    $bolum = $_POST['bolum'];
    $e_posta = $_POST['e_posta'];
    $oda_numarasi = $_POST['oda_numarasi'];
    $ise_baslama_tarihi = $_POST['ise_baslama_tarihi'];

    // Veritabanına veri eklenir
    $sql = "INSERT INTO personellerveri (ad, soyad, sicil_no, unvan, bolum, e_posta, oda_numarasi, ise_baslama_tarihi)
    VALUES ('$ad', '$soyad', '$sicil_no', '$unvan', '$bolum', '$e_posta', '$oda_numarasi', '$ise_baslama_tarihi')";

    if ($conn->query($sql) === TRUE) {
        echo "Kayıt başarıyla eklendi!";
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>



</body>
</html>
