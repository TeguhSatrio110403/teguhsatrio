<?php
// Koneksi ke database
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database (kosong jika tidak ada)
$database = "data"; // Nama database

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan data
if (isset($_POST['simpan'])) {
    $nama_merek = $_POST['nama_merek'];
    $warna = $_POST['warna'];
    $jumlah = $_POST['jumlah'];

    // Query untuk menyimpan data ke tabel printer
    $sql = "INSERT INTO printer (nama_merek, warna, jumlah) VALUES ('$nama_merek', '$warna', $jumlah)";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Data berhasil disimpan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Printer</title>
    <!-- Menghubungkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Tambah Data Barang</h2>
        <!-- Form Input Data Barang -->
        <form method="POST" action="">
            <!-- Input Nama Merek -->
            <div class="form-group">
                <label for="nama_merek" class="form-label">Nama Merek:</label>
                <input type="text" class="form-control" id="nama_merek" name="nama_merek" required>
            </div>

            <!-- Input Warna -->
            <div class="form-group">
                <label for="warna" class="form-label">Warna:</label>
                <input type="text" class="form-control" id="warna" name="warna" required>
            </div>

            <!-- Input Jumlah -->
            <div class="form-group">
                <label for="jumlah" class="form-label">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" required>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" name="simpan" class="btn btn-primary me-md-2">Simpan</button>
                <button type="reset" class="btn btn-secondary me-md-2">Ulangi</button>
                <button type="button" class="btn btn-danger" onclick="window.location.href='index.html'">Kembali</button>
            </div>
        </form>
    </div>

    <!-- Menghubungkan Bootstrap JS (opsional, jika diperlukan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>