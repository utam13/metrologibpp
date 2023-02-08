<div class="area-padding bg-white">
	<div class="container body">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="section-headline text-center">
					<h2 class="judul-page"><?= $halaman; ?></h2>
				</div>
            </div>
        </div>
		<div class="row center-content">
            <!-- single-well end-->
            <div class="col-md-9">
                <div class="well-middle">
                    <div class="single-well">
                        <div class="box box-khusus box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                    Formulir Pengajuan Tera/Tera Ulang (Tanggal: <?= date('d-m-Y',strtotime($tglpengajuan));?>)
                                </h3>
                            </div>
                            <form id="frm_uttp" name="frm_uttp" method="post" action="<?= base_url(); ?>pelayanan/prosespengajuan/<?= $kdpeserta;?>/<?= $mode;?>/<?= $proses;?>" onsubmit="showloading()">
                                <input type="text" class="sr-only" id="kode" name="kode" value="<?= $kdpengajuan;?>" />
                                <input type="text" class="sr-only" id="kdpenyedia" name="kdpenyedia" value="<?= $kdpenyedia;?>" />
                                <input type="text" class="sr-only" id="kduttppeserta" name="kduttppeserta" value="<?= $kduttppeserta;?>" />
                                <input type="text" class="sr-only" id="status" name="status" value="<?= $status;?>" />
                                <input type="text" class="sr-only" id="namalayanan" name="namalayanan" value="<?= $namalayanan;?>" />
                                <input type="text" class="sr-only" id="noskhp" name="noskhp" value="<?= $noskhp;?>" />
                                <input type="text" class="sr-only" id="kontrol" value="" />
                                <input type="file" class="sr-only" id="pilih-berkas" value="" accept=".jpg,.jpeg,.png,.gif,.bmp,.pdf" />
                                <input type="text" class="sr-only" id="tambahanke" value="" />
                                <input type="file" class="sr-only" id="pilih-tambahan" value="" accept=".jpg,.jpeg,.png,.gif,.bmp,.pdf" />
                                <input type="text" class="sr-only" id="hasilawal" name="hasilawal" value="<?= $hasiluji;?>" />
                                <input type="text" class="sr-only" id="jadwalawal" name="jadwalawal" value="<?= $jadwal2;?>" />
                                <input type="text" class="sr-only" id="pegawaiawal" name="pegawaiawal" value="<?= $kdpegawai;?>" />
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <fieldset>
                                                <legend>Informasi UTTP <?= $status > 0 ? "& Layanan":"";?></legend>
                                                <dl class="col-md-12 dl-horizontal dl-usaha">
                                                    <dt>Jenis UTTP</dt><dd><?= $namauttp;?></dd>
                                                    <dt>Merk/Type</dt><dd><?= $merktype;?></dd>
                                                    <dt>Kapasitas</dt><dd><?= $kapasitas;?></dd>
                                                    <dt>No. Seri</dt><dd><?= $noseri;?></dd>
                                                    <!-- <dt>Jumlah</dt><dd><?= $jml;?> unit</dd> -->
                                                    <?if($status >= 2){?>
                                                        <dt>Jenis Layanan</dt><dd><?= $nama;?></dd>
                                                    <?}?>
                                                    <dt>Status Pengajuan</dt><dd><a href="#" class="btn <?= $warnabtn;?> btn-xs"><?= $namastatus;?></a></dd>

                                                    <?if($status != 0){?>
                                                        <?if($adaskhplama == "1"){?>
                                                            <dt>No. SKHP Lama</dt><dd><?= $noskhplama;?></dd>
                                                            <dt>Tgl. SKHP Lama</dt><dd><?= $tglskhplama2;?></dd>
                                                            <dt>Berlaku Sampai</dt><dd><?= $berlakuskhplama2.' ' .$statusekspired;?></dd>
                                                            <dt>Lokasi Sebelumnya</dt><dd><?= $lokasisebelumnya;?></dd>
                                                        <?}?>
                                                        <dt><?= $namalabel;?></dt><dd><a href="<?= $file_izinskhplama;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                        <dt>Surat Permohonan</dt><dd><a href="<?= $file_suratpermohonan;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                            <?
                                                            $hasil = json_decode($berkastambahan);
                                                            foreach ($hasil as $bk) {
                                                            ?>
                                                            <dt><?= $bk->nama;?></dt><dd><a href="<?= $bk->file_berkasupload;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                            <?}?>
                                                    <?}?>

                                                    <?if($status != 0){?>
                                                    <dt><?= $namalabel;?></dt><dd><a href="<?= $file_izinskhplama;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                    <dt>Surat Permohonan</dt><dd><a href="<?= $file_suratpermohonan;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                        <?
                                                        $hasil = json_decode($berkastambahan);
                                                        foreach ($hasil as $bk) {
                                                        ?>
                                                        <dt><?= $bk->nama;?></dt><dd><a href="<?= $bk->file_berkasupload;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                        <?}?>
                                                    <?}?>

                                                    <?if($status >= 4){?>
                                                    <dt>Bukti Pembayaran<br>Retribusi</dt><dd><a href="<?= $file_buktibayar;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                    <?}?>

                                                    <?if($status >= 1){?>
                                                    <dt>Foto Kondisi Alat</dt><dd><a href="<?= $file_fotokondisi;?>" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a></dd>
                                                    <?}?>

                                                    <?if($status == 1 && $adapilihan != 0){?>
                                                    <dt style="padding-top:12px;">Jadwal</dt>
                                                        <dd>
                                                            <select class="form-control" id="tgltetapan" name="tgltetapan" required style="width:80%;" >
                                                                <option value="">Pilih</option>
                                                                <option value="<?= $tgl1;?>" <?= $status_tgl1;?> <?= $jadwal2 == $tgl1 ? "selected":"";?> ><?= date('d-m-Y',strtotime($tgl1)).$pegawai1;?></option>
                                                                <option value="<?= $tgl2;?>" <?= $status_tgl2;?> <?= $jadwal2 == $tgl2 ? "selected":"";?> ><?= date('d-m-Y',strtotime($tgl2)).$pegawai2;?></option>
                                                                <?if(($tgl3 != "-" && $tgl3 != "0000-00-00") || ($tgl4 != "-" && $tgl4 != "0000-00-00")){?>
                                                                    <?if($tgl3 != "-" && $tgl3 != "0000-00-00"){?>
                                                                        <option value="<?= $tgl3;?>" <?= $status_tgl3;?> <?= $jadwal2 == $tgl3 ? "selected":"";?> ><?= date('d-m-Y',strtotime($tgl3)).$pegawai3;?></option>
                                                                    <?}?>
                                                                    <?if($tgl4 != "-" && $tgl4 != "0000-00-00"){?>
                                                                    <option value="<?= $tgl4;?>" <?= $status_tgl4;?> <?= $jadwal2 == $tgl4 ? "selected":"";?> ><?= date('d-m-Y',strtotime($tgl4)).$pegawai4;?></option>
                                                                    <?}?>
                                                                <?}?>
                                                            </select>
                                                        </dd>
                                                    <?}elseif($status == 2 || ($status == 4 && $hasiluji != 0) || $status == 5){?>
                                                        <input type="date" class="sr-only" id="tgltetapan" name="tgltetapan" value="<?= $jadwal2;?>" />
                                                        <input type="text" class="sr-only" id="pegawaitetapan" name="pegawaitetapan" value="<?= $kdpegawai;?>" />
                                                        <dt>Jadwal</dt><dd><?= $jadwal;?></dd>
                                                        <dt>Penera</dt><dd><?= $namapenera;?></dd>
                                                    <?}?>

                                                    <?if($status >= 1){?>
                                                    <dt>Lokasi Pelayanan</dt><dd><?= $namalokasi;?></dd>
                                                    <?}?>

                                                    <?if($status == 5){?>
                                                    <dt>Hasil Layanan</dt><dd class="text-bold <?= $warnahasil;?>"><?= $namahasiluji;?></dd>
                                                    <dt>Dokumen Cerapan</dt><dd><?= $cerapan == '' ? '-': '<a href="'.$file_cerapan.'" target="_blank" class="btn btn-info btn-xs btn-lihat">Lihat</a>';?></dd>
                                                    <dt>Keterangan</dt><dd><?= $keterangan == '' ? '-':$keterangan;?></dd>
                                                    <dt>Dokumen SKRD</dt><dd><?= $skrd;?></dd>
                                                    <dt>Dokumen SKHP</dt><dd><?= $skhp;?></dd>
                                                    <?}?>
                                                </dl>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-5 text-center">
                                            <fieldset>
                                                <legend>Foto Alat</legend>
                                                <a href="<?= $file_foto;?>" target="_blank" class="img-responsive center-block">
                                                    <img src="<?= $file_foto;?>" alt="gambar" style="width:75%;">
                                                </a>
                                            </fieldset>
                                        </div>

                                        <?if($status == 0){?>
                                        <div class="col-md-12">&nbsp;</div>
                                        <div class="col-md-5">
                                            <fieldset>
                                                <legend>Jenis Layanan</legend>
                                                <div class="col-md-12">
                                                    <select class="form-control" id="layanan" name="layanan" required <?= $status != 0 ? "disabled='disabled'":"";?> >
                                                        <option value="">Pilih</option>
                                                        <?
                                                        $hasil = json_decode($listlayanan);
                                                        foreach ($hasil as $u) {
                                                            $pilih = $kdlayanan == $u->kdlayanan ? "selected": $u->pilihan;
                                                            echo "<option value='".$u->kdlayanan."' $pilih>".$u->nama."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-7">
                                            <fieldset>
                                                <legend>Foto Kondisi Alat</legend>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat <?= $fotokondisi != "" ? "":"sr-only";?>">
                                                            <a href="<?= $file_fotokondisi;?>" target="_blank" class="btn btn-success btn-flat btn-lihat">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas" id="berkas" value="<?= $fotokondisi;?>" placeholder="JPG/JPEG/BMP/GIF/PDF" required >
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary btn-flat btn-pilih <?= $fotokondisi != "" ? "sr-only":"";?>" onclick="upload_berkas('fotokondisi')">Pilih</button>
                                                            <?if($status == 0){?>
                                                            <button type="button" class="btn btn-danger btn-flat btn-batal <?= $fotokondisi != "" ? "":"sr-only";?>" onclick="batal_berkas('fotokondisi')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12 div-skhplama1 <?= $nama == 'Tera Ulang' || $noskhp != '' ? '':'sr-only';?>">&nbsp;</div>
                                            <div class="col-md-12 div-skhplama2 <?= $nama == 'Tera Ulang' || $noskhp != '' ? '':'sr-only';?>">
                                                <fieldset>
                                                    <legend>Data SKHP Lama</legend>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Dokumen</label>
                                                            <select class="form-control" id="dokumenskhplama" name="dokumenskhplama" <?= $nama== 'Tera Ulang' ? 'required':'';?> >
                                                                <option value="1" <?= $adaskhplama == "1" ? "selected":"";?> >Ada</option>
                                                                <option value="0" <?= $adaskhplama == "0" ? "selected":"";?> >Hilang</option>
                                                                <?if($noskhp != ''){?>
                                                                <option value="2" <?= $adaskhplama == "2" ? "selected":"";?> >Berbeda</option>
                                                                <?}?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>No. SKHP</label>
                                                            <input type="text" class="form-control" name="noskhplama" id="noskhplama" value="<?= $noskhp != '' ? $noskhp:$noskhplama;?>" maxlength=150 autocomplete="off" <?= $nama== 'Tera Ulang' || $noskhp != '' ? 'required':'';?> />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Tanggal</label>
                                                            <input type="date" class="form-control" name="tglskhplama" id="tglskhplama" value="<?= $noskhp != '' ? $tglterakhir:$tglskhplama;?>" autocomplete="off" <?= $nama== 'Tera Ulang' || $noskhp != '' ? 'required':'';?> />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Berlaku Sampai</label>
                                                            <input type="month" class="form-control" name="berlakuskhplama" id="berlakuskhplama" value="<?= $noskhp != '' ? $berlaku:$berlakuskhplama;?>" autocomplete="off" <?= $nama== 'Tera Ulang' || $noskhp != '' ? 'required':'';?> />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Lokasi UPTD Metrologi</label>
                                                            <input type="text" class="form-control" name="lokasisebelumnya" id="lokasisebelumnya" value="<?= $noskhp != '' ? $lokasipengurusan:$lokasisebelumnya;?>" maxlength=250 autocomplete="off" <?= $nama== 'Tera Ulang' || $noskhp != '' ? 'required':'';?> <?= $noskhp != '' ? 'readonly':'';?> />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                        <div class="col-md-12">&nbsp;</div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>
                                                    <span class="namaberkas"><?= $nama == "Tera Ulang" || $noskhp != '' ? "SKHP Lama":"Izin Persetujuan Tipe";?></span>
                                                </legend>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat3 <?= $izinskhplama != "" ? "":"sr-only";?>">
                                                            <a href="<?= $file_izinskhplama;?>" target="_blank" class="btn btn-success btn-flat btn-lihat3">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas_izinskhplama" id="berkas_izinskhplama" value="<?= $izinskhplama;?>" placeholder="JPG/JPEG/BMP/GIF/PDF" required >
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary btn-flat btn-pilih3 <?= $izinskhplama != "" ? "sr-only":"";?>" onclick="upload_berkas('izinskhplama')">Pilih</button>
                                                            <?if($status == 0){?>
                                                            <button type="button" class="btn btn-danger btn-flat btn-batal3 <?= $izinskhplama != "" ? "":"sr-only";?>" onclick="batal_berkas('izinskhplama')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <!-- <div class="col-md-12">&nbsp;</div> -->
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>Surat Permohonan</legend>
                                                <div class="col-md-12">
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat4 <?= $suratpermohonan != "" ? "":"sr-only";?>">
                                                            <a href="<?= $file_suratpermohonan;?>" target="_blank" class="btn btn-success btn-flat btn-lihat4">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas_suratpermohonan" id="berkas_suratpermohonan" value="<?= $suratpermohonan;?>" placeholder="JPG/JPEG/BMP/GIF/PDF" required >
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary btn-flat btn-pilih4 <?= $suratpermohonan != "" ? "sr-only":"";?>" onclick="upload_berkas('suratpermohonan')">Pilih</button>
                                                            <?if($status == 0){?>
                                                            <button type="button" class="btn btn-danger btn-flat btn-batal4 <?= $suratpermohonan != "" ? "":"sr-only";?>" onclick="batal_berkas('suratpermohonan')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <?if($adaberkastambahan > 0){?>
                                        <div class="col-md-12">&nbsp;</div>
                                        <div class="col-md-12">
                                            <fieldset>
                                                <legend>Dokumen Tambahan</legend>
                                                <?
                                                $hasil = json_decode($berkastambahan);
                                                foreach ($hasil as $bk) {
                                                ?>
                                                <div class="col-md-12">
                                                    <label><?= $bk->nama;?> <?= $bk->berkas != "" ? "<code><a href='$bk->file_berkas' target='_blank' class='text-red'>[Download Format $bk->nama]</a></code>":"";?></label>
                                                    <div class="input-group">
                                                        <span class="input-group-btn span-lihat_<?= $bk->nama_objek;?> <?= $bk->berkasupload != "" ? "":"sr-only";?>">
                                                            <a href="<?= $bk->file_berkasupload;?>" target="_blank" class="btn btn-success btn-flat btn-lihat_<?= $bk->nama_objek;?>">Lihat</a>
                                                        </span>
                                                        <input type="text" class="form-control block-input" name="berkas_tambahan[]" id="berkas_<?= $bk->nama_objek;?>" value="<?= $bk->berkasupload;?>" placeholder="JPG/JPEG/BMP/GIF/PDF" required >
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-primary btn-flat btn-pilih_<?= $bk->nama_objek;?> <?= $bk->berkasupload != "" ? "sr-only":"";?>" onclick="upload_tambahan('<?= $bk->nama_objek;?>')">Pilih</button>
                                                            <?if($status == 0){?>
                                                            <button type="button" class="btn btn-danger btn-flat btn-batal_<?= $bk->nama_objek;?> <?= $bk->berkasupload != "" ? "":"sr-only";?>" onclick="batal_berkas('<?= $bk->nama_objek;?>')">Batal Berkas</button>
                                                            <?}?>
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-12">&nbsp;</div>
                                                <?}?>
                                            </fieldset>
                                        </div>
                                        <?}?>
                                            
                                        <?}?>
                                        
                                        <?if((($status == 2 || $status == 3) && $this->session->userdata('level') != "Penera") || ($status == 5 && ($this->session->userdata('level') == "Admin Aplikasi" || $this->session->userdata('level') == "Administrator"))){?>
                                        <div class="col-md-12">&nbsp;</div>
                                        <div class="col-md-12">
                                            <fieldset>
                                                <legend>Pembayaran Restribusi</legend>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Nomor Bukti/Slip</label>
                                                        <input type="text" class="form-control" name="nobukti" id="nobukti" value="<?= $nobukti;?>" maxlength=50 autocomplete="off" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Tanggal</label>
                                                        <input type="date" class="form-control" name="tglbayar" id="tglbayar" value="<?= $tglbayar2;?>" max="<?= $tglsekarang;?>" autocomplete="off" required />
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Bukti Pembayaran</label>
                                                        <div class="input-group">
                                                            <span class="input-group-btn span-lihat2 <?= $buktibayar != "" ? "":"sr-only";?>">
                                                                <a href="<?= $file_buktibayar;?>" target="_blank" class="btn btn-success btn-flat btn-lihat2">Lihat</a>
                                                            </span>
                                                            <input type="text" class="form-control block-input" name="berkas2" id="berkas2" value="<?= $buktibayar;?>" placeholder="JPG/JPEG/BMP/GIF/PDF" required >
                                                            <span class="input-group-btn">
                                                                <button type="button" class="btn btn-primary btn-flat btn-pilih2 <?= $buktibayar != "" ? "sr-only":"";?>" onclick="upload_berkas('buktibayar')">Pilih</button>
                                                                <button type="button" class="btn btn-danger btn-flat btn-batal2 <?= $buktibayar != "" ? "":"sr-only";?>" onclick="batal_berkas('buktibayar')">Batal Berkas</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <?}?>

                                        <?if($status < 5){?>
                                        <div class="col-md-12">&nbsp;</div>

                                        <div class="col-sm-12">
                                            <fieldset>
                                                <legend>Catatan:</legend>
                                                <ol class="text-red text-justified">
                                                    <li>Pastikan data UTTP milik Anda sudah benar, jika ada kesalahan data silakan konfirmasi terlebih dahulu ke peserta agar dapat segera untuk dilakukan update</li>
                                                    <li>Jika pilihan tanggal pada jadwal tidak bisa Anda pilih hal tersebut dikarenakan tanggal sudah expired</li>
                                                    <li>Perubahan jadwal dapat menghubungi Penera atau Admin</li>
                                                    <li>Jika lebih dari 1 foto kondisi alat maka silakan digabung dalam bentuk PDF</li>
                                                    <li>Maksimal upload file berukuran 2 Mb</li>
                                                    <li>Jika ingin memberikan pilihan jadwal minimal pilihan diberikan 2 waktu</li>
                                                </ol>
                                            </fieldset>
                                        </div>
                                        <?}?>

                                        <?if($status == 10){?>
                                        <div class="col-md-12">&nbsp;</div>

                                        <div class="col-sm-12">
                                            <fieldset>
                                                <legend>Alasan Pembatalan:</legend>
                                                <div><?= $alasanbatal;?></div>
                                            </fieldset>
                                        </div>
                                        <?}?>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="<?= $status >= 5 ? base_url().'pelayanan/pengajuan/'.$kdpeserta.'/'.$mode.'/'.$kduttppeserta:$linkbatal;?>" class="btn btn-danger"><?= $status < 5 ? 'Batal':'Kembali';?></a>
                                    <?if($status < 5){?>
                                    <button type="submit" class="btn bg-khusus pull-right btn-simpan"><?= $namabtn;?></button>
                                    <?}?>
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
<!-- End Blog Area -->