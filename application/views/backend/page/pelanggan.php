<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Peserta Tera/Tera Ulang
            <small>Daftar Pelanggan dari <?= $penyedia;?></small>
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
                            <a href="<?= base_url();?>peserta" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                            <a href="<?= base_url();?>pelanggan/formulirpelanggan/<?= $kdpenyedia;?>/1" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Pelanggan</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>pelanggan/index/<?= $kdpenyedia;?>" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian dengan:</label>
                                    <select class="form-control input-sm" id="kategori" name="kategori">
                                        <option value="b.npwp">NPWP</option>
                                        <option value="b.nama">Nama Usaha</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" id="cari" name="cari" required autocomplete="off" value="" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>pelanggan/index/<?= $kdpenyedia;?>" class="btn bg-purple btn-sm" onclick="showloading()">Refresh</a>
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
                                    <a href="<?= base_url(); ?>excel/pelanggan/<?= $kdpenyedia;?>/<?= $getkategori;?>/<?= $getcari;?>" target="prosesdata" class="btn bg-green btn-sm">Download Excel</a>
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
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:5%;">No.</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">#</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml UTTP</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml SKHP Expired</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Tgl. Daftar</th>
                                            <th scope="col" colspan=7 nowrap class="text-center">Informasi Usaha</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" nowrap class="text-center">NPWP</th>
                                            <th scope="col" nowrap class="text-center">Nama Usaha</th>
                                            <th scope="col" nowrap class="text-center">Alamat</th>
                                            <th scope="col" nowrap class="text-center">Kelurahan</th>
                                            <th scope="col" nowrap class="text-center">Kecamatan</th>
                                            <th scope="col" nowrap class="text-center">Telp</th>
                                            <th scope="col" nowrap class="text-center">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $hasil = json_decode($peserta);
                                        foreach ($hasil as $d) {
                                        ?>
                                        <tr>
                                            <td scope="col" class="text-center"><?= $d->no;?></td>
                                            <td scope="col" nowrap>
                                                <?if($d->kelompok == 3){?>
                                                <a href="<?= base_url();?>pelanggan/formulirpelanggan/<?= $kdpenyedia;?>/2/<?= $d->kdpeserta; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url();?>pelanggan/prosespelanggan/3/<?= $kdpenyedia;?>/<?= $d->kdpeserta;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus pelanggan berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nLanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                                <?}?>

                                                <?if($d->kelompok == 1 && ($d->jmluttpmilik != 0 || $d->nominaljmluttp == 0)){?>
                                                <a href="<?= base_url();?>pelanggan/prosespelanggan/4/<?= $kdpenyedia;?>/<?= $d->kdpeserta;?>" class="btn btn-info btn-xs" onclick="return confirm('Melepas pelanggan berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nLanjutkan proses ?')"><i class="fa fa-unlink"></i></a>
                                                <?}?>

                                                <?if($d->kelompok == 3 && ($d->jmluttpmilik != 0 || $d->nominaljmluttp == 0)){?>
                                                    <a href="<?= base_url();?>pelanggan/formulir/2/<?= $d->kdpeserta;?>" class="btn btn-warning btn-xs" onclick="return confirm('Daftarkan pelanggan berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nSebagai peserta, dikarenakan ada sebagian atau selutuh alat yang sudah menjadi milik pelanggan. Lanjutkan proses ?')">Daftarkan</a>
                                                <?}elseif($d->kelompok == 1 && ($d->jmluttpmilik != 0 || $d->nominaljmluttp == 0)){?>
                                                    <a href="#" class="btn btn-default btn-xs" onclick="alert('Sebagian alat masih belum dialihkan kepemilikannya\nPerubahan data pelanggan dapat dilakukan secara mandiri oleh pelanggan atau dengan bantuan Admin')">Terdaftar</a>
                                                <?}else{?>
                                                    <a href="#" class="btn btn-default btn-xs" onclick="alert('Masih ada alat yang belum dilepas kepemilikannya')">Daftarkan</a>
                                                <?}?>
                                            </td>
                                            <td scope="col" class="text-center"><?= $d->jmluttp;?></td>
                                            <td scope="col" class="text-center"><?= $d->totalexpired;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->tgldaftar;?></td>
                                            <td scope="col" nowrap><?= $d->npwp;?></td>
                                            <td scope="col" nowrap><?= $d->nama;?></td>
                                            <td scope="col" nowrap><?= $d->alamat;?></td>
                                            <td scope="col" nowrap><?= $d->kelurahan;?></td>
                                            <td scope="col" nowrap><?= $d->kecamatan;?></td>
                                            <td scope="col" nowrap><?= $d->telp;?></td>
                                            <td scope="col" nowrap><?= $d->email;?></td>
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
                                        <li class="page-item"><a href="<?= base_url();?>pelanggan/index/<?= $kdpenyedia;?>/1/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url();?>pelanggan/index/<?= $kdpenyedia;?>/<?= $link_prev; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                        <?
                                            }

                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                if ($page == $i) {
                                                    $link_active = "";
                                                    $link_color = "class='page-item disabled'";
                                                } else {
                                                    $link_active = base_url() . "pelanggan/index/$kdpenyedia/$i/$limit/$getkategori/$getcari";
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
                                        <li class="page-item"><a href="<?= base_url();?>pelanggan/index/<?= $kdpenyedia;?>/<?= $link_next; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url();?>pelanggan/index/<?= $kdpenyedia;?>/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
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