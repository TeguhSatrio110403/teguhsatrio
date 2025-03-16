<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Total Pesanan Makanan</title>
    <!-- Menghubungkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        .menu-item {
            margin-bottom: 15px;
        }
        .menu-item label {
            font-size: 1rem;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Hitung Total Pesanan Makanan</h2>
        <form method="POST" action="">
            <!-- Menu Nasi Goreng -->
            <div class="menu-item">
                <label for="nasi_goreng" class="form-label">Nasi Goreng (Rp 10.000)</label>
                <input type="number" class="form-control" id="nasi_goreng" name="nasi_goreng" min="0" value="0">
            </div>

            <!-- Menu Ayam Goreng -->
            <div class="menu-item">
                <label for="ayam_goreng" class="form-label">Ayam Goreng (Rp 12.000)</label>
                <input type="number" class="form-control" id="ayam_goreng" name="ayam_goreng" min="0" value="0">
            </div>

            <!-- Menu Es Teh -->
            <div class="menu-item">
                <label for="es_teh" class="form-label">Es Teh (Rp 2.000)</label>
                <input type="number" class="form-control" id="es_teh" name="es_teh" min="0" value="0">
            </div>

            <!-- Menu Kopi -->
            <div class="menu-item">
                <label for="kopi" class="form-label">Kopi (Rp 3.000)</label>
                <input type="number" class="form-control" id="kopi" name="kopi" min="0" value="0">
            </div>

            <!-- Tombol Hitung -->
            <button type="submit" name="hitung" class="btn btn-primary w-100">Hitung Total</button>
        </form>

        <?php
        // Proses perhitungan total pesanan
        if (isset($_POST['hitung'])) {
            // Harga masing-masing menu
            $harga_nasi_goreng = 10000;
            $harga_ayam_goreng = 12000;
            $harga_es_teh = 2000;
            $harga_kopi = 3000;

            // Jumlah pesanan dari form
            $jumlah_nasi_goreng = isset($_POST['nasi_goreng']) ? (int)$_POST['nasi_goreng'] : 0;
            $jumlah_ayam_goreng = isset($_POST['ayam_goreng']) ? (int)$_POST['ayam_goreng'] : 0;
            $jumlah_es_teh = isset($_POST['es_teh']) ? (int)$_POST['es_teh'] : 0;
            $jumlah_kopi = isset($_POST['kopi']) ? (int)$_POST['kopi'] : 0;

            // Hitung total harga
            $total_nasi_goreng = $jumlah_nasi_goreng * $harga_nasi_goreng;
            $total_ayam_goreng = $jumlah_ayam_goreng * $harga_ayam_goreng;
            $total_es_teh = $jumlah_es_teh * $harga_es_teh;
            $total_kopi = $jumlah_kopi * $harga_kopi;

            // Total keseluruhan
            $total_pesanan = $total_nasi_goreng + $total_ayam_goreng + $total_es_teh + $total_kopi;

            // Tampilkan hasil
            echo "<div class='result'>";
            echo "<h3>Total Pesanan: Rp " . number_format($total_pesanan, 0, ',', '.') . "</h3>";
            echo "</div>";
        }
        ?>
    </div>

    <!-- Menghubungkan Bootstrap JS (opsional, jika diperlukan) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>