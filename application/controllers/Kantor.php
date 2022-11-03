<?
defined('BASEPATH') or exit('No direct script access allowed');

class Kantor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_kantor');
    }


    public function index($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Kantor";

        $data['infoapp'] = $this->infoapp->info();

        $data['alert'] = $this->alert_lib->alert($pesan, $isipesan);

        $kantor = $this->mod_kantor->kantor();
        $data['nama'] = empty($kantor) ? "-" : html_entity_decode($kantor['nama']);
        $data['alamat'] = empty($kantor) ? "-" : $kantor['alamat'];
        $data['telp'] = empty($kantor) ? "-" : $kantor['telp'];
        $data['wa'] = empty($kantor) ? "-" : $kantor['wa'];
        $data['email'] = empty($kantor) ? "-" : $kantor['email'];
        $data['web'] = empty($kantor) ? "-" : $kantor['web'];
        $data['waktuaktif'] = empty($kantor) ? "-" : $kantor['waktuaktif'];
        $data['googlemap'] = empty($kantor) ? "-" : $kantor['googlemap'];
        $data['ig'] = empty($kantor) ? "-" : $kantor['ig'];
        $data['fb'] = empty($kantor) ? "-" : $kantor['fb'];
        $data['youtube'] = empty($kantor) ? "-" : $kantor['youtube'];
        $data['logo'] = empty($kantor) ? "-" : $kantor['logo'];

        if ($data['logo'] == "") {
            $data['gambar_logo'] = "logoapp";
            $data['file_gambar_logo'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/logo/" . $data['logo'];
            if (file_exists($file_target)) {
                $data['gambar_logo'] = $data['logo'];
                $data['file_gambar_logo'] = base_url() . "upload/logo/" . $data['logo'];
            } else {
                $data['gambar_logo'] = "logoapp";
                $data['file_gambar_logo'] = base_url() . "upload/no-image.png";
            }
        }

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/kantor');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function upload()
    {
        $config['upload_path']        = './upload/logo';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp';
        $config['file_name']        = "logo";
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);

            $this->mod_kantor->update_logo($file_name);

            echo $file_name;
        }
    }

    public function proses()
    {
        $nama =  $this->clear_string->clear_quotes(ucwords($this->input->post('nama')));
        $alamat = $this->clear_string->clear_quotes($this->input->post('alamat'));
        $email = $this->input->post('email');
        $telp = $this->input->post('telp');
        $wa = $this->input->post('wa');
        $web = $this->input->post('website');
        $waktuaktif = $this->input->post('waktuaktif');
        $ig = $this->input->post('ig');
        $fb = $this->input->post('fb');
        $youtube = $this->input->post('youtube');
        $googlemap = $this->input->post('googlemap');

        $data = array(
            "nama" => $nama,
            "alamat" => $alamat,
            "telp" => $telp,
            "wa" => $wa,
            "email" => $email,
            "web" => $web,
            "waktuaktif" => $waktuaktif,
            "ig" => $ig,
            "fb" => $fb,
            "youtube" => $youtube,
            "googlemap" => $googlemap
        );

        $this->mod_kantor->ubah($data);
        $pesan = 2;
        $isipesan = "Informasi kantor diubah";

        redirect("kantor/index/$pesan/$isipesan");
    }
}
