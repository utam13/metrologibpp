<div class="content-wrapper">
    <section class="content-header">
        <h1>
            UTTP Wajib Tera
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
                            <a href="<?= base_url();?>uttp/formulir/1" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah UTTP</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>uttp" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian:</label>
                                    <input type="text" class="form-control input-sm" name="cari" placeholder="Nama UTTP" required autocomplete="off" value="" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>uttp" class="btn bg-purple btn-sm" onclick="showloading()">Refresh</a>
                                </div>
                                <div class="form-group">
                                    <select class="form-control input-sm" id="limitpage" name="limitpage" onchange="submit()">
                                        <option value="20" <? if ($limit==20) { echo "selected='selected'" ; }; ?> >20</option>
                                        <option value="40" <? if ($limit==40) { echo "selected='selected'" ; }; ?> >40</option>
                                        <option value="60" <? if ($limit==60) { echo "selected='selected'" ; }; ?> >60</option>
                                        <option value="80" <? if ($limit==80) { echo "selected='selected'" ; }; ?> >80</option>
                                        <option value="100" <? if ($limit==100) { echo "selected='selected'" ; }; ?> >100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="mytable">
                            <thead class="bg-light-blue">
                                <tr>
                                    <th class="text-center" style="width:2%;">No.</th>
                                    <th class="text-center" style="width:8%;">#</th>
                                    <th class="text-center" style="width:15%;">Gambar</th>
                                    <th class="text-center" style="width:75%;">Informasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $hasil = json_decode($uttp);
                                foreach ($hasil as $h) {
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $h->no; ?></td>
                                        <td class="text-center" nowrap>
                                            <div>
                                                <a href="<?= base_url();?>uttp/formulir/2/<?= $h->kduttp; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url(); ?>uttp/proses/3/<?= $h->kduttp; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus UTTP dengan nama <?= $h->nama; ?> ?')"><i class="fa fa-trash"></i></a>
                                            </div>
                                            <div>&nbsp;</div>
                                            <div>
                                                <a href="<?= base_url(); ?>uttp/doktambahan/<?= $h->kduttp; ?>" class="btn <?= $h->adadoktambahan;?> btn-sm "><i class="fa fa-file"></i> Dokumen Persyaratan Tambahan</a>
                                            </div>
                                            <div>&nbsp;</div>
                                            <div>
                                                <a href="<?= base_url(); ?>uttp/infotambahan/<?= $h->kduttp; ?>" class="btn <?= $h->adainfotambahan;?> btn-sm "><i class="fa fa-list"></i> Informasi Tambahan</a>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?= $h->file_berkas;?>" target="_blank">
                                                <img src="<?= $h->file_berkas;?>" alt="gambar" style="width:100%;">
                                            </a>
                                        </td>
                                        <td colspan=2>
                                            <?= $h->info;?>
                                        </td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>

                        <div class="col-sm-12 mt-2">
                        <? if ($jumlah_page > 0) { ?>
                            <ul class="pagination pull-right">
                                <? if ($page == 1) { ?>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                                <? } else {
                                        $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                <li class="page-item"><a href="<?= base_url();?>uttp/index/1/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>uttp/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                <?
                                    }

                                    for ($i = $start_number; $i <= $end_number; $i++) {
                                        if ($page == $i) {
                                            $link_active = "";
                                            $link_color = "class='page-item disabled'";
                                        } else {
                                            $link_active = base_url() . "uttp/index/$i/$limit/$getcari";
                                            $link_color = "class='page-item'";
                                        }
                                    ?>
                                <li <?= $link_color; ?>><a href="<?= $link_active; ?>" class="page-link" onclick="showloading()"><?= $i; ?></a></li>
                                <? }

                                    if ($page == $jumlah_page) {
                                    ?>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-forward"></i></a></li>
                                <? } else {
                                        $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page; ?>
                                <li class="page-item"><a href="<?= base_url();?>uttp/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>uttp/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
                                <? } ?>
                            </ul>
                        <? } ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>