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

<section class="border border-gray-400 width-full p-20">
  <h1>Selamat Datang, <?= $_SESSION['username'] ?>!</h1>
  <h2>Diagnosa Penyakit Dada dengan Decision Tree</h2>
<!-- Decision Tree -->
<div id="decision-tree">
    <div class="question-container" id="step1">
        <h3>1. Apakah Anda merasakan nyeri di dada?</h3>
        <button onclick="nextStep(2)">Yes</button>
        <button onclick="nextStep(15)">No</button>
    </div>
    <div class="question-container" id="step2">
        <h3>2. Apakah nyeri muncul tiba-tiba, sangat parah seperti robek, dan menjalar ke punggung?</h3>
        <button onclick="diagnosis('Diseksi Aorta (Aortic Dissection)')">Yes</button>
        <button onclick="nextStep(3)">No</button>
    </div>
    <div class="question-container" id="step3">
        <h3>3. Apakah nyerinya seperti ditekan berat, berlangsung >20 menit, menjalar ke lengan, rahang, atau punggung, disertai keringat dingin, mual, atau sulit bernapas?</h3>
        <button onclick="diagnosis('Serangan Jantung (Acute Coronary Syndrome)')">Yes</button>
        <button onclick="nextStep(4)">No</button>
    </div>
    <div class="question-container" id="step4">
        <h3>4. Apakah nyeri muncul saat beraktivitas dan hilang saat istirahat atau setelah menggunakan semprotan nitrat?</h3>
        <button onclick="diagnosis('Angina Stabil(Stable Angina)')">Yes</button>
        <button onclick="nextStep(5)">No</button>
    </div>
    <div class="question-container" id="step5">
        <h3>5. Apakah nyeri terasa tajam, terlokalisasi di satu titik, dan lebih sakit jika ditekan atau tubuh bergerak?</h3>
        <button onclick="diagnosis('Nyeri Otot/Tulang (Costochondritis)')">Yes</button>
        <button onclick="nextStep(6)">No</button>
    </div>
    <div class="question-container" id="step6">
        <h3>6. Apakah nyeri bertambah saat bernapas dalam, disertai demam atau sesak napas?</h3>
        <button onclick="diagnosis('Pneumonia atau Pulmonary Embolism')">Yes</button>
        <button onclick="nextStep(7)">No</button>
    </div>
    <div class="question-container" id="step7">
        <h3>7. Apakah nyeri terasa panas, lebih buruk setelah makan atau saat berbaring, dan membaik dengan obat maag?</h3>
        <button onclick="diagnosis('GERD atau Peptic Ulcer')">Yes</button>
        <button onclick="nextStep(8)">No</button>
    </div>
    <div class="question-container" id="step8">
        <h3>8. Apakah Anda mengalami demam tinggi, batuk berdahak, atau nyeri saat bernapas?</h3>
        <button onclick="diagnosis('Pneumonia atau Tuberculosis')">Yes</button>
        <button onclick="nextStep(9)">No</button>
    </div>
    <div class="question-container" id="step9">
        <h3>9. Apakah nyeri disertai rasa terbakar atau gatal di sekitar kulit dengan ruam kecil?</h3>
        <button onclick="diagnosis('Herpes Zoster')">Yes</button>
        <button onclick="nextStep(10)">No</button>
    </div>
    <div class="question-container" id="step10">
        <h3>10. Apakah nyeri berlangsung lama tanpa gejala lain dan berhubungan dengan stres atau kecemasan?</h3>
        <button onclick="diagnosis('Nyeri Psikogenik (Psychogenic Chest Pain)')">Yes</button>
        <button onclick="nextStep(11)">No</button>
    </div>
    <div class="question-container" id="step11">
        <h3>11. Apakah Anda sering merasa lelah, pusing, atau pucat dengan nyeri dada ringan?</h3>
        <button onclick="diagnosis('Anemia')">Yes</button>
        <button onclick="nextStep(12)">No</button>
    </div>
    <div class="question-container" id="step12">
        <h3>12. Apakah Anda memiliki batuk berkepanjangan, sesak napas dengan riwayat merokok?</h3>
        <button onclick="diagnosis('Penyakit Paru Kronis (COPD)')">Yes</button>
        <button onclick="nextStep(13)">No</button>
    </div>
    <div class="question-container" id="step13">
        <h3>13. Apakah nyeri muncul setelah kecelakaan atau benturan?</h3>
        <button onclick="diagnosis('Cedera Tulang Rusuk atau Trauma Dada')">Yes</button>
        <button onclick="nextStep(14)">No</button>
    </div>
    <div class="question-container" id="step14">
        <h3>14. Apakah nyeri dada disertai tekanan darah sangat tinggi (>180/110 mmHg)?</h3>
        <button onclick="diagnosis('Hipertensi Darurat (Hypertensive Emergency)')">Yes</button>
        <button onclick="nextStep(15)">No</button>
    </div>
    <div class="question-container" id="step15">
        <h3>15. Apakah Anda merasa sulit bernapas tanpa nyeri dada?</h3>
        <button onclick="diagnosis('Pulmonary Embolism atau Chronic Respiratory Disease')">Yes</button>
        <button onclick="diagnosis('Lakukan konsultasi ke dokter')">No</button>
    </div>
</div>

  <div id="result" class="hidden">
    <h2>Anda Didiagnosa:</h2>
    <p class="text-center font-bold text-3xl mb-10" style="color: #38b2ac" id="diagnosis"></p>
    <button style="display: block; margin: 0 auto;" class="center" onclick="restart()">Restart</button>
  </div>
</section>

<section class="flex py-16 mx-24">
  <script>
    let currentStep = 1;

    function nextStep(step) {
  // Hide the current active step
  const currentStepElement = document.getElementById(`step${currentStep}`);
  if (currentStepElement) {
    currentStepElement.classList.remove('active');
  }

  // Show the next step
  const nextStepElement = document.getElementById(`step${step}`);
  if (nextStepElement) {
    nextStepElement.classList.add('active');
    currentStep = step; // Update the current step to the new step
  } else {
    console.error(`Step "${step}" not found!`);
  }
}

    function diagnosis(result) {
      document.getElementById(`step${currentStep}`).classList.remove('active');
      document.getElementById('diagnosis').innerText = result;
      document.getElementById('result').style.display = 'block';
    }

    function restart() {
      document.getElementById('result').style.display = 'none';
      nextStep(1);
    }

    // Initialize the first step
    document.getElementById('step1').classList.add('active');
  </script>

  <!-- User Report Form -->
  <div class="container">
    <h3>Buat Laporan Baru</h3>
    <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    <form method="POST">
      <textarea name="diagnosa" id="diagnosa" placeholder="Hasil Diagnosa" required></textarea><br>
      <button type="submit">Kirim Laporan</button>
    </form>
  </div>

  <!-- User Report List -->
  <div class="laporan-list">
    <h3>Laporan Anda</h3>
    <div class="overflow-y-scroll border border-gray-400" style="max-height: 600px;">
    <?php if (count($laporan) > 0): ?>
      <?php foreach ($laporan as $item): ?>
        <div class="laporan-item">
          <p><strong>Tanggal:</strong> <?= $item['tanggal_periksa'] ?></p>
          <p><strong>Diagnosa:</strong> <?= htmlspecialchars($item['diagnosa']) ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>Belum ada laporan.</p>
    <?php endif; ?>
  </div>
</section>

<footer style="background-color: #38b2ac; color: white; display: block; position: relative; z-index: 10;">
    <div class="container text-center">
        <p>&copy; 2024 WeCare. All rights reserved.</p>
    </div>
</footer>

</body>
</html>