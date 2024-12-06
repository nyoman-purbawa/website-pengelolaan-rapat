<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit(); // Menghentikan eksekusi skrip setelah redirect
}

$db = new Rapat($conn);

$db->tambah_rapat($_POST);



?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Rapat</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Create Rapat</li>
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
                                <input type="text" id="inputText" class="form-control" name="nama-rapat" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDate">Tanggal Dilaksanakan</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" id="inputDate" class="form-control" name="tanggal-dilaksanakan" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputTime1">Jam Mulai</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                                <input type="time" id="inputTime1" class="form-control" name="jam-mulai" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputTime2">Jam Selesai</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                                </div>
                                <input type="time" id="inputTime2" class="form-control" name="jam-selesai" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputLocation">Ruang Rapat</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-map"></i></span>
                                </div>
                                <input type="text" id="inputLocation" class="form-control" name="ruang-rapat" required>
                            </div>
                        </div>

                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="middle-name" name="gambar-rapat" required>
                            <label class="custom-file-label" for="middle-name">Pilih file</label>
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