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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard - Chest Pain Diagnostic</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      line-height: 1.6;
    }
    .container {
      margin-bottom: 20px;
    }
    .question-container {
      display: none;
      margin-bottom: 20px;
    }
    .question-container.active {
      display: block;
    }
    button {
      margin: 10px;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }
    button:hover {
      background-color: #0056b3;
    }
    textarea {
      width: 100%;
      height: 100px;
      margin-bottom: 10px;
    }
    button {
      padding: 10px 20px;
      background-color: #007bff;
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
  <h1>Welcome, <?= $_SESSION['username'] ?>!</h1>
  <h2>Chest Pain Diagnostic Decision Tree</h2>

  <!-- Decision Tree -->
  <div id="decision-tree">
  <div class="question-container" id="step1">
      <h3>1. Apakah pasien mengalami nyeri dada?</h3>
      <button onclick="nextStep(2)">Yes</button>
      <button onclick="nextStep(8)">No</button>
    </div>

    <div class="question-container" id="step2">
      <h3>2. Apakah nyeri terjadi secara tiba-tiba, parah, terasa seperti robekan, dan menjalar ke punggung?</h3>
      <button onclick="diagnosis('Aortic Dissection')">Yes</button>
      <button onclick="nextStep(3)">No</button>
    </div>

    <div class="question-container" id="step3">
      <h3>3. Apakah nyeri terasa seperti ditekan, berlangsung &gt;20 menit, menjalar ke lengan/rahang/punggung, dan disertai keringat, mual, atau sesak napas?</h3>
      <button onclick="nextStep('3_1')">Yes</button>
      <button onclick="nextStep(4)">No</button>
    </div>

    <div class="question-container" id="step3_1">
      <h3>3.1 Perform ECG:</h3>
      <p>
        If ST-elevation → Diagnosis: STEMI. Proceed with PCI/thrombolysis.<br>
        If ST-depression → Diagnosis: NSTEMI/Unstable Angina. Measure troponin levels.<br>
        Otherwise, evaluate for non-cardiac causes.
      </p>
    </div>

    <div class="question-container" id="step4">
      <h3>4. Apakah nyeri terjadi saat aktivitas, reda dengan istirahat atau semprotan GTN, dan tidak menjalar?</h3>
      <button onclick="diagnosis('Stable Angina')">Yes</button>
      <button onclick="nextStep(5)">No</button>
    </div>

    <div class="question-container" id="step5">
      <h3>5. Apakah nyeri terlokalisir, tajam, dan memburuk saat ditekan atau bergerak?</h3>
      <button onclick="diagnosis('Musculoskeletal Pain (Costochondritis)')">Yes</button>
      <button onclick="nextStep(6)">No</button>
    </div>

    <div class="question-container" id="step6">
      <h3>6. Apakah nyeri terasa pleuritik (tajam, memburuk saat bernapas) dan disertai demam, batuk, atau sesak napas?</h3>
      <button onclick="diagnosis('Pneumonia or Pulmonary Embolism')">Yes</button>
      <button onclick="nextStep(7)">No</button>
    </div>

    <div class="question-container" id="step7">
      <h3>7. Apakah nyeri terasa terbakar, terkait dengan makan atau posisi berbaring, dan membaik dengan antasida?</h3>
      <button onclick="diagnosis('GERD or Peptic Ulcer Disease')">Yes</button>
      <button onclick="nextStep(2)">No</button>
    </div>

    <div class="question-container" id="step8">
      <h3>8. Apakah sesak napas terjadi mendadak, dengan hemoptysis (batuk berdarah) atau pembengkakan kaki unilateral?</h3>
      <button onclick="diagnosis('Pulmonary Embolism')">Yes</button>
      <button onclick="nextStep(9)">No</button>
    </div>

    <div class="question-container" id="step9">
      <h3>9. Apakah sesak napas disertai mengi, batuk berdahak, dan riwayat merokok?</h3>
      <button onclick="diagnosis('Chronic Obstructive Pulmonary Disease (COPD)')">Yes</button>
      <button onclick="nextStep(10)">No</button>
    </div>

    <div class="question-container" id="step10">
      <h3>10. Apakah ada demam, penurunan berat badan, berkeringat pada malam hari, dan batuk kronis?</h3>
      <button onclick="diagnosis('Tuberculosis (TB)')">Yes</button>
      <button onclick="diagnosis('Reassess symptoms or consider rarer causes')">No</button>
    </div>
  </div>

  <div id="result" style="display: none;">
    <h2>Diagnosis</h2>
    <p id="diagnosis"></p>
    <button onclick="restart()">Restart</button>
  </div>

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
      <label for="diagnosa">Diagnosa:</label><br>
      <textarea name="diagnosa" id="diagnosa" required></textarea><br>
      <button type="submit">Kirim Laporan</button>
    </form>
  </div>

  <!-- User Report List -->
  <div class="laporan-list">
    <h3>Laporan Anda</h3>
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

  <!-- Logout Button -->
  <form method="POST" action="logout.php">
    <button type="submit">Logout</button>
  </form>

  <a href="home.php" class="<?php echo isActive('/home'); ?>">Home</a>
</body>
</html>