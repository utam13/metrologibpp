<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Peserta Tera/Tera Ulang
            <small>Formulir</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div id="progress_div" class="col-lg-12" style="display:none;">
                <div class="progress progress-sm active">
                    <div id="progress_bar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Formulir Peserta <small>Tanggal Terdata: <?= $tgldaftar;?></small>
                        </h3>
                    </div>
                    <form id="frm_pegawai" name="frm_pegawai" method="post" action="<?= base_url(); ?>peserta/proses/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdpeserta; ?>">
                        <input type="hidden" id="npwp_awal" name="npwp_awal" value="<?= $npwp; ?>">
                        <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                        <input type="hidden" id="telp_awal" name="telp_awal" value="<?= $telp; ?>">
                        <input type="hidden" id="email_awal" name="email_awal" value="<?= $email; ?>">
                        <input type="hidden" id="nik_awal" name="nik_awal" value="<?= $nik; ?>">
                        <input type="hidden" id="telppic_awal" name="telppic_awal" value="<?= $telppic; ?>">
                        <input type="hidden" id="wa_awal" name="wa_awal" value="<?= $wa; ?>">
                        <input type="hidden" id="emailpic_awal" name="emailpic_awal" value="<?= $emailpic; ?>">
                        <input type="hidden" id="status" name="status" value="<?= $status; ?>">
                        <!-- <input type="text" class="sr-only" id="kontrol" value="" />
                        <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.pdf" /> -->
                        <div class="box-body">
                            <fieldset class="col-md-12">
                                <legend>Informasi Usaha</legend>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>NPWP <code>*)</code></label>
                                                    <input type="text" class="form-control block-specialchar" name="npwp" id="npwp" value="<?= $npwp;?>" maxlength=50 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                </div>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">    
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $alamat;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                </div>
                                            </div>
                                            <code class="col-md-12">*) NPWP pribadi untuk non perusahaan</code>
                                            <div class="col-md-12">&nbsp;</div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kecamatan</label>
                                                    <select class="form-control" id="kecamatan" name="kecamatan" required <?= $status != "" && $status == 0 ? "disabled":"";?> >
                                                        <option value="">Pilih</option>
                                                        <?
                                                        foreach ($daftarkecamatan as $k) {
                                                            $pilihkecamatan = $kecamatan == $k->kdkecamatan ? 'selected':'';
                                                            echo "<option value='".$k->kdkecamatan."' $pilihkecamatan>".$k->nama."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Kelurahan</label>
                                                    <select class="form-control" id="kelurahan" name="kelurahan" required <?= $status != "" && $status == 0 ? "disabled":"";?> >
                                                        <option value="">Pilih</option>
                                                        <?
                                                        if($proses == 2){
                                                            foreach ($daftarkelurahan as $k) {
                                                                $pilihkelurahan = $kelurahan == $k->kdkelurahan ? 'selected':'';
                                                                echo "<option value='".$k->kdkelurahan."' $pilihkelurahan>".$k->nama."</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Telp</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                        <input type="text" class="form-control block-specialchar" name="telp" id="telp" value="<?= $telp;?>" maxlength=50 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-6">  
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input type="email" class="form-control" name="email" id="email" value="<?= $email;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> >
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
                                            <!-- <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Izin Usaha <code>**)</code></label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat <?= $izinusaha != "" ? "": "sr-only";?>">
                                                            <a href="<?= $izinusaha != "" ? $file_izinusaha : "#";?>" target="_blank" class="btn btn-success btn-flat btn-lihat">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas" id="berkas" value="<?= $izinusaha != "" ? $izinusaha : "";?>" <?= $status != "" && $status == 0 ? "readonly":"";?> >
                                                        <span class="input-group-btn">
                                                            <?if($status == "" || $status != 0){?>
                                                                <button type="button" class="btn btn-primary btn-flat btn-pilih" onclick="upload_berkas('izinusaha')">Pilih</button>
                                                                <button type="button" class="btn btn-danger btn-flat btn-batal sr-only" onclick="batal_berkas('izinusaha')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                                
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Akta Pendirian <code>**)</code></label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat2 <?= $aktapendirian != "" ? "": "sr-only";?>">
                                                            <a href="<?= $aktapendirian != "" ? $file_aktapendirian : "#";?>" target="_blank" class="btn btn-success btn-flat2 btn-lihat">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas2" id="berkas2" value="<?= $aktapendirian != "" ? $aktapendirian : "";?>" <?= $status != "" && $status == 0 ? "readonly":"";?> >
                                                        <span class="input-group-btn">
                                                            <?if($status == "" || $status != 0){?>
                                                                <button type="button" class="btn btn-primary btn-flat btn-pilih2" onclick="upload_berkas('aktapendirian')">Pilih</button>
                                                                <button type="button" class="btn btn-danger btn-flat btn-batal2 sr-only" onclick="batal_berkas('aktapendirian')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <!-- <code class="col-md-12">**)Berkas PDF (maks. 2 Mb), khusus perusahaan</code> -->
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Kelompok</label>
                                                    <select class="form-control" id="kelompok" name="kelompok" required <?= $status != "" && $status == 0 ? "disabled":"";?> >
                                                        <option value="">Pilih</option>
                                                        <option value="1" <?= $kelompok == 1 ? "selected":"";?> >Pemilik Alat</option>
                                                        <option value="2" <?= $kelompok == 2 ? "selected":"";?> >Penyedia Alat</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $alamat;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <code class="col-md-12">*) NPWP pribadi untuk non perusahaan</code>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="col-md-12">&nbsp;</div>

                            <fieldset class="col-md-12">
                                <legend>Informasi PIC</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>No. KTP</label>
                                                    <input type="text" class="form-control block-specialchar" name="nik" id="nik" value="<?= $nik;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> >
                                                </div>
                                            </div>

                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="namapic" id="namapic" value="<?= $namapic;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                </div>
                                            </div>

                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label>Jabatan</label>
                                                    <input type="text" class="form-control block-specialchar" name="jabatan" id="jabatan" value="<?= $jabatan;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>Telp</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                        <input type="text" class="form-control block-specialchar" name="telppic" id="telppic" value="<?= $telppic;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>WhatsApp</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                                                        <input type="text" class="form-control block-specialchar" name="wa" id="wa" value="<?= $wa;?>" autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                        <input type="email" class="form-control" name="emailpic" id="emailpic" value="<?= $emailpic;?>" maxlength=150 autocomplete="off" required <?= $status != "" && $status == 0 ? "readonly":"";?> />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- <div class="col-sm-10">
                                                <div class="form-group">
                                                    <label>KTP <code>**)</code></label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat3 <?= $ktp != "" ? "": "sr-only";?>">
                                                            <a href="<?= $ktp != "" ? $file_ktp : "#";?>" target="_blank" class="btn btn-success btn-flat3 btn-lihat">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas3" id="berkas3" value="<?= $ktp != "" ? $ktp : "";?>" required <?= $status != "" && $status == 0 ? "readonly":"";?> >
                                                        <span class="input-group-btn">
                                                            <?if($status == "" || $status != 0){?>
                                                                <button type="button" class="btn btn-primary btn-flat btn-pilih3" onclick="upload_berkas('ktp')">Pilih</button>
                                                                <button type="button" class="btn btn-danger btn-flat btn-batal3 sr-only" onclick="batal_berkas('ktp')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control password-input" name="password" id="password" value="<?= $password;?>" maxlength=50 required />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                                                            <button type="button" class="btn btn-primary btn-flat" onclick="genpass()">Generate Password</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="box-footer">
                            <a href="<?= $kelompok == 3 ? base_url()."peserta/pelanggan/$kdpenyedia" : base_url()."peserta";?>" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <?if($status != "" && $status == 0){?>
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-thumbs-up"></i> Diterima</button>
                            <?}else{?>
                                <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                            <?}?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

