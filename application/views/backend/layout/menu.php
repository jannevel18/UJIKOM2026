<body>
    <?php
    $role = $this->session->userdata('level');
    $nama = $this->session->userdata('nama');
    ?>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div class="sidebar">
            <nav class="nxl-navigation">
                <div class="navbar-wrapper">
                    <div class="m-header">
                        <a href="index.html" class="b-brand">
                            <h2><a><br>Perpustakaan</a></h2>
                            <img src="assets/images/logo-abbr.png" alt="" class="logo logo-sm" />
                        </a>
                    </div>
                    
                    <div class="navbar-content">
                        <ul class="nxl-navbar">
                            <li class="nxl-item nxl-caption">
                                <?php 
                                    $role = $this->session->userdata('level');
                                ?>
                                <label>Selamat Datang <?php echo $nama; ?></label>
                            </li>
                            <?php if($role == 'admin'): ?>
                            <li class="nxl-item">
                                <a href="<?=site_url('halaman-sistem')?>" class="nxl-link">
                                    <span class="nxl-micon"></span>
                                    <span class="nxl-mtext">Dashboard</span>
                                </a>
                            </li>
                            <li class="nxl-item nxl-hasmenu">
                                <a href="javascript:void(0);" class="nxl-link">
                                    <span class="nxl-micon"></span>
                                    <span class="nxl-mtext">Master Data</span>
                                </a>
                                <ul class="nxl-submenu">
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('data-anggota')?>">Anggota</a>
                                    </li>
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('data-buku')?>">Buku</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nxl-item nxl-hasmenu">
                                <a href="javascript:void(0);" class="nxl-link">
                                    <span class="nxl-micon"></span>
                                    <span class="nxl-mtext">Data Transaksi</span>
                                </a>
                                <ul class="nxl-submenu">
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('data-peminjaman')?>">Peminjaman</a>
                                    </li>
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('data-pengembalian')?>">Pengembalian</a>
                                    </li>
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('riwayat-peminjaman')?>">Riwayat</a>
                                    </li>
                                </ul>
                            </li>
                            <?php elseif($role == 'siswa'): ?>
                            <li class="nxl-item">
                                <a href="<?=site_url('halaman-sistem')?>" class="nxl-link">
                                    <span class="nxl-micon"></span>
                                    <span class="nxl-mtext">Dashboard</span>
                                </a>
                            </li>
                            <li class="nxl-item nxl-hasmenu">
                                <a href="javascript:void(0);" class="nxl-link">
                                    <span class="nxl-micon"></span>
                                    <span class="nxl-mtext">Katalog</span>
                                </a>
                                <ul class="nxl-submenu">
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('data-peminjaman')?>">Pinjam Buku</a>
                                    </li>
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('data-pengembalian')?>">Kembalikan Buku</a>
                                    </li>
                                    <li class="nxl-item">
                                        <a class="nxl-link" href="<?=site_url('riwayat-peminjaman')?>">Riwayat Saya</a>
                                    </li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li class="nxl-item">
                                <div class="card text-center mt-3">
                                    <a href="<?php echo site_url('logout-sistem'); ?>" class="btn btn-danger btn-block text-white">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </aside>