<?php

class RekapRapat
{


    private $mysqli;


    function __construct($conn)
    {

        $this->mysqli = $conn;
    }


    // Tampilkan Absen Rapat
    public function tampilkan_rekap($id)
    {

        $database = $this->mysqli->conn;

        $query = mysqli_query($database, "SELECT * FROM tb_absen JOIN  tb_rekap_data_rapat ON tb_absen.id_rapatt = tb_rekap_data_rapat.fk_rekap_rapat WHERE id_rapatt = $id LIMIT 1");

        $rows = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function edit_rekap($id)
    {

        $database = $this->mysqli->conn;

        $query = mysqli_query($database, "SELECT * FROM tb_rekap_data_rapat WHERE fk_rekap_rapat = $id");

        $rows = [];

        while ($row = mysqli_fetch_assoc($query)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function update_rekap($id, $newDescRekap)
    {
        $database = $this->mysqli->conn;
        $newDescRekap = mysqli_real_escape_string($database, $newDescRekap);

        $query = "UPDATE tb_rekap_data_rapat SET desc_rekap = '$newDescRekap' WHERE fk_rekap_rapat = $id";

        if (mysqli_query($database, $query)) {
            return true; // Update berhasil
        } else {
            return false; // Update gagal
        }
    }

    public function delete_rekap($id)
    {
        $database = $this->mysqli->conn;
        $query = "DELETE FROM tb_rekap_data_rapat WHERE fk_rekap_rapat = $id";
        $result = mysqli_query($database, $query);
        return $result;
    }
}
