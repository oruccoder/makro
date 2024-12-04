
<div class="row">
                    <div class="col col-xs-12 col-sm-12 col-md-12">
                        <h3>Qiymətləndirmə Forması</h3>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Sorğu nömrəsi</th>
                                <th>Layihə</th>
                                <th>Ən Aşağı Qiymətlərə görə cəmi</th>
                                <th>Orta qiymətlərə görə cəmi</th>
                                <th>İstinad qiymətləri üzrə cəmi</th>
                                <th>Seçtiyiniz Cemi (ƏLAVƏ HARİC)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $details->code;?></td>
                                <td><?php echo proje_code($details->proje_id);?></td>
                                <td><?php echo amountFormat(0);?></td>
                                <td><?php echo amountFormat(0);?></td>
                                <td><?php echo amountFormat(0);?></td>
                                <td><span id="secilen_tutar"><b><?php echo amountFormat(0)?></b></span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col col-xs-12 col-sm-12 col-md-12" style="display: block;overflow-y: auto;height: 943px;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Tələb Tərifi</th>
                                <th>Son Alınan Qiymet (EDVSIZ)</th>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $comp = $items['company'];
                                    $arr2 = str_split($comp, 30);

                                    echo "<th>$arr2[0]...</th>";
                                }
                                ?>
<!--                                <th>Depo Stok</th>-->
                                <th>Form Orta</th>
                                <th>En Düşük Qiymət</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php

                            $min_price=0;
                            $index=0;
                            $i=0;
                            foreach ($data_products as $j => $product_items){
                                $name = $product_items->product_name;
                                $varyasyon = talep_form_product_options_teklif_html($product_items->id);
                                $varyasyon_value = talep_form_product_options_teklif_values($product_items->id);
                                $unit_name = $product_items->unit_name;
                                if($product_items->product_type==2){
                                    $name = '<b>Cari Teklifi :</b> '.cari_product_details($product_items->product_id)->product_name;
                                    $unit_name = units_(cari_product_details($product_items->product_id)->unit_id)['name'];
                                }
                                $image=product_full_details_parent($product_items->product_stock_code_id,$product_items->product_id)['image']
                                ?>
                                <tr>
                                    <td>
                                        <div class="col-md-8">
                                            <?php echo $name.'<br>'.$varyasyon;?>

                                            <table>
                                                <tr>
                                                    <td><p class="info-text-bold">Talep Edilen  Miktar: <?php echo floatval($product_items->product_qty).' '.$unit_name?></p></td>
                                                </tr>

                                            </table>
                                            <?php if($details->talep_type!=3){ ?>
                                                <span class="avatar-lg align-baseline"><img style="    width: 20% !important;" class="image_talep_product" src="<?php echo base_url().'/'.$image ?>"></span>
                                            <?php }?>
                                        </div>


                                    </td>
                                    <?php

                                    //$son_alinan_fiyat = amountFormat(piyasa_fiyati($product_items->product_id,$varyasyon_value));
                                    $son_alinan_fiyat = amountFormat(piyasa_fiyati_new($product_items->product_id,$product_items->id));
                                    echo "<td>$son_alinan_fiyat</td>";

                                    $totals = 0;
                                    $_isnid_price=[];

                                    $ort_count=count(muqayese_details($details->id)); //bölünecek sayı
                                    $ort_count_say=0;
                                    foreach (muqayese_details($details->id)['cari'] as $key => $items){


                                        $cari_id = $items['id'];
                                        $products = cari_details_items($details->id,$cari_id,$product_items->id);
                                        $frm_ort=0;

                                        if($products){
                                            $talep_form_teklifler_item_details_id = $products['details']->id;
                                            $price=amountFormat($products['details']->price,$products['para_birimi']);

                                            $kur = geopos_currencies_details($products['para_birimi'])->rate;

                                            $totals+=floatval($products['details']->price)*$kur;

                                            $_isnid_price[]=[floatval($products['details']->price)*$kur];
                                        }


                                        $price_d=amountFormat(0);
                                        if($products){
                                            $price=amountFormat($products['details']->price,$products['para_birimi']);

                                            $miktar=floatval($products['details']->qty);
                                            $desc=$products['details']->item_desc;
                                            $kur = geopos_currencies_details($products['para_birimi'])->rate;
                                            $azn_tutar=amountFormat((floatval($products['details']->price)*$kur),1);
                                            $azn_tutar_float=(floatval($products['details']->price)*$kur);
                                            $azn_tutar_float_total = $azn_tutar_float*$miktar;
                                            $azn_tutar_float_total = amountFormat($azn_tutar_float_total);

                                            $teklif_onay_kontrol = teklif_onay_kontrol($talep_form_teklifler_item_details_id);
                                            $class='';
                                            $fa_class='fa-2x';
                                            $html='';
                                            if($teklif_onay_kontrol){
//                                                $class='select-border';
//                                                $fa_class='fa fa-check fa-2x';
                                                foreach ($teklif_onay_kontrol as $items){
                                                    $onaylayan_user = personel_details($items->user_id);
                                                    $html.="<p style='background: chocolate;color: white;padding: 3px;' class='info-text'>$onaylayan_user Onay Vermiştir</p>";
                                                }
                                            }

                                            if($products['details']->price > 0 ){
                                                $ort_count_say++;
                                               echo "<td class='vert-align-mid cursortopointer clickable $class' cari_id='$cari_id' type_cd='1' radio_id='$index' product_id='$product_items->product_id' talep_form_teklifler_item_details_id ='$talep_form_teklifler_item_details_id' miktar='$miktar' azn_tutar_float='$azn_tutar_float' index='$index' data-click='$index'>$azn_tutar_float_total
                                                <div class='pull-left fa_update crload_$index' style='margin-top: 14px;color: #57889c;font-size: 36px;'><i class='$fa_class'></i></div>
                                                $html
                                                <p class='info-text'>$azn_tutar / $product_items->unit_name <i class='fa fa-info-circle'></i></p>
                                                <p class='info-text'>Sipariş Miktarı : $miktar $product_items->unit_name</p>
                                                <p class='info-text'>Açıklama : $desc</p>
                                                   </td>";
                                            }
                                            else {
                                                echo "<td>Teklif Verilmemiş</td>";
                                            }

                                        }
                                        else {
                                            echo "<td>$price_d</td>";
                                        }



                                        $index++;

                                    }
//
//                                    echo "<td>";
//                                    if($product_items->product_type==1){
//
//                                        if(stock_qty($product_items->product_id)){
//
//                                        echo '  <div class="btn-group" role="group'.$j.'">';
//                                        foreach (stock_qty($product_items->product_id) as $keys=> $warehouses){
//
//
//                                            if($warehouses['qty']){
//                                                $name = $warehouses['warehouse_name'];
//                                                $warehouse_id = $warehouses['warehouse_id'];
//                                                $qty = $warehouses['qty'];
//                                                $unit_name = $warehouses['unit_name'];
//                                                $html='';
//                                                $checked='';
//                                                if(teklif_onay_kontrol_warehouse($warehouse_id,$product_items->product_id,$details->id)){
//                                                    foreach (teklif_onay_kontrol_warehouse($warehouse_id,$product_items->product_id,$details->id) as $items){
//                                                        $onaylayan_user = personel_details($items->user_id);
//                                                        $html.="<div style='padding: 12px;'><p style='background: chocolate;color: white;padding: 5px;;' class='info-text'>$onaylayan_user Onay Vermiştir</p></div>";
//                                                        $checked='checked';
//                                                    }
//                                                }
//
//                                                ?>
<!---->
<!--                                                <input --><?php //echo $checked?><!-- type="radio" class="btn-check" type_cd="0" miktar="--><?php //echo $product_items->product_qty ?><!--" depo_id="--><?php //echo $warehouse_id ?><!--" eq="--><?php //echo $j?><!--"-->
<!--                                                                             product_id='--><?php //echo $product_items->product_id?><!--'  name="group--><?php //echo $j?><!--" id="btnradio--><?php //echo $i?><!--" autocomplete="off" >-->
<!--                                                <label class="btn btn-outline-primary radio_label" for="btnradio--><?php //echo $i?><!--">--><?php //echo $name.' '.$qty.' '.$unit_name ?><!--</label>-->
<!--                                                --><?php //echo $html ?>
<!---->
<!--                                                --><?php
//                                                $i++;
//                                            }
//
//                                        }
//
//                                        echo '  </div>';
//
//                                    }
//                                    }
//                                    echo "</td>";
//
//                                    echo "<td class='vert-align-mid cursortopointer clfickable' talep_form_teklifler_item_details_id ='0' miktar='10' azn_tutar_float='0' index='$j' data-click=''>$index Adet MErkez Depo
//                                                <div class='pull-left crload_$index' style='margin-top: 14px;color: #57889c;font-size: 36px;'><i class='$fa_class'></i></div>
//                                                $html
//                                                   </td>";
                                    $totalsprice=@amountFormat(floatval($totals)/floatval($ort_count_say));
                                    if($_isnid_price){
                                        $min_price = sort($_isnid_price);
                                        $min_price = amountFormat($_isnid_price[0][0]);
                                    }
                                    else {
                                        $min_price = amountFormat(0);
                                    }


                                    echo "<td>$totalsprice</td>";
                                    echo "<td>$min_price</td>";

                                    ?>

                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">Ön Ödeme Tutarı</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){


                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $avans_price=0;
                                    $kur=0;
                                    if($teklif_cari_details){
                                        $avans_price = $teklif_cari_details->avans_price;
                                        $para_birimi = $teklif_cari_details->para_birimi;
                                        $kur = geopos_currencies_details($para_birimi)->rate;

                                    }

                                    $avans_price_t=floatval($avans_price)*$kur;
                                    $avans_price_t = amountFormat($avans_price_t);

                                    echo "<td><b>$avans_price_t</b></td>";

                                }
                                ?>

                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">Ödəniş növü	</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $method='';
                                    if($teklif_cari_details){
                                        $method = account_type_sorgu($teklif_cari_details->method);
                                    }

                                    echo "<td>$method</td>";

                                }
                                ?>

                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">Çatdırılma qeydləri</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $teslimat_durumu='';
                                    if($teklif_cari_details){
                                        $teslimat = $teklif_cari_details->teslimat;
                                        $avans_price = $teklif_cari_details->avans_price;
                                        $teslimat_durumu = ($teslimat)?'Dahil':'Hariç';
                                        $edv = $teklif_cari_details->edv_durum;
                                        $alt_discount_total_val = $teklif_cari_details->alt_discount_total_val;
                                        $para_birimi = $teklif_cari_details->para_birimi;
                                    }


                                    echo "<td>$teslimat_durumu</td>";

                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">EDV qeydləri</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $edv_durum='';
                                    if($teklif_cari_details){
                                        $edv = $teklif_cari_details->edv_durum;
                                        $edv_durum = ($edv)?'Dahil':'Hariç';
                                        $alt_discount_total_val = $teklif_cari_details->alt_discount_total_val;
                                        $para_birimi = $teklif_cari_details->para_birimi;
                                    }


                                    echo "<td>$edv_durum</td>";

                                }
                                ?>
                            </tr>

                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">Əlavə Ödəniş (Çatdırılma)</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $teslimat_tutar_price=0;
                                    if($teklif_cari_details){
                                        $teslimat_tutar = $teklif_cari_details->teslimat_tutar;

                                        $para_birimi = $teklif_cari_details->para_birimi;

                                        $kur = geopos_currencies_details($para_birimi)->rate;
                                        $teslimat_tutar=floatval($teslimat_tutar)*$kur;
                                        $teslimat_tutar_price = amountFormat($teslimat_tutar);
                                    }


                                    echo "<td>$teslimat_tutar_price</td>";

                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">Güzəşt</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $discount_price=0;
                                    if($teklif_cari_details){
                                        $alt_discount_total_val = $teklif_cari_details->alt_discount_total_val;
                                        $para_birimi = $teklif_cari_details->para_birimi;

                                        $kur = geopos_currencies_details($para_birimi)->rate;
                                        $discount=floatval($alt_discount_total_val)*$kur;
                                        $discount_price =  amountFormat($discount);
                                    }

                                    echo "<td>$discount_price</td>";

                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">Vergi Pulsuz Qiymət Cəmi</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $alt_sub_total_val_price=0;
                                    if($teklif_cari_details){
                                        $alt_sub_total_val = $teklif_cari_details->alt_sub_total_val;
                                        $para_birimi = $teklif_cari_details->para_birimi;

                                        $kur = geopos_currencies_details($para_birimi)->rate;
                                        $alt_sub_total_val=floatval($alt_sub_total_val)*$kur;
                                        $alt_sub_total_val_price =  amountFormat($alt_sub_total_val);
                                    }

                                    echo "<td>$alt_sub_total_val_price</td>";

                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">ƏDV</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $alt_edv_total_val_price=0;
                                    if($teklif_cari_details){
                                        $alt_edv_total_val = $teklif_cari_details->alt_edv_total_val;
                                        $para_birimi = $teklif_cari_details->para_birimi;

                                        $kur = geopos_currencies_details($para_birimi)->rate;
                                        $alt_edv_total_val=floatval($alt_edv_total_val)*$kur;
                                        $alt_edv_total_val_price =  amountFormat($alt_edv_total_val);
                                    }

                                    echo "<td>$alt_edv_total_val_price</td>";

                                }
                                ?>
                            </tr>

                            <tr>
                                <td colspan="2" style="text-align: end;font-weight: bold;">ümumi Cəmi</td>
                                <?php
                                foreach (muqayese_details($details->id)['cari'] as $items){
                                    $teklif_cari_details = teklif_cari_details($items['teklif_id']);
                                    $alt_total_val_price=0;
                                    if($teklif_cari_details){
                                        $alt_total_val = $teklif_cari_details->alt_total_val;
                                        $para_birimi = $teklif_cari_details->para_birimi;

                                        $kur = geopos_currencies_details($para_birimi)->rate;
                                        $alt_total_val=floatval($alt_total_val)*$kur;
                                        $alt_total_val_price =  amountFormat($alt_total_val);
                                    }

                                    echo "<td>$alt_total_val_price</td>";

                                }
                                ?>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

<script>

</script>
<style>


    input[type=checkbox]:checked + .radio_label {
        background-color: #1eb4b5;
        color: white;
    }
    input[type="checkbox"], input[type="checkbox"]{
        display: contents;
    }

   input[type=radio]:checked + .radio_label {
        background-color: #1eb4b5;
        color: white;
    }
    input[type="radio"], input[type="checkbox"]{
        display: contents;
    }


    .input-group-addon{
        border: 1px solid gray;
        border-left: none;
        border-radius: 0px 17px 16px 0px;
        padding: 12px;
        font-size: 12px;
    }
</style>
<script>

    $(document).on('change','.para_birimi',function (){
        let para_birimi  =$('option:selected', '.para_birimi').attr('code');
        $('.item_para_birimi').empty().html(para_birimi)

    })
    $(document).on('change','.discount_type',function (){
        let discount_type  =$('option:selected', '.discount_type').attr('code');
        $('.item_discount_type').empty().html(discount_type)
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })
    $(document).on('change','.edv_durum',function (){
        let edv_durum  =$(this).val();
        $('.item_edv_durum').val(edv_durum)
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })

    function amount_max(element){
        let max = $(element).attr('max');
        if(parseFloat($(element).val())>parseFloat(max)){
            $(element).val(parseFloat(max))
            return false;
        }
    }

    $(document).ready(function (){
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

        localStorage.clear();

    })


    $('.item_qty, .item_price, .item_discount, .item_kdv').keyup(function (){
        item_hesap($(this).attr('eq'))
    })

    $('.teslimat_tutar').keyup(function (){
        let teslimat_tutar = parseFloat($('.teslimat_tutar').val());
        let item_kdv = parseFloat($('.kdv_oran_details').val());
        let edv_durum = parseInt($('.edv_durum').val());
        let edv_tutari=0;
        let edvsiz=0;
        let cemi=0;
        let cemi_total=0;
        if(edv_durum)
        {
            edv_tutari = teslimat_tutar* (parseFloat(item_kdv)/100);
            cemi = teslimat_tutar-parseFloat(edv_tutari)
            cemi_total=cemi+edv_tutari;
        }
        else
        {
            edv_tutari = teslimat_tutar* (parseFloat(item_kdv)/100);
            cemi = teslimat_tutar-parseFloat(edv_tutari)
            cemi_total=teslimat_tutar;
        }


        $('.teslimat_cemi_hidden').val(cemi.toFixed(2));
        $('.teslimat_edv_total_hidden').val(edv_tutari.toFixed(2));
        $('.teslimat_total_hidden').val(cemi_total.toFixed(2));
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            item_hesap(i)
        }

    })

    $(document).on('change','.item_edv_durum',function (){
        let eq  =$('option:selected', '.item_edv_durum').attr('eq');
        item_hesap(eq);

    })

    function item_hesap(eq){
        let discount_type= $('.discount_type').val();
        let item_qty= $('.item_qty').eq(eq).val();
        let item_price= $('.item_price').eq(eq).val();
        let item_discount= $('.item_discount').eq(eq).val();
        let item_kdv= $('.item_kdv').eq(eq).val();
        let edv_durum = parseInt($('.item_edv_durum').eq(eq).val());
        let cemi = parseFloat(item_qty)*parseFloat(item_price);

        let edvsiz=0;
        let edv_tutari=0;
        let discount=0;
        let item_umumi_cemi = cemi;


        if(item_discount){

            if(discount_type==2){
                discount = cemi * (parseFloat(item_discount)/100);
                item_umumi_cemi = cemi * (100 - parseFloat(item_discount)) / 100
            }
            else {
                item_umumi_cemi = cemi-parseFloat(item_discount)
                discount=parseFloat(item_discount)
            }


        }

        if(edv_durum){
            edv_tutari = item_umumi_cemi* (parseFloat(item_kdv)/100);
            edvsiz = cemi-parseFloat(edv_tutari)

        }
        else {
            edv_tutari = item_umumi_cemi* (parseFloat(item_kdv)/100);
            item_umumi_cemi=item_umumi_cemi-parseFloat(edv_tutari);
            cemi = cemi-parseFloat(edv_tutari)
            edvsiz=cemi;
        }



        $('.item_edvsiz_hidden').eq(eq).val(edvsiz.toFixed(2));
        $('.edv_tutari_hidden').eq(eq).val(edv_tutari.toFixed(2));

        $('.item_discount_hidden').eq(eq).val(discount.toFixed(2));

        $('.item_umumi').eq(eq).val(cemi.toFixed(2));
        $('.item_umumi_hidden').eq(eq).val(cemi.toFixed(2));

        $('.item_umumi_cemi').eq(eq).val(item_umumi_cemi.toFixed(2));
        $('.item_umumi_cemi_hidden').eq(eq).val(item_umumi_cemi.toFixed(2));

        total_hesapla();


    }

    function total_hesapla(){

        let cemi_total = 0;
        let cemi_umumi_total = 0;
        let item_discount_total = 0;
        let item_edvsiz_total = 0;
        let edv_tutari_total = 0;
        let count = $('.item_qty').length;
        for (let i=0; i<count; i++){
            cemi_total +=parseFloat($('.item_umumi_cemi_hidden').eq(i).val());
            cemi_umumi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
            item_discount_total +=parseFloat($('.item_discount_hidden').eq(i).val());
            item_edvsiz_total +=parseFloat($('.item_edvsiz_hidden').eq(i).val());
            edv_tutari_total +=parseFloat($('.edv_tutari_hidden').eq(i).val());
        }


        let para_birimi  =$('option:selected', '.para_birimi').attr('code');



        let teslimat_cemi_hidden=  parseFloat($('.teslimat_cemi_hidden').val());
        let teslimat_edv_total_hidden=  parseFloat($('.teslimat_edv_total_hidden').val());
        let teslimat_total_hidden=  parseFloat($('.teslimat_total_hidden').val());

        item_edvsiz_total=item_edvsiz_total+teslimat_cemi_hidden;
        edv_tutari_total=edv_tutari_total+teslimat_edv_total_hidden;
        cemi_umumi_total=cemi_umumi_total+teslimat_total_hidden;

        $('#alt_sub_total').empty().text(item_edvsiz_total.toFixed(2)+' '+para_birimi)
        $('.alt_sub_total_val').val(item_edvsiz_total.toFixed(2));

        $('#alt_total').empty().text(cemi_umumi_total.toFixed(2)+' '+para_birimi)
        $('.alt_total_val').val(cemi_umumi_total.toFixed(2));

        $('#alt_discount_total').empty().text(item_discount_total.toFixed(2)+' '+para_birimi)
        $('.alt_discount_total_val').val(item_discount_total.toFixed(2));

        $('#alt_edv_total').empty().text(edv_tutari_total.toFixed(2)+' '+para_birimi)
        $('.alt_edv_total_val').val(edv_tutari_total.toFixed(2));
    }

    $(document).on('click','.guncelle',function (){
        let method = $('.method').val();
        if(parseInt(method)){
            let product_details=[];
            let count = $('.item_qty').length;
            for (let i=0; i < count; i++){
                product_details.push({
                    'item_id':$('.item_id').eq(i).val(),
                    'item_qty':$('.item_qty').eq(i).val(),
                    'item_price':$('.item_price').eq(i).val(),
                    'item_kdv':$('.item_kdv').eq(i).val(),
                    'item_discount':$('.item_discount').eq(i).val(),
                    'item_edvsiz':$('.item_edvsiz_hidden').eq(i).val(),
                    'edv_tutari':$('.edv_tutari_hidden').eq(i).val(),
                    'item_umumi':$('.item_umumi_hidden').eq(i).val(),
                    'item_umumi_cemi':$('.item_umumi_cemi_hidden').eq(i).val(),
                    'item_discount_umumi':$('.item_discount_hidden').eq(i).val(),
                    'item_desc':$('.item_desc').eq(i).val(),
                });
            }
            $('#loading-box').removeClass('d-none');
            let data = {
                teklif_id : $('#teklif_id').val(),
                cari_id : $('#cari_id').val(),
                form_id : $('#form_id').val(),
                discount_type : $('.discount_type').val(),
                teslimat : $('.teslimat').val(),
                teslimat_tutar : $('.teslimat_tutar').val(),
                edv_durum : $('.edv_durum').val(),
                para_birimi : $('.para_birimi').val(),
                alt_sub_total_val : $('.alt_sub_total_val').val(),
                alt_total_val : $('.alt_total_val').val(),
                alt_discount_total_val : $('.alt_discount_total_val').val(),
                alt_edv_total_val : $('.alt_edv_total_val').val(),
                method : method,
                product_details:product_details,
                crsf_token: crsf_hash,
            }
            $.post(baseurl + 'malzemetalep/teklif_update',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                if(responses.status=='Success'){
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'modern',
                        icon: 'fa fa-check',
                        type: 'green',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Başarılı',
                        content: 'Başarılı Bir Şekilde Güncellendi!',
                        buttons:{
                            formSubmit: {
                                text: 'Tamam',
                                btnClass: 'btn-blue'
                            }
                        }
                    });
                }
                else {
                    $('#loading-box').addClass('d-none');
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: 'Hata Aldınız!',
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            });
        }
        else {
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                title: 'Dikkat!',
                content: 'Ödeniş Metodu Seçmelisiniz',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }
    })


    $('.clickable').click(function (e) {


        let total = 0;
        var clickID     = $(this).data('click');
        var radioButton = '.radio_'+clickID;
        var price       = $(this).attr('azn_tutar_float');
        var talep_form_teklifler_item_details_id = $(this).attr('talep_form_teklifler_item_details_id');
        var miktar       = $(this).attr('miktar');
        var index       = $(this).attr('index');
        var radio_id       = $(this).attr('radio_id');
        var product_id       = $(this).attr('product_id');
        var type_cd       = $(this).attr('type_cd');
        var cari_id       = $(this).attr('cari_id');

        $('input[name="group'+radio_id+'"]').prop('checked', false);

        var cell = $(e.target).get(0);
        var $this = this;
        $('.crload_'+clickID).html('<i class="fa fa-spinner fa-spin"></i>');

        if($(radioButton).is(":checked")){
            $(radioButton).prop("checked", false);

            var c = $(cell).parents('tr').children('td');
            $(c).each(function () {
                $(c).removeClass('info');
                $(c).removeClass('select-border');
                 $(c).find('.fa-check').removeClass('fa fa-check');
            });
            $('.crload_'+clickID).html('');



        }else{
            $(radioButton).prop("checked", true);
            var c = $(cell).parents('tr').children('td');
            $(c).each(function () {
                $(c).removeClass('info');
                $(c).removeClass('select-border');
                $(c).find('.fa-check').removeClass('fa fa-check');
            });

            $($this).addClass('select-border');
            $('.crload_'+clickID).html('<i class="fa fa-check fa-2x"></i>');

        }



       hesaplama(clickID,miktar,price,talep_form_teklifler_item_details_id,index,product_id,type_cd,cari_id)



        //console.log('materialID:'+materialID+'\nactionID:'+actionID+'\nrequestID:'+requestID+'\ncompareID:'+compareID+'\nofrReqID:'+ofrReqID+'\nquantity:'+quantity);

    });



    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }


    $(document).on('click','.btn-check',function (){
        let product_id = $(this).attr('product_id');
        let type_cd = $(this).attr('type_cd');
        let depo_id = $(this).attr('depo_id');
        let miktar = $(this).attr('miktar');
        let talep_form_teklifler_item_details_id = depo_id;
        let index = $(this).attr('eq');
        let count = $('.clickable').length;
        for (let i = 0; i<count;i++){
            if(product_id == $('.clickable').eq(i).attr('product_id')){
                $('.clickable').eq(i).removeClass('select-border');
                $('.fa_update i').eq(i).removeClass('fa fa-check');

            }
        }
        hesaplama(0,miktar,product_id,talep_form_teklifler_item_details_id,index,product_id,type_cd,0)

    })

    function hesaplama(clickID,miktar,price,talep_form_teklifler_item_details_id,index,product_id,type_cd,cari_id){
        let filteredSerial=[];

        filteredSerial.push({
            id: parseInt(clickID),
            price: price,
            type: type_cd,
            cari_id: cari_id,
            product_id: product_id,
            index: parseInt(index),
            miktar: parseFloat(miktar),
            talep_form_teklifler_item_details_id: parseInt(talep_form_teklifler_item_details_id),
            total: parseFloat(miktar)*parseFloat(price),
        });


        let _serials = localStorage.getItem('product_serial');

        _serials = JSON.parse(_serials);

        if(_serials){
            let _filtered = filteredSerial[0];
            let otherRows = $.grep(_serials, function( item ) {
                return item.index !== _filtered.index;
            });
            otherRows.push(_filtered);

            localStorage.setItem('product_serial',JSON.stringify(otherRows));
        }
        else{
            localStorage.setItem('product_serial',JSON.stringify(filteredSerial));
        }


        let _serials_new = localStorage.getItem('product_serial');

        _serials_new = JSON.parse(_serials_new);
        total_price=0;
        if(_serials_new){
            for(let j=0; j<_serials_new.length;j++){
                total_price+=parseFloat(_serials_new[j].total);
            }
        }
        else {
            total_price=parseFloat(total);
        }



        let cur_price = currencyFormat(floatVal(total_price))
        $('#secilen_tutar').empty().text(cur_price);
    }

</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>app-assets/talep.css">

