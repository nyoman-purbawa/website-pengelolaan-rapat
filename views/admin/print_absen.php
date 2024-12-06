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

// Custom CSS untuk format table
$stylesheet = '
body {
    font-family: Arial, sans-serif;
}
.table { width: 100%; border-collapse: collapse; }
.table th, .table td { padding: 8px; border: 1px solid #ccc; }
';

// Memulai pembuatan konten HTML
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>PDF Report</title>
    <style>' . $stylesheet . '</style>
</head>
<body>

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
                        <td style="text-align: center;"><img src="' . $ttdPath . '" width="100" alt="Signature"></td>
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
