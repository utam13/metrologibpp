
		<!-- Start Footer bottom Area -->
		<?extract($infoapp);?>
		<footer>
			<?if($halaman != "Landing"){?>
			<div class="footer-area">
				<div class="container">
					<div class="row">
					<!-- end single footer -->
					<div class="col-md-6 col-sm-4 col-xs-12">
						<div class="footer-content">
							<div class="footer-head text-left">
								<h4>informasi kantor</h4>
								<p style="width:300px;">
									<?= $namakantor;?>
								</p>
								<div class="footer-contacts" style="margin-top:20px;">
									<p>
										<?= $alamatkantor;?>
									</p>
								</div>
								<div class="footer-contacts">
									<p><span>Telp:</span> <?= $telpkantor;?></p>
									<p><span>WhatsApp:</span> <?= $wakantor;?></p>
									<p><span>Email:</span> <?= $emailkantor;?></p>
									<p><span>Website:</span> <?= $webkantor;?></p>
								</div>
								<div class="footer-contacts sosmed-icons">
									<ul>
										<?if($fbkantor != "" && $fbkantor != "-"){?>
										<li>
											<a href="<?= $fbkantor;?>"><i class="fa fa-facebook"></i></a>
										</li>
										<?} if($igkantor != "" && $igkantor != "-"){?>
										<li>
											<a href="<?= $igkantor;?>"><i class="fa fa-instagram"></i></a>
										</li>
										<?} if($youtubekantor != "" && $youtubekantor != "-"){?>
										<li>
											<a href="<?= $youtubekantor;?>"><i class="fa fa-youtube"></i></a>
										</li>
										<?}?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- end single footer -->
					<div class="col-md-6 col-sm-4 col-xs-12">
						<div class="footer-content">
							<div class="footer-head text-right">
								<h4>Lokasi Kantor</h4>
								<iframe class="bg-secondary" src="<?= $googlemapkantor;?>" width="100%" height="280px" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
			<?}?>
			<div class="footer-area-bottom">
				<div class="container">
					<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="copyright text-center">
						<p>
							&copy; Copyright <strong><?= $namakantor;?></strong>
							<br>
							ver. 1.0 | 2022
						</p>
						</div>
						<div class="credits">
						Designed by CV. DUTA AMANAH
						</div>
					</div>
					</div>
				</div>
			</div>
		</footer>

		<?if($halaman != "Kepemilikan UTTP" && $halaman != "Pengajuan Tera/Tera Ulang" && $halaman != "Pelanggan"){?>
		<div style="position: fixed; bottom: 10px; right: 10px; z-index: 1000;">
			<a href="https://wa.me/<?= str_replace("-","",$wakantor);?>/?text=Hi,%20Admin." target="_blank" rel="noopener" title="Hubungi kami">
				<img src="<?= base_url();?>assets/img/wa.png" alt="logowa" style="width:150px;">
			</a>
		</div>
		<?}?>
		<!-- <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a> -->

		<!-- JavaScript Libraries -->
		<script src="<?= base_url();?>assets/lib/jquery/jquery.min.js"></script>
		<script src="<?= base_url();?>assets/lib/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= base_url();?>assets/lib/owlcarousel/owl.carousel.min.js"></script>
		<script src="<?= base_url();?>assets/lib/venobox/venobox.min.js"></script>
		<script src="<?= base_url();?>assets/lib/knob/jquery.knob.js"></script>
		<script src="<?= base_url();?>assets/lib/wow/wow.min.js"></script>
		<script src="<?= base_url();?>assets/lib/parallax/parallax.js"></script>
		<script src="<?= base_url();?>assets/lib/easing/easing.min.js"></script>
		<script src="<?= base_url();?>assets/lib/nivo-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
		<script src="<?= base_url();?>assets/lib/appear/jquery.appear.js"></script>
		<script src="<?= base_url();?>assets/lib/isotope/isotope.pkgd.min.js"></script>

		<!-- DataTables -->
		<script src="<?= base_url(); ?>assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url(); ?>assets/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url();?>assets/js/datatables.custom.js"></script>

		<script src="<?= base_url();?>assets/js/main.js"></script>

		<script src="<?= base_url();?>assets/js/script.js"></script>

		<?if($halaman == "Pengajuan Tera/Tera Ulang" || $halaman == "Pengajuan Tera/Tera Ulang Pelanggan"){?>
			<script src="<?= base_url();?>assets/js/upload_permintaan.js"></script>
		<?}else{?>
			<script src="<?= base_url();?>assets/js/upload.js"></script>
		<?}?>
	</body>

</html>