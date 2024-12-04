<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 31.01.2020
 * Time: 13:35
 */
?>


<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>İşe Giriş Formu #</title>

    <style>

        @page { sheet-size: 210mm 130mm;
            margin-top: 5px;
            margin-left:  20px;
            margin-right:  20px;
        }




    </style>

</head>
<?php $loc=location($details['loc']); ?>
<body style="font-family: Helvetica;">
<div style="text-align: center">
    <img src="<?php    echo base_url('userfiles/company/' . $loc['logo']) ?>" style="max-width:100px;">
    <h5>İŞE GİRİŞ ONAY FORMU</h5>
</div>
<div style="font-size: 11px">
    <p>Personel Adı ve Soyadı: <b><?php echo $details['name']; ?></b></p>
    <p>Personel Fin Kodu: <b><?php echo personel_detailsa($details['id'])['fin_no']; ?></b></p>
    <p>İşe Başlangıç Tarihi: <b><?php echo dateformat($details['date_created']); ?></b></p>
</div>
<div style="text-align: justify;font-size: 10px">
    <p>Bu form İnsan Kaynakları Şubesi takibinde düzenlenir.Aşağıda belirtilen belgelerin teslim edildiği onaylanmıştır. </p>
    <p> İşe giriş sırasında, işlemlerin formda belirtilen takip sırayla yapılması uygundur.</p>
   <ul>
       <li>Sağlık Raporu</li>
       <li>Adli Sicil Belgesi</li>
       <li>Kimlik Fotokopisi</li>
   </ul>
</div>

<table style="width: 100%;text-align: center">
    <tr>
        <th style="width: 25%">Firma</th>
        <th style="width: 25%">Pozisyon</th>
        <th style="width: 25%">Sorumlu Personel</th>
        <th style="width: 25%">Muhasebe Onay</th>
    </tr>
    <tr>
        <td>
            <p><?php echo $loc['cname']; ?></p>
        </td>
        <td >
            <p><?php echo personel_depertman($details['dept'])['val1']; ?></p>
        </td>
        <td>
            <p><?php echo personel_details($details['sorumlu_pers_id']); ?></p>
        </td>
        <td>
            <p>Kaşe</p>
        </td>

    </tr>
</table>



