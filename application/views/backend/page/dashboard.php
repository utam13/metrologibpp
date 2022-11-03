<div class="content-wrapper">

    <!-- Main content -->
    <section class="content ">
        <div class="row">
            <div class="col-xs-12">
                <?if($this->session->userdata('level') != "Penera"){?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?= $regbaru;?></h3>

                                <p>Registrasi<br>Baru</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="<?= $regbaru > 0 ? base_url()."peserta/index/1/20/status/0":"#";?>" class="small-box-footer">detail data <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?}?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h3><?= $permintaanbaru;?></h3>

                                <p>Permintaan<br>Baru</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <a href="<?= $permintaanbaru > 0 ? base_url()."permintaan/index/1/20/a.status/0":"#";?>" class="small-box-footer">detail data <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-light-blue">
                            <div class="inner">
                                <h3><?= $permintaanditerima;?></h3>

                                <p>Permintaan<br>Diterima</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <a href="<?= $permintaanditerima > 0 ? base_url()."permintaan/index/1/20/a.status/1":"#";?>" class="small-box-footer">detail data <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="small-box bg-teal">
                            <div class="inner">
                                <h3><?= $permintaanterjadwal;?></h3>

                                <p>Permintaan<br>Terjadwal</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <a href="<?= $permintaanterjadwal > 0 ? base_url()."permintaan/index/1/20/a.status/2":"#";?>" class="small-box-footer">detail data <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-olive">
                            <div class="inner">
                                <h3><?= $permintaanterbayar;?></h3>

                                <p>Permintaan<br>Terbayar</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <a href="<?= $permintaanterbayar > 0 ? base_url()."permintaan/index/1/20/a.status/3":"#";?>" class="small-box-footer">detail data <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h3><?= $permintaandiproses;?></h3>

                                <p>Permintaan<br>Diproses</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                            <a href="<?= $permintaandiproses > 0 ? base_url()."permintaan/index/1/20/a.status/4":"#";?>" class="small-box-footer">detail data <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </section>
    <!-- /.content -->
</div>