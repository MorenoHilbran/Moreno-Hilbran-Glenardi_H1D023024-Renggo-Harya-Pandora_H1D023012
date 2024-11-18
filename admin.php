<?php
function isActive($path) {
  return ($_SERVER['REQUEST_URI'] === $path) ? 'text-white font-bold' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>halo</p>
    <form method="POST" action="logout.php">
    <button type="submit">Logout</button>
  </form>

  <a href="home.php" class="<?php echo isActive('/home'); ?>">Home</a>
</body>
</html>