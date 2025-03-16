<?php
session_start();

// Cek apakah pengguna sudah login dan levelnya manager
if (!isset($_SESSION['username']) || $_SESSION['level'] != 2) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Include file koneksi
include '../koneksi/koneksi.php';

// Ambil parameter dari URL untuk menentukan section yang aktif
$section = isset($_GET['section']) ? $_GET['section'] : 'beranda';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #3b82f6;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar-header {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link {
            color: white;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 1rem;
        }

        /* Quick Access Cards */
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Dashboard Manager</h3>
        </div>
        
        <!-- User Profile -->
        <!-- <div class="px-3 py-4 text-center border-bottom">
            <i class="bi bi-person-circle fs-1"></i>
            <h5 class="mt-2"><?php echo $username; ?></h5>
            <p class="text-white-50 mb-2">Manager</p>
        </div> -->
        
        <!-- Menu -->
        <div class="px-3 py-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'beranda') ? 'active' : ''; ?>" href="?section=beranda">
                        <i class="bi bi-house-fill me-2"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'transaction') ? 'active' : ''; ?>" href="?section=transaction">
                        <i class="bi bi-table me-2"></i> Transaction Temp
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'identitas') ? 'active' : ''; ?>" href="?section=identitas">
                        <i class="bi bi-building me-2"></i> Identitas
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <a href="logout.php" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container py-4">
            <!-- Beranda Section -->
            <?php if ($section == 'beranda'): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Dashboard Manager</h5>
                            </div>
                            <div class="card-body">
                                <h4>Selamat Datang, <?php echo $username; ?></h4>
                                <p>Anda login sebagai Manager. Silakan gunakan menu navigasi untuk mengakses fitur sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Transaction Temp Section -->
            <?php if ($section == 'transaction'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Transaction Temp</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Transaction</th>
                                    <th>ID Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                    <th>Session ID</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel transaction_temp
                                $sql = "SELECT * FROM transactio_temp";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row["id_transaction"]."</td>
                                                <td>".$row["id_item"]."</td>
                                                <td>".$row["quantity"]."</td>
                                                <td>".$row["price"]."</td>
                                                <td>".$row["amount"]."</td>
                                                <td>".$row["session_id"]."</td>
                                                <td>".$row["remark"]."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Identitas Section -->
            <?php if ($section == 'identitas'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Identitas</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Identitas</th>
                                    <th>Nama Identitas</th>
                                    <th>Badan Hukum</th>
                                    <th>NPWP</th>
                                    <th>Email</th>
                                    <th>URL</th>
                                    <th>Alamat</th>
                                    <th>Telp</th>
                                    <th>Fax</th>
                                    <th>Rekening</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel identitas
                                $sql = "SELECT * FROM identitas";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row["id_identitas"]."</td>
                                                <td>".$row["nama_identitas"]."</td>
                                                <td>".$row["badan_hukum"]."</td>
                                                <td>".$row["npwp"]."</td>
                                                <td>".$row["email"]."</td>
                                                <td>".$row["url"]."</td>
                                                <td>".$row["alamat"]."</td>
                                                <td>".$row["telp"]."</td>
                                                <td>".$row["fax"]."</td>
                                                <td>".$row["rekening"]."</td>
                                                <td>".$row["foto"]."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='11'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>