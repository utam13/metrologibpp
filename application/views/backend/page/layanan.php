<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Layanan
            <small>Daftar</small>
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
                            <a href="<?= base_url();?>layanan/formulir/1" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Layanan</a>
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th style="width:2%;">No.</th>
                                    <th style="width:8%;">#</th>
                                    <th style="width:20%;">Nama Layanan</th>
                                    <th style="width:70%;">Uraian Singkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $hasil = json_decode($layanan);
                                foreach ($hasil as $h) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $h->no; ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url();?>layanan/formulir/2/<?= $h->kdlayanan; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                            <a href="<?= base_url(); ?>layanan/proses/3/<?= $h->kdlayanan; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus layanan <?= $h->nama; ?> ?')"><i class="fa fa-trash"></i></a>
                                        </td>
                                        <td><?= $h->nama;?></td>
                                        <td><?= $h->uraian;?></td>
                                    </tr>
                                <? } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>