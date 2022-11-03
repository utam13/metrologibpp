<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pegawai
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
                            Formulir Pegawai
                        </h3>
                    </div>
                    <form id="frm_pegawai" name="frm_pegawai" method="post" action="<?= base_url(); ?>pegawai/proses/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdpegawai; ?>">
                        <input type="hidden" id="nip_awal" name="nip_awal" value="<?= $nip; ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>NIP/NIK</label>
                                        <input type="text" class="form-control" id="nip" name="nip" value="<?= $nip;?>" maxlength=150 autocomplete="off" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama;?>" maxlength=150 autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select class="form-control" name="jabatan" id="jabatan" required>
                                            <option value="">Pilih</option>
                                            <?foreach ($listjabatan as $j) {
                                                $pilih = $jabatan == $j->nama ? "selected" : "";
                                                echo "<option value='".$j->nama."' $pilih>".$j->nama."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12"><code>khusus non pegawai tidak memilik NIP, isi dengan NIK (nomor KTP)</code></div>
                                <div class="col-md-12"><hr></div>
                                <div class="col-md-12"><code>isi jika pegawai diberikan hak akses ke admin area</code></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" class="form-control" value="<?= $password;?>" autocomplete="new-password" placeholder="Password">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Level Akses</label>
                                        <select class="form-control" name="level" id="level">
                                            <option value="">Pilih</option>
                                            <option value="1" <?= $level == 1 ? "selected":"";?> >Admin Aplikasi</option>
                                            <option value="2" <?= $level == 2 ? "selected":"";?> >Admin Pelayanan</option>
                                            <option value="3" <?= $level == 3 ? "selected":"";?> >Penera</option>
                                        </select>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>pegawai" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right btn-simpan"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

