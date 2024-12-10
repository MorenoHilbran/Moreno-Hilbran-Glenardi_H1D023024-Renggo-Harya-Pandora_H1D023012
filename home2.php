<?php
session_start();
include ("connect.php");
include("auth.php");
checkAccess('user'); // Hanya user yang dapat mengakses halaman ini

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
    
    button {
      margin: 10px;
      padding: 10px 20px;
      background-color:  #319795;
      color: #fff;
      border: none;
      cursor: pointer;
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
        
        <a href="logout.php"><button class="button">Logout</button></a>
    </div>
</nav>

<header class="bg-no-repeat bg-cover bg-center h-screen" style="background-image: linear-gradient(rgba(56, 178, 172, 0.8), rgba(56, 178, 172, 0.8)), url(assets/header.jpeg)">
    <!-- Bagian Teks -->
    <div class="relative z-10 text-white p-10 ml-10">
        <p class="font-light text-3xl mt-40 mb-5">Selamat datang, <?= $_SESSION['username'] ?>!</p>
        <h1 class="text-7xl font-bold">
            <span class="block" style="color:white">Solusi Hidup Sehat</span>
            <span class="font-semibold mb-4 block" style="color: white">Dengan Diagnosa Awal dan Tepat</span>
        </h1>
        <p class="text-2xl mt-5">
            Diagnosa Penyakit Dada<br> 
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
  
<!-- CARA KERJA KAMI Section -->
<section class="py-16 text-white" style="background-image: linear-gradient(rgba(56, 178, 172, 0.8), rgba(56, 178, 172, 0.8)), url(assets/bg-about.jpg); background-size: cover; background-position: center;">
    <div class="text-center mt-10 mb-8">
        <h2 class="text-xl font-light">
            CARA KERJA KAMI
        </h2>
        <h3 class="text-4xl font-bold mt-6">
            Langkah Mudah Bersama WeCare
        </h3>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-8 max-w-screen-lg mx-auto mb-10">
        <!-- Card 1 -->
        <div class="p-6 bg-white text-gray-800 border-2 border-gray-200 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <h4 class="text-2xl font-semibold text-center text-teal-500 mb-4">1. Isi Data Pendaftaran Akun</h4>
            <p class="text-base text-center">
                Pengguna diharuskan mempunyai akun terlebih dahulu sebelum menggunakan fitur yang kami sediakan
                hanya perlu membuat username dan password yang kami butuhkan untuk membuat database pengguna.
            </p>
        </div>

        <!-- Card 2 -->
        <div class="p-6 bg-white text-gray-800 border-2 border-gray-200 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <h4 class="text-2xl font-semibold text-center text-teal-500 mb-4">2. Fitur Diagnosa</h4>
            <p class="text-base text-center">
                Sistem WeCare akan mendiagnosa pengguna menggunakan sistem decision tree untuk mendeteksi penyakit dada yang anda alami
                ketika sudah terdiagnosa maka pengguna diharuskan mengisi kolom laporan sesuai dengan hasil dari diagnosa.
            </p>
        </div>

        <!-- Card 3 -->
        <div class="p-6 bg-white text-gray-800 border-2 border-gray-200 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-lg">
            <h4 class="text-2xl font-semibold text-center text-teal-500 mb-4">3. Fitur Riwayat</h4>
            <p class="text-base text-center">
                Pengguna dapat melihat tabel riwayat laporan pengguna dan juga rekomendasi langkah medis selanjutnya sebagai saran/masukan dari dokter
                termasuk pencegahan atau konsultasi yang akan diberikan oleh dokter spesialis.
            </p>
        </div>
    </div>
</section>

<!-- EDUKASI Section -->
<section class="py-16 bg-gray-100" id="edukasi">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-teal-600">Edukasi Kesehatan</h2>
        <p class="text-lg text-gray-600 mt-4">Pelajari lebih lanjut tentang pencegahan dan penanganan penyakit kardiovaskular.</p>
    </div>

    <!-- Gagal Jantung -->
    <div class="flex flex-col lg:flex-row items-center gap-8 px-8 mb-12 max-w-screen-lg mx-auto">
        <div class="w-full lg:w-1/2">
            <img src="assets/gagaljantung.png" alt="Gagal Jantung" class="w-full aspect-video object-cover rounded-lg shadow-lg">
        </div>
        <div class="text-left">
            <h3 class="text-2xl font-semibold mb-4" style="color:#319795;">Gagal Jantung</h3>
            <p class="text-gray-600 mb-4">
                Gagal jantung adalah kondisi di mana jantung tidak dapat memompa darah sesuai kebutuhan tubuh. 
                Gejalanya meliputi sesak napas, kelelahan, dan pembengkakan kaki. Pencegahan meliputi gaya hidup sehat seperti 
                berhenti merokok, olahraga, dan diet seimbang.
            </p>
            <a href="#detail-gagal-jantung" class="text-teal-600 font-medium hover:underline">Baca selengkapnya →</a>
        </div>
    </div>

    <!-- Hipertensi -->
    <div class="flex flex-col-reverse lg:flex-row items-center gap-8 px-8 mb-12 max-w-screen-lg mx-auto">
        <div class="text-left">
            <h3 class="text-2xl font-semibold mb-4" style="color:#319795;">Hipertensi</h3>
            <p class="text-gray-600 mb-4">
                Hipertensi atau tekanan darah tinggi adalah kondisi dengan tekanan darah >140/90 mmHg. 
                Penyebabnya termasuk gaya hidup, obesitas, atau masalah ginjal. Pencegahan melibatkan pengurangan asupan garam, olahraga, dan kontrol stres.
            </p>
            <a href="#detail-hipertensi" class="text-teal-600 font-medium hover:underline">Baca selengkapnya →</a>
        </div>
        <div class="w-full lg:w-1/2">
            <img src="assets/hipertensi.webp" alt="Hipertensi" class="w-full aspect-video object-cover rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Infark Miokard -->
    <div class="flex flex-col lg:flex-row items-center gap-8 px-8 max-w-screen-lg mx-auto">
        <div class="w-full lg:w-1/2">
            <img src="assets/infark.webp" alt="Infark Miokard" class="w-full aspect-video object-cover rounded-lg shadow-lg">
        </div>
        <div class="text-left">
            <h3 class="text-2xl font-semibold mb-4" style="color:#319795;">Infark Miokard</h3>
            <p class="text-gray-600 mb-4">
                Infark miokard (serangan jantung) terjadi saat aliran darah ke otot jantung terhambat. Gejalanya meliputi nyeri dada dan keringat dingin. 
                Pengobatan meliputi pemberian aspirin, nitrogliserin, dan prosedur PCI.
            </p>
            <a href="#detail-infark-miokard" class="text-teal-600 font-medium hover:underline">Baca selengkapnya →</a>
        </div>
    </div>
</section>



<footer style="background-color: #38b2ac; color: white; display: block; position: relative; z-index: 10;">
    <div class="p-5 text-center">
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

