<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit(); // Menghentikan eksekusi skrip setelah redirect
}


$rapat_data = new Rapat($conn);
$id = $_GET['id'] ?? null;

$rows = $rapat_data->show_rapat("SELECT * FROM tb_create_rapat ORDER BY id_rapat DESC ");

$rapat_data->hapus_rapat($id);

$servername = "localhost";
$hostname = "root";
$password = "";
$database = "db_rapat_information";

$connection = mysqli_connect($servername, $hostname, $password, $database);

$totalRapat = mysqli_query($connection, "SELECT * FROM tb_create_rapat");
$countRapat = mysqli_num_rows($totalRapat);

$totalNotulen = mysqli_query($connection, "SELECT * FROM notulen_upload_download");
$countNotulen = mysqli_num_rows($totalNotulen);

$totalAbsen = mysqli_query($connection, "SELECT * FROM tb_absen");
$countAbsen = mysqli_num_rows($totalAbsen);

?>



<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
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
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-bar"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Rapat</span>
                        <span class="info-box-number">
                            <?= $countRapat ?>

                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-file"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Notulen</span>
                        <span class="info-box-number"><?= $countNotulen ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Absensi</span>
                        <span class="info-box-number"><?= $countAbsen ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.row -->

        <!-- Main row -->
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($rows as $row) : ?>
                    <div class="col-md-3">
                        <div class="card mb-3">
                            <img src="./../../assets/upload/<?= $row["gambar_rapat"]; ?>" class="card-img-top " height="200px" alt="gambar">
                            <div class="card-body">
                                <h5 class="mb-4"><?= $row["nama_rapat"] ?></h5>
                                <ul style="list-style: none; margin: 0; padding: 0; ;">
                                    <li class="mb-2"><i class="fas fa-calendar"></i> <?= $row["tgl_rapat"] ?></li>
                                    <li class="mb-2"><i class="fas fa-clock"></i> <?= $row["jam_mulai"] ?> - </i>
                                        <?= $row["jam_selesai"] ?>
                                    </li>
                                    <li class="mb-2"><i class="fas fa-map"></i> <?= $row["ruangan_rapat"] ?></li>
                                </ul>
                                <a href="?page=detail-rapat&id=<?= $row["id_rapat"]; ?>" class="btn btn-primary mr-2 mb-2" style="width: 100%;">Detail</a>
                                <button type="button" class="btn btn-danger hapus-button" data-id="<?= $row["id_rapat"]; ?>" data-toggle="modal" data-target="#hapusModal" style="width: 100%;">Hapus</button>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Hapus Start -->
        <!-- Tambahkan elemen modal -->
        <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="hapusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus rapat ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a id="hapusLink" href="#" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hapus End -->

        <!-- /.row -->
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->