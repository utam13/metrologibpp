<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Peserta Tera/Tera Ulang
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
                            <a href="<?= base_url();?>peserta/formulir/1" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Peserta</a>
                        </h3>

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>peserta" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian dengan:</label>
                                    <select class="form-control input-sm" id="kategori" name="kategori">
                                        <option value="npwp">NPWP</option>
                                        <option value="nama">Nama Usaha</option>
                                        <option value="nik">No. KTP PIC</option>
                                        <option value="namapic">Nama PIC</option>
                                        <option value="tgldaftar">Tgl Daftar</option>
                                        <option value="status">Status Registrasi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" id="cari" name="cari" required autocomplete="off" value="" />
                                    <select class="form-control input-sm sr-only" id="statuscari" name="statuscari">
                                        <option value="0">Registrasi Baru</option>
                                        <option value="1">Registrasi Diterima</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>peserta" class="btn bg-purple btn-sm" onclick="showloading()">Refresh</a>
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
                                    <a href="<?= base_url(); ?>excel/index/peserta/<?= $getkategori;?>/<?= $getcari;?>" target="prosesdata" class="btn bg-green btn-sm">Download Excel</a>
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
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Status</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml UTTP</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml Pelanggan</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Jml SKHP Expired</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Kelompok</th>
                                            <th scope="col" rowspan=2 nowrap class="text-center" style="width:10%;">Tgl. Daftar</th>
                                            <th scope="col" colspan=7 nowrap class="text-center">Informasi Usaha</th>
                                            <th scope="col" colspan=6 nowrap class="text-center">Informasi PIC</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" nowrap class="text-center">NPWP</th>
                                            <th scope="col" nowrap class="text-center">Nama Usaha</th>
                                            <th scope="col" nowrap class="text-center">Alamat</th>
                                            <th scope="col" nowrap class="text-center">Kelurahan</th>
                                            <th scope="col" nowrap class="text-center">Kecamatan</th>
                                            <th scope="col" nowrap class="text-center">Telp</th>
                                            <th scope="col" nowrap class="text-center">Email</th>
                                            <th scope="col" nowrap class="text-center">No. KTP</th>
                                            <th scope="col" nowrap class="text-center">Nama</th>
                                            <th scope="col" nowrap class="text-center">Jabatan</th>
                                            <th scope="col" nowrap class="text-center">Telp</th>
                                            <th scope="col" nowrap class="text-center">WhatsApp</th>
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
                                            <td scope="col" nowrap class="text-center">
                                                <?if($d->status == 1){?>
                                                <a href="<?= base_url();?>peserta/formulir/2/<?= $d->kdpeserta; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <?}?>
                                                <a href="<?= base_url();?>peserta/proses/3/<?= $d->kdpeserta;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus peserta berikut:\n<?= $d->npwp;?>\n<?= $d->nama;?>\nLanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td scope="col"><?= $d->namastatus;?></td>
                                            <td scope="col" class="text-center"><?= $d->jmluttp;?></td>
                                            <td scope="col" class="text-center"><?= $d->jmlpelanggan;?></td>
                                            <td scope="col" class="text-center"><?= $d->totalexpired;?></td>
                                            <td scope="col" class="text-center"><?= $d->namakelompok;?></td>
                                            <td scope="col" nowrap class="text-center"><?= $d->tgldaftar;?></td>
                                            <td scope="col" nowrap><?= $d->npwp;?></td>
                                            <td scope="col" nowrap><?= $d->nama;?></td>
                                            <td scope="col" nowrap><?= $d->alamat;?></td>
                                            <td scope="col" nowrap><?= $d->kelurahan;?></td>
                                            <td scope="col" nowrap><?= $d->kecamatan;?></td>
                                            <td scope="col" nowrap><?= $d->telp;?></td>
                                            <td scope="col" nowrap><?= $d->email;?></td>
                                            <td scope="col" nowrap><?= $d->nik;?></td>
                                            <td scope="col" nowrap><?= $d->namapic;?></td>
                                            <td scope="col" nowrap><?= $d->jabatan;?></td>
                                            <td scope="col" nowrap><?= $d->telppic;?></td>
                                            <td scope="col" nowrap><?= $d->wa;?></td>
                                            <td scope="col" nowrap><?= $d->emailpic;?></td>
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
                                        <li class="page-item"><a href="<?= base_url();?>peserta/index/1/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url();?>peserta/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                        <?
                                            }

                                            for ($i = $start_number; $i <= $end_number; $i++) {
                                                if ($page == $i) {
                                                    $link_active = "";
                                                    $link_color = "class='page-item disabled'";
                                                } else {
                                                    $link_active = base_url() . "peserta/index/$i/$limit/$getkategori/$getcari";
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
                                        <li class="page-item"><a href="<?= base_url();?>peserta/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                        <li class="page-item"><a href="<?= base_url();?>peserta/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
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