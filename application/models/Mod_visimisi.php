<?
class mod_visimisi extends CI_Model
{
    public function visimisi()
    {
        return $this->db->query("select * from visimisi")->row_array();
    }

    public function ubah($visi, $misi)
    {
        $this->db->query("update visimisi set visi='$visi', misi='$misi' where kdvisimisi='1'");
    }

    public function hapus()
    {
        $this->db->query("update visimisi set visi='', misi='' where kdvisimisi='1'");
    }
}