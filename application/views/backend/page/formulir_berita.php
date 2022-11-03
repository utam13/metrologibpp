<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Galeri & Berita
            <small>Formulir Berita</small>
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
                            Formulir Berita
                        </h3>
                    </div>
                    <form id="frm_sop" name="frm_sop" method="post" action="<?= base_url(); ?>galeriberita/proses/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdberita; ?>">
                        <input type="hidden" id="judul_awal" name="judul_awal" value="<?= $judul; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tgl" id="tgl" value="<?= $tgl; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam" id="jam" value="<?= $jam; ?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" name="judul" id="judul" value="<?= $judul; ?>" maxlength=250 autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Isi Berita</label>
                                        <textarea class="form-control ckeditor" name="isi" id="isi" rows="4" required /><?= $isi; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Link Instagram <code>(jika ada)</code></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-instagram"></i></span>
                                            <input type="text" class="form-control" name="ig" id="ig" value="<?= $ig; ?>" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Link Facebook <code>(jika ada)</code></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-facebook"></i></span>
                                            <input type="text" class="form-control" name="fb" id="fb" value="<?= $fb; ?>" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Link Youtube <code>(jika ada)</code></label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-youtube"></i></span>
                                            <input type="text" class="form-control" name="youtube" id="youtube" value="<?= $youtube; ?>" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>galeriberita" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

