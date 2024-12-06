<?php
// Class Rapat
class Rapat
{

    private $mysqli;

    // Method Constructor
    function __construct($conn)
    {
        $this->mysqli = $conn;
    }

    // Method Menampilkan Rapat Yang Sudah Di Create
    public function show_rapat($query)
    {
        $database = $this->mysqli->conn;
        $query = mysqli_query($database, $query);

        $rows = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }

        return $rows;
    }


    // Method Untuk Menghapus Rapat
    public function hapus_rapat($id)
    {
        $database = $this->mysqli->conn;

        // Prepared statements untuk mencegah SQL injection
        $delete_absen = $database->prepare("DELETE FROM tb_rekap_data_rapat WHERE fk_rekap_rapat = ?");
        $delete_absen->bind_param("i", $id);
        $delete_absen->execute();

        $delete_absen = $database->prepare("DELETE FROM tb_absen WHERE id_rapatt = ?");
        $delete_absen->bind_param("i", $id);
        $delete_absen->execute();

        $get_gambar_query = $database->prepare("SELECT gambar_rapat FROM tb_create_rapat WHERE id_rapat = ?");
        $get_gambar_query->bind_param("i", $id);
        $get_gambar_query->execute();
        $get_gambar_result = $get_gambar_query->get_result();
        $row = $get_gambar_result->fetch_assoc();
        $gambar_rapat = isset($row['gambar_rapat']) ? $row['gambar_rapat'] : null;
        $delete_rapat = $database->prepare("DELETE FROM tb_create_rapat WHERE id_rapat = ?");
        $delete_rapat->bind_param("i", $id);
        $delete_rapat->execute();

        // Hapus gambar dari direktori jika gambar tersedia
        if ($gambar_rapat && unlink("../../assets/upload/" . $gambar_rapat)) {
            if ($delete_rapat->affected_rows > 0) {
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
            } else {
                return false; // Tidak perlu menampilkan pesan di sini
            }
        } else {
            return false; // Gagal menghapus gambar atau gambar tidak tersedia
        }
    }


    // Method Menambahkan Rapat
    public function tambah_rapat($data)
    {
        if (isset($data["submit"])) {
            // Database Connection
            $db = $this->mysqli->conn;

            // Variables
            $nama_rapat = htmlspecialchars($data["nama-rapat"]);
            $tanggal_dilaksanakan = htmlspecialchars($data["tanggal-dilaksanakan"]);
            $jam_mulai = htmlspecialchars($data["jam-mulai"]);
            $jam_selesai = htmlspecialchars($data["jam-selesai"]);
            $ruang_rapat = htmlspecialchars($data["ruang-rapat"]);

            // File Upload
            $extensi = pathinfo($_FILES["gambar-rapat"]["name"], PATHINFO_EXTENSION);
            $allowed_ext = array("jpg", "jpeg", "png");

            if (in_array($extensi, $allowed_ext)) {
                $gambar_rapat = "brg-" . round(microtime(true)) . "." . $extensi;
                $source = $_FILES["gambar-rapat"]["tmp_name"];
                $upload = move_uploaded_file($source, "../../assets/upload/" . $gambar_rapat);

                if ($upload) {
                    // Prepared statement untuk mencegah SQL injection
                    $stmt = $db->prepare("INSERT INTO tb_create_rapat 
                                        VALUES (NULL, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $nama_rapat, $tanggal_dilaksanakan, $jam_mulai, $jam_selesai, $ruang_rapat, $gambar_rapat);
                    $result = $stmt->execute();

                    if ($result) {
                        echo "  
                        <script>
                            Swal.fire({
                                text: 'Rapat Berhasil Di Buat',
                                type: 'success',
                                icon: 'success',
                            });
                        </script>
                       ";
                        return true;
                    } else {
                        echo "  
                        <script>
                            Swal.fire({
                                text: 'Rapat Gagal Di Buat',
                                type: 'warning',
                                icon: 'warning',
                            });
                        </script>
                       ";
                        return false; // Tidak perlu menampilkan pesan di sini
                    }
                } else {
                    return false; // Tidak perlu menampilkan pesan di sini
                }
            } else {
                echo "  
                        <script>
                            Swal.fire({
                                text: 'Rapat Lengkapi Data',
                                type: 'warning',
                                icon: 'warning',
                            });
                        </script>
                       ";
                return false; // Tidak perlu menampilkan pesan di sini
            }
        }
    }
}
