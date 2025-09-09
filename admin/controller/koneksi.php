<?php

$hostname = "localhost";
$hostusername = "root";
$hostpassword = "";
$hostdatabase = "warung_sembako";
$config = mysqli_connect($hostname, $hostusername, $hostpassword, $hostdatabase);
if (!$config) {
    echo "Koneksi gagal";
}
