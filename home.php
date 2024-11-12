<?php
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
    <title>Navbar - WeCare</title>
    <style>
        /* CSS Styles */
        body { margin:0; padding: 0; font-family: Arial, sans-serif; }

        .navbar { display: flex; justify-content: space-between; align-items: center; background-color: #38b2ac; color: white; }
        .brand { font-size: 24px; font-weight: bold; margin-left: 20px; }
        .menu { display: flex; gap: 20px; list-style: none; padding: 0; }
        .menu li a { text-decoration: none; }
        .menu li a.active { font-weight: bold; }
        .button { background-color: #319795; color: white; padding: 20px; border-radius: 10px; font-weight: bold; margin-right: 20px; border: none; }
        .button:hover { background-color: #2c7a7b; }
    </style>
</head>

<nav class="navbar">
    <!-- Logo/Brand -->
    <div class="brand">WeCare</div>

    <!-- Menu Links -->
    <ul class="menu">
        <li>
            <a href="home.php" class="<?php echo isActive('/home'); ?>">Home</a>
        </li>
        <li>
            <a href="diagnose.php" class="<?php echo isActive('/diagnose'); ?>">Diagnose</a>
        </li>
        <li>
            <a href="riwayat.php" class="<?php echo isActive('/riwayat'); ?>">Riwayat</a>
        </li>
    </ul>

    <button class="button">Contact Us</button>
</nav>

<header class="flex max-w-screen py-20">
    <!-- Bagian Teks -->
    <div class="w-3/4 m-auto h-auto ml-28 mb-20">
        <p class="font-light text-teal-500 text-3xl mt-5 mb-5">Mari, untuk hidup sehat</p>
        <h1 class="text-7xl font-bold">
            <span class="text-teal-500 font-bold mb-4 block">Solusi Hidup Sehat</span> 
            <span class="text-teal-500 font-semibold mb-4 block">Dengan Diagnosa Awal dan Tepat</span>
        </h1>
        <p class="text-2xl text-teal-500 mt-5">Diagnosa Penyakit Umum<br> 
            <span class="text-teal-500 mb-5"><b>merekomendasikan pencegahan</b></span> yang tepat!
        </p>
    </div>
    
    <!-- Bagian Gambar -->
    <div class="items-center w-3/4 m-auto mt-5 mr-16 pr-50 animate-floatimage">
        <img src="assets/header.jpeg" alt="dokter" class="size-fit" />
    </div>
</header>

<section class="mx-24 py-16">
    <h2 class="text-center text-3xl font-semibold text-teal-400 p-8">
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
        <h3 class="text-6xl text-teal-400 font-bold mb-4 mt-4">
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
        <p>&copy; 2023 WeCare. All rights reserved.</p>
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
