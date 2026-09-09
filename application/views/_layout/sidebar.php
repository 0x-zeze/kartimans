<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard'); ?>">

        <div class="sidebar-brand-icon">
            <img src="<?= base_url('assets/img/logos.jpeg'); ?>" alt="Kartimans Barbershop">
        </div>
        <div class="sidebar-brand-text mx-3">Kartimans</div>
    </a>
    <hr class="sidebar-divider my-0">
    <?php
        $level = $this->session->userdata('level');
        $seg1 = $this->uri->segment(1);
        $seg2 = $this->uri->segment(2);
        $isDashboard = ($seg1 === 'dashboard' || $seg1 === '');
        $isForm = ($seg2 === 'form');
        $isPesan = ($seg2 === 'pesan');
        $isCharts = ($seg2 === 'charts');
        $masterPages = array('simpletable', 'databerhasil', 'datacancel', 'datauser', 'dataharga', 'detail_transaksi', 'detail_user', 'edit_user', 'edit_harga');
        $isMaster = in_array($seg2, $masterPages, true);
    ?>
    <li class="nav-item<?= $isDashboard ? ' active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Features
    </div>
    <?php if($level == "4") : ?>
    <li class="nav-item<?= $isPesan ? ' active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('element/pesan'); ?>">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Input Booking</span>
        </a>
    </li>
    <?php endif; ?>
    <?php if($level == "2" || $level == "3") : ?>
    <li class="nav-item<?= $isForm ? ' active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('element/form'); ?>">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Input Pesanan</span>
        </a>
    </li>
    <?php endif; ?>
    <?php if($level != "4"): ?>
    <li class="nav-item<?= $isMaster ? ' active' : ''; ?>">
        <a class="nav-link<?= $isMaster ? '' : ' collapsed'; ?>" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="<?= $isMaster ? 'true' : 'false'; ?>" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Master</span>
        </a>
        <div id="collapseTable" class="collapse<?= $isMaster ? ' show' : ''; ?>" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="py-2 collapse-inner rounded">
                <a class="collapse-item<?= ($seg2 === 'simpletable' || $seg2 === 'detail_transaksi') ? ' active' : ''; ?>" href="<?= base_url('element/simpletable'); ?>">Data Transaksi</a>
                <a class="collapse-item<?= $seg2 === 'databerhasil' ? ' active' : ''; ?>" href="<?= base_url('element/databerhasil'); ?>">Data Berhasil</a>
                <a class="collapse-item<?= $seg2 === 'datacancel' ? ' active' : ''; ?>" href="<?= base_url('element/datacancel'); ?>">Data Cancel</a>
                <a class="collapse-item<?= in_array($seg2, array('datauser', 'detail_user', 'edit_user'), true) ? ' active' : ''; ?>" href="<?= base_url('element/datauser'); ?>">Data User</a>
                <a class="collapse-item<?= in_array($seg2, array('dataharga', 'edit_harga'), true) ? ' active' : ''; ?>" href="<?= base_url('element/dataharga'); ?>">Data Harga</a>
            </div>
        </div>
    </li>
    <?php endif; ?>
    <?php if($level == "1" || $level == "2") : ?>
    <li class="nav-item<?= $isCharts ? ' active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('element/charts'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Laporan</span>
        </a>
    </li>
    <?php endif; ?>
    <hr class="sidebar-divider">
</ul>
<!-- Sidebar -->