<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pegawai
            <small>Struktur Kepegawaian</small>
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
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <a href="<?= base_url();?>pegawai" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body text-center">
                        <code>klik untuk mengubah gambar struktur kepegawaian, maksimal 6 Mb</code>
                        <img id="berkas" class="img-responsive center-block" src="<?= $file_berkas; ?>" alt="berkas" onclick="upload_berkas()" style="cursor:pointer;width:40%;">
                        <br>
                        <input type="text" class="sr-only" id="kontrol" value="struktur" />
                        <input type="text" class="sr-only" id="nama-file" value="struktur" />
                        <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.bmp" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>