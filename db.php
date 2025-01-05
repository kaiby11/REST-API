<?php
$host = 'localhost';
$user = 'root';      // Username database
$pass = '';          // Password database
$dbname = 'todo_list'; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
