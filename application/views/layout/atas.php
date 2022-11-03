<!doctype html>
<html lang="en">
<head>
	<?extract($infoapp);?>
	<meta charset="utf-8">
	<title><?= $namakantor;?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="keywords">
	<meta content="" name="description">

	<!-- Favicons -->
	<link href="<?= $file_logo; ?>" rel="icon">
	<link href="<?= $file_logo; ?>" rel="apple-touch-icon">

	<!-- Google Fonts -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet"> -->

	<!-- Bootstrap CSS File -->
	<link href="<?= base_url();?>assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url();?>assets/lib/font-awesome/css/font-awesome.min.css">

	<!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

	<!-- Libraries CSS Files -->
	<link href="<?= base_url();?>assets/lib/nivo-slider/css/nivo-slider.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/owlcarousel/owl.carousel.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/owlcarousel/owl.transitions.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/animate/animate.min.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/lib/venobox/venobox.css" rel="stylesheet">

	<!-- Nivo Slider Theme -->
	<link href="<?= base_url();?>assets/css/nivo-slider-theme.css" rel="stylesheet">

	<!-- Main Stylesheet File -->
	<link href="<?= base_url();?>assets/css/style.css" rel="stylesheet">

	<!--Custome -->
	<link href="<?= base_url();?>assets/css/color.css" rel="stylesheet">
	<link href="<?= base_url();?>assets/css/style-custom.css" rel="stylesheet">

	<!-- Responsive Stylesheet File -->
	<link href="<?= base_url();?>assets/css/responsive.css" rel="stylesheet">

	<!-- =======================================================
		Theme Name: eBusiness
		Theme URL: https://bootstrapmade.com/ebusiness-bootstrap-corporate-template/
		Author: BootstrapMade.com
		License: https://bootstrapmade.com/license/
	======================================================= -->
</head>

<body data-spy="scroll">

<div id="preloader"></div>

<?if($halaman == "Landing"){?>
<!-- Start Slider Area -->
<div id="home" class="slider-area">
    <div class="bend niceties preview-2">
        <div id="ensign-nivoslider" class="slides">
			<?
			$noslide = 1;
			foreach ($slide as $s) {
				$aktifslide = $noslide == 1 ? "active" : "";
				echo '<img src="'.base_url().'upload/slide/'.$s->gambar.'" alt="" title="#slider-direction-'.$noslide.'" />';
				$noslide++;
			}?>
        </div>
    </div>
</div>
<!-- End Slider Area -->
<?}else{?>
<div id="home" class="divider-area" id="divider">
    &nbsp;
</div>
<?}?>