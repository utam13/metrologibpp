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
							Daftar Alat UTTP Wajib Tera
						</h3>
					</div>
					<div class="box-body">
						<div class="row">
							<form class="form-inline" method="post" action="<?= base_url();?>info/uttpwajibtera">
								<div class="col-md-12 text-right">
									<div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Cari</span>
                                            <input type="text" class="form-control" id="cari" name="cari" placeholder="Nama Alat" autocomplete="off" value="">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn bg-khusus"><i class="fa fa-search"></i></button>
                                                <a href="<?= base_url();?>info/uttpwajibtera" class="btn bg-olive"><i class="fa fa-refresh"></i></a>
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
											<th scope="col" class="text-center" style="width:150px;">Gambar</th>
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
													<a href="<?= $h->file_berkas;?>" target="_blank" rel="noopener noreferrer">
														<img src="<?= $h->file_berkas;?>" alt="gambar" style="width:100%;">
													</a>
												</td>
												<td nowrap>
													<div>
                                                        <?= $h->info;?>
                                                    </div>
													<?if($h->total != 0){?>
                                                    <div>&nbsp;</div>
                                                    <div class="text-right">
                                                        <span >
															<a href="<?= base_url(); ?>info/detailkecamatan/<?= $h->kduttp; ?>" class="btn bg-khusus btn-sm "><i class="fa fa-table"></i> DETAIL PER-KECAMATAN</a>
                                                        </span>
                                                    </div>
													<?}?>
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
									<li class="page-item"><a href="<?= base_url(); ?>info/uttpwajibtera/<?= "1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>info/uttpwajibtera/<?= "$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
									<?
										}

										for ($i = $start_number; $i <= $end_number; $i++) {
											if ($page == $i) {
												$link_active = "";
												$link_color = "class='page-item disabled'";
											} else {
												$link_active = base_url() . "info/uttpwajibtera/$i/$limit/$getcari";
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
									<li class="page-item"><a href="<?= base_url(); ?>info/uttpwajibtera/<?= "$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>info/uttpwajibtera/<?= "$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
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