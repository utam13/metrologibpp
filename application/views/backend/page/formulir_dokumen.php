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
            <div id="progress_div" class="col-lg-12" style="display:none;">
                <div class="progress progress-sm active">
                    <div id="progress_bar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Formulir Dokumen Persyaratan Tambahan
                        </h3>
                    </div>
                    <form id="frm_sop" name="frm_sop" method="post" action="<?= base_url(); ?>uttp/prosesdokumen/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kddoktambahan; ?>">
                        <input type="hidden" id="kduttp" name="kduttp" value="<?= $kduttp; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nama Dokumen</label>
                                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" maxlength=150 autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Berkas (contoh/blanko dokumen) <code>(jika tidak ada kosongkan)</code></label>
                                                <div class="input-group">
                                                    <span class="input-group-btn span-lihat <?= $berkas != "" ? "": "sr-only";?>">
                                                        <a href="<?= $berkas != "" ? $file_berkas : "#";?>" target="_blank" class="btn btn-success btn-flat3 btn-lihat">Lihat</a>
                                                    </span>
                                                    <input type="text" class="form-control block-input" name="berkas" id="berkas" value="<?= $berkas;?>" >
                                                    <input type="text" class="sr-only" id="kontrol" value="dokumen" />
                                                    <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".pdf" />
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat btn-pilih <?= $berkas != "" ? "sr-only": "";?>" onclick="upload_berkas()">Pilih</button>
                                                        <button type="button" class="btn btn-danger btn-flat btn-batal <?= $berkas != "" ? "": "sr-only";?>" onclick="batal_berkas('dokumen')">Batal Berkas</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>uttp/doktambahan/<?= $kduttp;?>" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

