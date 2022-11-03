<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_landing');
    }

    public function index($page_galeri = 1, $page_berita = 1)
    {
        $data['halaman'] = "Landing";

        $data['infoapp']  = $this->infoapp->info();
        extract($data['infoapp'] );
        $data['namakantor'] = $namakantor;
        $data['alamatkantor'] = $alamatkantor;
        $data['telpkantor'] = $telpkantor;
        $data['wakantor'] = $wakantor;
        $data['emailkantor'] = $emailkantor;
        $data['webkantor'] = $webkantor;
        $data['waktuaktif'] = $waktuaktif;
        $data['googlemapkantor'] = $googlemapkantor;
        $data['igkantor'] = $igkantor;
        $data['fbkantor'] = $fbkantor;
        $data['youtubekantor'] = $youtubekantor;
        $data['logo'] = $logo;
        $data['file_logo'] = $file_logo;
        $data['slide'] = $slide;

        $tentang = $this->mod_landing->tentang();
        $data['singkat'] = empty($tentang) ? '' : $tentang['singkat'];
        
        $visimisi = $this->mod_landing->visimisi();
        $data['visi'] = empty($visimisi) ? '' : $visimisi['visi'];
        $data['misi'] = empty($visimisi) ? '' : $visimisi['misi'];

        // layanan
        $daftar_layanan = $this->mod_landing->daftar_layanan()->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar_layanan as $d) {
            $subrecord['nama'] = $d->nama;
            $subrecord['uraian'] = $d->uraian;

            array_push($record, $subrecord);
        }

        $data['layanan'] = json_encode($record);

        //berita
        $jumlah_berita = $this->mod_landing->jumlah_berita();

        $limit_berita = 10;
        $limit_start_berita = ($page_berita - 1) * $limit_berita;

        $data['limit_berita'] = $limit_berita;

        $daftar_berita = $this->mod_landing->daftar_berita($limit_start_berita, $limit_berita)->result();

        $record_berita = array();
        $subrecord_berita = array();
        foreach ($daftar_berita as $d) {
            $subrecord_berita['kdberita'] = $d->kdberita;
            $subrecord_berita['judul'] = $d->judul;

            $galeri = $this->mod_landing->galeriutama($d->kdberita);
            if (empty($galeri)) {
                $galeri2 = $this->mod_landing->galeriberita($d->kdberita);
                $subrecord_berita['gambar'] = emtpy($galeri2) ? "" : $galeri2['gambar'];
            } else {
                $subrecord_berita['gambar'] = $galeri['gambar'];
            }

            if ($subrecord_berita['gambar'] != "") {
                $berkas = "upload/galeri/" .  $subrecord_berita['gambar'];
                if (file_exists($berkas)) {
                    $subrecord_berita['file_berkas_berita'] = base_url() . "upload/galeri/" .  $subrecord_berita['gambar'] . "?" . rand();
                } else {
                    $subrecord_berita['file_berkas_berita'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord_berita['file_berkas_berita'] = base_url() . "upload/no-image.png";
            }

            $subrecord_berita['cutisi'] = strlen($d->isi) > 250 ? strip_tags(substr($d->isi,0,250))."..." : strip_tags($d->isi);
            $subrecord_berita['waktu'] = '<i class="fa fa-calendar"></i> '.date('d-m-Y',strtotime($d->tgl))."/".date('h:i A',strtotime($d->jam));

            $subrecord_berita['sosmed'] = "";
            if($d->ig != "" || $d->fb != "" || $d->youtube != ""){
                $subrecord_berita['sosmed'] .= '<ul>';
                $subrecord_berita['sosmed'] .= $d->ig != '' ? '<li><a href="'.$d->ig.'"><i class="fa fa-instagram"></i></a></li>' : '';
                $subrecord_berita['sosmed'] .= $d->fb != '' ? '<li><a href="'.$d->fb.'"><i class="fa fa-facebook"></i></a></li>' : '';
                $subrecord_berita['sosmed'] .= $d->youtube != '' ? '<li><a href="'.$d->youtube.'"><i class="fa fa-youtube"></i></a></li>' : '';
                $subrecord_berita['sosmed'] .= '</ul>';
            } else {
                $subrecord_berita['sosmed'] = "-";
            }

            array_push($record_berita, $subrecord_berita);
        }

        $data['berita'] = json_encode($record_berita);

        $data['page_berita'] = $page_berita;
        $data['limit_berita'] = $limit_berita;
        $data['get_jumlah_berita'] = $jumlah_berita;
        $data['jumlah_page_berita'] = ceil($jumlah_berita / $limit_berita);
        $data['jumlah_number_berita'] = 2;
        $data['start_number_berita'] = ($page_berita > $data['jumlah_number_berita']) ? $page_berita - $data['jumlah_number_berita'] : 1;
        $data['end_number_berita'] = ($page_berita < ($data['jumlah_page_berita'] - $data['jumlah_number_berita'])) ? $page_berita + $data['jumlah_number_berita'] : $data['jumlah_page_berita'];

        //galeri
        $jumlah_galeri = $this->mod_landing->jumlah_galeri();

        $limit_galeri = 10;
        $limit_start_galeri = ($page_galeri - 1) * $limit_galeri;

        $data['limit_galeri'] = $limit_galeri;

        $daftar_galeri = $this->mod_landing->daftar_galeri($limit_start_galeri, $limit_galeri)->result();

        $record_galeri = array();
        $subrecord_galeri = array();
        foreach ($daftar_galeri as $d) {
            // $subrecord_galeri['kdberita'] = $d->kdberita;
            $subrecord_galeri['judul'] = $d->judul;
            $subrecord_galeri['gambar'] = $d->gambar;

            $subrecord_galeri['waktu'] = date('d-m-Y',strtotime($d->tgl))."/".date('h:i A',strtotime($d->jam));
            // $galeri = $this->mod_landing->galeriutama($d->kdberita);
            // if (empty($galeri)) {
            //     $galeri2 = $this->mod_landing->galeriberita($d->kdberita);
            //     $subrecord_galeri['gambar'] = emtpy($galeri2) ? "" : $galeri2['gambar'];
            // } else {
            //     $subrecord_galeri['gambar'] = $galeri['gambar'];
            // }

            if ($subrecord_galeri['gambar'] != "") {
                $berkas = "upload/galeri/" .  $subrecord_galeri['gambar'];
                if (file_exists($berkas)) {
                    $subrecord_galeri['file_berkas_galeri'] = base_url() . "upload/galeri/" .  $subrecord_galeri['gambar'] . "?" . rand();
                } else {
                    $subrecord_galeri['file_berkas_galeri'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord_galeri['file_berkas_galeri'] = base_url() . "upload/no-image.png";
            }

            array_push($record_galeri, $subrecord_galeri);
        }

        $data['galeri'] = json_encode($record_galeri);

        $data['page_galeri'] = $page_galeri;
        $data['limit_galeri'] = $limit_galeri;
        $data['get_jumlah_galeri'] = $jumlah_galeri;
        $data['jumlah_page_galeri'] = ceil($jumlah_galeri / $limit_galeri);
        $data['jumlah_number_galeri'] = 2;
        $data['start_number_galeri'] = ($page_galeri > $data['jumlah_number_galeri']) ? $page_galeri - $data['jumlah_number_galeri'] : 1;
        $data['end_number_galeri'] = ($page_galeri < ($data['jumlah_page_galeri'] - $data['jumlah_number_galeri'])) ? $page_galeri + $data['jumlah_number_galeri'] : $data['jumlah_page_galeri'];

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/landing');
        $this->load->view('layout/bawah');
    }

    public function tentang()
    {
        $data['halaman'] = "Tentang Kami";

        $data['infoapp'] = $this->infoapp->info();

        $tentang = $this->mod_landing->tentang();
        $data['singkat'] = empty($tentang) ? '' : $tentang['singkat'];
        $data['isitentang'] = empty($tentang) ? '' : $tentang['isitentang'];

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/tentang');
        $this->load->view('layout/bawah');
    }

    public function berita($kdberita)
    {
        $data['halaman'] = "Berita Kegiatan";

        $data['infoapp'] = $this->infoapp->info();

        $berita = $this->mod_landing->ambil_berita($kdberita);
        if (empty($berita)) {
            redirect("landing");
        } else {
            $data['kdberita'] = $berita['kdberita'];
            $data['judul'] = $berita['judul'];
            $data['isi'] = $berita['isi'];

            $galeri = $this->mod_landing->galeriutama($berita['kdberita']);
            if (empty($galeri)) {
                $galeri2 = $this->mod_landing->galeriberita($berita['kdberita']);
                $data['gambar'] = emtpy($galeri2) ? "" : $galeri2['gambar'];
            } else {
                $data['gambar'] = $galeri['gambar'];
            }

            if ($data['gambar'] != "") {
                $berkas = "upload/galeri/" .  $data['gambar'];
                if (file_exists($berkas)) {
                    $data['file_berkas_berita'] = base_url() . "upload/galeri/" .  $data['gambar'] . "?" . rand();
                } else {
                    $data['file_berkas_berita'] = base_url() . "upload/no-image.png";
                }
            } else {
                $data['file_berkas_berita'] = base_url() . "upload/no-image.png";
            }

            $data['waktu'] = '<i class="fa fa-calendar"></i> '.date('d-m-Y',strtotime($berita['tgl']))."/".date('h:i A',strtotime($berita['jam']));

            $data['sosmed'] = "";
            if($berita['ig'] != "" || $berita['fb'] != "" || $berita['youtube'] != ""){
                $data['sosmed'] .= '<ul>';
                $data['sosmed'] .= $berita['ig'] != '' ? '<li><a href="'.$berita['ig'].'"><i class="fa fa-instagram"></i></a></li>' : '';
                $data['sosmed'] .= $berita['fb'] != '' ? '<li><a href="'.$berita['fb'].'"><i class="fa fa-facebook"></i></a></li>' : '';
                $data['sosmed'] .= $berita['youtube'] != '' ? '<li><a href="'.$berita['youtube'].'"><i class="fa fa-youtube"></i></a></li>' : '';
                $data['sosmed'] .= '</ul>';
            } else {
                $data['sosmed'] = "-";
            }

            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/berita');
            $this->load->view('layout/bawah');
        }
    }
}