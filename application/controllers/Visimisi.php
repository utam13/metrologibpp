<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visimisi extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_visimisi');
    }

    public function index($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Visi & Misi";

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $visimisi = $this->mod_visimisi->visimisi();
        $data['visi'] = empty($visimisi) ? '' : $visimisi['visi'];
        $data['misi'] = empty($visimisi) ? '' : $visimisi['misi'];

        //save log
        $this->log_lib->log_info("Akses halaman visi dan misi");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/visimisi');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses()
    {
        $visi = $this->input->post('visi');
        $misi = $this->input->post('misi');
        
        $this->mod_visimisi->hapus();
        $this->mod_visimisi->ubah($visi,$misi);
        
        $pesan = 2;
        $isipesan = "Isi kontent visi dan misi diupdate";

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("visimisi/index/$pesan/$msg");
    }
}