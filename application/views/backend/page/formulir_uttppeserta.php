<div class="content-wrapper">
    <section class="content-header">
        <h1>
            UTTP Peserta Tera/Tera Ulang
            <small>Nama Peserta: <?= $namapeserta;?></small>
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
                            Formulir UTTP Peserta</small>
                        </h3>
                    </div>
                    <form class="form-horizontal" id="frm_uttp" name="frm_uttp" method="post" action="<?= base_url(); ?>uttppeserta/prosesuttp/<?= $proses;?>/<?= $mode;?>" onsubmit="showloading()">
                        <input type="text" class="sr-only" id="kode" name="kode" value="<?= $kduttppeserta;?>" />
                        <input type="text" class="sr-only" id="kdpeserta" name="kdpeserta" value="<?= $kdpeserta;?>" />
                        <input type="text" class="sr-only" id="kdpenyedia" name="kdpenyedia" value="<?= $kdpenyedia;?>" />
                        <input type="text" class="sr-only" id="kontrol" value="" />
                        <input type="text" class="sr-only" id="namafile" name="namafile" value="<?= $foto;?>" />
                        <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,,.png,.gif,.bmp" />
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <fieldset>
                                        <legend>Informasi UTTP</legend>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Jenis UTTP</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="uttp" name="uttp" required >
                                                    <option value="">Pilih</option>
                                                    <?
                                                    foreach ($listuttp as $u) {
                                                        $pilih = $kduttp == $u->kduttp ? "selected":"";
                                                        echo "<option value='".$u->kduttp."' $pilih >".$u->nama."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Merk & Type</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="merktype" id="merktype" value="<?= $merktype;?>" maxlength=100 autocomplete="off" required />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Kapasitas</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="kapasitas" id="kapasitas" value="<?= $kapasitas;?>" maxlength=50 autocomplete="off" required />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">No. Seri</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" name="noseri" id="noseri" value="<?= $noseri;?>" maxlength=50 autocomplete="off" required />
                                            </div>
                                        </div>

                                        <div class="tambahan">
                                            <?if($proses == 2){
                                                $hasil = json_decode($infotambahan);
                                                foreach ($hasil as $it) {
                                                    echo  $it->komponen;
                                                }
                                            }?>
                                        </div>
                                        
                                        <div class="form-group sr-only">
                                            <label class="col-sm-3 control-label">Jumlah</label>
                                            <div class="col-sm-3">
                                                <div class="input-group">
                                                    <input type="number" class="form-control block-specialchar" name="jml" id="jml" value="<?= $jml;?>" min=1 max=999 autocomplete="off" />
                                                    <span class="input-group-addon">unit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-5">
                                    <fieldset>
                                        <legend>Foto UTTP</legend>
                                        <div class="col-md-12 text-center">
                                            <img id="foto" class="img-responsive center-block" src="<?= $file_foto; ?>" alt="Foto UTTP" onclick="upload_berkas('uttppeserta')" style="cursor:pointer;width:40%;">
                                            <div class="btn-area  <?= $proses == "2" ? "": "sr-only";?>">
                                                <a href="<?= $proses == "2" ? $file_foto : "#";?>" target="_blank" class="btn btn-success btn-lihat btn-sm">Lihat</a>
                                                <button type="button" class="btn btn-danger btn-batal btn-sm" onclick="batal_berkas('uttppeserta')">Batal</button>
                                            </div>
                                            <code>klik untuk mengupload maksimal 100 Kb</code>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>uttppeserta/index/<?= $kdpeserta;?>/<?= $mode;?>" class="btn btn-danger"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

