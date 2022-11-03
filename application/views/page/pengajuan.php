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
                <a href="<?= base_url();?>pelayanan/uttp/<?= $kdpeserta;?>/<?= $mode;?>" class="btn btn-default"><i class="fa fa-reply"></i> Kembali</a>
                <a href="<?= base_url();?>pelayanan/monitoring/<?= $kdpeserta;?>/<?= $mode;?>" class="btn bg-olive"><i class="fa fa-binoculars"></i> Monitoring <?= $monitoringpengajuan;?></a>
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
                            <i class="fa fa-balance-scale"></i> Daftar Pengajuan Selesai
						</h3>
                        <span class="text-black pull-right"><?= $namauttp;?></span> 
					</div>
					<div class="box-body">
						<div class="row">
							<form class="form-inline" method="post" action="<?= base_url();?>pelayanan/pengajuan/<?= $kdpeserta;?>/<?= $mode;?>/<?= $kduttppeserta;?>">
								<div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-addon">Cari</span>
                                            <input type="text" class="form-control" id="cari" name="cari" placeholder="No. Surat SKRD/SKHP" autocomplete="off" value="">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn bg-khusus"><i class="fa fa-search"></i></button>
                                                <a href="<?= base_url();?>pelayanan/pengajuan/<?= $kdpeserta;?>/<?= $mode;?>/<?= $kduttppeserta;?>" class="btn bg-olive"><i class="fa fa-refresh"></i></a>
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
											<th scope="col" rowspan=3 nowrap class="text-center">No</th>
											<th scope="col" rowspan=3 nowrap class="text-center">Status</th>
											<th scope="col" rowspan=3 nowrap class="text-center">Tgl. Pengajuan</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Jenis UTTP</th>
											<th scope="col" rowspan=3 nowrap class="text-center">Jenis Layanan</th>
											<th scope="col" rowspan=2 nowrap colspan=4 class="text-center">SKHP Lama</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Lokasi Layanan</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Jadwal</th>
											<th scope="col" rowspan=3 nowrap class="text-center">Penera</th>
                                            <th scope="col" rowspan=2 nowrap colspan=2 class="text-center">Pembayaran Restribusi</th>
                                            <th scope="col" colspan=5 nowrap class="text-center">Dokumen</th>
										</tr>
                                        <tr>
                                            <th scope="col" colspan=2 nowrap class="text-center">SKRD</th>
											<th scope="col" colspan=3 nowrap class="text-center">SKHP</th>
                                        </tr>
                                        <tr>
											<th scope="col" nowrap class="text-center">No. SKHP</th>
                                            <th scope="col" nowrap class="text-center">Tgl. SKHP</th>
                                            <th scope="col" nowrap class="text-center">Berlaku Sampai</th>
                                            <th scope="col" nowrap class="text-center">Lokasi</th>
                                            <th scope="col" nowrap class="text-center">Nomor</th>
											<th scope="col" nowrap class="text-center">Tgl. Pembayaran</th>
                                            <th scope="col" nowrap class="text-center">Nomor</th>
											<th scope="col" nowrap class="text-center">Tanggal</th>
                                            <th scope="col" nowrap class="text-center">Nomor</th>
											<th scope="col" nowrap class="text-center">Tanggal</th>
											<th scope="col" nowrap class="text-center">Berlaku Sampai</th>
                                        </tr>
									</thead>
									<tbody>
                                        <?
										$hasil = json_decode($pengajuan);
										foreach ($hasil as $h) {
										?>
											<tr>
												<td nowrap class="text-center"><?= $h->no;?></td>
												<td nowrap>
													<a href="<?= base_url().'pelayanan/formulirpengajuan/'.$kdpeserta.'/'.$mode.'/'.$h->kduttppeserta.'/2/'.$h->kdpengajuan;?>" class="btn <?= $h->warnabtn;?> btn-xs"><?= $h->namastatus;?></a>
                                                </td>
                                                <td nowrap class="text-center"><?= $h->tglpengajuan;?></td>
                                                <td nowrap><?= $h->namauttp;?></td>
                                                <td class="text-center" nowrap><?= $h->nama;?></td>
                                                <td nowrap><?= $h->noskhplama;?></td>
                                                <td class="text-center" nowrap><?= $h->tglskhplama;?></td>
                                                <td class="text-center" nowrap><?= $h->berlakuskhplama;?></td>
                                                <td nowrap><?= $h->lokasisebelumnya;?></td>
                                                <td class="text-center" nowrap><?= $h->namalokasi;?></td>
                                                <td class="text-center" nowrap><?= $h->jadwal;?></td>
                                                <td nowrap><?= $h->namapenera;?></td>
                                                <td nowrap><?= $h->nobukti == "" ? "-":"<a href='$h->file_buktibayar' target='_blank' class='btn btn-primary btn-xs'>$h->nobukti</a>";?></td>
                                                <td class="text-center" nowrap><?= $h->tglbayar;?></td>
                                                <td nowrap><?= $h->nosuratskrd;?></td>
                                                <td class="text-center" nowrap><?= $h->tglsuratskrd;?></td>
                                                <td nowrap><?= $h->nosuratskhp;?></td>
                                                <td class="text-center" nowrap><?= $h->tglsuratskhp;?></td>
                                                <td class="text-center" nowrap><?= $h->berlakuskhp;?></td>
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
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pengajuan/<?= "$kduttppeserta/1/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-backward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pengajuan/<?= "$kduttppeserta/$link_prev/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-backward"></i></a></li>
									<?
										}

										for ($i = $start_number; $i <= $end_number; $i++) {
											if ($page == $i) {
												$link_active = "";
												$link_color = "class='page-item disabled'";
											} else {
												$link_active = base_url() . "pelayanan/pengajuan/$kduttppeserta/$i/$limit/$getcari";
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
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pengajuan/<?= "$kduttppeserta/$link_next/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-step-forward"></i></a></li>
									<li class="page-item"><a href="<?= base_url(); ?>pelayanan/pengajuan/<?= "$kduttppeserta/$jumlah_page/$limit/$getcari";?>#divider" class="page-link"><i class="fa fa-fast-forward"></i></a></li>
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