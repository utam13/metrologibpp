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
			<div class="col-md-12">
				<div class="box box-khusus box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">
							Daftar Pelanggan Anda
						</h3>
					</div>
					<div class="box-body">
						<div class="row">
                            <form class="form-inline" method="post" action="<?= base_url();?>pelayanan/pelanggan">
								<div class="col-md-4">
                                    <a href="<?= base_url();?>pelayanan/formulirpelanggan/<?= $kdpenyedia;?>/1" class="btn bg-khusus btn-sm"><i class="fa fa-plus"></i> TAMBAH PELANGGAN</a>
								</div>
                                <div class="col-md-1">&nbsp;</div>
								<div class="col-md-7 text-right">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Cari</span>
                                            <input type="text" class="form-control" id="cari" name="cari" placeholder="NPWP atau Nama Pelanggan" autocomplete="off" value="">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn bg-khusus"><i class="fa fa-search"></i></button>
                                                <a href="<?= base_url();?>pelayanan/pelanggan" class="btn bg-olive"><i class="fa fa-refresh"></i></a>
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
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:5%;">No.</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">#</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml UTTP</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml SKHP Expired</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Tgl. Daftar</th>
                                            <th scope="col" colspan=7 nowrap class="text-center">Informasi Usaha</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" nowrap class="text-center">NPWP</th>
                                            <th scope="col" nowrap class="text-center">Nama Usaha</th>
                                            <th scope="col" nowrap class="text-center">Alamat</th>
                                            <th scope="col" nowrap class="text-center">Kelurahan</th>
                                            <th scope="col" nowrap class="text-center">Kecamatan</th>
                                            <th scope="col" nowrap class="text-center">Telp</th>
                                            <th scope="col" nowrap class="text-center">Email</th>
                                        </tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($pelanggan);
										foreach ($hasil as $d) {
										?>
										<tr>
                                            <td scope="col" class="text-center"><?= $d->no;?></td>
                                            <td scope="col" nowrap>
                                                <?if($d->kelompok == 3){?>
                                                <a href="<?= base_url();?>pelayanan/formulirpelanggan/<?= $kdpenyedia;?>/2/<?= $d->kdpeserta; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url();?>pelayanan/prosespelanggan/3/<?= $kdpenyedia;?>/<?= $d->kdpeserta;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus pelanggan berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nLanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                                <?}?>

                                                <?if($d->kelompok == 1 && ($d->jmluttpmilik != 0 || $d->nominaljmluttp == 0)){?>
                                                <a href="<?= base_url();?>pelayanan/prosespelanggan/4/<?= $kdpenyedia;?>/<?= $d->kdpeserta;?>" class="btn btn-info btn-xs" onclick="return confirm('Melepas pelanggan berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nLanjutkan proses ?')"><i class="fa fa-unlink"></i></a>
                                                <?}?>

                                                <?if($d->kelompok == 3 && ($d->jmluttpmilik != 0 || $d->nominaljmluttp == 0)){?>
                                                    <a href="<?= base_url();?>pelayanan/formulir/2/<?= $d->kdpeserta;?>" class="btn btn-warning btn-xs" onclick="return confirm('Daftarkan pelanggan berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nSebagai peserta, dikarenakan ada sebagian atau selutuh alat yang sudah menjadi milik pelanggan. Lanjutkan proses ?')">Daftarkan</a>
                                                <?}elseif($d->kelompok == 1 && ($d->jmluttpmilik != 0 || $d->nominaljmluttp == 0)){?>
                                                    <a href="#" class="btn btn-default btn-xs" onclick="alert('Sebagian alat masih belum dialihkan kepemilikannya\nPerubahan data pelanggan dapat dilakukan secara mandiri oleh pelanggan atau dengan bantuan Admin')">Terdaftar</a>
                                                <?}else{?>
                                                    <a href="#" class="btn btn-default btn-xs" onclick="alert('Masih ada alat yang belum dilepas kepemilikannya')">Daftarkan</a>
                                                <?}?>
                                            </td>
                                            <td scope="col" class="text-center"><?= $d->jmluttp;?></td>
                                            <td scope="col" class="text-center"><?= $d->totalexpired;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->tgldaftar;?></td>
                                            <td scope="col" nowrap><?= $d->npwp;?></td>
                                            <td scope="col" nowrap><?= $d->nama;?></td>
                                            <td scope="col" nowrap><?= $d->alamat;?></td>
                                            <td scope="col" nowrap><?= $d->kelurahan;?></td>
                                            <td scope="col" nowrap><?= $d->kecamatan;?></td>
                                            <td scope="col" nowrap><?= $d->telp;?></td>
                                            <td scope="col" nowrap><?= $d->email;?></td>
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
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pelanggan/<?= "1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pelanggan/<?= "$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
									<?
										}

										for ($i = $start_number; $i <= $end_number; $i++) {
											if ($page == $i) {
												$link_active = "";
												$link_color = "class='page-item disabled'";
											} else {
												$link_active = base_url() . "pelayanan/pelanggan/$i/$limit/$getcari";
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
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pelanggan/<?= "$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pelanggan/<?= "$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
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