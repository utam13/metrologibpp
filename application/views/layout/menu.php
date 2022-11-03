<?extract($infoapp);?>
<header>
    <!-- header-area start -->
    <div id="sticker" class="header-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-sm-12">                        
                    
                    <!-- Navigation -->
                    <nav class="navbar navbar-default">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <!-- Brand -->
                            <a class="navbar-brand page-scroll sticky-logo" href="#">
                                <h1 class="instansi">
                                    <img src="<?= $file_logo; ?>" alt="" title="" class="square"> 
                                    <div class="textheader">
                                        <p class='namaaplikasi'>KONSUMEN NYAMAN</p>
                                        <p class='namakantor'><?= $namakantor;?></p>
                                    </div>
                                </h1>
                            </a>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="active">
                                    <a class="page-scroll" href="<?if($halaman != "Landing"){ echo base_url();}?>#home">Beranda</a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="<?if($halaman != "Landing"){ echo base_url();}?>#about">Tentang Kami</a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="<?if($halaman != "Landing"){ echo base_url();}?>#services">Layanan</a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="<?if($halaman != "Landing"){ echo base_url();}?>#portfolio">Galeri</a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="<?if($halaman != "Landing"){ echo base_url();}?>#blog">Berita</a>
                                </li>
                                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Info Lainnya<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?= base_url();?>info/regulasi#regulasi">Regulasi</a></li>
                                        <li><a href="<?= base_url();?>info/sop#sop">SOP</a></li>
                                        <li><a href="<?= base_url();?>info/pegawai#pegawai">Pegawai</a></li>
                                        <li><a href="<?= base_url();?>info/uttpwajibtera#uttp">UTTP Wajib Tera</a></li>
                                    </ul> 
                                </li>
                                <li>
                                    <a class="page-scroll" href="<?if($halaman != "Landing"){ echo base_url();}?>#contact">Kontak</a>
                                </li>
                                <!-- <li>
                                    <a class="page-scroll" href="<?= base_url();?>pelayanan">Pelayanan</a>
                                </li> -->
                                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Pelayanan<span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?= base_url();?>pelayanan/alur">Alur Pelayanan</a></li>
                                        <?if ($this->session->userdata('level') == "") {?>
                                            <?if ($this->session->userdata('stat_log') != "login") {?>
                                                <li><a href="<?= base_url();?>pelayanan">Log In Peserta</a></li>
                                            <?}else{?>
                                                <li><a href="<?= base_url();?>pelayanan/peserta">Peserta</a></li>
                                            <?}?>
                                        <?}else{?>
                                            <li><a href="<?= base_url();?>login/logout">Log Out Admin Area</a></li>
                                        <?}?>
                                    </ul> 
                                </li>
                                
                            </ul>
                        </div>
                        <!-- navbar-collapse -->
                    </nav>
                    <!-- END: Navigation -->
                </div>
            </div>
        </div>
    </div>
    <!-- header-area end -->
</header>
<!-- header end -->