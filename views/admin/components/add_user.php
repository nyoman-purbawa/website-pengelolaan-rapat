<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit(); // Menghentikan eksekusi skrip setelah redirect
}

$user = new User($conn);
$user->tambah_user($_POST);
$select_users = $user->select_user();

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
    // Mengambil id data yang ingin dihapus dari URL
    $id = $_GET['id'];

    // Menjalankan query hapus
    $query = "DELETE FROM tb_user_login WHERE no_induk_guru = $id";

    if (mysqli_query($koneksi, $query)) {

        if (mysqli_affected_rows($koneksi) > 0) {

            echo "
            <script>
                Swal.fire({
                    text: 'Rapat Berhasil Di Hapus',
                    type: 'success',
                    icon: 'success',
                });

                setTimeout(function(){
                    window.location.reload();
                },1000);
            </script>
           ";
            return true;
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Menutup koneksi
mysqli_close($koneksi);



?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Add User</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Add User</li>
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
            <form action="" method="post">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Add User
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputText"> No Induk Guru</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-id-card"></i></span>
                                </div>
                                <input type="number" id="inputText" min="12" class="form-control" name="no_induk" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputDate">Nama</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                </div>
                                <input type="text" id="inputDate" class="form-control" name="username" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputTime1">Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" id="inputTime1" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputTime1">Roles</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                                </div>
                                <select id="inputTime1" class="form-control" name="roles">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
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
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-2-strong" style="background-color: #f5f7fa;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0" id="example1">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">NO INDUK GURU</th>
                                    <th scope="col">USERNAME</th>
                                    <th scope="col">PASSWORD</th>
                                    <th scope="col">ROLES</th>
                                    <th scope="col">AKSI</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                if (!empty($select_users)) {
                                    $no = 1;
                                    foreach ($select_users as $row) :
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row["no_induk_guru"] ?></td>
                                            <td><?= $row["username"] ?></td>
                                            <td><?= $row["password"] ?></td>
                                            <td><?= $row["roles"] ?></td>
                                            <td>
                                                <a href="index.php?page=add-user&id=<?= $row["no_induk_guru"] ?>" class="btn btn-danger btn-sm px-2">
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
                                <th scope="col">NO INDUK GURU</th>
                                <th scope="col">USERNAME</th>
                                <th scope="col">PASSWORD</th>
                                <th scope="col">ROLES</th>
                                <th scope="col">AKSI</th>

                            </tfoot>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>


</div>