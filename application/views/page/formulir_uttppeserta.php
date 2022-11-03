<div class="area-padding bg-white">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2 class="judul-page"><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
		<div class="row">
            <div  class="formulir-uttp">
                <!-- single-well end-->
                <div class="col-md-12">
                    <div class="well-middle">
                        <div class="single-well">
                            <div class="box box-khusus box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        Formulir UTTP Peserta
                                    </h3>
                                </div>
                                <form class="form-horizontal" id="frm_uttp" name="frm_uttp" method="post" action="<?= base_url(); ?>pelayanan/prosesuttp/<?= $kdpeserta;?>/<?= $mode;?>/<?= $proses;?>" onsubmit="showloading()">
                                    <input type="text" class="sr-only" id="kode" name="kode" value="<?= $kduttppeserta;?>" />
                                    <input type="text" class="sr-only" id="kontrol" value="" />
                                    <input type="text" class="sr-only" id="namafile" name="namafile" value="<?= $foto;?>" />
                                    <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,,.png,.gif,.bmp" />
                                    <input type="text" class="sr-only" id="jmlpengajuan" name="jmlpengajuan" value="<?= $jmlpengajuan;?>" />
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6">
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
                                                                    $kunci = $jmlpengajuan == 0 ? "":"disabled";
                                                                    echo "<option value='".$u->kduttp."' $pilih $kunci >".$u->nama."</option>";
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
                                                            <input type="text" class="form-control" name="kapasitas" id="kapasitas" value="<?= $kapasitas;?>" maxlength=50 autocomplete="off" required <?= $jmlpengajuan == 0 ? "":"readonly";?> />
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">No. Seri</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="noseri" id="noseri" value="<?= $noseri;?>" maxlength=50 autocomplete="off" required <?= $jmlpengajuan == 0 ? "":"readonly";?>/>
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
                                            <div class="col-md-6">
                                                <fieldset>
                                                    <legend>Foto UTTP</legend>
                                                    <div class="col-md-12 text-center">
                                                        <img id="foto" class="img-responsive center-block" src="<?= $file_foto; ?>" alt="Foto UTTP" onclick="<?= $jmlpengajuan == 0 ? "upload_berkas('uttppeserta')":"alert('Sudah ada data pengajuan yang terkait')";?>" style="cursor:pointer;width:40%;">
                                                        <div class="btn-area  <?= $proses == "2" ? "": "sr-only";?>">
                                                            <a href="<?= $proses == "2" ? $file_foto : "#";?>" target="_blank" class="btn btn-success btn-lihat btn-sm">Lihat</a>
                                                            <?if($jmlpengajuan == 0){?>
                                                            <button type="button" class="btn btn-danger btn-batal btn-sm" onclick="batal_berkas('uttppeserta')">Batal</button>
                                                            <?}?>
                                                        </div>
                                                        <code>klik untuk mengupload maksimal 2 Mb</code>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a href="<?= base_url();?>pelayanan/uttp/<?= $kdpeserta;?>/<?= $mode;?>" class="btn btn-danger">Batal</a>
                                        <button type="submit" class="btn bg-khusus pull-right btn-simpan">Simpan</button>
                                    </div>
                                </form>
                                <div class="overlay sr-only">
                                    <i class="fa fa-refresh fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<!-- End Blog Area -->