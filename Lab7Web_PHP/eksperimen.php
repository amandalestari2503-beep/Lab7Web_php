<?php
// 3. Function format Rupiah
function rupiah($angka) {
    return "Rp" . number_format($angka, 0, ",", ".");
}

// 1. Rata-rata tiga komponen nilai
$tugas = 85; $uts = 78; $uas = 90;
$rata = ($tugas + $uts + $uas) / 3;

// 2. Pencarian nama dari array lewat GET
$daftar = ["Alya", "Bima", "Citra", "Doni", "Andi"];
$kata = trim($_GET["cari"] ?? "");
$hasilCari = [];
if ($kata !== "") {
    foreach ($daftar as $nama) {
        if (stripos($nama, $kata) !== false) {
            $hasilCari[] = $nama;
        }
    }
}

// 4. Validasi NIM: angka saja, 8-10 digit
$pesanNim = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim = trim($_POST["nim"] ?? "");
    if (!ctype_digit($nim) || strlen($nim) < 8 || strlen($nim) > 10) {
        $pesanNim = "NIM harus angka, panjang 8-10 digit.";
    } else {
        $pesanNim = "NIM valid: " . htmlspecialchars($nim);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Eksperimen Mandiri</title>
</head>
<body>
    <h3>1. Rata-rata nilai</h3>
    <p>(<?= $tugas ?> + <?= $uts ?> + <?= $uas ?>) / 3 = <?= number_format($rata, 2) ?></p>

    <h3>2. Cari nama (GET)</h3>
    <form method="GET">
        <input name="cari" value="<?= htmlspecialchars($kata) ?>">
        <button type="submit">Cari</button>
    </form>
    <?php
    if ($kata !== "") {
        echo $hasilCari
            ? "Ditemukan: " . htmlspecialchars(implode(", ", $hasilCari))
            : "Tidak ditemukan.";
    }
    ?>

    <h3>3. Format Rupiah</h3>
    <p><?= rupiah(1500000) ?></p>

    <h3>4. Validasi NIM (POST)</h3>
    <form method="POST">
        <input name="nim" placeholder="NIM">
        <button type="submit">Cek</button>
        <button type="reset">Reset</button>
    </form>
    <p><?= $pesanNim ?></p>
</body>
</html>