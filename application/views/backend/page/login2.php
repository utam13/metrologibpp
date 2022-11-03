<?extract($infoapp);?>
<!DOCTYPE html>
<html>

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

    <style>
        body {
            background: url("<?= base_url(); ?>assets/backend/img/bg.png") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .login-box-body{
            display: flex;
            background: transparent !important;
            justify-content: center;
        }
        
        .login-box{
            width: 500px !important;
        }

        .box-login{
            display: flex;
            border-radius: 20px;
            width: 350px;
            background: #fff;
            flex-direction: column;
            padding: 10px 2px 2px 10px;
        }

        .login-header{
            text-align: center;
            margin: 20px 0 10px 0;
        }

        .login-form{
            display: flex;
            /* background-color: dodgerblue; */
            /* width: 250px; */
            flex-direction: row;
            justify-content: center;
            margin-bottom: 20px;
        }

        .form-group {
            width: 250px
        }

        .login-name{
            padding: 20px 0 0 0;
            font-size:3rem;
            font-weight: bold;
            color:#000;
        }

        .text-center{
            text-align: center;
        }
    </style>
    <? if ($pesan != "") { ?>
        <script>
            alert("<?= str_replace("%20", " ", $pesan); ?>");
        </script>
    <? } ?>
</head>

<body>
    <div class="login-box">
        <div class="login-logo">
            <div>
                <img src="<?= $file_logo; ?>" width="40%" />
            </div>
            <div class="login-name">
                <?= $namakantor;?>
            </div>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body ">
            <div class="box-login">
                <div class="login-header">Log In untuk memulai mengelola data</div>

                <div class="login-form">
                    <form method="post" action="<?= base_url(); ?>login/proses" onsubmit="showloading()">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control text-center" autocomplete="off" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="password" id="password" name="password" class="form-control text-center" autocomplete="new-password" placeholder="Password" required>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default" onclick="lihatpassword()"><span id="iconlihat" class="fa fa-eye"></span></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group text-center captcha">
                            <?= $captchaview;?>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control text-center" id="cekcaptcha" name="cekcaptcha" value="" placeholder="Ketikkan Kode CAPTCHA di atas" autocomplete="off" required >
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
                </div>
            </div>
            <!--<a href="<?= base_url(); ?>">Kembali ke Portal</a>-->
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