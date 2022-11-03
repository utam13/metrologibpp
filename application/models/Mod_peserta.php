<?
class mod_peserta extends CI_Model
{
    public function daftar($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select * from peserta where $q_cari order by tgldaftar DESC limit $start,$end");
    }

    public function jumlah_data($q_cari)
    {
        return $this->db->query("select * from peserta where $q_cari")->num_rows();
    }

    public function hitunguttp($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kdpeserta='$kode' and status='0'")->row_array();
    }

    public function hitunguttp2($kode)
    {
        return $this->db->query("select COALESCE(SUM(a.jml),0) as total 
                                        from uttppeserta a
                                            inner join pelanggan b
                                                on a.kdpeserta=b.pelanggan
                                        where b.kdpeserta='$kode' and a.status='1'")->row_array();
    }

    public function hitunguttppakai($kode)
    {
        return $this->db->query("select COALESCE(SUM(jml),0) as total from uttppeserta where kdpeserta='$kode' and status='1'")->row_array();
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

    public function ambil($kode)
    {
        return $this->db->query("select * from peserta where kdpeserta='$kode'")->row_array();
    }

    public function cek($target,$value)
    {
        return $this->db->query("select kdpeserta from peserta where $target='$value'")->num_rows();
    }

    public function ceknpwp($npwp)
    {
        return $this->db->query("select * from peserta where npwp='$npwp'")->row_array();
    }

    public function berkas($kode)
    {
        return $this->db->query("select izinusaha,aktapendirian,ktp from peserta where kdpeserta='$kode'")->row_array();
    }

    public function adapengajuan($kode)
    {
        return $this->db->query("select a.kdpengajuan
                                        from pengajuan a 
                                            inner join uttppeserta b
                                                on a.kduttppeserta=b.kduttppeserta
                                        where b.kdpeserta='$kode'")->num_rows();
    }

    public function simpan($data)
    {
        extract($data);
        // $this->db->query("insert into peserta(npwp,
        //                                         nama,
        //                                         alamat,
        //                                         kdkecamatan,
        //                                         kdkelurahan,
        //                                         email,
        //                                         telp,
        //                                         nik,
        //                                         namapic,
        //                                         jabatan,
        //                                         telppic,
        //                                         wa,
        //                                         emailpic,
        //                                         tgldaftar,
        //                                         status,
        //                                         izinusaha,
        //                                         aktapendirian,
        //                                         ktp,
        //                                         password) 
        //                                 values('$npwp',
        //                                         '$nama',
        //                                         '$alamat',
        //                                         '$kecamatan',
        //                                         '$kelurahan',
        //                                         '$email',
        //                                         '$telp',
        //                                         '$nik',
        //                                         '$namapic',
        //                                         '$jabatan',
        //                                         '$telppic',
        //                                         '$wa',
        //                                         '$emailpic',
        //                                         '$tgldaftar',
        //                                         '$status',
        //                                         '$izinusaha',
        //                                         '$aktapendirian',
        //                                         '$ktp',
        //                                         '$password')");

        $this->db->query("insert into peserta(kelompok,
                                                npwp,
                                                nama,
                                                alamat,
                                                kdkecamatan,
                                                kdkelurahan,
                                                email,
                                                telp,
                                                nik,
                                                namapic,
                                                jabatan,
                                                telppic,
                                                wa,
                                                emailpic,
                                                tgldaftar,
                                                status,
                                                password) 
                                        values('$kelompok',
                                                '$npwp',
                                                '$nama',
                                                '$alamat',
                                                '$kecamatan',
                                                '$kelurahan',
                                                '$email',
                                                '$telp',
                                                '$nik',
                                                '$namapic',
                                                '$jabatan',
                                                '$telppic',
                                                '$wa',
                                                '$emailpic',
                                                '$tgldaftar',
                                                '$status',
                                                '$password')");
    }

    public function ubah($data)
    {
        extract($data);
        // $this->db->query("update peserta set npwp='$npwp',
        //                                     nama='$nama',
        //                                     alamat='$alamat',
        //                                     kecamatan='$kecamatan',
        //                                     kelurahan='$kelurahan',
        //                                     email='$email',
        //                                     telp='$telp',
        //                                     nik='$nik',
        //                                     namapic='$namapic',
        //                                     jabatan='$jabatan',
        //                                     telppic='$telppic',
        //                                     wa='$wa',
        //                                     emailpic='$emailpic',
        //                                     tgldaftar='$tgldaftar',
        //                                     status='$status',
        //                                     izinusaha='$izinusaha',
        //                                     aktapendirian='$aktapendirian',
        //                                     ktp='$ktp',
        //                                     password='$password'
        //                                 where kdpeserta='$kdpeserta'");

        $this->db->query("update peserta set kelompok='$kelompok',
                                            npwp='$npwp',
                                            nama='$nama',
                                            alamat='$alamat',
                                            kdkecamatan='$kecamatan',
                                            kdkelurahan='$kelurahan',
                                            email='$email',
                                            telp='$telp',
                                            nik='$nik',
                                            namapic='$namapic',
                                            jabatan='$jabatan',
                                            telppic='$telppic',
                                            wa='$wa',
                                            emailpic='$emailpic',
                                            tgldaftar='$tgldaftar',
                                            status='$status',
                                            password='$password'
                                        where kdpeserta='$kdpeserta'");
    }

    public function hapus($kode)
    {
        $this->db->query("delete from peserta where kdpeserta='$kode'");
    }

    public function hapussemuauttp($kode)
    {
        $this->db->query("delete from uttppeserta where kdpeserta='$kode'");
    }

    public function berkassemuauttp($kode)
    {
        return $this->db->query("select foto from uttppeserta where kdpeserta='$kode'");
    }

    public function terima($kode,$password)
    {
        $this->db->query("update peserta set status='1',password='$password' where kdpeserta='$kode'");
    }

    public function cekpeserta($kode)
    {
        return $this->db->query("select kelompok,npwp,nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function daftar_uttp($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari order by b.nama ASC limit $start,$end");
    }

    public function jumlah_uttp($q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari")->num_rows();
    }

    public function jmlpengajuan($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode' and status='5'")->num_rows();
    }

    public function cekpengajuan($kode)
    {
        return $this->db->query("select tglsuratskhp from pengajuan where kduttppeserta='$kode' order by tglsuratskhp DESC limit 0,1")->row_array();
    }

    public function uttp()
    {
        return $this->db->query("select * from uttp order by nama ASC");
    }

    public function ambiluttp($kode)
    {
        return $this->db->query("select * from uttppeserta where kduttppeserta='$kode'")->row_array();
    }

    public function cekuttp($kode)
    {
        return $this->db->query("select nama from uttp where kduttp='$kode'")->row_array();
    }

    public function uttppeserta($kode)
    {
        return $this->db->query("select kduttp from uttppeserta where kdpeserta='$kode'")->num_rows();
    }

    public function simpanuttp($data)
    {
        extract($data);
        $this->db->query("insert into uttppeserta(kdpeserta,
                                                kduttp,
                                                merktype,
                                                kapasitas,
                                                noseri,
                                                jml,
                                                foto,
                                                status) 
                                        values('$kdpeserta',
                                                '$kduttp',
                                                '$merktype',
                                                '$kapasitas',
                                                '$noseri',
                                                '$jml',
                                                '$foto',
                                                '$status')");
    }

    public function ubahuttp($data)
    {
        extract($data);
        $this->db->query("update uttppeserta set kdpeserta='$kdpeserta',
                                                kduttp='$kduttp',
                                                merktype='$merktype',
                                                kapasitas='$kapasitas',
                                                noseri='$noseri',
                                                jml='$jml',
                                                foto='$foto'
                                        where kduttppeserta='$kduttppeserta'");
    }

    
    public function ubahpemilik($kode)
    {
        $this->db->query("update uttppeserta set status='0' where kduttppeserta='$kode'");
    }

    public function hapusuttp($kode)
    {
        $this->db->query("delete from uttppeserta where kduttppeserta='$kode'");
    }

    public function uploadfile($namafile)
    {
        $this->db->query("insert into uploadfile(berkas) values('$namafile')");
    }

    public function berkasuttp($kode)
    {
        return $this->db->query("select foto from uttppeserta where kduttppeserta='$kode'")->row_array();
    }

    public function cekkelompok($kode)
    {
        return $this->db->query("select kelompok from peserta where kdpeserta='$kode'")->row_array();
    }

    public function adapelanggan($kode)
    {
        return $this->db->query("select kdpelanggan from pelanggan where kdpeserta='$kode'")->num_rows();
    }

    public function hitungpelanggan($kode)
    {
        return $this->db->query("select kdpelanggan from pelanggan where kdpeserta='$kode'")->num_rows();
    }

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
                                        where b.status='0' and d.kdpeserta='$kode' and a.berlakuskhp<='$tgl' AND a.berlakuskhp<>'0000-00-00'")->num_rows();
    }

    public function totalexpired2($kode,$tgl)
    {
        return $this->db->query("select a.kdpengajuan
                                        from pengajuan a 
                                            inner join uttppeserta b
                                                on a.nosuratskhp=b.noskhp
                                            inner join uttp c
                                                on b.kduttp=c.kduttp
                                            inner join pelanggan d
                                                on b.kdpeserta=d.pelanggan
                                        where b.status='1' and d.kdpeserta='$kode' and a.berlakuskhp<='$tgl' AND a.berlakuskhp<>'0000-00-00'")->num_rows();
    }
}