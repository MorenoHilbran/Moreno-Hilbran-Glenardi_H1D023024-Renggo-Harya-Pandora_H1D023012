<?php

session_start();
// Fungsi untuk menentukan apakah link aktif
function isActive($path) {
    $currentPath = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); // Ambil path dari URL
    return ($currentPath === $path) ? 'text-white font-bold bg-teal-600 rounded px-4 py-2' : 'text-teal-100 px-4 py-2 hover:bg-teal-400 hover:text-white rounded';
}

// Koneksi ke database
include("connect.php");
$success = "";
$error = "";

// Proses penambahan tindak lanjut
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tindak_lanjut'])) {
    $id = intval($_POST['id']);
    $tindak_lanjut = mysqli_real_escape_string($connect, $_POST['tindak_lanjut']);

    $query = "UPDATE laporan SET tindak_lanjut = '$tindak_lanjut' WHERE id_laporan = $id";
    if (mysqli_query($connect, $query)) {
        $success = "Tindak lanjut berhasil ditambahkan.";
    } else {
        $error = "Terjadi kesalahan: " . mysqli_error($connect);
    }
}

// Ambil semua laporan dari tabel
$queryLaporan = "SELECT * FROM laporan ORDER BY tanggal_periksa DESC";
$resultLaporan = mysqli_query($connect, $queryLaporan);
$laporan = [];
while ($row = mysqli_fetch_assoc($resultLaporan)) {
    $laporan[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="sidebar" style="position: fixed;">
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
                <a href="logout.php">
                    <span class="description">Logout</span>
                </a>
            </div>
        </div>
    </div>
   <!-- Laporan Diagnosa Pengguna -->
<div class="mx-auto px-6 mt-8">
    <h2 class="text-2xl font-bold mb-6 ml-64">Laporan Diagnosa Pengguna</h2>

    <!-- Pesan Sukses dan Error -->
    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4 ml-64">
            <?= $success ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4 ml-64">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Laporan -->
    <div class="bg-white p-6 rounded shadow-lg ml-64" >
        <div class="overflow-x-auto max-h-screen overflow-y-scroll">
            <table class="table-auto w-full border-collapse border border-gray-400">
                <thead class="sticky top-0 bg-gray-200">
                    <tr class="text-left">
                        <th class="border border-gray-300 px-6 py-3">ID</th>
                        <th class="border border-gray-300 px-6 py-3">Username</th>
                        <th class="border border-gray-300 px-6 py-3">Hasil Diagnosa</th>
                        <th class="border border-gray-300 px-6 py-3">Tanggal</th>
                        <th class="border border-gray-300 px-6 py-3">Tindak Lanjut</th>
                        <th class="border border-gray-300 px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($laporan) > 0): ?>
                        <?php foreach ($laporan as $item): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-6 py-3"><?= $item['id_laporan'] ?></td>
                                <td class="border border-gray-300 px-6 py-3"><?= htmlspecialchars($item['username']) ?></td>
                                <td class="border border-gray-300 px-6 py-3"><?= htmlspecialchars($item['diagnosa']) ?></td>
                                <td class="border border-gray-300 px-6 py-3"><?= $item['tanggal_periksa'] ?></td>
                                <td class="border border-gray-300 px-6 py-3">
                                    <?= $item['tindak_lanjut'] ? htmlspecialchars($item['tindak_lanjut']) : "<span class='text-gray-500'>Belum ada</span>" ?>
                                </td>
                                <td class="border border-gray-300 px-6 py-3">
                                    <?php if (!$item['tindak_lanjut']): ?>
                                        <form method="POST" class="inline-block w-full">
                                            <textarea name="tindak_lanjut" placeholder="Tambahkan tindak lanjut..." class="w-full border p-2 rounded"></textarea>
                                            <input type="hidden" name="id" value="<?= $item['id_laporan'] ?>">
                                            <button type="submit" class="bg-green-300 text-white px-4 py-2 rounded mt-2 hover:opacity-80">Simpan</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-teal-700 font-bold">Tindak lanjut selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-600">Belum ada laporan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

      
   <script src="script.js"></script>
</body>
</html>
