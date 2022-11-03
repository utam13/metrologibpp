<?
class mod_regulasi extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from regulasi where $q_cari order by thn ASC limit $start,$end");
    }

    public function jumlah()
    {
        return $this->db->query("select * from regulasi")->num_rows();
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from regulasi where kdregulasi='$kode'")->row_array();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("select nama from regulasi where nama='$nama'")->num_rows();
    }

    public function berkas($kode)
    {
        return $this->db->query("select berkas from regulasi where kdregulasi='$kode'")->row_array();
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into regulasi(jenis,
                                                nomor,
                                                thn,
                                                nama,
                                                berkas) 
                                        values('$jenis',
                                                '$nomor',
                                                '$thn',
                                                '$nama',
                                                '$berkas')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update regulasi set jenis='$jenis',
                                            nomor='$nomor',
                                            thn='$thn',
                                            nama='$nama',
                                            berkas='$berkas'
                                        where kdregulasi='$kdregulasi'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from regulasi where kdregulasi='$kode'");
    }

    public function uploadfile($namafile)
    {
        $this->db->query("insert into uploadfile(berkas) values('$namafile')");
    }
}