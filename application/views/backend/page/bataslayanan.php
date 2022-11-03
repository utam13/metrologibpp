<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Maks. Waktu Layanan Per-Hari
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
                            Maks. Waktu 
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="frm_batas" name="frm_batas" method="post" action="<?= base_url(); ?>bataslayanan/proses" onsubmit="showloading()">
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="lama" id="lama" value="<?= $lama; ?>" max=9999 autocomplete="off" />
                                        <span class="input-group-addon">menit</span>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                            <a href="<?= base_url();?>bataslayanan" class="btn btn-danger"><i class="fa fa-close"></i> Batal</a>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>