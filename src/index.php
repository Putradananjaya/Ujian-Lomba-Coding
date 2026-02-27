<?php
// src/index.php
require 'database.php';

// [BUG 1: PROFILING] Asesi harus menambahkan fungsi microtime(true) di awal dan akhir file.

// Ambil semua data antrean peserta
$query_utama = $db->query("SELECT * FROM peserta_lomba");
$data_utama = $query_utama->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pendaftaran Lomba Coding</title>
</head>
<body>
    <h1>Form Pendaftaran Lomba Coding Dasar</h1>
    
    <form action="proses.php" method="POST">
        <input type="text" name="nama_tim" placeholder="Nama Tim (Misal: Alpha Team)"><br><br>
        <input type="text" name="asal_kelas" placeholder="Asal Kelas / Semester"><br><br>
        <select name="id_kategori">
            <option value="1">Web Development</option>
            <option value="2">Competitive Programming</option>
            <option value="3">UI/UX Design</option>
            <option value="4">Data Science</option>
        </select><br><br>
        <button type="submit">Daftarkan Tim</button>
    </form>
    
    <hr>
    
    <h2>Daftar Tim Pendaftar (5.000+ Tim)</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama Tim</th>
            <th>Asal Kelas</th>
            <th>Kategori Lomba</th>
        </tr>
        <?php
        foreach ($data_utama as $row) {
            $id_kategori = $row['id_kategori'];
            
            // [BUG 2: SKALABILITAS / N+1 QUERY] 
            // Kueri di dalam looping yang akan membunuh server. Asesi wajib menghapus ini 
            // dan menggabungkannya ke kueri utama di atas menggunakan JOIN.
            $query_relasi = $db->query("SELECT nama_kategori FROM kategori_lomba WHERE id = $id_kategori");
            $relasi = $query_relasi->fetch();

            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nama_tim'] . "</td>";
            echo "<td>" . $row['asal_kelas'] . "</td>";
            echo "<td>" . $relasi['nama_kategori'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>