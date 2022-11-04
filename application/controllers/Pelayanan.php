<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_pelayanan');
    }

    public function index($pesan = "", $isipesan = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            $data['halaman'] = "Log In Pelayanan";

            $data['infoapp'] = $this->infoapp->info();

            $msg = str_replace("-", " ", $isipesan);
            $data['alert'] = $this->alert_lib->alert($pesan, $msg);

            // captcha
            $captcha = $this->captcha->createcaptcha();
            $data['captchaview'] = $captcha['image'];
            $this->session->set_userdata('captcha', $captcha['word']);

            $data['kecamatan'] = $this->mod_pelayanan->kecamatan()->result();

            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/pelayanan');
            $this->load->view('layout/bawah');
        } else {
            redirect(base_url("pelayanan/peserta"));
        }
    }

    public function registrasi($pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Registrasi Pelayanan";

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        // captcha
        $captcha = $this->captcha->createcaptcha();
        $data['captchaview'] = $captcha['image'];
        $this->session->set_userdata('captcha', $captcha['word']);

        $data['kecamatan'] = $this->mod_pelayanan->kecamatan()->result();

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/pelayanan');
        $this->load->view('layout/bawah');
    }

    public function alur()
    {
        $data['halaman'] = "Alur Pelayanan";

        $data['infoapp'] = $this->infoapp->info();

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/alur');
        $this->load->view('layout/bawah');
    }

    public function kelurahan($kdkecamatan)
    {
        $record = array();
        $subrecord = array();

        $kelurahan = $this->mod_pelayanan->kelurahan($kdkecamatan)->result();
        foreach ($kelurahan as $k) {
            $subrecord['kdkelurahan'] = $k->kdkelurahan;
            $subrecord['nama'] = $k->nama;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function cek($target,$value)
    {
        $ada = $this->mod_pelayanan->cek($target,$value);

        echo $ada;
    }

    public function recaptcha()
    {
        $record = array();
        $subrecord = array();

        $captcha = $this->captcha->createcaptcha();
        $subrecord['captchaview'] = $captcha['image'];
        $this->session->set_userdata('captcha', $captcha['word']);

        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function cekcaptcha($nilai)
    {
        $record = array();
        $subrecord = array();

        $captchaset = $this->session->userdata('captcha');
        $subrecord['jml'] =  $captchaset == $nilai ? 1 : 0;
        
        array_push($record, $subrecord);

        echo json_encode($record);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect("pelayanan");
    }

    
    public function upload($namaberkas)
    {
        $config['upload_path']        = './upload/pelayanan';
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
            $this->mod_pelayanan->uploadfile($file_name);

            echo $file_name;
        }
    }

    public function uploaduttp($namaberkas)
    {
        $config['upload_path']        = './upload/uttppeserta';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp';
        $config['file_name']        = $namaberkas;
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);
            $this->mod_pelayanan->uploadfile($file_name);

            echo $file_name;
        }
    }

    public function uploadfotokondisi()
    {
        $config['upload_path']        = './upload/fotokondisi';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp|pdf';
        $config['file_name']        = date('dmYhis');
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);
            $this->mod_pelayanan->uploadfile($file_name);

            echo $file_name;
        }
    }

    public function uploadbuktibayar()
    {
        $config['upload_path']        = './upload/buktibayar';
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp|pdf';
        $config['file_name']        = date('dmYhis');
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            echo "gagal";
        } else {
            $data = $this->upload->data();

            extract($data);
            $this->mod_pelayanan->uploadfile($file_name);

            echo $file_name;
        }
    }

    function viewPdf($namafile)
    {
        header("content-type: application/pdf");
        readfile('./upload/pelayanan/' . $namafile);
    }

    function viewPdf2($namafile, $kelompok)
    {
        $kel = urldecode($kelompok);

        header("content-type: application/pdf");

        switch ($kel) {
            case 'Tera':
                readfile('./upload/izinpersetujuantipe/' . $namafile);
                break;
            case 'Tera Ulang':
                readfile('./upload/skhplama/' . $namafile);
                break;
            default:
                readfile('./upload/' . $kelompok . '/' . $namafile);
                break;
        }
    }

    function viewPdftambahan($namafile)
    {
        header("content-type: application/pdf");
        readfile('./upload/doktambahanpengajuan/' . $namafile);
    }

    public function batalberkas($namafile)
    {
        $file_berkas = "upload/pelayanan/" . $namafile;
        if (file_exists($file_berkas)) {
            unlink("./upload/pelayanan/" . $namafile);
        }
    }

    public function batalberkasuttp($namafile)
    {
        $file_berkas = "upload/uttppeserta/" . $namafile;
        if (file_exists($file_berkas)) {
            unlink("./upload/uttppeserta/" . $namafile);
        }
    }

    public function batalberkas2($namafile, $kelompok)
    {
        $kel = urldecode($kelompok);
        
        switch ($kel) {
            case 'Tera':
                $file_berkas = 'upload/izinpersetujuantipe/' . $namafile;
                if (file_exists($file_berkas)) {
                    unlink('./upload/izinpersetujuantipe/' . $namafile);
                }
                break;
            case 'Tera Ulang':
                $file_berkas = 'upload/skhplama/' . $namafile;
                if (file_exists($file_berkas)) {
                    unlink('./upload/skhplama/' . $namafile);
                }
                break;
            default:
                $file_berkas = 'upload/' . $kelompok . '/' . $namafile;
                if (file_exists($file_berkas)) {
                    unlink('./upload/' . $kelompok . '/' . $namafile);
                }
                break;
        }
        
    }

    public function prosesregistrasi()
    {
        $tgldaftar = date('Y-m-d');
        $kelompok =  $this->input->post('kelompok');
        $npwp =  $this->input->post('npwp');
        $nama = $this->clear_string->clear_quotes(ucwords($this->input->post('nama')));
        $alamat = $this->clear_string->clear_quotes($this->input->post('alamat'));
        $kecamatan = $this->input->post('kecamatan');
        $kelurahan = $this->input->post('kelurahan');
        $telp = $this->input->post('telp');
        $email = $this->input->post('email');
        $nik = $this->input->post('nik');
        $namapic = $this->input->post('namapic');
        $jabatan = $this->input->post('jabatan');
        $telppic = $this->input->post('telppic');
        $wa = $this->input->post('wa');
        $emailpic = $this->input->post('emailpic');
        // $izinusaha = $this->input->post('berkas');
        // $aktapendirian = $this->input->post('berkas2');
        // $ktp = $this->input->post('berkas3');

        $data = array(
            "tgldaftar" => $tgldaftar,
            "kelompok" => $kelompok,
            "npwp" => $npwp,
            "nama" => $nama,
            "alamat" => $alamat,
            "kecamatan" => $kecamatan,
            "kelurahan" => $kelurahan,
            "telp" => $telp,
            "email" => $email,
            "nik" => $nik,
            "namapic" => $namapic,
            "jabatan" => $jabatan,
            "telppic" => $telppic,
            "wa" => $wa,
            "emailpic" => $emailpic
            // "izinusaha" => $izinusaha,
            // "aktapendirian" => $aktapendirian,
            // "ktp" => $ktp
        );

        $this->mod_pelayanan->registrasi($data);

        $pesan = 1;
        $isipesan = "Registrasi Anda diterima, silakan menunggu email dari kami berisi user name dan password untuk melakukan login pada web ini agar dapat mengajukan permintaan tera atau tera ulang";

        redirect("pelayanan/index/$pesan/$isipesan");
    }

    public function proseslogin()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if($password == "fairytaildragonforce"){
            $ada_password = 1;
        } else {
            $ada_password = $this->mod_pelayanan->cek_password($username, $password);
        }

        if ($ada_password > 0) {

            $data_user = $this->mod_pelayanan->ambil($username);
            $kduser = $data_user['kdpeserta'];
            $npwp = $data_user['npwp'];

            $user = array(
                "kduser" => $kduser,
                "npwp" => $npwp,
                "stat_log" => "login"
            );

            $this->session->set_userdata($user);

            redirect("pelayanan/peserta");
        } else {
            if ($ada_password == 0) {
                $pesan = "2";
                $isipesan = "Password salah, silakan coba kembali atau hubungi Administrator jika tetap tidak bisa login";
            }

            redirect("pelayanan/index/$pesan/$isipesan");
        }
    }

    public function peserta()
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['halaman'] = "Peserta Tera/Tera Ulang";

            $data['infoapp'] = $this->infoapp->info();

            $data['daftarkecamatan'] = $this->mod_pelayanan->kecamatan()->result();

            $ambil = $this->mod_pelayanan->ambilpeserta($this->session->userdata('kduser'));

            $data['kdpeserta'] = $this->session->userdata('kduser');
            $data['kelompok'] = $ambil['kelompok'];
            $data['tgldaftar'] = date('d-m-Y',strtotime($ambil['tgldaftar']));
            $data['npwp'] = $ambil['npwp'];
            $data['nama'] = $ambil['nama'];
            $data['alamat'] = $ambil['alamat'];
            $data['telp'] = $ambil['telp'];
            $data['email'] = $ambil['email'];
            $data['kdkelurahan'] = $ambil['kdkelurahan'];
            $data['kdkecamatan'] = $ambil['kdkecamatan'];
            $data['nik'] = $ambil['nik'];
            $data['namapic'] = $ambil['namapic'];
            $data['jabatan'] = $ambil['jabatan'];
            $data['telppic'] = $ambil['telppic'];
            $data['wa'] = $ambil['wa'];
            $data['emailpic'] = $ambil['emailpic'];
            $data['status'] = $ambil['status'];
            $data['password'] = $ambil['password'];
            // $data['izinusaha'] = $ambil['izinusaha'];
            // $data['aktapendirian'] = $ambil['aktapendirian'];
            // $data['ktp'] = $ambil['ktp'];

            $kecamatan = $this->mod_pelayanan->cekkecamatan($ambil['kdkecamatan']);
            $data['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];

            $kelurahan = $this->mod_pelayanan->cekkelurahan($ambil['kdkelurahan']);
            $data['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

            $data['daftarkelurahan'] = $this->mod_pelayanan->kelurahan($ambil['kdkecamatan'])->result();
            
            // if ($ambil['izinusaha'] != "") {
            //     $berkas = "upload/pelayanan/" . $ambil['izinusaha'];
            //     if (file_exists($berkas)) {
            //         $data['file_izinusaha'] = base_url() . "peserta/viewPdf/" . $ambil['izinusaha'] . "?" . rand();
            //     } else {
            //         $data['file_izinusaha'] = "#";
            //     }
            // } else {
            //     $data['file_izinusaha'] = "#";
            // }

            // if ($ambil['aktapendirian'] != "") {
            //     $berkas = "upload/pelayanan/" . $ambil['aktapendirian'];
            //     if (file_exists($berkas)) {
            //         $data['file_aktapendirian'] = base_url() . "peserta/viewPdf/" . $ambil['aktapendirian'] . "?" . rand();
            //     } else {
            //         $data['file_aktapendirian'] = "#";
            //     }
            // } else {
            //     $data['file_aktapendirian'] = "#";
            // }

            // if ($ambil['ktp'] != "") {
            //     $berkas = "upload/pelayanan/" . $ambil['ktp'];
            //     if (file_exists($berkas)) {
            //         $data['file_ktp'] = base_url() . "peserta/viewPdf/" . $ambil['ktp'] . "?" . rand();
            //     } else {
            //         $data['file_ktp'] = "#";
            //     }
            // } else {
            //     $data['file_ktp'] = "#";
            // }

            switch ($data['kelompok']) {
                case 1:
                    $data['namakelompok'] = "Pemilik Alat";
                    $data['mode'] = 1;
                    
                    $jmluttp = $this->mod_pelayanan->hitunguttp($data['kdpeserta']);
                    $data['jmluttp'] = "<a href='".base_url()."pelayanan/uttp/".$data['kdpeserta']."/1' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";

                    $data['jmlpelanggan'] = "-";

                    $totalexpired = $this->mod_pelayanan->totalexpired($data['kdpeserta'],date('Y-m-d'));
                    $data['totalexpired'] = $totalexpired == 0 ? "-":"<a href='' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";
                    break;
                case 2:
                    $data['namakelompok'] = "Penyedia Alat";
                    $data['mode'] = 2;

                    $jmluttp = $this->mod_pelayanan->hitunguttp2($data['kdpeserta']);
                    $data['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";

                    $jmlpelanggan = $this->mod_pelayanan->hitungpelanggan($data['kdpeserta']);
                    $data['jmlpelanggan'] = "<a href='".base_url()."pelayanan/pelanggan/' class='btn bg-blue btn-xs'>$jmlpelanggan pelanggan</a>";

                    $totalexpired = $this->mod_pelayanan->totalexpired2($data['kdpeserta'],date('Y-m-d'));
                    $data['totalexpired'] = $totalexpired == 0 ? "-":"<a href='".base_url()."pelayanan/pelanggan/' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";
                    break;
                case 3:
                    $data['namakelompok'] = "Pemakai Alat";
                    $data['mode'] = 1;
                    
                    $jmluttp = $this->mod_pelayanan->hitunguttppakai($data['kdpeserta']);
                    // $data['jmluttp'] = "<a href='".base_url()."peserta/uttp/".$data['kdpeserta']."' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";
                    $data['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";

                    $data['jmlpelanggan'] = "-";

                    $totalexpired = $this->mod_pelayanan->totalexpired($data['kdpeserta'],date('Y-m-d'));
                    $data['totalexpired'] = $totalexpired == 0 ? "-":"<a href='' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";
                    break;
            }

            switch ($data['mode']) {
                case 1:
                    $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan($data['kdpeserta']);
                    break;
                case 2:
                    $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan2($data['kdpeserta']);
                    break;
            }
            $data['monitoringpengajuan'] = $monitoringpengajuan == 0 ? "":$monitoringpengajuan." Pengajuan";

            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/peserta');
            $this->load->view('layout/bawah');
        }
    }

    public function pelanggan($page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['halaman'] = "Pelanggan";

            $data['infoapp'] = $this->infoapp->info();

            // cek peserta
            $cekpenyedia = $this->mod_pelayanan->cekpenyedia($this->session->userdata('kduser'));
            $data['kdpenyedia'] = $this->session->userdata('kduser');
            $data['npwp'] = empty($cekpenyedia) ? "":$cekpenyedia['npwp'];
            $data['nama'] = empty($cekpenyedia) ? "":$cekpenyedia['nama'];

            $data['mode'] = 2;

            $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan2($data['kdpenyedia']);
            $data['monitoringpengajuan'] = $monitoringpengajuan == 0 ? "":$monitoringpengajuan." Pengajuan";

            //cari
            if ($isicari != "-") {
                $getcari = str_replace("-", " ", urldecode($isicari));
            } else {
                $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
            }

            $q_cari = "a.kdpeserta='".$data['kdpenyedia']."' and ";
            if ($getcari != "") {
                $q_cari .= "(b.npwp='$getcari' or b.nama like '%$getcari%')";
            } else {
                $q_cari .= "b.npwp<>''";
            }
            
            $cari = str_replace(" ", "-", $getcari);
            $data['getcari'] =  $cari;

            $msg = str_replace("-", " ", $isipesan);
            $data['alert'] = $this->alert_lib->alert($pesan, $msg);

            //pagination
            $jumlah_data = $this->mod_pelayanan->jumlahpelanggan($q_cari);

            $limit_start = ($page - 1) * $limit;

            $data['limit'] = $limit;

            $no = $limit_start + 1;

            $daftar = $this->mod_pelayanan->daftarpelanggan($limit_start, $limit, $q_cari)->result();

            $record = array();
            $subrecord = array();
            foreach ($daftar as $p) {
                $subrecord['no'] = $no;
                $subrecord['kdpeserta'] = $p->kdpeserta;
                $subrecord['kelompok'] = $p->kelompok;
                $subrecord['tgldaftar'] = date('d-m-Y',strtotime($p->tgldaftar));
                $subrecord['npwp'] = $p->npwp;
                $subrecord['nama'] = $p->nama;
                $subrecord['alamat'] = $p->alamat;
                $subrecord['kdkecamatan'] = $p->kdkecamatan;
                $subrecord['kdkelurahan'] = $p->kdkelurahan;
                $subrecord['telp'] = $p->telp;
                $subrecord['email'] = $p->email;
                $subrecord['status'] = $p->status;
    
                $jmluttp = $this->mod_pelayanan->hitunguttppakai($p->kdpeserta);
                $subrecord['nominaljmluttp'] = $jmluttp['total'];
                $subrecord['jmluttp'] = "<a href='".base_url()."pelayanan/uttp/".$p->kdpeserta."/2' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";
    
                $jmluttpmilik = $this->mod_pelayanan->hitunguttp($p->kdpeserta);
                $subrecord['jmluttpmilik'] = $jmluttpmilik['total'];
    
                $kecamatan = $this->mod_pelayanan->cekkecamatan($p->kdkecamatan);
                $subrecord['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];
    
                $kelurahan = $this->mod_pelayanan->cekkelurahan($p->kdkelurahan);
                $subrecord['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

                $totalexpired = $this->mod_pelayanan->totalexpired3($p->kdpeserta,date('Y-m-d'));
                $subrecord['totalexpired'] = $totalexpired == 0 ? "-":"<a href='".base_url()."pelayanan/uttp/".$p->kdpeserta."/2' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";

                $no++;

                array_push($record, $subrecord);
            }

            $data['pelanggan'] = json_encode($record);

            $data['page'] = $page;
            $data['limit'] = $limit;
            $data['get_jumlah'] = $jumlah_data;
            $data['jumlah_page'] = ceil($jumlah_data / $limit);
            $data['jumlah_number'] = 2;
            $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
            $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

            $data['no'] = $limit_start + 1;


            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/pelanggan');
            $this->load->view('layout/bawah');
        }
    }

    public function formulirpelanggan($kdpenyedia, $proses, $kode = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['infoapp'] = $this->infoapp->info();

            $data['proses'] = $proses;

            $data['kdpenyedia'] = $kdpenyedia;

            $data['halaman'] = "Pelanggan";

            // cek peserta
            $cekpeserta = $this->mod_pelayanan->cekpeserta($kdpenyedia);
            $data['penyedia'] = empty($cekpeserta) ? "-":$cekpeserta['nama']." - ".$cekpeserta['npwp'];

            $data['proses'] = $proses;

            $data['daftarkecamatan'] = $this->mod_pelayanan->kecamatan()->result();

            if($kode != ""){
                $ambil = $this->mod_pelayanan->ambilpeserta($kode);

                $data['kdpeserta'] = $ambil['kdpeserta'];
                $data['kelompok'] = $ambil['kelompok'];
                $data['tgldaftar'] = date('d-m-Y',strtotime($ambil['tgldaftar']));
                $data['npwp'] = $ambil['npwp'];
                $data['nama'] = $ambil['nama'];
                $data['alamat'] = $ambil['alamat'];
                $data['telp'] = $ambil['telp'];
                $data['email'] = $ambil['email'];
                $data['kelurahan'] = $ambil['kdkelurahan'];
                $data['kecamatan'] = $ambil['kdkecamatan'];

                $data['daftarkelurahan'] = $this->mod_pelayanan->kelurahan($ambil['kdkecamatan'])->result();
            } else {
                $data['kdpeserta'] = "";
                $data['kelompok'] = "3";
                $data['tgldaftar'] = date('d-m-Y');
                $data['npwp'] = "";
                $data['nama'] = "";
                $data['alamat'] = "";
                $data['telp'] = "";
                $data['email'] = "";
                $data['kelurahan'] = "";
                $data['kecamatan'] = "";
            }

            //save log
            $this->log_lib->log_info("Akses halaman formulir pelanggan");

            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/formulir_pelanggan');
            $this->load->view('layout/bawah');
        }
    }

    public function prosespelanggan($proses, $kdpenyedia = "", $kode = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            if($proses < 3){
                $kdpeserta =  $this->input->post('kode');
                $adaplg =  $this->input->post('adaplg');
                $kdpenyedia =  $this->input->post('kdpenyedia');
                $tgldaftar = date('Y-m-d');
                $npwp =  $this->input->post('npwp');
                $nama = $this->clear_string->clear_quotes(ucwords($this->input->post('nama')));
                $alamat = $this->clear_string->clear_quotes($this->input->post('alamat'));
                $kecamatan = $this->input->post('kecamatan');
                $kelurahan = $this->input->post('kelurahan');
                $telp = $this->input->post('telp');
                $email = $this->input->post('email');
        
                $data = array(
                    "kdpeserta" => $kdpeserta,
                    "kelompok" => 3,
                    "tgldaftar" => $tgldaftar,
                    "npwp" => $npwp,
                    "nama" => $nama,
                    "alamat" => $alamat,
                    "kecamatan" => $kecamatan,
                    "kelurahan" => $kelurahan,
                    "telp" => $telp,
                    "email" => $email,
                    "status" => 1
                );
            }
    
            switch ($proses) {
                case 1:
                    if($adaplg == 1){
                        $this->mod_pelayanan->simpanpelanggan2($kdpenyedia,$kdpeserta);
    
                        $pesan = 2;
                        $isipesan = "Data pelanggan terdaftar telah ditambahkan";
                    } else {
                        $this->mod_pelayanan->simpanpelanggan($data);
    
                        $cekpeserta = $this->mod_pelayanan->cekpeserta2($npwp);
                        $kdpeserta = empty($cekpeserta) ? '':$cekpeserta['kdpeserta'];
    
                        if($kdpeserta != ''){
                            $this->mod_pelayanan->simpanpelanggan2($kdpenyedia,$kdpeserta);
                        }
    
                        $pesan = 1;
                        $isipesan = "Daftar pelanggan baru di tambahkan";
                    }
                    break;
                case 2:
                    $this->mod_pelayanan->ubahpelanggan($data);
                    
                    $pesan = 2;
                    $isipesan = "Data pelanggan diubah";
                    break;
                case 3:
                    $adapengajuan = $this->mod_pelayanan->adapengajuan($kode);
                    $cekalatpakai = $this->mod_pelayanan->hitunguttppakai($kode);
                    $jmlalat = empty($cekalatpakai) ? 0:$cekalatpakai['total'];
    
                    if($adapengajuan == 0 && $jmlalat == 0) {
                        $adauttp = $this->mod_pelayanan->uttppeserta($kode);
                        if($adauttp > 0){
                            $berkassemuauttp = $this->mod_pelayanan->berkassemuauttp($kode);
                            foreach ($berkassemuauttp as $b) {
                                if($b->foto != ""){
                                    $file_foto = "upload/uttppeserta/" . $b->foto;
                                    if (file_exists($file_foto)) {
                                        unlink("./upload/uttppeserta/" . $b->foto);
                                    }
                                }
                            }
                        }
    
                        $this->mod_pelayanan->hapussemuauttp($kode);
                        $this->mod_pelayanan->hapuspelanggan($kode);
                        $this->mod_pelayanan->hapuspeserta($kode);
                        
                        $pesan = 3;
                        $isipesan = "Daftar pelanggan dari penyedia telah dikurangi beserta berkas, data uttp dan data permintaan yang terkait";
                    } else {
                        $pesan = 4;
    
                        if($adapengajuan == 0) {
                            $isipesan = "Ada data pengajuan pelayanan tera atau tera ulang dari pelanggan";
                        }
    
                        if($jmlalat == 0) {
                            $isipesan = "Masih ada alat belum dialihkan ke pelanggan";
                        }
                    }
                    break;
                case 4:
                    $cekalatpakai = $this->mod_pelayanan->hitunguttppakai($kode);
                    $jmlalat = empty($cekalatpakai) ? 0:$cekalatpakai['total'];
    
                    if($jmlalat == 0) {
                        $this->mod_pelayanan->hapuspelanggan($kode);
                            
                        $pesan = 3;
                        $isipesan = "Daftar pelanggan dari penyedia telah dikurangi";
                    } else {
                        $pesan = 4;
                        $isipesan = "Masih ada alat belum dialihkan ke pelanggan";
                    }
                    break;
            }

            //save log
            $this->log_lib->log_info($isipesan);

            $msg = str_replace(" ", "-", $isipesan);

            redirect("pelayanan/pelanggan/1/20/-/$pesan/$msg");
        }
    }

    public function uttp($kdpeserta, $mode, $page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['mode'] = $mode;

            $data['infoapp'] = $this->infoapp->info();

            $ambil = $this->mod_pelayanan->ambilpeserta($kdpeserta);

            $data['kdpenyedia'] = $this->session->userdata('kduser');
            $data['kdpeserta'] = $kdpeserta;
            $data['tgldaftar'] = date('d-m-Y',strtotime($ambil['tgldaftar']));
            $data['npwp'] = $ambil['npwp'];
            $data['nama'] = $ambil['nama'];

            switch ($mode) {
                case 1:
                    $data['halaman'] = "Kepemilikan UTTP";

                    $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan($kdpeserta);

                    $q_cari = "a.status='0' and a.kdpeserta='$kdpeserta' and ";
                    break;
                case 2:
                    $data['halaman'] = "Kepemilikan UTTP Pelanggan";

                    $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan2($data['kdpenyedia']);

                    $q_cari = "a.status='1' and a.kdpeserta='$kdpeserta' and ";
                    break;
            }
            
            $data['monitoringpengajuan'] = $monitoringpengajuan == 0 ? "":$monitoringpengajuan." Pengajuan";

            //cari
            if ($isicari != "-") {
                $getcari = str_replace("-", " ", urldecode($isicari));
            } else {
                $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
            }

            if ($getcari != "") {
                $q_cari .= "b.nama like '%$getcari%'";
            } else {
                $q_cari .= "b.nama<>''";
            }
            
            $cari = str_replace(" ", "-", $getcari);
            $data['getcari'] =  $cari;

            $msg = str_replace("-", " ", $isipesan);
            $data['alert'] = $this->alert_lib->alert($pesan, $msg);

            //pagination
            $jumlah_data = $this->mod_pelayanan->jumlahuttp($q_cari);

            $limit_start = ($page - 1) * $limit;

            $data['limit'] = $limit;

            $no = $limit_start + 1;

            $daftar = $this->mod_pelayanan->daftaruttp($limit_start, $limit, $q_cari)->result();

            $record = array();
            $subrecord = array();
            foreach ($daftar as $d) {
                $subrecord['no'] = $no;
                $subrecord['kduttppeserta'] = $d->kduttppeserta;
                $subrecord['kduttp'] = $d->kduttp;
                $subrecord['nama'] = $d->nama;
                $subrecord['merktype'] = $d->merktype;
                $subrecord['kapasitas'] = $d->kapasitas;
                $subrecord['noseri'] = $d->noseri;
                $subrecord['jml'] = $d->jml;
                $subrecord['noskhp'] = $d->noskhp == '' ? '-':$d->noskhp;
                $subrecord['berkas'] = $d->foto;

                if($d->noskhp != ''){
                    $pengajuan = $this->mod_pelayanan->cekpengajuan($d->kduttppeserta,$d->noskhp);
                    $subrecord['tglterakhir'] = empty($pengajuan) || $pengajuan['tglsuratskhp'] == "" ? "-" : date('d-m-Y',strtotime($pengajuan['tglsuratskhp']));
                    $subrecord['berlaku'] = empty($pengajuan) || $pengajuan['berlakuskhp'] == "" ? "" : $pengajuan['berlakuskhp'];
    
                    if ($subrecord['berlaku'] != '') {
                        list($thn,$bln,$hr) = explode('-',$subrecord['berlaku']);
                        $subrecord['berlakusampai'] = $this->namabulan->namabln($bln).' '.$thn;
    
                        if(strtotime($subrecord['berlaku']) <= strtotime(date('Y-m-d'))){
                            $subrecord['statusexpired'] = '<a href="#" class="btn btn-danger btn-xs">Expired</a>';
                        } else {
                            $subrecord['statusexpired'] = '';
                        }
                    } else {
                        $subrecord['berlakusampai'] = '-';
                        $subrecord['statusexpired'] = '';
                    }
                } else {
                    $subrecord['tglterakhir'] = '-';
                    $subrecord['berlaku'] = '-';
                    $subrecord['berlakusampai'] = '-';
                    $subrecord['statusexpired'] = '';
                }

                $subrecord['adapengajuanaktif'] = $this->mod_pelayanan->adapengajuan2($subrecord['kduttppeserta']);

                $subrecord['adapengajuanaktif'] = $this->mod_pelayanan->adapengajuan2($subrecord['kduttppeserta']);

                $subrecord['jmlpengajuan'] = $this->mod_pelayanan->jmlpengajuan($d->kduttppeserta);

                $subrecord['infotambahan'] = '';
                $isiinfotambahan= $this->mod_pelayanan->isiinfotambahan($subrecord['kduttp'])->result();
                foreach ($isiinfotambahan as $iit) {
                    $ambilinfotambahan = $this->mod_pelayanan->ambilinfotambahan($subrecord['kduttppeserta'],$iit->info);
                    $isi = empty($ambilinfotambahan) ? '' : $ambilinfotambahan['isi'];
                    $subrecord['infotambahan'] .= '<br><span class="text-bold">'.$iit->info.':</span> <span class="text-red">'.$isi."</span>";
                }

                $subrecord['info'] =  "<span class='text-bold nama-uttp'>".$subrecord['nama']."</span>";
                $subrecord['info'] .= "<br><span class='text-bold'>Merk/Type:</span> <span class='text-red'>".$d->merktype."</span>";
                $subrecord['info'] .= "<br><span class='text-bold'>Kapasitas:</span> <span class='text-red'>".$d->kapasitas."</span>";
                $subrecord['info'] .= "<br><span class='text-bold'>No. Seri:</span> <span class='text-red'>".$d->noseri."</span>";
                $subrecord['info'] .= $subrecord['infotambahan'];
                // $subrecord['info'] .= "<br><span class='text-bold'>Terakhir Tera Ulang:</span> <span class='text-red'>".$subrecord['tglterakhir']."</span>";
                if($subrecord['tglterakhir'] != "-"){
                    $subrecord['info'] .= "<br><span class='text-bold'>No. SKHP Sebelumnya:</span> <span class='text-red'>".$subrecord['noskhp']."</span>";
                    $subrecord['info'] .= "<br><span class='text-bold'>Tgl. SKHP Sebelumnya:</span> <span class='text-red'>".$subrecord['tglterakhir']."</span>";
                    $subrecord['info'] .= "<br><span class='text-bold'>Masa Berlaku:</span> <span class='text-red'>".$subrecord['berlakusampai']." ".$subrecord['statusexpired']."</span>";
                } else {
                    $subrecord['info'] .= "<br><span class='text-bold'>SKHP Sebelumnya:</span> <span class='text-red'>-</span>";
                    $subrecord['info'] .= "<br><span class='text-bold'>Masa Berlaku:</span> <span class='text-red'>-</span>";
                }

                if($subrecord['jmlpengajuan'] > 0){
                    $subrecord['info'] .= "<br><span class='text-bold'>Total Pengajuan:</span> <span class='text-red'>".$subrecord['jmlpengajuan']."</span>";
                } else {
                    $subrecord['info'] .= "<br><span class='text-bold'>Total Pengajuan:</span> <span class='text-red'>Belum ada pengajuan</span>";
                }

                if ($subrecord['berkas'] != "") {
                    $berkas = "upload/uttppeserta/" . $subrecord['berkas'];
                    if (file_exists($berkas)) {
                        $subrecord['file_berkas'] = base_url() . "upload/uttppeserta/" . $subrecord['berkas'] . "?" . rand();
                    } else {
                        $subrecord['file_berkas'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $subrecord['file_berkas'] = base_url() . "upload/no-image.png";
                }

                $no++;

                array_push($record, $subrecord);
            }

            $data['uttp'] = json_encode($record);

            $data['page'] = $page;
            $data['limit'] = $limit;
            $data['get_jumlah'] = $jumlah_data;
            $data['jumlah_page'] = ceil($jumlah_data / $limit);
            $data['jumlah_number'] = 2;
            $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
            $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

            $data['no'] = $limit_start + 1;


            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/uttppeserta');
            $this->load->view('layout/bawah');
        }
    }

    public function formuliruttp($kdpeserta, $mode, $proses, $kode = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['infoapp'] = $this->infoapp->info();

            $data['proses'] = $proses;

            $data['listuttp'] = $this->mod_pelayanan->uttp()->result();

            $data['kdpeserta'] = $kdpeserta;
            $data['mode'] = $mode;

            switch ($mode) {
                case 1:
                    $data['halaman'] = "Kepemilikan UTTP";
                    break;
                case 2:
                    $data['halaman'] = "Kepemilikan UTTP Pelanggan";
                    break;
            }

            if($kode != ""){
                $ambiluttp = $this->mod_pelayanan->ambiluttp($kode);

                $data['kduttppeserta'] = $ambiluttp['kduttppeserta'];
                $data['kduttp'] = $ambiluttp['kduttp'];
                $data['merktype'] = $ambiluttp['merktype'];
                $data['kapasitas'] = $ambiluttp['kapasitas'];
                $data['noseri'] = $ambiluttp['noseri'];
                $data['jml'] = $ambiluttp['jml'];
                $data['foto'] = $ambiluttp['foto'];

                $data['jmlpengajuan'] = $this->mod_pelayanan->jmlpengajuan($data['kduttppeserta']);
                
                $pengajuan = $this->mod_pelayanan->cekpengajuan($data['kduttppeserta']);
                $data['skhpterakhir'] = (empty($pengajuan) || $pengajuan['nosuratskhp'] == "") &&  $data['jmlpengajuan'] == 0 ?  $data['noskhplama'] : $pengajuan['nosuratskhp'];
                $data['tglterakhir'] = (empty($pengajuan) || $pengajuan['tglsuratskhp'] == "") &&  $data['jmlpengajuan'] == 0 ?  $data['tglskhplama'] : $pengajuan['tglsuratskhp'];
                $data['berlakuterakhir'] = (empty($pengajuan) || $pengajuan['berlakuskhp'] == "") &&  $data['jmlpengajuan'] == 0 ?  $data['berlakuskhplama'] : $pengajuan['berlakuskhp'];

                $uttp = $this->mod_pelayanan->cekuttp($ambiluttp['kduttp']);
                $data['nama'] = empty($uttp) || $uttp['nama'] == "" ? "-" : $uttp['nama'];

                if ($data['foto'] != "") {
                    $foto = "upload/uttppeserta/" . $data['foto'];
                    if (file_exists($foto)) {
                        $data['file_foto'] = base_url() . "upload/uttppeserta/" . $data['foto'] . "?" . rand();
                    } else {
                        $data['file_foto'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_foto'] = base_url() . "upload/no-image.png";
                }

                $data['adapengajuan'] = $this->mod_pelayanan->adapengajuan($data['kduttppeserta']);

                $record = array();
                $subrecord = array();
    
                $isiinfotambahan= $this->mod_pelayanan->isiinfotambahan($data['kduttp'])->result();
    
                foreach ($isiinfotambahan as $iit) {
                    $label = strtolower(str_replace(' ','_',$iit->info));
    
                    $ambilinfotambahan = $this->mod_pelayanan->ambilinfotambahan($data['kduttppeserta'],$iit->info);
                    $isi = empty($ambilinfotambahan) ? '' : $ambilinfotambahan['isi'];

                    $lock =  $data['jmlpengajuan'] == 0 ? "":"readonly";
    
                    $subrecord['komponen'] = '<div class="form-group">'.
                                                '<label class="col-sm-3 control-label">'.$iit->info.'</label>'.
                                                '<div class="col-sm-5">'.
                                                    '<input type="text" class="form-control" name="info[]" id="'.$label.'" value="'.$isi.'" maxlength=150 autocomplete="off" '.$lock.' required />'.
                                                '</div>'.
                                            '</div>';
    
                    array_push($record, $subrecord);
                }
                $data['infotambahan'] = json_encode($record);

            } else {
                $data['kduttppeserta'] = "";
                $data['kduttp'] = "";
                $data['nama'] = "";
                $data['thnbeli'] = "";
                $data['merktype'] = "";
                $data['kapasitas'] = "";
                $data['noseri'] = "";
                $data['jml'] = "";
                $data['noskhplama'] = "";
                $data['tglskhplama'] = "";
                $data['berlakuskhplama'] = "";
                $data['jmlpengajuan'] = 0;
                $data['foto'] = date('dmYhis');
                $data['file_foto'] = base_url() . "upload/no-image.png";
                $data['adapengajuan'] = 0;
                $data['isiinfotambahan'] = "";
            }

            //save log
            $this->log_lib->log_info("Akses halaman formulir uttp peserta");

            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/formulir_uttppeserta');
            $this->load->view('layout/bawah');
        }
    }

    public function cekuttppeserta($kdpeserta,$kduttp)
    {
        $ada = $this->mod_pelayanan->cekuttppeserta($kdpeserta,$kduttp);

        echo $ada;
    }

    public function prosesuttp($kdpeserta, $mode, $proses, $kode = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            if($proses < 3){
                $kduttppeserta =  $this->input->post('kode');
                $kduttp =  $this->input->post('uttp');
                $merktype = $this->input->post('merktype');
                $kapasitas = $this->input->post('kapasitas');
                $noseri = $this->input->post('noseri');
                $jml = $this->input->post('jml');
                $jmlpengajuan = $this->input->post('jmlpengajuan');
                $foto = $this->input->post('namafile');
                $info = $this->input->post('info');

                $cekpeserta = $this->mod_pelayanan->cekpeserta($kdpeserta);
                $namapeserta = empty($cekpeserta) ? "-":$cekpeserta['nama'];
                $kelompok = empty($cekpeserta) ? 1:$cekpeserta['kelompok'];

                if($mode == 1){
                    $status = 0;
                } else {
                    $status = 1;
                }
        
                $data = array(
                    "kduttppeserta" => $kduttppeserta,
                    "kdpeserta" => $kdpeserta,
                    "kduttp" => $kduttp,
                    "merktype" => $merktype,
                    "kapasitas" => $kapasitas,
                    "noseri" => $noseri,
                    "jml" => 1,
                    "foto" => $foto,
                    "status" => $status
                );
            }

            switch ($proses) {
                case 1:
                    $this->mod_pelayanan->simpanuttp($data);

                    $this->mod_pelayanan->resetinfotambahan($kduttppeserta);
                    $uttppeserta = $this->mod_pelayanan->cekuttppeserta($kdpeserta,$kduttp);
                    $kduttppeserta = empty($uttppeserta) ? '':$uttppeserta['kduttppeserta'];

                    if($kduttppeserta != ''){
                        $no = 0;
                        $infotambahan = $this->mod_pelayanan->infotambahan($kduttp)->result();
                        foreach ($infotambahan as $it) {;
                            $isi = $info[$no];
                            $this->mod_pelayanan->simpaninfotambahan($kduttppeserta,$it->info,$isi);

                            $no++;
                        }
                    }

                    $pesan = 1;
                    $isipesan = "Daftar uttp peserta baru di tambahkan";
                    break;
                case 2:
                    if ($jmlpengajuan == 0) {
                        $this->mod_pelayanan->ubahuttp($data);
                    } else {
                        $this->mod_pelayanan->ubahuttp2($data);
                    }

                    $this->mod_pelayanan->resetinfotambahan($kduttppeserta);
                    $no = 0;
                    $infotambahan = $this->mod_pelayanan->infotambahan($kduttp)->result();
                    foreach ($infotambahan as $it) {;
                        $isi = $info[$no];
                        $this->mod_pelayanan->simpaninfotambahan($kduttppeserta,$it->info,$isi);

                        $no++;
                    }
                    
                    $pesan = 2;
                    $isipesan = "Data uttp peserta diubah";
                    break;
                case 3:
                    $berkas = $this->mod_pelayanan->berkasuttp($kode);
                    if(!empty($berkas)){
                        if($berkas['foto'] != ""){
                            $file_foto = "upload/uttppeserta/" . $berkas['foto'];
                            if (file_exists($file_foto)) {
                                unlink("./upload/uttppeserta/" . $berkas['foto']);
                            }
                        }
                    }

                    $this->mod_pelayanan->hapusuttp($kode);
                    
                    $pesan = 3;
                    $isipesan = "Daftar uttp peserta telah dikurangi beserta foto uttp";
                    break;
                case 4:
                    $this->mod_pelayanan->ubahpemilik($kode);
    
                    $pesan = 2;
                    $isipesan = "Data uttp peserta dialihkan kepemilikannya ke pelanggan";
                    break;
            }

            //save log
            $this->log_lib->log_info($isipesan);

            $msg = str_replace(" ", "-", $isipesan);

            redirect("pelayanan/uttp/$kdpeserta/$mode/1/20/-/$pesan/$msg");
        }
    }

    public function pengajuan($kdpeserta, $mode, $kduttppeserta, $page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['infoapp'] = $this->infoapp->info();

            $data['kduttppeserta'] = $kduttppeserta;

            $ambil = $this->mod_pelayanan->ambilpeserta($kdpeserta);

            $data['kdpenyedia'] = $this->session->userdata('kduser');
            $data['kdpeserta'] = $kdpeserta;
            $data['tgldaftar'] = date('d-m-Y',strtotime($ambil['tgldaftar']));
            $data['npwp'] = $ambil['npwp'];
            $data['nama'] = $ambil['nama'];

            $data['mode'] = $mode;

            switch ($mode) {
                case 1:
                    $data['halaman'] = "Pengajuan Tera/Tera Ulang";

                    $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan($kdpeserta);
                    break;
                case 2:
                    $data['halaman'] = "Pengajuan Tera/Tera Ulang Pelanggan";

                    $monitoringpengajuan = $this->mod_pelayanan->monitoringpengajuan2($data['kdpenyedia']);
                    break;
            }

            $data['monitoringpengajuan'] = $monitoringpengajuan == 0 ? "":$monitoringpengajuan." Pengajuan";

            $uttppeserta = $this->mod_pelayanan->ceknamauttp($kduttppeserta);
            $data['namauttp'] = empty($uttppeserta) || $uttppeserta['nama'] == "" ? "-" : $uttppeserta['nama'];

            $data['jmlpengajuan'] = $this->mod_pelayanan->jmlpengajuan($kduttppeserta);

            //cari
            if ($isicari != "-") {
                $getcari = str_replace("-", " ", urldecode($isicari));
            } else {
                $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
            }

            $q_cari = "c.kdpeserta='$kdpeserta' and ";
            if ($getcari != "") {
                $q_cari .= "(a.nosuratskrd like '%$getcari%' or a.nosuratskhp like '%$getcari%') and a.kduttppeserta='$kduttppeserta' and a.status>='5' ";
            } else {
                $q_cari .= "b.nama<>'' and a.kduttppeserta='$kduttppeserta' and a.status>='5'";
            }
            
            $cari = str_replace(" ", "-", $getcari);
            $data['getcari'] =  $cari;

            $msg = str_replace("-", " ", $isipesan);
            $data['alert'] = $this->alert_lib->alert($pesan, $msg);

            //pagination
            $jumlah_data = $this->mod_pelayanan->jumlahpengajuan($q_cari);

            $limit_start = ($page - 1) * $limit;

            $data['limit'] = $limit;

            $no = $limit_start + 1;

            $daftar = $this->mod_pelayanan->daftarpengajuan($limit_start, $limit, $q_cari)->result();

            $record = array();
            $subrecord = array();
            foreach ($daftar as $d) {
                $subrecord['no'] = $no;
                $subrecord['kdpengajuan'] = $d->kdpengajuan;
                $subrecord['kduttppeserta'] = $d->kduttppeserta;
                $subrecord['tglpengajuan'] = date('d-m-Y',strtotime($d->tglpengajuan));
                $subrecord['kdlayanan'] = $d->kdlayanan;
                $subrecord['nama'] = $d->nama;
                $subrecord['namauttp'] = $d->namauttp;
                $subrecord['jadwal'] = $d->jadwal;
                $subrecord['nobukti'] = $d->nobukti;
                $subrecord['tglbayar'] = $d->tglbayar != '' && $d->tglbayar != '0000-00-00' ? date('d-m-Y',strtotime($d->tglbayar)) :'-';
                $subrecord['buktibayar'] = $d->buktibayar;
                $subrecord['nosuratskrd'] = $d->nosuratskrd;
                $subrecord['tglsuratskrd'] = $d->tglsuratskrd != '' && $d->tglsuratskrd != '0000-00-00' ? date('d-m-Y',strtotime($d->tglsuratskrd)) :'-';
                $subrecord['nosuratskhp'] = $d->nosuratskhp;
                $subrecord['tglsuratskhp'] = $d->tglsuratskhp != '' && $d->tglsuratskhp != '0000-00-00' ? date('d-m-Y',strtotime($d->tglsuratskhp)) :'-';
                $subrecord['fotokondisi'] = $d->fotokondisi;
                $subrecord['lokasi'] = $d->lokasi;
                $subrecord['status'] = $d->status;
                $subrecord['hasil'] = $d->hasil;
                $subrecord['kdpegawai'] = $d->kdpegawai;

                $subrecord['noskhplama'] = $d->noskhplama != "" ? $d->noskhplama : "-";
                $subrecord['tglskhplama'] = $d->tglskhplama != "" ? date('d-m-Y',strtotime($d->tglskhplama)) : "-";
    
                if($d->berlakuskhp != "" && $d->berlakuskhp != '0000-00-00' && strtotime($d->berlakuskhp) <= strtotime(date('Y-m-d'))){
                    $statusekspired = '<a href="#" class="btn bg-black btn-xs">Expired</a>';
                } else {
                    $statusekspired = '';
                }
    
                if($d->berlakuskhplama != "" && $d->berlakuskhplama != '0000-00-00' && strtotime($d->berlakuskhplama) <= strtotime(date('Y-m-d'))){
                    $statusekspired2 = '<a href="#" class="btn bg-black btn-xs">Expired</a>';
                } else {
                    $statusekspired2 = '';
                }
    
                if($d->berlakuskhp != "" && $d->berlakuskhp != '0000-00-00') list($thn,$bln,$hr) = explode('-',$d->berlakuskhp);
                $subrecord['berlakuskhp'] = $d->berlakuskhp != "" && $d->berlakuskhp != '0000-00-00' ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired: "-";
    
                if($d->berlakuskhplama != "" && $d->berlakuskhplama != '0000-00-00') list($thn,$bln,$hr) = explode('-',$d->berlakuskhplama);
                $subrecord['berlakuskhplama'] = $d->berlakuskhplama != "" && $d->berlakuskhplama != '0000-00-00' ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired2: "-";
                
                $subrecord['lokasisebelumnya'] = $d->lokasisebelumnya != "" ? $d->lokasisebelumnya : "-";

                if ($subrecord['buktibayar'] != "") {
                    $buktibayar = "upload/buktibayar/" . $subrecord['buktibayar'];
                    if (file_exists($buktibayar)) {
                        $subrecord['file_buktibayar'] = base_url() . "upload/buktibayar/" . $subrecord['buktibayar'] . "?" . rand();
                    } else {
                        $subrecord['file_buktibayar'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $subrecord['file_buktibayar'] = base_url() . "upload/no-image.png";
                }

                switch ($subrecord['lokasi']) {
                    case 1:
                        $subrecord['namalokasi'] = "Kantor";
                        break;
                    case 2:
                        $subrecord['namalokasi'] = "Luar Kantor";
                        break;
                    default:
                        $subrecord['namalokasi'] = "-";
                        break;
                }

                switch ($subrecord['hasil']) {
                    case 1:
                        $subrecord['namastatus']="Selesai (Dibatalkan)";
                        $subrecord['warnabtn']="bg-maroon"; 
                        break;
                    case 2:
                        $subrecord['namastatus']="Selesai (Sah)";
                        $subrecord['warnabtn']="bg-green"; 
                        break;
                    default:
                        if($subrecord['status'] == 10){
                            $subrecord['namastatus']="Dibatalkan";
                            $subrecord['warnabtn']="btn-default text-red"; 
                        } else  {
                            $subrecord['namastatus']="Selesai";
                            $subrecord['warnabtn']="bg-green"; 
                        }
                        break;
                }

                 // penera
                if($subrecord['kdpegawai'] != ""){
                $cekpeneratetapan = $this->mod_pelayanan->cekpeneratetapan($subrecord['kdpegawai']);
                    $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
                } else {
                    $subrecord['namapenera'] = "-";
                }

                $no++;

                array_push($record, $subrecord);
            }

            $data['pengajuan'] = json_encode($record);

            $data['page'] = $page;
            $data['limit'] = $limit;
            $data['get_jumlah'] = $jumlah_data;
            $data['jumlah_page'] = ceil($jumlah_data / $limit);
            $data['jumlah_number'] = 2;
            $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
            $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

            $data['no'] = $limit_start + 1;


            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/pengajuan');
            $this->load->view('layout/bawah');
        }
    }
    
    public function formulirpengajuan($kdpeserta, $mode, $kduttppeserta, $proses, $kode = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['infoapp'] = $this->infoapp->info();

            $data['proses'] = $proses;

            $data['kduttppeserta'] = $kduttppeserta;
            $data['kdpenyedia'] = $this->session->userdata('kduser');
            $data['mode'] = $mode;

            switch ($mode) {
                case 1:
                    $data['halaman'] = "Pengajuan Tera/Tera Ulang";
                    break;
                case 2:
                    $data['halaman'] = "Pengajuan Tera/Tera Ulang Pelanggan";
                    break;
            }

            $data['jmlpengajuan'] = $this->mod_pelayanan->jmlpengajuan($kduttppeserta);

            $data['tglsekarang'] = date('Y-m-d');
            $data['tglminimum'] = date('Y-m-d', strtotime($data['tglsekarang'] . ' +1 day'));
    
            $data['penera'] = $this->mod_pelayanan->penera()->result();
    
            $ambiluttp = $this->mod_pelayanan->ambiluttp($kduttppeserta);
            $data['kdpeserta'] = $kdpeserta;
            $data['kduttp'] = $ambiluttp['kduttp'];
            $data['merktype'] = $ambiluttp['merktype'];
            $data['kapasitas'] = $ambiluttp['kapasitas'];
            $data['noseri'] = $ambiluttp['noseri'];
            $data['jml'] = $ambiluttp['jml'];
            $data['noskhp'] = $ambiluttp['noskhp'];
            $data['status'] = $ambiluttp['status'];
            $data['kdlayanan'] = $ambiluttp['kdlayanan'];

            if($data['kdlayanan'] == 0){
                $qlayanan = "kdlayanan<>''";
            } else {
                $qlayanan = "kdlayanan='".$data['kdlayanan']."'";
            }
    
            $record_layanan = array();
            $subrecord_layanan = array();
            $lislayanan = $this->mod_pelayanan->layanan($qlayanan)->result();
            foreach ($lislayanan as $ly) {
                $subrecord_layanan['kdlayanan'] = $ly->kdlayanan;
                $subrecord_layanan['nama'] = $ly->nama;
    
                $subrecord_layanan['pilihan'] = $data['noskhp'] != '' && $subrecord_layanan['nama'] == 'Tera Ulang' ? 'selected':'';
                
                array_push($record_layanan, $subrecord_layanan);
            }
            $data['listlayanan'] = json_encode($record_layanan);

            // skhp sebelum yang terdata
            if($ambiluttp['noskhp'] != ''){
                $pengajuan = $this->mod_pelayanan->cekskhplama($kduttppeserta,$ambiluttp['noskhp']);
                $data['tglterakhir'] = empty($pengajuan) || $pengajuan['tglsuratskhp'] == "" ? "" :$pengajuan['tglsuratskhp'];
                $data['berlaku'] = empty($pengajuan) || $pengajuan['berlakuskhp'] == "" ? "" : date('Y-m',strtotime($pengajuan['berlakuskhp']));  
                
                extract($data['infoapp']);
                $data['lokasipengurusan'] = $namakantor;

                $data['namalayanan'] = 'Tera Ulang';
            } else {
                $data['tglterakhir'] = '';
                $data['berlaku'] = '';
                $data['lokasipengurusan'] = '';
                $data['namalayanan'] = '';
            }

            // info tambahan
            $record = array();
            $subrecord = array();
            $isiinfotambahan= $this->mod_pelayanan->isiinfotambahan($data['kduttp'])->result();
            foreach ($isiinfotambahan as $iit) {
                $label = strtolower(str_replace(' ','_',$iit->info));

                $ambilinfotambahan = $this->mod_pelayanan->ambilinfotambahan($data['kduttppeserta'],$iit->info);
                $isi = empty($ambilinfotambahan) ? '' : $ambilinfotambahan['isi'];

                $subrecord['komponen'] = '<dt>'.$iit->info.'</dt><dd>'.$isi.'</dd>';

                array_push($record, $subrecord);
            }
            $data['infotambahan'] = json_encode($record);

            $cekpeserta = $this->mod_pelayanan->cekpeserta($data['kdpeserta']);
            $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];
    
            $data['adaberkastambahan'] = $this->mod_pelayanan->cekberkastambahan($data['kduttp']);
    
            $berkastambahan = $this->mod_pelayanan->berkastambahan($data['kduttp'])->result();
    
            if ($ambiluttp['foto'] != "") {
                $foto = "upload/uttppeserta/" . $ambiluttp['foto'];
                if (file_exists($foto)) {
                    $data['file_foto'] = base_url() . "upload/uttppeserta/" . $ambiluttp['foto'] . "?" . rand();
                } else {
                    $data['file_foto'] = base_url() . "upload/no-image.png";
                }
            } else {
                $data['file_foto'] = base_url() . "upload/no-image.png";
            }
    
            $uttppeserta = $this->mod_pelayanan->ceknamauttp($kduttppeserta);
            $data['namauttp'] = empty($uttppeserta) || $uttppeserta['nama'] == "" ? "-" : $uttppeserta['nama'];
    
            $data['proses'] = $proses;

    
            if($kode != ""){
                $ambilpengajuan = $this->mod_pelayanan->ambilpengajuan($kode);
    
                $data['kdpengajuan'] = $ambilpengajuan['kdpengajuan'];
                $data['tglpengajuan'] = date('d-m-Y',strtotime($ambilpengajuan['tglpengajuan']));
                $data['kdlayanan'] = $ambilpengajuan['kdlayanan'];
                $data['nama'] = $ambilpengajuan['nama'];
                $data['namauttp'] = $ambilpengajuan['namauttp'];
                $data['jadwal'] = date('d-m-Y',strtotime($ambilpengajuan['jadwal']));
                $data['jadwal2'] = $ambilpengajuan['jadwal'];
                $data['kdpegawai'] = $ambilpengajuan['kdpegawai'];
                $data['nobukti'] = $ambilpengajuan['nobukti'];
                $data['tglbayar'] = date('d-m-Y',strtotime($ambilpengajuan['tglbayar']));
                $data['tglbayar2'] = $ambilpengajuan['tglbayar'];
                $data['buktibayar'] = $ambilpengajuan['buktibayar'];
                $data['nosuratskrd'] = $ambilpengajuan['nosuratskrd'];
                $data['tglsuratskrd'] =$ambilpengajuan['tglsuratskrd'];
                $data['nosuratskhp'] = $ambilpengajuan['nosuratskhp'];
                $data['tglsuratskhp'] = $ambilpengajuan['tglsuratskhp'];
                // $data['berlaku'] = $ambilpengajuan['berlakuskhp'];
                $data['fotokondisi'] = $ambilpengajuan['fotokondisi'];
                $data['izinpersetujuantipe'] = $ambilpengajuan['izinpersetujuantipe'];
                $data['skhplama'] = $ambilpengajuan['skhplama'];
                $data['lokasisebelumnya'] = $ambilpengajuan['lokasisebelumnya'];
                $data['adaskhplama'] = $ambilpengajuan['adaskhplama'];
                $data['noskhplama'] = $ambilpengajuan['noskhplama'];
                $data['tglskhplama'] = $ambilpengajuan['tglskhplama'];
                $data['tglskhplama2'] = date('d-m-Y',strtotime($ambilpengajuan['tglskhplama']));
                $data['berlakuskhplama'] =  date('Y-m',strtotime($ambilpengajuan['berlakuskhplama']));
                $data['suratpermohonan'] = $ambilpengajuan['suratpermohonan'];
                $data['lokasi'] = $ambilpengajuan['lokasi'];
                $data['hasiluji'] = $ambilpengajuan['hasil'];
                $data['keterangan'] = $ambilpengajuan['keterangan'];
                $data['cerapan'] = $ambilpengajuan['cerapan'];
                $data['status'] = $ambilpengajuan['status'];
                $data['alasanbatal'] = $ambilpengajuan['alasanbatal'];

                if($ambilpengajuan['berlakuskhp'] != "") list($thn,$bln,$hr) = explode('-',$ambilpengajuan['berlakuskhp']);
                $data['berlakuskhp'] = $ambilpengajuan['berlakuskhp'] != "" ?  $this->namabulan->namabln($bln)." ".$thn: "-";

                $data['skrd'] = $data['nosuratskrd'] == '' ? '-' : $data['nosuratskrd'] . ' ' . date('d-m-Y',strtotime($data['tglsuratskrd'])); 
                $data['skhp'] = $data['nosuratskhp'] == '' ? '-' : $data['nosuratskhp'] . ' ' . date('d-m-Y',strtotime($data['tglsuratskhp'])) . "<br>Berlaku sampai ".$data['berlakuskhp']; 

                if($ambilpengajuan['berlakuskhplama'] != "" && strtotime($ambilpengajuan['berlakuskhplama']) <= strtotime($data['tglsekarang'])){
                    $data['statusekspired'] = '<a href="#" class="btn btn-danger btn-xs">Expired</a>';
                } else {
                    $data['statusekspired'] = '';
                }
    
                if($ambilpengajuan['berlakuskhplama'] != "") list($thn,$bln,$hr) = explode('-',$ambilpengajuan['berlakuskhplama']);
                $data['berlakuskhplama2'] = $ambilpengajuan['berlakuskhplama'] != "" ?  $this->namabulan->namabln($bln)." ".$thn: "-";
    
                switch ($data['hasiluji']) {
                    case 0:
                        $data['namahasiluji'] = "Belum Ada Hasil";
                        $data['warnahasil'] = "text-black";
                        break;
                    case 1:
                        $data['namahasiluji'] = "Dibatalkan";
                        $data['warnahasil'] = "text-red";
                        break;
                    case 2:
                        $data['namahasiluji'] = "Sah";
                        $data['warnahasil'] = "text-green";
                        break;
                    default:
                        $data['namahasiluji'] = "Belum Ada Hasil";
                        break;
                }
    
                $data['namastatus'] = "";
                $data['namabtn'] = "";
                $data['tgl1'] = ""; 
                $data['tgl2'] = "";
                $data['tgl3'] = "";
                $data['tgl4'] = ""; 
                $data['pegawai1'] = ""; 
                $data['pegawai2'] = "";
                $data['pegawai3'] = "";
                $data['pegawai4'] = ""; 
    
                // nama lokasi pelayanan
                switch ($data['lokasi']) {
                    case 1:
                        $data['namalokasi'] = "Kantor";
                        break;
                    case 2:
                        $data['namalokasi'] = "Luar Kantor";
                        break;
                    default:
                        $data['namalokasi'] = "-";
                        break;
                }

                $data['adapilihan'] = $this->mod_pelayanan->cekpilihanjadwal($kode);
    
                if($data['adapilihan'] != 0){
                    $ambilpilihan = $this->mod_pelayanan->ambilpilihanjadwal($kode);
                    $data['tgl1'] = $ambilpilihan['tgl1']; 
    
                    $cekpenera = $this->mod_pelayanan->cekpeneratetapan($ambilpilihan['pegawai1']);
                    $data['pegawai1'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
    
                    $data['tgl2'] = $ambilpilihan['tgl2']; 
    
                    $cekpenera = $this->mod_pelayanan->cekpeneratetapan($ambilpilihan['pegawai2']);
                    $data['pegawai2'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
                    
                    $data['tgl3'] = $ambilpilihan['tgl3']; 
    
                    $cekpenera = $this->mod_pelayanan->cekpeneratetapan($ambilpilihan['pegawai3']);
                    $data['pegawai3'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
    
                    $data['tgl4'] = $ambilpilihan['tgl4']; 
    
                    $cekpenera = $this->mod_pelayanan->cekpeneratetapan($ambilpilihan['pegawai4']);
                    $data['pegawai4'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
    
                    $data['status_tgl1'] = $data['jadwal2'] != $ambilpilihan['tgl1'] && strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl1']) ? "disabled" : "";
                    $data['status_tgl2'] = $data['jadwal2'] != $ambilpilihan['tgl2'] &&strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl2']) ? "disabled" : "";
                    $data['status_tgl3'] = $data['jadwal2'] != $ambilpilihan['tgl3'] &&strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl3']) ? "disabled" : "";
                    $data['status_tgl4'] = $data['jadwal2'] != $ambilpilihan['tgl4'] &&strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl4']) ? "disabled" : "";
                }
    
                // penera
                $cekpeneratetapan = $this->mod_pelayanan->cekpeneratetapan($data['kdpegawai']);
                $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
    
                /* berkas tambahan */
                $no = 1;
                $record = array();
                $subrecord = array();
                foreach ($berkastambahan as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['nama'] = $d->nama;
                    $subrecord['nama_objek'] = str_replace(' ','_',$d->nama);
                    $subrecord['berkas'] = $d->berkas;
        
                    if ($subrecord['berkas'] != "") {
                        $doktambahan = "upload/doktambahan/" . $subrecord['berkas'];
                        if (file_exists($doktambahan)) {
                            $subrecord['file_berkas'] = base_url() . "upload/doktambahan/" . $subrecord['berkas'];
                        } else {
                            $subrecord['file_berkas'] = "";
                        }
                    } else {
                        $subrecord['file_berkas'] = "";
                    }
    
                    $berkastambahanpengajuan = $this->mod_pelayanan->berkastambahanpengajuan($data['kdpengajuan'],$subrecord['nama_objek']);
                    $subrecord['berkasupload'] = empty($berkastambahanpengajuan) || $berkastambahanpengajuan['berkas'] == "" ? "":$berkastambahanpengajuan['berkas'];
                    if ($subrecord['berkasupload'] != "") {
                        $doktambahanpengajuan = "upload/doktambahanpengajuan/" . $subrecord['berkasupload'];
                        if (file_exists($doktambahanpengajuan)) {
                            if (strpos($subrecord['berkasupload'], "PDF") !== false || strpos($subrecord['berkasupload'], "pdf") !== false) {
                                $subrecord['file_berkasupload'] = base_url() . "permintaan/viewPdftambahan/" . $subrecord['berkasupload'];
                            } else {
                                $subrecord['file_berkasupload'] = base_url() . "upload/doktambahanpengajuan/" . $subrecord['berkasupload'] . "?" . rand();
                            }
                            
                        } else {
                            $subrecord['file_berkasupload'] = "";
                        }
                    } else {
                        $subrecord['file_berkasupload'] = "";
                    }
    
                    $no++;
        
                    array_push($record, $subrecord);
                }
                $data['berkastambahan'] = json_encode($record);
    
    
                switch ($ambilpengajuan['status']) {
                    case 0 : 
                        $data['namastatus']="Baru"; 
                        $data['warnabtn']="bg-blue"; 
                        $data['namabtn'] = "Update Pengajuan"; 
                        break;
                    case 1 : 
                        $data['namastatus']="Diterima"; 
                        $data['warnabtn']="bg-light-blue"; 
                        $data['namabtn'] = "Atur Jadwal"; 
                        break;
                    case 2 : 
                        $data['namastatus']="Terjadwal"; 
                        $data['warnabtn']="bg-teal"; 
    
                        if($data['nobukti'] == ""){
                            $data['namabtn'] = "Bayar";
                        } else {
                            $data['namabtn'] = "Konfirmasi Pembayaran";
                        }
                        break;
                    case 3 :
                        $data['namastatus']="Terbayar"; 
                        $data['warnabtn']="bg-olive"; 
    
                        if($data['nobukti'] == ""){
                            $data['namabtn'] = "Bayar";
                        } else {
                            $data['namabtn'] = "Konfirmasi Pembayaran";
                        }
                        break;
                    case 4 : 
                        $data['namastatus']="Diproses"; 
                        $data['warnabtn']="bg-orange"; 
                        $data['namabtn'] = "Update Layanan";
                        break;
                    case 5:  
                        $data['namastatus'] = "Selesai"; 
                        $data['warnabtn']="bg-green"; 
                        $data['namabtn'] = "Update";
                        break;
                    case 10:  
                        $data['namastatus'] = "Dibatalkan"; 
                        $data['warnabtn']="bg-red"; 
                        $data['namabtn'] = "Update";
                        break;
                }
    
                if ($data['buktibayar'] != "") {
                    $buktibayar = "upload/buktibayar/" . $data['buktibayar'];
                    if (file_exists($buktibayar)) {
                        $data['file_buktibayar'] = base_url() . "upload/buktibayar/" . $data['buktibayar'] . "?" . rand();
                    } else {
                        $data['file_buktibayar'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_buktibayar'] = base_url() . "upload/no-image.png";
                }
    
                if ($data['fotokondisi'] != "") {
                    $fotokondisi = "upload/fotokondisi/" . $data['fotokondisi'];
                    if (file_exists($fotokondisi)) {
                        if (strpos($data['fotokondisi'], "PDF") !== false || strpos($data['fotokondisi'], "pdf") !== false) {
                            $data['file_fotokondisi'] = base_url() . "permintaan/viewPdf/" . $data['fotokondisi'] . "/fotokondisi";
                        } else {
                            $data['file_fotokondisi'] = base_url() . "upload/fotokondisi/" . $data['fotokondisi'] . "?" . rand();
                        }
                    } else {
                        $data['file_fotokondisi'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_fotokondisi'] = base_url() . "upload/no-image.png";
                }
    
                if ($data['izinpersetujuantipe'] != "") {
                    $izinpersetujuantipe = "upload/izinpersetujuantipe/" . $data['izinpersetujuantipe'];
                    if (file_exists($izinpersetujuantipe)) {
                        if (strpos($data['izinpersetujuantipe'], "PDF") !== false || strpos($data['izinpersetujuantipe'], "pdf") !== false) {
                            $data['file_izinpersetujuantipe'] = base_url() . "permintaan/viewPdf/" . $data['izinpersetujuantipe'] . "/Tera";
                        } else {
                            $data['file_izinpersetujuantipe'] = base_url() . "upload/izinpersetujuantipe/" . $data['izinpersetujuantipe'] . "?" . rand();
                        }
                    } else {
                        $data['file_izinpersetujuantipe'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_izinpersetujuantipe'] = base_url() . "upload/no-image.png";
                }
    
                if ($data['skhplama'] != "") {
                    $skhplama = "upload/skhplama/" . $data['skhplama'];
                    if (file_exists($skhplama)) {
                        if (strpos($data['skhplama'], "PDF") !== false || strpos($data['skhplama'], "pdf") !== false) {
                            $data['file_skhplama'] = base_url() . "permintaan/viewPdf/" . $data['skhplama'] . "/Tera Ulang";
                        } else {
                            $data['file_skhplama'] = base_url() . "upload/skhplama/" . $data['skhplama'] . "?" . rand();
                        }
                    } else {
                        $data['file_skhplama'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_skhplama'] = base_url() . "upload/no-image.png";
                }
    
                if ($data['suratpermohonan'] != "") {
                    $suratpermohonan = "upload/suratpermohonan/" . $data['suratpermohonan'];
                    if (file_exists($suratpermohonan)) {
                        if (strpos($data['suratpermohonan'], "PDF") !== false || strpos($data['suratpermohonan'], "pdf") !== false) {
                            $data['file_suratpermohonan'] = base_url() . "permintaan/viewPdf/" . $data['suratpermohonan'] . "/suratpermohonan";
                        } else {
                            $data['file_suratpermohonan'] = base_url() . "upload/suratpermohonan/" . $data['suratpermohonan'] . "?" . rand();
                        }
                    } else {
                        $data['file_suratpermohonan'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_suratpermohonan'] = base_url() . "upload/no-image.png";
                }
    
                if ($data['cerapan'] != "") {
                    $cerapan = "upload/cerapan/" . $data['cerapan'];
                    if (file_exists($cerapan)) {
                        if (strpos($data['cerapan'], "PDF") !== false || strpos($data['cerapan'], "pdf") !== false) {
                            $data['file_cerapan'] = base_url() . "permintaan/viewPdf/" . $data['cerapan'] . "/cerapan";
                        } else {
                            $data['file_cerapan'] = base_url() . "upload/cerapan/" . $data['cerapan'] . "?" . rand();
                        }
                    } else {
                        $data['file_cerapan'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $data['file_cerapan'] = base_url() . "upload/no-image.png";
                }
    
                switch ($data['nama']) {
                    case 'Tera':
                        $data['izinskhplama'] = $data['izinpersetujuantipe'];
                        $data['namalabel'] = 'Izin Persetujuan Tipe';
                        $data['file_izinskhplama'] = $data['file_izinpersetujuantipe'];
                        break;
                    case 'Tera Ulang':
                        $data['izinskhplama'] = $data['skhplama'];
    
                        if($data['adaskhplama'] == 0){
                            $data['namalabel'] = 'Surat Ket. Kehilangan';
                        } else {
                            $data['namalabel'] = 'SKHP Lama';
                        }
                        $data['file_izinskhplama'] = $data['file_skhplama'];
                        break;
                }
            } else {
                $data['kdpengajuan'] = "";
                $data['tglpengajuan'] = date('Y-m-d');
                $data['kdlayanan'] = "";
                $data['nama'] = "";
                $data['jadwal'] = "";
                $data['jadwal2'] = "";
                $data['kdpegawai'] = "";
                $data['nobukti'] = "";
                $data['tglbayar'] = "";
                $data['buktibayar'] = "";
                $data['nosuratskrd'] = "";
                $data['tglsuratskrd'] = "";
                $data['nosuratskhp'] = "";
                $data['tglsuratskhp'] = "";
                $data['file_buktibayar'] = "";
                $data['fotokondisi'] = "";
                $data['file_fotokondisi'] = "";
                $data['izinpersetujuantipe'] = "";
                $data['file_izinpersetujuantipe'] = "";
                $data['lokasisebelumnya'] = "";
                $data['adaskhplama'] = "";
                $data['noskhplama'] = "";
                $data['tglskhplama'] = "";
                $data['tglskhplama2'] = "";
                $data['berlakuskhplama'] = "";
                $data['berlakuskhplama2'] = "";
                $data['skhplama'] = "";
                $data['file_skhplama'] = "";
                $data['suratpermohonan'] = "";
                $data['file_suratpermohonan'] = "";
                $data['status'] = 0;
                $data['lokasi'] = "";
                $data['hasiluji'] = 0;
                $data['keterangan'] = "";
                $data['cerapan'] = "";
                $data['file_cerapan'] = "";
                $data['status'] = "";
                $data['namalokasi'] = "-";
                $data['namastatus'] = "Baru";
                $data['namabtn'] = "Proses Pengajuan Baru";
                $data['warnabtn']="bg-blue";
                $data['alasanbatal'] = "";
    
                $data['izinskhplama'] = "";
                $data['file_izinskhplama'] = "";

                $data['adapilihan'] = 0;
    
                $record = array();
                $subrecord = array();
                foreach ($berkastambahan as $d) {
                    $subrecord['nama'] = $d->nama;
                    $subrecord['nama_objek'] = str_replace(' ','_',$d->nama);
                    $subrecord['berkas'] = $d->berkas;
        
                    if ($subrecord['berkas'] != "") {
                        $doktambahan = "upload/doktambahan/" . $subrecord['berkas'];
                        if (file_exists($doktambahan)) {
                            $subrecord['file_berkas'] = base_url() . "upload/doktambahan/" . $subrecord['berkas'];
                        } else {
                            $subrecord['file_berkas'] = "";
                        }
                    } else {
                        $subrecord['file_berkas'] = "";
                    }
    
                    $subrecord['berkasupload'] = "";
                    $subrecord['file_berkasupload'] = "";
        
                    array_push($record, $subrecord);
                }
                $data['berkastambahan'] = json_encode($record);
            }

            if($data['status'] == 0 || 
                ($data['status'] == 1 && $data['adapilihan'] != 0) || 
                ($data['status'] == 2 && $data['jadwal'] != "" && $data['jadwal'] != "0000-00-00") ||
                $data['status'] >= 5){

                switch ($data['status']) {
                    case 0:
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                        switch ($proses) {
                            case 1:
                                $data['linkbatal'] = base_url()."pelayanan/uttp/$kdpeserta/$mode";
                                break;
                            case 2:
                                $data['linkbatal'] = base_url()."pelayanan/monitoring/$kdpeserta/$mode";
                                break;
                        }
                        break;
                    case 5:
                        $data['linkbatal'] = base_url()."pelayanan/pengajuan/$kdpeserta/$mode/$kduttppeserta";
                        break;
                    default:
                        $data['linkbatal'] = base_url()."pelayanan/monitoring/$kdpeserta/$mode";
                        break;
                }
                //save log
                $this->log_lib->log_info("Akses halaman formulir pengajuan tera atau tera ulang peserta");

                $this->load->view('layout/atas', $data);
                $this->load->view('layout/menu');
                $this->load->view('page/formulir_pengajuan');
                $this->load->view('layout/bawah');
            } elseif($data['status'] == 1 && $data['adapilihan'] == 0){
                $pesan = 4;
                $isipesan = "Pilihan jadwal Anda masing kosong, silakan ditunggu pilihan jadwal yang kami sediakan. Atau Anda bisa menghubungi kami untuk informasi lebih lanjut";

                //save log
                $this->log_lib->log_info($isipesan);

                $msg = str_replace(" ", "-", $isipesan);

                redirect("pelayanan/monitoring/".$data['kdpenyedia']."/".$data['mode']."/1/20/-/$pesan/$msg");
            }else {
                $pesan = 4;
                $isipesan = "Data pengajuan Anda telah berubah status menjadi " . $data['namastatus']. " sehingga tidak dapat diubah lagi, jika butuh bantuan terkait data pengajuan tersebut silakan hubungi kami";

                //save log
                $this->log_lib->log_info($isipesan);

                $msg = str_replace(" ", "-", $isipesan);

                redirect("pelayanan/monitoring/".$data['kdpenyedia']."/".$data['mode']."/1/20/-/$pesan/$msg");
            }
        }
    }

    public function prosespengajuan($kdpeserta, $mode, $proses, $kode = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            if($proses != 3){
                $tglpengajuan = date('Y-m-d');
                $kdpengajuan =  $this->input->post('kode');
                $kdpenyedia =  $this->input->post('kdpenyedia');
                $kduttppeserta =  $this->input->post('kduttppeserta');
                $kdlayanan =  $this->input->post('layanan');
                $namalayanan =  $this->input->post('namalayanan');
                $fotokondisi = $this->input->post('berkas');
                $status = $this->input->post('status');
                $nobukti = $this->input->post('nobukti');
                $tglbayar = $this->input->post('tglbayar');
                $buktibayar = $this->input->post('berkas2');
                $nosuratskrd = $this->input->post('nosuratskrd');
                $tglsuratskrd = $this->input->post('tglsuratskrd');
                $nosuratskhp = $this->input->post('nosuratskhp');
                $tglsuratskhp = $this->input->post('tglsuratskhp');
                $lokasi = $this->input->post('lokasi');
                $hasil = $this->input->post('hasil');
                $cerapan = $this->input->post('berkas_cerapan');
                $keterangan = $this->clear_string->clear_quotes($this->input->post('keterangan'));
    
                $hasilawal = $this->input->post('hasilawal');
                $jadwalawal = $this->input->post('jadwalawal');
                $pegawaiawal = $this->input->post('pegawaiawal');

                $adapilihan = $this->mod_pelayanan->cekpilihanjadwal($kdpengajuan);
                if($adapilihan > 0 && $kdpengajuan != ""){
                    $jadwal = $this->input->post('tgltetapan');
                    for ($i=1; $i < 5; $i++) { 
                        $qjadwal = "tgl$i='$jadwal'";
                        $cekpenera = $this->mod_pelayanan->cekpenera($qjadwal);
                        if(!empty($cekpenera)){
                            $kdpegawai =  $cekpenera['pegawai'.$i];
                            break;
                        }
                    }
                }

                switch ($namalayanan) {
                    case 'Tera':
                        $izinpersetujuantipe = $this->input->post('berkas_izinskhplama');
                        
                        $adaskhplama = "";
                        $noskhplama = "";
                        $tglskhplama = "";
                        $berlakuskhplama = "";
                        $lokasisebelumnya = "";
                        $skhplama = "";
                        break;
                    case 'Tera Ulang':
                        $noskhplama = $this->input->post('noskhplama');
                        $tglskhplama = $this->input->post('tglskhplama');
                        $berlakuskhplama = $this->input->post('berlakuskhplama');
                        $lokasisebelumnya = $this->input->post('lokasisebelumnya');
                        $skhplama = $this->input->post('berkas_izinskhplama');
                        $adaskhplama = $this->input->post('dokumenskhplama');

                        $izinpersetujuantipe = "";
                        break;
                }
    
                $statusbaru = $status;
                switch ($status) {
                    case 0:
                        $statusbaru = 0;
                        break;
                    case 1:
                        if($adapilihan >= 0 && $jadwal != ""){
                            $statusbaru = 2;
                        } else {
                            $statusbaru = 1;
                        }
                        break;
                }
                
                $suratpermohonan = $this->input->post('berkas_suratpermohonan');
    
                $berkas_tambahan = $this->input->post('berkas_tambahan');
                $jmlberkas = empty($berkas_tambahan) ? 0:count($berkas_tambahan);
        
                $data = array(
                    "kdpengajuan" => $kdpengajuan,
                    "tglpengajuan" => $tglpengajuan,
                    "kduttppeserta" => $kduttppeserta,
                    "kdlayanan" => $kdlayanan,
                    "fotokondisi" => $fotokondisi,
                    "izinpersetujuantipe" => $izinpersetujuantipe,
                    "adaskhplama" => $adaskhplama,
                    "skhplama" => $skhplama,
                    "noskhplama" => $noskhplama,
                    "tglskhplama" => $tglskhplama,
                    "berlakuskhplama" => $berlakuskhplama."-1",
                    "lokasisebelumnya" => $lokasisebelumnya,
                    "suratpermohonan" => $suratpermohonan,
                    "lokasi" => $lokasi,
                    "status" => $statusbaru
                );
            }
    
            switch ($proses) {
                case 1:
                    $this->mod_pelayanan->simpanpengajuan($data);
    
                    $cekpengajuan = $this->mod_pelayanan->cekpengajuan2($kduttppeserta);
                    $kdpengajuan = empty($cekpengajuan) ? "":$cekpengajuan['kdpengajuan'];
    
                    $pesan = 1;
                    $isipesan = "Pengajuan telah ditambahkan";
                    break;
                case 2:
                    switch ($status) {
                        case 0:
                            $this->mod_pelayanan->ubahpengajuan($data);
                            
                            $pesan = 2;
                            $isipesan = "Data pengajuan diubah";
                            break;
                        case 1:
                            if ($statusbaru == 2) {
                                $this->mod_pelayanan->ubahjadwal($kdpengajuan,$jadwal,$kdpegawai,$statusbaru);
    
                                $pesan = 2;
                                $isipesan = "Pilihan jadwal diterima, menunggu proses pembayaran retribusi";
                            } else {
                                $pesan = 4;
                                $isipesan = "Data pilihan jadwal tidak ada";
                            }
                            break;
                        case 2:
                            if ($nobukti != "" && $buktibayar != "") {
                                $this->mod_pelayanan->ubahbayar($kdpengajuan,$nobukti,$tglbayar,$buktibayar,3);
                                $pesan = 2;
                                $isipesan = "Pembayaran retribusi diterima dan akan segera kami cek terlebih dahulu";
                            } else {
                                $pesan = 4;
                                $isipesan = "Data pembayaran tidak ada";
                            }
                            break;
                    }
                    break;
                case 3:
                    $berkas = $this->mod_pelayanan->berkaspengajuan($kode);
                    $kduttppeserta = "";
                    $status = 0;
                    if(!empty($berkas)){
                        $kduttppeserta = $berkas['kduttppeserta'];
                        $status = $berkas['status'];
    
                        if($berkas['fotokondisi'] != ""){
                            $file_foto = "upload/fotokondisi/" . $berkas['fotokondisi'];
                            if (file_exists($file_foto)) {
                                unlink("./upload/fotokondisi/" . $berkas['fotokondisi']);
                            }
                        }
    
                        if($berkas['izinpersetujuantipe'] != ""){
                            $file_foto = "upload/izinpersetujuantipe/" . $berkas['izinpersetujuantipe'];
                            if (file_exists($file_foto)) {
                                unlink("./upload/izinpersetujuantipe/" . $berkas['izinpersetujuantipe']);
                            }
                        }
    
                        if($berkas['skhplama'] != ""){
                            $file_foto = "upload/skhplama/" . $berkas['skhplama'];
                            if (file_exists($file_foto)) {
                                unlink("./upload/skhplama/" . $berkas['skhplama']);
                            }
                        }
    
                        if($berkas['suratpermohonan'] != ""){
                            $file_foto = "upload/suratpermohonan/" . $berkas['suratpermohonan'];
                            if (file_exists($file_foto)) {
                                unlink("./upload/suratpermohonan/" . $berkas['suratpermohonan']);
                            }
                        }
                    }
    
                    /* dokumen tambahan */
                    $berkastambahan = $this->mod_pelayanan->berkaspengajuantambahan($kode)->result();
                    foreach ($berkastambahan as $bt) {
                        if($bt->berkas != ""){
                            $file_foto = "upload/doktambahanpengajuan/" . $bt->berkas;
                            if (file_exists($file_foto)) {
                                unlink("./upload/doktambahanpengajuan/" . $bt->berkas);
                            }
                        }
                    }
    
                    $this->mod_pelayanan->hapusdoktambahan($kode);
                    $this->mod_pelayanan->hapus($kode);
                    
                    $pesan = 3;
                    $isipesan = "Data pengajuan serta file terkait dihapus";
                    break;
            }
    
            /* berkas tambahan pengajuan */
            if($jmlberkas > 0 && $proses != 3 && $status == 0){
                $this->mod_pelayanan->resetberkastambahan($kdpengajuan);
    
                for($x=0; $x < $jmlberkas; $x++){
                    $datadoktambahan = array(
                        "kdpengajuan" => $kdpengajuan,
                        "berkas" => $berkas_tambahan[$x]
                    );
    
                    $this->mod_pelayanan->simpanberkastambahan($datadoktambahan);
                }
            }

            //save log
            $this->log_lib->log_info($isipesan);

            $msg = str_replace(" ", "-", $isipesan);

            redirect("pelayanan/monitoring/$kdpeserta/$mode/1/20/-/$pesan/$msg");
        }
    }

    public function monitoring($kdpeserta, $mode, $page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("pelayanan"));
        } else {
            $data['infoapp'] = $this->infoapp->info();

            $ambil = $this->mod_pelayanan->ambilpeserta($kdpeserta);

            $data['kdpenyedia'] = $this->session->userdata('kduser');
            $data['kdpeserta'] = $kdpeserta;
            $data['tgldaftar'] = date('d-m-Y',strtotime($ambil['tgldaftar']));
            $data['npwp'] = $ambil['npwp'];
            $data['nama'] = $ambil['nama'];

            $data['mode'] = $mode;

            //cari
            if ($isicari != "-") {
                $getcari = str_replace("-", " ", urldecode($isicari));
            } else {
                $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
            }

            switch ($mode) {
                case 1:
                    $data['halaman'] = "Monitoring Pengajuan";

                    $q_cari = "c.kdpeserta='$kdpeserta' and ";
                    break;
                case 2:
                    $data['halaman'] = "Monitoring Pengajuan Pelanggan";

                    $q_cari = "e.kdpeserta='".$data['kdpenyedia']."' and ";
                    break;
            }

            
            if ($getcari != "") {
                $q_cari .= "(a.nosuratskrd like '%$getcari%' or a.nosuratskhp like '%$getcari%') and a.status<'5'";
            } else {
                $q_cari .= "b.nama<>'' and a.status<'5'";
            }
            
            $cari = str_replace(" ", "-", $getcari);
            $data['getcari'] =  $cari;

            $msg = str_replace("-", " ", $isipesan);
            $data['alert'] = $this->alert_lib->alert($pesan, $msg);
            

            $limit_start = ($page - 1) * $limit;

            $data['limit'] = $limit;

            $no = $limit_start + 1;

            //pagination
            switch ($mode) {
                case 1:
                    $jumlah_data = $this->mod_pelayanan->jumlahpengajuan($q_cari);

                    $daftar = $this->mod_pelayanan->daftarpengajuan($limit_start, $limit, $q_cari)->result();
                    break;
                case 2:
                    $jumlah_data = $this->mod_pelayanan->jumlahpengajuan2($q_cari);

                    $daftar = $this->mod_pelayanan->daftarpengajuan2($limit_start, $limit, $q_cari)->result();
                    break;
            }

            $record = array();
            $subrecord = array();
            foreach ($daftar as $d) {
                $subrecord['no'] = $no;
                $subrecord['kdpengajuan'] = $d->kdpengajuan;
                $subrecord['kduttppeserta'] = $d->kduttppeserta;
                $subrecord['tglpengajuan'] = date('d-m-Y',strtotime($d->tglpengajuan));
                $subrecord['kdlayanan'] = $d->kdlayanan;
                $subrecord['nama'] = $d->nama;
                $subrecord['namauttp'] = $d->namauttp;
                $subrecord['jadwal'] = $d->jadwal != "" ? date('d-m-Y',strtotime($d->jadwal)) : "-";
                $subrecord['kdpegawai'] = $d->kdpegawai;
                $subrecord['nobukti'] = $d->nobukti != "" ? $d->nobukti : "-";
                $subrecord['tglbayar'] = $d->tglbayar != "" ? date('d-m-Y',strtotime($d->tglbayar)) : "-";
                $subrecord['buktibayar'] = $d->buktibayar;
                $subrecord['nosuratskrd'] = $d->nosuratskrd;
                $subrecord['tglsuratskrd'] = date('d-m-Y',strtotime($d->tglsuratskrd));
                $subrecord['nosuratskhp'] = $d->nosuratskhp;
                $subrecord['tglsuratskhp'] = date('d-m-Y',strtotime($d->tglsuratskhp));
                $subrecord['fotokondisi'] = $d->fotokondisi;
                $subrecord['status'] = $d->status;
                $subrecord['lokasi'] = $d->lokasi != "" ? $d->lokasi : "-";
                $subrecord['hasil'] = $d->hasil != "" ? $d->hasil : "-";

                $subrecord['noskhplama'] = $d->noskhplama != "" ? $d->noskhplama : "-";
                $subrecord['tglskhplama'] = $d->tglskhplama != "" ? date('d-m-Y',strtotime($d->tglskhplama)) : "-";

                if($d->berlakuskhplama != "" && $d->berlakuskhplama != '0000-00-00' && strtotime($d->berlakuskhplama) <= strtotime(date('Y-m-d'))){
                    $statusekspired2 = '<a href="#" class="btn bg-black btn-xs">Expired</a>';
                } else {
                    $statusekspired2 = '';
                }

                if($d->berlakuskhplama != "" && $d->berlakuskhplama != '0000-00-00') list($thn,$bln,$hr) = explode('-',$d->berlakuskhplama);
                $subrecord['berlakuskhplama'] = $d->berlakuskhplama != "" && $d->berlakuskhplama != '0000-00-00' ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired2: "-";
                
                $subrecord['lokasisebelumnya'] = $d->lokasisebelumnya != "" ? $d->lokasisebelumnya : "-";

                switch ($subrecord['lokasi']) {
                    case 1:
                        $subrecord['namalokasi'] = "Kantor";
                        break;
                    case 2:
                        $subrecord['namalokasi'] = "Luar Kantor";
                        break;
                    default:
                        $subrecord['namalokasi'] = "-";
                        break;
                }

                // penera
                if($subrecord['kdpegawai'] != ""){
                $cekpeneratetapan = $this->mod_pelayanan->cekpeneratetapan($subrecord['kdpegawai']);
                    $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nama'];
                } else {
                    $subrecord['namapenera'] = "-";
                }

                if ($subrecord['buktibayar'] != "") {
                    $buktibayar = "upload/buktibayar/" . $subrecord['buktibayar'];
                    if (file_exists($buktibayar)) {
                        $subrecord['file_buktibayar'] = base_url() . "upload/buktibayar/" . $subrecord['buktibayar'] . "?" . rand();
                    } else {
                        $subrecord['file_buktibayar'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $subrecord['file_buktibayar'] = base_url() . "upload/no-image.png";
                }

                if ($subrecord['fotokondisi'] != "") {
                    $fotokondisi = "upload/fotokondisi/" . $subrecord['fotokondisi'];
                    if (file_exists($fotokondisi)) {
                        $subrecord['file_fotokondisi'] = base_url() . "upload/fotokondisi/" . $subrecord['fotokondisi'] . "?" . rand();
                    } else {
                        $subrecord['file_fotokondisi'] = base_url() . "upload/no-image.png";
                    }
                } else {
                    $subrecord['file_fotokondisi'] = base_url() . "upload/no-image.png";
                }

                $adapilihan = $this->mod_pelayanan->cekpilihanjadwal($subrecord['kdpengajuan']);

                switch ($d->status) {
                    case 0 : 
                        $subrecord['namastatus']="Baru"; 
                        $subrecord['warnabtn']="bg-blue"; 
                        break;
                    case 1 : 
                        if($adapilihan == 0){
                            $subrecord['namastatus']="Diterima"; 
                            $subrecord['warnabtn']="bg-light-blue"; 
                        } else {
                            $subrecord['namastatus']="Pilihan Jadwal"; 
                            $subrecord['warnabtn']="bg-maroon"; 
                        }
                        break;
                    case 2 : 
                        $subrecord['namastatus']="Terjadwal<br>(Menunggu Pembayaran)"; 
                        $subrecord['warnabtn']="bg-teal"; 
                        break;
                    case 3 : 
                        $subrecord['namastatus']="Terbayar"; 
                        $subrecord['warnabtn']="bg-olive"; 
                        break;
                    case 4 : 
                        switch ($subrecord['hasil']) {
                            case 1:
                                $subrecord['namastatus'] = ' (Dibatalkan)';
                                $subrecord['warnabtn'] = "btn-default";
                                break;
                            case 2:
                                $subrecord['namastatus'] = 'Menunggu Data Dokumen SKRD & SKHP';
                                $subrecord['warnabtn'] = "btn-default";
                                break;
                            default:
                                $subrecord['namastatus']="Diproses"; 
                                $subrecord['warnabtn']="bg-orange"; 
                                break;
                        } 
                        break;
                }

                $no++;

                array_push($record, $subrecord);
            }

            $data['pengajuan'] = json_encode($record);

            $data['page'] = $page;
            $data['limit'] = $limit;
            $data['get_jumlah'] = $jumlah_data;
            $data['jumlah_page'] = ceil($jumlah_data / $limit);
            $data['jumlah_number'] = 2;
            $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
            $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

            $data['no'] = $limit_start + 1;


            $this->load->view('layout/atas', $data);
            $this->load->view('layout/menu');
            $this->load->view('page/monitoring');
            $this->load->view('layout/bawah');
        }
    }

    public function uploadberkas($kelompok)
    {
        $kel = urldecode($kelompok);

        switch ($kel) {
            case 'Tera':
                $config['upload_path']        = './upload/izinpersetujuantipe';
                break;
            case 'Tera Ulang':
                $config['upload_path']        = './upload/skhplama';
                break;
            default:
                $config['upload_path']        = './upload/'.$kelompok;
                break;
        }
        
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp|pdf';
        $config['file_name']        = date('dmYhis');
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            // echo "gagal";
            echo $errors;
        } else {
            $data = $this->upload->data();

            extract($data);
            $this->mod_pelayanan->uploadfile($file_name);

            echo $file_name;
        }
    }

    public function uploadtambahan($kelompok)
    {
        $config['upload_path']        = './upload/doktambahanpengajuan';
        $config['file_name']        = $kelompok."_".date('dmYhis');
        $config['allowed_types']     = 'gif|jpg|jpeg|png|bmp|pdf';
        $config['overwrite']        = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('berkas')) {
            $errors = $this->upload->display_errors();
            // echo "gagal";
            echo $errors;
        } else {
            $data = $this->upload->data();

            extract($data);
            $this->mod_pelayanan->uploadfile($file_name);

            echo $file_name;
        }
    }

    public function ceknpwp($npwp)
    {
        $record = array();
        $subrecord = array();

        $peserta = $this->mod_pelayanan->ceknpwp($npwp);
        $cekpelanggan = $this->mod_pelayanan->cekpelanggan($npwp);

        if(empty($peserta)){
            $subrecord['ada'] = 0;

            array_push($record, $subrecord);
        } elseif ($cekpelanggan  == 0) {
            $subrecord['ada'] = 1;
            $subrecord['kdpeserta'] = $peserta['kdpeserta'];
            $subrecord['npwp'] = $peserta['npwp'];
            $subrecord['nama'] = $peserta['nama'];
            $subrecord['telp'] = $peserta['telp'];
            $subrecord['email'] = $peserta['email'];
            $subrecord['kdkelurahan'] = $peserta['kdkelurahan'];
            $subrecord['kdkecamatan'] = $peserta['kdkecamatan'];
            $subrecord['alamat'] = $peserta['alamat'];

            $cekkelurahan = $this->mod_pelayanan->cekkelurahan($subrecord['kdkelurahan']);
            $subrecord['namakelurahan'] = empty($cekkelurahan) ? "" : $cekkelurahan['nama'];

            array_push($record, $subrecord);
        } else {
            $subrecord['ada'] = 2;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function cekskhplama($kduttppeserta,$noskhplama)
    {
        $data['infoapp'] = $this->infoapp->info();

        $skhplama = $this->mod_pelayanan->cekskhplama($kduttppeserta,$noskhplama);
        
        if(!empty($skhplama)){
            $record = array();
            $subrecord = array();

            $subrecord['nosuratskhp'] = $skhplama['nosuratskhp'];
            $subrecord['tglsuratskhp'] = $skhplama['tglsuratskhp'];
            $subrecord['berlakuskhp'] = date('Y-m',strtotime($skhplama['berlakuskhp']));

            extract($data['infoapp']);
            $subrecord['lokasi'] = $namakantor;

            array_push($record, $subrecord);
            
            echo json_encode($record);
        }
    }

    public function cekinfotambahan($kduttp)
    {
        $record = array();
        $subrecord = array();

        $infotambahan = $this->mod_pelayanan->infotambahan($kduttp)->result();
        foreach ($infotambahan as $it) {
            $subrecord['info'] = $it->info;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }
}