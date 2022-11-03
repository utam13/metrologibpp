<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bataslayanan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_bataslayanan');
    }

    public function index($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Maks. Waktu Layanan Per-Hari";

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $bataslayanan = $this->mod_bataslayanan->batas();
        $data['lama'] = empty($bataslayanan) ? 0 : $bataslayanan['lama'];

        //save log
        $this->log_lib->log_info("Akses halaman batas layanan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/bataslayanan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses()
    {
        $lama = $this->input->post('lama');

        $this->mod_bataslayanan->hapus();
        $this->mod_bataslayanan->simpan($lama);
        
        $pesan = 2;
        $isipesan = "Maks. Waktu layanan per-hari telah diatur ulang";

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("bataslayanan/index/$pesan/$msg");
    }
}