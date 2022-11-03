<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Layanan
            <small>Formulir</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Formulir Layanan
                        </h3>
                    </div>
                    <form id="frm_layanan" name="frm_layanan" method="post" action="<?= base_url(); ?>layanan/proses/<?= $proses;?>" onsubmit="showloading()">
                        <input type="hidden" id="kode" name="kode" value="<?= $kdlayanan; ?>">
                        <input type="hidden" id="nama_awal" name="nama_awal" value="<?= $nama; ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Nama Layanan</label>
                                <input type="text" class="form-control" name="nama" id="nama" value="<?= $nama; ?>" maxlength=250 autocomplete="off" required />
                            </div>
                            <div class="form-group">
                                <label>Uraian Singkat</label>
                                <textarea class="form-control textarea" name="uraian" id="uraian" rows="2" maxlength=250 required style="resize:none;"><?= $uraian; ?></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="<?= base_url();?>layanan" class="btn btn-default"><i class="fa fa-close"></i> Batal</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>