<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_pegawai');
    }

    public function index($page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Pegawai";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $q_cari = "";
        if ($getcari != "") {
            $q_cari = "(a.nip like '%$getcari%' or a.nama like '%$getcari%')";
        } else {
            $q_cari = "a.nip<>''";
        }

        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_pegawai->jumlah_data($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $pegawai = $this->mod_pegawai->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($pegawai as $p) {
            $subrecord['no'] = $no;
            $subrecord['kdpegawai'] = $p->kdpegawai;
            $subrecord['nip'] = $p->nip;
            $subrecord['nama'] = $p->nama;
            $subrecord['jabatan'] = $p->jabatan;
            $subrecord['password'] = $p->password;
            $subrecord['level'] = $p->level;

            if($p->level != 0){
                $subrecord['adaakses'] = "<i class='fa fa-key text-red' title='Diberi akses admin'></i>";
            } else {
                $subrecord['adaakses'] = "";
            }

            $no++;

            array_push($record, $subrecord);
        }
        $data['pegawai'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;
        //end

        //save log
        $this->log_lib->log_info("Akses halaman pegawai");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/pegawai');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "Pegawai";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        $data['listjabatan'] = $this->mod_pegawai->jabatan()->result();

        if($kode != ""){
            $ambil = $this->mod_pegawai->ambil($kode);

            $data['kdpegawai'] = $ambil['kdpegawai'];
            $data['nip'] = $ambil['nip'];
            $data['nama'] = $ambil['nama'];
            $data['jabatan'] = $ambil['jabatan'];
            $data['password'] = $ambil['password'];
            $data['level'] = $ambil['level'];
        } else {
            $data['kdpegawai'] = "";
            $data['nip'] = "";
            $data['nama'] = "";
            $data['jabatan'] = "";
            $data['password'] = "";
            $data['level'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir pegawai");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_pegawai');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if($proses != 3){
            $kdpegawai = $this->input->post('kode');
            $awal = $this->input->post('nip_awal');
            $nip = $this->input->post('nip');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));
            $jabatan = $this->input->post('jabatan');
            $password = $this->input->post('password');
            $level = $this->input->post('level');

            $cek_nip = $this->mod_pegawai->cek_nip($nip);

            $data = array(
                    "kdpegawai" => $kdpegawai,
                    "nip" => $nip,
                    "nama" => $nama,
                    "jabatan" => $jabatan,
                    "password" => $password,
                    "level" => $level
            );
        }

        switch ($proses) {
            case 1:
                if ($cek_nip == 0) {
                    $this->mod_pegawai->simpan($data);

                    $pesan = 1;
                    $isipesan = "Daftar pegawai baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "NIP pegawai sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nip  || ($awal != $nip && $cek_nip == 0)) {
                    $this->mod_pegawai->ubah($data);
                    $pesan = 2;
                    $isipesan = "Data pegawai diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "NIP pegawai sudah terdaftar";
                }
                break;
            case 3:
                $this->mod_pegawai->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Daftar pegawai telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("pegawai/index/1/20/-/$pesan/$msg");
    }

    public function jabatan($proses=1, $kode= "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Pegawai";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $no = 1;

        $jabatan = $this->mod_pegawai->jabatan()->result();

        $record = array();
        $subrecord = array();
        foreach ($jabatan as $j) {
            $subrecord['no'] = $no;
            $subrecord['kdjabatan'] = $j->kdjabatan;
            $subrecord['nama'] = $j->nama;

            $no++;

            array_push($record, $subrecord);
        }
        $data['jabatan'] = json_encode($record);

        if($kode != "" && $kode != "-"){
            $ambil = $this->mod_pegawai->ambiljabatan($kode);

            $data['kdjabatan'] = $ambil['kdjabatan'];
            $data['nama'] = $ambil['nama'];
        } else {
            $data['kdjabatan'] = "";
            $data['nama'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman jabatan pegawai");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/jabatan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function prosesjabatan($proses = 1, $kode = "")
    {
        if($proses != 3){
            $kdjabatan = $this->input->post('kode');
            $awal = $this->input->post('nama_awal');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));

            $cek_jabatan = $this->mod_pegawai->cek_jabatan($nama);

            $data = array(
                    "kdjabatan" => $kdjabatan,
                    "nama" => $nama
            );
        }

        switch ($proses) {
            case 1:
                if ($cek_jabatan == 0) {
                    $this->mod_pegawai->simpanjabatan($data);

                    $pesan = 1;
                    $isipesan = "Daftar jabatan baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama jabatan sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_jabatan == 0)) {
                    $this->mod_pegawai->ubahjabatan($data);
                    $pesan = 2;
                    $isipesan = "Data jabatan diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama jabatan sudah terdaftar";
                }
                break;
            case 3:
                $this->mod_pegawai->hapusjabatan($kode);
                
                $pesan = 3;
                $isipesan = "Daftar jabatan telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("pegawai/jabatan/1/-/$pesan/$msg");
    }

    public function struktur()
    {
        $data['halaman'] = "Pegawai";

        $data['infoapp'] = $this->infoapp->info();

        $ambil = $this->mod_pegawai->ambilstruktur();

        if ($ambil['berkas'] != "") {
            $berkas = "upload/struktur/" . $ambil['berkas'];
            if (file_exists($berkas)) {
                $data['file_berkas'] = base_url() . "upload/struktur/" . $ambil['berkas'] . "?" . rand();
            } else {
                $data['file_berkas'] = base_url() . "upload/no-image.png";
            }
        } else {
            $data['file_berkas'] = base_url() . "upload/no-image.png";
        }

        //save log
        $this->log_lib->log_info("Akses halaman jabatan pegawai");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/struktur');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function upload()
    {
        $config['upload_path']        = './upload/struktur';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp';
        $config['file_name']        = "struktur";
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);
            $this->mod_pegawai->hapusstruktur();
            $this->mod_pegawai->ubahstruktur($file_name);

            echo $file_name;
        }
    }

    public function ubahpassword($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Ubah Password";

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $data['kdpegawai'] = $this->session->userdata('kduser');

        //save log
        $this->log_lib->log_info("Akses halaman ubah password");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/ubahpassword');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function prosesubahpassword()
    {
        $kdpegawai = $this->input->post('kode');
        $nip = $this->input->post('nip');
        $lama = $this->input->post('passwordlama');
        $baru = $this->input->post('password');

        $cek_nip = $this->mod_pegawai->cek_nip2($kdpegawai,$nip);

        $cek_passlama = $this->mod_pegawai->cek_passlama($kdpegawai,$nip,$lama);

        if ($cek_nip != 0) {
            $this->mod_pegawai->ubahpassword($kdpegawai,$baru);

            $pesan = 1;
            $isipesan = "Password Anda diubah, pastikan Anda telah mencatatnya";
        } else {
            $pesan = 4;

            if($cek_nip == 0){
                $isipesan = "NIP Anda tidak sesuai";
            } elseif($cek_passlama == 0) {
                $isipesan = "Password Lama Anda tidak sesuai, jika Anda mengalami kesulitan silakan hubungi Admin Aplikasi";
            } else {
                $isipesan = "Data tidak ditemukan";
            }
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("pegawai/ubahpassword/$pesan/$msg");
    }
}