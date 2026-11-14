<?php
function hitungDiskon($harga, $persen) {
    $potongan = $harga * ($persen / 100);
    return $harga - $potongan;
}
$hargaAkhir = hitungDiskon(150000, 10);
echo "Harga setelah diskon: RP" . number_format($hargaAkhir, 0, ",", ".");

function hitungLuasPersegiPanjang($panjang, $lebar) {
    return $panjang * $lebar;
}
$luas = hitungLuasPersegiPanjang(10, 5);
echo "Luas persegi panjang: " . $luas;

?>