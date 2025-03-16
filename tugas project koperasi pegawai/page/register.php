<?php
include '../koneksi/koneksi.php';

$alert_message = ""; // Variabel untuk menyimpan pesan alert
$alert_type = "";   // Variabel untuk menentukan jenis alert (success/danger)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_user = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Password disimpan dalam bentuk plain text
    $level = $_POST['level'];

    // Validasi level
    $valid_levels = [1, 2]; // Nilai level yang valid
    if (!in_array($level, $valid_levels)) {
        $alert_message = "Level tidak valid!";
        $alert_type = "danger";
    } else {
        // Cek apakah level ada di tabel level
        $check_level_sql = "SELECT id_level FROM level WHERE id_level = $level";
        $check_level_result = mysqli_query($koneksi, $check_level_sql);

        if (mysqli_num_rows($check_level_result) == 0) {
            $alert_message = "Level tidak ditemukan di database!";
            $alert_type = "danger";
        } else {
            // Insert data ke tabel yang sesuai
            if ($level == 1) {
                $sql = "INSERT INTO petugas (nama_user, username, password, level) VALUES ('$nama_user', '$username', '$password', $level)";
            } else {
                $sql = "INSERT INTO manager (nama_user, username, password, level) VALUES ('$nama_user', '$username', '$password', $level)";
            }

            if (mysqli_query($koneksi, $sql)) {
                $alert_message = "Registrasi berhasil! Anda akan dialihkan ke halaman login.";
                $alert_type = "success";
            } else {
                $alert_message = "Error: " . mysqli_error($koneksi);
                $alert_type = "danger";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet"> <!-- Impor file CSS terpisah -->
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Alert untuk menampilkan pesan -->
                <?php if (!empty($alert_message)): ?>
                    <div class="alert alert-<?php echo $alert_type; ?> alert-auto-hide" role="alert">
                        <?php echo $alert_message; ?>
                    </div>
                <?php endif; ?>

                <!-- Card dengan sudut yang lebih round -->
                <div class="card shadow rounded-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-center">Register</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nama_user" class="form-label">Nama User</label>
                                <input type="text" class="form-control" id="nama_user" name="nama_user" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="level" class="form-label">Level</label>
                                <select class="form-control" id="level" name="level" required>
                                    <option value="1">Petugas</option>
                                    <option value="2">Manager</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Sudah punya akun? <a href="login.php" class="text-primary">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menghilangkan alert setelah 5 detik
        function autoHideAlert() {
            const alertElement = document.querySelector('.alert-auto-hide');
            if (alertElement) {
                setTimeout(() => {
                    alertElement.style.display = 'none';
                    // Redirect ke halaman login setelah alert hilang
                    window.location.href = 'login.php';
                }, 5000); // = 5 detik
            }
        }

        // Panggil fungsi saat halaman dimuat
        window.onload = autoHideAlert;
    </script>
</body>
</html>