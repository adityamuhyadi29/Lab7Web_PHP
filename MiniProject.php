
<?php
// ===============================
// BAGIAN PEMROSESAN DATA
// ===============================

$data = null;
$error = [];

$nama = "";
$nim = "";
$prodi = "";
$semesterInput = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Mengambil data dari form
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    // Validasi nama
    if ($nama === "") {
        $error[] = "Nama wajib diisi.";
    }

    // Validasi NIM
    if ($nim === "") {
        $error[] = "NIM wajib diisi.";
    }

    // Validasi program studi
    if ($prodi === "") {
        $error[] = "Program studi wajib diisi.";
    }

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }

    // Validasi semester
    if (
        !ctype_digit((string)$semesterInput) ||
        (int)$semesterInput < 1 ||
        (int)$semesterInput > 14
    ) {
        $error[] = "Semester harus berupa angka 1-14.";
    }

    // Jika tidak ada error, simpan data
    if (!$error) {
        $data = compact("nama", "nim", "prodi", "email");
        $data["semester"] = (int)$semesterInput;
    }
}

// Fungsi untuk mengamankan output
function aman($teks) {
    return htmlspecialchars(
        (string)$teks,
        ENT_QUOTES,
        "UTF-8"
    );
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa</title>
</head>

<body>

    <h2>Formulir Data Mahasiswa</h2>

    <!-- FORM INPUT DATA -->
    <form method="POST" action="">

        <label>Nama:</label><br>
        <input type="text" name="nama"
            value="<?= aman($nama) ?>">
        <br><br>

        <label>NIM:</label><br>
        <input type="text" name="nim"
            value="<?= aman($nim) ?>">
        <br><br>

        <label>Program Studi:</label><br>
        <input type="text" name="prodi"
            value="<?= aman($prodi) ?>">
        <br><br>

        <label>Semester:</label><br>
        <input type="number" name="semester"
            value="<?= aman($semesterInput) ?>">
        <br><br>

        <label>Email:</label><br>
        <input type="text" name="email"
            value="<?= aman($email) ?>">
        <br><br>

        <button type="submit">Kirim Data</button>

    </form>

    <hr>

    <!-- BAGIAN MENAMPILKAN ERROR -->
    <?php if (!empty($error)): ?>

        <h3>Terjadi Kesalahan:</h3>

        <?php foreach ($error as $pesan): ?>
            <p style="color: red;">
                <?= aman($pesan) ?>
            </p>
        <?php endforeach; ?>

    <?php endif; ?>

    <!-- BAGIAN MENAMPILKAN HASIL -->
    <?php if ($data !== null): ?>

        <h3>Ringkasan Data Mahasiswa</h3>

        <p>Nama: <?= aman($data["nama"]) ?></p>
        <p>NIM: <?= aman($data["nim"]) ?></p>
        <p>Program Studi: <?= aman($data["prodi"]) ?></p>
        <p>Semester: <?= aman($data["semester"]) ?></p>
        <p>Email: <?= aman($data["email"]) ?></p>

        <p style="color: green;">
            Data mahasiswa berhasil dikirim!
        </p>

    <?php endif; ?>

</body>
</html>
