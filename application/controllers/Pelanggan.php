<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_pelanggan');
    }

    public function index($kdpenyedia, $page = 1, $limit = 20, $isikategori = "-", $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Peserta Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['kdpenyedia'] = $kdpenyedia;

        // cek peserta
        $cekpeserta = $this->mod_pelanggan->cekpeserta($kdpenyedia);
        $data['penyedia'] = empty($cekpeserta) ? "-":$cekpeserta['nama']." - ".$cekpeserta['npwp'];

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
            $getkategori = str_replace("-", " ", urldecode($isikategori));
        } else {
            $getkategori = $this->input->post('kategori');
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $q_cari = "a.kdpeserta='$kdpenyedia' and ";
        if ($getcari != "") {
            $q_cari .= "$getkategori like '%$getcari%'";
        } else {
            $q_cari .= "b.npwp<>''";
        }

        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $kategori = str_replace(" ", "-", $getkategori);
        $data['getkategori'] =  $kategori;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_pelanggan->jumlahpelanggan($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $pegawai = $this->mod_pelanggan->daftarpelanggan($limit_start, $limit, $q_cari)->result();

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
            $subrecord['status'] = $p->status;

            $jmluttp = $this->mod_pelanggan->hitunguttppakai($p->kdpeserta);
            $subrecord['nominaljmluttp'] = $jmluttp['total'];
            $subrecord['jmluttp'] = "<a href='".base_url()."uttppeserta/index/".$p->kdpeserta."/2' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";

            $jmluttpmilik = $this->mod_pelanggan->hitunguttp($p->kdpeserta);
            $subrecord['jmluttpmilik'] = $jmluttpmilik['total'];

            $kecamatan = $this->mod_pelanggan->kecamatan($p->kdkecamatan);
            $subrecord['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];

            $kelurahan = $this->mod_pelanggan->kelurahan($p->kdkelurahan);
            $subrecord['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

            // cek skhp expired
            $totalexpired = $this->mod_pelanggan->totalexpired($p->kdpeserta,date('Y-m-d'));
            $subrecord['totalexpired'] = $totalexpired == 0 ? "-":"<a href='".base_url()."uttppeserta/index/".$p->kdpeserta."/2' class='btn bg-red btn-xs'>$totalexpired SKHP</a>";

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
        $this->log_lib->log_info("Akses halaman pelanggan pengguna alat UTTP");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/pelanggan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulirpelanggan($kdpenyedia, $proses, $kode = "")
    {
        $data['halaman'] = "Peserta Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['kdpenyedia'] = $kdpenyedia;

        // cek peserta
        $cekpeserta = $this->mod_pelanggan->cekpeserta($kdpenyedia);
        $data['penyedia'] = empty($cekpeserta) ? "-":$cekpeserta['nama']." - ".$cekpeserta['npwp'];

        $data['proses'] = $proses;

        $data['daftarkecamatan'] = $this->mod_pelanggan->ambilkecamatan()->result();

        if($kode != ""){
            $ambil = $this->mod_pelanggan->ambil($kode);

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

            $data['daftarkelurahan'] = $this->mod_pelanggan->ambilkelurahan($ambil['kdkecamatan'])->result();
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
        $this->log_lib->log_info("Akses halaman formulir pelanggan pengguna alat");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_pelanggan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function prosespelanggan($proses = 1, $kdpenyedia = "", $kode = "")
    {
        if($proses < 3){
            $kdpeserta =  $this->input->post('kode');
            $adaplg =  $this->input->post('adaplg');
            $kdpenyedia =  $this->input->post('kdpenyedia');
            $tgldaftar = date('Y-m-d');
            $npwp =  $this->input->post('npwp');
            $npwp_awal =  $this->input->post('npwp_awal');
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
                    $this->mod_pelanggan->simpanpelanggan2($kdpenyedia,$kdpeserta);

                    $pesan = 2;
                    $isipesan = "Data pelanggan terdaftar telah ditambahkan";
                } else {
                    $this->mod_pelanggan->simpanpelanggan($data);

                    $cekpeserta = $this->mod_pelanggan->cekpeserta2($npwp);
                    $kdpeserta = empty($cekpeserta) ? '':$cekpeserta['kdpeserta'];

                    if($kdpeserta != ''){
                        $this->mod_pelanggan->simpanpelanggan2($kdpenyedia,$kdpeserta);
                    }

                    $pesan = 1;
                    $isipesan = "Daftar pelanggan baru di tambahkan";
                }
                break;
            case 2:
                $this->mod_pelanggan->ubahpelanggan($data);
                
                $pesan = 2;
                $isipesan = "Data pelanggan diubah";
                break;
            case 3:
                $adapengajuan = $this->mod_pelanggan->adapengajuan($kode);
                $cekalatpakai = $this->mod_pelanggan->hitunguttppakai($kode);
                $jmlalat = empty($cekalatpakai) ? 0:$cekalatpakai['total'];

                if($adapengajuan == 0 && $jmlalat == 0) {
                    $adauttp = $this->mod_pelanggan->uttppeserta($kode);
                    if($adauttp > 0){
                        $berkassemuauttp = $this->mod_pelanggan->berkassemuauttp($kode);
                        foreach ($berkassemuauttp as $b) {
                            if($b->foto != ""){
                                $file_foto = "upload/uttppeserta/" . $b->foto;
                                if (file_exists($file_foto)) {
                                    unlink("./upload/uttppeserta/" . $b->foto);
                                }
                            }
                        }
                    }

                    $this->mod_pelanggan->hapussemuauttp($kode);
                    $this->mod_pelanggan->hapuspelanggan($kode);
                    $this->mod_pelanggan->hapus($kode);
                    
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
                $cekalatpakai = $this->mod_pelanggan->hitunguttppakai($kode);
                $jmlalat = empty($cekalatpakai) ? 0:$cekalatpakai['total'];

                if($jmlalat == 0) {
                    $this->mod_pelanggan->hapuspelanggan($kode);
                        
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

        redirect("pelanggan/index/$kdpenyedia/1/20/-/-/$pesan/$msg");
    }
}