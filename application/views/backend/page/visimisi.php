<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Visi & Misi
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
                            Isi Visi & Misi
                        </h3>
                    </div>
                    <form id="frm_visimisi" name="frm_visimisi" method="post" action="<?= base_url(); ?>visimisi/proses" onsubmit="showloading()">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Visi</label>
                                        <textarea class="form-control ckeditor" name="visi" id="visi" rows="4" maxlength=250 required style="resize:none;"><?= $visi; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Misi</label>
                                        <textarea class="form-control ckeditor" name="misi" id="misi" rows="4" maxlength=250 required style="resize:none;"><?= $misi; ?></textarea>
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