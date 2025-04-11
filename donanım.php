
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donanım Bilgi Formu</title>
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
    <h2 class="mt-4">Donanım Bilgi Formu</h2>
    <div class="row">
        <div class="col text-right mb-3">
            <a href="kasa.php" class="btn btn-danger">Kasa Bilgileri</a> <!-- Kasa Bilgileri sayfasına yönlendiren düğme -->
        </div>
    </div>

    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="marka">Marka:</label>
            <input type="text" class="form-control" id="marka" name="marka" required>
        </div>
        <div class="form-group">
            <label for="model">Model:</label>
            <input type="text" class="form-control" id="model" name="model" required>
        </div>
        <div class="form-group">
            <label for="aciklama">Açıklama:</label>
            <input type="text" class="form-control" id="aciklama" name="aciklama" required>
        </div>
        <div class="form-group">
            <label for="verildigitarih">Verildiği Tarih:</label>
            <input type="date" class="form-control" id="verildigitarih" name="verildigitarih" required>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
    </form>


    <hr>

    <h2 class="mt-4">Kaydedilen Donanımlar</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Marka</th>
                <th>Model</th>
                <th>Açıklama</th>
                <th>Verildiği Tarih</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php
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

            // Kaydedilen donanım bilgilerini sorgula
            $sql = "SELECT * FROM donanım";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['marka'] . "</td>";
                    echo "<td>" . $row['model'] . "</td>";
                    echo "<td>" . $row['aciklama'] . "</td>";
                    echo "<td>" . $row['verildigitarih'] . "</td>";
                    echo "<td>
                    <form method='post' action='dsil.php'>
                        <input type='hidden' name='donanim_id' value='" . $row['id'] . "'>
                        <button type='submit' class='btn btn-danger' onclick=\"return confirm('Bu kaydı silmek istediğinizden emin misiniz?')\">Sil</button>
                    </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Kaydedilen donanım bulunamadı.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- Diğer kodlar buraya gelecek -->

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php
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

// Formdan gelen verileri işle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marka = $_POST['marka'];
    $model = $_POST['model'];
    $aciklama = $_POST['aciklama'];
    $verildigitarih = $_POST['verildigitarih'];

    // Veritabanına veri eklenir
    $sql = "INSERT INTO donanım (marka, model, aciklama, verildigitarih)
    VALUES ('$marka', '$model', '$aciklama', '$verildigitarih')";

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
