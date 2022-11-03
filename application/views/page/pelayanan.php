<div class="area-padding bg-white">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2 class="judul-page"><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
        <!-- Message area -->
        <?
        extract($alert);
        if ($kode_alert != "") {
        ?>
        <div class="row login-contents">
            <div class="col-lg-6">
                <div class="alert <?= $jenisbox ?>">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
                </div>
            </div>
        </div>
        <? } ?>
        <div class="row login-notes login-contents <?= $halaman == "Registrasi Pelayanan" ? "sr-only":"";?> ">
            <div class="col-md-7 text-center">
                <code>Silakan melakukan registrasi terlebih dahulu jika Anda belum memiliki akses ke layanan kami.<br>Untuk melakukan registrasi silakan klik tombol registrasi pada box log in dibawah.</code>
            </div>
            <div class="col-md-12">&nbsp;</div>
        </div>
		<div class="row">
            <div class="login login-contents <?= $halaman == "Registrasi Pelayanan" ? "sr-only":"";?>">
                <div class="col-md-3 side-image">
                    <div class="well-left">
                        <div class="single-well">
                            <a href="#">
                                <img src="<?= base_url();?>assets/img/login.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- single-well end-->
                <div class="col-md-3">
                    <div class="well-middle">
                        <div class="single-well">
                            <div class="box box-khusus box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        Log In
                                    </h3>
                                </div>
                                <form id="frm_login" name="frm_login" method="post" action="<?= base_url(); ?>pelayanan/proseslogin" onsubmit="showloading()">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>NIK PIC</label>
                                            <input type="text" class="form-control text-center" name="username" id="username" value="" autocomplete="off" required />
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password" class="form-control text-center" autocomplete="new-password" placeholder="Password" required>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group text-center captcha">
                                            <?= $captchaview;?>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control text-center" id="cekcaptcha" name="cekcaptcha" value="" placeholder="Ketikkan Kode CAPTCHA di atas" autocomplete="off" required >
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default" onclick="recaptcha()"><i class="fa fa-refresh"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="button" class="btn bg-khusus btn-registrasi"><i class="fa fa-clipboard"></i> Registrasi</button>
                                        <button type="submit" class="btn bg-khusus btn-login pull-right" disabled><i class="fa fa-unlock"></i> Log In</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div  class="registrasi <?= $halaman == "Registrasi Pelayanan" ? "":"sr-only";?> ">
                <!-- single-well end-->
                <div class="col-md-12">
                    <div class="well-middle">
                        <div class="single-well">
                            <div class="box box-khusus box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        Formulir Registrasi Peserta
                                    </h3>
                                </div>
                                <form class="form-horizontal" id="frm_registrasi" name="frm_registrasi" method="post" action="<?= base_url(); ?>pelayanan/prosesregistrasi" onsubmit="showloading()">
                                    <input type="text" class="sr-only" id="kontrol" value="" />
                                    <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".pdf" />
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <legend>Informasi Usaha</legend>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Kelompok <code>*)</code></label>
                                                        <div class="col-sm-9">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="kelompok" id="kelompok1" value="1" required >
                                                                    Pemilik Alat
                                                                </label>
                                                                <span>&nbsp;</span>
                                                                <label>
                                                                    <input type="radio" name="kelompok" id="kelompok2" value="2" required >
                                                                    Penyedia Alat
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">NPWP <code>**)</code></label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control block-specialchar" name="npwp" id="npwp" value="" maxlength=50 autocomplete="off" required />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nama</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="nama" id="nama" value="" maxlength=150 autocomplete="off" required />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Alamat</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="alamat" id="alamat" value="" maxlength=150 autocomplete="off" required />
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Kecamatan</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" id="kecamatan" name="kecamatan" required >
                                                                <option value="">Pilih</option>
                                                                <?
                                                                foreach ($kecamatan as $k) {
                                                                    echo "<option value='".$k->kdkecamatan."'>".$k->nama."</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Kelurahan</label>
                                                        <div class="col-sm-4">
                                                            <select class="form-control" id="kelurahan" name="kelurahan" required >
                                                                <option value="">Pilih</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Telp</label>
                                                        <div class="col-sm-5">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                                <input type="text" class="form-control block-specialchar" name="telp" id="telp" value="" maxlength=50 autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                                <input type="email" class="form-control" name="email" id="email" value="" maxlength=150 autocomplete="off" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- <div class="form-group">
                                                        <label class="col-sm-3 control-label">Izin Usaha <code>**)</code></label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group">
                                                                <span class="input-group-btn span-lihat sr-only">
                                                                    <a href="#" target="_blank" class="btn btn-success btn-flat btn-lihat">Lihat</a>
                                                                </span>
                                                                <input type="text" class="form-control block-input" name="berkas" id="berkas" value="" placeholder="PDF">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn bg-khusus btn-flat btn-pilih" onclick="upload_berkas('izinusaha')">Pilih</button>
                                                                    <button type="button" class="btn btn-danger btn-flat btn-batal sr-only" onclick="batal_berkas('izinusaha')">Batal Berkas</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Akta Pendirian <code>**)</code></label>
                                                        <div class="col-sm-9">
                                                            <div class="input-group">
                                                                <span class="input-group-btn span-lihat2 sr-only">
                                                                    <a href="#" target="_blank" class="btn btn-success btn-flat btn-lihat2">Lihat</a>
                                                                </span>
                                                                <input type="text" class="form-control block-input" name="berkas2" id="berkas2" value="" placeholder="PDF">
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn bg-khusus btn-flat btn-pilih2" onclick="upload_berkas('aktapendirian')">Pilih</button>
                                                                    <button type="button" class="btn btn-danger btn-flat btn-batal2 sr-only" onclick="batal_berkas('aktapendirian')">Batal Berkas</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <legend>Informasi PIC</legend>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">NIK</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control block-specialchar" name="nik" id="nik" value="" maxlength=150 autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nama</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" name="namapic" id="namapic" value="" maxlength=150 autocomplete="off" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Jabatan</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control block-specialchar" name="jabatan" id="jabatan" value="" maxlength=150 autocomplete="off" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Telp</label>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                                <input type="text" class="form-control block-specialchar" name="telppic" id="telppic" value="" maxlength=150 autocomplete="off" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">WhatsApp</label>
                                                        <div class="col-sm-6">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                                                                <input type="text" class="form-control block-specialchar" name="wa" id="wa" value="" autocomplete="off" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                                <input type="email" class="form-control" name="emailpic" id="emailpic" value="" maxlength=150 autocomplete="off" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="form-group">
                                                        <label class="col-sm-2 control-label">KTP <code>***)</code></label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <span class="input-group-btn span-lihat3 sr-only">
                                                                    <a href="#" target="_blank" class="btn btn-success btn-flat btn-lihat3">Lihat</a>
                                                                </span>
                                                                <input type="text" class="form-control block-input" name="berkas3" id="berkas3" value="" placeholder="PDF" required >
                                                                <span class="input-group-btn">
                                                                    <button type="button" class="btn bg-khusus btn-flat btn-pilih3" onclick="upload_berkas('ktp')">Pilih</button>
                                                                    <button type="button" class="btn btn-danger btn-flat btn-batal3 sr-only" onclick="batal_berkas('ktp')">Batal Berkas</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </fieldset>
                                            </div>
                                            <div class="col-md-12">&nbsp;</div>
                                            <div class="col-sm-12">
                                                <fieldset>
                                                    <legend>Catatan:</legend>
                                                    <!-- <ol class="text-red">
                                                        <li>*) untuk non badan usaha masukkan NPWP pribadi</li>
                                                        <li>**) khusus badan usaha wajib diupload, berkas berupa file PDF dengan ukuran maks. 2 Mb</li>
                                                        <li>***) berkas KTP PIC berupa file PDF dengan ukuran maks. 2 Mb</li>
                                                    </ol> -->
                                                    <ol class="text-red">
                                                        <li>*) jika alat UTTP adalah milik sendiri pilih <b>Pemilik Alat</b>, jika penyedia alat UTTP yang digunakan pelanggan maka pilih <b>Penyedia Alat</b> </li>
                                                        <li>**) untuk non badan usaha masukkan NPWP pribadi</li>
                                                    </ol>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a href="<?= base_url();?>" class="btn btn-danger" onclick="return confirm('Batalkan registrasi peserta ?')">Batal</a>
                                        <button type="submit" class="btn bg-khusus pull-right btn-simpan">Daftarkan</button>
                                    </div>
                                </form>
                                <div class="overlay sr-only">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- End Blog Area -->