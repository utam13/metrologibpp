<div class="content-wrapper">
    <section class="content-header">
        <h1>
            SOP
            <small>Formulir</small>
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

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Formulir SOP
                        </h3>
                    </div>
                    <form id="frm_sop" name="frm_sop" method="post" action="<?= base_url(); ?>sop/proses/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="proses" name="proses" value="<?= $proses; ?>">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdsop; ?>">
                        <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Nama SOP</label>
                                        <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" maxlength=250 autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Berkas PDF (maks. 3 Mb)</label>
                                        <div class="input-group">
                                            <span class="input-group-btn span-lihat <?= $berkas != "" ? "": "sr-only";?>">
                                                <a href="<?= $berkas != "" ? $file_berkas : "#";?>" target="_blank" class="btn btn-success btn-flat btn-lihat">Lihat</a>
                                            </span>
                                            <input type="text" class="form-control" name="berkas" id="berkas" value="<?= $berkas != "" ? $berkas : "#";?>" required readonly>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-info btn-flat btn-pilih" onclick="upload_berkas()">Pilih Berkas</button>
                                                <a href="#" class="btn btn-danger btn-flat btn-batal sr-only">Batal Berkas</a>
                                            </span>
                                        </div>
                                        <input type="text" class="sr-only" id="kontrol" value="sop" />
                                        <input type="text" class="sr-only" id="nama-file" value="<?= date('dmYhis');?>" />
                                        <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.pdf" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>sop" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

