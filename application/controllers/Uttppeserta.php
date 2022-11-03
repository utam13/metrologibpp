<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uttppeserta extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('stat_log') != "login") {
            redirect(base_url("login"));
        }

        $this->load->model('mod_uttppeserta');
    }

    public function index($kdpeserta,$mode = 1,$page = 1, $limit = 20, $isicari = "-", $pesan = "", $isipesan = "")
    {
        $data['halaman'] = "UTTP Peserta Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['mode'] = $mode;

        $data['kdpeserta'] = $kdpeserta;
        $cekpeserta = $this->mod_uttppeserta->cekpeserta($kdpeserta);
        $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];
        $data['kelompok'] = empty($cekpeserta) ? 1:$cekpeserta['kelompok'];

        //cari
        if ($isicari != "-") {
            $getcari = str_replace("-", " ", urldecode($isicari));
        } else {
            $getcari = $this->clear_string->clear_quotes($this->input->post('cari'));
        }

        $cekpenyedia = $this->mod_uttppeserta->cekpenyedia($kdpeserta);
        $data['kdpenyedia'] = empty($cekpenyedia) ? "":$cekpenyedia['kdpeserta'];

        switch ($mode) {
            case 1:
                $q_cari = "status='0' and ";
                break;
            case 2:
                $q_cari = "status='1' and ";
                break;
        }
        
        if ($getcari != "") {
            $q_cari .= "(nama like '%$getcari%' or noskhp='$getcari') and kdpeserta='$kdpeserta'";
        } else {
            $q_cari .= "nama<>'' and kdpeserta='$kdpeserta'";
        }

        $cari = str_replace(" ", "-", $getcari);
        $data['getcari'] =  $cari;

        $msg = str_replace("-", " ", $isipesan);
        $data['alert'] = $this->alert_lib->alert($pesan, $msg);

        //pagination
        $jumlah_data = $this->mod_uttppeserta->jumlah_uttp($q_cari);

        if ($this->input->post('limitpage') != "") {
            $limit = $this->input->post('limitpage');
        }

        $limit_start = ($page - 1) * $limit;

        $data['limit'] = $limit;

        $no = $limit_start + 1;

        $uttp = $this->mod_uttppeserta->daftar_uttp($limit_start, $limit, $q_cari)->result();

        $record = array();
        $subrecord = array();
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
            $subrecord['status'] = $d->status;
            $subrecord['noskhp'] = $d->noskhp == '' ? '-':$d->noskhp;

            $subrecord['jmlpengajuan'] = $this->mod_uttppeserta->jmlpengajuan($d->kduttppeserta);

            $subrecord['adapengajuanberjalan'] = $this->mod_uttppeserta->adapengajuanberjalan($d->kduttppeserta);
            if ($subrecord['adapengajuanberjalan'] == 0) {
                $subrecord['proses'] = 1;
                $subrecord['namatombol'] = 'Pengajuan Baru';
                $subrecord['warnatombol'] = 'btn-warning';
            } else {
                $subrecord['proses'] = 2;
                $subrecord['namatombol'] = 'Lihat Pengajuan';
                $subrecord['warnatombol'] = 'btn-default';
            }

            if($d->noskhp != ''){
                $pengajuan = $this->mod_uttppeserta->cekpengajuan($d->kduttppeserta,$d->noskhp);
                $subrecord['tglterakhir'] = empty($pengajuan) || $pengajuan['tglsuratskhp'] == "" ? "-" : date('d-m-Y',strtotime($pengajuan['tglsuratskhp']));
                $subrecord['berlaku'] = empty($pengajuan) || $pengajuan['berlakuskhp'] == "" ? "" : $pengajuan['berlakuskhp'];

                if ($subrecord['berlaku'] != '') {
                    list($thn,$bln,$hr) = explode('-',$subrecord['berlaku']);
                    $subrecord['berlakusampai'] = $this->namabulan->namabln($bln).' '.$thn;

                    if(strtotime($subrecord['berlaku']) <= strtotime(date('Y-m-d'))){
                        $subrecord['warnabg'] = 'bg-maroon-active';
                    } else {
                        $subrecord['warnabg'] = '';
                    }
                } else {
                    $subrecord['berlakusampai'] = '-';
                    $subrecord['warnabg'] = '';
                }
            } else {
                $subrecord['tglterakhir'] = '-';
                $subrecord['berlaku'] = '-';
                $subrecord['berlakusampai'] = '-';
                $subrecord['warnabg'] = '';
            }
            

            $isiinfotambahan= $this->mod_uttppeserta->isiinfotambahan($d->kduttp)->result();
            foreach ($isiinfotambahan as $iit) {
                $ambilinfotambahan = $this->mod_uttppeserta->ambilinfotambahan($d->kduttppeserta,$iit->info);
                $isi = empty($ambilinfotambahan) ? '' : $ambilinfotambahan['isi'];
                $subrecord['nama'] .= '<br>'.$iit->info.': '.$isi;
            }

            // $subrecord['info'] =  "<span class='text-bold nama-uttp'>".$subrecord['nama']."</span>";
            // $subrecord['info'] .= "<br><span class='text-bold'>Merk/Type:</span> <span class='text-red'>".$d->merktype."</span>";
            // $subrecord['info'] .= "<br><span class='text-bold'>Kapasitas:</span> <span class='text-red'>".$d->kapasitas."</span>";
            // $subrecord['info'] .= "<br><span class='text-bold'>No. Seri:</span> <span class='text-red'>".$d->noseri."</span>";
            // $subrecord['info'] .= "<br><span class='text-bold'>Jumlah:</span> <span class='text-red'>".$d->jml." unit</span>";
            // $subrecord['info'] .= "<br><span class='text-bold'>Terakhir Tera Ulang:</span> <span class='text-red'>".$subrecord['tglterakhir']."</span>";
            // $subrecord['info'] .= "<br><span class='text-bold'>Jumlah Pengajuan:</span> <span class='text-red'>".$subrecord['jmlpengajuan']."</span>";

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
        //end

        //save log
        $this->log_lib->log_info("Akses halaman peserta tera atau tera Ulang");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/uttppeserta');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function formuliruttp($kdpeserta, $proses, $mode, $kode = "")
    {
        $data['halaman'] = "UTTP Peserta Tera/Tera Ulang";

        $data['infoapp'] = $this->infoapp->info();

        $data['mode'] = $mode;

        $data['kdpeserta'] = $kdpeserta;
        $cekpeserta = $this->mod_uttppeserta->cekpeserta($kdpeserta);
        $data['namapeserta'] = empty($cekpeserta) ? "-":$cekpeserta['nama'];
        $data['kelompok'] = empty($cekpeserta) ? 1:$cekpeserta['kelompok'];

        if($data['kelompok'] == 3){
            $cekpenyedia = $this->mod_uttppeserta->cekpenyedia($kdpeserta);
            $data['kdpenyedia'] = empty($cekpenyedia) ? "-":$cekpenyedia['kdpeserta'];
        } else {
            $data['kdpenyedia'] = "";
        }

        $data['proses'] = $proses;

        $data['listuttp'] = $this->mod_uttppeserta->uttp()->result();

        if($kode != ""){
            $ambiluttp = $this->mod_uttppeserta->ambiluttp($kode);

            $data['kduttppeserta'] = $ambiluttp['kduttppeserta'];
            $data['kduttp'] = $ambiluttp['kduttp'];
            $data['merktype'] = $ambiluttp['merktype'];
            $data['kapasitas'] = $ambiluttp['kapasitas'];
            $data['noseri'] = $ambiluttp['noseri'];
            $data['jml'] = $ambiluttp['jml'];
            $data['foto'] = $ambiluttp['foto'];

            $uttp = $this->mod_uttppeserta->cekuttp($ambiluttp['kduttp']);
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

            $data['adapengajuan'] = $this->mod_uttppeserta->adapengajuan($data['kduttppeserta']);

            $record = array();
            $subrecord = array();

            $isiinfotambahan= $this->mod_uttppeserta->isiinfotambahan($data['kduttp'])->result();

            foreach ($isiinfotambahan as $iit) {
                $label = strtolower(str_replace(' ','_',$iit->info));

                $ambilinfotambahan = $this->mod_uttppeserta->ambilinfotambahan($data['kduttppeserta'],$iit->info);
                $isi = empty($ambilinfotambahan) ? '' : $ambilinfotambahan['isi'];

                $subrecord['komponen'] = '<div class="form-group">'.
                                            '<label class="col-sm-3 control-label">'.$iit->info.'</label>'.
                                            '<div class="col-sm-5">'.
                                                '<input type="text" class="form-control" name="info[]" id="'.$label.'" value="'.$isi.'" maxlength=150 autocomplete="off" required />'.
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
            $data['jml'] = 1;
            $data['foto'] = date('dmYhis');
            $data['file_foto'] = base_url() . "upload/no-image.png";
            $data['adapengajuan'] = 0;
            $data['isiinfotambahan'] = "";
        }

        //save log
        $this->log_lib->log_info("Akses halaman formulir uttp peserta");

        $this->load->view('backend/layout/top', $data);
        $this->load->view('backend/layout/header');
        $this->load->view('backend/layout/sidebar');
        $this->load->view('backend/page/formulir_uttppeserta');
        $this->load->view('backend/layout/footer');
        $this->load->view('backend/layout/bottom');
    }

    public function cekinfotambahan($kduttp)
    {
        $record = array();
        $subrecord = array();

        $infotambahan = $this->mod_uttppeserta->infotambahan($kduttp)->result();
        foreach ($infotambahan as $it) {
            $subrecord['info'] = $it->info;

            array_push($record, $subrecord);
        }

        echo json_encode($record);
    }

    public function prosesuttp($proses, $mode, $kdpeserta = "", $kode = "")
    {
        if($proses < 3){
            $kduttppeserta =  $this->input->post('kode');
            $kdpeserta =  $this->input->post('kdpeserta');
            $kdpenyedia =  $this->input->post('kdpenyedia');
            $kduttp =  $this->input->post('uttp');
            $merktype = $this->input->post('merktype');
            $kapasitas = $this->input->post('kapasitas');
            $noseri = $this->input->post('noseri');
            $jml = $this->input->post('jml');
            $foto = $this->input->post('namafile');
            $info = $this->input->post('info');

            $cekpeserta = $this->mod_uttppeserta->cekpeserta($kdpeserta);
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
                $this->mod_uttppeserta->simpanuttp($data);

                $this->mod_uttppeserta->resetinfotambahan($kduttppeserta);
                $uttppeserta = $this->mod_uttppeserta->cekuttppeserta($kdpeserta,$kduttp);
                $kduttppeserta = empty($uttppeserta) ? '':$uttppeserta['kduttppeserta'];

                if($kduttppeserta != ''){
                    $no = 0;
                    $infotambahan = $this->mod_uttppeserta->infotambahan($kduttp)->result();
                    foreach ($infotambahan as $it) {;
                        $isi = $info[$no];
                        $this->mod_uttppeserta->simpaninfotambahan($kduttppeserta,$it->info,$isi);

                        $no++;
                    }
                }

                $pesan = 1;
                $isipesan = "Daftar uttp peserta baru di tambahkan";
                break;
            case 2:
                $this->mod_uttppeserta->ubahuttp($data);

                $this->mod_uttppeserta->resetinfotambahan($kduttppeserta);
                $no = 0;
                $infotambahan = $this->mod_uttppeserta->infotambahan($kduttp)->result();
                foreach ($infotambahan as $it) {;
                    $isi = $info[$no];
                    $this->mod_uttppeserta->simpaninfotambahan($kduttppeserta,$it->info,$isi);

                    $no++;
                }

                $pesan = 2;
                $isipesan = "Data uttp peserta diubah";
                break;
            case 3:
                $berkas = $this->mod_uttppeserta->berkasuttp($kode);
                if(!empty($berkas)){
                    if($berkas['foto'] != ""){
                        $file_foto = "upload/uttppeserta/" . $berkas['foto'];
                        if (file_exists($file_foto)) {
                            unlink("./upload/uttppeserta/" . $berkas['foto']);
                        }
                    }
                }

                $this->mod_uttppeserta->hapusuttp($kode);
                
                $pesan = 3;
                $isipesan = "Daftar uttp peserta telah dikurangi beserta foto uttp";
                break;
            case 4:
                $this->mod_uttppeserta->ubahpemilik($kode);

                $pesan = 2;
                $isipesan = "Data uttp peserta dialihkan kepemilikannya ke pelanggan";
                break;
        }

        //save log
        $this->log_lib->log_info($isipesan);

        $msg = str_replace(" ", "-", $isipesan);

        redirect("uttppeserta/index/$kdpeserta/$mode/1/20/-/$pesan/$msg");
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
            $this->mod_uttppeserta->uploadfile($file_name);

            echo $file_name;
        }
    }

    public function batalberkasuttp($namafile)
    {
        $file_berkas = "upload/uttppeserta/" . $namafile;
        if (file_exists($file_berkas)) {
            unlink("./upload/uttppeserta/" . $namafile);
        }
    }
}