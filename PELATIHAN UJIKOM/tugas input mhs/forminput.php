<?php
// Koneksi ke database
$host = "localhost"; // Host database
$username = "root"; // Username database
$password = ""; // Password database (kosong jika tidak ada)
$database = "db_mahasiswa"; // Nama database

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan data
if (isset($_POST['tambah'])) {
    $nim_mhs = $_POST['nim_mhs'];
    $nama_mhs = $_POST['nama_mhs'];
    $jkel = $_POST['jkel'];
    $jurusan_mhs = $_POST['jurusan_mhs'];

    // Jika ada no (berarti edit data), lakukan update
    if (isset($_POST['no'])) {
        $no = $_POST['no'];
        $sql = "UPDATE data_mhs SET nim_mhs='$nim_mhs', nama_mhs='$nama_mhs', jkel='$jkel', jurusan_mhs='$jurusan_mhs' WHERE no=$no";
    } else {
        // Jika tidak ada no (berarti tambah data baru), lakukan insert
        $sql = "INSERT INTO data_mhs (nim_mhs, nama_mhs, jkel, jurusan_mhs) VALUES ('$nim_mhs', '$nama_mhs', '$jkel', '$jurusan_mhs')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Data mahasiswa berhasil disimpan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Proses hapus data
if (isset($_GET['hapus'])) {
    $no = $_GET['hapus'];
    $sql = "DELETE FROM data_mhs WHERE no = $no";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Data mahasiswa berhasil dihapus!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

// Ambil data untuk diedit
$edit_data = null;
if (isset($_GET['edit'])) {
    $no = $_GET['edit'];
    $sql = "SELECT * FROM data_mhs WHERE no = $no";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

// Ambil semua data dari database
$sql = "SELECT * FROM data_mhs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .table {
            margin-top: 20px;
        }
        .radio-group {
            display: flex;
            gap: 10px;
        }
        .radio-group label {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Form Data Mahasiswa</h2>

        <!-- Form Input Data Mahasiswa -->
        <form method="POST" action="">
            <!-- Input Hidden untuk menyimpan no (ID) saat edit -->
            <?php if ($edit_data): ?>
                <input type="hidden" name="no" value="<?php echo $edit_data['no']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="nim_mhs" class="form-label">NIM:</label>
                <input type="text" class="form-control" id="nim_mhs" name="nim_mhs" value="<?php echo $edit_data ? $edit_data['nim_mhs'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="nama_mhs" class="form-label">Nama Mahasiswa:</label>
                <input type="text" class="form-control" id="nama_mhs" name="nama_mhs" value="<?php echo $edit_data ? $edit_data['nama_mhs'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label class="form-label">Jenis Kelamin:</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="jkel" value="Laki-laki" <?php echo ($edit_data && $edit_data['jkel'] == 'Laki-laki') ? 'checked' : ''; ?> required> Laki-laki
                    </label>
                    <label>
                        <input type="radio" name="jkel" value="Perempuan" <?php echo ($edit_data && $edit_data['jkel'] == 'Perempuan') ? 'checked' : ''; ?> required> Perempuan
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="jurusan_mhs" class="form-label">Jurusan:</label>
                <input type="text" class="form-control" id="jurusan_mhs" name="jurusan_mhs" value="<?php echo $edit_data ? $edit_data['jurusan_mhs'] : ''; ?>" required>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" name="tambah" class="btn btn-primary me-md-2">
                    <?php echo $edit_data ? 'Update' : 'Tambah'; ?>
                </button>
                <button type="reset" class="btn btn-secondary me-md-2">Cancel</button>
                <?php if ($edit_data): ?>
                    <a href="?" class="btn btn-warning me-md-2">Batal Edit</a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Tabel Data Mahasiswa -->
        <h2 class="text-center mb-4">Data Mahasiswa</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['no']}</td>
                                <td>{$row['nim_mhs']}</td>
                                <td>{$row['nama_mhs']}</td>
                                <td>{$row['jkel']}</td>
                                <td>{$row['jurusan_mhs']}</td>
                                <td>
                                    <a href='?edit={$row['no']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='?hapus={$row['no']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data mahasiswa.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>