<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Ubah Password
            <small>Formulir</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
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
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Formulir Perubahan Password
                        </h3>
                    </div>
                    <form id="frm_ubahpassword" name="frm_ubahpassword" method="post" action="<?= base_url(); ?>pegawai/prosesubahpassword" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdpegawai; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" value="" maxlength=100 autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password Lama</label>
                                        <div class="input-group">
                                            <input type="password" id="passwordlama" name="passwordlama" class="form-control" value="" autocomplete="new-password">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" onclick="lihatpasswordlama()"><span id="iconlihatlama" class="fa fa-eye"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password baru</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control" value="" autocomplete="new-password">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>admin" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

