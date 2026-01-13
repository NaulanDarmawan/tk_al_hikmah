<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $data['judul']; ?> | Rapor TK</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/adminlte/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/adminlte/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?php echo BASEURL; ?>" class="nav-link">Home</a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?php echo BASEURL; ?>" class="brand-link">
            <img src="<?php echo BASEURL; ?>/img/logo.png" alt="Logo TK" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">TK Al-Hikmah Malang</span>
        </a>

        <div class="sidebar">
            <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo BASEURL; ?>/img/default.jpg" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Nama Guru / Admin</a>
                </div>
            </div> -->

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-header">MENU UTAMA</li>
                    <li class="nav-item">
                        <a href="<?php echo BASEURL; ?>/siswa" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Data Siswa
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
    <a href="<?php echo BASEURL; ?>/penilaian" class="nav-link">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Penilaian Harian</p>
    </a>
</li>
                    <li class="nav-item">
                        <a href="<?php echo BASEURL; ?>/rapor" class="nav-link">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>
                                Input Rapor
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo BASEURL; ?>/cetak" class="nav-link"> <i class="nav-icon fas fa-print"></i>
                            <p>
                                Cetak Rapor
                            </p>
                        </a>
                    </li>                    
                </ul>
            </nav>
            </div>
        </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?php echo $data['judul']; ?></h1>
                    </div>
                    <div class="col-sm-6">
                        </div>
                </div>
            </div></section>

        <section class="content">
            <div class="container-fluid">