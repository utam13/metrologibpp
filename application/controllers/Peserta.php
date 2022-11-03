<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_peserta');
    }

    public function index($page = 1, $limit = 20, $isikategori = "-", $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Peserta Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
            $getkategori = str_replace("-", " ", urldecode($isikategori));
        } else {
            $getkategori = $this->input->post('kategori');
            switch ($getkategori) {
                case 'status':
                    $getcari = $this->clear_string->clear_quotes($this->input->post('statuscari'));
                    break;
                default:
                    $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
                    break;
            }
        }

        $q_cari = "kelompok<>'3' and ";
        // $q_cari = "";
        if ($getcari != "") {
            $q_cari .= "$getkategori like '%$getcari%'";
        } else {
            $q_cari .= "npwp<>''";
        }

        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $kategori = str_replace(" ", "-", $getkategori);
        $data['getkategori'] =  $kategori;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_peserta->jumlah_data($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $pegawai = $this->mod_peserta->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($pegawai as $p) {
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
            $subrecord['nik'] = $p->nik;
            $subrecord['namapic'] = $p->namapic;
            $subrecord['jabatan'] = $p->jabatan;
            $subrecord['telppic'] = $p->telppic;
            $subrecord['wa'] = $p->wa;
            $subrecord['emailpic'] = $p->emailpic;
            $subrecord['password'] = $p->password;
            $subrecord['status'] = $p->status;

            switch ($subrecord['kelompok']) {
                case 1:
                    $subrecord['namakelompok'] = "Pemilik Alat";
                    
                    $jmluttp = $this->mod_peserta->hitunguttp($p->kdpeserta);
                    $subrecord['jmluttp'] = "<a href='".base_url()."uttppeserta/index/".$p->kdpeserta."/1' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";

                    $subrecord['jmlpelanggan'] = "-";

                    switch ($p->status) {
                        case 0:
                            $subrecord['namastatus'] = "<a href='".base_url()."peserta/formulir/4/".$p->kdpeserta."' class='btn bg-red btn-xs'>Baru</a>";
                            break;
                        case 1:
                            $subrecord['namastatus'] = "<a href='#' class='btn bg-green btn-xs'>Diterima</a>";
                            break;
                    }

                    // cek skhp expired
                    $totalexpired = $this->mod_peserta->totalexpired($p->kdpeserta,date('Y-m-d'));
                    $subrecord['totalexpired'] = $totalexpired == 0 ? "-":"<a href='".base_url()."permintaan/index/1/20/e.npwp/".$p->npwp."' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";
                    break;
                case 2:
                    $subrecord['namakelompok'] = "Penyedia Alat";

                    $jmluttp = $this->mod_peserta->hitunguttp2($p->kdpeserta);
                    $subrecord['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";

                    $jmlpelanggan = $this->mod_peserta->hitungpelanggan($p->kdpeserta);
                    $subrecord['jmlpelanggan'] = "<a href='".base_url()."pelanggan/index/".$p->kdpeserta."' class='btn bg-blue btn-xs'>$jmlpelanggan pelanggan</a>";

                    switch ($p->status) {
                        case 0:
                            $subrecord['namastatus'] = "<a href='".base_url()."peserta/formulir/4/".$p->kdpeserta."' class='btn bg-red btn-xs'>Baru</a>";
                            break;
                        case 1:
                            $subrecord['namastatus'] = "<a href='#' class='btn bg-green btn-xs'>Diterima</a>";
                            break;
                    }

                    // cek skhp expired
                    $totalexpired = $this->mod_peserta->totalexpired2($p->kdpeserta,date('Y-m-d'));
                    $subrecord['totalexpired'] = $totalexpired == 0 ? "-":"<a href='".base_url()."pelanggan/index/".$p->kdpeserta."' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";
                    break;
                case 3:
                    $subrecord['namakelompok'] = "Pemakai Alat";
                    
                    $jmluttp = $this->mod_peserta->hitunguttppakai($p->kdpeserta);
                    // $subrecord['jmluttp'] = "<a href='".base_url()."peserta/uttp/".$p->kdpeserta."' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";
                    $subrecord['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";

                    $subrecord['jmlpelanggan'] = "-";

                    $subrecord['namastatus'] = "-";

                    // cek skhp expired
                    $totalexpired = $this->mod_peserta->totalexpired($p->kdpeserta,date('Y-m-d'));
                    $subrecord['totalexpired'] = $totalexpired == 0 ? "-":"<a href='".base_url()."permintaan/index/1/20/e.npwp/".$p->npwp."' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";
                    break;
            }

            $kecamatan = $this->mod_peserta->kecamatan($p->kdkecamatan);
            $subrecord['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];

            $kelurahan = $this->mod_peserta->kelurahan($p->kdkelurahan);
            $subrecord['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

            $no++;

            array_push($record, $subrecord);
        }
        $data['peserta'] = json_encode($record);

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
        $this->log_lib->log_info("Akses halaman peserta tera atau tera Ulang");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/peserta');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "Peserta Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        $data['daftarkecamatan'] = $this->mod_peserta->ambilkecamatan()->result();

        if($kode != ""){
            $ambil = $this->mod_peserta->ambil($kode);

            $data['kdpeserta'] = $ambil['kdpeserta'];
            $data['kelompok'] = $ambil['kelompok'] == 3 ? 1:$ambil['kelompok'];
            $data['tgldaftar'] = date('d-m-Y',strtotime($ambil['tgldaftar']));
            $data['npwp'] = $ambil['npwp'];
            $data['nama'] = $ambil['nama'];
            $data['alamat'] = $ambil['alamat'];
            $data['telp'] = $ambil['telp'];
            $data['email'] = $ambil['email'];
            $data['kelurahan'] = $ambil['kdkelurahan'];
            $data['kecamatan'] = $ambil['kdkecamatan'];
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

            $data['daftarkelurahan'] = $this->mod_peserta->ambilkelurahan($ambil['kdkecamatan'])->result();
            
            // if ($ambil['izinusaha'] != "") {
            //     $berkas = "upload/pelayanan/" . $ambil['izinusaha'];
            //     if (file_exists($berkas)) {
            //         $data['file_izinusaha'] = base_url() . "peserta/viewPdf/" . $ambil['izinusaha'] . "?" . rand();
            //     } else {
            //         $data['file_izinusaha'] = "";
            //     }
            // } else {
            //     $data['file_izinusaha'] = "";
            // }

            // if ($ambil['aktapendirian'] != "") {
            //     $berkas = "upload/pelayanan/" . $ambil['aktapendirian'];
            //     if (file_exists($berkas)) {
            //         $data['file_aktapendirian'] = base_url() . "peserta/viewPdf/" . $ambil['aktapendirian'] . "?" . rand();
            //     } else {
            //         $data['file_aktapendirian'] = "";
            //     }
            // } else {
            //     $data['file_aktapendirian'] = "";
            // }

            // if ($ambil['ktp'] != "") {
            //     $berkas = "upload/pelayanan/" . $ambil['ktp'];
            //     if (file_exists($berkas)) {
            //         $data['file_ktp'] = base_url() . "peserta/viewPdf/" . $ambil['ktp'] . "?" . rand();
            //     } else {
            //         $data['file_ktp'] = "";
            //     }
            // } else {
            //     $data['file_ktp'] = "";
            // }

            if($data['kelompok'] == 3){
                $cekpenyedia = $this->mod_peserta->cekpenyedia($data['kdpeserta']);
                $data['kdpenyedia'] = empty($cekpenyedia) ? "-":$cekpenyedia['kdpeserta'];
            } else {
                $data['kdpenyedia'] = "";
            }
        } else {
            $data['kdpeserta'] = "";
            $data['kelompok'] = "";
            $data['tgldaftar'] = date('d-m-Y');
            $data['npwp'] = "";
            $data['nama'] = "";
            $data['alamat'] = "";
            $data['telp'] = "";
            $data['email'] = "";
            $data['kelurahan'] = "";
            $data['kecamatan'] = "";
            $data['nik'] = "";
            $data['namapic'] = "";
            $data['jabatan'] = "";
            $data['telppic'] = "";
            $data['wa'] = "";
            $data['emailpic'] = "";
            $data['status'] = "";
            $data['password'] = "";
            $data['kdpenyedia'] = "";
            // $data['izinusaha'] = "";
            // $data['aktapendirian'] = "";
            // $data['ktp'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir peserta tera atau tera ulang");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_peserta');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function kelurahan($kdkecamatan)
    {
        $record = array();
        $subrecord = array();

        $kelurahan = $this->mod_peserta->ambilkelurahan($kdkecamatan)->result();
        foreach ($kelurahan as $k) {
            $subrecord['kdkelurahan'] = $k->kdkelurahan;
            $subrecord['nama'] = $k->nama;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function cek($target,$value)
    {
        $ada = $this->mod_peserta->cek($target,$value);

        echo $ada;
    }

    public function ceknpwp($npwp)
    {
        $record = array();
        $subrecord = array();

        $peserta = $this->mod_peserta->ceknpwp($npwp);
        $cekpelanggan = $this->mod_peserta->cekpelanggan($npwp);

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

            $cekkelurahan = $this->mod_peserta->cekkelurahan($subrecord['kdkelurahan']);
            $subrecord['namakelurahan'] = empty($cekkelurahan) ? "" : $cekkelurahan['nama'];

            array_push($record, $subrecord);
        } else {
            $subrecord['ada'] = 2;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function proses($proses = 1, $kode = "")
    {
        if($proses != 3){
            $kdpeserta =  $this->input->post('kode');
            $kelompok =  $this->input->post('kelompok');
            $tgldaftar = date('Y-m-d');
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
            $password = $this->input->post('password');

            switch ($proses) {
                case 1:
                    $status = 1;
                    break;
                default:
                    $status = $this->input->post('status');
                    break;
            }
    
            $data = array(
                "kdpeserta" => $kdpeserta,
                "kelompok" => $kelompok,
                "tgldaftar" => $tgldaftar,
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
                "emailpic" => $emailpic,
                // "izinusaha" => $izinusaha,
                // "aktapendirian" => $aktapendirian,
                // "ktp" => $ktp,
                "status" => $status,
                "password" => $password
            );
        }

        switch ($proses) {
            case 1:
                $this->mod_peserta->simpan($data);

                $pesan = 1;
                $isipesan = "Daftar peserta baru di tambahkan";
                break;
            case 2:
                $this->mod_peserta->ubah($data);
                $pesan = 2;
                $isipesan = "Data peserta diubah";
                break;
            case 3:
                $cekkelompok = $this->mod_peserta->cekkelompok($kod);
                $kelompok = empty($cekkelompok) ? 0:$cekkelompok['kelompok'];

                switch ($kelompok) {
                    case 1:
                        $adapelanggan = 0;
                        break;
                    case 2:
                        $adapelanggan = $this->mod_peserta->adapelanggan($kode);
                        break;
                    default:
                        $adapelanggan = 0;
                        break;
                }

                $adapengajuan = $this->mod_peserta->adapengajuan($kode);

                if($adapengajuan == 0 && $adapelanggan == 0) {
                    // $berkas = $this->mod_peserta->berkas($kode);
                    // if(!empty($berkas)){
                    //     if($berkas['izinusaha'] != ""){
                    //         $file_izinusaha = "upload/pelayanan/" . $berkas['izinusaha'];
                    //         if (file_exists($file_izinusaha)) {
                    //             unlink("./upload/pelayanan/" . $berkas['izinusaha']);
                    //         }
                    //     }

                    //     if($berkas['aktapendirian'] != ""){
                    //         $file_aktapendirian = "upload/pelayanan/" . $berkas['aktapendirian'];
                    //         if (file_exists($file_aktapendirian)) {
                    //             unlink("./upload/pelayanan/" . $berkas['aktapendirian']);
                    //         }
                    //     }

                    //     if($berkas['ktp'] != ""){
                    //         $file_ktp = "upload/pelayanan/" . $berkas['ktp'];
                    //         if (file_exists($file_ktp)) {
                    //             unlink("./upload/pelayanan/" . $berkas['ktp']);
                    //         }
                    //     }
                    // }

                    $adauttp = $this->mod_peserta->uttppeserta($kode);
                    if($adauttp > 0){
                        $berkassemuauttp = $this->mod_peserta->berkassemuauttp($kode);
                        foreach ($berkassemuauttp as $b) {
                            if($b->foto != ""){
                                $file_foto = "upload/uttppeserta/" . $b->foto;
                                if (file_exists($file_foto)) {
                                    unlink("./upload/uttppeserta/" . $b->foto);
                                }
                            }
                        }
                    }

                    $this->mod_peserta->hapussemuauttp($kode);

                    $this->mod_peserta->hapus($kode);
                    
                    $pesan = 3;
                    $isipesan = "Daftar peserta telah dikurangi beserta berkas, data uttp dan data permintaan yang terkait";
                } else {
                    if($adapengajuan != 0) {
                        $pesan = 4;
                        $isipesan = "Ada data pengajuan pelayanan tera atau tera ulang dari peserta";
                    }

                    if($adapelanggan != 0) {
                        $pesan = 4;
                        $isipesan = "Masih memiliki pelanggan yang terdaftar sebagai pengguna alat UTTP";
                    }
                }
                break;
            case 4:
                $this->mod_peserta->terima($kdpeserta,$password);
                $pesan = 2;
                $isipesan = "Registrasi peserta dengan NPWP $npwp diterima, segera diinformasikan kepada peserta melalui email atau whatsapp";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("peserta/index/1/20/-/-/$pesan/$msg");
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
            $this->mod_peserta->uploadfile($file_name);

            echo $file_name;
        }
    }

    function viewPdf($namafile)
    {
        header("content-type: application/pdf");
        readfile('./upload/pelayanan/' . $namafile);
    }

    public function batalberkas($namafile)
    {
        $file_berkas = "upload/pelayanan/" . $namafile;
        if (file_exists($file_berkas)) {
            unlink("./upload/pelayanan/" . $namafile);
        }
    }
}