<header class="main-header">
    <!-- Logo -->
    <?extract($infoapp);?>
    <a href="<?= base_url(); ?>admin" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="<?= $file_logo;?>" alt="" width=30></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin Area</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" >
            <span class="sr-only">Toggle navigation</span> 
            <h4 class="brand"><?= $namakantor;?></h4>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= base_url(); ?>assets/backend/img/user.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?= ucfirst($this->session->userdata('nama')); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="padding-top:3rem;">
                            <img src="<?= base_url(); ?>assets/backend/img/user.png" class="img-circle" alt="User Image">

                            <p>
                                <?= ucfirst($this->session->userdata('nama')); ?>
                                <small><?= ucfirst($this->session->userdata('level')); ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= base_url();?>pegawai/ubahpassword" class="btn bg-light-blue btn-flat"><i class="fa fa-key"></i> Ubah Password</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= base_url();?>login/logout" class="btn bg-red btn-flat"><i class="fa fa-lock"></i> Log out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>