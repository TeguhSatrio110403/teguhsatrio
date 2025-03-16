<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitung Diskon</title>
    <!-- Menghubungkan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Hitung Diskon</h2>
        <!-- Form Input Total Belanja -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="total_belanja" class="form-label">Total Belanja (Rp):</label>
                <input type="number" class="form-control" id="total_belanja" name="total_belanja" min="0" required>
            </div>
            <button type="submit" name="hitung" class="btn btn-primary w-100">Hitung Diskon</button>
        </form>

        <?php
        // Fungsi untuk menghitung diskon
        function hitungDiskon($totalBelanja) {
            if ($totalBelanja >= 100000) {
                return 10; // Diskon 10%
            } elseif ($totalBelanja >= 50000) {
                return 5; // Diskon 5%
            } else {
                return 0; // Tidak ada diskon
            }
        }

        // Prosedur untuk menampilkan hasil perhitungan
        function tampilkanHasil($totalBelanja) {
            $persentaseDiskon = hitungDiskon($totalBelanja); // Memanggil fungsi hitungDiskon
            $diskon = $totalBelanja * ($persentaseDiskon / 100); // Hitung nilai diskon
            $totalBayar = $totalBelanja - $diskon;

            echo "<div class='result'>";
            echo "<p><strong>Total Belanja:</strong> Rp " . number_format($totalBelanja, 0, ',', '.') . "</p>";
            echo "<p><strong>Diskon:</strong> " . $persentaseDiskon . "% (Rp " . number_format($diskon, 0, ',', '.') . ")</p>";
            echo "<p><strong>Total Bayar:</strong> Rp " . number_format($totalBayar, 0, ',', '.') . "</p>";
            echo "</div>";
        }

        // Cek apakah form telah disubmit
        if (isset($_POST['hitung'])) {
            $totalBelanja = (int)$_POST['total_belanja']; // Ambil nilai total belanja dari form
            tampilkanHasil($totalBelanja); // Tampilkan hasil perhitungan
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>