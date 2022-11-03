<div class="content-wrapper">
    <section class="content-header">
        <h1>
            UTTP Wajib Tera
            <small>Dokumen Persyaratan Tambahan - <?= $namauttp;?></small>
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
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <a href="<?= base_url();?>uttp" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                            <a href="<?= base_url();?>uttp/formulirdokumen/1/<?= $kduttp;?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Dokumen</a>
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="text-center" style="width:2%;">No.</th>
                                        <th class="text-center" style="width:16%;">#</th>
                                        <th class="text-center" style="width:82%;">Dokumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    $hasil = json_decode($doktambahan);
                                    foreach ($hasil as $h) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $h->no; ?></td>
                                            <td class="text-center" nowrap>
                                                <?if($h->berkas != ""){?>
                                                    <a href="<?= $h->file_berkas; ?>" target="_blank" class="btn btn-info btn-xs">Contoh Dokumen</a>
                                                <?}?>

                                                <a href="<?= base_url();?>uttp/formulirdokumen/2/<?= $h->kduttp; ?>/<?= $h->kddoktambahan; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url(); ?>uttp/prosesdokumen/3/<?= $h->kduttp; ?>/<?= $h->kddoktambahan; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus Dokumen Tambahan dengan nama <?= $h->nama; ?> ?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td nowrap><?= $h->nama;?></td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>