<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sop extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_sop');
    }

    public function index($page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "SOP";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $q_cari = "";
        if ($getcari != "") {
            $q_cari = "nama like '%$getcari%'";
        } else {
            $q_cari = "nama<>''";
        }
        
        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_sop->jumlah($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $daftar = $this->mod_sop->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdsop'] = $d->kdsop;
            $subrecord['nama'] = $d->nama;
            $subrecord['berkas'] = $d->berkas;

            if ($subrecord['berkas'] != "") {
                $berkas = "upload/sop/" . $subrecord['berkas'];
                if (file_exists($berkas)) {
                    $data['file_berkas'] = base_url() . "upload/sop/" . $subrecord['berkas'] . "?" . rand();
                } else {
                    $data['file_berkas'] = "";
                }
            } else {
                $data['file_berkas'] = "";
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['sop'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;

        //save log
        $this->log_lib->log_info("Akses halaman daftar sop");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/sop');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "SOP";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        if($kode != ""){
            $ambil = $this->mod_sop->ambil($kode);

            $data['kdsop'] = $ambil['kdsop'];
            $data['nama'] = $ambil['nama'];
            $data['berkas'] = $ambil['berkas'];

            if ($ambil['berkas'] != "") {
                $berkas = "upload/sop/" . $ambil['berkas'];
                if (file_exists($berkas)) {
                    $data['file_berkas'] = base_url() . "sop/viewPdf/" . $ambil['berkas'] . "?" . rand();
                } else {
                    $data['file_berkas'] = "";
                }
            } else {
                $data['file_berkas'] = "";
            }
        } else {
            $data['kdsop'] = "";
            $data['nama'] = "";
            $data['berkas'] = "";
            $data['file_berkas'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir sop");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_sop');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if ($proses != 3) {
            $kdsop = $this->input->post('kode');
            $awal = $this->input->post('nama_awal');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));
            $berkas = $this->input->post('berkas');

            $cek_nama = $this->mod_sop->cek_nama($nama);

            $data = array(
                "kdsop" => $kdsop,
                "nama" => $nama,
                "berkas" => $berkas
            );
        }

        switch ($proses) {
            case 1:
                if ($cek_nama == 0) {
                    $this->mod_sop->simpan($data);

                    $pesan = 1;
                    $isipesan = "Daftar sop baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama sop sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_nama == 0)) {
                    $this->mod_sop->ubah($data);
                    $pesan = 2;
                    $isipesan = "Daftar sop diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama sop sudah terdaftar";
                }
                break;
            case 3:
                $berkas = $this->mod_sop->berkas($kode);
                if(!empty($berkas)){
                    $file_berkas = "upload/sop/" . $berkas['berkas'];
                    if (file_exists($file_berkas)) {
                        unlink("./upload/sop/" . $berkas['berkas']);
                    }
                }

                $this->mod_sop->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Daftar sop telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("sop/index/1/20/-/$pesan/$msg");
    }

    public function upload($namaberkas)
    {
        $config['upload_path']        = './upload/sop';
        $config['allowed_types']     = 'pdf';
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
        readfile('./upload/sop/' . $namafile);
    }

    public function batalberkas($namafile,$proses,$kode = "")
    {
        $file_galeri = "upload/sop/" . $namafile;
        if (file_exists($file_galeri)) {
            unlink("./upload/sop/" . $namafile);
        }

        $pesan = 3;
        $isipesan = "Berkas terpilih dibatalkan";

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("sop/formulir/$proses/$kode");
    }
}