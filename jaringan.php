<?php
$koneksi = new mysqli("localhost", "root", "", "pencarian");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}




?>