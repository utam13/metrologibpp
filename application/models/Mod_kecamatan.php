<?
class mod_kecamatan extends CI_Model
{
    public function kecamatan()
    {
        return $this->db->query("select * from kecamatan order by nama ASC");
    }

    public function kelurahan($kdkecamatan)
    {
        return $this->db->query("select * from kelurahan where kdkecamatan='$kdkecamatan' order by nama ASC");
    }

    public function cek_kecamatan($nama)
    {
        return $this->db->query("select nama from kecamatan where nama='$nama'")->row_array();
    }

    public function cek_kelurahan($nama)
    {
        return $this->db->query("select nama from kelurahan where nama='$nama'")->row_array();
    }

    public function ambilkelurahan($kode)
    {
        return $this->db->query("select * from kelurahan where kdkelurahan='$kode'")->row_array();
    }

    public function ambilkecamatan($kode)
    {
        return $this->db->query("select * from kecamatan where kdkecamatan='$kode'")->row_array();
    }

    public function simpankecamatan($nama)
    {
        $this->db->query("insert into kecamatan(nama) values('$nama')");
    }

    public function ubahkecamatan($kode,$nama)
    {
        $this->db->query("update kecamatan set nama='$nama' where kdkecamatan='$kode'");
    }

    public function hapuskecamatan($kode)
    {
        $this->db->query("delete from kecamatan where kdkecamatan='$kode'");
    }

    public function simpankelurahan($kdkecamatan,$nama)
    {
        $this->db->query("insert into kelurahan(kdkecamatan,nama) values('$kdkecamatan','$nama')");
    }

    public function ubahkelurahan($kode,$nama)
    {
        $this->db->query("update kelurahan set nama='$nama' where kdkelurahan='$kode'");
    }

    public function hapuskelurahan($kode)
    {
        $this->db->query("delete from kelurahan where kdkelurahan='$kode'");
    }

    public function hapussemuakelurahan($kode)
    {
        $this->db->query("delete from kelurahan where kdkecamatan='$kode'");
    }
}