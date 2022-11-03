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
            <div class="col-md-12 text-center">
				<a href="<?= base_url();?>pelayanan" class="btn btn-default"><i class="fa fa-user"></i> Data Peserta</a>
				<?if($mode == 2){?>
					<a href="<?= base_url();?>pelayanan/pelanggan" class="btn btn-primary"><i class="fa fa-users"></i> Data Pelanggan</a>
				<?}?>
                <a href="<?= base_url();?>pelayanan/monitoring/<?= $kdpenyedia;?>/<?= $mode;?>" class="btn bg-olive"><i class="fa fa-binoculars"></i> Monitoring <?= $monitoringpengajuan;?></a>
                <a href="<?= base_url();?>panduanpeserta.pdf" target="_blank" class="btn bg-maroon"><i class="fa fa-book"></i> Panduan</a>
            </div>

            <div class="col-md-12">&nbsp;</div>

            <!-- Message area -->
            <?
            extract($alert);
            if ($kode_alert != "") {
            ?>
            <div class="col-lg-6">
                <div class="alert <?= $jenisbox ?>">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
                </div>
            </div>
            <? } ?>

			<div class="col-md-8">
				<div class="box box-khusus box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">
                            <i class="fa fa-balance-scale"></i> Daftar Alat UTTP <?= $mode == 1 ? "Peserta":"Pelanggan $npwp - $nama";?>
						</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<form class="form-inline" method="post" action="<?= base_url();?>pelayanan/uttp/<?= $kdpeserta;?>/<?= $mode;?>">
								<div class="col-md-4">
                                    <a href="<?= base_url();?>pelayanan/formuliruttp/<?= $kdpeserta;?>/<?= $mode;?>/1" class="btn bg-khusus btn-sm"><i class="fa fa-plus"></i> TAMBAH UTTP <?= $mode == 1 ? "":"PELANGGAN";?></a>
								</div>
                                <div class="col-md-1">&nbsp;</div>
								<div class="col-md-7 text-right">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Cari</span>
                                            <input type="text" class="form-control" id="cari" name="cari" placeholder="Nama Alat" autocomplete="off" value="">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn bg-khusus"><i class="fa fa-search"></i></button>
                                                <a href="<?= base_url();?>pelayanan/uttp/<?= $kdpeserta;?>/<?= $mode;?>" class="btn bg-olive"><i class="fa fa-refresh"></i></a>
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

							<div class="col-md-12 table-responsive">
								<table class="table table-striped table-hover table-bordered table-sm table-normal">
									<thead class="bg-khusus">
										<tr>
											<th scope="col" class="text-center" style="width:130px;">Gambar</th>
											<th scope="col" class="text-center">Informasi UTTP</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($uttp);
										foreach ($hasil as $h) {
										?>
											<tr>
												<td>
													<a href="<?= $h->file_berkas;?>" target="_blank" class="img-responsive center-block">
														<img src="<?= $h->file_berkas;?>" alt="gambar" style="width:100%;">
													</a>
												</td>
												<td nowrap>
                                                    <div>
                                                        <?= $h->info;?>
                                                    </div>
                                                    <div>&nbsp;</div>
                                                    <div class="text-center">
                                                        <span >
                                                        	<a href="<?= base_url(); ?>pelayanan/pengajuan/<?= $kdpeserta;?>/<?= $mode;?>/<?= $h->kduttppeserta; ?>" class="btn btn-default btn-sm "><i class="fa fa-table"></i> DAFTAR PENGAJUAN</a>
                                                            <a href="<?= base_url();?>pelayanan/formuliruttp/<?= $kdpeserta;?>/<?= $mode;?>/2/<?= $h->kduttppeserta; ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
															
															<?if($mode == 2){?>
															<a href="<?= base_url();?>pelayanan/prosesuttp/<?= $kdpeserta;?>/<?= $mode;?>/4/<?= $h->kduttppeserta; ?>" class="btn btn-info btn-sm" onclick="return confirm('Mengalihkan kepemilikan uttp ke pelanggan <?= $nama;?>?')"><i class="fa fa-unlink"></i></a>
															<?}?>

															<?if($h->jmlpengajuan == 0){?>
                                                            	<a href="<?= base_url(); ?>pelayanan/prosesuttp/<?= $kdpeserta;?>/<?= $mode;?>/3/<?= $h->kduttppeserta; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Menghapus UTTP dengan nama\n<?= $h->nama; ?> ?')"><i class="fa fa-trash"></i></a>
															<?}else{?>
																<a href="#" class="btn btn-danger btn-sm" onclick="alert('Tidak dapat dihapus karena ada data pengajuan yang terkait')"><i class="fa fa-trash"></i></a>
															<?}?>

															<?if($h->adapengajuanaktif == 0){?>
                                                            <a href="<?= base_url();?>pelayanan/formulirpengajuan/<?= $kdpeserta;?>/<?= $mode;?>/<?= $h->kduttppeserta;?>/1" class="btn bg-khusus btn-sm ">PENGAJUAN BARU</a>
															<?}else{?>
																<a href="#" onclick="alert('Ada data pengajuan yang masih aktif')" class="btn bg-khusus btn-sm ">PENGAJUAN BARU</a>
															<?}?>
                                                        </span>
                                                    </div>
                                                </td>
											</tr>
										<? } ?>
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
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/uttp/<?= "1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/uttp/<?= "$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
									<?
										}

										for ($i = $start_number; $i <= $end_number; $i++) {
											if ($page == $i) {
												$link_active = "";
												$link_color = "class='page-item disabled'";
											} else {
												$link_active = base_url() . "pelayanan/uttp/$i/$limit/$getcari";
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
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/uttp/<?= "$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/uttp/<?= "$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
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