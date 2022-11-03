<?
class mod_slide extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }

    public function slide($kode)
    {
        return $this->db->query("select * from slide where kdslide='$kode'")->row_array();
    }

    public function ubah($no,$gambar)
    {
        $this->db->query("update slide set gambar='$gambar' where kdslide='$no'");
    }

    public function hapus($kode)
    {
        $this->db->query("update slide set gambar='' where kdslide='$kode'");
    }
}
