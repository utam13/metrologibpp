<?
class mod_galeriberita extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from berita where $q_cari order by tgl,jam ASC limit $start,$end");
    }

    public function jumlah($q_cari)
    {
        return $this->db->query("select * from berita where $q_cari")->num_rows();
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from berita where kdberita='$kode'")->row_array();
    }

    public function cek_judul($judul)
    {
        return $this->db->query("select judul from berita where judul='$judul'")->num_rows();
    }

    public function galeri($kode)
    {
        return $this->db->query("select gambar from galeri where kdberita='$kode'");
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into berita(tgl,jam,judul,isi,ig,fb,youtube) values('$tgl','$jam','$judul','$isi','$ig','$fb','$youtube')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update berita set tgl='$tgl',jam='$jam',judul='$judul',isi='$isi',ig='$ig',fb='$fb',youtube='$youtube' where kdberita='$kdberita'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from berita where kdberita='$kode'");
    }

    public function daftar_galeri($start = 0, $end = 10, $kdberita)
    {
        return $this->db->query("select * from galeri where kdberita='$kdberita' order by kdberita ASC limit $start,$end");
    }

    public function jumlah_galeri($kdberita)
    {
        return $this->db->query("select * from galeri where kdberita='$kdberita'")->num_rows();
    }

    public function simpangaleri($kdberita,$gambar)
    {
        $this->db->query("insert into galeri(kdberita,gambar,status) values('$kdberita','$gambar','0')");
    }

    public function resetgaleri($kdberita)
    {
        $this->db->query("update galeri set status='0' where kdberita='$kdberita'");
    }

    public function ubahgaleri($kdgaleri)
    {
        $this->db->query("update galeri set status='1' where kdgaleri='$kdgaleri'");
    }

    public function hapusgaleri($kode)
    {
        $this->db->query("delete from galeri where kdgaleri='$kode'");
    }

    public function hapussemuagaleri($kode)
    {
        $this->db->query("delete from galeri where kdberita='$kode'");
    }
}