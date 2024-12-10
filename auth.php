<?php
// Memulai sesi jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Fungsi untuk memvalidasi akses halaman berdasarkan role
 * @param string $requiredRole Role yang diperlukan untuk mengakses halaman
 */
function checkAccess($requiredRole) {
    // Cek apakah pengguna memiliki role yang sesuai
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
        // Redirect ke halaman akses ditolak jika role tidak sesuai
        header("Location: login.php");
        exit();
    }
}

/**
 * Fungsi untuk memeriksa apakah pengguna sudah login
 * Jika belum, redirect ke halaman login
 */
function checkLogin() {
    if (!isset($_SESSION['username'])) {
        // Redirect ke halaman login jika belum login
        header("Location: login.php");
        exit();
    }
}
?>
