<?
class mod_tentang extends CI_Model
{
    public function tentang()
    {
        return $this->db->query("select * from tentang")->row_array();
    }

    public function ubah($singkat, $isi)
    {
        $this->db->query("update tentang set singkat='$singkat', isitentang='$isi' where kdtentang='1'");
    }

    public function hapus()
    {
        $this->db->query("update tentang set singkat='', isitentang='' where kdtentang='1'");
    }
}