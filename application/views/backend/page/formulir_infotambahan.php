<div class="content-wrapper">
    <section class="content-header">
        <h1>
            UTTP Wajib Tera
            <small>Informasi tambahan untuk pengajuan pada UTTP<br><?= $namauttp;?></small>
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

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Formulir Informasi Tambahan
                        </h3>
                    </div>
                    <form id="frm_sop" name="frm_sop" method="post" action="<?= base_url(); ?>uttp/prosesinfotambahan/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdinfotambahan; ?>">
                        <input type="hidden" id="kduttp" name="kduttp" value="<?= $kduttp; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Informasi yang dibutuhkan</label>
                                                <input type="text" class="form-control" name="info" id="info" value="<?= $info; ?>" maxlength=150 autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>uttp/infotambahan/<?= $kduttp;?>" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

