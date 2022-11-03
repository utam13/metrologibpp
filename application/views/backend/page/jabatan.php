<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pegawai
            <small>Pengaturan Jabatan</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Message area -->
            <?
            extract($alert);
            if ($kode_alert != "") {
            ?>
                <div class="col-lg-12">
                    <div class="alert <?= $jenisbox ?>">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <?= str_replace("%7C", "<br>", str_replace("%20", " ", $isipesan)); ?>
                    </div>
                </div>
            <? } ?>
            <div class="col-xs-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <a href="<?= base_url();?>pegawai" class="btn btn-default btn-sm"><i class="fa fa-reply"></i> Kembali</a>
                        </h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="frm_jabatan" name="frm_jabatan" method="post" action="<?= base_url(); ?>pegawai/prosesjabatan/<?= $proses;?>" onsubmit="showloading()">
                                    <input type="hidden" id="kode" name="kode" value="<?= $kdjabatan; ?>">
                                    <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                                    <label>Nama Jabatan <small class="<?= $proses == 1 ? "sr-only":"";?>">(Nama awal: <?= $nama;?>)</small></label>
                                    <div class="input-group">
                                        <input type="text" id="nama" name="nama" class="form-control" value="<?= $nama;?>" autocomplete="off" maxlength=50>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                            <a href="<?= base_url();?>pegawai/jabatan" class="btn btn-danger"><i class="fa fa-close"></i> Batal</a>
                                        </span>
                                    </div>
                                    <code>masukkan jabatan sesuai urutan tingkatan dari tingkat paling atas ke paling bawah</code>
                                </form>
                            </div>
                            <div class="col-md-12"><hr></div>
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-striped" id="mytable">
                                    <thead class="bg-light-blue">
                                        <tr>
                                            <th scope="col" nowrap class="text-center" style="width:5%;">No.</th>
                                            <th scope="col" nowrap class="text-center" style="width:10%;">#</th>
                                            <th scope="col" nowrap class="text-center" style="width:45%;">Nama Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $hasil = json_decode($jabatan);
                                        foreach ($hasil as $d) {
                                        ?>
                                        <tr>
                                            <td scope="col" class="text-center"><?= $d->no;?></td>
                                            <td scope="col" nowrap class="text-center">
                                                <a href="<?= base_url();?>pegawai/jabatan/2/<?= $d->kdjabatan; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a href="<?= base_url();?>pegawai/prosesjabatan/3/<?= $d->kdjabatan;?>" class="btn btn-danger btn-xs" onclick="return confirm('Menghapus jabatan <?= $d->nama;?>, Lanjutkan proses ?')"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td scope="col" nowrap><?= $d->nama;?></td>
                                        </tr>
                                        <?}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>