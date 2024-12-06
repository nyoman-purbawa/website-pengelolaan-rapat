<?php

session_start(); // Memulai sesi untuk menyimpan data login
require_once("./config/autoload.php");

$host = "localhost";
$user = "root";
$pass = "";
$database = "db_rapat_information";

$conn = mysqli_connect($host, $user, $pass, $database);

if (isset($_POST["login"])) {
  $no_induk = $_POST["no_induk"];
  $password = $_POST["password"];

  $query = "SELECT * FROM tb_user_login WHERE no_induk_guru = '$no_induk' AND password = '$password'";
  $sql_query = mysqli_query($conn, $query);

  if (mysqli_num_rows($sql_query)) {
    $user_data = mysqli_fetch_assoc($sql_query);

    $_SESSION["login"] = true;

    // Mengarahkan pengguna berdasarkan peran (roles)
    if ($user_data['roles'] === 'admin') {
      header("location:views/admin/index.php"); // Ganti dengan halaman admin yang sesuai
    } else if ($user_data['roles'] === 'user') {
      header("location:views/users/index.php"); // Ganti dengan halaman user yang sesuai
    }
    exit();
  } else {
    $error = "No Induk Guru atau password salah.";
  }
}









?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/bootstrap/plugins/fontawesome-free/css/all.min.css" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/bootstrap/dist/css/adminlte.min.css" />
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body rounded">
        <div class="text-center">
          <img src="assets/img/logo.png" width="200px" class="mx-auto" alt="" />
        </div>
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="number" class="form-control" name="no_induk" placeholder="Nomor Induk Guru" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-id-card"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <button type="submit" name="login" class="btn btn-sm btn-primary btn-block">
                Sign In
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- /.social-auth-links -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="assets/bootstrap/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="assets/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/bootstrap/dist/js/adminlte.min.js"></script>
</body>

</html>