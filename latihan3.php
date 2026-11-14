<?php
$mahasiswa = ["Alya", "Bima", "Citra", "Doni", "Eka", "Fajar", "Gita", "Hadi", "Indra", "Joko"];
echo "<h3>Daftar Mahasiswa</h3><lo>";
foreach ($mahasiswa as $nama) {
    echo "<li>" . htmlspecialchars($nama) . "</li>";
}
echo "</lo>"
?>