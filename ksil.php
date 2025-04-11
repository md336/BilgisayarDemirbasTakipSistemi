<?php
// Kayıtları listeleme
$result = $conn->query("SELECT * FROM kasa");

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>ID</th><th>Kasa Demirbaş No</th><th>Çalışan Sicil</th><th>İşletim Sistemi</th><th>Marka Model</th><th>RAM</th><th>Sabit Disk</th><th>Ekran</th><th>PC Model</th><th>İşlemci Hızı</th><th>Çekirdek</th><th>Monitör Boyutu</th><th>Sil</th></tr></thead>';
    echo '<tbody>';
    while($row = $result->fetch_assoc()) {
        echo '<tr>';
        
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
        <form method="post" action="kasa.php">
            <input type="hidden" name="kasademirbasno" value="' . $row["kasademirbasno"] . '">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger btn-sm">Sil</button>
        </form>
      </td>';

        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<div class="alert alert-info" role="alert">Henüz kayıtlı donanım bulunmamaktadır.</div>';
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

$conn->close();
?>
