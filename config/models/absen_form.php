<?php

class Absen
{
    private $mysqli;

    function __construct($conn)
    {
        $this->mysqli = $conn;
    }

    // Method untuk menampilkan absen rapat
    public function tampilkan_absen($id)
    {
        $conn = $this->mysqli->conn;

        $stmt = $conn->prepare("SELECT * FROM tb_create_rapat JOIN tb_absen ON tb_create_rapat.id_rapat = tb_absen.id_rapatt WHERE id_rapat = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    // Method untuk menghapus absen
    public function hapus_absen($id_absen)
    {
        $conn = $this->mysqli->conn;

        // Prepare and execute the DELETE query
        $delete_absen = $conn->prepare("DELETE FROM tb_absen WHERE id_absen = ?");
        $delete_absen->bind_param("i", $id_absen);

        try {
            $delete_absen->execute();

            if ($delete_absen->affected_rows > 0) {
                // Record deleted successfully
                return true;
            } else {
                // Record not found or deletion failed
                return false;
            }
        } catch (Exception $e) {
            // Handle database error here
            echo "Error deleting attendance record: " . $e->getMessage();
            return false;
        }
    }

    // Method untuk menambahkan absen baru
    public function tambah_absen($postData, $getQuery)
    {
        $conn = $this->mysqli->conn;

        if (isset($postData["submit"])) {
            try {
                // Check and sanitize input data
                $nama_absen = htmlspecialchars($postData["nama_absen"] ?? '');
                $category_absen = htmlspecialchars($postData["position"] ?? '');
                $gambar_ttd = htmlspecialchars($postData["signature"] ?? '');

                // Handle signature upload
                if (!empty($gambar_ttd)) {
                    // Decode the base64 string and save it as an image file
                    $folderPath = "assets/upload/";
                    $image_parts = explode(";base64,", $gambar_ttd);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = uniqid() . '.png';
                    $file = $folderPath . $fileName;
                    file_put_contents($file, $image_base64);

                    // Set id_rapatt from $getQuery
                    $id_rapatt = isset($getQuery["id"]) ? intval($getQuery["id"]) : null;

                    // Proceed with database insertion
                    $stmt = $conn->prepare("INSERT INTO tb_absen (id_rapatt, nama_absen, category_absen, gambar_ttd) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $id_rapatt, $nama_absen, $category_absen, $file);
                    $result = $stmt->execute();

                    if ($result) {
                        echo "Berhasil Melakukan Absen";
                        return true;
                    } else {
                        echo "Gagal Melakukan absen.";
                        return false;
                    }
                } else {
                    // Handle case where 'signature' key is not set or is empty
                    echo "Gagal Menambahkan Absen: Signature tidak ada atau gagal diunggah.";
                    return false;
                }
            } catch (Exception $e) {
                // Handle other exceptions
                echo "Error: Terjadi kesalahan dalam pemrosesan data.";
                return false;
            }
        }
    }



    // Method untuk menambahkan rekap rapat
    public function tambah_rekap($data, $id)
    {
        $conn = $this->mysqli->conn;

        if (isset($data["submit-rapat"])) {
            $rekap_rapat = htmlspecialchars($data["rekap-rapat"]);
            $fk_rekap_rapat = intval($id);

            // Proses unggah gambar
            if (!empty($_FILES['gambar']['name'])) {
                // Tentukan folder tempat gambar akan disimpan
                $uploadDir = '../../assets/uploads/';

                // Pastikan folder tersebut ada, jika belum maka buat folder baru
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Ambil informasi file yang diunggah
                $fileName = $_FILES['gambar']['name'];
                $fileTmpName = $_FILES['gambar']['tmp_name'];
                $filePath = $uploadDir . $fileName;

                // Pindahkan file yang diunggah ke folder tujuan
                if (move_uploaded_file($fileTmpName, $filePath)) {
                    // Jika berhasil, tambahkan informasi gambar ke dalam teks rekap
                    $rekap_rapat .= "<br><img src='$filePath' alt='Uploaded Image'>";
                } else {
                    // Jika gagal, tampilkan pesan error
                    echo "<script>
                        Swal.fire({
                            title: 'Gagal Mengunggah Gambar',
                            text: 'Gagal mengunggah gambar.',
                            type: 'error',
                            icon: 'error',
                        });
                    </script>";
                    return false;
                }
            }

            // Lanjutkan proses penyimpanan rekap rapat
            $check_absen = $conn->query("SELECT COUNT(*) as count FROM tb_absen WHERE id_rapatt = '$fk_rekap_rapat'");
            if ($check_absen) {
                $row_absen = $check_absen->fetch_assoc();
                $count_absen = $row_absen['count'];

                if ($count_absen == 0) {
                    echo "<script>
                        Swal.fire({
                            text: 'Peserta Rapat Belum Melakukan Absen',
                            type: 'warning',
                            icon: 'warning',
                        });
                    </script>";
                    return false;
                } else {
                    $query_check = $conn->query("SELECT COUNT(*) as count FROM tb_rekap_data_rapat WHERE fk_rekap_rapat = '$fk_rekap_rapat'");
                    if ($query_check) {
                        $row = $query_check->fetch_assoc();
                        $count = $row['count'];

                        if ($count > 0) {
                            echo "<script>
                                Swal.fire({
                                    text: 'Anda Sudah Menginputkan Data Sebelumnya',
                                    type: 'warning',
                                    icon: 'warning',
                                });
                            </script>";
                        } else {
                            $query_insert = "INSERT INTO tb_rekap_data_rapat (fk_rekap_rapat, desc_rekap) VALUES ('$fk_rekap_rapat', '$rekap_rapat')";

                            $result_insert = $conn->query($query_insert);

                            if ($result_insert) {
                                echo "<script>
                                    Swal.fire({
                                        text: 'Data Rekap Berhasil Di Tambahkan',
                                        type: 'success',
                                        icon: 'success',
                                    });
                                </script>";
                            } else {
                                echo "<script>
                                    Swal.fire({
                                        title: 'Gagal Menambahkan Data Rekap',
                                        type: 'error',
                                        icon: 'error',
                                    });
                                </script>";
                            }
                        }
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Gagal Mengecek Data',
                                type: 'error',
                                icon: 'error',
                            });
                        </script>";
                    }
                }
            } else {
                echo "<script>
                Swal.fire({
                    title: 'Gagal Mengecek Data Absen',
                    type: 'error',
                    icon: 'error',
                });
            </script>";
            }
        }
    }
}
