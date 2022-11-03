<?
class mod_bataslayanan extends CI_Model
{
    public function batas()
    {
        return $this->db->query("select * from bataslayanan")->row_array();
    }

    public function simpan($lama)
    {
        $this->db->query("insert into bataslayanan(lama) values('$lama')");
    }

    public function hapus()
    {
        $this->db->query("truncate table bataslayanan");
    }
}