<?php


session_start();
if (!isset($_SESSION["login"])) {
  header("location: ../../login.php");
  return exit();
}


require_once "../../config/autoload.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AdminLTE 3 | Dashboard 2</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../assets/bootstrap/plugins/fontawesome-free/css/all.min.css" />
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/bootstrap/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/bootstrap/dist/css/adminlte.min.css" />
  <!-- SummerNote -->
  <link rel="stylesheet" href="../../assets/bootstrap/plugins/summernote/summernote-bs4.min.css" />
  <!-- Data Table -->
  <link rel="stylesheet" href="../../assets/bootstrap/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
  <link rel="stylesheet" href="../../assets/bootstrap/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
  <link rel="stylesheet" href="../../assets/bootstrap/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="">
    <!-- Navbar -->
    <nav class="container-fluid navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- ml-auto for right alignment -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">User</span>
            <i class="fas fa-user img-profile rounded-circle"></i>
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="../../config/models/logout.php">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="container">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
            <!-- /.col -->

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
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Data Table Notulen</h3>
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
                      $file_path = "../../assets/upload/" . $row['filename'];
                  ?>
                      <tr>
                        <td><?= $row["nama_rapat"] ?></td>
                        <td><?= $row["tanggal_rapat"] ?></td>
                        <td class="text-center">
                          <a href="<?php echo $file_path; ?>" class="btn btn-success btn-sm">Download</a>


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
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="../../assets/bootstrap/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../assets/bootstrap/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="../../assets/bootstrap/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/bootstrap/dist/js/adminlte.js"></script>

  <!-- PAGE PLUGINS -->
  <!-- Summernote -->
  <script src="../../assets/bootstrap/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../../assets/bootstrap/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../assets/bootstrap/plugins/jszip/jszip.min.js"></script>
  <script src="../../assets/bootstrap/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../../assets/bootstrap/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../../assets/bootstrap/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
    $(function() {
      $("#example1")
        .DataTable({
          responsive: true,
          lengthChange: false,
          autoWidth: false,
        })
        .buttons()
        .container()
        .appendTo("#example1_wrapper .col-md-6:eq(0)");

      $("#example2").DataTable({
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
      });
    });
  </script>
</body>

</html>