<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Regulasi
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
                            Formulir Regulasi
                        </h3>
                    </div>
                    <form id="frm_regulasi" name="frm_regulasi" method="post" action="<?= base_url(); ?>regulasi/proses/<?= $proses;?>" onsubmit="showloading()" >
                        <input type="hidden" id="proses" name="proses" value="<?= $proses; ?>">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdregulasi; ?>">
                        <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Jenis</label>
                                        <select class="form-control" name="jenis" id="jenis" required />
                                            <option value="">Pilih</option>
                                            <option value="Perwali" <?= $jenis=="Perwali" ? "selected":"";?> >Perwali</option>
                                            <option value="Permendag" <?= $jenis=="Permendag" ? "selected":"";?> >Permendag</option>
                                            <option value="Undang-undang" <?= $jenis=="Undang-undang" ? "selected":"";?> >Undang-undang</option>
                                            <option value="Lainnya" <?= $jenis=="Lainnya" ? "selected":"";?> >Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nomor</label>
                                        <input type="text" class="form-control" name="nomor" id="nomor" value="<?= $nomor; ?>" autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tahun</label>
                                        <input type="number" class="form-control" name="tahun" id="tahun" value="<?= $thn; ?>" max=<?= date('Y');?> autocomplete="off" required  />
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
                                        <input type="text" class="sr-only" id="kontrol" value="regulasi" />
                                        <input type="text" class="sr-only" id="nama-file" value="<?= date('dmYhis');?>" />
                                        <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.pdf" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nama Regulasi</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" maxlength=250 autocomplete="off" required />
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>regulasi" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

