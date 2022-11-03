<div class="blog-page area-padding">
    <div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
		<div class="row">
			<!-- Start single blog -->
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
					<!-- single-blog start -->
					<article class="blog-post-wrapper">
						<div class="post-thumbnail text-center">
							<img src="<?= $file_berkas_berita;?>" alt="berita" />
						</div>
						<div class="post-information">
							<h2><?= $judul;?></h2>
							<div class="entry-meta">
								<span><?= $waktu;?></span>
							</div>
							<div class="entry-content">
								<?= $isi;?>
								
							</div>
							<div class="entry-link sosmed-icons text-right">
								<?= $sosmed;?>
							</div>
						</div>
					</article>
					<!-- single-blog end -->
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<!-- End Blog Area -->
<div class="clearfix"></div>