<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?= base_url(); ?>assets/backend/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url(); ?>assets/backend/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url(); ?>assets/backend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= base_url(); ?>assets/backend/bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url(); ?>assets/backend/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url(); ?>assets/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url(); ?>assets/backend/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url(); ?>assets/backend/bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url(); ?>assets/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Select2 -->
<script src="<?= base_url(); ?>assets/backend/bower_components/select2/dist/js/select2.full.min.js"></script>

<?if($halaman == "Tentang Kami" || $halaman == "Visi & Misi" || $halaman == "Galeri & Berita"){?>
<!-- CK Editor -->
<script src="<?= base_url(); ?>assets/backend/bower_components/ckeditor/ckeditor.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/editor.js"></script>
<?}?>

<!-- DataTables -->
<script src="<?= base_url(); ?>assets/backend/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/datatables.custom.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url(); ?>assets/backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url(); ?>assets/backend/bower_components/fastclick/lib/fastclick.js"></script>

<!-- iCheck 1.0.1 -->
<script src="<?= base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>

<!-- Sparkline -->
<script src="<?= base_url(); ?>assets/backend/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url(); ?>assets/backend/dist/js/adminlte.min.js"></script>

<!-- Tambahan JS -->
<script src="<?= base_url(); ?>assets/backend/js/aksi.js"></script>
<script src="<?= base_url(); ?>assets/backend/js/ambil.js"></script>

<?if($halaman == "Peserta Tera/Tera Ulang" || $halaman == "UTTP Peserta Tera/Tera Ulang"){?>
    <script src="<?= base_url();?>assets/backend/js/upload_peserta.js"></script>
<?}elseif($halaman == "Pengajuan Tera/Tera Ulang"){?>
    <script src="<?= base_url();?>assets/backend/js/upload_permintaan.js"></script>
<?}else{?>
    <script src="<?= base_url(); ?>assets/backend/js/upload.js"></script>
<?}?>

<!-- Excel to JSON -->
<!--<script src="<?= base_url(); ?>assets/js/xlsx.full.min.js"></script>-->

<script>
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button"; //again because google chrome don't insert first hash into history
    window.onhashchange = function() {
        window.location.hash = "no-back-button";
    }
</script>

<!-- Initialize Select2 Elements -->
<script>
    $('.select2').select2();

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
</script>

</body>

</html>