<?
defined('BASEPATH') or exit('No direct script access allowed');

class Slide extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_slide');
    }


    public function index()
    {
        $data['halaman'] = "Slide";

        $data['infoapp'] = $this->infoapp->info();

        $slide_1 = $this->mod_slide->slide(1);

        $data['kode_1'] = empty($slide_1) ? "-" : $slide_1['kdslide'];
        $data['gambar_1'] =empty($slide_1) ? "-" :  $slide_1['gambar'];

        if ($data['gambar_1'] == "") {
            $data['gambar_slide_1'] = date('dmYhis');
            $data['file_slide_1'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/slide/" . $data['gambar_1'];
            if (file_exists($file_target)) {
                $data['gambar_slide_1'] = $data['gambar_1'];
                $data['file_slide_1'] = base_url() . "upload/slide/" . $data['gambar_1'];
            } else {
                $data['gambar_slide_1'] = date('dmYhis');
                $data['file_slide_1'] = base_url() . "upload/no-image.png";
            }
        }
        
        $slide_2 = $this->mod_slide->slide(2);

        $data['kode_2'] = empty($slide_2) ? "-" : $slide_2['kdslide'];
        $data['gambar_2'] =empty($slide_2) ? "-" :  $slide_2['gambar'];

        if ($data['gambar_2'] == "") {
            $data['gambar_slide_2'] = date('dmYhis');
            $data['file_slide_2'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/slide/" . $data['gambar_2'];
            if (file_exists($file_target)) {
                $data['gambar_slide_2'] = $data['gambar_2'];
                $data['file_slide_2'] = base_url() . "upload/slide/" . $data['gambar_2'];
            } else {
                $data['gambar_slide_2'] = date('dmYhis');
                $data['file_slide_2'] = base_url() . "upload/no-image.png";
            }
        }

        $slide_3 = $this->mod_slide->slide(3);

        $data['kode_3'] = empty($slide_3) ? "-" : $slide_3['kdslide'];
        $data['gambar_3'] =empty($slide_3) ? "-" :  $slide_3['gambar'];

        if ($data['gambar_3'] == "") {
            $data['gambar_slide_3'] = date('dmYhis');
            $data['file_slide_3'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/slide/" . $data['gambar_3'];
            if (file_exists($file_target)) {
                $data['gambar_slide_3'] = $data['gambar_3'];
                $data['file_slide_3'] = base_url() . "upload/slide/" . $data['gambar_3'];
            } else {
                $data['gambar_slide_3'] = date('dmYhis');
                $data['file_slide_3'] = base_url() . "upload/no-image.png";
            }
        }

        $slide_4 = $this->mod_slide->slide(4);

        $data['kode_4'] = empty($slide_4) ? "-" : $slide_4['kdslide'];
        $data['gambar_4'] =empty($slide_4) ? "-" :  $slide_4['gambar'];

        if ($data['gambar_4'] == "") {
            $data['gambar_slide_4'] = date('dmYhis');
            $data['file_slide_4'] = base_url() . "upload/no-image.png";
        } else {
            $file_target = "upload/slide/" . $data['gambar_4'];
            if (file_exists($file_target)) {
                $data['gambar_slide_4'] = $data['gambar_4'];
                $data['file_slide_4'] = base_url() . "upload/slide/" . $data['gambar_4'];
            } else {
                $data['gambar_slide_4'] = date('dmYhis');
                $data['file_slide_4'] = base_url() . "upload/no-image.png";
            }
        }

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/slide');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function upload($no)
    {
        $config['upload_path']        = './upload/slide';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp';
        $config['file_name']        = "slide_".$no;
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);

            $this->mod_slide->hapus($no);
            $this->mod_slide->ubah($no,$file_name);

            echo $file_name;
        }
    }
}
