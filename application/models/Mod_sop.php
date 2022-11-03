<?
class mod_sop extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from sop where $q_cari order by nama ASC limit $start,$end");
    }

    public function jumlah()
    {
        return $this->db->query("select * from sop")->num_rows();
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from sop where kdsop='$kode'")->row_array();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("select nama from sop where nama='$nama'")->num_rows();
    }

    public function berkas($kode)
    {
        return $this->db->query("select berkas from sop where kdsop='$kode'")->row_array();
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into sop(nama,berkas) values('$nama','$berkas')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update sop set nama='$nama',berkas='$berkas' where kdsop='$kdsop'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from sop where kdsop='$kode'");
    }

    public function uploadfile($namafile)
    {
        $this->db->query("insert into uploadfile(berkas) values('$namafile')");
    }
}