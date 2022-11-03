<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tentang extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_tentang');
    }

    public function index($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Tentang Kami";

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $tentang = $this->mod_tentang->tentang();
        $data['singkat'] = empty($tentang) ? '' : $tentang['singkat'];
        $data['isi'] = empty($tentang) ? '' : $tentang['isitentang'];

        //save log
        $this->log_lib->log_info("Akses halaman informasi tentang kami");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/tentang');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses()
    {
        $singkat = $this->input->post('singkat');
        $isi = $this->input->post('isi');
        
        $this->mod_tentang->hapus();
        $this->mod_tentang->ubah($singkat,$isi);
        
        $pesan = 2;
        $isipesan = "Isi kontent tentang kami diupdate";

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("tentang/index/$pesan/$msg");
    }
}