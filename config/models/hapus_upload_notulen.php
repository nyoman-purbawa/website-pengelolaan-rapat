<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rapat_information";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT * FROM notulen_upload_download";
$result = $conn->query($sql);


// Hapus Data 
// Hapus Data 
// Hapus Data 


// Hapus Data 
if (!empty($_GET["id"])) {
    $id = $_GET['id'];

    // Membuat query untuk mengambil nama file berdasarkan id
    $sql_select = "SELECT filename FROM notulen_upload_download WHERE id_notulen = '$id'";
    $result_select = $conn->query($sql_select);

    if ($result_select && $result_select->num_rows > 0) {
        $row = $result_select->fetch_assoc();
        $filename = $row['filename'];

        // Hapus file dari direktori
        $file_path = "../../assets/upload/" . $filename;
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Membuat query untuk menghapus data berdasarkan id
        $sql_delete = "DELETE FROM notulen_upload_download WHERE id_notulen = '$id'";

        // Menjalankan query
        if ($conn->query($sql_delete) === TRUE) {
            header("Location: ../../views/admin/index.php?page=uplaod-notulen"); // Redirect ke halaman index.php
            exit(); // Untuk menghentikan eksekusi script selanjutnya.
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        return false;
    }
}
