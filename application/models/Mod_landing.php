<?
class mod_landing extends CI_Model
{
    public function tentang()
    {
        return $this->db->query("select * from tentang")->row_array();
    }

    public function visimisi()
    {
        return $this->db->query("select * from visimisi")->row_array();
    }

    public function daftar_layanan()
    {
        return $this->db->query("select * from layanan order by nama ASC");
    }

    public function daftar_berita($start = 0, $end = 10)
    {
        return $this->db->query("select * from berita order by tgl,jam DESC limit $start,$end");
    }

    public function jumlah_berita()
    {
        return $this->db->query("select * from berita")->num_rows();
    }

    public function galeriutama($kdberita)
    {
        return $this->db->query("select gambar from galeri where kdberita='$kdberita'")->row_array();
    }

    public function galeriberita($kdberita)
    {
        return $this->db->query("select gambar from galeri where kdberita='$kdberita' order by kdgaleri ASC limit 0,1")->row_array();
    }

    public function daftar_galeri($start = 0, $end = 10)
    {
        return $this->db->query("select a.*,b.judul,b.tgl,b.jam from galeri a inner join berita b on a.kdberita=b.kdberita order by b.tgl,b.jam DESC limit $start,$end");
    }

    public function jumlah_galeri()
    {
        return $this->db->query("select a.*,b.judul,b.tgl,b.jam from galeri a inner join berita b on a.kdberita=b.kdberita")->num_rows();
    }

    public function ambil_berita($kdberita)
    {
        return $this->db->query("select * from berita where kdberita='$kdberita'")->row_array();
    }
}