<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uttp extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_uttp');
    }

    public function index($page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "UTTP Wajib Tera";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $q_cari = "";
        if ($getcari != "") {
            $q_cari = "nama like '%$getcari%'";
        } else {
            $q_cari = "nama<>''";
        }
        
        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_uttp->jumlah($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
            
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $daftar = $this->mod_uttp->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kduttp'] = $d->kduttp;
            $subrecord['kdlayanan'] = $d->kdlayanan;
            $subrecord['nama'] = $d->nama;
            $subrecord['berlaku'] = $d->berlaku;
            $subrecord['lama'] = $d->lama;
            $subrecord['keterangan'] = $d->keterangan;
            $subrecord['berkas'] = $d->gambar;

            /* layanan */
            if($d->kdlayanan == "" || $d->kdlayanan == 0){
                $subrecord['namalayanan'] = "Semua Layanan Aktif";
            } else {
                $ceklayanan = $this->mod_uttp->ceklayanan($d->kdlayanan);
                $subrecord['namalayanan'] = empty($ceklayanan) || $ceklayanan['nama'] == "" ? "-":$ceklayanan['nama'];
            }
            
            /* check dokumen tambahan */
            $subrecord['doktambahan'] = "";
            $doktambahan = $this->mod_uttp->doktambahan($d->kduttp)->result();
            foreach ($doktambahan as $dt) {
                $subrecord['doktambahan'] .= $dt->nama.", ";
            }

            /* check info tambahan */
            $subrecord['infotambahan'] = "";
            $infotambahan = $this->mod_uttp->infotambahan($d->kduttp)->result();
            foreach ($infotambahan as $it) {
                $subrecord['infotambahan'] .= $it->info.", ";
            }

            $subrecord['info'] =  "<span class='text-bold'>".$d->nama."</span>";

            if($d->berlaku != "0" && $d->berlaku != ""){
                $subrecord['info'] .= "<br><span class='text-bold'>Masa berlaku SKHP:</span> <span class='text-red'>".$d->berlaku." bulan</span>";
            } else {
                $subrecord['info'] .= "<br><span class='text-bold'>Masa berlaku SKHP:</span> <span class='text-red'>-</span>";
            }

            // if($d->batas != "0" && $d->batas != ""){
            //     $subrecord['info'] .= "<br><span class='text-bold'>Batas jml unit per-penera/hari:</span> <span class='text-red'>".$d->batas." unit</span>";
            // } else {
            //     $subrecord['info'] .= "<br><span class='text-bold'>Batas jml unit per-penera/hari:</span> <span class='text-red'>-</span>";
            // }

            if($d->lama != "0" && $d->lama != ""){
                $subrecord['info'] .= "<br><span class='text-bold'>Lama pengerjaan per-unit:</span> <span class='text-red'>".$d->lama." menit</span>";
            } else {
                $subrecord['info'] .= "<br><span class='text-bold'>Lama pengerjaan per-unit:</span> <span class='text-red'>-</span>";
            }

            if($subrecord['doktambahan'] != ""){
                $subrecord['adadoktambahan'] = "btn-primary";
            } else {
                $subrecord['adadoktambahan'] = "btn-default";
            }

            if($subrecord['infotambahan'] != ""){
                $subrecord['adainfotambahan'] = "btn-primary";
            } else {
                $subrecord['adainfotambahan'] = "btn-default";
            }

            /* layanan */
            if($d->kdlayanan == "" || $d->kdlayanan == 0){
                $subrecord['namalayanan'] = "Semua Layanan Aktif";
                $subrecord['info'] .= "<br><span class='text-bold'>Layanan aktif:</span> <span class='text-red'>Semua Layanan</span>";
            } else {
                $ceklayanan = $this->mod_uttp->ceklayanan($d->kdlayanan);
                $subrecord['namalayanan'] = empty($ceklayanan) || $ceklayanan['nama'] == "" ? "-":$ceklayanan['nama'];
                $subrecord['info'] .= "<br><span class='text-bold'>Layanan aktif:</span> <span class='text-red'>".$subrecord['namalayanan']."</span>";
            }

            if($d->keterangan != ""){
                $subrecord['info'] .= "<br><span class='text-bold'>Keterangan:</span><br>".$d->keterangan;
            } else {
                $subrecord['info'] .= "<br><span class='text-bold'>Keterangan:</span><br>tidak ada";
            }

            if ($subrecord['berkas'] != "") {
                $berkas = "upload/uttp/" . $subrecord['berkas'];
                if (file_exists($berkas)) {
                    $subrecord['file_berkas'] = base_url() . "upload/uttp/" . $subrecord['berkas'] . "?" . rand();
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

        //save log
        $this->log_lib->log_info("Akses halaman daftar uttp");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/uttp');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($proses, $kode = "")
    {
        $data['halaman'] = "UTTP Wajib Tera";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        $data['layanan'] = $this->mod_uttp->layanan()->result();

        if($kode != ""){
            $ambil = $this->mod_uttp->ambil($kode);

            $data['kduttp'] = $ambil['kduttp'];
            $data['kdlayanan'] = $ambil['kdlayanan'];
            $data['nama'] = $ambil['nama'];
            $data['berlaku'] = $ambil['berlaku'];
            $data['lama'] = $ambil['lama'];
            $data['keterangan'] = $ambil['keterangan'];
            $data['berkas'] = $ambil['gambar'] != "" ? $ambil['gambar'] : date('dmYhis');

            if ($ambil['gambar'] != "") {
                $berkas = "upload/uttp/" . $ambil['gambar'];
                if (file_exists($berkas)) {
                    $data['file_berkas'] = base_url() . "upload/uttp/" . $ambil['gambar'] . "?" . rand();
                } else {
                    $data['file_berkas'] = base_url() . "upload/no-image.png";
                }
            } else {
                $data['file_berkas'] = base_url() . "upload/no-image.png";
            }
        } else {
            $data['kduttp'] = "";
            $data['kdlayanan'] = 0;
            $data['nama'] = "";
            $data['berlaku'] = 0;
            $data['lama'] = 0;
            $data['keterangan'] = "";
            $data['berkas'] = date('dmYhis');
            $data['file_berkas'] = base_url() . "upload/no-image.png";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir uttp");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_uttp');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses($proses = 1, $kode = "")
    {
        if ($proses != 3) {
            $kduttp = $this->input->post('kode');
            $kdlayanan = $this->input->post('kdlayanan');
            $awal = $this->input->post('nama_awal');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));
            $berlaku = $this->input->post('berlaku');
            $lama = $this->input->post('lama');
            $keterangan = $this->input->post('keterangan');
            $berkas = $this->input->post('berkas');

            $cek_nama = $this->mod_uttp->cek_nama($nama);

            $data = array(
                "kduttp" => $kduttp,
                "kdlayanan" => $kdlayanan,
                "nama" => $nama,
                "berlaku" => $berlaku,
                "lama" => $lama,
                "keterangan" => $keterangan,
                "berkas" => $berkas
            );
        }

        switch ($proses) {
            case 1:
                if ($cek_nama == 0) {
                    $this->mod_uttp->simpan($data);

                    $pesan = 1;
                    $isipesan = "Daftar uttp baru di tambahkan";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama uttp sudah terdaftar";
                }
                break;
            case 2:
                if ($awal == $nama  || ($awal != $nama && $cek_nama == 0)) {
                    $this->mod_uttp->ubah($data);
                    $pesan = 2;
                    $isipesan = "Data uttp diubah";
                } else {
                    $pesan = 4;
                    $isipesan = "Nama uttp sudah terdaftar";
                }
                break;
            case 3:
                $berkas = $this->mod_uttp->berkas($kode);
                if(!empty($berkas)){
                    $file_berkas = "upload/uttp/" . $berkas['gambar'];
                    if (file_exists($file_berkas)) {
                        unlink("./upload/uttp/" . $berkas['gambar']);
                    }
                }

                $this->mod_uttp->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Daftar uttp telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("uttp/index/1/20/-/$pesan/$msg");
    }

    public function upload($namaberkas)
    {
        $config['upload_path']        = './upload/uttp';
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

            echo $file_name;
        }
    }

    public function doktambahan($kduttp, $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "UTTP Wajib Tera";

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_uttp->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama']=="" ? "-":$cekuttp['nama'];

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $daftar = $this->mod_uttp->daftardok($kduttp)->result();

        $no=1; 

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kddoktambahan'] = $d->kddoktambahan;
            $subrecord['kduttp'] = $d->kduttp;
            $subrecord['nama'] = $d->nama;
            $subrecord['berkas'] = $d->berkas;

            if ($subrecord['berkas'] != "") {
                $berkas = "upload/doktambahan/" . $subrecord['berkas'];
                if (file_exists($berkas)) {
                    $subrecord['file_berkas'] = base_url() . "upload/doktambahan/" . $subrecord['berkas'];
                } else {
                    $subrecord['file_berkas'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord['file_berkas'] = base_url() . "upload/no-image.png";
            }

            $no++;

            array_push($record, $subrecord);
        }

        $data['doktambahan'] = json_encode($record);

        //save log
        $this->log_lib->log_info("Akses halaman daftar dokumen persyaratan tambahan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/doktambahan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulirdokumen($proses, $kduttp, $kode = "")
    {
        $data['halaman'] = "UTTP Wajib Tera";

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_uttp->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama']=="" ? "-":$cekuttp['nama'];

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        if($kode != ""){
            $ambil = $this->mod_uttp->ambildokumen($kode);

            $data['kddoktambahan'] = $ambil['kddoktambahan'];
            $data['nama'] = $ambil['nama'];
            $data['berkas'] = $ambil['berkas'] != "" ? $ambil['berkas'] : "";

            if ($ambil['berkas'] != "") {
                $berkas = "upload/doktambahan/" . $ambil['berkas'];
                if (file_exists($berkas)) {
                    $data['file_berkas'] = base_url() . "upload/doktambahan/" . $ambil['berkas'];
                } else {
                    $data['file_berkas'] = base_url() . "upload/no-image.png";
                }
            } else {
                $data['file_berkas'] = base_url() . "upload/no-image.png";
            }
        } else {
            $data['kddoktambahan'] = "";
            $data['nama'] = "";
            $data['berkas'] = "";
            $data['file_berkas'] = base_url() . "upload/no-image.png";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir dokumen persyaratan tambahan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_dokumen');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function prosesdokumen($proses = 1, $kduttp = "", $kode = "")
    {
        if ($proses != 3) {
            $kddoktambahan = $this->input->post('kode');
            $kduttp = $this->input->post('kduttp');
            $nama = $this->clear_string->clear_quotes($this->input->post('nama'));
            $berkas = $this->input->post('berkas');

            $data = array(
                "kduttp" => $kduttp,
                "kddoktambahan" => $kddoktambahan,
                "nama" => $nama,
                "berkas" => $berkas
            );
        }

        switch ($proses) {
            case 1:
                $this->mod_uttp->simpandokumen($data);

                $pesan = 1;
                $isipesan = "Daftar dokumen persyaratan baru di tambahkan";
                break;
            case 2:
                $this->mod_uttp->ubahdokumen($data);

                $pesan = 2;
                $isipesan = "Data dokumen persyaratan diubah";
                break;
            case 3:
                $berkas = $this->mod_uttp->berkasdokumen($kode);
                if(!empty($berkas)){
                    $file_berkas = "upload/doktambahan/" . $berkas['berkas'];
                    if (file_exists($file_berkas)) {
                        unlink("./upload/doktambahan/" . $berkas['berkas']);
                    }
                }

                $this->mod_uttp->hapusdokumen($kode);
                
                $pesan = 3;
                $isipesan = "Daftar dokumen persyaratan telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("uttp/doktambahan/$kduttp/$pesan/$msg");
    }

    public function uploaddokumen($namaberkas)
    {
        $config['upload_path']        = './upload/doktambahan';
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

            echo $file_name;
        }
    }

    public function batalberkas($namafile)
    {
        $file_berkas = "upload/doktambahan/" . $namafile;
        if (file_exists($file_berkas)) {
            unlink("./upload/doktambahan/" . $namafile);
        }
    }

    public function infotambahan($kduttp, $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "UTTP Wajib Tera";

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_uttp->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama']=="" ? "-":$cekuttp['nama'];

        $data['infoapp'] = $this->infoapp->info();

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        $daftar = $this->mod_uttp->daftarinfo($kduttp)->result();

        $no=1; 

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdinfotambahan'] = $d->kdinfotambahan;
            $subrecord['kduttp'] = $d->kduttp;
            $subrecord['info'] = $d->info;

            $no++;

            array_push($record, $subrecord);
        }

        $data['infotambahan'] = json_encode($record);

        //save log
        $this->log_lib->log_info("Akses halaman daftar informasi tambahan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/infotambahan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulirinfotambahan($proses, $kduttp, $kode = "")
    {
        $data['halaman'] = "UTTP Wajib Tera";

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_uttp->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama']=="" ? "-":$cekuttp['nama'];

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        if($kode != ""){
            $ambil = $this->mod_uttp->ambilinfotambahan($kode);

            $data['kdinfotambahan'] = $ambil['kdinfotambahan'];
            $data['info'] = $ambil['info'];
        } else {
            $data['kdinfotambahan'] = "";
            $data['info'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir informasi tambahan");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_infotambahan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function prosesinfotambahan($proses = 1, $kduttp = "", $kode = "")
    {
        if ($proses != 3) {
            $kdinfotambahan = $this->input->post('kode');
            $kduttp = $this->input->post('kduttp');
            $info = $this->clear_string->clear_quotes($this->input->post('info'));

            $data = array(
                "kduttp" => $kduttp,
                "kdinfotambahan" => $kdinfotambahan,
                "info" => $info
            );
        }

        switch ($proses) {
            case 1:
                $this->mod_uttp->simpaninfotambahan($data);

                $pesan = 1;
                $isipesan = "Informasi tambahan baru di tambahkan";
                break;
            case 2:
                $this->mod_uttp->ubahinfotambahan($data);

                $pesan = 2;
                $isipesan = "Informasi tambahan diubah";
                break;
            case 3:
                $this->mod_uttp->hapusinfotambahan($kode);
                
                $pesan = 3;
                $isipesan = "Informasi tambahan telah dikurangi ";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("uttp/infotambahan/$kduttp/$pesan/$msg");
    }
}