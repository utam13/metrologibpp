<div class="content-wrapper">
    <section class="content-header">
        <h1>
            UTTP Wajib Tera
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
                            Formulir UTTP
                        </h3>
                    </div>
                    <form id="frm_sop" name="frm_sop" method="post" action="<?= base_url(); ?>uttp/proses/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kduttp; ?>">
                        <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group text-center">
                                        <label>Gambar Alat (maks. 100 Kb)</label>
                                        <img id="gambar" class="img-responsive center-block" src="<?= $file_berkas; ?>" alt="berkas" onclick="upload_berkas()" style="cursor:pointer;width:80%;">
                                        <input type="text" class="sr-only" id="kontrol" value="uttp" />
                                        <input type="text" class="sr-only" name="berkas" id="nama-file" value="<?= $berkas;?>" />
                                        <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.bmp" />
                                        <code>klik untuk mengupload</code>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Nama Alat UTTP</label>
                                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" maxlength=150 autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Masa berlaku</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="berlaku" id="berlaku" value="<?= $berlaku; ?>" max=99 autocomplete="off" />
                                                    <span class="input-group-addon">bulan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Layanan Aktif</label>
                                                <select class="form-control " id="kdlayanan" name="kdlayanan" >
                                                    <option value="0">Semua Layanan</option>
                                                    <?
                                                    foreach ($layanan as $l) {
                                                        $pilih = $kdlayanan == $l->kdlayanan ? "selected":"";
                                                        echo "<option value='".$l->kdlayanan."' $pilih>".$l->nama."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Jml unit per-penera/hari</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="batas" id="batas" value="<?= $batas; ?>" min=1 max=999 autocomplete="off" required />
                                                    <span class="input-group-addon">unit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Lama pengerjaan per-unit</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="lama" id="lama" value="<?= $lama; ?>" min=1 max=999 autocomplete="off" required />
                                                    <span class="input-group-addon">menit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?= $keterangan; ?>" maxlength=250 autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>uttp" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

