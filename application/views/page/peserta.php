<div class="area-padding">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2 class="judul-page"><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
        
		<div class="row">
            <div  class="registrasi">
                <!-- single-well end-->
                <div class="col-md-12 text-center">
                    <!-- <a href="<?= base_url();?>pelayanan/uttp/<?= $kdpeserta;?>" class="btn bg-blue"><i class="fa fa-balance-scale"></i> Daftar UTTP</a> -->
                    <a href="<?= base_url();?>pelayanan/monitoring/<?= $kdpeserta;?>/<?= $mode;?>" class="btn bg-olive"><i class="fa fa-binoculars"></i> Monitoring <?= $monitoringpengajuan;?></a>
                    <a href="<?= base_url();?>panduanpeserta.pdf" target="_blank" class="btn bg-maroon"><i class="fa fa-book"></i> Panduan</a>
                </div>

                <div class="col-md-12">&nbsp;</div>

                <div class="col-md-12">
                    <div class="well-middle">
                        <div class="single-well">
                            <div class="box box-khusus box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-user"></i> Data Peserta
                                    </h3>
                                    <a href="<?= base_url();?>pelayanan/logout" class="btn bg-maroon pull-right btn-xs" onclick="return confirm('Keluar dari area peserta ?')"><i class="fa fa-lock"></i> Log Out</a>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>Informasi Usaha</legend>
                                                <dl class="dl-horizontal dl-usaha">
                                                    <dt>Kelompok</dt><dd><?= $namakelompok;?></dd>
                                                    <dt>NPWP</dt><dd><?= $npwp;?></dd>
                                                    <dt>Nama</dt><dd><?= $nama;?></dd>
                                                    <dt>Alamat</dt><dd><?= $alamat;?></dd>
                                                    <dt>Kelurahan</dt><dd><?= $kelurahan;?></dd>
                                                    <dt>Kecamatan</dt><dd><?= $kecamatan;?></dd>
                                                    <dt>Telp</dt><dd><?= $telp;?></dd>
                                                    <dt>Email</dt><dd><?= $email;?></dd>
                                                    <!-- <dt>Izin Usah</dt>
                                                        <dd>
                                                            <?if($file_izinusaha != "#"){?>
                                                            <a href="<?= $file_izinusaha;?>" target="_blank" class="btn btn-info btn-xs">Lihat Izin Usaha</a>
                                                            <?}else{echo "tidak ada berkas Izin Usah";}?>
                                                        </dd>
                                                    <dt>Akta Pendirian</dt>
                                                        <dd>
                                                            <?if($file_aktapendirian != "#"){?>
                                                            <a href="<?= $file_aktapendirian;?>" target="_blank" class="btn btn-info btn-xs">Lihat Akta Pendirian</a>
                                                            <?}else{echo "tidak ada berkas Akta Pendirian";}?>
                                                        </dd> -->
                                                </dl>
                                            </fieldset>
                                            <br>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>Informasi PIC</legend>
                                                <dl class="dl-horizontal dl-pic">
                                                    <dt>NIK</dt><dd><?= $nik;?></dd>
                                                    <dt>Nama</dt><dd><?= $namapic;?></dd>
                                                    <dt>Jabatan</dt><dd><?= $jabatan;?></dd>
                                                    <dt>Telp</dt><dd><?= $telppic;?></dd>
                                                    <dt>Email</dt><dd><?= $emailpic;?></dd>
                                                    <dt>WhatsApp</dt><dd><?= $wa;?></dd>
                                                    <!-- <dt>KTP</dt><dd><a href="<?= $file_ktp;?>" target="_blank" class="btn btn-info btn-xs">Lihat</a></dd> -->
                                                    <dt>Jumlah Alat UTTP</dt><dd><?= $jmluttp;?></dd>
                                                    <?if($kelompok == 2){?>
                                                    <dt>Jumlah Pelanggan</dt><dd><?= $jmlpelanggan;?></dd>
                                                    <?}?>
                                                    <dt>Jumlah SKHP Expired</dt><dd><?= $totalexpired;?></dd>
                                                </dl>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-12">&nbsp;</div>
                                        <?extract($infoapp);?>
                                        <div class="col-md-12">
                                            <fieldset>
                                                <legend>Catatan:</legend>
                                                <ol class="text-red">
                                                    <li>Jika ada data yang salah dan perlu diubah silakan email atau whatsapp kami untuk segera dilakukan update</li>
                                                    <li>Pastikan data alat UTTP yang dimiliki telah di daftarkan semua sebelum melakukan proses pengajuan tera/tera ulang</li>
                                                    <li>Data alat UTTP hanya bisa Anda ubah sendiri jika belum ada pengajuan tera/tera ulang untuk alat tersebut, jika sudah ada pengajuan maka silakan informasikan segera kepada kami untuk melakukan update</li>
                                                    <li>Seluruh data Anda hanya dapat dilihat dan diakses oleh <b>Anda sendiri</b> dan kami selaku pengelola sistem di <b><?= $namakantor;?></b>, maka pastikan username dan password akses Anda tidak di share ke orang lain yang tidak berkepentingan</li>
                                                </ol>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="box-footer">
                                    <a href="<?= base_url();?>pelayanan/logout" class="btn btn-danger pull-right" onclick="return confirm('Keluar dari area peserta ?')"><i class="fa fa-lock"></i> Log Out</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- End Blog Area -->