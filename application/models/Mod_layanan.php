<?
class mod_layanan extends CI_Model
{
    public function daftar()
    {
        return $this->db->query("select * from layanan order by nama ASC");
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from layanan where kdlayanan='$kode'")->row_array();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("select nama from layanan where nama='$nama'")->num_rows();
    }

    public function simpan($nama,$uraian)
    {
        $this->db->query("insert into layanan(nama,uraian) values('$nama','$uraian')");
    }

    public function ubah($kdlayanan,$nama,$uraian)
    {
        $this->db->query("update layanan set nama='$nama',uraian='$uraian' where kdlayanan='$kdlayanan'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from layanan where kdlayanan='$kode'");
    }
}