<?
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_laporan');
    }

    public function index()
    {
        $data['halaman'] = "Laporan";

        $data['infoapp'] = $this->infoapp->info();

        $data['peserta'] = $this->mod_laporan->peserta()->result();

        $data['layanan'] = $this->mod_laporan->layanan()->result();

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header', $data);
        $this->load->view('backend/layout/sidebar', $data);
        $this->load->view('backend/page/laporan', $data);
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function proses()
    {
        $data['infoapp'] = $this->infoapp->info();

        $tglsekarang = date('Y-m-d');

        $kelompok = $this->input->post('kelompoklaporan');
        $status = $this->input->post('status');
        $layanan = $this->input->post('layanan');
        $adaskhplama = $this->input->post('adaskhplama');
        $berlakuskhplama = $this->input->post('berlakuskhplama');
        $peserta = $this->input->post('peserta');
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');

        $data['kelompok'] = $kelompok;

        switch ($kelompok) {
            case 1:
                $data['judul'] = "Rekap Peserta Tera/Tera Ulang";
                $data['namafile'] = "Rekap Peserta ".date('d-m-Y',strtotime($dari))." sampai ".date('d-m-Y',strtotime($sampai));
                $data['peserta'] = "";
                break;
            case 2:
                $data['judul'] = "Rekap Pengajuan Tera/Tera Ulang";

                if($layanan != ''){
                    $ceklayanan = $this->mod_laporan->ceklayanan($layanan);
                    $data['judul'] = empty($ceklayanan) ? '':'Rekap Pengajuan '.$ceklayanan['nama'];
                }

                if($adaskhplama != ''){
                    $data['judul'] .= $adaskhplama == 1 ? '':' - Dokumen Hilang';
                }

                if($berlakuskhplama != ''){
                    $data['judul'] .= $berlakuskhplama == 1 ? ' - Masih Berlaku':' - Masa Berlaku Expired';
                }

                $data['namafile'] = "Rekap Pengajuan ".date('d-m-Y',strtotime($dari))." sampai ".date('d-m-Y',strtotime($sampai));
                if($peserta == 0){
                    $data['peserta'] = "Semua Peserta";
                } else {
                    $cekpeserta = $this->mod_laporan->cekpeserta($peserta);
                    $data['peserta'] = empty($cekpeserta) ? "" : $cekpeserta['npwp']." sampai ".$cekpeserta['nama'];
                }
                break;
            case 3:
                $data['judul'] = "Rekap SKHP Expired";
                $data['namafile'] = "Rekap SKHP Expired";
                $data['peserta'] = '';
                break;
        }

        if($kelompok != 3){
            switch ($status) {
                case 6:
                    $data['status'] = "Status Pengajuan Semua";
                    break;
                case 0:
                    $data['status'] = "Status Pengajuan Baru";
                    break;
                case 1:
                    $data['status'] = "Status Pengajuan Diterima";
                    break;
                case 2:
                    $data['status'] = "Status Pengajuan Terjadwal";
                    break;
                case 3:
                    $data['status'] = "Status Pengajuan Terbayar";
                    break;
                case 4:
                    $data['status'] = "Status Pengajuan Diproses";
                    break;
                case 5:
                    $data['status'] = "Status Pengajuan Selesai";
                    break;
                case 41:
                    $data['status'] = "Status Pengajuan Diproses (Alat telah diterima)";
                    break;
                case 51:
                    $data['status'] = "Status Pengajuan Selesai (Dibatalkan)";
                    break;
                case 52:
                    $data['status'] = "Status Pengajuan Selesai (Sah)";
                    break;
                case 53:
                    $data['status'] = "Status Pengajuan Selesai (Alat dikembalikan)";
                    break;
                case 54:
                    $data['status'] = "Status Pengajuan Selesai (Dokumen diserahkan)";
                    break;
                default:
                    $data['status'] = "";
                    break;
            }

            $data['rentang'] = "Rentang Waktu ".date('d-m-Y',strtotime($dari))." sampai dengan ".date('d-m-Y',strtotime($sampai));
        }

        $record = array();
        $subrecord = array();

        $no = 1;
        $q_cari = "";

        switch ($kelompok) {
            case 1:
                // $q_cari = "kelompok<>'3' and  tgldaftar>='$dari' and tgldaftar<='$sampai'";
                $q_cari = "tgldaftar>='$dari' and tgldaftar<='$sampai'";

                $pegawai = $this->mod_laporan->daftarpeserta($q_cari)->result();

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

                    $kecamatan = $this->mod_laporan->kecamatan($p->kdkecamatan);
                    $subrecord['kecamatan'] = empty($kecamatan) || $kecamatan['nama'] == "" ? "-" : $kecamatan['nama'];

                    $kelurahan = $this->mod_laporan->kelurahan($p->kdkelurahan);
                    $subrecord['kelurahan'] = empty($kelurahan) || $kelurahan['nama'] == "" ? "-" : $kelurahan['nama'];

                    switch ($subrecord['kelompok']) {
                        case 1:
                            $subrecord['namakelompok'] = "Pemilik Alat";
                            
                            $jmluttp = $this->mod_laporan->hitunguttp($p->kdpeserta);
                            $subrecord['jmluttp'] = $jmluttp['total']." unit";
        
                            $subrecord['jmlpelanggan'] = "-";
                            break;
                        case 2:
                            $subrecord['namakelompok'] = "Penyedia Alat";
        
                            $jmluttp = $this->mod_laporan->hitunguttp2($p->kdpeserta);
                            $subrecord['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";
        
                            $jmlpelanggan = $this->mod_laporan->hitungpelanggan($p->kdpeserta);
                            $subrecord['jmlpelanggan'] = $jmlpelanggan." pelanggan";
                            break;
                        case 3:
                            $subrecord['namakelompok'] = "Pemakai Alat";
                            
                            $jmluttp = $this->mod_laporan->hitunguttppakai($p->kdpeserta);
                            // $subrecord['jmluttp'] = "<a href='".base_url()."peserta/uttp/".$p->kdpeserta."' class='btn bg-blue btn-xs'>".$jmluttp['total']." unit</a>";
                            $subrecord['jmluttp'] = $jmluttp['total'] == 0 ? "-":$jmluttp['total']." unit";
        
                            $subrecord['jmlpelanggan'] = "-";
                            break;
                    }

                    $no++;

                    array_push($record, $subrecord);
                }
                break;
            case 2:
                switch ($status) {
                    case 6:
                        $q_cari = "a.status<>''";
                        break;
                    case 0:
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $q_cari = "a.status='$status'";
                        break;
                    case 41:
                        $q_cari = "a.status='4' and f.kelompok='1' and f.pegawaiterima<>'' and f.nikterima=''";
                        break;
                    case 51:
                        $q_cari = "a.status='5' and a.hasil='1'";
                        break;
                    case 52:
                        $q_cari = "a.status='5' and a.hasil='2'";
                        break;
                    case 53:
                        $q_cari = "a.status='5' and f.kelompok='1' and f.pegawaiterima<>'' and f.nikterima<>''";
                        break;
                    case 54:
                        $q_cari = "a.status='5' and f.kelompok='2'";
                        break;
                    default:
                        $q_cari = "a.status<>''";
                        break;
                }

                if($layanan != ''){
                    $q_cari .= " and a.kdlayanan='$layanan'";
                }

                if($adaskhplama != ''){
                    $q_cari .= " and a.adaskhplama='$adaskhplama'";
                }

                if($berlakuskhplama != ''){
                    $q_cari .= " and a.berlakuskhplama<='$tglsekarang'";
                }

                if($peserta == 0){
                    $q_cari .= " and c.kdpeserta<>''";
                } else {
                    $q_cari .= " and c.kdpeserta='$peserta'";
                }

                $q_cari .= " and a.tglpengajuan>='$dari' and a.tglpengajuan<='$sampai'";

                switch ($status) {
                    case 41:
                    case 53:
                    case 54:
                        $permintaan = $this->mod_laporan->daftarpengajuanserahterima($q_cari)->result();
                        break;
                    default:
                        $permintaan = $this->mod_laporan->daftarpengajuan($q_cari)->result();
                        break;
                }

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
                    $subrecord['tglbayar'] = $d->tglbayar != "" && $d->tglbayar != "0000-00-00" ? date('d-m-Y',strtotime($d->tglbayar)) : "-";
                    $subrecord['buktibayar'] = $d->buktibayar != "" ? $d->buktibayar : "-";
                    $subrecord['nosuratskrd'] = $d->nosuratskrd != "" ? $d->nosuratskrd : "-";
                    $subrecord['tglsuratskrd'] = $d->tglsuratskrd != "" && $d->tglsuratskrd != "0000-00-00" ? date('d-m-Y',strtotime($d->tglsuratskrd)) : "-";
                    $subrecord['nosuratskhp'] = $d->nosuratskhp != "" ? $d->nosuratskhp : "-";
                    $subrecord['tglsuratskhp'] = $d->tglsuratskhp != "" && $d->tglsuratskhp != "0000-00-00" ? date('d-m-Y',strtotime($d->tglsuratskhp)) : "-";
                    $subrecord['fotokondisi'] = $d->fotokondisi != "" ? $d->fotokondisi : "-";
                    $subrecord['lokasi'] = $d->lokasi != "" ? $d->lokasi : "-";
                    $subrecord['hasil'] = $d->hasil != "" ? $d->hasil : "-";
                    $subrecord['cerapan'] = $d->cerapan != "" ? $d->cerapan : "-";
                    $subrecord['keterangan'] = $d->keterangan != "" ? str_replace("\r\n", "\n",$d->keterangan) : "-";
                    $subrecord['status'] = $d->status;

                    $subrecord['noskhplama'] = $d->noskhplama != "" ? $d->noskhplama : "-";
                    $subrecord['tglskhplama'] = $d->tglskhplama != "" && $d->tglskhplama != "0000-00-00" ? date('d-m-Y',strtotime($d->tglskhplama)) : "-";
        
                    if($d->berlakuskhp != "" && $d->berlakuskhp != "0000-00-00" && strtotime($d->berlakuskhp) <= strtotime(date('Y-m-d'))){
                        $statusekspired = '(Expired)';
                    } else {
                        $statusekspired = '';
                    }
        
                    if($d->berlakuskhplama != "" && $d->berlakuskhplama != "0000-00-00" && strtotime($d->berlakuskhplama) <= strtotime(date('Y-m-d'))){
                        $statusekspired2 = '(Expired)';
                    } else {
                        $statusekspired2 = '';
                    }
        
                    if($d->berlakuskhp != "") list($thn,$bln,$hr) = explode('-',$d->berlakuskhp);
                    $subrecord['berlakuskhp'] = $d->berlakuskhp != "" && $d->berlakuskhp != "0000-00-00" ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired: "-";
        
                    if($d->berlakuskhplama != "") list($thn,$bln,$hr) = explode('-',$d->berlakuskhplama);
                    $subrecord['berlakuskhplama'] = $d->berlakuskhplama != "" && $d->berlakuskhplama != "0000-00-00" ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired2: "-";
                    
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
                    $cekpeneratetapan = $this->mod_laporan->cekpeneratetapan($subrecord['kdpegawai']);
                        $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
                    } else {
                        $subrecord['namapenera'] = "-";
                    }

                    // cekterima
                    $cekterima = $this->mod_laporan->cekterima($subrecord['kdpengajuan']);
                    $namastatus_st_awal = $cekterima == 0 ? "Belum Diterima" : "Sudah Diterima";
                    $warnastatus_st_awal = $cekterima == 0 ? "btn-primary" : "bg-green";

                    $cekkembali = $this->mod_laporan->cekkembali($subrecord['kdpengajuan']);
                    $namastatus_st = $cekkembali == 0 ? $namastatus_st_awal : "Sudah dikembalikan";
                    $warnastatus_st = $cekkembali == 0 ? $warnastatus_st_awal : "btn-default";

                    $proses_st = $cekterima == 0 ? 1 : 2;

                    $cekterimadok = $this->mod_laporan->cekterimadok($subrecord['kdpengajuan']);
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
            case 3:
                if($peserta == 0){
                    $q_cari .= " c.kdpeserta<>''";
                } else {
                    $q_cari .= " c.kdpeserta='$peserta'";
                }

                $q_cari .= " and a.berlakuskhp<='$tglsekarang' and a.berlakuskhp<>'0000-00-00'";

                $permintaan = $this->mod_laporan->daftarpengajuanexpired($q_cari)->result();

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
                    $subrecord['jadwal'] = $d->jadwal != "" || $d->jadwal != "0000-00-00" ? date('d-m-Y',strtotime($d->jadwal)) : "-";
                    $subrecord['kdpegawai'] = $d->kdpegawai;
                    $subrecord['nobukti'] = $d->nobukti != "" ? $d->nobukti : "-";
                    $subrecord['tglbayar'] = $d->tglbayar != "" && $d->tglbayar != "0000-00-00" ? date('d-m-Y',strtotime($d->tglbayar)) : "-";
                    $subrecord['buktibayar'] = $d->buktibayar != "" ? $d->buktibayar : "-";
                    $subrecord['nosuratskrd'] = $d->nosuratskrd != "" ? $d->nosuratskrd : "-";
                    $subrecord['tglsuratskrd'] = $d->tglsuratskrd != "" && $d->tglsuratskrd != "0000-00-00" ? date('d-m-Y',strtotime($d->tglsuratskrd)) : "-";
                    $subrecord['nosuratskhp'] = $d->nosuratskhp != "" ? $d->nosuratskhp : "-";
                    $subrecord['tglsuratskhp'] = $d->tglsuratskhp != "" && $d->tglsuratskhp != "0000-00-00" ? date('d-m-Y',strtotime($d->tglsuratskhp)) : "-";
                    $subrecord['fotokondisi'] = $d->fotokondisi != "" ? $d->fotokondisi : "-";
                    $subrecord['lokasi'] = $d->lokasi != "" ? $d->lokasi : "-";
                    $subrecord['hasil'] = $d->hasil != "" ? $d->hasil : "-";
                    $subrecord['cerapan'] = $d->cerapan != "" ? $d->cerapan : "-";
                    $subrecord['keterangan'] = $d->keterangan != "" ? str_replace("\r\n", "\n",$d->keterangan) : "-";
                    $subrecord['status'] = $d->status;

                    $subrecord['noskhplama'] = $d->noskhplama != "" ? $d->noskhplama : "-";
                    $subrecord['tglskhplama'] = $d->tglskhplama != "" ? date('d-m-Y',strtotime($d->tglskhplama)) : "-";
        
                    if($d->berlakuskhp != "" && strtotime($d->berlakuskhp) <= strtotime(date('Y-m-d'))){
                        $statusekspired = '(Expired)';
                    } else {
                        $statusekspired = '';
                    }
        
                    if($d->berlakuskhplama != "" && strtotime($d->berlakuskhplama) <= strtotime(date('Y-m-d'))){
                        $statusekspired2 = '(Expired)';
                    } else {
                        $statusekspired2 = '';
                    }
        
                    if($d->berlakuskhp != "") list($thn,$bln,$hr) = explode('-',$d->berlakuskhp);
                    $subrecord['berlakuskhp'] = $d->berlakuskhp != "" ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired: "-";
        
                    if($d->berlakuskhplama != "") list($thn,$bln,$hr) = explode('-',$d->berlakuskhplama);
                    $subrecord['berlakuskhplama'] = $d->berlakuskhplama != "" ?  $this->namabulan->namabln($bln)." ".$thn." ".$statusekspired2: "-";
                    
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
                    $cekpeneratetapan = $this->mod_laporan->cekpeneratetapan($subrecord['kdpegawai']);
                        $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
                    } else {
                        $subrecord['namapenera'] = "-";
                    }

                    // cekterima
                    $cekterima = $this->mod_laporan->cekterima($subrecord['kdpengajuan']);
                    $namastatus_st_awal = $cekterima == 0 ? "Belum Diterima" : "Sudah Diterima";
                    $warnastatus_st_awal = $cekterima == 0 ? "btn-primary" : "bg-green";

                    $cekkembali = $this->mod_laporan->cekkembali($subrecord['kdpengajuan']);
                    $namastatus_st = $cekkembali == 0 ? $namastatus_st_awal : "Sudah dikembalikan";
                    $warnastatus_st = $cekkembali == 0 ? $warnastatus_st_awal : "btn-default";

                    $proses_st = $cekterima == 0 ? 1 : 2;

                    $cekterimadok = $this->mod_laporan->cekterimadok($subrecord['kdpengajuan']);
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

        $this->load->view('backend/page/cetaklaporan', $data);
    }
}
