<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print BarCode</title>
    <style>  @page {
            margin: 0 auto;
            sheet-size: 96mm 76mm ;
        }




    </style>
</head>
<body>
<table cellpadding="1" style="width: 100%">

    <tr >
        <td style="border: 0px solid;font-size: 14px;text-align: center"><strong><?= $lab['product_name'] ?></strong><br>Ürün Kodu: <?= $lab['product_code'] ?>



            <br/>
            <br/>
            <barcode code="<?= $lab['barcode'] ?>" text="1" class="barcode" height=".6" size="0.9"  >
            </barcode>



            <?php
            if($lab['en']!=0){

            $toplam_agirlik=$lab['toplam_agirlik'];
            if($lab['en']!=0)
            {
                $toplam_m2= ($lab['en']*$lab['boy']/10000)*1;
                ?>  <h5> &nbsp;
                &nbsp; <?php echo ($lab['en']/100).'m x '.($lab['boy']/100).'m' ?></h5> <?php
            }

            ?>

            <p> &nbsp;
                &nbsp; <?php  if(toplam_agirlik($lab['pid'])!='0 KG'){ echo  'Toplam Ağırlık: '.toplam_agirlik($lab['pid']); }; ?>
            </p>
            <?php } ?>

            <br/>
            <p style="font-size: 10px"><?php echo $lab['product_des'] ?></p>
        </td>




    </tr>
    <tr>
        <td style="border: 0px solid;font-size: 10px;text-align: center">

            <img src="<?php echo base_url('userfiles/company/' . $loca['logo']) ?>" style="width: 20%;text-align: center;">

            <!--img src="<?php echo base_url('userfiles/company/makro_lab.PNG') ?>" style="width: 25%;text-align: center;"-->

            <strong style="text-align: center;font-size: 12px">Makro2000 Grup Şirketleri </strong>  <br>
            <strong style="text-align: center;font-size: 12px"><?php echo $loca['phone'];  ?>
            </strong>  <br>

            <p style="float: right;font-size: 9px"><?php echo $loca['address'];  ?>
            </p>
            <p style="float: right;font-size: 9px">www.makro2000.com.tr
            </p>

            <p style="float: left;font-size: 8px">info@makro2000.com.tr
            </p>



        </td>
    </tr>



</table>

</body>
</html>