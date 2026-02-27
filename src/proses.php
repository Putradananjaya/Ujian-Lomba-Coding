<?php
// src/proses.php
require 'database.php';

// [BUG 1: ALGORITMA] Tidak ada validasi. Jika user submit form kosong, program akan tetap lanjut dan error.
$nama_tim = $_POST['nama_tim'];
$asal_kelas = $_POST['asal_kelas'];
$id_kategori = $_POST['id_kategori'];

// [BUG 2: SQL INJECTION] Parameter langsung digabung ke string SQL!
// Asesi wajib mengubahnya menjadi Prepared Statement.
$sql = "INSERT INTO peserta_lomba (nama_tim, asal_kelas, id_kategori) VALUES ('$nama_tim', '$asal_kelas', '$id_kategori')";

// Mengeksekusi kueri kotor
$db->exec($sql);

header("Location: index.php");
exit;
?>