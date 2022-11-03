<?
class mod_pelayanan extends CI_Model
{
    public function kelurahan($kdkecamatan)
    {
        return $this->db->query("select * from kelurahan where kdkecamatan='$kdkecamatan' order by nama ASC");
    }

    public function kecamatan()
    {
        return $this->db->query("select * from kecamatan order by nama ASC");
    }

    public function cekkelurahan($kode)
    {
        return $this->db->query("select nama from kelurahan where kdkelurahan='$kode'")->row_array();
    }

    public function cekkecamatan($kode)
    {
        return $this->db->query("select nama from kecamatan where kdkecamatan='$kode'")->row_array();
    }

    public function cek($target,$value)
    {
        return $this->db->query("select kdpeserta from peserta where $target='$value'")->num_rows();
    }

    public function uploadfile($namafile)
    {
        $this->db->query("insert into uploadfile(berkas) values('$namafile')");
    }

    public function registrasi($data)
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
        //                                         ktp) 
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
        //                                         '0',
        //                                         '$izinusaha',
        //                                         '$aktapendirian',
        //                                         '$ktp')");

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
                                                status) 
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
                                                '0')");
    }

    public function cek_password($username, $pass)
    {
        return $this->db->query("select kdpeserta from peserta where nik='$username' and password='$pass'")->num_rows();
    }

    public function ambil($username)
    {
        return $this->db->query("select kdpeserta,npwp from peserta where nik='$username'")->row_array();
    }

    public function ambilpeserta($kode)
    {
        return $this->db->query("select * from peserta where kdpeserta='$kode'")->row_array();
    }

    public function daftaruttp($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari order by b.nama ASC limit $start,$end");
    }

    public function jumlahuttp($q_cari)
    {
        return $this->db->query("select a.*,b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where $q_cari")->num_rows();
    }

    public function jmlpengajuan($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode'")->num_rows();
    }

    public function monitoringpengajuan($kode)
    {
        return $this->db->query("select a.kdpengajuan
                                    from pengajuan a 
                                        inner join uttppeserta b
                                            on a.kduttppeserta=b.kduttppeserta
                                    where b.kdpeserta='$kode' and a.status<'5'")->num_rows();
    }

    public function monitoringpengajuan2($kode)
    {
        return $this->db->query("select a.kdpengajuan
                                    from pengajuan a 
                                        inner join uttppeserta b
                                            on a.kduttppeserta=b.kduttppeserta
                                        inner join pelanggan c
                                            on b.kdpeserta=c.pelanggan
                                    where c.kdpeserta='$kode' and a.status<'5'")->num_rows();
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

    public function hitungpelanggan($kode)
    {
        return $this->db->query("select kdpelanggan from pelanggan where kdpeserta='$kode'")->num_rows();
    }

    public function cekpengajuan($kode)
    {
        return $this->db->query("select nosuratskhp,tglsuratskhp,berlakuskhp from pengajuan where kduttppeserta='$kode' order by tglsuratskhp DESC limit 0,1")->row_array();
    }

    public function uttp()
    {
        return $this->db->query("select * from uttp order by nama ASC");
    }

    public function layanan($qlayanan)
    {
        return $this->db->query("select * from layanan where $qlayanan order by nama ASC");
    }

    public function cekuttp($kode)
    {
        return $this->db->query("select nama from uttp where kduttp='$kode'")->row_array();
    }

    public function berkasuttp($kode)
    {
        return $this->db->query("select foto from uttppeserta where kduttppeserta='$kode'")->row_array();
    }

    public function cekuttppeserta($kdpeserta,$kduttp)
    {
        return $this->db->query("select kduttppeserta from uttppeserta where kdpeserta='$kdpeserta' and kduttp='$kduttp'")->num_rows();
    }

    public function ambiluttp($kode)
    {
        return $this->db->query("select a.*,
                                        b.kdlayanan 
                                    from uttppeserta a
                                        inner join uttp b
                                            on a.kduttp=b.kduttp
                                    where a.kduttppeserta='$kode'")->row_array();
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

    public function ubahuttp2($data)
    {
        extract($data);
        $this->db->query("update uttppeserta set merktype='$merktype' where kduttppeserta='$kduttppeserta'");
    }

    public function hapusuttp($kode)
    {
        $this->db->query("delete from uttppeserta where kduttppeserta='$kode'");
    }

    public function ambilpengajuan($kode)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp 
                                        where a.kdpengajuan='$kode'")->row_array();
    }


    public function daftarpengajuan($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                    where $q_cari 
                                    order by a.tglpengajuan DESC limit $start,$end");
    }

    public function jumlahpengajuan($q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                    where $q_cari")->num_rows();
    }

    public function daftarpengajuan2($start = 0, $end = 10, $q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                        inner join pelanggan e
                                            on c.kdpeserta=e.pelanggan
                                    where $q_cari 
                                    order by a.tglpengajuan DESC limit $start,$end");
    }

    public function jumlahpengajuan2($q_cari)
    {
        return $this->db->query("select a.*,
                                        b.nama,
                                        d.nama as namauttp
                                    from pengajuan a 
                                        inner join layanan b
                                            on a.kdlayanan=b.kdlayanan
                                        inner join uttppeserta c
                                            on a.kduttppeserta=c.kduttppeserta
                                        inner join uttp d
                                            on c.kduttp=d.kduttp
                                        inner join pelanggan e
                                            on c.kdpeserta=e.pelanggan
                                    where $q_cari")->num_rows();
    }

    public function cekpilihanjadwal($kode)
    {
        return $this->db->query("select kdpilihanjadwal from pilihanjadwal where kdpengajuan='$kode'")->num_rows();
    }

    public function pilihanjadwal($kode)
    {
        return $this->db->query("select * from pilihanjadwal where kdpengajuan='$kode'")->row_array();
    }

    public function ceknamauttp($kode)
    {
        return $this->db->query("select b.nama from uttppeserta a inner join uttp b on a.kduttp=b.kduttp where a.kduttppeserta='$kode'")->row_array();
    }

    public function simpanpengajuan($data)
    {
        extract($data);
        $this->db->query("insert into pengajuan(tglpengajuan,
                                                kduttppeserta,
                                                kdlayanan,
                                                fotokondisi,
                                                izinpersetujuantipe,
                                                adaskhplama,
                                                skhplama,
                                                noskhplama,
                                                tglskhplama,
                                                berlakuskhplama,
                                                lokasisebelumnya,
                                                suratpermohonan,
                                                status) 
                                        values('$tglpengajuan',
                                                '$kduttppeserta',
                                                '$kdlayanan',
                                                '$fotokondisi',
                                                '$izinpersetujuantipe',
                                                '$adaskhplama',
                                                '$skhplama',
                                                '$noskhplama',
                                                '$tglskhplama',
                                                '$berlakuskhplama',
                                                '$lokasisebelumnya',
                                                '$suratpermohonan',
                                                '0')");
    }

    public function ubahpengajuan($data)
    {
        extract($data);
        $this->db->query("update pengajuan set kduttppeserta='$kduttppeserta',
                                                kdlayanan='$kdlayanan',
                                                fotokondisi='$fotokondisi',
                                                izinpersetujuantipe='$izinpersetujuantipe',
                                                adaskhplama='$adaskhplama',
                                                skhplama='$skhplama',
                                                noskhplama='$noskhplama',
                                                tglskhplama='$tglskhplama',
                                                berlakuskhplama='$berlakuskhplama',
                                                lokasisebelumnya='$lokasisebelumnya',
                                                suratpermohonan='$suratpermohonan',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahbayar($kdpengajuan,$nobukti,$tglbayar,$buktibayar,$status)
    {
        $this->db->query("update pengajuan set nobukti='$nobukti',
                                                tglbayar='$tglbayar',
                                                buktibayar='$buktibayar',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function ubahjadwal($kdpengajuan, $jadwal, $kdpegawai, $status)
    {
        $this->db->query("update pengajuan set jadwal='$jadwal',
                                                kdpegawai='$kdpegawai',
                                                status='$status'
                                        where kdpengajuan='$kdpengajuan'");
    }

    public function hapuspengajuan($kode)
    {
        $this->db->query("delete from pengajuan where kdpengajuan='$kode'");
    }

    public function hapusdoktambahan($kode)
    {
        $this->db->query("delete from doktambahpengajuan where kdpengajuan='$kode'");
    }

    public function berkaspengajuan($kode)
    {
        return $this->db->query("select kduttppeserta,fotokondisi,izinpersetujuantipe,skhplama,suratpermohonan,status from pengajuan where kdpengajuan='$kode'")->row_array();
    }

    public function berkaspengajuantambahan($kode)
    {
        return $this->db->query("select berkas from doktambahpengajuan where kdpengajuan='$kode'");
    }

    public function resetberkastambahan($kdpengajuan)
    {
        $this->db->query("delete from doktambahpengajuan where kdpengajuan='$kdpengajuan'");
    }
    
    public function simpanberkastambahan($data)
    {
        extract($data);
        $this->db->query("insert into doktambahpengajuan(kdpengajuan,
                                                berkas) 
                                        values('$kdpengajuan',
                                                '$berkas')");
    }

    public function cekpenyedia($kode)
    {
        return $this->db->query("select npwp,nama from peserta where kdpeserta='$kode'")->row_array();
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

    public function cekpeserta($kode)
    {
        return $this->db->query("select kelompok,npwp,nama from peserta where kdpeserta='$kode'")->row_array();
    }

    public function penera()
    {
        return $this->db->query("select kdpegawai,nip,nama from pegawai where level='3' order by nama ASC");
    }

    public function cekberkastambahan($kduttp)
    {
        return $this->db->query("select kddoktambahan from doktambahan where kduttp='$kduttp'")->num_rows();
    }

    public function berkastambahan($kduttp)
    {
        return $this->db->query("select nama,berkas from doktambahan where kduttp='$kduttp' order by nama ASC");
    }

    public function berkastambahanpengajuan($kdpengajuan,$nama)
    {
        return $this->db->query("select berkas from doktambahpengajuan where kdpengajuan='$kdpengajuan' and berkas like '$nama%' order by berkas ASC")->row_array();
    }

    public function cekpenera($qjadwal)
    {
        return $this->db->query("select * from pilihanjadwal where $qjadwal")->row_array();
    }

    public function cekpeneratetapan($kode)
    {
        return $this->db->query("select nip,nama from pegawai where kdpegawai='$kode'")->row_array();
    }

    public function cekpengajuan2($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode'")->row_array();
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

    public function adapengajuan($kode)
    {
        return $this->db->query("select a.kdpengajuan
                                        from pengajuan a 
                                            inner join uttppeserta b
                                                on a.kduttppeserta=b.kduttppeserta
                                        where b.kdpeserta='$kode'")->num_rows();
    }

    public function adapengajuan2($kode)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kode' and status<>'5'")->num_rows();
    }

    public function uttppeserta($kode)
    {
        return $this->db->query("select kduttp from uttppeserta where kdpeserta='$kode'")->num_rows();
    }

    public function berkassemuauttp($kode)
    {
        return $this->db->query("select foto from uttppeserta where kdpeserta='$kode'");
    }

    public function hapussemuauttp($kode)
    {
        $this->db->query("delete from uttppeserta where kdpeserta='$kode'");
    }

    public function hapuspeserta($kode)
    {
        $this->db->query("delete from peserta where kdpeserta='$kode'");
    }

    public function ceknpwp($npwp)
    {
        return $this->db->query("select * from peserta where npwp='$npwp'")->row_array();
    }

    public function cekpelanggan($npwp)
    {
        return $this->db->query("select a.pelanggan 
                                    from pelanggan a
                                        inner join peserta b
                                            on a.pelanggan=b.kdpeserta
                                    where b.npwp='$npwp'")->num_rows();
    }

    public function ambilpilihanjadwal($kode)
    {
        return $this->db->query("select * from pilihanjadwal where kdpengajuan='$kode'")->row_array();
    }

    public function ubahpemilik($kode)
    {
        $this->db->query("update uttppeserta set status='0' where kduttppeserta='$kode'");
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

    public function totalexpired3($kode,$tgl)
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

    public function ambilinfotambahan($kode,$info)
    {
        return $this->db->query("select * from infotambahanpeserta where kduttppeserta='$kode' and info='$info'")->row_array();
    }

    public function adapengajuanberjalan($kduttppeserta)
    {
        return $this->db->query("select kdpengajuan from pengajuan where kduttppeserta='$kduttppeserta' and status<'5' ")->num_rows();
    }

    public function isiinfotambahan($kode)
    {
        return $this->db->query("select * from infotambahan where kduttp='$kode' order by info ASC");
    }
    
    public function cekskhplama($kduttppeserta,$noskhp)
    {
        return $this->db->query("select nosuratskhp,tglsuratskhp,berlakuskhp from pengajuan where kduttppeserta='$kduttppeserta' and nosuratskhp='$noskhp'")->row_array();
    }
}