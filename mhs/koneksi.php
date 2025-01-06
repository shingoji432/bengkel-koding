<?php
$serverName = '127.0.0.1';
$databaseUsername = 'root';
$databasePassword = '';
$databaseName = 'mhs';

$conn = new mysqli($databaseHost,$databaseUsername,$databasePassword, $databaseName);

if ($conn->connect_error){
    die("Koneksi gagal: " . $conn->connect_error);
}?>