<?
class mod_pegawai extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,b.kdjabatan from pegawai a inner join jabatan b on a.jabatan=b.nama where $q_cari order by b.kdjabatan, a.nama ASC limit $start,$end");
    }

    public function jumlah_data($q_cari)
    {
        return $this->db->query("select a.*,b.kdjabatan from pegawai a inner join jabatan b on a.jabatan=b.nama where $q_cari")->num_rows();
    }

    public function jabatan()
    {
        return $this->db->query("select * from jabatan order by kdjabatan ASC");
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from pegawai where kdpegawai='$kode'")->row_array();
    }

    public function cek_nip($nip)
    {
        return $this->db->query("select nip from pegawai where nip='$nip'")->num_rows();
    }

    public function ambiljabatan($kode)
    {
        return $this->db->query("select * from jabatan where kdjabatan='$kode'")->row_array();
    }

    public function ambilstruktur()
    {
        return $this->db->query("select * from struktur")->row_array();
    }

    public function cek_jabatan($nama)
    {
        return $this->db->query("select nama from jabatan where nama='$nama'")->num_rows();
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into pegawai(nip,
                                                nama,
                                                jabatan,
                                                password,
                                                level) 
                                        values('$nip',
                                                '$nama',
                                                '$jabatan',
                                                '$password',
                                                '$level')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update pegawai set nip='$nip',
                                                nama='$nama',
                                                jabatan='$jabatan',
                                                password='$password',
                                                level='$level'
                                        where kdpegawai='$kdpegawai'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from pegawai where kdpegawai='$kode'");
    }

    public function simpanjabatan($data)
    {
        extract($data);
        $this->db->query("insert into jabatan(nama) values('$nama')");
    }

    public function ubahjabatan($data)
    {
        extract($data);
        $this->db->query("update jabatan set nama='$nama' where kdjabatan='$kdjabatan'");
    }

    public function hapusjabatan($kode)
    {
        $this->db->query("delete from jabatan where kdjabatan='$kode'");
    }

    public function ubahstruktur($berkas)
    {
        $this->db->query("update struktur set berkas='$berkas' where kdstruktur='1'");
    }

    public function hapusstruktur()
    {
        $this->db->query("update struktur set berkas='' where kdstruktur='1'");
    }

    public function cek_nip2($kdpegawai, $nip)
    {
        return $this->db->query("select kdpegawai from pegawai where nip='$nip' and kdpegawai='$kdpegawai'")->num_rows();
    }

    public function cek_passlama($kdpegawai, $nip, $lama)
    {
        return $this->db->query("select kdpegawai from pegawai where nip='$nip' and password='$lama' and kdpegawai='$kdpegawai'")->num_rows();
    }

    public function ubahpassword($kdpegawai,$password)
    {
        $this->db->query("update pegawai set password='$password' where kdpegawai='$kdpegawai'");
    }
}