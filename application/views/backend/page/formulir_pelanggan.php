<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Peserta Tera/Tera Ulang
            <small>Formulir Pelanggan dari <?= $penyedia;?></small>
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
                            Formulir Pelanggan <small>Tanggal Terdata: <?= $tgldaftar;?></small>
                        </h3>

                        <div style="float:right">
                            <a href="<?= base_url();?>pelanggan/index/<?= $kdpenyedia;?>" class="btn btn-default btn-xs"><i class="fa fa-reply"></i> Kembali</a>
                        </div>
                    </div>
                    <form id="frm_pelanggan" name="frm_pelanggan" method="post" action="<?= base_url(); ?>pelanggan/prosespelanggan/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdpeserta; ?>">
                        <input type="hidden" id="kdpenyedia" name="kdpenyedia" value="<?= $kdpenyedia; ?>">
                        <input type="hidden" id="npwp_awal" name="npwp_awal" value="<?= $npwp; ?>">
                        <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                        <input type="hidden" id="telp_awal" name="telp_awal" value="<?= $telp; ?>">
                        <input type="hidden" id="email_awal" name="email_awal" value="<?= $email; ?>">
                        <input type="hidden" id="adaplg" name="adaplg" value="">
                        <input type="hidden" id="proses" name="proses" value="<?= $proses;?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>NPWP <code>*)</code></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control block-specialchar" name="npwp" id="npwppelanggan" value="<?= $npwp;?>" maxlength=50 autocomplete="off" required />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat btn-cek" onclick="ceknpwp()" <?= $proses == 1 ? "":"disabled";?> >Cek</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">    
                                                <label>Nama</label>
                                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama;?>" maxlength=150 autocomplete="off" required <?= $proses == 1 ? "readonly":"";?> />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kecamatan</label>
                                                <select class="form-control" id="kecamatan" name="kecamatan" required <?= $proses == 1 ? "disabled":"";?> >
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
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kelurahan</label>
                                                <select class="form-control" id="kelurahan" name="kelurahan" required <?= $proses == 1 ? "disabled":"";?> >
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

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telp</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input type="text" class="form-control block-specialchar" name="telp" id="telp" value="<?= $telp;?>" maxlength=50 autocomplete="off" required <?= $proses == 1 ? "readonly":"";?> >
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Email</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                                    <input type="email" class="form-control" name="email" id="email" value="<?= $email;?>" maxlength=150 autocomplete="off" required <?= $proses == 1 ? "readonly":"";?> >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" value="<?= $alamat;?>" maxlength=150 autocomplete="off" required <?= $proses == 1 ? "readonly":"";?> />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <code>*) NPWP pribadi untuk non perusahaan</code>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>pelanggan/index/<?= $kdpenyedia;?>" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> <?= $proses == "1" ? "Daftar":"Simpan";?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

