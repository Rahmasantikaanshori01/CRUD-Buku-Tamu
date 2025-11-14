<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ZieBukuTamu</title>

    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Zie BukuTamu</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="buku-tamu.php">
            <i class="fas fa-fw fa-book"></i>
            <span>Buku Tamu</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="laporan.php">
            <i class="fas fa-fw fa-file"></i>
            <span>Laporan</span>
        </a>
    </li>

    <!-- 🔥 PERBAIKAN PENTING: tampilkan menu User hanya untuk admin & operator -->
<?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin','operator'])): ?>
    <li class="nav-item">
        <a class="nav-link" href="users.php">
            <i class="fas fa-fw fa-users"></i>
            <span>User</span>
        </a>
    </li>
<?php endif; ?>


    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a href="logout.php" class="nav-link">
            <i class="fas fa-fw fa-power-off"></i>
            <span>Logout</span>
        </a>
    </li>
    <!-- 🔥 Sidebar Toggler (ini yang membuat tombol panah muncul) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<div id="content-wrapper" class="d-flex flex-column">

<div id="content">
