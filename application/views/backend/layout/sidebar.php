<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?= $halaman=="Dashboard" ? "active":"";?>"><a href="<?= base_url(); ?>admin" onclick="showloading()"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="header">MENU UTAMA</li>
            <?if($this->session->userdata('level') != "Admin Pelayanan" && $this->session->userdata('level') != "Penera"){?>
            <li class="treeview <?= $halaman=="Kantor" || $halaman=="Slide" || $halaman=="Tentang Kami" || $halaman=="Visi & Misi" || $halaman=="Layanan" || $halaman=="Regulasi" || $halaman=="SOP" || $halaman=="Pegawai" || $halaman=="UTTP Wajib Tera" || $halaman=="Galeri & Berita" || $halaman=="Kecamatan & Kelurahan" || $halaman=="Maks. Waktu Layanan Per-Hari" ? "active":"";?>">
                <a href="#">
                    <i class="fa fa-info-circle"></i> 
                    <span>Informasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= $halaman=="Kantor" ? "active":"";?>"><a href="<?= base_url(); ?>kantor"><i class="fa fa-circle-o"></i> <span>Kantor</span></a></li>
                    <li class="<?= $halaman=="Slide" ? "active":"";?>"><a href="<?= base_url(); ?>slide"><i class="fa fa-circle-o"></i> <span>Slide</span></a></li>
                    <li class="<?= $halaman=="Tentang Kami" ? "active":"";?>"><a href="<?= base_url(); ?>tentang"><i class="fa fa-circle-o"></i> <span>Tentang Kami</span></a></li>
                    <li class="<?= $halaman=="Visi & Misi" ? "active":"";?>"><a href="<?= base_url(); ?>visimisi"><i class="fa fa-circle-o"></i> <span>Visi & Misi</span></a></li>
                    <li class="<?= $halaman=="Layanan" ? "active":"";?>"><a href="<?= base_url(); ?>layanan"><i class="fa fa-circle-o"></i> <span>Layanan</span></a></li>
                    <li class="<?= $halaman=="Regulasi" ? "active":"";?>"><a href="<?= base_url(); ?>regulasi"><i class="fa fa-circle-o"></i> <span>Regulasi</span></a></li>
                    <li class="<?= $halaman=="SOP" ? "active":"";?>"><a href="<?= base_url(); ?>sop"><i class="fa fa-circle-o"></i> <span>SOP</span></a></li>
                    <li class="<?= $halaman=="Pegawai" ? "active":"";?>"><a href="<?= base_url(); ?>pegawai"><i class="fa fa-circle-o"></i> <span>Pegawai</span></a></li>
                    <li class="<?= $halaman=="UTTP Wajib Tera" ? "active":"";?>"><a href="<?= base_url(); ?>uttp"><i class="fa fa-circle-o"></i> <span>UTTP Wajib Tera</span></a></li>
                    <li class="<?= $halaman=="Galeri & Berita" ? "active":"";?>"><a href="<?= base_url(); ?>galeriberita"><i class="fa fa-circle-o"></i> <span>Galeri & Berita</span></a></li>
                    <li class="<?= $halaman=="Kecamatan & Kelurahan" ? "active":"";?>"><a href="<?= base_url(); ?>kecamatan"><i class="fa fa-circle-o"></i> <span>Kecamatan & Kelurahan</span></a></li>
                    <li class="<?= $halaman=="Maks. Waktu Layanan Per-Hari" ? "active":"";?>"><a href="<?= base_url(); ?>bataslayanan"><i class="fa fa-circle-o"></i> <span>Waktu Layanan Per-Hari</span></a></li>
                </ul>
            </li>
            <?}?>
            <li class="treeview <?= $halaman=="Peserta Tera/Tera Ulang" || $halaman=="UTTP Peserta Tera/Tera Ulang" || $halaman=="Pengajuan Tera/Tera Ulang" || $halaman=="Laporan" ? "active":"";?>">
                <a href="#">
                    <i class="fa fa-balance-scale"></i>
                    <span>Pelayanan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?if($this->session->userdata('level') != "Penera"){?>
                    <li class="<?= $halaman=="Peserta Tera/Tera Ulang" || $halaman=="UTTP Peserta Tera/Tera Ulang" ? "active":"";?>"><a href="<?= base_url(); ?>peserta"><i class="fa fa-circle-o"></i> <span>Peserta Tera/Tera Ulang</span></a></li>
                    <?}?>
                    <li class="<?= $halaman=="Pengajuan Tera/Tera Ulang" ? "active":"";?>"><a href="<?= base_url(); ?>permintaan"><i class="fa fa-circle-o"></i> <span>Pengajuan</span></a></li>
                    <li class="<?= $halaman=="Laporan" ? "active":"";?>"><a href="<?= base_url(); ?>laporan"><i class="fa fa-circle-o"></i> <span>Laporan</span></a></li>
                </ul>
            </li>
            <li><a href=" <?= base_url(); ?>panduan.pdf" target="_blank"><i class="fa fa-book"></i> <span>Panduan</span></a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>