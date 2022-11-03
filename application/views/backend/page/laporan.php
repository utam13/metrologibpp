<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Laporan
                        </h3>
                    </div>
                    <form id="frm_laporan" name="frm_laporan" method="post" target="prosesdata" action="<?= base_url(); ?>laporan/proses">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Kelompok Laporan</label>
                                <select class="form-control" name="kelompoklaporan" id="kelompoklaporan" required >
                                    <option value="">Pilih</option>
                                    <option value="1">Rekap Peserta</option>
                                    <option value="2">Rekap Pengajuan</option>
                                    <option value="3">Rekap SKHP Expired</option>
                                </select>
                            </div>
                            <div class="form-group div-status sr-only">
                                <label>Status Pengajuan</label>
                                <select class="form-control" name="status" id="status" >
                                    <option value="">Pilih</option>
                                    <option value="6">Semua Pengajuan</option>
                                    <option value="0">Pengajuan Baru</option>
                                    <option value="1">Pengajuan Diterima</option>
                                    <option value="2">Pengajuan Terjadwal</option>
                                    <option value="3">Pengajuan Terbayar</option>
                                    <option value="4">Pengajuan Diproses (Semua)</option>
                                    <option value="41">Pengajuan Diproses (Alat Diterima)</option>
                                    <option value="5">Pengajuan Selesai (Semua)</option>
                                    <option value="51">Pengajuan Selesai (Dibatalkan)</option>
                                    <option value="52">Pengajuan Selesai (Sah)</option>
                                    <option value="53">Pengajuan Selesai (Alat Dikembalikan)</option>
                                    <option value="54">Pengajuan Selesai (Dokumen Diserahkan)</option>
                                </select>
                            </div>
                            <div class="form-group div-layanan sr-only">
                                <label>Pelayanan</label>
                                <select class="form-control" name="layanan" id="layananlaporan" >
                                    <option value="">Semua Pelayanan</option>
                                    <?
                                    foreach ($layanan as $u) {
                                        echo "<option value='".$u->kdlayanan."'>".$u->nama."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group div-dokskhplama sr-only">
                                <label>Status Dokumen SKHP Lama</label>
                                <select class="form-control" name="adaskhplama" id="adaskhplama" >
                                    <option value="">Semua Status</option>
                                    <option value="1">Ada</option>
                                    <option value="0">Hilang</option>
                                </select>
                            </div>
                            <div class="form-group div-berlakuskhplama sr-only">
                                <label>Status Berlaku SKHP Lama</label>
                                <select class="form-control" name="berlakuskhplama" id="berlakuskhplama" >
                                    <option value="">Semua Status</option>
                                    <option value="1">Masih Berlaku</option>
                                    <option value="0">Expired</option>
                                </select>
                            </div>
                            <div class="form-group div-peserta sr-only">
                                <label>Peserta</label>
                                <select class="form-control select2" name="peserta" id="peserta" >
                                    <option value="">Pilih</option>
                                    <option value="0">Semua Peserta</option>
                                    <?
                                    foreach ($peserta as $p) {
                                        echo "<option value='".$p->kdpeserta."'>".$p->npwp." - ".$p->nama."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group div-tgllaporan">
                                <label>Rentang Waktu Pelaporan <small class="tgl">Tanggal</small></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small>Dari</small>
                                        <input type="date" name="dari" id="dari" class="form-control" max="<?= date('Y-m-d');?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <small>Sampai</small>
                                        <input type="date" name="sampai" id="sampai" class="form-control" max="<?= date('Y-m-d');?>" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">Proses</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>