<?
class mod_permintaan extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp,
                                        e.npwp,e.nama as namapeserta
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                        inner join peserta e
                                            on c.kdpeserta=e.kdpeserta
                                    where $q_cari 
                                    order by a.tglpengajuan DESC limit $start,$end");
    }

    public function jumlah_data($q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp,
                                        e.npwp,e.nama as namapeserta
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                        inner join peserta e
                                            on c.kdpeserta=e.kdpeserta
                                    where $q_cari")->num_rows();
    }

    public function cekpengajuan($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode' and status<>'5'")->row_array();
    }

    public function cekpengajuan2($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode'")->row_array();
    }

    public function ambilpengajuan($kode)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp 
                                        where a.kdpengajuan='$kode'")->row_array();
    }

    public function layanan($qlayanan)
    {
        return $this->db->query("select * from layanan where $qlayanan order by nama ASC");
    }

    public function ambiluttp($kode)
    {
        return $this->db->query("select a.*,
                                        b.kdlayanan 
                                    from uttppeserta a
                                        inner join uttp b
                                            on a.kduttp=b.kduttp
                                    where a.kduttppeserta='$kode'")->row_array();
    }

    public function cekberkastambahan($kduttp)
    {
        return $this->db->query("select kddoktambahan from doktambahan where kduttp='$kduttp'")->num_rows();
    }

    public function berkastambahan($kduttp)
    {
        return $this->db->query("select nama,berkas from doktambahan where kduttp='$kduttp' order by nama ASC");
    }

    public function berkastambahanpengajuan($kdpengajuan,$nama)
    {
        return $this->db->query("select berkas from doktambahpengajuan where kdpengajuan='$kdpengajuan' and berkas like '$nama%' order by berkas ASC")->row_array();
    }

    public function ceknamauttp($kode)
    {
        return $this->db->query("select b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where a.kduttppeserta='$kode'")->row_array();
    }

    public function cekpilihanjadwal($kode)
    {
        return $this->db->query("select kdpilihanjadwal from pilihanjadwal where kdpengajuan='$kode'")->num_rows();
    }

    public function ambilpilihanjadwal($kode)
    {
        return $this->db->query("select * from pilihanjadwal where kdpengajuan='$kode'")->row_array();
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into pengajuan(tglpengajuan,
                                                kduttppeserta,
                                                kdlayanan,
                                                fotokondisi,
                                                izinpersetujuantipe,
                                                adaskhplama,
                                                skhplama,
                                                noskhplama,
                                                tglskhplama,
                                                berlakuskhplama,
                                                lokasisebelumnya,
                                                suratpermohonan,
                                                status) 
                                        values('$tglpengajuan',
                                                '$kduttppeserta',
                                                '$kdlayanan',
                                                '$fotokondisi',
                                                '$izinpersetujuantipe',
                                                '$adaskhplama',
                                                '$skhplama',
                                                '$noskhplama',
                                                '$tglskhplama',
                                                '$berlakuskhplama',
                                                '$lokasisebelumnya',
                                                '$suratpermohonan',
                                                '1')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update pengajuan set kduttppeserta='$kduttppeserta',
                                                kdlayanan='$kdlayanan',
                                                fotokondisi='$fotokondisi',
                                                izinpersetujuantipe='$izinpersetujuantipe',
                                                adaskhplama='$adaskhplama',
                                                skhplama='$skhplama',
                                                noskhplama='$noskhplama',
                                                tglskhplama='$tglskhplama',
                                                berlakuskhplama='$berlakuskhplama',
                                                lokasisebelumnya='$lokasisebelumnya',
                                                suratpermohonan='$suratpermohonan',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahterjadwal($data)
    {
        extract($data);
        $this->db->query("update pengajuan set status='$status' where kdpengajuan='$kdpengajuan'");
    }

    public function ubahbayar($kdpengajuan,$nobukti,$tglbayar,$buktibayar,$status)
    {
        $this->db->query("update pengajuan set nobukti='$nobukti',
                                                tglbayar='$tglbayar',
                                                buktibayar='$buktibayar',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahjadwal($kdpengajuan, $lokasi, $jadwal, $kdpegawai, $status)
    {
        $this->db->query("update pengajuan set jadwal='$jadwal',
                                                kdpegawai='$kdpegawai',
                                                lokasi='$lokasi',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahjadwal2($kdpengajuan, $jadwal, $kdpegawai)
    {
        $this->db->query("update pengajuan set jadwal='$jadwal',
                                                kdpegawai='$kdpegawai'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahlokasi($kdpengajuan, $lokasi)
    {
        $this->db->query("update pengajuan set lokasi='$lokasi' where kdpengajuan='$kdpengajuan'");
    }

    public function ubahbatal($kdpengajuan,$alasanbatal,$status)
    {
        $this->db->query("update pengajuan set alasanbatal='$alasanbatal',status='$status' where kdpengajuan='$kdpengajuan'");
    }

    public function ubahhasil($kdpengajuan,$hasil,$cerapan,$keterangan,$status)
    {
        $this->db->query("update pengajuan set hasil='$hasil',
                                                cerapan='$cerapan',
                                                keterangan='$keterangan',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahselesai($kdpengajuan,$nosuratskrd,$tglsuratskrd,$nosuratskhp,$tglsuratskhp,$berlakuskhp,$status)
    {
        $this->db->query("update pengajuan set nosuratskrd='$nosuratskrd',
                                                tglsuratskrd='$tglsuratskrd',
                                                nosuratskhp='$nosuratskhp',
                                                tglsuratskhp='$tglsuratskhp',
                                                berlakuskhp='$berlakuskhp',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahuttppeserta($kduttppeserta,$nosuratskhp)
    {
        $this->db->query("update uttppeserta set noskhp='$nosuratskhp' where kduttppeserta='$kduttppeserta'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from pengajuan where kdpengajuan='$kode'");
    }

    public function hapusdoktambahan($kode)
    {
        $this->db->query("delete from doktambahpengajuan where kdpengajuan='$kode'");
    }

    public function berkaspengajuan($kode)
    {
        return $this->db->query("select kduttppeserta,
                                        fotokondisi,
                                        izinpersetujuantipe,
                                        skhplama,
                                        suratpermohonan,
                                        status 
                                    from pengajuan where kdpengajuan='$kode'")->row_array();
    }

    public function berkaspengajuantambahan($kode)
    {
        return $this->db->query("select berkas from doktambahpengajuan where kdpengajuan='$kode'");
    }

    public function monitoringpengajuan($kode)
    {
        return $this->db->query("select a.kdpengajuan
                                    from pengajuan a 
                                        inner join uttppeserta b
                                            on a.kduttppeserta=b.kduttppeserta
                                    where b.kdpeserta='$kode' and a.status<>'5'")->num_rows();
    }

    public function resetjadwal($kdpengajuan)
    {
        $this->db->query("delete from pilihanjadwal where kdpengajuan='$kdpengajuan'");
    }

    public function simpanjadwal($data)
    {
        extract($data);
        $this->db->query("insert into pilihanjadwal(kdpengajuan,
                                                tgl1,
                                                pegawai1,
                                                tgl2,
                                                pegawai2,
                                                tgl3,
                                                pegawai3,
                                                tgl4,
                                                pegawai4) 
                                        values('$kdpengajuan',
                                                '$tgl1',
                                                '$pegawai1',
                                                '$tgl2',
                                                '$pegawai2',
                                                '$tgl3',
                                                '$pegawai3',
                                                '$tgl4',
                                                '$pegawai4')");
    }

    public function uploadfile($namafile)
    {
        $this->db->query("insert into uploadfile(berkas) values('$namafile')");
    }

    public function cekpeserta($kode)
    {
        return $this->db->query("select nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function resetberkastambahan($kdpengajuan)
    {
        $this->db->query("delete from doktambahpengajuan where kdpengajuan='$kdpengajuan'");
    }

    public function simpanberkastambahan($data)
    {
        extract($data);
        $this->db->query("insert into doktambahpengajuan(kdpengajuan,
                                                berkas) 
                                        values('$kdpengajuan',
                                                '$berkas')");
    }

    public function penera()
    {
        return $this->db->query("select kdpegawai,nip,nama from pegawai where level='3' order by nama ASC");
    }

    public function pegawai()
    {
        return $this->db->query("select kdpegawai,nip,nama from pegawai order by nama ASC");
    }

    public function cekpenera($qjadwal)
    {
        return $this->db->query("select * from pilihanjadwal where $qjadwal")->row_array();
    }

    public function cekpeneratetapan($kode)
    {
        return $this->db->query("select nip,nama from pegawai where kdpegawai='$kode'")->row_array();
    }

    public function cekterima($kdpengajuan)
    {
        return $this->db->query("select kdserahterima from serahterima where kdpengajuan='$kdpengajuan' and kelompok='1'")->num_rows();
    }

    public function cekkembali($kdpengajuan)
    {
        return $this->db->query("select kdserahterima from serahterima where kdpengajuan='$kdpengajuan' and kelompok='1' and (tglkembali <> NULL or tglkembali <> '0000-00-00')")->num_rows();
    }

    public function cekterimadok($kdpengajuan)
    {
        return $this->db->query("select kdserahterima from serahterima where kdpengajuan='$kdpengajuan' and kelompok='2'")->num_rows();
    }

    public function cekserahterima($kdpengajuan)
    {
        return $this->db->query("select * from serahterima where kdpengajuan='$kdpengajuan' and kelompok='1'")->row_array();
    }

    public function cekserahterimadok($kdpengajuan)
    {
        return $this->db->query("select * from serahterima where kdpengajuan='$kdpengajuan' and kelompok='2'")->row_array();
    }

    public function cekpegawai($kode)
    {
        return $this->db->query("select nip,nama from pegawai where kdpegawai='$kode'")->row_array();
    }

    public function terima($data)
    {
        extract($data);
        $this->db->query("insert into serahterima(kdpengajuan,
                                                    tglterima,
                                                    kelompok,
                                                    pegawaiterima,
                                                    keterangan) 
                                        values('$kdpengajuan',
                                                '$tgl',
                                                '$kelompok',
                                                '$pegawaiterima',
                                                '$keterangan')");
    }

    public function kembali($data)
    {
        extract($data);
        $this->db->query("update serahterima set tglterima='$tglterima',
                                                tglkembali='$tgl',
                                                pegawaiterima='$pegawaiterima',
                                                nikterima='$nikpenerima',
                                                namapenerima='$namapenerima'
                                    where kdpengajuan='$kdpengajuan' and kelompok='1'");
    }

    public function terimadokumen($data)
    {
        extract($data);
        $this->db->query("insert into serahterima(kdpengajuan,
                                                    tglterima,
                                                    kelompok,
                                                    pegawaiterima,
                                                    nikterima,
                                                    namapenerima) 
                                        values('$kdpengajuan',
                                                '$tgl',
                                                '$kelompok',
                                                '$pegawaiterima',
                                                '$nikpenerima',
                                                '$namapenerima')");
    }

    public function resetterimadokumen($kode)
    {
        $this->db->query("delete from serahterima where kdpengajuan='$kode' and kelompok='2'");
    }

    public function cekbatas()
    {
        return $this->db->query("select jml from bataslayanan")->row_array();
    }

    public function cekjmljadwal($kdpegawai,$tgl)
    {
        return $this->db->query("select jadwal from pengajuan where kdpegawai='$kdpegawai' and jadwal='$tgl'")->num_rows();
    }

    public function isiinfotambahan($kode)
    {
        return $this->db->query("select * from infotambahan where kduttp='$kode' order by info ASC");
    }

    public function ambilinfotambahan($kode,$info)
    {
        return $this->db->query("select * from infotambahanpeserta where kduttppeserta='$kode' and info='$info'")->row_array();
    }

    public function cekskhplama($kduttppeserta,$noskhp)
    {
        return $this->db->query("select nosuratskhp,tglsuratskhp,berlakuskhp from pengajuan where kduttppeserta='$kduttppeserta' and nosuratskhp='$noskhp'")->row_array();
    }

    public function cekskhputtp($nosuratskhp)
    {
        return $this->db->query("select noskhp from uttppeserta where noskhp='$nosuratskhp'")->num_rows();
    }

    public function cek($target,$value)
    {
        return $this->db->query("select kdpengajuan from pengajuan where $target='$value'")->num_rows();
    }

    public function totalwaktu($tgl)
    {
        return $this->db->query("SELECT coalesce(SUM(c.lama),0) AS total
                                        FROM pengajuan a
                                            INNER JOIN uttppeserta b
                                                ON a.kduttppeserta=b.kduttppeserta
                                            INNER JOIN uttp c
                                                ON b.kduttp = c.kduttp
                                        WHERE a.jadwal='$tgl'")->row_array();
    }

    public function waktuuttp($kode)
    {
        return $this->db->query("SELECT lama FROM uttp where kduttp='$kode'")->row_array();
    }

    public function batas()
    {
        return $this->db->query("SELECT lama FROM bataslayanan")->row_array();
    }
}
