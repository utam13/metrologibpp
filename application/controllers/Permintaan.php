<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permintaan extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_permintaan');
    }

    public function index($page = 1, $limit = 20, $isikategori = "-", $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "Pengajuan Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
            $getkategori = str_replace("-", " ", urldecode($isikategori));
        } else {
            $getkategori = $this->input->post('kategori');
            switch ($getkategori) {
                case 'a.status':
                    $getcari = $this->clear_string->clear_quotes($this->input->post('statuscari'));
                    break;
                case 'a.kdpegawai':
                    $getcari = $this->clear_string->clear_quotes($this->input->post('peneracari'));
                    break;
                default:
                    $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
                    break;
            }
        }

        $q_cari = "";
        if ($getcari != "") {
            switch ($getkategori) {
                case 'expired':
                    $q_cari = "a.berlakuskph<='$getcari'";
                    break;
                case 'a.status':
                    $q_cari = "a.status='$getcari'";
                    break;
                default:
                    $q_cari = "$getkategori like '%$getcari%'";
                    break;
            }
        } else {
            $q_cari = "b.nama<>''";
        }

        if($this->session->userdata('level') == "Penera"){
            $q_cari .= " and a.kdpegawai='".$this->session->userdata('kduser')."'";
        }

        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $kategori = str_replace(" ", "-", $getkategori);
        $data['getkategori'] =  $kategori;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_permintaan->jumlah_data($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $permintaan = $this->mod_permintaan->daftar($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
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
            $subrecord['tglsuratskrd'] = $d->tglsuratskrd != "" && $d->tglsuratskrd != "0000-00-00" ? date('d-m-Y',strtotime($d->tglsuratskrd)) : "-";
            $subrecord['nosuratskhp'] = $d->nosuratskhp != "" ? $d->nosuratskhp : "-";
            $subrecord['tglsuratskhp'] = $d->tglsuratskhp != "" && $d->tglsuratskhp != "0000-00-00" ? date('d-m-Y',strtotime($d->tglsuratskhp)) : "-";
            $subrecord['fotokondisi'] = $d->fotokondisi != "" ? $d->fotokondisi : "-";
            $subrecord['lokasi'] = $d->lokasi != "" ? $d->lokasi : "-";
            $subrecord['hasil'] = $d->hasil != "" ? $d->hasil : "-";
            $subrecord['cerapan'] = $d->cerapan != "" ? $d->cerapan : "-";
            $subrecord['keterangan'] = $d->keterangan != "" ? str_replace("\r\n", "\n",$d->keterangan) : "-";
            $subrecord['status'] = $d->status;
            $subrecord['alasanbatal'] = $d->alasanbatal != "" ? $d->alasanbatal : "";

            $subrecord['noskhplama'] = $d->noskhplama != "" ? $d->noskhplama : "-";
            $subrecord['tglskhplama'] = $d->tglskhplama != "" && $d->tglskhplama != "0000-00-00" ? date('d-m-Y',strtotime($d->tglskhplama)) : "-";

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

            if ($subrecord['cerapan'] != "-") {
                $cerapan = "upload/cerapan/" . $subrecord['cerapan'];
                if (file_exists($cerapan)) {
                    $subrecord['file_cerapan'] = base_url() . "upload/cerapan/" . $subrecord['cerapan'] . "?" . rand();
                } else {
                    $subrecord['file_cerapan'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord['file_cerapan'] = base_url() . "upload/no-image.png";
            }

            switch ($subrecord['hasil']) {
                case 0:
                    $subrecord['namahasil'] = "-";
                    $subrecord['infohasil'] = "-";
                    $subrecord['warnahasil'] = "";
                    break;
                case 1:
                    $subrecord['namahasil'] = "Dibatalkan";
                    $subrecord['infohasil'] = "<button type='button' class='btn btn-info btn-xs' onclick='alert(\"".$subrecord['keterangan']."\")'>Lihat Keterangan</button>";
                    $subrecord['warnahasil'] = "text-red";
                    break;
                case 2:
                    $subrecord['namahasil'] = "Sah";
                    $subrecord['infohasil'] = "<a href='".$subrecord['file_cerapan']."' target='_blank' class='btn btn-info btn-xs'>Lihat Cerapan</a>";
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
            $cekpeneratetapan = $this->mod_permintaan->cekpeneratetapan($subrecord['kdpegawai']);
                // $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
                $subrecord['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nama'];
            } else {
                $subrecord['namapenera'] = "-";
            }

            if ($subrecord['buktibayar'] != "-") {
                $buktibayar = "upload/buktibayar/" . $subrecord['buktibayar'];
                if (file_exists($buktibayar)) {
                    $subrecord['file_buktibayar'] = base_url() . "upload/buktibayar/" . $subrecord['buktibayar'] . "?" . rand();
                } else {
                    $subrecord['file_buktibayar'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord['file_buktibayar'] = base_url() . "upload/no-image.png";
            }

            if ($subrecord['fotokondisi'] != "-") {
                $fotokondisi = "upload/fotokondisi/" . $subrecord['fotokondisi'];
                if (file_exists($fotokondisi)) {
                    $subrecord['file_fotokondisi'] = base_url() . "upload/fotokondisi/" . $subrecord['fotokondisi'] . "?" . rand();
                } else {
                    $subrecord['file_fotokondisi'] = base_url() . "upload/no-image.png";
                }
            } else {
                $subrecord['file_fotokondisi'] = base_url() . "upload/no-image.png";
            }

            // cekterima
            $cekterima = $this->mod_permintaan->cekterima($subrecord['kdpengajuan']);
            $namastatus_st_awal = $cekterima == 0 ? "Terima" : "Diterima";
            $warnastatus_st_awal = $cekterima == 0 ? "btn-primary" : "bg-green";

            $cekkembali = $this->mod_permintaan->cekkembali($subrecord['kdpengajuan']);
            $namastatus_st = $cekkembali == 0 ? $namastatus_st_awal : "Telah dikembalikan";
            $warnastatus_st = $cekkembali == 0 ? $warnastatus_st_awal : "btn-default";

            $proses_st = $cekterima == 0 ? 1 : 2;

            $cekterimadok = $this->mod_permintaan->cekterimadok($subrecord['kdpengajuan']);
            $namastatus_dok = $cekterimadok == 0 ? "Pengambilan" : "Telah Diserahkan";
            $warnastatus_dok = $cekterimadok == 0 ? "btn-primary" : "btn-default";

            $adapilihan = $this->mod_permintaan->cekpilihanjadwal($subrecord['kdpengajuan']);

            switch ($d->status) {
                case 0 : 
                    $subrecord['namastatus']="Baru"; 
                    $subrecord['warnabtn']="bg-blue"; 

                    $subrecord['serahterimaalat']="-"; 
                    $subrecord['serahterimadok']="-"; 
                    break;
                case 1 : 
                    if($adapilihan == 0){
                        $subrecord['namastatus']="Diterima"; 
                        $subrecord['warnabtn']="bg-light-blue"; 
                    } else {
                        $subrecord['namastatus']="Menunggu Pilihan"; 
                        $subrecord['warnabtn']="btn-default"; 
                    }

                    $subrecord['serahterimaalat']="-"; 
                    $subrecord['serahterimadok']="-"; 
                    break;
                case 2 : 
                    $subrecord['namastatus']="Terjadwal<br>(Menunggu Pembayaran)"; 
                    $subrecord['warnabtn']="bg-teal"; 

                    $subrecord['serahterimaalat']="-"; 
                    $subrecord['serahterimadok']="-"; 
                    break;
                case 3 : 
                    $subrecord['namastatus']="Terbayar"; 
                    $subrecord['warnabtn']="bg-olive"; 

                    $subrecord['serahterimaalat']="-";
                    $subrecord['serahterimadok']="-"; 
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

                    if ($subrecord['lokasi'] == 1) {
                        if($cekterima == 1){
                            $subrecord['serahterimaalat']="<a href='#' class='btn $warnastatus_st btn-xs' onclick='alert(\"Alat dapat dikembalikan setelah status menjadi Selesai (Dibatalkan/Sah)\")'>$namastatus_st</a>";
                        } else {
                            $subrecord['serahterimaalat']="<a href='".base_url()."permintaan/serahterima/1/1/".$subrecord['kdpengajuan']."' class='btn $warnastatus_st btn-xs'>$namastatus_st</a>";
                        }
                    } else {
                        $subrecord['serahterimaalat']="-"; 
                    }
                    
                    $subrecord['serahterimadok']="-"; 
                    break;
                case 5 : 
                    switch ($subrecord['hasil']) {
                        case 1:
                            $subrecord['namastatus']="Selesai (Dibatalkan)";
                            $subrecord['warnabtn']="bg-black"; 

                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 2:
                            $subrecord['namastatus']="Selesai (Sah)";
                            $subrecord['warnabtn']="bg-green"; 

                            $subrecord['serahterimadok']="<a href='".base_url()."permintaan/serahterima/2/2/".$subrecord['kdpengajuan']."' class='btn $warnastatus_dok btn-xs'>$namastatus_dok</a>";
                            break;
                        default:
                            $subrecord['namastatus']="Selesai";
                            $subrecord['warnabtn']="bg-green"; 

                            $subrecord['serahterimadok']="-"; 
                            break;
                    }

                    if ($subrecord['lokasi'] == 1) {
                        $subrecord['serahterimaalat'] = "<a href='".base_url()."permintaan/serahterima/1/$proses_st/".$subrecord['kdpengajuan']."' class='btn $warnastatus_st btn-xs'>$namastatus_st</a>&nbsp;";
                    } else {
                        $subrecord['serahterimaalat'] = "-"; 
                    }
                    break;
                case 10 : 
                    $subrecord['namastatus']="Dibatalkan";
                    $subrecord['warnabtn']="btn-default text-red"; 

                    switch ($subrecord['hasil']) {
                        case 1:
                            $subrecord['serahterimadok']="-"; 
                            break;
                        case 2:
                            $subrecord['serahterimadok']="<a href='".base_url()."permintaan/serahterima/2/2/".$subrecord['kdpengajuan']."' class='btn $warnastatus_dok btn-xs'>$namastatus_dok</a>";
                            break;
                        default:
                            $subrecord['serahterimadok']="-"; 
                            break;
                    }

                    if ($subrecord['lokasi'] == 1) {
                        $subrecord['serahterimaalat'] = "<a href='".base_url()."permintaan/serahterima/1/$proses_st/".$subrecord['kdpengajuan']."' class='btn $warnastatus_st btn-xs'>$namastatus_st</a>&nbsp;";
                    } else {
                        $subrecord['serahterimaalat'] = "-"; 
                    }
                    break;
            }

            // cek expired skhp
            // cek skhp uttppeserta
            $adaskhputtp = $this->mod_permintaan->cekskhputtp($subrecord['nosuratskhp']);
            if($subrecord['nosuratskhp'] != '-' && $adaskhputtp > 0 && $d->berlakuskhp != '' && $d->berlakuskhp != '0000-00-00'){
                list($thn,$bln,$tgl) = explode('-',$d->berlakuskhp); 

                if(strtotime($d->berlakuskhp) <= strtotime(date('Y-m-d'))){
                    $subrecord['warnabaris'] = "bg-maroon-active";
                    $subrecord['warnahasil'] = "";
                } else {
                    $subrecord['warnabaris'] = ""; 
                }
            } else {
                $subrecord['warnabaris'] = ""; 
            }

            $no++;

            array_push($record, $subrecord);
        }
        $data['permintaan'] = json_encode($record);

        $data['page'] = $page;
        $data['limit'] = $limit;
        $data['get_jumlah'] = $jumlah_data;
        $data['jumlah_page'] = ceil($jumlah_data / $limit);
        $data['jumlah_number'] = 2;
        $data['start_number'] = ($page > $data['jumlah_number']) ? $page - $data['jumlah_number'] : 1;
        $data['end_number'] = ($page < ($data['jumlah_page'] - $data['jumlah_number'])) ? $page + $data['jumlah_number'] : $data['jumlah_page'];

        $data['no'] = $limit_start + 1;
        //end

        $data['penera'] = $this->mod_permintaan->penera()->result();

        //save log
        $this->log_lib->log_info("Akses halaman permintaan tera atau tera Ulang");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/permintaan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formulir($kduttppeserta, $proses, $kode = "", $status = 0)
    {
        $data['halaman'] = "Pengajuan Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['proses'] = $proses;

        $data['kduttppeserta'] = $kduttppeserta;

        $data['tglsekarang'] = date('Y-m-d');
        $data['tglminimum'] = date('Y-m-d', strtotime($data['tglsekarang'] . ' +1 day'));

        $data['penera'] = $this->mod_permintaan->penera()->result();

        $ambiluttp = $this->mod_permintaan->ambiluttp($kduttppeserta);
        $data['kdpeserta'] = $ambiluttp['kdpeserta'];
        $data['kduttp'] = $ambiluttp['kduttp'];
        $data['merktype'] = $ambiluttp['merktype'];
        $data['kapasitas'] = $ambiluttp['kapasitas'];
        $data['noseri'] = $ambiluttp['noseri'];
        $data['jml'] = $ambiluttp['jml'];
        $data['noskhp'] = $ambiluttp['noskhp'];
        $data['status'] = $ambiluttp['status'];
        $data['mode'] = $ambiluttp['status'] == 0 ? 1:2;
        $data['kdlayanan'] = $ambiluttp['kdlayanan'];

        if($data['kdlayanan'] == 0){
            $qlayanan = "kdlayanan<>''";
        } else {
            $qlayanan = "kdlayanan='".$data['kdlayanan']."'";
        }

        $record_layanan = array();
        $subrecord_layanan = array();
        $lislayanan = $this->mod_permintaan->layanan($qlayanan)->result();
        foreach ($lislayanan as $ly) {
            $subrecord_layanan['kdlayanan'] = $ly->kdlayanan;
            $subrecord_layanan['nama'] = $ly->nama;

            $subrecord_layanan['pilihan'] = $data['noskhp'] != '' && $subrecord_layanan['nama'] == 'Tera Ulang' ? 'selected':'';
            
            array_push($record_layanan, $subrecord_layanan);
        }
        $data['listlayanan'] = json_encode($record_layanan);

        // skhp sebelum yang terdata
        if($ambiluttp['noskhp'] != ''){
            $pengajuan = $this->mod_permintaan->cekskhplama($kduttppeserta,$ambiluttp['noskhp']);
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
        $isiinfotambahan= $this->mod_permintaan->isiinfotambahan($data['kduttp'])->result();
        foreach ($isiinfotambahan as $iit) {
            $label = strtolower(str_replace(' ','_',$iit->info));

            $ambilinfotambahan = $this->mod_permintaan->ambilinfotambahan($data['kduttppeserta'],$iit->info);
            $isi = empty($ambilinfotambahan) ? '' : $ambilinfotambahan['isi'];

            $subrecord['komponen'] = '<dt>'.$iit->info.'</dt><dd>'.$isi.'</dd>';

            array_push($record, $subrecord);
        }
        $data['infotambahan'] = json_encode($record);

        $cekpeserta = $this->mod_permintaan->cekpeserta($data['kdpeserta']);
        $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];

        $data['adaberkastambahan'] = $this->mod_permintaan->cekberkastambahan($data['kduttp']);

        $berkastambahan = $this->mod_permintaan->berkastambahan($data['kduttp'])->result();

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

        $uttppeserta = $this->mod_permintaan->ceknamauttp($kduttppeserta);
        $data['namauttp'] = empty($uttppeserta) || $uttppeserta['nama'] == "" ? "-" : $uttppeserta['nama'];

        $data['proses'] = $proses;

        $data['monitoringpengajuan'] = $this->mod_permintaan->monitoringpengajuan($data['kdpeserta']);

        if($kode == ""){
            $cekpengajuan = $this->mod_permintaan->cekpengajuan($kduttppeserta);
            $kode = empty($cekpengajuan) ? "":$cekpengajuan['kdpengajuan'];
        } 

        if($kode != ""){
            $ambilpengajuan = $this->mod_permintaan->ambilpengajuan($kode);

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
            $data['tglsuratskrd'] = $ambilpengajuan['tglsuratskrd'];
            $data['nosuratskhp'] = $ambilpengajuan['nosuratskhp'];
            $data['tglsuratskhp'] = $ambilpengajuan['tglsuratskhp'];
            $data['berlakuskhp'] = $ambilpengajuan['berlakuskhp'] != '' && $ambilpengajuan['berlakuskhp'] != '0000-00-00' ? date('Y-m',strtotime($ambilpengajuan['berlakuskhp'])):'';
            $data['fotokondisi'] = $ambilpengajuan['fotokondisi'];
            $data['izinpersetujuantipe'] = $ambilpengajuan['izinpersetujuantipe'];
            $data['skhplama'] = $ambilpengajuan['skhplama'];
            $data['lokasisebelumnya'] = $ambilpengajuan['lokasisebelumnya'];
            $data['adaskhplama'] = $ambilpengajuan['adaskhplama'];
            $data['noskhplama'] = $ambilpengajuan['noskhplama'];
            $data['tglskhplama'] = $ambilpengajuan['tglskhplama'];
            $data['tglskhplama2'] = date('d-m-Y',strtotime($ambilpengajuan['tglskhplama']));
            $data['berlakuskhplama'] = date('Y-m',strtotime($ambilpengajuan['berlakuskhplama']));
            $data['suratpermohonan'] = $ambilpengajuan['suratpermohonan'];
            $data['lokasi'] = $ambilpengajuan['lokasi'];
            $data['hasiluji'] = $ambilpengajuan['hasil'];
            $data['keterangan'] = $ambilpengajuan['keterangan'];
            $data['cerapan'] = $ambilpengajuan['cerapan'];
            $data['alasanbatal'] = $ambilpengajuan['alasanbatal'];
            $data['status'] = $ambilpengajuan['status'];

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

            $data['adapilihan'] = $this->mod_permintaan->cekpilihanjadwal($kode);

            if($data['adapilihan'] != 0){
                $ambilpilihan = $this->mod_permintaan->ambilpilihanjadwal($kode);
                $data['tgl1'] = $ambilpilihan['tgl1']; 

                $cekpenera = $this->mod_permintaan->cekpeneratetapan($ambilpilihan['pegawai1']);
                // $data['pegawai1'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
                $data['pegawai1'] = empty($cekpenera) ? "":$cekpenera['nama'];

                $data['tgl2'] = $ambilpilihan['tgl2']; 

                $cekpenera = $this->mod_permintaan->cekpeneratetapan($ambilpilihan['pegawai2']);
                // $data['pegawai2'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
                $data['pegawai2'] = empty($cekpenera) ? "":$cekpenera['nama'];
                
                $data['tgl3'] = $ambilpilihan['tgl3']; 

                $cekpenera = $this->mod_permintaan->cekpeneratetapan($ambilpilihan['pegawai3']);
                // $data['pegawai3'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
                $data['pegawai3'] = empty($cekpenera) ? "":$cekpenera['nama'];

                $data['tgl4'] = $ambilpilihan['tgl4']; 

                $cekpenera = $this->mod_permintaan->cekpeneratetapan($ambilpilihan['pegawai4']);
                // $data['pegawai4'] = empty($cekpenera) ? "":" (".$cekpenera['nip']." - ".$cekpenera['nama'].")";
                $data['pegawai4'] = empty($cekpenera) ? "":$cekpenera['nama'];

                $data['status_tgl1'] = $data['jadwal2'] != $ambilpilihan['tgl1'] && strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl1']) ? "disabled" : "";
                $data['status_tgl2'] = $data['jadwal2'] != $ambilpilihan['tgl2'] &&strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl2']) ? "disabled" : "";
                $data['status_tgl3'] = $data['jadwal2'] != $ambilpilihan['tgl3'] &&strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl3']) ? "disabled" : "";
                $data['status_tgl4'] = $data['jadwal2'] != $ambilpilihan['tgl4'] &&strtotime($data['tglsekarang']) >= strtotime($ambilpilihan['tgl4']) ? "disabled" : "";
            }

            // penera
            $cekpeneratetapan = $this->mod_permintaan->cekpeneratetapan($data['kdpegawai']);
            // $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
            $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nama'];

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

                $berkastambahanpengajuan = $this->mod_permintaan->berkastambahanpengajuan($data['kdpengajuan'],$subrecord['nama_objek']);
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
                    $data['namabtn'] = "Terima Permintaan"; 
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

            if($proses == 4){
                $data['namabtn'] = "Batalkan Pengajuan";
            }
        } else {
            $data['kdpengajuan'] = "";
            $data['tglpengajuan'] = date('Y-m-d');
            $data['kdlayanan'] = "";
            $data['nama'] = $data['namalayanan'];
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
            $data['berlakuskhp'] = "";
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
            $data['alasanbatal'] = "";
            $data['namalokasi'] = "-";
            $data['namastatus'] = "Baru";
            $data['namabtn'] = "Proses Pengajuan Baru";
            $data['warnabtn']="bg-blue";
            $data['statusekspired'] = '';

            $data['izinskhplama'] = "";
            $data['file_izinskhplama'] = "";

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
            
            if($proses == 4){
                $data['namabtn'] = "Batalkan Pengajuan";
            }
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir pengajuan tera atau tera ulang peserta");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_permintaan');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
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
            $this->mod_permintaan->uploadfile($file_name);

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
            $this->mod_permintaan->uploadfile($file_name);

            echo $file_name;
        }
    }

    function viewPdf($namafile, $kelompok)
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

    public function batalberkas($namafile, $kelompok)
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

    public function proses($proses = 1, $kode = "")
    {
        if($proses != 3){
            $tglpengajuan = date('Y-m-d');
            $kdpengajuan =  $this->input->post('kode');
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
            $berlakuskhp = $this->input->post('berlakuskhp');
            $lokasi = $this->input->post('lokasi');
            $penjadwalan = $this->input->post('penjadwalan');
            $hasil = $this->input->post('hasil');
            $cerapan = $this->input->post('berkas_cerapan');
            $keterangan = $this->clear_string->clear_quotes($this->input->post('keterangan'));
            $alasanbatal = $this->input->post('alasanbatal');

            $hasilawal = $this->input->post('hasilawal');
            $jadwalawal = $this->input->post('jadwalawal');
            $pegawaiawal = $this->input->post('pegawaiawal');

            $tgl1 = $this->input->post('tgl1');
            $pegawai1 = $this->input->post('pegawai1');
            $tgl2 = $this->input->post('tgl2');
            $pegawai2 = $this->input->post('pegawai2');
            $tgl3 = $this->input->post('tgl3');
            $pegawai3 = $this->input->post('pegawai3');
            $tgl4 = $this->input->post('tgl4');
            $pegawai4 = $this->input->post('pegawai4');

            $adapilihan = $this->mod_permintaan->cekpilihanjadwal($kdpengajuan);
            if($adapilihan > 0 && $kdpengajuan != ""){
                $penjadwalan = 1;
            }

            switch ($penjadwalan) {
                case 0:
                    $jadwal = $this->input->post('tgltetapan');
                    $kdpegawai = $this->input->post('pegawaitetapan'); //petugas penera
                    break;
                case 1:
                    if($status == 3){
                        $jadwal = $this->input->post('tgltetapan');
                        $kdpegawai = $this->input->post('pegawaitetapan'); //petugas penera
                    } else {
                        $jadwal = $this->input->post('tgltetapan');

                        if($this->session->userdata('level') == "Penera") {
                            $kdpegawai = $this->input->post('pegawaitetapan'); //petugas penera
                        }else{
                            for ($i=1; $i < 5; $i++) { 
                                $qjadwal = "tgl$i='$jadwal'";
                                $cekpenera = $this->mod_permintaan->cekpenera($qjadwal);
                                if(!empty($cekpenera)){
                                    $kdpegawai =  $cekpenera['pegawai'.$i];
                                    break;
                                }
                            }
                        }
                    }
                    break;
                    
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
                    $statusbaru = 1;
                    break;
                case 1:
                    if($adapilihan == 0 && $penjadwalan == 1){
                        $statusbaru = 1;
                    } else {
                        $statusbaru = 2;
                    }
                    break;
                case 4:
                    if($hasil == 1){
                        $statusbaru = 5;
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

            $data2 = array(
                "kdpengajuan" => $kdpengajuan,
                "tgl1" => $tgl1,
                "pegawai1" => $pegawai1,
                "tgl2" => $tgl2,
                "pegawai2" => $pegawai2,
                "tgl3" => $tgl3,
                "pegawai3" => $pegawai3,
                "tgl4" => $tgl4,
                "pegawai4" => $pegawai4
            );
        }

        switch ($proses) {
            case 1:
                $this->mod_permintaan->simpan($data);

                $cekpengajuan = $this->mod_permintaan->cekpengajuan2($kduttppeserta);
                $kdpengajuan = empty($cekpengajuan) ? "":$cekpengajuan['kdpengajuan'];

                $pesan = 1;
                $isipesan = "Pengajuan telah ditambahkan";
                break;
            case 2:
                switch ($status) {
                    case 0:
                        $this->mod_permintaan->ubah($data);
                        
                        $pesan = 2;
                        $isipesan = "Data pengajuan diubah dan status permintaan peserta diterima, menunggu proses penjadwalan";
                        break;
                    case 1:
                        if ($statusbaru == 2) {
                            $this->mod_permintaan->ubahjadwal($kdpengajuan,$lokasi,$jadwal,$kdpegawai,$statusbaru);

                            $pesan = 2;
                            $isipesan = "Pilihan jadwal diterima, menunggu proses pembayaran retribusi";
                        } else {
                            if($adapilihan == 0){
                                $this->mod_permintaan->resetjadwal($kdpengajuan);
                                $this->mod_permintaan->simpanjadwal($data2);

                                $this->mod_permintaan->ubahlokasi($kdpengajuan,$lokasi);

                                $pesan = 2;
                                $isipesan = "Pilihan jadwal telah diberikan, menunggu peserta memilih jadwal. Segera diinformasikan kepada peserta";
                            } else {
                                $pesan = 4;
                                $isipesan = "Data pilihan jadwal tidak ada";
                            }
                        }
                        break;
                    case 2:
                    case 3:
                        if ($nobukti != "" && $buktibayar != "") {
                            $this->mod_permintaan->ubahbayar($kdpengajuan,$nobukti,$tglbayar,$buktibayar,4);
                            $pesan = 2;
                            $isipesan = "Pembayaran retribusi diterima dan melanjutkan ke proses kegiatan pengujian UTTP. Segera diinformasikan kepada peserta";
                        } else {
                            $pesan = 4;
                            $isipesan = "Data pembayaran tidak ada";
                        }
                        break;
                    case 4:
                        if ($hasilawal == 0 && $hasil == 0) {
                            if($jadwalawal != $jadwal || $pegawaiawal != $kdpegawai){
                                $this->mod_permintaan->ubahjadwal2($kdpengajuan,$jadwal,$kdpegawai);

                                $pesan = 2;
                                $isipesan = "Perubahan jadwal tersimpan";
                            } else {
                                $pesan = 2;
                                $isipesan = "Data tersimpan";
                            }
                        }elseif ($hasilawal == 0 && $hasil != 0) {
                            if($jadwalawal != $jadwal || $pegawaiawal != $kdpegawai){
                                $pesan = 4;
                                $isipesan = "Jadwal dan atau pegawai penera berubah, jika ingin menginputkan data hasil pelayanan maka jadwal dan atau penera tidak boleh diubah";
                            } else {
                                $this->mod_permintaan->ubahhasil($kdpengajuan,$hasil,$cerapan,$keterangan,$statusbaru);

                                $pesan = 2;
                                $isipesan = "Hasil pelayanan tersimpan";
                            }
                        } elseif ($hasilawal == 2 && $hasil == 2 && $nosuratskrd != "" && $nosuratskhp != "" && $tglsuratskrd != "" && $tglsuratskhp != "" && $berlakuskhp != "") { 
                            $this->mod_permintaan->ubahselesai($kdpengajuan,$nosuratskrd,$tglsuratskrd,$nosuratskhp,$tglsuratskhp,$berlakuskhp.'-1',5);

                            $this->mod_permintaan->ubahuttppeserta($kduttppeserta,$nosuratskhp);

                            $pesan = 2;
                            $isipesan = "Proses pelayanan telah selesai dan segera diinformasikan kepada peserta untuk mengambil dokumen SKRD dan SKHP";
                        } else {
                            $pesan = 4;
                            $isipesan = "Data dokumen hasil pelayanan tidak ada";
                        }
                        break;
                    case 5:
                        $this->mod_permintaan->ubahbayar($kdpengajuan,$nobukti,$tglbayar,$buktibayar,$status);

                        // $this->mod_permintaan->ubahuttppeserta($kduttppeserta,$nosuratskhp);

                        if ($hasil == 1) {
                            $this->mod_permintaan->ubahhasil($kdpengajuan,$hasil,$cerapan,$keterangan,$status);
                        } elseif ($hasil == 2 && $nosuratskrd != "" && $nosuratskhp != "" && $tglsuratskrd != "" && $tglsuratskhp != "" && $berlakuskhp != "") { 
                            $this->mod_permintaan->ubahselesai($kdpengajuan,$nosuratskrd,$tglsuratskrd,$nosuratskhp,$tglsuratskhp,$berlakuskhp.'-1',$status);
                        }

                        $pesan = 2;
                        $isipesan = "Perubahan data pelayanan tersimpan";
                        break;
                }
                break;
            case 3:
                $berkas = $this->mod_permintaan->berkaspengajuan($kode);
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
                $berkastambahan = $this->mod_permintaan->berkaspengajuantambahan($kode)->result();
                foreach ($berkastambahan as $bt) {
                    if($bt->berkas != ""){
                        $file_foto = "upload/doktambahanpengajuan/" . $bt->berkas;
                        if (file_exists($file_foto)) {
                            unlink("./upload/doktambahanpengajuan/" . $bt->berkas);
                        }
                    }
                }

                $this->mod_permintaan->hapusdoktambahan($kode);
                $this->mod_permintaan->hapus($kode);
                
                $pesan = 3;
                $isipesan = "Data pengajuan serta file terkait dihapus";
                break;
            case 4:
                $this->mod_permintaan->ubahbatal($kdpengajuan,$alasanbatal,10);
                
                $pesan = 3;
                $isipesan = "Data pengajuan dibatalkan";
                break;
        }

        /* berkas tambahan pengajuan */
        if($jmlberkas > 0 && $proses != 3 && $status == 0){
            $this->mod_permintaan->resetberkastambahan($kdpengajuan);

            for($x=0; $x < $jmlberkas; $x++){
                $datadoktambahan = array(
                    "kdpengajuan" => $kdpengajuan,
                    "berkas" => $berkas_tambahan[$x]
                );

                $this->mod_permintaan->simpanberkastambahan($datadoktambahan);
            }
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("permintaan/index/1/20/-/-/$pesan/$msg");
    }

    public function serahterima($kelompok, $proses, $kdpengajuan)
    {
        $data['halaman'] = "Pengajuan Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['kelompok'] = $kelompok;
        $data['proses'] = $proses;
        $data['kdpengajuan'] = $kdpengajuan;

        switch ($proses) {
            case 1:
                $data['judulform'] = "Penerimaan Alat";

                $data['tglterima'] = "-";
                $data['pegawaiterima'] = "";
                $data['keterangan'] = "-";
                $data['penerima'] = "-";
                $data['tglkembali'] = "";
                $data['nikterima'] = "-";
                $data['namapenerima'] = "-";

                $data['tgl'] = "";
                break;
            case 2:
                switch ($kelompok) {
                    case 1:
                        $data['judulform'] = "Pengembalian Alat";

                        // cek serahterima
                        $cekserahterima = $this->mod_permintaan->cekserahterima($kdpengajuan);
                        $data['tglterima'] = empty($cekserahterima) ? "-" : date('d-m-Y',strtotime($cekserahterima['tglterima']));
                        $data['tglterima2'] = empty($cekserahterima) ? "-" : $cekserahterima['tglterima'];
                        $data['pegawaiterima'] = empty($cekserahterima) ? "" : $cekserahterima['pegawaiterima'];
                        $data['keterangan'] = empty($cekserahterima) ? "-" : $cekserahterima['keterangan'];

                        if($data['pegawaiterima'] != ""){
                            $cekpegawai = $this->mod_permintaan->cekpegawai($data['pegawaiterima']);
                            $data['penerima'] =  empty($cekpegawai) ? "-" : $cekpegawai['nip']." - ".$cekpegawai['nama'];
                        } else{
                            $data['penerima'] = "-";
                        }

                        $data['tglkembali'] = empty($cekserahterima) ? "" : $cekserahterima['tglkembali'];
                        $data['nikterima'] = empty($cekserahterima) ? "-" : $cekserahterima['nikterima'];
                        $data['namapenerima'] = empty($cekserahterima) ? "-" : $cekserahterima['namapenerima'];

                        $data['tgl'] = $data['tglkembali'];
                        break;
                    case 2:
                        $data['judulform'] = "Penyerahan Dokumen";

                        $cekserahterima = $this->mod_permintaan->cekserahterimadok($kdpengajuan);
                        $data['tglterima'] = empty($cekserahterima) ? "-" : $cekserahterima['tglterima'];
                        $data['pegawaiterima'] = empty($cekserahterima) ? "" : $cekserahterima['pegawaiterima'];
                        $data['nikterima'] = empty($cekserahterima) ? "" : $cekserahterima['nikterima'];
                        $data['namapenerima'] = empty($cekserahterima) ? "" : $cekserahterima['namapenerima'];

                        $data['tgl'] = $data['tglterima'];
                        break;
                }
                break;
        }

        $ambilpengajuan = $this->mod_permintaan->ambilpengajuan($kdpengajuan);

        $data['kdpengajuan'] = $ambilpengajuan['kdpengajuan'];
        $data['kduttppeserta'] = $ambilpengajuan['kduttppeserta'];
        $data['tglpengajuan'] = date('d-m-Y',strtotime($ambilpengajuan['tglpengajuan']));
        $data['kdlayanan'] = $ambilpengajuan['kdlayanan'];
        $data['nama'] = $ambilpengajuan['nama'];
        $data['namauttp'] = $ambilpengajuan['namauttp'];
        $data['jadwal'] = date('d-m-Y',strtotime($ambilpengajuan['jadwal']));
        $data['kdpegawai'] = $ambilpengajuan['kdpegawai'];
        $data['nobukti'] = $ambilpengajuan['nobukti'];
        $data['tglbayar'] = date('d-m-Y',strtotime($ambilpengajuan['tglbayar']));
        $data['buktibayar'] = $ambilpengajuan['buktibayar'];
        $data['nosuratskrd'] = $ambilpengajuan['nosuratskrd'];
        $data['tglsuratskrd'] =$ambilpengajuan['tglsuratskrd'];
        $data['nosuratskhp'] = $ambilpengajuan['nosuratskhp'];
        $data['tglsuratskhp'] =$ambilpengajuan['tglsuratskhp'];
        $data['fotokondisi'] = $ambilpengajuan['fotokondisi'];
        $data['izinpersetujuantipe'] = $ambilpengajuan['izinpersetujuantipe'];
        $data['skhplama'] = $ambilpengajuan['skhplama'];
        $data['suratpermohonan'] = $ambilpengajuan['suratpermohonan'];
        $data['lokasi'] = $ambilpengajuan['lokasi'];
        $data['hasiluji'] = $ambilpengajuan['hasil'];
        $data['keterangan'] = $ambilpengajuan['keterangan'];
        $data['cerapan'] = $ambilpengajuan['cerapan'];
        $data['status'] = $ambilpengajuan['status'];

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

        $ambiluttp = $this->mod_permintaan->ambiluttp($data['kduttppeserta']);
        $data['kdpeserta'] = $ambiluttp['kdpeserta'];
        $data['kduttp'] = $ambiluttp['kduttp'];
        $data['merktype'] = $ambiluttp['merktype'];
        $data['kapasitas'] = $ambiluttp['kapasitas'];
        $data['noseri'] = $ambiluttp['noseri'];
        $data['jml'] = $ambiluttp['jml'];
        $data['kdlayanan'] = $ambiluttp['kdlayanan'];

        $cekpeserta = $this->mod_permintaan->cekpeserta($data['kdpeserta']);
        $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];

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

        $data['pegawai'] = $this->mod_permintaan->pegawai()->result();

        // penera
        $cekpeneratetapan = $this->mod_permintaan->cekpeneratetapan($data['kdpegawai']);
        // $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
        $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nama'];

        //save log
        $this->log_lib->log_info("Akses halaman formulir serah terima");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_serahterima');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function prosesserahterima($proses)
    {
        $tglterima = $this->input->post('tglterima');
        $tgl = $this->input->post('tgl');
        $kelompok = $this->input->post('kelompok');
        $kdpengajuan =  $this->input->post('kdpengajuan');
        $pegawaiterima =  $this->input->post('pegawaiterima');
        $nikpenerima =  $this->input->post('nikterima');
        $namapenerima =  $this->clear_string->clear_quotes($this->input->post('namaterima'));
        $keterangan = $this->clear_string->clear_quotes($this->input->post('keterangan'));
    
        $data = array(
            "tglterima" => $tglterima,
            "tgl" => $tgl,
            "kelompok" => $kelompok,
            "kdpengajuan" => $kdpengajuan,
            "pegawaiterima" => $pegawaiterima,
            "nikpenerima" => $nikpenerima,
            "namapenerima" => $namapenerima,
            "keterangan" => $keterangan
        );

        switch ($proses) {
            case 1:
                $this->mod_permintaan->terima($data);

                $pesan = 1;
                $isipesan = "Penerimaan alat tersimpan";
                break;
            case 2:
                switch ($kelompok) {
                    case 1:
                        $this->mod_permintaan->kembali($data);

                        $pesan = 2;
                        $isipesan = "Pengembalian alat tersimpan";
                        break;
                    case 2:
                        $this->mod_permintaan->resetterimadokumen($kdpengajuan);
                        $this->mod_permintaan->terimadokumen($data);

                        $pesan = 1;
                        $isipesan = "Penyerahan dokumen SKRD dan SKHP tersimpan";
                        break;
                }
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("permintaan/index/1/20/-/-/$pesan/$msg");
    }

    public function cetakterima($kdpengajuan)
    {
        $data['halaman'] = "Cetak Label Penerimaan Alat";

        $data['infoapp'] = $this->infoapp->info();

        $ambilpengajuan = $this->mod_permintaan->ambilpengajuan($kdpengajuan);

        $data['kdpengajuan'] = $ambilpengajuan['kdpengajuan'];
        $data['kduttppeserta'] = $ambilpengajuan['kduttppeserta'];
        $data['tglpengajuan'] = date('d-m-Y',strtotime($ambilpengajuan['tglpengajuan']));
        $data['kdlayanan'] = $ambilpengajuan['kdlayanan'];
        $data['nama'] = $ambilpengajuan['nama'];
        $data['namauttp'] = $ambilpengajuan['namauttp'];
        $data['jadwal'] = date('d-m-Y',strtotime($ambilpengajuan['jadwal']));
        $data['kdpegawai'] = $ambilpengajuan['kdpegawai'];

        // penera
        $cekpeneratetapan = $this->mod_permintaan->cekpeneratetapan($data['kdpegawai']);
        // $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nip']." - ".$cekpeneratetapan['nama'];
        $data['namapenera'] = empty($cekpeneratetapan) ? "-":$cekpeneratetapan['nama'];

        // data uttp
        $ambiluttp = $this->mod_permintaan->ambiluttp($data['kduttppeserta']);
        $data['kdpeserta'] = $ambiluttp['kdpeserta'];
        $data['kduttp'] = $ambiluttp['kduttp'];
        $data['merktype'] = $ambiluttp['merktype'];
        $data['kapasitas'] = $ambiluttp['kapasitas'];
        $data['noseri'] = $ambiluttp['noseri'];
        $data['jml'] = $ambiluttp['jml'];
        $data['kdlayanan'] = $ambiluttp['kdlayanan'];

        $cekpeserta = $this->mod_permintaan->cekpeserta($data['kdpeserta']);
        $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];

        // cek serahterima
        $cekserahterima = $this->mod_permintaan->cekserahterima($kdpengajuan);
        $data['tglterima'] = empty($cekserahterima) ? "-" : date('d-m-Y',strtotime($cekserahterima['tglterima']));
        $data['pegawaiterima'] = empty($cekserahterima) ? "" : $cekserahterima['pegawaiterima'];
        $data['keterangan'] = empty($cekserahterima) ? "-" : $cekserahterima['keterangan'];

        if($data['pegawaiterima'] != ""){
            $cekpegawai = $this->mod_permintaan->cekpegawai($data['pegawaiterima']);
            // $data['penerima'] =  empty($cekpegawai) ? "-" : $cekpegawai['nip']." - ".$cekpegawai['nama'];
            $data['penerima'] =  empty($cekpegawai) ? "-" : $cekpegawai['nama'];
        } else{
            $data['penerima'] = "-";
        }

        $this->load->view('backend/page/cetakterima', $data);
    }

    public function cekbatasjadwal($tgl,$kdpegawai)
    {
        $cekbatas = $this->mod_permintaan->cekbatas();
        $batas = empty($cekbatas) ? 0 : $cekbatas['jml'];

        $cekjmljadwal = $this->mod_permintaan->cekjmljadwal($kdpegawai,$tgl);

        if($batas != 0 && $batas > $cekjmljadwal){
            echo 1;
        } else {
            echo 0;
        }
    }

    public function cekskhplama($kduttppeserta,$noskhplama)
    {
        $data['infoapp'] = $this->infoapp->info();

        $skhplama = $this->mod_permintaan->cekskhplama($kduttppeserta,$noskhplama);
        
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

    public function cek($target,$value)
    {
        $ada = $this->mod_permintaan->cek($target,$value);

        echo $ada;
    }

    public function cekwaktu($tgl,$kduttp)
    {
        $waktuuttp = $this->mod_permintaan->waktuuttp($kduttp);

        $totalwaktu = $this->mod_permintaan->totalwaktu($tgl);

        $batas = $this->mod_permintaan->batas();

        $total = $totalwaktu['total'] + $waktuuttp['lama'];

        if($total > $batas){
            echo 0;
        } else {
            echo 1;
        }
    }
}