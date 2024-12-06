<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit(); // Menghentikan eksekusi skrip setelah redirect
}

class FileUploader
{
    private $mysqli;
    private $targetDirectory;
    private $allowedTypes;

    function __construct($conn, $targetDirectory, $allowedTypes)
    {
        $this->mysqli = $conn;
        $this->targetDirectory = $targetDirectory;
        $this->allowedTypes = $allowedTypes;
    }

    public function uploadFile($file, $rapatname, $rapatdate)
    {
        if ($file["error"] == 0) {
            $fileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

            // Check if the file type is allowed
            if (!in_array($fileType, $this->allowedTypes)) {
                return "Sorry, only " . implode(", ", $this->allowedTypes) . " files are allowed.";
            }

            // Generate a unique name for the file
            $uniqueName = bin2hex(random_bytes(8)) . '.' . $fileType;
            $targetFile = $this->targetDirectory . $uniqueName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                // Prepare file information for database insertion
                $filename = $uniqueName;
                $filesize = $file["size"];
                $filetype = $file["type"];

                try {
                    // Insert file information into the database
                    $stmt = $this->mysqli->prepare("INSERT INTO notulen_upload_download (nama_rapat, tanggal_rapat, filename, filesize, filetype) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssds", $rapatname, $rapatdate, $filename, $filesize, $filetype);
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {
                        echo '
                        <div class="container m-4">
                            <div class="alert alert-dismissible alert-success">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>Success!</strong> Data Berhasil Di Tambahkan.
                            </div>
                        </div>';
                    } else {
                        return "Failed to insert data into the database.";
                    }
                } catch (mysqli_sql_exception $e) {
                    return "Sorry, there was an error uploading your file and storing information in the database: " . $e->getMessage();
                }
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        } else {
            return "No file was uploaded.";
        }
    }
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_rapat_information";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Usage example
$targetDirectory = "./../../assets/upload/";
$allowedTypes = array(
    "jpg", "jpeg", "png", "gif", // image files
    "pdf",                       // PDF files
    "doc", "docx",               // Word documents
    "xls", "xlsx",               // Excel spreadsheets
    "ppt", "pptx",               // PowerPoint presentations
    "bmp", "tiff", "svg",        // additional image files
    "txt"                        // text files
);

$uploader = new FileUploader($conn, $targetDirectory, $allowedTypes);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $rapatname = $_POST['rapatname'];
    $rapatdate = $_POST['rapatdate'];
    echo $uploader->uploadFile($_FILES["file"], $rapatname, $rapatdate);
}

// Close the database connection
$conn->close();





?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Upload Notulen</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Upload Notulen</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Create Rapat
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputText">Nama Rapat</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-edit"></i></span>
                                </div>
                                <input type="text" id="inputText" class="form-control" name="rapatname" placeholder="Nama Rapat" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDate">Tanggal Dilaksanakan</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="inputDate" class="form-control" name="rapatdate" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDate">Upload Berkas</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="middle-name" name="file">
                                <label class="custom-file-label" for="middle-name">Pilih file</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Absensi</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <table id="example1" class="table table-bordered ">
                <thead>
                    <tr>
                        <th>Nama Rapat</th>
                        <th>Tanggal Rapat</th>
                        <th>Aksi</th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($result)) {
                        foreach ($result as $row) :
                            $file_path = "./../../assets/upload/" . $row['filename'];
                    ?>
                            <tr>
                                <td><?= $row["nama_rapat"] ?></td>
                                <td><?= $row["tanggal_rapat"] ?></td>
                                <td class="text-center">
                                    <a href="<?php echo $file_path; ?>" class="btn btn-success btn-sm">Download</a>
                                    <a href="./../../config/models/hapus_upload_notulen.php?id=<?= $row["id_notulen"] ?>" class="btn btn-danger btn-sm">Hapus</a>

                                </td>

                            </tr>
                    <?php
                        endforeach;
                    } else {
                        // Penanganan jika $rows tidak memiliki nilai yang valid
                        // Misalnya, tampilkan pesan bahwa tidak ada data yang ditemukan
                        echo "<tr><td colspan='4'>Tidak ada data yang ditemukan.</td></tr>";
                    }
                    ?>


                </tbody>
                <tfoot>
                    <tr>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>TTD</th>

                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>