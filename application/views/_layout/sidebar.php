<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url('assets/'); ?>img/logo/logos.jpeg">
        </div>
        <div class="sidebar-brand-text mx-3">Kartimans Barber Shop</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="<?= base_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Features
    </div>
    <?php if($_SESSION['level'] == "4") : ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('element/pesan'); ?>">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Input Booking</span>
        </a>
    </li>
    <?php endif; ?>
    <?php if($_SESSION['level'] == "2" || $_SESSION['level'] == "3") : ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('element/form'); ?>">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Input Pesanan</span>
        </a>
    </li>
    <?php endif; ?>
    <?php if($_SESSION['level'] != "4"): ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Master</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" href="<?= base_url('element/simpletable'); ?>">Data Transaksi</a>
                <a class="collapse-item" href="<?= base_url('element/databerhasil'); ?>">Data Berhasil</a>
                <a class="collapse-item" href="<?= base_url('element/datacancel'); ?>">Data Cancel</a>
                <a class="collapse-item" href="<?= base_url('element/datauser'); ?>">Data User</a>
                <a class="collapse-item" href="<?= base_url('element/dataharga'); ?>">Data Harga</a>
            </div>
        </div>
    </li>
    <?php endif; ?>
    <?php if($_SESSION['level'] == "1" || $_SESSION['level'] == "2") : ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('element/charts'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span>
        </a>
    </li>
    <?php endif; ?>
    <hr class="sidebar-divider">
    <hr class="sidebar-divider">
</ul>
<!-- Sidebar -->