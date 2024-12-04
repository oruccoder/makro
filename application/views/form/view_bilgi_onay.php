
<style>
    @media (min-width: 992px)
    {
        .modal-lg {
            max-width: 90% !important;
        }
    }

</style>
<div id="notifys" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="messages"></div>
</div
<div class="card">
    <h4 style="text-align: center;"><?php echo $product_name; ?></h4>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Ürün</th>
                <th>Detay</th>
                <th>Marka</th>
                <th>İstehsalçı Ülke</th>
                <th>Miktar</th>
                <th>Birim</th>
                <th>Firmanın Verdiği Fiyat</th>
                <th>EDV Durumu</th>
                <th>EDV'siz Fiyat </th>
                <th>EDV'li Fiyat </th>
                <th>EDV'siz Toplam Fiyat</th>
                <th>EDV'li Toplam Fiyat</th>
                <th>Not</th>
                <th>Onay/İptal</th>
            </tr>
            <?php $i=0; foreach ($data as $datas) {
                $p=$datas['product_name'];
                $p=str_replace("'","\'",$datas['product_name']);
                $kdv_durumu='EDV Hariç';
                $edv_tutari=(round($datas['price']*0.18,2));
                $toplam_edv_tutari=round($datas['subtotal']*0.18,2);

                $edvsiz_fiyat=0;
                $edvli_fiyat=0;
                $edvli_toplam_fiyat=0;
                $edvsiz_toplam_fiyat=0;
                if($datas['kdv_dahil_haric']==1)
                {
                    $kdv_durumu='EDV Dahil';

                    $edvsiz_fiyat=$datas['price']/1.18;
                    $edvli_fiyat=$datas['price'];
                    $edvsiz_toplam_fiyat=$datas['subtotal']/1.18;
                    $edvli_toplam_fiyat=$datas['subtotal'];
                }
                else
                {
                    $kdv_durumu='EDV Hariç';
                    $edvsiz_fiyat=(round($datas['price'],2));
                    $edvsiz_toplam_fiyat=$datas['subtotal'];
                    $edvli_fiyat=$datas['price']*1.18;
                    $edvli_toplam_fiyat=$datas['subtotal']*1.18;



                }

                $onay_durum=onay_durumlari_ogren_product_user(2,$satin_alma_id,$string,$p,$datas['id']);

                if($datas['ref_urun']==0)
                {

                    if($onay_durum==3)
                    {
                        echo "<tr style='background-color: gray;color: white'>";
                    }
                    else
                    {
                        echo "<tr>";
                    }
                    ?>

                    <td><?php echo $datas['product_name']?></br><?php echo product_detail($datas['product_id'])['cat_name'] ?></td>
                    <td><?php echo $datas['product_detail']?></td>
                    <td><?php echo $datas['marka']?></td>
                    <td><?php echo $datas['ulke']?></td>
                    <td><input name="qty"  class="form-control" value="<?php echo $datas['qty']?>"></td>
                    <td><?php echo $datas['unit']?></td>
                    <td><?php echo amountFormat($datas['price'],$invoice_details->para_birimi)?></td>
                    <td><?php echo $kdv_durumu?></td>
                    <td><?php echo amountFormat($edvsiz_fiyat,$invoice_details->para_birimi)?></td>
                    <td><?php echo amountFormat($edvli_fiyat,$invoice_details->para_birimi)?></td>
                    <td><?php echo amountFormat($edvsiz_toplam_fiyat,$invoice_details->para_birimi)?></td>
                    <td><?php echo amountFormat($edvli_toplam_fiyat,$invoice_details->para_birimi)?></td>
                    <td><input type="text" class="form-control notes" name="notes[]"></td>
                    <td><button  class="btn btn-success btn-xs onayla_" item_id="<?php echo $datas['id']; ?>" status="3" >✓</button>
                        <button  class="btn btn-success btn-xs iptal" style="background-color: #ff7588 !important;border-color: #ff7588 !important;" item_id="<?php echo $datas['id']; ?>" status="1" >x</button></td>
                    </tr>
                    <?php
                } else
                {
                    $i++;
                    if($i==1)
                    {
                        ?>

                        <?php
                    }
                    ?>

                    <?php

                }
                ?>


            <?php } ?>
        </table>

        <?php if(referans_urunleri($satin_alma_id,$product_name))
        {
        ?>

        <table class="table">
            <tr>
                <td colspan="8" style="text-align: center;font-size: 21px;font-weight: 800;background-color: #33333380 !important;color: white;">Firmanın Ekstra Teklif Verdiği Ürünler</td>
            </tr>
            <tr>
                <th>Ürün</th>
                <th>Marka</th>
                <th>İstehsalçı Ülke</th>
                <th>Miktar</th>
                <th>Birim</th>
                <th>Fiyat</th>
                <th>Toplam Fiyat</th>
                <th>Not</th>
                <th>Onay/İptal</th>
            </tr>

            <?php foreach (referans_urunleri($satin_alma_id,$product_name) as $datas_)
            {
                $p=str_replace("'","\'",$datas_['product_name']);;

                $onay_durums=onay_durumlari_ogren_product_user_ref($string,$datas_['id']);



                if($onay_durums==3)
                {
                    echo "<tr style='background-color: gray;color: white'>";
                }
                else
                {
                    echo "<tr>";
                }
                ?>


                <td><?php echo $datas_['product_name']?></td>
                <td><?php echo $datas_['marka']?></td>
                <td><?php echo $datas_['ulke']?></td>
                <td><input name="qty"  class="form-control" value="<?php echo $datas_['qty']?>"></td>
                <td><?php echo $datas_['unit']?></td>
                <td><?php echo amountFormat($datas_['price'],$invoice_details->para_birimi)?></td>
                <td><?php echo amountFormat($datas_['subtotal'],$invoice_details->para_birimi)?></td>
                <td><input type="text" class="form-control notes" name="notes[]"></td>
                <td><button  class="btn btn-success btn-xs onayla_" item_id="<?php echo $datas_['id']; ?>" status="3" >✓</button>
                    <button  class="btn btn-success btn-xs iptal" style="background-color: #ff7588 !important;border-color: #ff7588 !important;" item_id="<?php echo $datas_['id']; ?>" status="1" >x</button></td>
                </tr>
            <?php } ?>
            <?php
            } ?>
        </table>
        <table class="table">
            <tr>
                <th>Açıklama</th>
                <th>Seçenek</th>
                <th></th>
            </tr>
            <tr>
                <td><input name="secenek_note"  id='secenek_note' class="form-control secenek_note" value=""></td>
                <td><select name="secenek" id="secenek" class="form-control secenek">
                        <option value="Satınalma Yapılmasın">Satınalma Yapılmasın</option>
                        <option value="Farklı Firmadan">Farklı Firmadan</option>
                        <option value="Beklet">Beklet</option>
                        <option value="Yurtdışı Fiyat Araştırılsın">Yurtdışı Fiyat Araştırılsın</option>
                    </select>
                    <input type="hidden" value="<?php echo $product_name; ?>" id="product_name">
                </td>
                <td><button class="btn btn-success btn-xs kayit_ekle" >Kayıt Et</button></td>
            </tr>
        </table>

    </div>
</div>

<script>

</script>
