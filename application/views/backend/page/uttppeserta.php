<div class="content-wrapper">
    <section class="content-header">
        <h1>
            UTTP Peserta Tera/Tera Ulang
            <small>Nama Peserta: <?= $namapeserta;?></small>
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
                            <a href="<?= $mode == 2 ? base_url()."pelanggan/index/$kdpenyedia" : base_url()."peserta";?>" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                            <a href="<?= base_url();?>uttppeserta/formuliruttp/<?= $kdpeserta;?>/1/<?= $mode;?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah UTTP</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url();?>uttppeserta/index/<?= $kdpeserta;?>/<?= $mode;?>" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian dengan:</label>
                                    <input type="text" class="form-control input-sm" name="cari" required placeholder="Nama Alat atau No. SKHP" autocomplete="off" value="" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>uttppeserta/index/<?= $kdpeserta;?>/<?= $mode;?>" class="btn bg-purple btn-sm" onclick="showloading()">Refresh</a>
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
                                <div class="form-group">
                                    <a href="<?= base_url(); ?>excel/index/uttppeserta/<?= $kdpeserta."_".$mode;?>/<?= $getcari;?>" target="prosesdata" class="btn bg-green btn-sm">Download Excel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped" id="mytable">
                                    <thead class="bg-light-blue">
                                        <tr>
                                            <th scope="col" nowrap class="text-center" style="width:5%;">No.</th>
                                            <th scope="col" nowrap class="text-center" style="width:10%;">#</th>
                                            <th scope="col" nowrap class="text-center">Jenis UTTP</th>
                                            <th scope="col" nowrap class="text-center">Merk/Type</th>
                                            <th scope="col" nowrap class="text-center">Kapasitas</th>
                                            <th scope="col" nowrap class="text-center">No. Seri</th>
                                            <!-- <th scope="col" nowrap class="text-center">Jumlah</th> -->
                                            <th scope="col" nowrap class="text-center">No. SKHP<br>Terakhir</th>
                                            <th scope="col" nowrap class="text-center">Tera/Tera Ulang<br>Terakhir</th>
                                            <th scope="col" nowrap class="text-center">Berlaku Sampai</th>
                                            <th scope="col" nowrap class="text-center">Jumlah Pengajuan<br>Tera/Tera Ulang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $hasil = json_decode($uttp);
                                        foreach ($hasil as $d) {
                                        ?>
                                        <tr class="<?= $d->warnabg;?>">
                                            <td scope="col" class="text-center"><?= $d->no;?></td>
                                            <td scope="col" nowrap class="text-center">
                                                <a href="<?= base_url();?>uttppeserta/formuliruttp/<?= $kdpeserta;?>/2/<?= $mode;?>/<?= $d->kduttppeserta; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url();?>uttppeserta/prosesuttp/3/<?= $mode;?>/<?= $kdpeserta;?>/<?= $d->kduttppeserta;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus uttp peserta\n<?= $d->nama;?> ?')"><i class="fa fa-trash"></i></a>
                                                <?if($mode == 2){?>
                                                <a href="<?= base_url();?>uttppeserta/prosesuttp/4/<?= $mode;?>/<?= $kdpeserta;?>/<?= $d->kduttppeserta;?>" class="btn btn-info btn-xs" onclick="return confirm('Mengalihkan kepemilikan uttp ke pelanggan <?= $namapeserta;?>?')"><i class="fa fa-unlink"></i></a>
                                                <?}?>
                                                <a href="<?= base_url();?>permintaan/formulir/<?= $d->kduttppeserta;?>/<?= $d->proses;?>" class="btn <?= $d->warnatombol;?> btn-xs"><?= $d->namatombol;?></a>
                                            </td>
                                            <td scope="col" nowrap><?= $d->nama;?></td>
                                            <td scope="col" nowrap><?= $d->merktype;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->kapasitas;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->noseri;?></td>
                                            <!-- <td scope="col" nowrap class="text-center"><?= $d->jml;?> unit</td> -->
                                            <td scope="col" nowrap class="text-center"><?= $d->noskhp;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->tglterakhir;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->berlakusampai;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->jmlpengajuan;?></td>
                                        </tr>
                                        <?}?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <? if ($jumlah_page > 0) { ?>
                                    <ul class="pagination pull-right">
                                        <? if ($page == 1) { ?>
                                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                                        <? } else {
                                                $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                        <li class="page-item"><a href="<?= base_url();?>uttppeserta/index/<?= $kdpeserta;?>/1/<?= $mode;?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url();?>uttppeserta/index/<?= $kdpeserta;?>/<?= $link_prev; ?>/<?= $mode;?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                        <?
                                            }

                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                if ($page == $i) {
                                                    $link_active = "";
                                                    $link_color = "class='page-item disabled'";
                                                } else {
                                                    $link_active = base_url() . "uttppeserta/index/$kdpeserta/$i/$mode/$limit/$getkategori/$getcari";
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
                                        <li class="page-item"><a href="<?= base_url();?>uttppeserta/index/<?= $kdpeserta;?>/<?= $link_next; ?>/<?= $mode;?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url();?>uttppeserta/index/<?= $kdpeserta;?>/<?= $jumlah_page; ?>/<?= $mode;?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
                                        <? } ?>
                                    </ul>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>