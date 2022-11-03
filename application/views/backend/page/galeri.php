<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Galeri & Berita
            <small>Daftar Galeri Berita (<?= $judul;?>)</small>
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
                            <a href="<?= base_url();?>galeriberita" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-7">
                                <form id="frm_galeri" name="frm_galeri" method="post" action="<?= base_url(); ?>galeriberita/prosesgaleri/1" onsubmit="showloading()">
                                    <div class="input-group">
                                        <span class="input-group-btn span-lihat sr-only">
                                            <a href="#" target="_blank" class="btn btn-success btn-flat btn-lihat">Lihat</a>
                                        </span>
                                        <input type="text" class="form-control" name="berkas" id="berkas" value="" required readonly>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat btn-pilih" onclick="upload_berkas()">Pilih Foto/Gambar (maks. 6 Mb)</button>
                                            <a href="#" class="btn btn-danger btn-flat btn-batal sr-only">Batal Berkas</a>
                                            <button type="submit" class="btn btn-primary btn-flat btn-simpan" disabled><i class="fa fa-save"></i> Simpan</button>
                                        </span>
                                    </div>
                                    <input type="hidden" id="kdberita" name="kdberita" value="<?= $kdberita; ?>">
                                    <input type="text" class="sr-only" id="kontrol" value="galeri" />
                                    <input type="text" class="sr-only" id="nama-file" value="<?= date('dmYhis');?>" />
                                    <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.bmp" />
                                </form>
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-12">
                                <div class="row">
                                    <?
                                    $hasil = json_decode($galeri);
                                    foreach ($hasil as $h) {
                                    ?>
                                    <div class="col-xs-4">
                                        <a href="<?= base_url(); ?>galeriberita/prosesgaleri/3/<?= $h->kdberita; ?>/<?= $h->kdgaleri; ?>/<?= $h->gambar; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus gambar tersebut ?')"><i class="fa fa-trash"></i></a>
                                        <?if($h->status == 0){?>
                                            <a href="<?= base_url(); ?>galeriberita/prosesgaleri/2/<?= $h->kdberita; ?>/<?= $h->kdgaleri; ?>" class="btn btn-warning btn-xs"><i class="fa fa-minus-square-o"></i> Pilih Foto/Gambar utama</a>
                                        <?}else{?>
                                            <a href="#" class="btn btn-success btn-xs" onclick="alert('telah diatur sebagai foto/gambar utama')"><i class="fa fa-check-square-o"></i> Foto/Gambar Utama</a>
                                        <?}?>
                                        <img class="img-responsive center-block" src="<?= $h->file_berkas; ?>" style="width:100%;">
                                    </div>
                                    <?}?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <? if ($jumlah_page > 0) { ?>
                            <ul class="pagination pull-right">
                                <? if ($page == 1) { ?>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                                <? } else {
                                        $link_prev = ($page > 1) ? $page - 1 : 1; ?>
                                <li class="page-item"><a href="<?= base_url();?>galeriberita/galeri/<?= $kdberita; ?>/1/<?= $limit;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>galeriberita/galeri/<?= $kdberita; ?>/<?= $link_prev; ?>/<?= $limit;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                                <?
                                    }

                                    for ($i = $start_number; $i <= $end_number; $i++) {
                                        if ($page == $i) {
                                            $link_active = "";
                                            $link_color = "class='page-item disabled'";
                                        } else {
                                            $link_active = base_url() . "galeriberita/galeri/$kdberita/$i/$limit";
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
                                <li class="page-item"><a href="<?= base_url();?>galeriberita/galeri/<?= $kdberita; ?>/<?= $link_next; ?>/<?= $limit;?>" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                                <li class="page-item"><a href="<?= base_url();?>galeriberita/galeri/<?= $kdberita; ?>/<?= $jumlah_page; ?>/<?= $limit;?>" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
                                <? } ?>
                            </ul>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>