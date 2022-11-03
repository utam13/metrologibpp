<?
class mod_laporan extends CI_Model
{
    public function peserta()
    {
        return $this->db->query("select kdpeserta,npwp,nama from peserta order by nama ASC");
    }

    public function cekpeserta($kode)
    {
        return $this->db->query("select npwp,nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function daftarpeserta($q_cari)
    {
        return $this->db->query("select * from peserta where $q_cari order by tgldaftar DESC");
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

    public function daftarpengajuanexpired($q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp,
                                        e.npwp,e.nama as namapeserta
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.nosuratskhp=c.noskhp
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                        inner join peserta e
                                            on c.kdpeserta=e.kdpeserta
                                    where $q_cari 
                                    order by a.tglpengajuan DESC");
    }

    public function daftarpengajuanserahterima($q_cari)
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
                                        inner join serahterima f
                                            on a.kdpengajuan=f.kdpengajuan
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

    public function layanan()
    {
        return $this->db->query("select * from layanan order by nama ASC");
    }

    public function ceklayanan($kode)
    {
        return $this->db->query("select nama from layanan where kdlayanan='$kode'")->row_array();
    }
}