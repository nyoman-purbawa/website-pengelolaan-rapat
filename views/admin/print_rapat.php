<?php
require_once('./../../assets/vendor/autoload.php');
require_once("./../../config/autoload.php");

// Inisialisasi mPDF dengan ukuran kertas F4
$mpdf = new \Mpdf\Mpdf([
    'format' => [210, 330]
]);

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$database = "db_rapat_information";

$conn = new Database($host, $user, $pass, $database);
$id = $_GET["id"];

// Membuat objek database
$db = new Absen($conn);
$rows = $db->tampilkan_absen($id);

$data_dilaksanakan = new Rapat($conn);
$data_pelaksakaan = $data_dilaksanakan->show_rapat("SELECT * FROM tb_create_rapat WHERE id_rapat = '$id'");

$data_rekap_rapat = new RekapRapat($conn);
$show_rekap = $data_rekap_rapat->tampilkan_rekap($id);

// Custom CSS untuk format table
$stylesheet = '
body {
    font-family: Arial, sans-serif;
}
.card { margin: 10px; }
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 8px; border: 1px solid #ccc; }
.kop-laporan {
    border-bottom: 7px solid black;
    padding-top: 20px;
    margin: 0 auto 1rem auto;
    color: black;
    width: 100%;
}

.tengah {
    text-align: center;
    font-size: 12pt;
}
.bold {
    font-weight: bold;
}
';

// Path gambar kop surat
$kopImagePath = $_SERVER['DOCUMENT_ROOT'] . '/website_sd_n_mI403/assets/img/logo.jpg';

// Memulai pembuatan konten HTML
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>PDF Report</title>
    <style>' . $stylesheet . '</style>
</head>
<body>

<table class="kop-laporan">
<tr>
    <td style="width: 20%;">
        <img src="' . $kopImagePath . '" width="100" alt="kop">
    </td>
    <td class="tengah" style="width: 80%;">
        <p class="bold">PEMERINTAH KOTA SURABAYA</p>
        <p class="bold">DINAS PENDIDIKAN</p>
        <p class="bold">SEKOLAH DASAR NEGERI MARGOREJO I No. 403</p>
        <p class="bold">STATUS AKREDITASI : "A"</p>
        <p>Jl. Margorejo No. 4 Kecamatan Wonocolo; Telp. 031-8430745</p>
        <p>E-mail: sdnmarsatiadatanding@gmail.com; NPSN 20533209</p>
        <p>Surabaya - 60238</p>
    </td>
</tr>
</table> 

<div class="data-dilaksanakan">';

foreach ($data_pelaksakaan as $row) :
    $html .= '
    <p><strong>Perihal :</strong> ' . $row['nama_rapat'] . '</p>
    <p><strong>Pukul   :</strong> ' . $row['jam_mulai'] . ' - ' . $row['jam_selesai'] . '</p>
    <p><strong>Tanggal :</strong> ' . $row['tgl_rapat'] . '</p>
    <p><strong>Tempat  :</strong> ' . $row['ruang_rapat'] . '</p>
    ';
endforeach;
$html .= '
</div>

<div class="dsc-rekap">';

foreach ($show_rekap as $row) :
    $descRekap = htmlspecialchars_decode($row['desc_rekap']);
    $html .= '<p>' . $descRekap . '</p>';
endforeach;

$html .= '
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>TTD</th>
                    </tr>
                </thead>
                <tbody>';

// Mengisi data ke dalam tabel
foreach ($rows as $row) {
    $ttdPath = $_SERVER['DOCUMENT_ROOT'] . '/website_sd_n_mI403/' . $row['gambar_ttd'];
    $html .= '
                    <tr>
                        <td>' . $row['nama_absen'] . '</td>
                        <td>' . $row['category_absen'] . '</td>
                        <td style="text-align: center;"><img src="' . $ttdPath . '" width="100" alt="gambar tidak ditemukan"></td>
                    </tr>';
}

$html .= '
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>

</html>';

// Menambahkan konten HTML ke dokumen mPDF
$mpdf->WriteHTML($html);

// Output dokumen PDF ke browser
$mpdf->Output();
