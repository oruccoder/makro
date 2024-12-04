
<style>
    @media (min-width: 992px)
    {
        .modal-lg {
            max-width: 100% !important;
        }
    }

</style>
<div id="notifys" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="messages"></div>
</div
<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Ürün</th>
                <th>Detay</th>
                <th>Firma</th>
                <th>Marka</th>
                <th>İstehsalçı Ülke</th>
                <th>Miktar</th>
                <th>Birim</th>
                <th>Firmanın Fiyatı</th>
                <th>EDV Durumu</th>
                <th>EDV'siz Fiyat </th>
                <th>EDV'li Fiyat </th>
                <th>EDV'siz Toplam Fiyat</th>
                <th>EDV'li Toplam Fiyat</th>
                <th>Not</th>
                <th>Onay/İptal</th>
            </tr>
            <?php $i=0; foreach ($urunler as $datas) {
                $p=$datas['product_name'];

                $product=str_replace("'","\'",$p);

                $onay_durum=onay_durumlari_ogren_product_user(2,$satin_alma_id,$string,$product,$datas['id']);


                if($datas['ref_urun']==0)
                {


                    ?>

                    <tbody>
                    <tr class="rowid">
                        <?php $teklifler = satinalma_urun_to_firma($satin_alma_id,$product) ?>
                        <td rowspan="<?php  $sayi = floatval(count($teklifler))+1; echo $sayi; ?>" style="text-align: center;vertical-align: inherit;"><b><?php echo $datas['product_name']?></b></br><?php echo product_detail($datas['product_id'])['cat_name'] ?></td>

                        <?php foreach (satinalma_urun_to_firma($satin_alma_id,$product) as $datass) {

                        $kdv_durumu='EDV Hariç';

                        $edv_tutari=(round($datass['price']*0.18,2));
                        $toplam_edv_tutari=round($datass['subtotal']*0.18,2);


                        $edvsiz_fiyat=0;
                        $edvli_fiyat=0;
                        $edvli_toplam_fiyat=0;
                        $edvsiz_toplam_fiyat=0;
                        if($datass['kdv_dahil_haric']==1)
                        {

                            $kdv_durumu='EDV Dahil';
                            $edvsiz_fiyat=$datass['price']/1.18;
                            $edvli_fiyat=$datass['price'];
                            $edvsiz_toplam_fiyat=$datass['subtotal']/1.18;
                            $edvli_toplam_fiyat=$datass['subtotal'];

                        }
                        else
                        {
                            $kdv_durumu='EDV Hariç';
                            $edvsiz_fiyat=(round($datass['price'],2));
                            $edvsiz_toplam_fiyat=$datass['subtotal'];
                            $edvli_fiyat=$datass['price']*1.18;
                            $edvli_toplam_fiyat=$datass['subtotal']*1.18;



                        }


                        $onay_durum=onay_durumlari_ogren_product_user_firma(2,$satin_alma_id,$string,$product,$datas['id'],$datass['id']);


                        if($onay_durum==3)
                        {
                            echo "<tr style='background-color: gray;color: white'>";
                        }
                        else
                        {
                            echo "<tr>";
                        }

                        ?>
                        <td><?php echo $datass['product_detail']?></td>
                        <td><?php echo $datass['firma']?></td>
                        <td><?php echo $datass['marka']?></td>
                        <td><?php echo $datass['ulke']?></td>
                        <td><?php echo $datass['qty']?></td>
                        <td><?php echo $datass['unit']?></td>
                        <td><?php echo amountFormat($datass['price'],$invoice_details->para_birimi)?></td>
                        <td><?php echo $kdv_durumu?></td>
                        <td><?php echo amountFormat($edvsiz_fiyat,$invoice_details->para_birimi)?></td>
                        <td><?php echo amountFormat($edvli_fiyat,$invoice_details->para_birimi)?></td>
                        <td><?php echo amountFormat($edvsiz_toplam_fiyat,$invoice_details->para_birimi)?></td>
                        <td><?php echo amountFormat($edvli_toplam_fiyat,$invoice_details->para_birimi)?></td>
                        <td><input type="text" class="form-control notes" name="notes[]"></td>
                        <td><button  class="btn btn-success btn-xs onayla_" item_id="<?php echo $datass['id']; ?>" status="3" >✓</button>
                            <button  class="btn btn-success btn-xs iptal" style="background-color: #ff7588 !important;border-color: #ff7588 !important;" item_id="<?php echo $datass['id']; ?>" status="1" >x</button></td>
                    </tr>

                    <?php } ?>
                    </tr>
                    </tbody>
                    <?php

                }
                ?>


            <?php } ?>
        </table>


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
                </td>
                <td><button class="btn btn-success btn-xs kayit_ekle" >Kayıt Et</button></td>
            </tr>
        </table>

    </div>
</div>

<script>

</script>
