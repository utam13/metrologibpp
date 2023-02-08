<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regulasi extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_regulasi');
    }

    public function index($page = 1, $limit = 20, $isicari = "-", $katcari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Regulasi";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
            $getkategori = str_replace("-", " ", urldecode($katcari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
            $getkategori = $this->input->post('kategori');
        }

        $q_cari = "";
        if ($getcari != "") {
            $q_cari = "$getkategori like '%$getcari%'";
        } else {
            $q_cari = "nama<>''";
        }
        
        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $kategori = str_replace(" ", "-", $getkategori);
        $data['getkategori'] =  $kategori;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_regulasi->jumlah($q_cari);

        if ($this->input->post('limitpage') == "") {
            $limit_start = ($page - 1) * 10;
        } else {
            $limit = $this->input->post('limitpage');
            $limit_start = ($page - 1) * $limit;
        }

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $daftar = $this->mod_regulasi->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdregulasi'] = $d->kdregulasi;
            $subrecord['jenis'] = $d->jenis;
            $subrecord['nama'] = $d->nama;
            $subrecord['nomor'] = $d->nomor;
            $subrecord['thn'] = $d->thn;
            $subrecord['berkas'] = $d->berkas;

            if ($subrecord['berkas'] != "") {
                $berkas = "upload/regulasi/" . $subrecord['berkas'];
                if (file_exists($berkas)) {
                    $subrecord['file_berkas'] = base_url() . "upload/regulasi/" . $subrecord['berkas'] . "?" . rand();
                } else {
                    $subrecord['file_berkas'] = "";
                }
            } else {
                $subrecord['file_berkas'] = "";
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['regulasi'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;

        //save log
        $this->log_lib->log_info("Akses halaman daftar regulasi");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/regulasi');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "Regulasi";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        if($kode != ""){
            $ambil = $this->mod_regulasi->ambil($kode);

            $data['kdregulasi'] = $ambil['kdregulasi'];
            $data['jenis'] = $ambil['jenis'];
            $data['nama'] = $ambil['nama'];
            $data['nomor'] = $ambil['nomor'];
            $data['thn'] = $ambil['thn'];
            $data['berkas'] = $ambil['berkas'];
            $data['file_berkas'] = $ambil['berkas'];

            if ($ambil['berkas'] != "") {
                $berkas = "upload/regulasi/" . $ambil['berkas'];
                if (file_exists($berkas)) {
                    $data['file_berkas'] = base_url() . "upload/regulasi/" . $ambil['berkas'] . "?" . rand();
                } else {
                    $data['file_berkas'] = "";
                }
            } else {
                $data['file_berkas'] = "";
            }
        } else {
            $data['kdregulasi'] = "";
            $data['jenis'] = "";
            $data['nama'] = "";
            $data['nomor'] = "";
            $data['thn'] = "";
            $data['berkas'] = "";
            $data['file_berkas'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir regulasi");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_regulasi');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if ($proses != 3) {
            $kdregulasi = $this->input->post('kode');
            $awal = $this->input->post('nama_awal');
            $jenis = $this->input->post('jenis');
            $nomor = $this->input->post('nomor');
            $thn = $this->input->post('tahun');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));
            $berkas = $this->input->post('berkas');

            $cek_nama = $this->mod_regulasi->cek_nama($nama);

            $data = array(
                "kdregulasi" => $kdregulasi,
                "jenis" => $jenis,
                "nomor" => $nomor,
                "thn" => $thn,
                "nama" => $nama,
                "berkas" => $berkas
            );
        }

        switch ($proses) {
            case 1:
                if ($cek_nama == 0) {
                    $this->mod_regulasi->simpan($data);

                    $pesan = 1;
                    $isipesan = "Daftar regulasi baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama regulasi sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_nama == 0)) {
                    $this->mod_regulasi->ubah($data);
                    $pesan = 2;
                    $isipesan = "Daftar regulasi diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama regulasi sudah terdaftar";
                }
                break;
            case 3:
                $berkas = $this->mod_regulasi->berkas($kode);
                if(!empty($berkas)){
                    $file_berkas = "upload/regulasi/" . $berkas['berkas'];
                    if (file_exists($file_berkas)) {
                        unlink("./upload/regulasi/" . $berkas['berkas']);
                    }
                }

                $this->mod_regulasi->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Daftar regulasi telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("regulasi/index/1/20/-/-/$pesan/$msg");
    }

    public function upload($namaberkas)
    {
        $config['upload_path']        = './upload/regulasi';
        $config['allowed_types']     = 'jpg|jpeg|png|pdf';
        $config['file_name']        = $namaberkas;
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

    function viewPdf($namafile)
    {
        header("content-type: application/pdf");
        readfile('./upload/regulasi/' . $namafile);
    }

    public function batalberkas($namafile,$proses,$kode = "")
    {
        $file_galeri = "upload/regulasi/" . $namafile;
        if (file_exists($file_galeri)) {
            unlink("./upload/regulasi/" . $namafile);
        }

        $pesan = 3;
        $isipesan = "Berkas terpilih dibatalkan";

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("regulasi/formulir/$proses/$kode");
    }
}