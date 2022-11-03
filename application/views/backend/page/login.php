<!DOCTYPE html>
<html>
<?extract($infoapp);?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $namakantor;?></title>
    <link href="<?= $file_logo; ?>" rel="shortcut icon" type="image/x-icon" />

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/css/login-style.css">

    <? if ($pesan != "") { ?>
        <script>
            alert("<?= str_replace("%20", " ", $pesan); ?>");
        </script>
    <? } ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= $file_logo; ?>"/>
            <p>
                <?= $namakantor;?>
            </p>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <div class="row body-row">
                <div class="col-md-7 body-content">
                    <div class="row body-login">
                        <div class="col-md-12">
                            <p class="login-box-msg" >Log In Admin</p>
                        </div>
                        <div class="col-md-12">
                        <form method="post" action="<?= base_url(); ?>login/proses" onsubmit="showloading()">
                            <div class="form-group has-feedback">
                                <input type="text" name="username" class="form-control" autocomplete="off" placeholder="Username" required>
                                <span class="fa fa-user form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control" autocomplete="new-password" placeholder="Password" required>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                                    </span>
                                </div>
                                <span class="fa fa-key form-control-feedback" style="margin-right:40px;"></span>
                            </div>
                            <div class="form-group text-center captcha">
                                <?= $captchaview;?>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="cekcaptcha" name="cekcaptcha" value="" placeholder="Ketikkan Kode CAPTCHA di atas" autocomplete="off" required >
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="recaptcha()"><i class="fa fa-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4" style="float:right;">
                                    <button type="submit" id="btn-login" class="btn btn-primary btn-block btn-flat" id="btn-login" disabled>Log In</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                        <!--<a href="<?= base_url(); ?>">Kembali ke Portal</a>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?= base_url(); ?>assets/backend/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url(); ?>assets/backend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custome JS -->
	<script src="<?= base_url(); ?>assets/backend/js/aksi.js"></script>

</body>

</html>