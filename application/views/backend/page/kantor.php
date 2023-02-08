<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Informasi Instansi
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
            <!-- Message area -->
            <?
            extract($alert);
            if ($kode_alert != "") {
            ?>
                <div class="col-lg-12">
                    <div class="alert <?= $jenisbox ?>">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
                    </div>
                </div>
            <? } ?>
            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Logo Aplikasi
                        </h3>
                    </div>
                    <div class="box-body box-profile text-center">
                        <form id="frm_logo" name="frm_logo" method="post" action="#">
                        <div class="row">
                            <div class="col-xs-12">
                                <img id="logo_app" class="img-responsive center-block" src="<?= $file_gambar_logo; ?>" alt="Logo Aplikasi" onclick="upload_logo()" style="cursor:pointer;width:60%;">
                                <br>
                                <p class="text-muted text-center"><i>klik untuk mengubah logo aplikasi maksimal 100 kb</i></p>
                            </div>
                        </div>                        
                        <input type="file" id="pilih_logo" accept=".jpg,.jpeg,.png,.gif,.bmp" style="display:none;">  
                        </form>  
                    </div>                    
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Informasi Kantor
                        </h3>
                    </div>
                    <form class="form-horizontal" id="frm_kantor" name="frm_kantor" method="post" action="<?= base_url(); ?>kantor/proses" onsubmit="showloading()">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" maxlength=250 autocomplete="off" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat" id="alamat" rows="4" placeholder="Isi alamat dengan lengkap" maxlength=250 required style="resize:none;"><?= $alamat; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Telp</label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control" name="telp" id="telp" value="<?= $telp; ?>" maxlength=50 autocomplete="off" required>
                                        <span class="input-group-addon">62-8xx-xxx-xxxx</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">WhatsApp <code>jika ada</code></label>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                                        <input type="text" class="form-control" name="wa" id="wa" value="<?= $wa; ?>" autocomplete="off" />
                                        <span class="input-group-addon">62-8xx-xxx-xxxx</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="email" id="email" value="<?= $email; ?>" maxlength=200 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Website</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="website" id="website" value="<?= $web; ?>" maxlength=200 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Waktu Pelayanan</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="waktuaktif" id="waktuaktif" value="<?= $waktuaktif; ?>" maxlength=200 autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Google Map</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="googlemap" id="googlemap" value="<?= $googlemap; ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Instagram <code>(jika ada)</code></label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                        <input type="text" class="form-control" name="ig" id="ig" value="<?= $ig; ?>" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Facebook <code>(jika ada)</code></label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                        <input type="text" class="form-control" name="fb" id="fb" value="<?= $fb; ?>" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Youtube <code>(jika ada)</code></label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                                        <input type="text" class="form-control" name="youtube" id="youtube" value="<?= $youtube; ?>" autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>