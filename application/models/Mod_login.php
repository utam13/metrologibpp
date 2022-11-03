<?
class mod_login extends CI_Model
{
    public function kantor()
    {
        return $this->db->query("select logo from kantor")->row_array();
    }

    public function cek_username($username)
    {
        return $this->db->query("select nip from pegawai where nip='$username'")->num_rows();
    }

    public function cek_password($username, $pass)
    {
        return $this->db->query("select nip from pegawai where nip='$username' and password='$pass'")->num_rows();
    }

    public function ambil($username)
    {
        return $this->db->query("select * from pegawai where nip='$username'")->row_array();
    }
}
