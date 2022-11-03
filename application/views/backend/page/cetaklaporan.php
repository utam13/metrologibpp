<?
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$namafile.xls");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul;?></title>

    <link rel="stylesheet" href="<?= base_url();?>assets/backend/css/excel.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/backend/css/color.css">
</head>
<body> 
    <?
    extract($infoapp);

    switch ($kelompok) {
        case 1:
    ?>
            <table>
                <tr>
                    <td class="header-top"><?= $namakantor;?></td>
                </tr>
                <tr>
                    <td class="header-middle"><?= $judul;?></td>
                </tr>
                <tr>
                    <td class="header-bottom"><?= $rentang;?></td>
                </tr>
                <tr>
                    <td>
                        <table class="record">
                            <thead class="bg-gray">
                                <tr>
                                    <th rowspan=2 nowrap class="text-center" style="width:5%;">No.</th>
                                    <th rowspan=2 nowrap class="text-center" style="width:10%;">Tgl. Daftar</th>
                                    <th rowspan=2 nowrap class="text-center" style="width:10%;">Jml UTTP</th>
                                    <th rowspan=2 nowrap class="text-center" style="width:10%;">Kelompok</th>
                                    <th rowspan=2 nowrap class="text-center" style="width:10%;">Jml Pelanggan</th>
                                    <th colspan=7 nowrap class="text-center">Informasi Usaha</th>
                                    <th colspan=6 nowrap class="text-center">Informasi PIC</th>
                                </tr>
                                <tr>
                                    <th nowrap class="text-center">NPWP</th>
                                    <th nowrap class="text-center">Nama Usaha</th>
                                    <th nowrap class="text-center">Alamat</th>
                                    <th nowrap class="text-center">Kelurahan</th>
                                    <th nowrap class="text-center">Kecamatan</th>
                                    <th nowrap class="text-center">Telp</th>
                                    <th nowrap class="text-center">Email</th>
                                    <th nowrap class="text-center">No. KTP</th>
                                    <th nowrap class="text-center">Nama</th>
                                    <th nowrap class="text-center">Jabatan</th>
                                    <th nowrap class="text-center">Telp</th>
                                    <th nowrap class="text-center">WhatsApp</th>
                                    <th nowrap class="text-center">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $hasil = json_decode($data);
                                foreach ($hasil as $d) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $d->no;?></td>
                                    <td nowrap class="text-center"><?= $d->tgldaftar;?></td>
                                    <td class="text-center"><?= $d->jmluttp;?></td>
                                    <td class="text-center"><?= $d->namakelompok;?></td>
                                    <td class="text-center"><?= $d->jmlpelanggan;?></td>
                                    <td nowrap><?= $d->npwp;?></td>
                                    <td nowrap><?= $d->nama;?></td>
                                    <td nowrap><?= $d->alamat;?></td>
                                    <td nowrap><?= $d->kelurahan;?></td>
                                    <td nowrap><?= $d->kecamatan;?></td>
                                    <td nowrap><?= $d->telp;?></td>
                                    <td nowrap><?= $d->email;?></td>
                                    <td nowrap><?= $d->nik;?></td>
                                    <td nowrap><?= $d->namapic;?></td>
                                    <td nowrap><?= $d->jabatan;?></td>
                                    <td nowrap><?= $d->telppic;?></td>
                                    <td nowrap><?= $d->wa;?></td>
                                    <td nowrap><?= $d->emailpic;?></td>
                                </tr>
                                <?}?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
    <?      break;?>
    <? case 2:?>
    <? case 3:?>
            <table>
                <tr>
                    <td class="header-top"><?= $namakantor;?></td>
                </tr>
                <tr>
                    <td class="header-middle"><?= $judul;?></td>
                </tr>
                <?if($kelompok != 3){?>
                <tr>
                    <td class="header-bottom"><?= $status;?></td>
                </tr>
                <tr>
                    <td class="header-bottom"><?= $rentang;?></td>
                </tr>
                <?}?>
                <tr>
                    <td>
                        <table class="record">
                            <thead class="bg-gray">
                                <tr>
                                    <th rowspan=3 nowrap class="text-center">No</th>
                                    <th rowspan=3 nowrap class="text-center">Status</th>
                                    <th rowspan=2 nowrap colspan=2 class="text-center">Serah Terima</th>
                                    <th rowspan=3 nowrap class="text-center">Tgl. Pengajuan</th>
                                    <th rowspan=2 nowrap colspan=2 class="text-center">Peserta</th>
                                    <th rowspan=3 nowrap class="text-center">Jenis UTTP</th>
                                    <th rowspan=3 nowrap class="text-center">Jenis Layanan</th>
                                    <th rowspan=2 nowrap colspan=4 class="text-center">SKHP Lama</th>
                                    <th rowspan=3 nowrap class="text-center">Lokasi Layanan</th>
                                    <th rowspan=3 nowrap class="text-center">Jadwal</th>
                                    <th rowspan=3 nowrap class="text-center">Penera</th>
                                    <th rowspan=2 nowrap colspan=2 class="text-center">Pembayaran Restribusi</th>
                                    <th rowspan=2 nowrap colspan=2 class="text-center">Hasil Uji</th>
                                    <th colspan=5 nowrap class="text-center">Dokumen</th>
                                </tr>
                                <tr>
                                    <th colspan=2 nowrap class="text-center">SKRD</th>
                                    <th colspan=3 nowrap class="text-center">SKHP</th>
                                </tr>
                                <tr>
                                    <th nowrap class="text-center">Alat</th>
                                    <th nowrap class="text-center">Dokumen<br>SKRD & SKHP</th>
                                    <th nowrap class="text-center">NPWP</th>
                                    <th nowrap class="text-center">Nama</th>
                                    <th nowrap class="text-center">No. SKHP</th>
                                    <th nowrap class="text-center">Tgl. SKHP</th>
                                    <th nowrap class="text-center">Berlaku Sampai</th>
                                    <th nowrap class="text-center">Lokasi</th>
                                    <th nowrap class="text-center">Nomor</th>
                                    <th nowrap class="text-center">Tanggal</th>
                                    <th nowrap class="text-center">Hasil</th>
                                    <th nowrap class="text-center">Cerapan/Keterangan</th>
                                    <th nowrap class="text-center">Nomor</th>
                                    <th nowrap class="text-center">Tanggal</th>
                                    <th nowrap class="text-center">Nomor</th>
                                    <th nowrap class="text-center">Tanggal</th>
                                    <th nowrap class="text-center">Berlaku sampai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $hasil = json_decode($data);
                                foreach ($hasil as $h) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $h->no;?></td>
                                    <td nowrap><?= $h->namastatus;?></td>
                                    <td class="text-center" nowrap><?= $h->serahterimaalat;?></td>
                                    <td class="text-center" nowrap><?= $h->serahterimadok;?></td>
                                    <td class="text-center" nowrap><?= $h->tglpengajuan;?></td>
                                    <td class="text-center" nowrap><?= $h->npwp;?></td>
                                    <td nowrap><?= $h->namapeserta;?></td>
                                    <td nowrap><?= $h->namauttp;?></td>
                                    <td class="text-center" nowrap><?= $h->nama;?></td>
                                    <td nowrap><?= $h->noskhplama;?></td>
                                    <td class="text-center" nowrap><?= $h->tglskhplama;?></td>
                                    <td class="text-center" nowrap><?= $h->berlakuskhplama;?></td>
                                    <td nowrap><?= $h->lokasisebelumnya;?></td>
                                    <td class="text-center" nowrap><?= $h->namalokasi;?></td>
                                    <td class="text-center" nowrap><?= $h->jadwal;?></td>
                                    <td nowrap><?= $h->namapenera;?></td>
                                    <td nowrap><?= $h->nobukti == "-" ? "-":"Lihat di aplikasi";?></td>
                                    <td class="text-center" nowrap><?= $h->tglbayar;?></td>
                                    <td nowrap class="text-bold"><?= $h->namahasil;?></td>
                                    <td nowrap><?= $h->infohasil;?></td>
                                    <td nowrap><?= $h->nosuratskrd;?></td>
                                    <td class="text-center" nowrap><?= $h->tglsuratskrd;?></td>
                                    <td nowrap><?= $h->nosuratskhp;?></td>
                                    <td class="text-center" nowrap><?= $h->tglsuratskhp;?></td>
                                    <td class="text-center" nowrap><?= $h->berlakuskhp;?></td>
                                </tr>
                                <?}?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
    <?      break;?>
    <?}?>
</body>
</html>