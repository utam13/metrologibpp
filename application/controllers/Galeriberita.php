<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeriberita extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_galeriberita');
    }

    public function index($page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Galeri & Berita";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $q_cari = "";
        if ($getcari != "") {
            $q_cari = "judul like '%$getcari%'";
        } else {
            $q_cari = "judul<>''";
        }
        
        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_galeriberita->jumlah($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
            
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $daftar = $this->mod_galeriberita->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdberita'] = $d->kdberita;
            $subrecord['judul'] = $d->judul;
            $subrecord['tgl'] = $d->tgl;
            $subrecord['jam'] = $d->jam;
            $subrecord['isi'] = $d->isi;

            $subrecord['cutisi'] = strlen($d->isi) > 250 ? strip_tags(substr($d->isi,0,250))."..." : strip_tags($d->isi);

            $subrecord['waktu'] = date('d-m-Y',strtotime($d->tgl))."<br>".date('h:i A',strtotime($d->jam));
            $subrecord['info'] =  "<span class='text-bold'>".$d->judul."</span>";
            $subrecord['info'] .= "<br><span class='text-bold'>Isi berita:</span><br>".$subrecord['cutisi']."<br>";

            $subrecord['sosmed'] = "";
            if($d->ig != "" || $d->fb != "" || $d->youtube != ""){
                $subrecord['sosmed'] .= $d->ig != '' ? '<a href="'.$d->ig.'" class="btn btn-social-icon bg-fuchsia"><i class="fa fa-instagram"></i></a>&nbsp;' : '';
                $subrecord['sosmed'] .= $d->fb != '' ? '<a href="'.$d->fb.'" class="btn btn-social-icon bg-blue"><i class="fa fa-facebook"></i></a>&nbsp;' : '';
                $subrecord['sosmed'] .= $d->youtube != '' ? '<a href="'.$d->youtube.'" class="btn btn-social-icon bg-red"><i class="fa fa-youtube"></i></a>' : '';
            } else {
                $subrecord['sosmed'] = "-";
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['berita'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;

        //save log
        $this->log_lib->log_info("Akses halaman daftar berita");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/berita');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "Galeri & Berita";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        if($kode != ""){
            $ambil = $this->mod_galeriberita->ambil($kode);

            $data['kdberita'] = $ambil['kdberita'];
            $data['judul'] = $ambil['judul'];
            $data['tgl'] = $ambil['tgl'];
            $data['jam'] = $ambil['jam'];
            $data['isi'] = $ambil['isi'];
            $data['ig'] = $ambil['ig'];
            $data['fb'] = $ambil['fb'];
            $data['youtube'] = $ambil['youtube'];
        } else {
            $data['kdberita'] = "";
            $data['judul'] = "";
            $data['tgl'] = date('Y-m-d');
            $data['jam'] = "";
            $data['isi'] = "";
            $data['ig'] = "";
            $data['fb'] = "";
            $data['youtube'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir berita");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_berita');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if ($proses != 3) {
            $kdberita = $this->input->post('kode');
            $awal = $this->input->post('judul_awal');
            $judul = $this->clear_string->clear_quotes($this->input->post('judul'));
            $isi = $this->input->post('isi');
            $tgl = $this->input->post('tgl');
            $jam = $this->input->post('jam');
            $ig = $this->input->post('ig');
            $fb = $this->input->post('fb');
            $youtube = $this->input->post('youtube');

            $cek_judul = $this->mod_galeriberita->cek_judul($judul);

            $data = array(
                "kdberita" => $kdberita,
                "judul" => $judul,
                "isi" => $isi,
                "tgl" => $tgl,
                "jam" => $jam,
                "ig" => $ig,
                "fb" => $fb,
                "youtube" => $youtube
            );
        }

        switch ($proses) {
            case 1:
                if ($cek_judul == 0) {
                    $this->mod_galeriberita->simpan($data);

                    $pesan = 1;
                    $isipesan = "Daftar berita baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Judul berita sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $judul  || ($awal != $judul && $cek_judul == 0)) {
                    $this->mod_galeriberita->ubah($data);
                    $pesan = 2;
                    $isipesan = "Data berita diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Judul berita sudah terdaftar";
                }
                break;
            case 3:
                $galeri = $this->mod_galeriberita->galeri($kode)->result();
                foreach ($galeri as $g) {
                    $file_galeri = "upload/galeri/" . $galeri['gambar'];
                    if (file_exists($file_galeri)) {
                        unlink("./upload/galeri/" . $galeri['gambar']);
                    }
                }

                $this->mod_galeriberita->hapussemuagaleri($kode);
                $this->mod_galeriberita->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Daftar berita telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("galeriberita/index/1/20/-/$pesan/$msg");
    }

    public function galeri($kdberita, $page = 1, $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Galeri & Berita";

        $data['infoapp'] = $this->infoapp->info();

        $data['kdberita'] = $kdberita;
        $ambil = $this->mod_galeriberita->ambil($kdberita);
        $data['judul'] = $ambil['judul'];

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_galeriberita->jumlah_galeri($kdberita);

        $limit = 10;
        $limit_start = ($page - 1) * $limit;
        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $daftar = $this->mod_galeriberita->daftar_galeri($limit_start, $limit, $kdberita)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdgaleri'] = $d->kdgaleri;
            $subrecord['kdberita'] = $d->kdberita;
            $subrecord['gambar'] = $d->gambar;
            $subrecord['status'] = $d->status;

            if ( $d->gambar != "") {
                $berkas = "upload/galeri/" .  $d->gambar;
                if (file_exists($berkas)) {
                    $subrecord['file_berkas'] = base_url() . "upload/galeri/" .  $d->gambar . "?" . rand();
                } else {
                    $subrecord['file_berkas'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord['file_berkas'] = base_url() . "upload/no-image.png";
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['galeri'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;

        //save log
        $this->log_lib->log_info("Akses halaman daftar galeri berita");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/galeri');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function upload()
    {
        $config['upload_path']        = './upload/galeri';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp';
        $config['file_name']        = date('dmYhis');
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);

            echo $file_name;
        }
    }

    public function prosesgaleri($proses, $kdberita = "", $kdgaleri ="", $namafile = "")
    {
        if ($proses == 1) {
            $kdberita = $this->input->post('kdberita');
            $berkas = $this->input->post('berkas');
        }

        switch ($proses) {
            case 1:
                $this->mod_galeriberita->simpangaleri($kdberita,$berkas);

                $pesan = 1;
                $isipesan = "Foto atau gambar galeri baru di tambahkan";
                break;
            case 2:
                $this->mod_galeriberita->resetgaleri($kdberita);

                $this->mod_galeriberita->ubahgaleri($kdgaleri);

                $pesan = 1;
                $isipesan = "Mengatur foto atau gambar utama";
                break;
            case 3:
                $file_galeri = "upload/galeri/" . $namafile;
                if (file_exists($file_galeri)) {
                    unlink("./upload/galeri/" . $namafile);
                }

                $this->mod_galeriberita->hapusgaleri($kdgaleri);
                
                $pesan = 3;
                $isipesan = "Foto atau gambar galeri telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("galeriberita/galeri/$kdberita/1/$pesan/$msg");
    }

    public function batalberkas($kdberita,$namafile)
    {
        $file_galeri = "upload/galeri/" . $namafile;
        if (file_exists($file_galeri)) {
            unlink("./upload/galeri/" . $namafile);
        }

        $pesan = 3;
        $isipesan = "Berkas terpilih dibatalkan";

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("galeriberita/galeri/$kdberita/1/$pesan/$msg");
    }
}