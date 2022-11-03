<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_layanan');
    }

    public function index($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Layanan";

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $no = 1;

        $daftar = $this->mod_layanan->daftar()->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdlayanan'] = $d->kdlayanan;
            $subrecord['nama'] = $d->nama;
            $subrecord['uraian'] = $d->uraian;

            $no++;

            array_push($record, $subrecord);
        }

        $data['layanan'] = json_encode($record);

        //save log
        $this->log_lib->log_info("Akses halaman daftar layanan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/layanan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "Layanan";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        if($kode != ""){
            $ambil = $this->mod_layanan->ambil($kode);

            $data['kdlayanan'] = $ambil['kdlayanan'];
            $data['nama'] = $ambil['nama'];
            $data['uraian'] = $ambil['uraian'];
        } else {
            $data['kdlayanan'] = "";
            $data['nama'] = "";
            $data['uraian'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir layanan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_layanan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if ($proses != 3) {
            $kdlayanan = $this->input->post('kode');
            $awal = $this->input->post('nama_awal');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));
            $uraian = $this->clear_string->clear_quotes($this->input->post('uraian'));

            $cek_nama = $this->mod_layanan->cek_nama($nama);
        }

        switch ($proses) {
            case 1:
                if ($cek_nama == 0) {
                    $this->mod_layanan->simpan($nama,$uraian);
                    $pesan = 1;
                    $isipesan = "Daftar layanan baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama layanan sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_nama == 0)) {
                    $this->mod_layanan->ubah($kdlayanan,$nama,$uraian);
                    $pesan = 2;
                    $isipesan = "Daftar layanan diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama layanan sudah terdaftar";
                }
                break;
            case 3:
                $this->mod_layanan->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Daftar layanan telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("layanan/index/$pesan/$msg");
    }
}