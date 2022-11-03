<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Tentang Kami
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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Isi Tentang Kami
                        </h3>
                    </div>
                    <form id="frm_tentang" name="frm_tentang" method="post" action="<?= base_url(); ?>tentang/proses" onsubmit="showloading()">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Sekilas</label>
                                <textarea class="form-control ckeditor" name="singkat" id="singkat" rows="4" required /><?= $singkat; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Isi tentang kami</label>
                                <textarea class="form-control ckeditor" name="isi" id="isi" rows="4" required /><?= $isi; ?></textarea>
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