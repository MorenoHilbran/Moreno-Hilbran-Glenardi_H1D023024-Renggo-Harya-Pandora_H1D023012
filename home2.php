<?php
session_start();
include ("connect.php");
// Fungsi untuk memeriksa apakah path saat ini sama dengan route tertentu
function isActive($path) {
    return ($_SERVER['REQUEST_URI'] === $path) ? 'text-white font-bold' : '';
}
?>
<?php
  $anggota1 = 'assets/anggota1.jpeg';
  $anggota2 = 'assets/anggota2.jpeg';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <title>Home - WeCare</title>
    <style>
        /* CSS Styles */
        body { margin:0; padding: 0; font-family: Arial, sans-serif; }

        .navbar { display: flex; gap : 310px; align-items: center; margin-left: 20px; background-color: white; color: #38b2ac; justify-content: space-between; }
        .brand { font-size: 10px; font-weight: bold; margin-right: 40px; width: 200px; }
        .menu { display: flex; gap: 20px; list-style: none; padding: 0; }
        .menu li a { text-decoration: none; }
        .menu li a.active { font-weight: bold; }
        .button { background-color: #319795; color: white; padding: 10px; border-radius: 10px; font-weight: bold; border: none; }
        .button:hover { background-color: #2c7a7b; }
    </style>
</head>

<body>
<nav class="navbar">
    <!-- Logo/Brand -->
    <div><img src="assets/logo_base.png" class="brand" alt="WeCare"></div>
    <!-- Menu Links -->
    <ul class="menu">
        <li>
            <a href="home2.php" class="<?php echo isActive('home2.php'); ?>">Home</a>
        </li>
        <li>
            <a href="diagnose.php" class="<?php echo isActive('/diagnose'); ?>">Diagnose</a>
        </li>
        <li>
            <a href="riwayat.php" class="<?php echo isActive('riwayat.php'); ?>">Riwayat</a>
        </li>
    </ul>
    <div class="flex space-x-2 mr-10">
        <?php if (isset($_SESSION['username'])): ?>
            <h1 class="text-2xl font-bold mt-2 mr-2">Selamat Datang, <?php echo $_SESSION['username']; ?></h1>
        <?php endif; ?>
        <a href="login.php"><button class="button">Logout</button></a>
    </div>
</nav>

<header class="bg-no-repeat bg-cover bg-center h-screen" style="background-image: linear-gradient(rgba(56, 178, 172, 0.8), rgba(56, 178, 172, 0.8)), url(assets/header.jpeg)">
    <!-- Bagian Teks -->
    <div class="relative z-10 text-white p-10 ml-10">
        <p class="font-light text-3xl mt-40 mb-5">Mari, untuk hidup sehat</p>
        <h1 class="text-7xl font-bold">
            <span class="block" style="color:white">Solusi Hidup Sehat</span>
            <span class="font-semibold mb-4 block" style="color: white">Dengan Diagnosa Awal dan Tepat</span>
        </h1>
        <p class="text-2xl mt-5">
            Diagnosa Penyakit Umum<br> 
            <span class="mb-5"><b>dan rekomendasi pencegahan</b></span> yang tepat!
        </p>
        <a href="diagnose.php">
        <button class="bg-white mt-10 py-3 px-6 text-2xl rounded-md shadow-md hover:shadow-lg transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-teal-400 focus:ring-opacity-50" style="color: #38b2ac">
            Diagnosa Sekarang!
        </button>
        </a>
    </div>
</header>

<section class="mx-24 py-16 ">
    <h2 class="text-center text-4xl font-semibold p-8" style="color: #38b2ac;">
      OUR TEAM
    </h2>
    <div class="flex justify-center p-5 max-w-screen">
      <?php 
        // Card 1
        echo renderCard($anggota1, "Moreno Hilbran<br>H1D023024");
        // Card 2
        echo renderCard($anggota2, "Renggo Harya Pandora<br>H1D023012");
      ?>
    </div>
  </section>

<section class="flex py-16 mx-24">
    <!-- Bagian Gambar -->
    <div class="w-1/2 h-auto m-auto">
        <img src="assets/logo_base.png" class="h-3/4 w-auto ml-28" alt="Dokter">
    </div>

    <!-- Bagian Teks -->
    <div class="w-1/2 text-left m-auto p-10">
        <h2 class="font-light text-xl">
            TENTANG KAMI
        </h2>
        <h3 class="text-6xl font-bold mb-4 mt-4" style="color: #38b2ac;">
            WeCare
        </h3>
        <p class="text-lg mt-6 text-black">
            Meningkatkan kesadaran masyarakat Indonesia terhadap <br> pentingnya
            diagnosa lebih awal dengan pencegahan penyakit yang efektif. <br>
            WeCare hadir dengan solusi yang menggabungkan teknologi 
            dan pendekatan diagnosa tanpa harus ke dokter langsung
        </p>
    </div>
</section>

<footer style="background-color: #38b2ac; color: white; padding: 1rem 0; margin-top: 10rem; display: block; position: relative; z-index: 10;">
    <div class="container mx-auto text-center">
        <p>&copy; 2024 WeCare. All rights reserved.</p>
    </div>
</footer>

</body>
</html>

<?php
// Function to render each card
function renderCard($image, $title) {
    return '
      <div class="w-80 bg-white shadow-lg rounded-lg p-5 m-4 transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
        <img src="'.$image.'" alt="'.$title.'" class="w-full h-80 object-cover rounded-lg" />
        <h3 class="text-xl font-semibold text-center text-teal-400 mt-4">'.$title.'</h3>
      </div>
    ';
}
?>

