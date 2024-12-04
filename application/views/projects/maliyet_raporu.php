<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Proje Maliyeti Yazdır</title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }
        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right:20pt;
        }

        .invoice-box table td {
            padding: 6pt 4pt 2pt 4pt;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding-bottom: 3px;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }
        .partys tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;

        }

        table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td{
            border: 1px solid #ddd;
        }

        table tr.b_class td{
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td{
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 400pt;
        }

        .myco2 {
            width: 300pt;
        }

        .myw {
            width: 240pt;
            font-size: 14pt;
            line-height: 14pt;

        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;

        }
        .party {
            border: #ccc 1px solid;
        }


    </style>
</head>

<body>

<div class="invoice-box">


    <br>
    <table  style="font-size: 12px" class="party">

        <tbody>
        <tr>
            <td><strong><?php $loc=location($this->aauth->get_user()->loc);
                    $ara_toplam=$banka_komisyon+$nakit_komisyon+$fehle['total']+$kiralama['total']+$demirbas['total']+$kurulum['total']+$fatura['total']+$iscilik['total']+$yol['total']+$tasoron['total']+$kiran['total']+$maas['total'];
                    $tax_toplam=$insaat_gideri['tax']+$fehle['tax']+$kiralama['tax']+$demirbas['tax']+$kurulum['tax']+$fatura['tax']+$iscilik['tax']+$yol['tax']+$tasoron['tax']+$kiran['tax']+$maas['tax'];
            ?></strong><br>
                <!--img src="<?php echo base_url('userfiles/company/' . $loc['logo']) ?>"-->
                <img style="width: 100%;"
                src="https://makro2000.com.tr/image/catalog/menu-logo/makro-group-menu-logo.png"
            </td>

            <td  style="text-align: center"><b>Makro 2000 Eğİtim Teknolojileri İnşaat Taahhüt  İç ve Dış Ticaret Anonim“ Şirketinin</b><br>
                <p style="text-align: center">
                    Azərbaycan Respublikasındakı Filialı<br>
                    VÖEN: 1800732691 Baku / Azerbaycan Tel: +994 12 597 48 18   Mail : info@makro2000.com.tr
                </p>
            </td>
            <td><strong><?php $loc=location($this->aauth->get_user()->loc);?></strong><br>
                <img  style="width: 100%;" src="https://makro2000.com.tr/image/catalog/menu-logo/makro-group-menu-logo.png"
            </td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border-right: 1px solid #ddd">Proje Adı</td>
            <td colspan="2"><?php echo $edit_data['name'];?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border-right: 1px solid #ddd">Sözleşme No</td>
            <td colspan="2"><?php echo $edit_data['sozlesme_numarasi'];?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border-right: 1px solid #ddd;">Adres</td>
            <td colspan="2"><?php echo $edit_data['project_adresi'];?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border-right: 1px solid #ddd;">Telefon</td>
            <td colspan="2"><?php echo $edit_data['project_yetkili_no'];?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border-right: 1px solid #ddd;">E-Mail</td>
            <td colspan="2"><?php echo $edit_data['email'];?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border-right: 1px solid #ddd;">Yetkili Kişi</td>
            <td colspan="2"><?php echo $edit_data['project_yetkili_adi'];?></td>
        </tr>


        </tbody>
    </table>
    <table style="font-size: 12px"  class="partys">
        <tr>
            <td></td>
            <td>Esas Para</td>
            <td>Ədv</td>
        </tr>
        <tr style="border: 1px solid #ddd;">
            <td style="border: 1px solid #ddd">Sözleşme Fiyatı</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($edit_data['sozlesme_tutari']);?></td>
            <td style="border: 1px solid #ddd"></td>
        </tr>
        <tr style="border: 1px solid #ddd">
            <td style="border: 1px solid #ddd">İlave</td>
            <td style="border: 1px solid #ddd"></td>
            <td style="border: 1px solid #ddd"></td>
        </tr>
        <tr style="border: 1px solid #ddd">
            <td style="border: 1px solid #ddd">İlave</td>
            <td style="border: 1px solid #ddd"></td>
            <td style="border: 1px solid #ddd"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: yellow;color: black">
            <td style="border: 1px solid #ddd">İnşaat Malzemesi</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($insaat_gideri['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($insaat_gideri['tax']);?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: #6496ed;color: white">
            <td style="border: 1px solid #ddd">Maaş</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($maas['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($maas['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Kıran</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($kiran['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($kiran['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Taşöron</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($tasoron['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($tasoron['tax']);?></td>

        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Yol</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($yol['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($yol['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">İşçilik</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($iscilik['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($iscilik['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Fatura</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($fatura['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($fatura['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Kurulum</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($kurulum['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($kurulum['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Demirbaş</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($demirbas['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($demirbas['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Kiralama</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($kiralama['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($kiralama['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Fəhlə</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($fehle['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($fehle['tax']);?></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Nagd Komisyonlar</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($nakit_komisyon);?></td>
            <td style="border: 1px solid #ddd"></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: cornflowerblue;color: white">
            <td style="border: 1px solid #ddd">Köçürme Komisyonlar</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($banka_komisyon);?></td>
            <td style="border: 1px solid #ddd"></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: yellow;color: black">
            <td style="border: 1px solid #ddd">Ara Toplam Giderler</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($ara_toplam);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($tax_toplam);?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: yellow;color: black">
            <td style="border: 1px solid #ddd">Özel Giderler</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($ozel_giderler['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($ozel_giderler['tax']);?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: yellow;color: black">
            <td style="border: 1px solid #ddd">Ortak Giderler</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($ortak_giderler['total']);?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($ortak_giderler['tax']);?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr style="border: 1px solid #ddd;background-color: red;color: white">
            <td style="border: 1px solid #ddd">Toplam Maliyet</td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($ara_toplam+$ortak_giderler['total']+$ozel_giderler['total']+$insaat_gideri['total'])?></td>
            <td style="border: 1px solid #ddd"><?php echo amountFormat($tax_toplam)?></td>
        </tr>
    </table>



</div>

</body>
</html>