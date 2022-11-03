<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?extract($infoapp);?>
    <title><?= $namakantor." | ".$halaman;?></title>

    <link href="<?= $file_logo;?>" rel="shortcut icon" type="image/x-icon" />

    <style>
        body{
            font-family: tahoma;
        }

        .body-label{
            width: 350px;
            border: 2px solid #000;
            border-collapse: collapse;
        }

        .content-label {
            width: 100%;
            border-collapse: collapse;
        }

        .content-label td {
            border-bottom: 1px solid #000;
        }

        .judul-label{
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 0 10px 0;
            background-color: silver;
        }

        .info-label{
            width: 25%;
            font-size: 1rem;
            font-weight: bold;
            padding: 5px 0 5px 5px;
        }

        .isi-label{
            width: 75%;
            padding: 5px 0 5px 0;
        }
    </style>
</head>
<body onload="window.print()">
    <table class="body-label">
        <tr>
            <td class="judul-label">DATA UTTP</td>
        </tr>
        <tr>
            <td>
                <table class="content-label">
                    <tr>
                        <td class="info-label">Pemilik</td>
                        <td class="isi-label">: <?= $namapeserta;?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Tgl. Terima</td>
                        <td class="isi-label">: <?= $tglterima;?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Penerima</td>
                        <td class="isi-label">: <?= $penerima;?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Penera</td>
                        <td class="isi-label">: <?= $namapenera;?></td>
                    </tr>
                    <tr>
                        <td class="info-label">Keterangan</td>
                        <td class="isi-label">: <?= $keterangan;?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>