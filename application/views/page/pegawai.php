<div class="area-padding">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
		<div class="row center-content">
			<div class="col-md-8">
				<div class="box box-khusus box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">
							Struktur Organisasi
						</h3>
					</div>
					<div class="box-body">
						<img id="berkas" class="img-responsive center-block" src="<?= $file_struktur; ?>" alt="berkas" style="width:40%;">
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="box box-khusus box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">
							Daftar Pegawai
						</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<form class="form-inline" method="post" action="<?= base_url();?>info/pegawai">
								<div class="col-md-12 text-right">
									<div class="form-group">
										<div class="input-group input-group-sm">
											<span class="input-group-addon">Cari</span>
											<input type="text" class="form-control" id="cari" name="cari" placeholder="Nama atau Jabatan" autocomplete="off" value="">
											<span class="input-group-btn">
												<button type="submit" class="btn bg-khusus"><i class="fa fa-search"></i></button>
												<a href="<?= base_url();?>info/pegawai" class="btn bg-olive"><i class="fa fa-refresh"></i></a>
											</span>
										</div>
									</div>
                                    <div class="form-group">
                                        <select class="form-control input-sm" id="limitpage" name="limitpage" onchange="submit()">
                                            <option value="20" <?= $limit == "20" ? "selected":"";?> >20</option>
                                            <option value="40" <?= $limit == "40" ? "selected":"";?> >40</option>
                                            <option value="60" <?= $limit == "60" ? "selected":"";?> >60</option>
                                            <option value="80" <?= $limit == "80" ? "selected":"";?> >80</option>
                                            <option value="100" <?= $limit == "100" ? "selected":"";?> >100</option>
                                        </select>
                                    </div>
								</div>
							</form>

							<div class="col-md-12 table-responsive no-padding">
								<table class="table table-striped table-hover table-bordered table-sm table-normal" id="mytable">
									<thead class="bg-khusus">
										<tr>
											<th scope="col" class="text-center nourut">No.</th>
											<th scope="col">Nama</th>
											<th scope="col">Jabatan</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($pegawai);
										foreach ($hasil as $d) {
										?>
										<tr>
											<td scope="col" class="text-center"><?= $d->no;?></td>
											<td scope="col" nowrap><?= $d->nama;?></td>
											<td scope="col" nowrap><?= $d->jabatan;?></td>
										</tr>
										<?}?>
									</tbody>
								</table>
							</div>

							<div class="col-md-12">
								<? if ($jumlah_page > 0) { ?>
								<ul class="pagination pull-right">
									<? if ($page == 1) { ?>
									<li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
									<li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
									<? } else {
											$link_prev = ($page > 1) ? $page - 1 : 1; ?>
									<li class="page-item"><a href="<?= base_url(); ?>info/pegawai/<?= "1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>info/pegawai/<?= "$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
									<?
										}

										for ($i = $start_number; $i <= $end_number; $i++) {
											if ($page == $i) {
												$link_active = "";
												$link_color = "class='page-item disabled'";
											} else {
												$link_active = base_url() . "info/pegawai/$i/$limit/$getcari";
												$link_color = "class='page-item'";
											}
										?>
									<li <?= $link_color; ?>><a href="<?= $link_active; ?>#divider" class="page-link"><?= $i; ?></a></li>
									<? }

										if ($page == $jumlah_page) {
										?>
									<li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-forward"></i></a></li>
									<li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-forward"></i></a></li>
									<? } else {
											$link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
									<li class="page-item"><a href="<?= base_url(); ?>info/pegawai/<?= "$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>info/pegawai/<?= "$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
									<? } ?>
								</ul>
								<? } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<!-- End Blog Area -->