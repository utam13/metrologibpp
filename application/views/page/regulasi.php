<div class="area-padding bg-white">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2><?= $halaman; ?></h2>
<!-- 
					<div class="row">
                        <ol class="breadcrumb-menu bg-khusus">
                            <li class="active"><a class="page-scroll" href="#info_total">Regulasi</a></li>
                            <li><a class="page-scroll" href="#grafik_belanja_pengadaan_apbd_kota_balikpapan">SOP</a></li>
                            <li><a class="page-scroll" href="#rup">Pegawai</a></li>
                            <li><a class="page-scroll" href="#rpp">UTTP Wajib Tera</a></li>
                        </ol>
                    </div> -->
				</div>
            </div>
        </div>
		<div class="row">
            <!-- single-well start-->
            <div class="col-md-5 side-image">
				<div class="well-left">
					<div class="single-well">
						<a href="#">
							<img src="<?= base_url();?>assets/img/terms.svg" alt="">
						</a>
					</div>
				</div>
            </div>
            <!-- single-well end-->
            <div class="col-md-7">
				<div class="well-middle">
					<div class="single-well">
						<a href="#">
							<h4 class="sec-head">Daftar Regulasi UPTD Metrologi Balikpapan</h4>
						</a>
						<ul>
							<?
							foreach ($regulasi as $r) {
								echo '<li>'.
										'<i class="fa fa-check"></i><p style="margin: -22px 0 0 20px">'.$r->nama.' (Nomor '.$r->nomor.' Tahun '.$r->thn.') <a href="'.base_url().'upload/regulasi/'.$r->berkas.'" target="_blank" class="btn btn-info btn-xs">Lihat</a></p>'. 
									'</li>';
							}
							?>
						</ul>
					</div>
				</div>
            </div>
            <!-- End col-->
        </div>
	</div>
</div>
<!-- End Blog Area -->
<div class="clearfix"></div>