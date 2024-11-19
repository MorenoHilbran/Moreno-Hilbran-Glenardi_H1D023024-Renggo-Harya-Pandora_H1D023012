<?php

// Koneksi ke database
include 'connect.php';

// Fungsi untuk memeriksa apakah path yang diberikan aktif atau tidak
function isActive($path) {
    return (basename($_SERVER['REQUEST_URI']) === $path) ? 'text-white font-bold bg-teal-600 rounded px-4 py-2' : 'text-teal-100 px-4 py-2 hover:bg-teal-400 hover:text-white rounded';
}

// Mengambil jumlah pasien terdaftar
$queryTotalPatients = "SELECT COUNT(*) AS total FROM user";
$resultTotalPatients = mysqli_query($connect, $queryTotalPatients);
$totalPatients = ($resultTotalPatients && mysqli_num_rows($resultTotalPatients) > 0) ? mysqli_fetch_assoc($resultTotalPatients)['total'] : 0;

// Mengambil data penyakit dari tabel laporan
$queryDiseases = "
    SELECT diagnosa, COUNT(*) AS total 
    FROM laporan 
    GROUP BY diagnosa
";
$resultDiseases = mysqli_query($connect, $queryDiseases);

$diseases = [];
while ($row = mysqli_fetch_assoc($resultDiseases)) {
    $diseases[$row['diagnosa']] = $row['total'];
}

// Mengambil jumlah laporan yang belum ditindaklanjuti
$queryPendingReports = "SELECT COUNT(*) AS total FROM laporan WHERE tindak_lanjut IS NULL";
$resultPendingReports = mysqli_query($connect, $queryPendingReports);
$totalPendingReports = ($resultPendingReports && mysqli_num_rows($resultPendingReports) > 0) ? mysqli_fetch_assoc($resultPendingReports)['total'] : 0;

// Mengambil jumlah laporan yang sudah ditindaklanjuti
$queryHandledReports = "SELECT COUNT(*) AS total FROM laporan WHERE tindak_lanjut IS NOT NULL";
$resultHandledReports = mysqli_query($connect, $queryHandledReports);
$totalHandledReports = ($resultHandledReports && mysqli_num_rows($resultHandledReports) > 0) ? mysqli_fetch_assoc($resultHandledReports)['total'] : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="header">
                <div class="list-item">
                    <a href="#">
                        <img src="assets/" alt="" class="icon">
                        <span class="description-header">We Care</span>
                    </a>
                </div>
            </div>
            <div class="illustration">
                <img src="assets/trial.png" alt="Illustration">
            </div>
            <div class="main">
                <div class="list-item flex items-center">
                    <img src="assets/Dashboard.svg" alt="" class="icon ml-4">
                    <a href="admin.php" class="<?php echo isActive('admin.php'); ?>">
                        <span class="description ml-2">Dashboard</span>
                    </a>
                </div>
                <div class="list-item flex items-center">
                    <img src="assets/profile.svg" alt="" class="icon w-6 h-6 ml-3">
                    <a href="daftarpasien.php" class="<?php echo isActive('daftarpasien.php'); ?>">
                        <span class="description ml-1">Daftar Pasien</span>
                    </a>
                </div>
                <div class="list-item flex items-center">
                    <img src="assets/report.svg" alt="" class="icon ml-3">
                    <a href="result.php" class="<?php echo isActive('result.php'); ?>">
                        <span class="description ml-1">Hasil Diagnosa</span>
                    </a>
                </div>
                <div class="list-item-logout">
                    <a href="logout.php" class="text-red-500">
                        <span class="description">Logout</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="main-content">
                <h2 class="text-2xl font-bold p-6">Dashboard</h2>

                <!-- Statistik Singkat -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white ml-3 p-6 rounded shadow border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-700">Jumlah Pasien Terdaftar</h3>
                        <p class="text-3xl font-bold text-teal-500 mt-2"><?= $totalPatients ?></p>
                    </div>
                    <div class="bg-white p-6 rounded shadow border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-700">Laporan Belum Ditindaklanjuti</h3>
                        <p class="text-3xl font-bold text-red-500 mt-2"><?= $totalPendingReports ?></p>
                    </div>
                    <div class="bg-white mr-3 p-6 rounded shadow border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-700">Laporan Sudah Ditindaklanjuti</h3>
                        <p class="text-3xl font-bold text-green-500 mt-2"><?= $totalHandledReports ?></p>
                    </div>
                </div>

                <!-- Grafik Penyakit -->
                <div class="bg-white p-5 rounded shadow w-full border border-gray-200 mt-5 chart-container">
                      <h3 class="text-lg font-bold text-gray-700">Macam-Macam Diagnosa (Diagram Lingkaran)</h3>
                        <div class="relative">
                          <canvas id="diseaseChart"></canvas>
    </div>
</div>
        </div>
    </div>

    <!-- Script untuk Chart.js -->
    <script>
        // Data untuk diagram lingkaran
        const diseaseData = {
            labels: <?= json_encode(array_keys($diseases)) ?>,
            datasets: [{
                data: <?= json_encode(array_values($diseases)) ?>,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                ],
                hoverOffset: 4
            }]
        };

        // Konfigurasi Chart.js
        const config = {
            type: 'pie',
            data: diseaseData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333' // Warna teks di legenda
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const value = tooltipItem.raw;
                                const total = diseaseData.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${tooltipItem.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        };

        // Render Chart
        const diseaseChart = new Chart(
            document.getElementById('diseaseChart'),
            config
        );
    </script>
</body>
</html>
