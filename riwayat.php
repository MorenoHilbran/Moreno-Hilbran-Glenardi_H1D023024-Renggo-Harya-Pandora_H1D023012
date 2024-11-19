<?php
// Start session
session_start();
include("connect.php");

// Simulasi login - ganti ini dengan sistem login sesungguhnya
if (!isset($_SESSION['username'])) {
    // Jika user belum login, arahkan ke halaman login
    header('Location: login.php');
    exit;
}

function isActive($path) {
  return ($_SERVER['REQUEST_URI'] === $path) ? 'text-white font-bold' : '';
}

$username = $_SESSION['username'];

// Query untuk mengambil semua riwayat laporan user
$queryHistory = "
    SELECT tanggal_periksa, diagnosa, tindak_lanjut 
    FROM laporan 
    WHERE username = ?
";

// Persiapkan dan jalankan query
$stmt = mysqli_prepare($connect, $queryHistory);
if (!$stmt) {
    die("Query gagal dipersiapkan: " . mysqli_error($connect));
}
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$resultHistory = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard - Chest Pain Diagnostic</title>
  <style>
    body { margin: 0; padding: 0; font-family: Arial, sans-serif; }
    .navbar { display: flex; gap: 400px; align-items: center; margin-left: 20px; background-color: white; color: #38b2ac; justify-content: space-between; }
    .brand { font-size: 10px; font-weight: bold; margin-right: 40px; width: 200px; }
    .menu { display: flex; gap: 20px; list-style: none; padding: 0; }
    .menu li a { text-decoration: none; }
    .menu li a.active { font-weight: bold; }
    .button { background-color: #319795; color: white; padding: 10px; border-radius: 10px; font-weight: bold; border: none; margin-left: 80px; }
    .button:hover { background-color: #2c7a7b; }

    .container {
      padding: 20px;
    }
    .question-container {
      display: none;
      margin-bottom: 20px;
      text-align: center;
    }

    .question-container.active {
      display: block;
      text-align: center;
      margin-top: 100px;
      height: 30vh;
    }

    button {
      margin: 10px;
      padding: 10px 20px;
      background-color:  #319795;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }
    textarea {
      width: 100%;
      height: 200px;
      margin-bottom: 10px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button:hover {
      background-color: #0056b3;
    }
    .laporan-list {
      margin-top: 20px;
    }
    .laporan-item {
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }
    h1 {
        text-align: center;
        font-size: 100px;
        color: #38b2ac;
    }
    h2 {
        text-align: center;
        font-size: 40px;
        padding: 20px;
        margin-top: 30px;
    }
    h3 {
        text-align: center;
        font-size: 30px;
        padding: 20px;
    }
  </style>
</head>
<body>
    
<nav class="navbar">
    <!-- Logo/Brand -->
    <div><img src="assets/logo_base.png" class="brand" alt="WeCare""></div>
    <!-- Menu Links -->
    <ul class="menu">
        <li>
            <a href="home2.php" class="<?php echo isActive('home2.php'); ?>">Home</a>
        </li>
        <li>
            <a href="diagnose.php" class="<?php echo isActive('diagnose.php'); ?>">Diagnose</a>
        </li>
        <li>
            <a href="riwayat.php" class="<?php echo isActive('riwayat.php'); ?>">Riwayat</a>
        </li>
    </ul>

        <a href="login.php"><button class="button">Logout</button></a>
    </div>
</nav>

<section class="border border-gray-400 width-full p-10">
<h1>Riwayat Laporan Anda</h1>
<?php if (mysqli_num_rows($resultHistory) > 0): ?>
<div class="overflow-x-auto mt-6">
    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead class="text-white" style="background-color: #38b2ac">
            <tr>
                <th class="px-6 py-3 border border-gray-300 text-left">Tanggal Periksa</th>
                <th class="px-6 py-3 border border-gray-300 text-left">Diagnosa</th>
                <th class="px-6 py-3 border border-gray-300 text-left">Status Tindak Lanjut</th>
                <th class="px-6 py-3 border border-gray-300 text-left">Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody class="bg-white text-gray-700">
            <?php while ($row = mysqli_fetch_assoc($resultHistory)): ?>
                <tr class="hover:bg-gray-100 transition duration-300">
                    <td class="px-6 py-4 border border-gray-300">
                        <?= htmlspecialchars($row['tanggal_periksa']) ?>
                    </td>
                    <td class="px-6 py-4 border border-gray-300">
                        <?= htmlspecialchars($row['diagnosa']) ?>
                    </td>
                    <td class="px-6 py-4 border border-gray-300">
                        <?= $row['tindak_lanjut'] ? '<span class="text-green-600 font-semibold">Sudah Ditindaklanjuti</span>' : '<span class="text-red-600 font-semibold">Belum Ditindaklanjuti</span>' ?>
                    </td>
                    <td class="px-6 py-4 border border-gray-300">
                        <?= $row['tindak_lanjut'] ? htmlspecialchars($row['tindak_lanjut']) : '<span class="text-gray-500">-</span>' ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
<div class="text-center mt-6">
    <p class="text-gray-500 text-lg">Tidak ada laporan yang dapat ditampilkan.</p>
</div>
<?php endif; ?>
</section>
<footer style="position: fixed; bottom: 0; width: 100%; background-color: #38b2ac; color: white;">
    <div class="container text-center">
        <p>&copy; 2024 WeCare. All rights reserved.</p>
    </div>
</footer>

</body>
</html>