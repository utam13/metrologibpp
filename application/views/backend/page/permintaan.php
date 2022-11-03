<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pengajuan Tera/Tera Ulang
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
                        <!-- <h3 class="box-title">
                            <a href="<?= base_url();?>permintaan/formulir/1" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Pengajuan Baru</a>
                        </h3> -->

                        <div style="float:right">
                            <form class="form-inline" method="post" action="<?= base_url(); ?>permintaan" method="post" style="float:right;" onsubmit="showloading()">
                                <div class="form-group">
                                    <label>Pencarian dengan:</label>
                                    <select class="form-control input-sm" id="kategori" name="kategori">
                                        <option value="e.npwp">NPWP</option>
                                        <option value="e.nama">Nama Usaha</option>
                                        <option value="b.nama">Jenis Layanan</option>
                                        <option value="d.nama">Jenis UTTP</option>
                                        <option value="b.nama">Jenis Layanan</option>
                                        <option value="a.kdpegawai">Penera</option>
                                        <option value="a.nosuratskrd">No. Surat SKRD</option>
                                        <option value="a.nosuratskhp">No. Surat SKHP</option>
                                        <option value="a.tglpengajuan">Tgl. Pengajuan</option>
                                        <option value="a.status">Status Pengajuan</option>
                                        <option value="expired">SKHP Expired</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" id="cari" name="cari" required autocomplete="off" value="" />
                                    <select class="form-control input-sm sr-only" id="statuscari" name="statuscari">
                                        <option value="0">Pengajuan Baru</option>
                                        <option value="1">Pengajuan Diterima</option>
                                        <option value="2">Pengajuan Terjadwal</option>
                                        <option value="3">Pengajuan Terbayar</option>
                                        <option value="4">Pengajuan Diproses</option>
                                        <option value="5">Pengajuan Selesai</option>
                                    </select>
                                    <select class="form-control input-sm sr-only" id="peneracari" name="peneracari">
                                        <option value="">Pilih Penera</option>
                                        <?foreach ($penera as $p) {
                                            echo "<option value='".$p->kdpegawai."'>".$p->nip." - ".$p->nama."</option>";
                                        }?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                                    <a href="<?= base_url(); ?>permintaan" class="btn bg-purple btn-sm" onclick="showloading()">Segarkan</a>
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
                                    <a href="<?= base_url(); ?>excel/index/pengajuan/<?= $getkategori;?>/<?= $getcari;?>" target="prosesdata" class="btn bg-green btn-sm">Download Excel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12"><code>Baris berwarna merah maroon menandakan menandakan SKHP terakhir yang diajukan telah ekspired oleh pemilik atau penyedia UTTP terkait telah expired</code></div>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped" id="mytable">
                                    <thead class="bg-light-blue">
                                        <tr>
                                            <th scope="col" rowspan=3 nowrap class="text-center">No</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Status</th>
                                            <th scope="col" rowspan=2 nowrap colspan=2 class="text-center">Serah Terima</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Tgl. Pengajuan</th>
                                            <th scope="col" rowspan=2 nowrap colspan=2 class="text-center">Peserta</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Jenis UTTP</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Jenis Layanan</th>
                                            <th scope="col" rowspan=2 nowrap colspan=4 class="text-center">SKHP Lama</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Lokasi Layanan</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Jadwal</th>
                                            <th scope="col" rowspan=3 nowrap class="text-center">Penera</th>
                                            <th scope="col" rowspan=2 nowrap colspan=2 class="text-center">Pembayaran Restribusi</th>
                                            <th scope="col" rowspan=2 nowrap colspan=2 class="text-center">Hasil Uji</th>
                                            <th scope="col" colspan=5 nowrap class="text-center">Dokumen</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" colspan=2 nowrap class="text-center">SKRD</th>
                                            <th scope="col" colspan=3 nowrap class="text-center">SKHP</th>
                                        </tr>
                                        <tr>
                                            <th scope="col" nowrap class="text-center">Alat</th>
                                            <th scope="col" nowrap class="text-center">Dokumen<br>SKRD & SKHP</th>
                                            <th scope="col" nowrap class="text-center">NPWP</th>
                                            <th scope="col" nowrap class="text-center">Nama</th>
                                            <th scope="col" nowrap class="text-center">No. SKHP</th>
                                            <th scope="col" nowrap class="text-center">Tgl. SKHP</th>
                                            <th scope="col" nowrap class="text-center">Berlaku Sampai</th>
                                            <th scope="col" nowrap class="text-center">Lokasi</th>
                                            <th scope="col" nowrap class="text-center">Nomor</th>
                                            <th scope="col" nowrap class="text-center">Tanggal</th>
                                            <th scope="col" nowrap class="text-center">Hasil</th>
                                            <th scope="col" nowrap class="text-center">Cerapan/Keterangan</th>
                                            <th scope="col" nowrap class="text-center">Nomor</th>
                                            <th scope="col" nowrap class="text-center">Tanggal</th>
                                            <th scope="col" nowrap class="text-center">Nomor</th>
                                            <th scope="col" nowrap class="text-center">Tanggal</th>
                                            <th scope="col" nowrap class="text-center">Berlaku sampai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $hasil = json_decode($permintaan);
                                        foreach ($hasil as $h) {
                                        ?>
                                            <tr class="<?= $h->warnabaris;?>">
                                                <td class="text-center"><?= $h->no;?></td>
                                                <td nowrap>
                                                    <?if($h->alasanbatal == ''){?>
                                                        <a href="<?= base_url()."permintaan/formulir/$h->kduttppeserta/2/$h->kdpengajuan/$h->status";?>" class="btn <?= $h->warnabtn;?> btn-xs"><?= $h->namastatus;?></a>
                                                    <?}else{?>
                                                        <a href="<?= base_url()."permintaan/formulir/$h->kduttppeserta/4/$h->kdpengajuan/$h->status";?>" class="btn <?= $h->warnabtn;?> btn-xs"><?= $h->namastatus;?></a>
                                                    <?}?>

                                                    <?if($h->status < 2){?>
                                                        <a href="<?= base_url()."permintaan/formulir/$h->kduttppeserta/4/$h->kdpengajuan/$h->status";?>" class="btn btn-danger btn-xs" onclick="return confirm('Membatalkan pengajuan tera/tera ulang\n<?= $h->namauttp.' oleh '.$h->namapeserta;?>\nSeluruh data yang berkaitan dengn pengajuan tersebut akan dihapus, Lanjutkan ?')">Batal Pengajuan</a>
                                                    <?}?>
                                                    <!-- <a href="<?= $h->file_fotokondisi;?>" target="_blank" class="btn btn-info btn-xs">Foto Kondisi</a> -->
                                                </td>
                                                <td class="text-center" nowrap>
                                                    <?if($h->serahterimaalat != "-"){?>
                                                    <a href="<?= base_url();?>permintaan/cetakterima/<?= $h->kdpengajuan;?>" target="prosesdata" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>
                                                    <?}?>
                                                    <?= $h->serahterimaalat;?>
                                                </td>
                                                <td class="text-center" nowrap>
                                                    <?= $h->serahterimadok;?>
                                                </td>
                                                <td class="text-center" nowrap><?= $h->tglpengajuan;?></td>
                                                <td class="text-center" nowrap><?= $h->npwp;?></td>
                                                <td nowrap><?= $h->namapeserta;?></td>
                                                <td nowrap><?= $h->namauttp;?></td>
                                                <td class="text-center" nowrap><?= $h->nama;?></td>
                                                <td nowrap><?= $h->noskhplama;?></td>
                                                <td class="text-center" nowrap><?= $h->tglskhplama;?></td>
                                                <td class="text-center" nowrap><?= $h->berlakuskhplama;?></td>
                                                <td nowrap><?= $h->lokasisebelumnya;?></td>
                                                <td class="text-center" nowrap><?= $h->namalokasi;?></td>
                                                <td class="text-center" nowrap><?= $h->jadwal;?></td>
                                                <td nowrap><?= $h->namapenera;?></td>
                                                <td nowrap><?= $h->nobukti == "-" ? "-":"<a href='$h->file_buktibayar' target='_blank' class='btn btn-primary btn-xs'>$h->nobukti</a>";?></td>
                                                <td class="text-center" nowrap><?= $h->tglbayar;?></td>
                                                <td nowrap class="text-bold <?= $h->warnahasil;?> hasil"><?= $h->namahasil;?></td>
                                                <td nowrap><?= $h->infohasil;?></td>
                                                <td nowrap><?= $h->nosuratskrd;?></td>
                                                <td class="text-center" nowrap><?= $h->tglsuratskrd;?></td>
                                                <td nowrap><?= $h->nosuratskhp;?></td>
                                                <td class="text-center" nowrap><?= $h->tglsuratskhp;?></td>
                                                <td class="text-center" nowrap><?= $h->berlakuskhp;?></td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12"><code>Baris berwarna merah maroon menandakan menandakan SKHP terakhir yang diajukan telah ekspired oleh pemilik atau penyedia UTTP terkait telah expired</code></div>
                            <div class="col-sm-12">
                            <? if ($jumlah_page > 0) { ?>
                                <ul class="pagination pull-right">
                                    <? if ($page == 1) { ?>
                                    <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                                    <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                                    <? } else {
                                            $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                    <li class="page-item"><a href="<?= base_url();?>permintaan/index/1/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                    <li class="page-item"><a href="<?= base_url();?>permintaan/index/<?= $link_prev; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                    <?
                                        }

                                        for ($i = $start_number; $i <= $end_number; $i++) {
                                            if ($page == $i) {
                                                $link_active = "";
                                                $link_color = "class='page-item disabled'";
                                            } else {
                                                $link_active = base_url() . "permintaan/index/$i/$limit/$getkategori/$getcari";
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
                                    <li class="page-item"><a href="<?= base_url();?>permintaan/index/<?= $link_next; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                    <li class="page-item"><a href="<?= base_url();?>permintaan/index/<?= $jumlah_page; ?>/<?= $limit;?>/<?= $getkategori;?>/<?= $getcari;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
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