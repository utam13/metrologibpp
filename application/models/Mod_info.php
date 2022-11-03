<?
class mod_info extends CI_Model
{
    public function regulasi()
    {
        return $this->db->query("select * from regulasi order by thn ASC");
    }

    public function sop()
    {
        return $this->db->query("select * from sop order by nama ASC");
    }

    public function struktur()
    {
        return $this->db->query("select berkas from struktur")->row_array();
    }

    public function daftar_pegawai($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,b.kdjabatan from pegawai a inner join jabatan b on a.jabatan=b.nama where $q_cari order by b.kdjabatan ASC limit $start,$end");
    }

    public function jumlah_pegawai($q_cari)
    {
        return $this->db->query("select a.*,b.kdjabatan from pegawai a inner join jabatan b on a.jabatan=b.nama where $q_cari")->num_rows();
    }

    public function daftar_uttp($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from uttp where $q_cari order by nama ASC limit $start,$end");
    }

    public function jumlah_uttp()
    {
        return $this->db->query("select * from uttp")->num_rows();
    }

    public function doktambahan($kode)
    {
        return $this->db->query("select * from doktambahan where kduttp='$kode' order by nama ASC");
    }

    public function cekuttpterdata($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kduttp='$kode'")->row_array();
    }

    public function daftar_kecamatan()
    {
        return $this->db->query("select * from kecamatan order by nama ASC");
    }

    public function cekuttpkecamatan($kduttp,$kdkecamatan)
    {
        return $this->db->query("select COALESCE(SUM(a.jml),0) as total 
                                        from uttppeserta a
                                            inner join peserta b
                                                on a.kdpeserta=b.kdpeserta
                                        where a.kduttp='$kduttp' and b.kdkecamatan='$kdkecamatan'")->row_array();
    }

    public function cekuttp($kode)
    {
        return $this->db->query("select nama from uttp where kduttp='$kode'")->row_array();
    }

    public function daftar_kelurahan($kdkecamatan)
    {
        return $this->db->query("select * from kelurahan where kdkecamatan='$kdkecamatan' order by nama ASC");
    }

    public function cekkecamatan($kode)
    {
        return $this->db->query("select nama from kecamatan where kdkecamatan='$kode'")->row_array();
    }

    public function cekuttpkelurahan($kduttp,$kdkelurahan)
    {
        return $this->db->query("select COALESCE(SUM(a.jml),0) as total 
                                        from uttppeserta a
                                            inner join peserta b
                                                on a.kdpeserta=b.kdpeserta
                                        where a.kduttp='$kduttp' and b.kdkelurahan='$kdkelurahan'")->row_array();
    }

    public function daftar_pemilik($kdkelurahan)
    {
        return $this->db->query("select * from peserta where kdkelurahan='$kdkelurahan' order by nama ASC");
    }

    public function cekkelurahan($kode)
    {
        return $this->db->query("select nama from kelurahan where kdkelurahan='$kode'")->row_array();
    }

    public function cekuttppeserta($kduttp,$kdpeserta)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kduttp='$kduttp' and kdpeserta='$kdpeserta'")->row_array();
    }
}