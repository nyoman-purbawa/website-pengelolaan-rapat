<?php

require_once('./../../assets/vendor/autoload.php');

$id = $_GET["id"];
$kode = $_SERVER['DOCUMENT_ROOT'] . "form-absen.php?id=" . $id;

require_once('./../../assets/vendor/qrcode/qrlib.php');

QRcode::png($kode, "absensi.png", "M", 5, 5);

$mpdf = new \Mpdf\Mpdf();

// Menambahkan CSS untuk memposisikan gambar di tengah halaman


$mpdf->WriteHTML(
    '
<div style="text-align: center; ">
    <img src="absensi.png" width="600px" alt="">
</div>'
);

$mpdf->Output();
