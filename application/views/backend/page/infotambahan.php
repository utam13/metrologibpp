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
                            <a href="<?= base_url();?>uttp/formulirinfotambahan/1/<?= $kduttp;?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Informasi</a>
                        </h3>
                        <code class="pull-right">Informasi ini akan tampil pada halaman pengajuan pelayanan</code>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered table-striped" id="mytable">
                                <thead class="bg-light-blue">
                                    <tr>
                                        <th class="text-center" style="width:2%;">No.</th>
                                        <th class="text-center" style="width:16%;">#</th>
                                        <th class="text-center" style="width:82%;">Informasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    $hasil = json_decode($infotambahan);
                                    foreach ($hasil as $h) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= $h->no; ?></td>
                                            <td class="text-center" nowrap>
                                                <a href="<?= base_url();?>uttp/formulirinfotambahan/2/<?= $h->kduttp; ?>/<?= $h->kdinfotambahan; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url(); ?>uttp/prosesinfotambahan/3/<?= $h->kduttp; ?>/<?= $h->kdinfotambahan; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus informasi tambahan <?= $h->info; ?> ?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td nowrap><?= $h->info;?></td>
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