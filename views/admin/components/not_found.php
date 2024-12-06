<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION["login"])) {
    header("location: ./../../../login.php");
    exit(); // Menghentikan eksekusi skrip setelah redirect
}
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="error-page text-center">
                <h2 class="headline text-warning">404</h2>
                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
                    <p>
                        We could not find the page you were looking for.
                        Meanwhile, you may <a href="?page=dashboard">return to dashboard</a> or try using the search form.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </div>
    </section>
    <!-- /.content -->
</div>