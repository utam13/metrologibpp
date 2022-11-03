<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_kecamatan');
    }

    public function index($proses = 1, $kode = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Kecamatan & Kelurahan";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $no = 1;
        $daftar = $this->mod_kecamatan->kecamatan()->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdkecamatan'] = $d->kdkecamatan;
            $subrecord['nama'] = $d->nama;

            $no++;

            array_push($record, $subrecord);
        }

        $data['kecamatan'] = json_encode($record);

        if($kode != "" && $kode != "-"){
            $ambil = $this->mod_kecamatan->ambilkecamatan($kode);

            $data['kdkecamatan'] = $ambil['kdkecamatan'];
            $data['nama'] = $ambil['nama'];
        } else {
            $data['kdkecamatan'] = "";
            $data['nama'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman daftar kecamatan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/kecamatan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if ($proses != 3) {
            $kdkecamatan = $this->input->post('kode');
            $awal = $this->input->post('nama_awal');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));

            $cek_nama = $this->mod_kecamatan->cek_kecamatan($nama);
        }

        switch ($proses) {
            case 1:
                if ($cek_nama == 0) {
                    $this->mod_kecamatan->simpankecamatan($nama);

                    $pesan = 1;
                    $isipesan = "Daftar kecamatan baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama kecamatan sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_nama == 0)) {
                    $this->mod_kecamatan->ubahkecamatan($kdkecamatan,$nama);
                    $pesan = 2;
                    $isipesan = "Data kecamatan diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama kecamatan sudah terdaftar";
                }
                break;
            case 3:
                $this->mod_kecamatan->hapussemuakelurahan($kode);
                $this->mod_kecamatan->hapuskecamatan($kode);
                
                $pesan = 3;
                $isipesan = "Daftar kecamatan telah dikurangi beserta seluruh daftar kelurahan yang ada di bawah nya";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("kecamatan/index/1/-/$pesan/$msg");
    }

    public function kelurahan($kdkecamatan, $proses = 1, $kode = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Kecamatan & Kelurahan";

        $data['infoapp'] = $this->infoapp->info();

        $kecamatan = $this->mod_kecamatan->ambilkecamatan($kdkecamatan);
        $data['kdkecamatan'] = $kdkecamatan;
        $data['namakecamatan'] = $kecamatan['nama'];


        $data['proses'] = $proses;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $no = 1;
        $daftar = $this->mod_kecamatan->kelurahan($kdkecamatan)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdkelurahan'] = $d->kdkelurahan;
            $subrecord['kdkecamatan'] = $d->kdkecamatan;
            $subrecord['nama'] = $d->nama;

            $no++;

            array_push($record, $subrecord);
        }

        $data['kelurahan'] = json_encode($record);

        if($kode != "" && $kode != "-"){
            $ambil = $this->mod_kecamatan->ambilkelurahan($kode);

            $data['kdkelurahan'] = $ambil['kdkelurahan'];
            $data['nama'] = $ambil['nama'];
        } else {
            $data['kdkelurahan'] = "";
            $data['nama'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman daftar kelurahan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/kelurahan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proseskelurahan($proses = 1, $kecamatan = "", $kode = "")
    {
        if ($proses != 3) {
            $kdkelurahan = $this->input->post('kode');
            $kdkecamatan = $this->input->post('kdkecamatan');
            $awal = $this->input->post('nama_awal');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));

            $cek_nama = $this->mod_kecamatan->cek_kelurahan($nama);
        }

        switch ($proses) {
            case 1:
                if ($cek_nama == 0) {
                    $this->mod_kecamatan->simpankelurahan($kdkecamatan,$nama);

                    $pesan = 1;
                    $isipesan = "Daftar kelurahan baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama kelurahan sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_nama == 0)) {
                    $this->mod_kecamatan->ubahkelurahan($kdkelurahan,$nama);
                    $pesan = 2;
                    $isipesan = "Data kelurahan diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama kelurahan sudah terdaftar";
                }
                break;
            case 3:
                $kdkecamatan = $kecamatan;
                $this->mod_kecamatan->hapuskelurahan($kode);
                
                $pesan = 3;
                $isipesan = "Daftar kelurahan telah dikurangi";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("kecamatan/kelurahan/$kdkecamatan/1/-/$pesan/$msg");
    }
}