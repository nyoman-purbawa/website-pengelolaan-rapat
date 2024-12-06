<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit(); // Menghentikan eksekusi skrip setelah redirect
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

if (isset($_GET['page']) && $_GET['page'] == 'delete-rekap' && isset($_GET['id'])) {
    $idToDelete = $_GET['id'];

    // Panggil fungsi delete_rekap dari objek $data_rekap_rapat
    $deleteSuccess = $data_rekap_rapat->delete_rekap($idToDelete);

    if ($deleteSuccess) {
        // Redirect kembali ke halaman yang sesuai setelah penghapusan
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    } else {
        echo "<script>alert('Gagal menghapus rekap rapat');</script>";
    }
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

if (!empty($_GET["id_absen"])) {
    // Mengambil id data yang ingin dihapus dari URL
    $id = $_GET["id"];
    $id_rapat = $_GET['id_absen'];

    // Menjalankan query hapus
    $query = "DELETE FROM tb_absen WHERE id_absen = ?";

    if ($stmt = $koneksi->prepare($query)) {
        $stmt->bind_param("i", $id_rapat);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "
            <script>
                Swal.fire({
                    text: 'Absen Berhasil Dihapus',
                    type: 'success',
                    icon: 'success',
                });

                setTimeout(function(){
                    window.location.href = 'index.php?page=detail-rapat&id=' + $id;
                }, 1000);
            </script>
            ";
        } else {
            echo " <script>
            Swal.fire({
                text: 'Data Absen Tidak Bisa DiHapus',
                type: 'error',
                icon: 'error',
            });

            setTimeout(function(){
                window.location.href = 'index.php?page=detail-rapat&id=' + $id;
            }, 1000);
        </script>
        ";
        }

        $stmt->close();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}




if (isset($_GET['id'])) {
    $id = $_GET['id'];

    function deleteData($id)
    {
        global $koneksi;
        $query = "DELETE FROM tb_absen WHERE id_absen = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
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
                        <textarea id="summernote" name="rekap-rapat" style="width: 100%"></textarea>
                    </div>

                    <div class=" card-footer">
                        <button name="submit-rapat" class="btn btn-primary">Submit</button>
                        <a href="?page=edit-detail-rapat&id=<?php echo $_GET["id"] ?>" name="edit" class="btn btn-success">Edit</a>
                        <a href="?page=detail-rapat&id=<?php echo $_GET["id"] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete Rekap</a>
                    </div>
                </div>
            </form>

        </div>

        <div class="container-fluid">

            <div class="alert alert-light w-100" role="alert">
                <a target="_blank" href="./../../form-absen.php?id=<?= $id ?>" class="text-white d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-2 mr-4"><i class="fas fa-link fa-sm text-white-50"></i> Link Absensi</a>
                <a target="_blank" href="print_qrcode.php?id=<?= $id ?>" class=" text-white d-sm-inline-block btn btn-sm btn-secondary shadow-sm mb-2 mr-4"><i class="fas fa-download fa-sm text-white-50"></i> Qr Code</a>
                <a target="_blank" href="print_rapat.php?id=<?= $id ?>" class=" text-white d-sm-inline-block btn btn-sm btn-success shadow-sm mb-2 mr-4"><i class="fas fa-print fa-sm text-white-50"></i> Print Report</a>
                <a target="_blank" href="print_absen.php?id=<?= $id ?>" class=" text-white d-sm-inline-block btn btn-sm btn-info  shadow-sm mb-2 mr-4"><i class="fas fa-print fa-sm text-white-50"></i> Print Absen</a>

            </div>

        </div>


        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-2-strong" style="background-color: #f5f7fa;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0" id="example1">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">NAMA</th>
                                            <th scope="col">POSITION</th>
                                            <th scope="col">SIGNATURE</th>
                                            <th scope="col">AKSI</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($rows)) {
                                            $no = 1;
                                            foreach ($rows as $row) :
                                        ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $row["nama_absen"] ?></td>
                                                    <td><?= $row["category_absen"] ?></td>
                                                    <td class="text-center"><img src="./../../<?= $row["gambar_ttd"] ?>" width="150px" alt=""></td>
                                                    <td>
                                                        <a href="index.php?page=detail-rapat&id=<?= $id ?>&id_absen=<?= $row["id_absen"] ?>" class="btn btn-danger btn-sm px-3">
                                                            <i class="fas fa-times"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                        <?php
                                            endforeach;
                                        } else {
                                            // Penanganan jika $rows tidak memiliki nilai yang valid
                                            // Misalnya, tampilkan pesan bahwa tidak ada data yang ditemukan
                                            echo "<tr><td colspan='4' class='text-center'>No Data Source.</td></tr>";
                                        }
                                        ?>


                                    </tbody>
                                    <tfoot>
                                        <th scope="col">NO</th>
                                        <th scope="col">NAMA</th>
                                        <th scope="col">POSITION</th>
                                        <th scope="col">SIGNATURE</th>
                                        <th scope="col">AKSI</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>


        </div>
</section>