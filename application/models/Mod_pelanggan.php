<?
class mod_pelanggan extends CI_Model
{
    public function daftarpelanggan($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.kdpeserta as kdpeyedia,
                                        b.*
                                    from pelanggan a
                                        inner join peserta b
                                            on a.pelanggan=b.kdpeserta
                                    where $q_cari order by b.tgldaftar DESC limit $start,$end");
    }

    public function jumlahpelanggan($q_cari)
    {
        return $this->db->query("select a.kdpeserta as kdpeyedia,
                                        b.*
                                    from pelanggan a
                                        inner join peserta b
                                            on a.pelanggan=b.kdpeserta 
                                    where $q_cari")->num_rows();
    }

    public function simpanpelanggan($data)
    {
        extract($data);
        $this->db->query("insert into peserta(tgldaftar,
                                                kelompok,
                                                npwp,
                                                nama,
                                                alamat,
                                                kdkecamatan,
                                                kdkelurahan,
                                                email,
                                                telp,
                                                status) 
                                        values('$tgldaftar',
                                                '$kelompok',
                                                '$npwp',
                                                '$nama',
                                                '$alamat',
                                                '$kecamatan',
                                                '$kelurahan',
                                                '$email',
                                                '$telp',
                                                '$status')");
    }

    
    public function cekpeserta2($npwp)
    {
        return $this->db->query("select kdpeserta from peserta where npwp='$npwp'")->row_array();
    }

    public function simpanpelanggan2($kdpenyedia,$kdpeserta)
    {
        extract($data);
        $this->db->query("insert into pelanggan(kdpeserta,
                                                pelanggan) 
                                        values('$kdpenyedia',
                                                '$kdpeserta')");
    }

    public function ubahpelanggan($data)
    {
        extract($data);
        $this->db->query("update peserta set tgldaftar='$tgldaftar',
                                                kelompok='$kelompok',
                                                npwp='$npwp',
                                                nama='$nama',
                                                alamat='$alamat',
                                                kdkecamatan='$kecamatan',
                                                kdkelurahan='$kelurahan',
                                                email='$email',
                                                telp='$telp'
                                        where kdpeserta='$kdpeserta'");
    }

    public function hapuspelanggan($kode)
    {
        $this->db->query("delete from pelanggan where pelanggan='$kode'");
    }

    public function cekpenyedia($kode)
    {
        return $this->db->query("select kdpeserta from pelanggan where pelanggan='$kode'")->row_array();
    }

    public function registrasipelanggan($data)
    {
        extract($data);
        $this->db->query("update peserta set tgldaftar='$tgldaftar',
                                                kelompok='$kelompok',
                                                npwp='$npwp',
                                                nama='$nama',
                                                alamat='$alamat',
                                                kdkecamatan='$kecamatan',
                                                kdkelurahan='$kelurahan',
                                                email='$email',
                                                telp='$telp'
                                        where kdpeserta='$kdpeserta'");
    }

    public function cekkelurahan($kode)
    {
        return $this->db->query("select nama from kelurahan where kdkelurahan='$kode'")->row_array();
    }

    public function cekpelanggan($npwp)
    {
        return $this->db->query("select a.pelanggan 
                                    from pelanggan a
                                        inner join peserta b
                                            on a.pelanggan=b.kdpeserta
                                    where b.npwp='$npwp'")->num_rows();
    }

    public function cekpeserta($kode)
    {
        return $this->db->query("select kelompok,npwp,nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function hitunguttppakai($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kdpeserta='$kode' and status='1'")->row_array();
    }

    public function hitunguttp($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kdpeserta='$kode' and status='0'")->row_array();
    }

    public function kecamatan($kode)
    {
        return $this->db->query("select nama from kecamatan where kdkecamatan='$kode'")->row_array();
    }

    public function kelurahan($kode)
    {
        return $this->db->query("select nama from kelurahan where kdkelurahan='$kode'")->row_array();
    }

    public function ambilkelurahan($kdkecamatan)
    {
        return $this->db->query("select * from kelurahan where kdkecamatan='$kdkecamatan' order by nama ASC");
    }
    
    public function ambilkecamatan()
    {
        return $this->db->query("select * from kecamatan order by nama ASC");
    }

    public function totalexpired($kode,$tgl)
    {
        return $this->db->query("select a.kdpengajuan
                                        from pengajuan a 
                                            inner join uttppeserta b
                                                on a.nosuratskhp=b.noskhp
                                            inner join uttp c
                                                on b.kduttp=c.kduttp
                                            inner join peserta d
                                                on b.kdpeserta=d.kdpeserta
                                        where b.status='1' and d.kdpeserta='$kode' and a.berlakuskhp<='$tgl' AND a.berlakuskhp<>'0000-00-00'")->num_rows();
    }
}