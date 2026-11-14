
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

$nilai1 = "";
$nilai2 = "";
$nilai3 = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Mengambil data dari form
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    $nilai1 = $_POST["nilai1"] ?? "";
    $nilai2 = $_POST["nilai2"] ?? "";
    $nilai3 = $_POST["nilai3"] ?? "";

    // Validasi nama
    if ($nama === "") {
        $error[] = "Nama wajib diisi.";
    }

    // Validasi NIM
    if (!preg_match("/^[0-9]{10}$/", $nim)) {
        $error[] = "NIM harus berupa 10 angka.";
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

    // Validasi komponen nilai
    $daftarNilai = [$nilai1, $nilai2, $nilai3];

    foreach ($daftarNilai as $nilai) {

        if (
            $nilai === "" ||
            !is_numeric($nilai) ||
            $nilai < 0 ||
            $nilai > 100
        ) {
            $error[] = "Setiap nilai harus berupa angka 0-100.";
            break;
        }
    }
    // Jika tidak ada error
    if (empty($error)) {

        $rataRata = (
            $nilai1 +
            $nilai2 +
            $nilai3
        ) / 3;

        $data = [
            "nama" => $nama,
            "nim" => $nim,
            "prodi" => $prodi,
            "semester" => (int)$semesterInput,
            "email" => $email,
            "nilai1" => $nilai1,
            "nilai2" => $nilai2,
            "nilai3" => $nilai3,
            "rataRata" => $rataRata
        ];
    }
}

// Fungsi untuk format rupiah
function formatRupiah($harga) {
    return "Rp " . number_format(
        $harga,
        0,
        ",",
        "."
    );
}
// Fungsi untuk mengamankan output
function aman($teks) {
    return htmlspecialchars(
        (string)$teks,
        ENT_QUOTES,
        "UTF-8"
    );
}
// GET pencarian nama mahasiswa
$mahasiswa = [
    "Andi",
    "Budi",
    "Citra",
    "Dewi",
    "Eko"
];

$hasilCari = null;

if (isset($_GET["cari"])) {

    $kataKunci = trim($_GET["cari"]);

    foreach ($mahasiswa as $mhs) {

        if (stripos($mhs, $kataKunci) !== false) {
            $hasilCari[] = $mhs;
        }
    }

    if ($hasilCari === null) {
        $hasilCari = [];
    }
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
        <h3>Komponen Nilai</h3>
        <label>Nilai Tugas:</label><br>
    <input type="number" name="nilai1"
        min="0" max="100"
        value="<?= aman($nilai1) ?>">
    <br><br>

    <label>Nilai UTS:</label><br>
    <input type="number" name="nilai2"
        min="0" max="100"
        value="<?= aman($nilai2) ?>">
    <br><br>

    <label>Nilai UAS:</label><br>
    <input type="number" name="nilai3"
        min="0" max="100"
        value="<?= aman($nilai3) ?>">
    <br><br>
    <!-- EKSPERIMEN 5: TOMBOL RESET -->
    <button type="reset">Reset Form</button>


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

        <h3>Hasil perhitungan nilai</h3>
        <p>Nilai Tugas: <?= aman($data["nilai1"]) ?></p>
        <p>Nilai UTS: <?= aman($data["nilai2"]) ?></p>
        <p>Nilai UAS: <?= aman($data["nilai3"]) ?></p>

        <p>Rata-rata:<b><?= number_format($data["rataRata"], 2) ?></b></p>

        <p style="color: green;">
            Data mahasiswa berhasil dikirim!
        </p>

        <h3>Contoh format harga</h3>
        <p>Harga: <?= formatRupiah(1500000) ?></p>

    <?php endif; ?>

    <hr>

<!-- EKSPERIMEN GET: PENCARIAN NAMA -->

<h2>Pencarian Nama Mahasiswa</h2>

<form method="GET" action="">

    <label>Masukkan nama:</label><br>

    <input type="text" name="cari"
        value="<?= aman($_GET["cari"] ?? "") ?>">

    <button type="submit">Cari</button>

</form>

<?php if ($hasilCari !== null): ?>

    <h3>Hasil Pencarian:</h3>

    <?php if (count($hasilCari) > 0): ?>

        <?php foreach ($hasilCari as $namaHasil): ?>

            <p><?= aman($namaHasil) ?></p>

        <?php endforeach; ?>

    <?php else: ?>

        <p style="color:red;">
            Nama tidak ditemukan.
        </p>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>
