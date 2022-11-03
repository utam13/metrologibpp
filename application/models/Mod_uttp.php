<?
class mod_uttp extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from uttp where $q_cari order by nama ASC limit $start,$end");
    }

    public function jumlah($q_cari)
    {
        return $this->db->query("select * from uttp where $q_cari")->num_rows();
    }

    public function doktambahan($kode)
    {
        return $this->db->query("select * from doktambahan where kduttp='$kode' order by nama ASC");
    }

    public function infotambahan($kode)
    {
        return $this->db->query("select * from infotambahan where kduttp='$kode' order by info ASC");
    }

    public function ceklayanan($kode)
    {
        return $this->db->query("select kdlayanan,nama from layanan where kdlayanan='$kode'")->row_array();
    }

    public function layanan()
    {
        return $this->db->query("select kdlayanan,nama from layanan order by nama ASC");
    }

    public function ambil($kode)
    {
        return $this->db->query("select * from uttp where kduttp='$kode'")->row_array();
    }

    public function cek_nama($nama)
    {
        return $this->db->query("select nama from uttp where nama='$nama'")->num_rows();
    }

    public function berkas($kode)
    {
        return $this->db->query("select gambar from uttp where kduttp='$kode'")->row_array();
    }

    public function simpan($data)
    {
        extract($data);
        $this->db->query("insert into uttp(kdlayanan,
                                            nama,
                                            berlaku,
                                            lama,
                                            keterangan,
                                            gambar) 
                                    values('$kdlayanan',
                                            '$nama',
                                            '$berlaku',
                                            '$lama',
                                            '$keterangan',
                                            '$berkas')");
    }

    public function ubah($data)
    {
        extract($data);
        $this->db->query("update uttp set kdlayanan='$kdlayanan',
                                            nama='$nama',
                                            berlaku='$berlaku',
                                            lama='$lama',
                                            keterangan='$keterangan',
                                            gambar='$berkas' 
                                        where kduttp='$kduttp'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from uttp where kduttp='$kode'");
    }

    public function daftardok($kduttp)
    {
        return $this->db->query("select * from doktambahan where kduttp='$kduttp' order by nama ASC");
    }

    public function cekuttp($kode)
    {
        return $this->db->query("select * from uttp where kduttp='$kode'")->row_array();
    }

    public function ambildokumen($kode)
    {
        return $this->db->query("select * from doktambahan where kddoktambahan='$kode'")->row_array();
    }

    public function simpandokumen($data)
    {
        extract($data);
        $this->db->query("insert into doktambahan(kduttp,
                                            nama,
                                            berkas) 
                                    values('$kduttp',
                                            '$nama',
                                            '$berkas')");
    }

    public function ubahdokumen($data)
    {
        extract($data);
        $this->db->query("update doktambahan set kduttp='$kduttp',
                                            nama='$nama',
                                            berkas='$berkas' 
                                        where kddoktambahan='$kddoktambahan'");
    }

    public function hapusdokumen($kode)
    {
        $this->db->query("delete from doktambahan where kddoktambahan='$kode'");
    }

    public function berkasdokumen($kode)
    {
        return $this->db->query("select berkas from doktambahan where kddoktambahan='$kode'")->row_array();
    }

    public function daftarinfo($kduttp)
    {
        return $this->db->query("select * from infotambahan where kduttp='$kduttp' order by info ASC");
    }

    public function ambilinfotambahan($kode)
    {
        return $this->db->query("select * from infotambahan where kdinfotambahan='$kode'")->row_array();
    }

    public function simpaninfotambahan($data)
    {
        extract($data);
        $this->db->query("insert into infotambahan(kduttp,
                                            info) 
                                    values('$kduttp',
                                            '$info')");
    }

    public function ubahinfotambahan($data)
    {
        extract($data);
        $this->db->query("update infotambahan set kduttp='$kduttp',
                                            info='$info'
                                        where kdinfotambahan='$kdinfotambahan'");
    }

    public function hapusinfotambahan($kode)
    {
        $this->db->query("delete from infotambahan where kdinfotambahan='$kode'");
    }
}