<?
defined('BASEPATH') or exit('No direct script access allowed');

class Excel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_excel');
    }

    public function index($laporan, $kategori = "", $cari = "")
    {
        $data['laporan'] = $laporan;

        $record = array();
        $subrecord = array();

        $no = 1;
        $q_cari = "";

        switch ($laporan) {
            case "peserta":
                $data['judul'] = "Daftar Peserta Tera/Tera Ulang";
                $data['namafile'] = "Daftar Peserta Tera dan Tera Ulang";

                $q_cari = "kelompok<>'3' and ";

                if ($cari != "") {
                    $q_cari .= "$kategori like '%$cari%'";
                } else {
                    $q_cari .= "npwp<>''";
                }

                $peserta = $this->mod_excel->daftar($q_cari)->result();

                foreach ($peserta as $p) {
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

                    $kecamatan = $this->mod_excel->kecamatan($p->kdkecamatan);
                    $subrecord['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];

                    $kelurahan = $this->mod_excel->kelurahan($p->kdkelurahan);
                    $subrecord['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

                    switch ($subrecord['kelompok']) {
                        case 1:
                            $subrecord['namakelompok'] = "Pemilik Alat";
                            
                            $jmluttp = $this->mod_excel->hitunguttp($p->kdpeserta);
                            $subrecord['jmluttp'] = $jmluttp['total']." unit";
        
                            $subrecord['jmlpelanggan'] = "-";

                            switch ($p->status) {
                                case 0:
                                    $subrecord['namastatus'] = "Baru";
                                    break;
                                case 1:
                                    $subrecord['namastatus'] = "Diterima";
                                    break;
                            }
                            break;
                        case 2:
                            $subrecord['namakelompok'] = "Penyedia Alat";
        
                            $jmluttp = $this->mod_excel->hitunguttp2($p->kdpeserta);
                            $subrecord['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";
        
                            $jmlpelanggan = $this->mod_excel->hitungpelanggan($p->kdpeserta);
                            $subrecord['jmlpelanggan'] = $jmlpelanggan." pelanggan";

                            switch ($p->status) {
                                case 0:
                                    $subrecord['namastatus'] = "Baru";
                                    break;
                                case 1:
                                    $subrecord['namastatus'] = "Diterima";
                                    break;
                            }
                            break;
                        case 3:
                            $subrecord['namakelompok'] = "Pemakai Alat";
                            
                            $jmluttp = $this->mod_excel->hitunguttppakai($p->kdpeserta);
                            // $subrecord['jmluttp'] = "<a href='".base_url()."peserta/uttp/".$p->kdpeserta."' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";
                            $subrecord['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";
        
                            $subrecord['jmlpelanggan'] = "-";

                            $subrecord['namastatus'] = "-";
                            break;
                    }

                    $no++;

                    array_push($record, $subrecord);
                }
                
                break;
            case "uttppeserta":
                $data['judul'] = "Daftar UTTP Peserta Tera/Tera Ulang";
                $data['namafile'] = "Daftar UTTP Peserta Tera dan Tera Ulang";

                list($kdpeserta,$mode) = explode('_',$kategori);

                $cekpeserta = $this->mod_excel->cekpeserta($kdpeserta);
                $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];

                $data['judul'] .= " - ". $data['namapeserta'] ;
                $data['namafile'] .= " - ". $data['namapeserta'] ;
                
                switch ($mode) {
                    case 1:
                        $q_cari = "status='1' and ";
                        break;
                    case 2:
                        $q_cari = "status='0' and ";
                        break;
                }

                if ($cari != "") {
                    $q_cari .= "nama like '%$cari%' and kdpeserta='$kategori'";
                } else {
                    $q_cari .= "nama<>'' and kdpeserta='$kategori'";
                }

                $uttp = $this->mod_excel->daftar_uttp($q_cari)->result();

                foreach ($uttp as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['kduttppeserta'] = $d->kduttppeserta;
                    $subrecord['kduttp'] = $d->kduttp;
                    $subrecord['nama'] = $d->nama;
                    $subrecord['merktype'] = $d->merktype;
                    $subrecord['kapasitas'] = $d->kapasitas;
                    $subrecord['noseri'] = $d->noseri;
                    $subrecord['jml'] = $d->jml;
                    $subrecord['berkas'] = $d->foto;

                    $pengajuan = $this->mod_excel->cekpengajuan($d->kduttppeserta);
                    $subrecord['tglterakhir'] = empty($pengajuan) || $pengajuan['tglsuratskhp'] == "" ? "-" : date('d-m-Y',strtotime($pengajuan['tglsuratskhp']));

                    $subrecord['jmlpengajuan'] = $this->mod_excel->jmlpengajuan($d->kduttppeserta);

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case "pengajuan":
                $data['judul'] = "Daftar Pengajuan Tera/Tera Ulang";
                $data['namafile'] = "Daftar Pengajuan Tera dan Tera Ulang";

                if ($cari != "") {
                    $q_cari = "$kategori like '%$cari%'";
                } else {
                    $q_cari = "b.nama<>''";
                }

                if($this->session->userdata('level') == "Penera"){
                    $q_cari .= " and a.kdpegawai='".$this->session->userdata('kduser')."'";
                }

                $permintaan = $this->mod_excel->daftarpengajuan($q_cari)->result();

                foreach ($permintaan as $d) {
                    $subrecord['no'] = $no;
                    $subrecord['kdpengajuan'] = $d->kdpengajuan;
                    $subrecord['kduttppeserta'] = $d->kduttppeserta;
                    $subrecord['tglpengajuan'] = date('d-m-Y',strtotime($d->tglpengajuan));
                    $subrecord['npwp'] = $d->npwp;
                    $subrecord['namapeserta'] = $d->namapeserta;
                    $subrecord['kdlayanan'] = $d->kdlayanan;
                    $subrecord['nama'] = $d->nama;
                    $subrecord['namauttp'] = $d->namauttp;
                    $subrecord['jadwal'] = $d->jadwal != "" ? date('d-m-Y',strtotime($d->jadwal)) : "-";
                    $subrecord['kdpegawai'] = $d->kdpegawai;
                    $subrecord['nobukti'] = $d->nobukti != "" ? $d->nobukti : "-";
                    $subrecord['tglbayar'] = $d->tglbayar != "" ? date('d-m-Y',strtotime($d->tglbayar)) : "-";
                    $subrecord['buktibayar'] = $d->buktibayar != "" ? $d->buktibayar : "-";
                    $subrecord['nosuratskrd'] = $d->nosuratskrd != "" ? $d->nosuratskrd : "-";
                    $subrecord['tglsuratskrd'] = $d->tglsuratskrd != "" ? date('d-m-Y',strtotime($d->tglsuratskrd)) : "-";
                    $subrecord['nosuratskhp'] = $d->nosuratskhp != "" ? $d->nosuratskhp : "-";
                    $subrecord['tglsuratskhp'] = $d->tglsuratskhp != "" ? date('d-m-Y',strtotime($d->tglsuratskhp)) : "-";
                    $subrecord['fotokondisi'] = $d->fotokondisi != "" ? $d->fotokondisi : "-";
                    $subrecord['lokasi'] = $d->lokasi != "" ? $d->lokasi : "-";
                    $subrecord['hasil'] = $d->hasil != "" ? $d->hasil : "-";
                    $subrecord['cerapan'] = $d->cerapan != "" ? $d->cerapan : "-";
                    $subrecord['keterangan'] = $d->keterangan != "" ? str_replace("\r\n", "\n",$d->keterangan) : "-";
                    $subrecord['status'] = $d->status;

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
                        case 0:
                            $subrecord['namahasil'] = "-";
                            $subrecord['infohasil'] = "-";
                            $subrecord['warnahasil'] = "";
                            break;
                        case 1:
                            $subrecord['namahasil'] = "Dibatalkan";
                            $subrecord['infohasil'] = $subrecord['keterangan'];
                            $subrecord['warnahasil'] = "text-red";
                            break;
                        case 2:
                            $subrecord['namahasil'] = "Sah";
                            $subrecord['infohasil'] = "lihat di aplikasi";
                            $subrecord['warnahasil'] = "text-green";
                            break;
                        default:
                            $subrecord['namahasil'] = "-";
                            $subrecord['infohasil'] = "-";
                            $subrecord['warnahasil'] = "";
                            break;
                    }

                    // penera
                    if($subrecord['kdpegawai'] != ""){
                    $cekpeneratetapan = $this->mod_excel->cekpeneratetapan($subrecord['kdpegawai']);
                        $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
                    } else {
                        $subrecord['namapenera'] = "-";
                    }

                    // cekterima
                    $cekterima = $this->mod_excel->cekterima($subrecord['kdpengajuan']);
                    $namastatus_st_awal = $cekterima == 0 ? "Belum Diterima" : "Sudah Diterima";
                    $warnastatus_st_awal = $cekterima == 0 ? "btn-primary" : "bg-green";

                    $cekkembali = $this->mod_excel->cekkembali($subrecord['kdpengajuan']);
                    $namastatus_st = $cekkembali == 0 ? $namastatus_st_awal : "Sudah dikembalikan";
                    $warnastatus_st = $cekkembali == 0 ? $warnastatus_st_awal : "btn-default";

                    $proses_st = $cekterima == 0 ? 1 : 2;

                    $cekterimadok = $this->mod_excel->cekterimadok($subrecord['kdpengajuan']);
                    $namastatus_dok = $cekterimadok == 0 ? "Belum Diserahkan" : "Sudah Diserahkan";
                    $warnastatus_dok = $cekterimadok == 0 ? "btn-primary" : "btn-default";

                    switch ($d->status) {
                        case 0 : 
                            $subrecord['namastatus']="Baru"; 

                            $subrecord['serahterimaalat']="-"; 
                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 1 : 
                            if($adapilihan == 0){
                                $subrecord['namastatus']="Diterima"; 
                            } else {
                                $subrecord['namastatus']="Menunggu Pilihan";  
                            }

                            $subrecord['serahterimaalat']="-"; 
                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 2 : 
                            $subrecord['namastatus']="Terjadwal (Menunggu Pembayaran)"; 

                            $subrecord['serahterimaalat']="-"; 
                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 3 : 
                            $subrecord['namastatus']="Terbayar"; 

                            $subrecord['serahterimaalat']="-";
                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 4 : 
                            $subrecord['namastatus']="Diproses"; 

                            if ($subrecord['lokasi'] == 1) {
                                $subrecord['serahterimaalat']=$namastatus_st;
                            } else {
                                $subrecord['serahterimaalat']="-"; 
                            }
                            
                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 5 : 
                            switch ($subrecord['hasil']) {
                                case 1:
                                    $subrecord['namastatus']="Selesai (Dibatalkan)";

                                    $subrecord['serahterimadok']="-"; 
                                    break;
                                case 2:
                                    $subrecord['namastatus']="Selesai (Sah)";

                                    $subrecord['serahterimadok']=$namastatus_dok;
                                    break;
                                default:
                                    $subrecord['namastatus']="Selesai";

                                    $subrecord['serahterimadok']="-"; 
                                    break;
                            }

                            if ($subrecord['lokasi'] == 1) {
                                $subrecord['serahterimaalat'] = $namastatus_st;
                            } else {
                                $subrecord['serahterimaalat'] = "-"; 
                            }
                            break;
                    }

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
        }

        $data['data'] = json_encode($record);

        $this->load->view('backend/page/excel', $data);
    }

    public function pelanggan($kdpenyedia, $kategori = "", $cari = "")
    {
        $data['laporan'] = "pelanggan";

        $record = array();
        $subrecord = array();

        $no = 1;
        $q_cari = "";

        $cekpeserta = $this->mod_excel->cekpeserta($kdpenyedia);
        $data['penyedia'] = empty($cekpeserta) ? "-":$cekpeserta['nama']." - ".$cekpeserta['npwp'];

        $data['judul'] = "Daftar Pelanggan dari ".$data['penyedia'];
        $data['namafile'] = "Daftar Pelanggan";

        $q_cari = "a.kdpeserta='$kdpenyedia' and ";

        if ($cari != "") {
            $q_cari .= "$kategori like '%$cari%'";
        } else {
            $q_cari .= "npwp<>''";
        }

        $peserta = $this->mod_excel->daftarpelanggan($q_cari)->result();

        foreach ($peserta as $p) {
            $subrecord['no'] = $no;
            $subrecord['kdpeserta'] = $p->kdpeserta;
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

            $kecamatan = $this->mod_excel->kecamatan($p->kdkecamatan);
            $subrecord['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];

            $kelurahan = $this->mod_excel->kelurahan($p->kdkelurahan);
            $subrecord['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

            $jmluttp = $this->mod_excel->hitunguttppakai($p->kdpeserta);
            $subrecord['jmluttp'] = $jmluttp['total']." unit";

            $jmluttpmilik = $this->mod_excel->hitunguttp($p->kdpeserta);
            $subrecord['jmluttpmilik'] = $jmluttpmilik['total'];

            $no++;

            array_push($record, $subrecord);
        }
        
        $data['data'] = json_encode($record);

        $this->load->view('backend/page/excel', $data);
    }
}
