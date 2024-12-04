<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 30.01.2020
 * Time: 17:59
 */
?>


<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>İzin Kağıdı Yazdır #</title>

    <style>






    </style>

</head>
<body style="font-family: Helvetica;">
<div style="text-align: center">
    <img src="<?php  $loc=location($details->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>" style="max-height:130px;max-width:100px;">
    <h5>İcazə Vərəqəsi</h5>
</div>
<div style="font-size: 11px">
    <p>Adi Soyadi: <b><?php echo $details->emp_fullname; ?></b></p>
    <p>Vəzifəsi: <b><?php echo roles($detailsa->roleid); ?></b></p>
    <p>Telefonu: <b><?php echo $detailsa->phone; ?></b></p>
</div>
<div style="text-align: justify;font-size: 11px">
    <p>Yukarıda açık kimlik bilgileri yazılı olan <b><?php echo $details->emp_fullname; ?></b>, işyerimizde <b><?php
            echo dateformat(personel_detailsa($details->emp_id)['date_created']); ?></b> tarihinden bu yana çalışmaktadır <b><?php echo dateformat($details->bas_date).' '.$details->bas_saati; ?></b> / <b><?php echo dateformat($details->bitis_date).' '.$details->bit_saati; ?></b>
        tarihleri arasında,  '<b><?php echo $details->izin_sebebi; ?></b>' sebebi ile <b><?php echo $details->izin_tipi; ?></b> izin kullanacaktır.
    </p>
</div>

<div style="text-align: justify;font-size: 11px">
    <p>İş bu belge ilgili kişinin talebi üzerine verilmiştir.</p>
    <p>Gereğini bilgilerinize arz ederim</p><br/>

</div>

<table style="width: 100%;text-align: center;font-size: 10px">
    <tr>
        <td>Ofis Meneceri</td>
        <td>Şöbə Müdiri</td>
        <td>HR</td>
        <td>Direktör</td>
    </tr>
    <tr>

        <td class="text-xs-left"><b><?php echo personel_details($details->bolum_sorumlusu)?></b></td>
        <td class="text-xs-left"><b><?php echo personel_details($details->bolum_pers_id)?></b></td>
        <td class="text-xs-left"><b><?php echo personel_details($details->finans_pers_id)?></b></td>
        <td class="text-xs-left"><b><?php echo personel_details($details->genel_mudur)?></b></td>

    </tr>
</table>









