<?php
// Start session
session_start();

// Simulasi login - ganti ini dengan sistem login sesungguhnya
if (!isset($_SESSION['username'])) {
    // Jika user belum login, arahkan ke halaman login
    header('Location: login.php');
    exit;
}

include("connect.php");
function isActive($path) {
  return ($_SERVER['REQUEST_URI'] === $path) ? 'text-white font-bold' : '';
}
// Tangani pembuatan laporan
$success = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['diagnosa'])) {
    $username = $_SESSION['username'];
    $diagnosa = mysqli_real_escape_string($connect, $_POST['diagnosa']);
    $query = "INSERT INTO laporan (username, diagnosa) VALUES ('$username', '$diagnosa')";

    if (mysqli_query($connect, $query)) {
        $success = "Laporan berhasil dibuat!";
    } else {
        $success = "Terjadi kesalahan: " . mysqli_error($connect);
    }
}

// Ambil laporan user untuk ditampilkan
$laporan = [];
$queryLaporan = "SELECT * FROM laporan WHERE username = '" . $_SESSION['username'] . "'";
$resultLaporan = mysqli_query($connect, $queryLaporan);
while ($row = mysqli_fetch_assoc($resultLaporan)) {
    $laporan[] = $row;
}
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
  
    .laporan-item {
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }
    h1 {
        text-align: center;
        font-size: 45px;
        color: #38b2ac;
        margin-top: 30px;
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

<!-- Section Wrapper -->
<section class="w-full mx-auto mt-15 p-8 bg-white shadow-lg border border-gray-400">
  <h1 class="text-2xl font-bold text-gray-700 text-center mb-4">
    Selamat Datang, <?= $_SESSION['username'] ?>!
  </h1>
  <h2 class="text-xl text-teal-600 text-center font-semibold mb-6">
    Diagnosa Penyakit Dada dengan Decision Tree
  </h2>

  <!-- Tombol Mulai Diagnosa -->
  <div id="start-section" class="text-center">
    <button id="start-button" class="px-6 py-3 bg-teal-500 text-white font-semibold rounded-lg hover:bg-teal-600">
      Mulai Diagnosa
    </button>
  </div>

  <!-- Popup -->
  <div id="popup" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 text-center">
      <h3 id="question" class="text-lg font-medium text-gray-800 mb-4">
        <!-- Pertanyaan akan dimasukkan secara dinamis -->
      </h3>
      <div class="flex gap-4 justify-center">
        <button id="yes-button" class="py-2 px-4 bg-teal-500 text-white font-semibold rounded-lg hover:bg-teal-600">
          Yes
        </button>
        <button id="no-button" class="py-2 px-4 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600">
          No
        </button>
      </div>
    </div>
  </div>

  <!-- Diagnosis Result -->
  <div id="result" class="hidden text-center mt-8">
    <h2 class="text-2xl font-bold text-teal-600 mb-4">
      Anda Didiagnosa:
    </h2>
    <p class="text-lg font-medium text-gray-700 mb-6" id="diagnosis"></p>
    <button class="px-6 py-2 bg-teal-500 text-white font-semibold rounded-lg hover:bg-teal-600" onclick="restart()">
      Restart
    </button>
  </div>
</section>

<script>
  // Question data
  const questions = [
    { text: "Apakah Anda merasakan nyeri di dada?", yes: 2, no: 15 },
    { text: "Apakah nyeri muncul tiba-tiba, sangat parah seperti robek, dan menjalar ke punggung?", yes: 'Diseksi Aorta (Aortic Dissection)', no: 3 },
    { text: "Apakah nyerinya seperti ditekan berat, berlangsung >20 menit, menjalar ke lengan, rahang, atau punggung, disertai keringat dingin, mual, atau sulit bernapas?", yes: 'Serangan Jantung (Acute Coronary Syndrome)', no: 4 },
    { text: "Apakah nyeri muncul saat beraktivitas dan hilang saat istirahat atau setelah menggunakan semprotan nitrat?", yes: 'Angina Stabil(Stable Angina)', no: 5 },
    { text: "Apakah Anda merasa sulit bernapas tanpa nyeri dada?", yes: 'Pulmonary Embolism atau Chronic Respiratory Disease', no: 'Lakukan konsultasi ke dokter' }
  ];

  // Elements
  const popup = document.getElementById('popup');
  const questionElement = document.getElementById('question');
  const yesButton = document.getElementById('yes-button');
  const noButton = document.getElementById('no-button');
  const resultSection = document.getElementById('result');
  const diagnosisElement = document.getElementById('diagnosis');
  const startSection = document.getElementById('start-section');
  const startButton = document.getElementById('start-button');

  let currentStep = 0;

  // Show popup
  function showPopup(step) {
    currentStep = step;
    const question = questions[step - 1];
    questionElement.textContent = question.text;

    yesButton.onclick = () => {
      if (typeof question.yes === 'string') {
        showDiagnosis(question.yes);
      } else {
        showPopup(question.yes);
      }
    };

    noButton.onclick = () => {
      if (typeof question.no === 'string') {
        showDiagnosis(question.no);
      } else {
        showPopup(question.no);
      }
    };

    popup.classList.remove('hidden');
  }

  // Show diagnosis
  function showDiagnosis(diagnosis) {
    popup.classList.add('hidden');
    resultSection.classList.remove('hidden');
    diagnosisElement.textContent = diagnosis;
  }

  // Restart process
  function restart() {
    resultSection.classList.add('hidden');
    startSection.classList.remove('hidden');
  }

  // Mulai Diagnosa
  startButton.onclick = () => {
    startSection.classList.add('hidden');
    showPopup(1);
  };
</script>

  <!-- User Report Form -->
  <div class="container border border-gray-300 bg-white rounded-lg shadow p-6 flex justify-between">
    <div class="flex-1 mr-4">
      <h3 class="text-2xl font-bold mb-4">Buat Laporan Baru</h3>
      <?php if (!empty($success)) echo "<p class='text-green-500 font-bold'>$success</p>"; ?>
      <form method="POST">
        <textarea name="diagnosa" id="diagnosa" placeholder="Hasil Diagnosa" required class="w-full p-4 border border-gray-300 rounded-lg"></textarea><br>
        <button type="submit" style="background:#38b2ac" class="hover:opacity-80 text-white font-bold py-2 px-4 rounded-lg">Kirim Laporan</button>
      </form>
    </div>

    <!-- User Report List -->
    <div class="laporan-list flex-1 ml-4">
      <h3 class="text-2xl font-bold mb-4">Laporan Anda</h3>
      <div class="overflow-y-scroll border border-gray-400 rounded-lg shadow p-4" style="max-height: 600px;">
        <?php if (count($laporan) > 0): ?>
          <?php foreach ($laporan as $item): ?>
            <div class="laporan-item bg-white p-4 rounded-lg shadow mb-4">
              <p><strong>Tanggal:</strong> <?= $item['tanggal_periksa'] ?></p>
              <p><strong>Diagnosa:</strong> <?= htmlspecialchars($item['diagnosa']) ?></p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center p-4">Belum ada laporan.</p>
        <?php endif; ?>
      </div>
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
