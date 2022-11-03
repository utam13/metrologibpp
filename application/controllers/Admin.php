<?
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_admin');
    }


    public function index()
    {
        $data['halaman'] = "Dashboard";

        $data['infoapp'] = $this->infoapp->info();

        $regbaru = $this->mod_admin->registrasi(0);
        $data['regbaru'] = number_format($regbaru,0,',','.');

        // $regdisetujui = $this->mod_admin->registrasi(1);
        // $data['regdisetujui'] =  number_format($regdisetujui,0,',','.');

        $permintaanbaru = $this->mod_admin->pengajuan(0);
        $data['permintaanbaru'] = number_format($permintaanbaru,0,',','.');

        $permintaanditerima = $this->mod_admin->pengajuan(1);
        $data['permintaanditerima'] =  number_format($permintaanditerima,0,',','.');

        $permintaanterjadwal = $this->mod_admin->pengajuan(2);
        $data['permintaanterjadwal'] =  number_format($permintaanterjadwal,0,',','.');

        $permintaanterbayar = $this->mod_admin->pengajuan(3);
        $data['permintaanterbayar'] =  number_format($permintaanterbayar,0,',','.');

        $permintaandiproses = $this->mod_admin->pengajuan(4);
        $data['permintaandiproses'] =  number_format($permintaandiproses,0,',','.');

        // $cekuploadfile = $this->mod_admin->uploadfile()->result();
        // foreach ($cekuploadfile as $c) {
        //     $cek_berkaspeserta = $this->mod_admin->cek_berkaspeserta($c->berkas);
        //     $file_berkas = "upload/pelayanan/" . $c->berkas;

        //     $cek_uttppeserta = $this->mod_admin->cek_uttppeserta($c->berkas);
        //     $file_berkasuttp = "upload/uttppeserta/" . $c->berkas;

        //     if (file_exists($file_berkas) && $cek_berkaspeserta == 0) {
        //         unlink("./upload/pelayanan/" . $c->berkas);
        //     } elseif (file_exists($file_berkasuttp)  && $cek_uttppeserta == 0) {
        //             unlink("./upload/uttppeserta/" . $c->berkas);
        //     }

        //     $clearupload = $this->mod_admin->clearupload($c->berkas);
        // }

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/dashboard');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }
}
