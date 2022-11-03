<?
class mod_uttppeserta extends CI_Model
{
    public function daftar_uttp($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari order by b.nama ASC limit $start,$end");
    }

    public function jumlah_uttp($q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari")->num_rows();
    }

    public function jmlpengajuan($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode' and status='5'")->num_rows();
    }

    public function cekpengajuan($kode,$noskhp)
    {
        return $this->db->query("select tglsuratskhp,berlakuskhp from pengajuan where kduttppeserta='$kode' and nosuratskhp='$noskhp'")->row_array();
    }

    public function uttp()
    {
        return $this->db->query("select * from uttp order by nama ASC");
    }

    public function ambiluttp($kode)
    {
        return $this->db->query("select * from uttppeserta where kduttppeserta='$kode'")->row_array();
    }

    public function cekuttp($kode)
    {
        return $this->db->query("select nama from uttp where kduttp='$kode'")->row_array();
    }

    public function uttppeserta($kode)
    {
        return $this->db->query("select kduttp from uttppeserta where kdpeserta='$kode'")->num_rows();
    }

    public function simpanuttp($data)
    {
        extract($data);
        $this->db->query("insert into uttppeserta(kdpeserta,
                                                kduttp,
                                                merktype,
                                                kapasitas,
                                                noseri,
                                                jml,
                                                foto,
                                                status) 
                                        values('$kdpeserta',
                                                '$kduttp',
                                                '$merktype',
                                                '$kapasitas',
                                                '$noseri',
                                                '$jml',
                                                '$foto',
                                                '$status')");
    }

    public function ubahuttp($data)
    {
        extract($data);
        $this->db->query("update uttppeserta set kdpeserta='$kdpeserta',
                                                kduttp='$kduttp',
                                                merktype='$merktype',
                                                kapasitas='$kapasitas',
                                                noseri='$noseri',
                                                jml='$jml',
                                                foto='$foto'
                                        where kduttppeserta='$kduttppeserta'");
    }

    public function resetinfotambahan($kode)
    {
        $this->db->query("delete from infotambahanpeserta where kduttppeserta='$kode'");
    }

    public function simpaninfotambahan($kduttppeserta,$info,$isi)
    {
        $this->db->query("insert into infotambahanpeserta(kduttppeserta,
                                                info,
                                                isi) 
                                        values('$kduttppeserta',
                                                '$info',
                                                '$isi')");
    }
    
    public function ubahpemilik($kode)
    {
        $this->db->query("update uttppeserta set status='0' where kduttppeserta='$kode'");
    }

    public function hapusuttp($kode)
    {
        $this->db->query("delete from uttppeserta where kduttppeserta='$kode'");
    }

    public function uploadfile($namafile)
    {
        $this->db->query("insert into uploadfile(berkas) values('$namafile')");
    }

    public function berkasuttp($kode)
    {
        return $this->db->query("select foto from uttppeserta where kduttppeserta='$kode'")->row_array();
    }

    public function cekpeserta($kode)
    {
        return $this->db->query("select kelompok,npwp,nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function cekpenyedia($kode)
    {
        return $this->db->query("select kdpeserta from pelanggan where pelanggan='$kode'")->row_array();
    }

    public function adapengajuan($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode'")->num_rows();
    }

    public function adaskhplama($kode)
    {
        return $this->db->query("select kdskhplama from skhplama where kduttppeserta='$kode'")->num_rows();
    }

    public function infotambahan($kode)
    {
        return $this->db->query("select info from infotambahan where kduttp='$kode' order by info ASC");
    }

    public function isiinfotambahan($kode)
    {
        return $this->db->query("select * from infotambahan where kduttp='$kode' order by info ASC");
    }

    public function cekuttppeserta($kdpeserta,$kduttp)
    {
        return $this->db->query("select kduttppeserta from uttppeserta where kdpeserta='$kdpeserta' and kduttp='$kduttp'")->row_array();
    }

    public function ambilinfotambahan($kode,$info)
    {
        return $this->db->query("select * from infotambahanpeserta where kduttppeserta='$kode' and info='$info'")->row_array();
    }

    public function adapengajuanberjalan($kduttppeserta)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kduttppeserta' and status<'5' ")->num_rows();
    }
}