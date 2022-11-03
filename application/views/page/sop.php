<div class="area-padding bg-white">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
		<div class="row">
            <!-- single-well start-->
            <div class="col-md-5 side-image">
				<div class="well-left">
					<div class="single-well">
						<a href="#">
							<img src="<?= base_url();?>assets/img/todo.svg" alt="">
						</a>
					</div>
				</div>
            </div>
            <!-- single-well end-->
            <div class="col-md-7">
				<div class="well-middle">
					<div class="single-well">
						<a href="#">
							<h4 class="sec-head">Daftar SOP UPTD Metrologi Balikpapan</h4>
						</a>
						<ul>
							<?
							foreach ($sop as $s) {
								echo '<li>'.
										'<i class="fa fa-check"></i><p style="margin: -22px 0 0 20px">'.$s->nama.' <a href="'.base_url().'info/viewPdf/sop/'.$s->berkas.'" target="_blank" class="btn btn-info btn-xs">Lihat</a></p>'. 
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