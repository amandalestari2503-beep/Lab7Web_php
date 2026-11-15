<?php
// ===== BAGIAN PEMROSESAN =====
$data = null;
$error = [];
$nama = $nim = $prodi = $semesterInput = $email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    if ($nama === "") $error[] = "Nama wajib diisi.";
    if ($nim === "") $error[] = "NIM wajib diisi.";
    if ($prodi === "") $error[] = "Program studi wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }
    if (!ctype_digit((string)$semesterInput) ||
        (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa angka 1–14.";
    }

    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }
}

function e($teks) {
    return htmlspecialchars($teks, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Data Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 480px; margin: 30px auto; }
        label { display: block; margin-top: 10px; }
        input { width: 100%; padding: 6px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 8px 16px; }
        .error { background: #fdd; border: 1px solid #c00; padding: 10px; margin-top: 15px; }
        .sukses { background: #dfd; border: 1px solid #0a0; padding: 10px; margin-top: 15px; }
    </style>
</head>
<body>
    <h2>Form Data Mahasiswa</h2>

    <form method="POST" action="">
        <label>Nama
            <input type="text" name="nama" value="<?= e($nama) ?>">
        </label>
        <label>NIM
            <input type="text" name="nim" value="<?= e($nim) ?>">
        </label>
        <label>Program Studi
            <input type="text" name="prodi" value="<?= e($prodi) ?>">
        </label>
        <label>Semester (1–14)
            <input type="text" name="semester" value="<?= e((string)$semesterInput) ?>">
        </label>
        <label>Email
            <input type="text" name="email" value="<?= e($email) ?>">
        </label>
        <button type="submit">Kirim</button>
    </form>

    <?php if ($error): ?>
        <div class="error">
            <strong>Terdapat kesalahan:</strong>
            <ul>
                <?php foreach ($error as $pesan): ?>
                    <li><?= e($pesan) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($data): ?>
        <div class="sukses">
            <h3>Ringkasan Data Mahasiswa</h3>
            <p>Nama: <?= e($data["nama"]) ?></p>
            <p>NIM: <?= e($data["nim"]) ?></p>
            <p>Program Studi: <?= e($data["prodi"]) ?></p>
            <p>Semester: <?= $data["semester"] ?></p>
            <p>Email: <?= e($data["email"]) ?></p>
        </div>
    <?php endif; ?>
</body>
</html>