<?php
session_start();
function isActive($path) {
    return (basename($_SERVER['REQUEST_URI']) === $path) ? 'text-white font-bold bg-teal-600 rounded px-4 py-2' : 'text-teal-100 px-4 py-2 hover:bg-teal-400 hover:text-white rounded';
}

include 'connect.php'; // File koneksi database
$success = "";
$error = "";

// Proses penghapusan user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $deleteQuery = "DELETE FROM user WHERE username = '$username'";

    if (mysqli_query($connect, $deleteQuery)) {
        $success = "User berhasil dihapus.";
    } else {
        $error = "Gagal menghapus user: " . mysqli_error($connect);
    }
}

// Ambil data dari tabel user
$query = "SELECT username, email FROM user";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
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
                    <a href="result.php" class="<?php echo isActive('daftarpasien.php'); ?>">
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
    <div class="main-content">
<!-- Konten -->
<h2 class="text-2xl font-bold p-6">Data User</h2>
<div class=" mx-auto mt-2 px-6">

    <!-- Pesan Sukses dan Error -->
    <?php if ($success): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <?= $success ?>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- Tabel Data User -->
    <div class="bg-white p-6 w-full rounded shadow-lg">
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-6 py-3">Username</th>
                        <th class="border border-gray-300 px-6 py-3">Email</th>
                        <th class="border border-gray-300 px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="border border-gray-300 px-6 py-3"><?= htmlspecialchars($row['username']) ?></td>
                            <td class="border border-gray-300 px-6 py-3"><?= htmlspecialchars($row['email']) ?></td>
                            <td class="border border-gray-300 px-6 py-3">
                                <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    <input type="hidden" name="username" value="<?= htmlspecialchars($row['username']) ?>">
                                    <button type="submit" name="delete_user" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

      
   <script src="script.js"></script>
</body>
</html>
