<?
class mod_excel extends CI_Model
{
    public function daftar($q_cari)
    {
        return $this->db->query("select * from peserta where $q_cari order by tgldaftar DESC");
    }

    public function daftarpelanggan($q_cari)
    {
        return $this->db->query("select a.kdpeserta as kdpeyedia,
                                        b.*
                                    from pelanggan a
                                        inner join peserta b
                                            on a.pelanggan=b.kdpeserta
                                    where $q_cari order by b.tgldaftar DESC");
    }

    public function kecamatan($kode)
    {
        return $this->db->query("select nama from kecamatan where kdkecamatan='$kode'")->row_array();
    }

    public function kelurahan($kode)
    {
        return $this->db->query("select nama from kelurahan where kdkelurahan='$kode'")->row_array();
    }

    public function hitunguttp($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kdpeserta='$kode' and status='0'")->row_array();
    }

    public function hitunguttp2($kode)
    {
        return $this->db->query("select COALESCE(SUM(a.jml),0) as total 
                                        from uttppeserta a
                                            inner join pelanggan b
                                                on a.kdpeserta=b.pelanggan
                                        where b.kdpeserta='$kode' and a.status='1'")->row_array();
    }

    public function hitunguttppakai($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kdpeserta='$kode' and status='1'")->row_array();
    }

    public function hitungpelanggan($kode)
    {
        return $this->db->query("select kdpelanggan from pelanggan where kdpeserta='$kode'")->num_rows();
    }

    public function cekpeserta($kode)
    {
        return $this->db->query("select npwp,nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function daftar_uttp($q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari order by b.nama ASC");
    }

    public function jmlpengajuan($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode' and status='5'")->num_rows();
    }

    public function cekpengajuan($kode)
    {
        return $this->db->query("select tglsuratskhp from pengajuan where kduttppeserta='$kode' order by tglsuratskhp DESC limit 0,1")->row_array();
    }

    public function daftarpengajuan($q_cari)
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
                                    order by a.tglpengajuan DESC");
    }

    public function ceknamauttp($kode)
    {
        return $this->db->query("select b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where a.kduttppeserta='$kode'")->row_array();
    }

    public function cekpilihanjadwal($kode)
    {
        return $this->db->query("select kdpilihanjadwal from pilihanjadwal where kdpengajuan='$kode'")->num_rows();
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
        return $this->db->query("select kdserahterima from serahterima where kdpengajuan='$kdpengajuan' and kelompok='1' and (tglkembali<>'' or tglkembali<>'0000-00-00')")->num_rows();
    }

    public function cekterimadok($kdpengajuan)
    {
        return $this->db->query("select kdserahterima from serahterima where kdpengajuan='$kdpengajuan' and kelompok='2'")->num_rows();
    }
}