<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit();
}

$id_not_found = '';

if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    $db = new Absen($conn);
    $rows = $db->tampilkan_absen($id);
    $db->tambah_rekap($_POST, $id);

    $data_rekap_rapat = new RekapRapat($conn);
    $show_rekap = $data_rekap_rapat->tampilkan_rekap($id);
} else {
    $id_not_found = '
    <div class="container m-4">
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Info!</strong> ID Dari halaman ini tidak ditemukan, Silakan Login Ulang.
        </div>
    </div>
    ';
}



$host = "localhost";
$user = "root";
$pass = "";
$database = "db_rapat_information";

$koneksi = mysqli_connect($host, $user, $pass, $database);

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    $data_rekap_rapat = new RekapRapat($conn);
    $show_rekap = $data_rekap_rapat->edit_rekap($id);

    if (isset($_POST['submit'])) {
        $newDescRekap = $_POST['rekap-rapat'];

        // Panggil fungsi update_rekap dari objek $data_rekap_rapat
        $updateSuccess = $data_rekap_rapat->update_rekap($id, $newDescRekap);

        if ($updateSuccess) {
            echo "
            <script>
                Swal.fire({
                    text: 'Data Berhadil Di Edit',
                    type: 'success',
                    icon: 'success',
                });

                setTimeout(function(){
                    window.location.href = 'index.php?page=detail-rapat&id=' + $id;
                }, 1000);
            </script>
            ";
            exit();
        } else {
            echo "<script>alert('Gagal melakukan update rekap rapat');</script>";
        }
    }
}




// Menutup koneksi
mysqli_close($koneksi);





?>

<?= $id_not_found   ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Rapat</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Detail Rapat</li>
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
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Word
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <textarea id="summernote" name="rekap-rapat" style="width: 100%">
                            <?php foreach ($show_rekap as $row) : ?>
                                <?php $descRekap = htmlspecialchars_decode($row['desc_rekap']); ?>
                                <?php echo $descRekap; ?>
                            <?php endforeach; ?>
                        </textarea>
                    </div>


                    <div class=" card-footer">
                        <button name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>

        </div>
</section>