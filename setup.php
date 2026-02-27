<?php
// setup.php - Eksekusi: php setup.php
$db = new PDO('sqlite:src/pendaftaran.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Buat Tabel Kategori Lomba dan Peserta Lomba
$db->exec("CREATE TABLE IF NOT EXISTS kategori_lomba (id INTEGER PRIMARY KEY AUTOINCREMENT, nama_kategori TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS peserta_lomba (id INTEGER PRIMARY KEY AUTOINCREMENT, nama_tim TEXT, asal_kelas TEXT, id_kategori INTEGER)");

// Masukkan data referensi kategori perlombaan
$db->exec("INSERT INTO kategori_lomba (nama_kategori) VALUES ('Web Development'), ('Competitive Programming'), ('UI/UX Design'), ('Data Science')");

// Masukkan 5.000 data dummy untuk mensimulasikan beban server
echo "Sedang men-generate 5.000 data tim peserta...\n";
$db->beginTransaction();
for ($i = 1; $i <= 5000; $i++) {
    $id_kategori = rand(1, 4);
    $db->exec("INSERT INTO peserta_lomba (nama_tim, asal_kelas, id_kategori) VALUES ('Tim Hebat $i', 'TI-Semester 3', $id_kategori)");
}
$db->commit();

echo "Setup Selesai! File pendaftaran.sqlite berhasil dibuat di dalam folder src/.";
?>