<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$level = $_SESSION['level'];

// Redirect jika bukan level petugas (level 1)
if ($level != 1) {
    header("Location: manager.php");
    exit();
}

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
    <title>Dashboard Petugas</title>
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
            <h3>Dashboard Petugas</h3>
        </div>
        
        <!-- Menu -->
        <div class="px-3 py-2">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'beranda') ? 'active' : ''; ?>" href="?section=beranda">
                        <i class="bi bi-house-fill me-2"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'customer') ? 'active' : ''; ?>" href="?section=customer">
                        <i class="bi bi-people-fill me-2"></i> Data Customer
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'sales') ? 'active' : ''; ?>" href="?section=sales">
                        <i class="bi bi-cart-fill me-2"></i> Data Penjualan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'item') ? 'active' : ''; ?>" href="?section=item">
                        <i class="bi bi-box-seam-fill me-2"></i> Data Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($section == 'transaction') ? 'active' : ''; ?>" href="?section=transaction">
                        <i class="bi bi-graph-up me-2"></i> Transaksi
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
                                <h5 class="mb-0">Dashboard Petugas</h5>
                            </div>
                            <div class="card-body">
                                <h4>Selamat Datang, <?php echo $_SESSION['username']; ?></h4>
                                <p>Anda login sebagai Petugas. Silakan gunakan menu navigasi untuk mengakses fitur sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Data Customer Section -->
            <?php if ($section == 'customer'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Customer</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Customer</th>
                                    <th>Nama Customer</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel customer
                                $sql = "SELECT * FROM customer";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row["id_customer"]."</td>
                                                <td>".$row["nama_customer"]."</td>
                                                <td>".$row["alamat"]."</td>
                                                <td>".$row["telepon"]."</td>
                                                <td>".$row["email"]."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada data customer</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Data Penjualan Section -->
            <?php if ($section == 'sales'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Penjualan</th>
                                    <th>Tanggal Penjualan</th>
                                    <th>Total Harga</th>
                                    <th>ID Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel penjualan
                                $sql = "SELECT * FROM transaction";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row["id_penjualan"]."</td>
                                                <td>".$row["tanggal_penjualan"]."</td>
                                                <td>".$row["total_harga"]."</td>
                                                <td>".$row["id_customer"]."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Tidak ada data penjualan</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Data Barang Section -->
            <?php if ($section == 'item'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Barang</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>UOM</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel item
                                $sql = "SELECT * FROM item";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row["id_item"]."</td>
                                                <td>".$row["nama_item"]."</td>
                                                <td>".$row["uom"]."</td>
                                                <td>".$row["harga_beli"]."</td>
                                                <td>".$row["harga_jual"]."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Tidak ada data barang</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Transaksi Section -->
            <?php if ($section == 'transaction'): ?>
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Harga</th>
                                    <th>ID Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Query untuk mengambil data dari tabel transaksi
                                $sql = "SELECT * FROM transaksi";
                                $result = $koneksi->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>".$row["id_transaksi"]."</td>
                                                <td>".$row["tanggal_transaksi"]."</td>
                                                <td>".$row["total_harga"]."</td>
                                                <td>".$row["id_customer"]."</td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>Tidak ada data transaksi</td></tr>";
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