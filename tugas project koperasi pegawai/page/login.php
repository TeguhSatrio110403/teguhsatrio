<?php
session_start(); // Mulai session
include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Password diinput oleh pengguna

    // Cari pengguna di tabel petugas atau manager
    $sql = "SELECT * FROM petugas WHERE username = '$username' UNION SELECT * FROM manager WHERE username = '$username'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Bandingkan password yang diinput dengan password di database (plain text)
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['login_success']; // Set session untuk alert berhasil
            header("Location: index.php");
            exit();
        } else {
            // Jika password salah, tampilkan pesan error (opsional)
            echo "Password salah!";
        }
    } else {
        // Jika username tidak ditemukan, tampilkan pesan error (opsional)
        echo "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet"> 
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-center">Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Belum punya akun? <a href="register.php" class="text-primary">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>