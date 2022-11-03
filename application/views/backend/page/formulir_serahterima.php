<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pengajuan Tera/Tera Ulang
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
                            Formulir Serah Terima Alat
                        </h3>
                    </div>
                    <form id="frm_uttp" name="frm_uttp" method="post" action="<?= base_url(); ?>permintaan/prosesserahterima/<?= $proses;?>" onsubmit="showloading()">
                        <input type="text" class="sr-only" id="kdpengajuan" name="kdpengajuan" value="<?= $kdpengajuan;?>" />
                        <input type="text" class="sr-only" id="kelompok" name="kelompok" value="<?= $kelompok;?>" />
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <fieldset>
                                                <legend>Informasi UTTP</legend>
                                                <dl class="col-md-12 dl-horizontal dl-usaha">
                                                    <dt>Jenis UTTP</dt><dd><?= $namauttp;?></dd>
                                                    <dt>Merk/Type</dt><dd><?= $merktype;?></dd>
                                                    <dt>Kapasitas</dt><dd><?= $kapasitas;?></dd>
                                                    <dt>No. Seri</dt><dd><?= $noseri;?></dd>
                                                    <dt>Jumlah</dt><dd><?= $jml;?> unit</dd>
                                                    <?if($nama!=""){?>
                                                    <dt>Jenis Layanan</dt><dd><?= $nama;?></dd>
                                                    <?}?>

                                                    <dt>Jadwal</dt><dd><?= $jadwal;?></dd>
                                                    <dt>Penera</dt><dd><?= $namapenera;?></dd>
                                                    <dt>Lokasi Pelayanan</dt><dd><?= $namalokasi;?></dd>

                                                    <?if($kelompok == 2){?>
                                                    <dt>Hasil Layanan</dt><dd class="text-bold <?= $warnahasil;?>"><?= $namahasiluji;?></dd>
                                                    <dt>Dokumen Cerapan</dt><dd><?= $cerapan == '' ? '-': '<a href="'.$file_cerapan.'" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a>';?></dd>
                                                    <dt>Keterangan</dt><dd><?= $keterangan == '' ? '-':$keterangan;?></dd>
                                                    <dt>Dokumen SKRD</dt><dd><?= $nosuratskrd." (".date('d-m-Y',strtotime($tglsuratskrd)).")";?></dd>
                                                    <dt>Dokumen SKHP</dt><dd><?= $nosuratskhp." (".date('d-m-Y',strtotime($tglsuratskhp)).")";?></dd>
                                                    <?}?>

                                                    <?if($kelompok == 1 && $proses == 2){?>
                                                        <?if($this->session->userdata('level') == "Admin Aplikasi" || $this->session->userdata('level') == "Administrator" ){?>
                                                            <dt style="padding-top:12px;">Tgl. Penerimaan</dt>
                                                            <dd>
                                                                <input type="date" name="tglterima" id="tglterima" class="form-control" value="<?= $tglterima2;?>" style="width:40%;" >
                                                                <?}else{echo $tglterima;}?>
                                                            </dd>
                                                        <dt style="padding-top:12px;">Penerima</dt>
                                                        <dd>
                                                            <?if($this->session->userdata('level') == "Admin Aplikasi" || $this->session->userdata('level') == "Administrator" ){?>
                                                            <select class="form-control" id="pegawaiterima" name="pegawaiterima" >
                                                                <option value="">Pilih Pegawai</option>
                                                                <?foreach ($pegawai as $p) {
                                                                    $pilih = $pegawaiterima == $p->kdpegawai ? "selected":"";
                                                                    echo "<option value='".$p->kdpegawai."' $pilih>".$p->nip." - ".$p->nama."</option>";
                                                                }?>
                                                            </select>
                                                        </dd>
                                                        <?}else{?>
                                                            <dt>Tgl. Penerimaan</dt><dd><?= $tglterima;?></dd>
                                                            <dt>Penerima</dt><dd><?= $penerima;?></dd>
                                                        <?}?>
                                                    <dt>Keterangan</dt><dd><?= $keterangan;?></dd>
                                                    <?}?>
                                                </dl>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <fieldset>
                                        <legend>Foto Alat</legend>
                                        <div class="text-center">
                                            <a href="<?= $file_foto;?>" target="_blank" class="img-responsive center-block">
                                                <img src="<?= $file_foto;?>" alt="gambar" style="width:70%;">
                                            </a>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-12">&nbsp;</div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <legend><?= $judulform;?></legend>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="date" name="tgl" id="tgl" class="form-control" value="<?= $proses == 1 ? date('Y-m-d'):$tgl;?>" required>
                                            </div>
                                        </div>
                                        
                                        <?if($proses == 1 || ($proses == 2 && $kelompok == 2)){?>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Pegawai <?= $kelompok == 1 ? "Penerima Alat":"yang Menyerahkan";?></label>
                                                    <select class="form-control" id="pegawaiterima" name="pegawaiterima" reqired >
                                                        <option value="">Pilih Pegawai</option>
                                                        <?foreach ($pegawai as $p) {
                                                            $pilih = $pegawaiterima == $p->kdpegawai ? "selected":"";
                                                            echo "<option value='".$p->kdpegawai."' $pilih>".$p->nip." - ".$p->nama."</option>";
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?}?>

                                        <?if($proses == 2 || ($proses == 2 && $kelompok == 2)){?>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>No. KTP Penerima</label>
                                                        <input type="text" name="nikterima" id="nikterima" class="form-control" value="<?= $proses == 1 ? "":$nikterima;?>" maxlength=150 required>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Nama Penerima</label>
                                                        <input type="text" name="namaterima" id="namaterima" class="form-control" value="<?= $proses == 1 ? "":$namapenerima;?>" maxlength=150 required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?}?>

                                        <?if($kelompok == 1 && $proses == 1){?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Keterangan</label>
                                                <textarea class="form-control textarea" name="keterangan" id="keterangan" rows="2" maxlength=250  style="resize:none;" ></textarea>
                                            </div>
                                        </div>
                                        <?}?>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>permintaan" class="btn btn-danger">Batal</a>
                            <?if($this->session->userdata('level') != "Penera"){?>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan">Proses</button>
                            <?}?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

