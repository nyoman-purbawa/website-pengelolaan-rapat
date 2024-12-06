<?php

class User
{
    private $mysqli;

    // Method Constructor
    function __construct($conn)
    {
        $this->mysqli = $conn;
    }

    function tambah_user($data)
    {
        $db = $this->mysqli->conn;

        if (isset($data["submit"])) {
            $no_induk = htmlspecialchars($data["no_induk"]);
            $username = htmlspecialchars($data["username"]);
            $password = htmlspecialchars($data["password"]); // Hash password
            $roles = htmlspecialchars($data["roles"]);

            // Prepared statement to prevent SQL injection
            $cek_query = $db->prepare("SELECT * FROM tb_user_login WHERE no_induk_guru = ?");
            $cek_query->bind_param("s", $no_induk);
            $cek_query->execute();
            $cek_result = $cek_query->get_result();

            if ($cek_result->num_rows > 0) {
                // Jika nomor induk sudah ada, tampilkan Sweet Alert
                echo "<script>
                    Swal.fire({
                        text:'Data User dengan Nomor Induk tersebut sudah ada.',
                        type: 'error',
                        icon: 'error',
                    });
                </script>";
                return false;
            }

            // Prepared statement to prevent SQL injection
            $sql = $db->prepare("INSERT INTO tb_user_login VALUES (?, ?, ?, ?)");
            $sql->bind_param("ssss", $no_induk, $username, $password, $roles);
            $result = $sql->execute();

            // Condition Mengecek Database 
            if ($result) {
                echo "<script>
                    Swal.fire({
                        text:'Data User Berhasil Ditambahkan',
                        type: 'success',
                        icon: 'success',
                    });
                </script>";
                return true;
            } else {
                echo "Error: " . $db->error;
                return false;
            }
        }
    }

    function hapus_user($no_induk)
    {
        $db = $this->mysqli->conn;

        // Prepared statement to prevent SQL injection
        $hapus_query = $db->prepare("DELETE FROM tb_user_login WHERE no_induk_guru = ?");
        $hapus_query->bind_param("s", $no_induk);
        $result = $hapus_query->execute();

        if ($result) {
            echo "<script>
                Swal.fire({
                    text:'Data User Berhasil Dihapus',
                    type: 'success',
                    icon: 'success',
                });
            </script>";
            return true;
        } else {
            echo "Error: " . $db->error;
            return false;
        }
    }

    function select_user()
    {
        $db = $this->mysqli->conn;

        // Prepared statement to prevent SQL injection
        $select_query = $db->prepare("SELECT * FROM tb_user_login");
        $select_query->execute();
        $result = $select_query->get_result();

        if ($result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            return $users;
        } else {
            return [];
        }
    }
}
