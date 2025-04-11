<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çalışanı Düzenle</title>
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
    <h2 class="mt-4">Çalışanı Düzenle</h2>
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

    // Düzenlenecek çalışanın ID'si
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Veritabanından ilgili çalışanın verilerini al
        $sql = "SELECT * FROM personellerveri WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form method="post" action="duzenle.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="ad">Ad:</label>
                    <input type="text" class="form-control" id="ad" name="ad" value="<?php echo $row['ad']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="soyad">Soyad:</label>
                    <input type="text" class="form-control" id="soyad" name="soyad" value="<?php echo $row['soyad']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="sicil_no">Sicil No:</label>
                    <input type="text" class="form-control" id="sicil_no" name="sicil_no" value="<?php echo $row['sicil_no']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="unvan">Ünvan:</label>
                    <input type="text" class="form-control" id="unvan" name="unvan" value="<?php echo $row['unvan']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="bolum">Bölüm:</label>
                    <input type="text" class="form-control" id="bolum" name="bolum" value="<?php echo $row['bolum']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="e_posta">E-posta:</label>
                    <input type="email" class="form-control" id="e_posta" name="e_posta" value="<?php echo $row['e_posta']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="oda_numarasi">Oda Numarası:</label>
                    <input type="text" class="form-control" id="oda_numarasi" name="oda_numarasi" value="<?php echo $row['oda_numarasi']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="ise_baslama_tarihi">İşe Başlama Tarihi:</label>
                    <input type="date" class="form-control" id="ise_baslama_tarihi" name="ise_baslama_tarihi" value="<?php echo $row['ise_baslama_tarihi']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
            </form>
            <?php
        } else {
            echo "Çalışan bulunamadı.";
        }
    }

    // Formdan gelen verileri işle
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        $id = $_POST['id'];
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $sicil_no = $_POST['sicil_no'];
        $unvan = $_POST['unvan'];
        $bolum = $_POST['bolum'];
        $e_posta = $_POST['e_posta'];
        $oda_numarasi = $_POST['oda_numarasi'];
        $ise_baslama_tarihi = $_POST['ise_baslama_tarihi'];

        // Veritabanında güncelleme işlemi yapılır
        $sql = "UPDATE personellerveri SET ad='$ad', soyad='$soyad', sicil_no='$sicil_no', unvan='$unvan', bolum='$bolum', e_posta='$e_posta', oda_numarasi='$oda_numarasi', ise_baslama_tarihi='$ise_baslama_tarihi' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Kayıt başarıyla güncellendi!";
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
    ?>
</div>

<form method="post" action="personel.php">
    <button type="submit" class="btn btn-primary mt-3 float-right">Personel Bilgilerine Dön</button>
</form>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
