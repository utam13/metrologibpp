<!-- Start About area -->
<div id="about" class="about-area area-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline text-center">
                    <h2>Tentang Kami</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- single-well start-->
            <div class="col-md-1"></div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="well-left">
                    <div class="single-well text-center">
                        <a href="#">
                            <img src="<?= $file_logo;?>" alt="logo" class="square">
                        </a>
                    </div>
                </div>
            </div>
            <!-- single-well end-->
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="well-middle">
                    <div class="single-well">
                        <a href="#">
                            <i><h3>Sekilas <?= $namakantor;?></h3></i>
                        </a>
                        <?= $singkat;?>
                    </div>
                </div>
            </div>
            <!-- End col-->
            <div class="col-md-12 text-center">
                <a href="<?= base_url();?>landing/tentang" class="ready-btn">Baca lebih lanjut</a>
            </div>
        </div>
    </div>
</div>
<!-- End About area -->

<!-- Start Service area -->
<div id="services" class="service-area area-padding">
    <div class="service-bg">
        <div class="test-overly2"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-headline services-head text-center">
                        <h2>Pelayanan</h2>
                    </div>
                </div>
            </div>
            <div class="row text-center service-text">
                <div class="services-contents">
                    <?
                    $hasil = json_decode($layanan);
                    foreach ($hasil as $h) {
                    ?>
                    <!-- Start Left services -->
                    <div class="col-md-4">
                        <div class="about-move">
                        <div class="services-details">
                            <div class="single-services">
                                <a class="services-icon" href="#">
                                    <i class="fa fa-balance-scale"></i>
                                </a>
                                <h4><?= $h->nama;?></h4>
                                <p>
                                    <?= $h->uraian;?>
                                </p>
                            </div>
                        </div>
                        <!-- end about-details -->
                        </div>
                    </div>
                    <?}?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Service area -->

<!-- Start Wellcome Area -->
<!-- <div class="wellcome-area">
    <div class="well-bg">
        <div class="test-overly"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="wellcome-text">
                        <div class="well-text text-center">
                            <h2>Visi</h2>
                            <?= $visi;?>
                        </div>
                        <div class="well-text text-center">
                            <h2>Misi</h2>
                            <?= $misi;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- End Wellcome Area -->

<!-- Start portfolio Area -->
<div id="portfolio" class="portfolio-area area-padding fix" style="margin-top: 30px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-center">
                <h2>Galeri Kegiatan</h2>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="awesome-project-content galeri-contents">
                <?
                $hasil = json_decode($galeri);
                foreach ($hasil as $h) {
                ?>
                <!-- single-awesome-project start -->
                <div class="col-md-4 col-sm-4 col-xs-12 design development">
                    <div class="single-awesome-project">
                        <div class="awesome-img">
                            <a href="#"><img src="<?= $h->file_berkas_galeri?>" alt="galeri" /></a>
                            <div class="add-actions text-center">
                                <div class="project-dec">
                                    <a class="venobox" data-gall="myGallery" href="<?= $h->file_berkas_galeri?>">
                                        <h4><?= $h->judul;?></h4>
                                        <span><?= $h->waktu;?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- single-awesome-project end -->
                <?}?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
            <? //if ($jumlah_page_galeri > 0) { ?>
                <ul class="pagination">
                    <? if ($page_galeri == 1) { ?>
                    <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                    <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                    <? } else {
                            $link_prev_galeri = ($page_galeri > 1) ? $page_galeri - 1 : 1; ?>
                    <li class="page-item"><a href="<?= base_url();?>landing/index/1/1" class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                    <li class="page-item"><a href="<?= base_url();?>landing/index/<?= $link_prev_galeri; ?>/1" class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                    <?
                    }

                    for ($i_galeri = $start_number_galeri; $i_galeri <= $end_number_galeri; $i_galeri++) {
                        if ($page_galeri == $i_galeri) {
                            $link_active_galeri = "";
                            $link_color_galeri = "class='page-item disabled'";
                        } else {
                            $link_active_galeri = base_url() . "landing/index/$i_galeri/1";
                            $link_color_galeri = "class='page-item'";
                        }
                    ?>
                    <li <?= $link_color_galeri; ?>><a href="<?= $link_active_galeri; ?>" class="page-link" onclick="showloading()"><?= $i_galeri; ?></a></li>
                    <? }

                    if ($page_galeri == $jumlah_page_galeri) {
                    ?>
                    <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-forward"></i></a></li>
                    <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-forward"></i></a></li>
                    <? } else {
                            $link_next_galeri = ($page_galeri < $jumlah_page_galeri) ? $page_galeri + 1 : $jumlah_page_galeri; ?>
                    <li class="page-item"><a href="<?= base_url();?>landing/index/<?= $link_next_galeri; ?>/1" class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                    <li class="page-item"><a href="<?= base_url();?>landing/index/<?= $jumlah_page_galeri; ?>/1" class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
                    <? } ?>
                </ul>
            <?//}?>
            </div>
        </div>
    </div>
</div>
<!-- awesome-portfolio end -->

<!-- Start Blog Area -->
<div id="blog" class="blog-area">
    <div class="blog-inner area-padding">
        <div class="container ">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-headline text-center">
                        <h2>Berita Kegiatan</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 berita-contents">
                    <?
                    $hasil = json_decode($berita);
                    foreach ($hasil as $h) {
                    ?>
                    <!-- Start Left Blog -->
                    <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:10px;">
                        <div class="single-blog">
                            <div class="single-blog-img">
                                <img src="<?= $h->file_berkas_berita;?>" alt="berita">
                            </div>
                            <div class="blog-meta">
                                <span class="date-type">
                                    <?= $h->waktu;?>
                                </span>
                            </div>
                            <div class="blog-text">
                                <h4>
                                    <a href="<?= base_url();?>landing/berita/<?= $h->kdberita;?>"><?= $h->judul;?></a>
                                </h4>
                                <p>
                                    <?= $h->cutisi;?>
                                </p>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?= base_url();?>landing/berita/<?= $h->kdberita;?>" class="ready-btn">Baca...</a>
                                </div>
                                <div class="col-md-6 footer-icons text-right" style="margin-top:10px !important;">
                                    <?= $h->sosmed;?>
                                </div>
                            </div>
                        </div>
                        <!-- Start single blog -->
                    </div>
                    <!-- End Left Blog-->
                    <?}?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                <?if ($jumlah_page_berita > 0) { ?>
                    <ul class="pagination">
                        <? if ($page_berita == 1) { ?>
                            <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-backward"></i></a></li>
                            <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-backward"></i></a></li>
                        <? } else {
                            $link_prev_berita = ($page_berita > 1) ? $page_berita - 1 : 1; ?>
                            <li class="page-item"><a href="<?= base_url();?>landing/index/1/1 class="page-link" onclick="showloading()"><i class="fa fa-fast-backward"></i></a></li>
                            <li class="page-item"><a href="<?= base_url();?>landing/index/1/<?= $link_prev_berita; ?> class="page-link" onclick="showloading()"><i class="fa fa-step-backward"></i></a></li>
                        <?
                        }

                        for ($i_berita = $start_number_berita; $i_berita <= $end_number_berita; $i_berita++) {
                            if ($page_berita == $i_berita) {
                                $link_active_berita = "";
                                $link_color_berita = "class='page-item disabled'";
                            } else {
                                $link_active_berita = base_url() . "landing/index/1/$i_berita";
                                $link_color_berita = "class='page-item'";
                            }
                        ?>
                        <li <?= $link_color_berita; ?>><a href="<?= $link_active_berita; ?>" class="page-link" onclick="showloading()"><?= $i_berita; ?></a></li>
                        <? }

                        if ($page_berita == $jumlah_page_berita) {
                        ?>
                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-step-forward"></i></a></li>
                        <li class="page-item disabled"><a href="#" class="page-link" tabindex="-1" aria-disabled="true"><i class="fa fa-fast-forward"></i></a></li>
                        <? } else {
                                $link_next_berita = ($page_berita < $jumlah_page_berita) ? $page_berita + 1 : $jumlah_page_berita; ?>
                        <li class="page-item"><a href="<?= base_url();?>landing/index/1/<?= $link_next_berita; ?> class="page-link" onclick="showloading()"><i class="fa fa-step-forward"></i></a></li>
                        <li class="page-item"><a href="<?= base_url();?>landing/index/1/<?= $jumlah_page_berita; ?> class="page-link" onclick="showloading()"><i class="fa fa-fast-forward"></i></a></li>
                        <? } ?>
                    </ul>
                <?}?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Blog -->

<!-- Start team Area -->
<div id="team" class="our-team-area area-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-center">
                <h2>Instagram</h2>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 team-top">
                <script src="https://apps.elfsight.com/p/platform.js" defer></script>
                <div class="elfsight-app-00d9a700-d3b5-488c-809a-85dfb8df07a5"></div>
            </div>
        </div>
    </div>
</div>
<!-- End Team Area -->

<!-- Start Suscrive Area -->
<div class="suscribe-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs=12">
                <div class="suscribe-text text-center">
                    <h3>Silakan melakukan registrasi untuk memudahkan dalam pelayanan<br>tera dan tera ulang</h3>
                    <div>&nbsp;</div>
                    <div><a href="<?= base_url();?>pelayanan/registrasi" class="btn bg-white btn-lg text-black">REGISTRASI DISINI</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Suscrive Area -->

<!-- Start contact Area -->
<div id="contact" class="contact-area">
    <div class="contact-inner area-padding">
        <div class="contact-overly"></div>
        <div class="container ">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="section-headline text-center">
                        <h2>Kontak Kami</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Start contact icon column -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="contact-icon text-center">
                        <div class="single-icon">
                            <i class="fa fa-phone icon"></i>
                            <p>
                                <?= $telpkantor;?><br>
                                <span><?= $waktuaktif;?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Start contact icon column -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="contact-icon text-center">
                        <div class="single-icon">
                            <i class="fa fa-whatsapp icon"></i>
                            <p>
                                <?= $wakantor;?><br>
                                <span>Aktif di waktu kerja</span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Start contact icon column -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="contact-icon text-center">
                        <div class="single-icon">
                            <i class="fa fa-envelope-o icon"></i>
                            <p>
                                <?= $emailkantor;?><br>
                                <span><?= $webkantor;?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Start contact icon column -->
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="contact-icon text-center">
                        <div class="single-icon">
                            <i class="fa fa-building icon"></i>
                            <p>
                                <?= $alamatkantor;?>
                            </p>
                        </div>
                        <div class="col-md-12 sosmed-icons text-right">
                            <ul>
                                <?if($fbkantor != "" && $fbkantor != "-"){?>
                                <li>
                                    <a href="<?= $fbkantor;?>"><i class="fa fa-facebook"></i></a>
                                </li>
                                <?} if($igkantor != "" && $igkantor != "-"){?>
                                <li>
                                    <a href="<?= $igkantor;?>"><i class="fa fa-instagram"></i></a>
                                </li>
                                <?} if($youtubekantor != "" && $youtubekantor != "-"){?>
                                <li>
                                    <a href="<?= $youtubekantor;?>"><i class="fa fa-youtube"></i></a>
                                </li>
                                <?}?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <!-- Start Google Map -->
                <div class="col-md-12 col-sm-6 col-xs-12">
                    <!-- Start Map -->
                    <iframe src="<?= $googlemapkantor;?>" width="100%" height="380" frameborder="0" style="border:0" allowfullscreen></iframe>
                    <!-- End Map -->
                </div>
                <!-- End Google Map -->

               
                <!-- Start  contact -->
                <!-- <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="form contact-form">
                    <div id="sendmessage">Your message has been sent. Thank you!</div>
                    <div id="errormessage"></div>
                    <form action="" method="post" role="form" class="contactForm">
                        <div class="form-group">
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama Anda" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                        <div class="validation"></div>
                        </div>
                        <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" data-rule="email" data-msg="Please enter a valid email" />
                        <div class="validation"></div>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                        <div class="validation"></div>
                        </div>
                        <div class="form-group">
                        <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Pesan Anda"></textarea>
                        <div class="validation"></div>
                        </div>
                        <div class="text-center"><button type="submit">Kirim Pesan</button></div>
                    </form>
                    </div>
                </div> -->
                <!-- End Left contact -->
            </div>
        </div>
    </div>
</div>
<!-- End Contact Area -->