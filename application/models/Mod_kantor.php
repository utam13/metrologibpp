<?
class mod_kantor extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select * from kantor where kdkantor='1'")->row_array();
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update kantor set nama='$nama',alamat='$alamat',telp='$telp',wa='$wa',email='$email',web='$web',waktuaktif='$waktuaktif',ig='$ig',fb='$fb',youtube='$youtube',googlemap='$googlemap' where kdkantor='1'");
    }

    public function update_logo($file_name)
    {
        $this->db->query("update kantor set logo='$file_name' where kdkantor='1'");
    }
}
