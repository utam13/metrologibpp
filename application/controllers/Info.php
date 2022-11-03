<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('mod_info');
    }

    public function regulasi()
    {
        $data['halaman'] = "Regulasi";

        $data['infoapp'] = $this->infoapp->info();

        $data['regulasi']= $this->mod_info->regulasi()->result();

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/regulasi');
        $this->load->view('layout/bawah');
    }

    public function sop()
    {
        $data['halaman'] = "SOP";

        $data['infoapp'] = $this->infoapp->info();

        $data['sop']= $this->mod_info->sop()->result();

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/sop');
        $this->load->view('layout/bawah');
    }

    public function pegawai($page = 1, $limit = 20, $isicari = "-")
    {
        $data['halaman'] = "Pegawai";

        $data['infoapp'] = $this->infoapp->info();

        $struktur = $this->mod_info->struktur();

        if ($struktur['berkas'] != "") {
            $berkas = "upload/struktur/" . $struktur['berkas'];
            if (file_exists($berkas)) {
                $data['file_struktur'] = base_url() . "upload/struktur/" . $struktur['berkas'] . "?" . rand();
            } else {
                $data['file_struktur'] = base_url() . "upload/no-image.png";
            }
        } else {
            $data['file_struktur'] = base_url() . "upload/no-image.png";
        }

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $q_cari = "";
        if ($getcari != "") {
            $q_cari = "(a.nip like '%$getcari%' or a.nama like '%$getcari%')";
        } else {
            $q_cari = "a.nip<>''";
        }

        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        //pagination
        $jumlah_data = $this->mod_info->jumlah_pegawai($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;
        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $pegawai = $this->mod_info->daftar_pegawai($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($pegawai as $p) {
            $subrecord['no'] = $no;
            $subrecord['kdpegawai'] = $p->kdpegawai;
            $subrecord['nip'] = $p->nip;
            $subrecord['nama'] = $p->nama;
            $subrecord['jabatan'] = $p->jabatan;
            $subrecord['password'] = $p->password;
            $subrecord['level'] = $p->level;

            $no++;

            array_push($record, $subrecord);
        }
        $data['pegawai'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;
        //end

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/pegawai');
        $this->load->view('layout/bawah');
    }

    public function uttpwajibtera($page = 1, $limit = 20, $isicari = "-")
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

        //pagination
        $jumlah_data = $this->mod_info->jumlah_uttp($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
            
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $daftar = $this->mod_info->daftar_uttp($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kduttp'] = $d->kduttp;
            $subrecord['nama'] = $d->nama;
            $subrecord['keterangan'] = $d->keterangan;
            $subrecord['berkas'] = $d->gambar;

            /* check dokumen tambahan */
            $subrecord['doktambahan'] = "";
            $doktambahan = $this->mod_info->doktambahan($d->kduttp)->result();
            foreach ($doktambahan as $dt) {
                $subrecord['doktambahan'] .= $dt->nama.", ";
            }

            $cekuttpterdata = $this->mod_info->cekuttpterdata($d->kduttp);
            $subrecord['total'] = $cekuttpterdata['total'];

            $subrecord['info'] =  "<span class='text-bold nama-uttp'>".$d->nama."</span>";
            $subrecord['info'] .=  "<br><span class='text-bold'>Total terdata:</span> <span class='text-red'>".$subrecord['total']." unit</span>";
            if($d->teraulang != "0"){
                $subrecord['teraulang'] = $d->teraulang." tahun";
                $subrecord['info'] .= "<br><span class='text-bold'>Jangka waktu tera ulang:</span> <span class='text-red'>".$d->teraulang." tahun</span>";
            } else {
                $subrecord['teraulang'] = "tidak ditentukan";
                $subrecord['info'] .= "<br><span class='text-bold'>Jangka waktu tera ulang:</span> <span class='text-red'>tidak ditentukan</span>";
            }

            if($subrecord['doktambahan'] != ""){
                $subrecord['info'] .= "<br><span class='text-bold'>Dokumen Tambahan yang dibutuhkan:</span> <span class='text-red'>".$subrecord['doktambahan']." tahun</span>";
            } else {
                $subrecord['info'] .= "<br><span class='text-bold'>Dokumen Tambahan yang dibutuhkan:</span> <span class='text-red'>tidak ada</span>";
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

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/uttp');
        $this->load->view('layout/bawah');
    }

    function viewPdf($kelompok,$namafile)
    {
        header("content-type: application/pdf");
        readfile('./upload/'.$kelompok.'/' . $namafile);
    }

    public function detailkecamatan($kduttp)
    {
        $data['halaman'] = "UTTP Wajib Tera Per-Kecamatan";

        $data['infoapp'] = $this->infoapp->info();

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_info->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama'] == "" ? "-" : $cekuttp['nama'];

        $no = 1;

        $daftar = $this->mod_info->daftar_kecamatan()->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdkecamatan'] = $d->kdkecamatan;
            $subrecord['nama'] = $d->nama;

            $cekuttpkecamatan= $this->mod_info->cekuttpkecamatan($kduttp, $d->kdkecamatan);
            $subrecord['total'] = $cekuttpkecamatan['total'] == 0 ? "-":$cekuttpkecamatan['total']." unit";

            $no++;

            array_push($record, $subrecord);
        }

        $data['kecamatan'] = json_encode($record);

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/detailkecamatan');
        $this->load->view('layout/bawah');
    }

    public function detailkelurahan($kduttp,$kdkecamatan)
    {
        $data['halaman'] = "UTTP Wajib Tera Per-Kelurahan";

        $data['infoapp'] = $this->infoapp->info();

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_info->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama'] == "" ? "-" : $cekuttp['nama'];

        $data['kdkecamatan'] = $kdkecamatan;
        $cekkecamatan = $this->mod_info->cekkecamatan($kdkecamatan);
        $data['namakecamatan'] = empty($cekkecamatan) || $cekkecamatan['nama'] == "" ? "-" : $cekkecamatan['nama'];

        $no = 1;

        $daftar = $this->mod_info->daftar_kelurahan($kdkecamatan)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdkelurahan'] = $d->kdkelurahan;
            $subrecord['nama'] = $d->nama;

            $cekuttpkelurahan= $this->mod_info->cekuttpkelurahan($kduttp, $d->kdkelurahan);
            $subrecord['total'] = $cekuttpkelurahan['total'] == 0 ? "-":$cekuttpkelurahan['total']." unit";

            $no++;

            array_push($record, $subrecord);
        }

        $data['kelurahan'] = json_encode($record);

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/detailkelurahan');
        $this->load->view('layout/bawah');
    }

    public function detailpemilik($kduttp,$kdkecamatan,$kdkelurahan)
    {
        $data['halaman'] = "UTTP Wajib Tera Per-Pemilik";

        $data['infoapp'] = $this->infoapp->info();

        $data['kduttp'] = $kduttp;
        $cekuttp = $this->mod_info->cekuttp($kduttp);
        $data['namauttp'] = empty($cekuttp) || $cekuttp['nama'] == "" ? "-" : $cekuttp['nama'];

        $data['kdkecamatan'] = $kdkecamatan;
        $cekkecamatan = $this->mod_info->cekkecamatan($kdkecamatan);
        $data['namakecamatan'] = empty($cekkecamatan) || $cekkecamatan['nama'] == "" ? "-" : $cekkecamatan['nama'];

        $data['kdkelurahan'] = $kdkelurahan;
        $cekkelurahan = $this->mod_info->cekkelurahan($kdkelurahan);
        $data['namakelurahan'] = empty($cekkelurahan) || $cekkelurahan['nama'] == "" ? "-" : $cekkelurahan['nama'];

        $no = 1;

        $daftar = $this->mod_info->daftar_pemilik($kdkelurahan)->result();

        $record = array();
        $subrecord = array();
        foreach ($daftar as $d) {
            $subrecord['no'] = $no;
            $subrecord['kdpeserta'] = $d->kdpeserta;
            $subrecord['nama'] = $d->nama;
            $subrecord['alamat'] = $d->alamat;

            $cekuttppeserta= $this->mod_info->cekuttppeserta($kduttp, $d->kdpeserta);
            $subrecord['total'] = $cekuttppeserta['total'] == 0 ? "-":$cekuttppeserta['total']." unit";

            $no++;

            array_push($record, $subrecord);
        }

        $data['pemilik'] = json_encode($record);

        $this->load->view('layout/atas', $data);
        $this->load->view('layout/menu');
        $this->load->view('page/detailpemilik');
        $this->load->view('layout/bawah');
    }
}