<?
class mod_admin extends CI_Model
{
    public function registrasi($status)
    {
        return $this->db->query("select kdpeserta from peserta where status='$status'")->num_rows();
    }

    public function pengajuan($status)
    {
        return $this->db->query("select kdpengajuan from pengajuan where status='$status'")->num_rows();
    }

    public function uploadfile()
    {
        return $this->db->query("select * from uploadfile");
    }

    public function cek_berkaspeserta($namafile)
    {
        return $this->db->query("select kdpeserta from peserta where (izinusaha='$namafile' or aktapendirian='$namafile' or ktp='$namafile')")->num_rows();
    }

    public function cek_uttppeserta($namafile)
    {
        return $this->db->query("select kduttppeserta from uttppeserta where foto='$namafile'")->num_rows();
    }

    public function clearupload($namafile)
    {
        $this->db->query("delete from uploadfile where berkas='$namafile'");
    }
}
