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
                            <div class="col-md-12">
                                Daftar UTTP <?= $namauttp;?> 
                            </div>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="col-md-12">
                                Kecamatan <?= $namakecamatan;?> 
                            </div>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="col-md-12">
                                Kelurahan <?= $namakelurahan;?> 
                            </div>
						</h3>
					</div>
					<div class="box-body">
						<div class="row">
                            <div class="col-md-12">
                                <a href="<?= base_url();?>info/detailkelurahan/<?= $kduttp;?>/<?= $kdkecamatan;?>" class="btn btn-default"><i class="fa fa-reply"></i> Kembali Per-Kelurahan</a>
                            </div>
							<div class="col-md-12 table-responsive">
								<table class="table table-striped table-hover table-bordered table-sm table-normal">
									<thead class="bg-khusus">
										<tr>
											<th scope="col" class="text-center" style="width:10px;">No</th>
											<th scope="col" class="text-center">Nama</th>
                                            <th scope="col" class="text-center">Alamat</th>
											<th scope="col" class="text-center">Jumlah</th>
										</tr>
									</thead>
									<tbody>
										<?
										$hasil = json_decode($pemilik);
										foreach ($hasil as $h) {
										?>
											<tr>
												<td class="text-center"><?= $h->no;?></td>
												<td><?= $h->nama;?></td>
                                                <td><?= $h->alamat;?></td>
												<td class="text-center"><?= $h->total;?></td>
											</tr>
										<? } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
	</div>
</div>
<!-- End Blog Area -->