<?php



require_once "config/autoload.php";
$conn = new Database($host, $user, $pass, $database);



$db = new Absen($conn);

$post = $_POST;
$get = $_GET;

$db->tambah_absen($post, $get);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SB Admin 2 - Login</title>



    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/bootstrap/plugins/fontawesome-free/css/all.min.css" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/bootstrap/dist/css/adminlte.min.css" />

    <!-- Signaure -->
    <link href="css/styles.css" rel="stylesheet" />

    <!-- Sweet Alert  -->
    <script src="assets/sweetalert/sweetalert2.all.min.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script type="text/javascript" src="assets/signature/jquery.signature.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/signature/jquery.signature.css">




    <style>
        .kbw-signature {
            width: 400px;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }
    </style>


</head>

<body style="background:#e9ecef;">
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card border-0 shadow rounded-3 col-sm-12 col-md-4">
            <div class="card-body">
                <div class="text-center">
                    <img src="assets/img/logo.png" width="160px" alt="">

                </div>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama_absen" class="form-label">Nama : </label>
                        <input type="text" class="form-control" id="nama_absen" name="nama_absen" placeholder="Masukan Nama Anda" require />
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label font-weight-bold">Sebagai : </label>
                        <select name="position" id="position" class="form-control ">
                            <option value="" class="form-control">Pilih posisi rapat</option>
                            <option value="MC (Master of Ceremony)" class="form-control">MC (Master of Ceremony)
                            </option>
                            <option value="Pemateri" class="form-control">Pemateri</option>
                            <option value="Peserta" class="form-control">Peserta</option>
                            <option value="Panitia" class="form-control">Panitia</option>
                            <!-- Anda bisa menambahkan opsi lainnya di sini jika diperlukan -->
                        </select>

                    </div>

                    <div class="input-group mb-3">
                        <label class="" for="">Signature:</label>
                        <br />
                        <div id="sig" style="width: 100%; height:150px; " class="from-control"></div>
                        <br />
                        <textarea class="form-control" id="signature64" name="signature" style="display: none;" require></textarea>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary" name="submit">Submit</button>
                    <button class="btn btn-sm  btn-warning" id="clear">Clear</button>
                </form>
            </div>
        </div>



    </div>



    <script src="js/script.js"></script>
    <script src="js/scripts.js"></script>


    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>
</body>

</html>