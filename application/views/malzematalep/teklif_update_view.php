<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Təklif Forması</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>

<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group row col-sm-12">
                                            <label class="col-sm-12 col-form-label" for="product_name">Cari</label>
                                            <div class="col-sm-12">
                                                <input type="text" disabled class="form-control margin-bottom" value="<?php echo customer_details($cari_id)['company']?>">
                                                <input type="hidden" class="kdv_oran_details" value="<?php echo $teklif_details->kdv_oran;?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 row" style="padding: 0;">
                                            <div class="form-group col-sm-3">
                                                <label class="col-sm-12 col-form-label" for="product_name">Sorğu nömrəsi</label>
                                                <div class="col-sm-12">
                                                    <input type="text" disabled class="form-control margin-bottom" value="<?php echo $details->code;?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="col-sm-12 col-form-label" for="product_name">Teklif Oluşturma Tarixi</label>
                                                <div class="col-sm-12">
                                                    <input type="text" disabled class="form-control margin-bottom" value="<?php echo $teklif_details->create_at;?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="col-sm-12 col-form-label" for="product_name">Ödeniş Metodu<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <select class="form-control method">
                                                        <option value="0">Seçiniz</option>
                                                        <?php
                                                        $method_id=0;
                                                        if($teklif_kontrol){
                                                            $method_id = $teklif_kontrol['details']->method;
                                                        }
                                                        foreach (account_type() as $items){
                                                            $id=$items['id'];
                                                            $name=$items['name'];
                                                            $selected='';
                                                            if($id==$method_id){
                                                                $selected='selected';
                                                            }
                                                            echo "<option $selected value='$id'>$name</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <label class="col-sm-12 col-form-label" for="product_name">Endirim Tipi</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control discount_type">
                                                        <?php
                                                        $discount_type=0;
                                                        if($teklif_kontrol){
                                                            $discount_type = $teklif_kontrol['details']->discount_type;
                                                        }
                                                        else {
                                                            $discount_type = $teklif_details->discount_type;
                                                        }
                                                        ?>
                                                        <option code="%" <?php echo ($discount_type==2)?'selected':''; ?> value='2'>%</option>
                                                        <option code="Float" <?php echo ($discount_type==1)?'selected':''; ?> value='1'>Float</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col col-xs-6 col-sm-6 col-md-6">

                                        <div class="col-sm-12 row" style="padding: 0;">
                                            <div class="form-group col-sm-2">
                                                <label class="col-sm-12 col-form-label" for="product_name">Çatdırılma Növü</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control teslimat">
                                                        <?php
                                                        $teslimat=0;
                                                        if($teklif_kontrol){
                                                            $teslimat = $teklif_kontrol['details']->teslimat;
                                                        }
                                                        else {
                                                            $teslimat = $teklif_details->teslimat;
                                                        }
                                                        ?>
                                                        <option <?php echo ($teslimat)?'selected':''; ?> value='1'>Dahil</option>
                                                        <option <?php echo (!$teslimat)?'selected':''; ?> value='0'>Hariç</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <label class="col-sm-12 col-form-label" for="product_name">Çatdırılma T.</label>
                                                <div class="col-sm-12">
                                                    <?php
                                                    $teslimat_tutar = 0;
                                                    if ($teklif_kontrol) {
                                                        $teslimat_tutar = $teklif_kontrol['details']->teslimat_tutar;
                                                    } ?>
                                                    <input type="number" class="form-control teslimat_tutar" value="<?php echo $teslimat_tutar ?>">
                                                    <input class="form-control teslimat_cemi_hidden" type="hidden" value="0">
                                                    <input class="form-control teslimat_edv_total_hidden" type="hidden" value="0">
                                                    <input class="form-control teslimat_total_hidden" type="hidden" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="col-sm-12 col-form-label" for="product_name">ƏDV</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control edv_durum">
                                                        <?php
                                                        $edv_durum=0;
                                                        if($teklif_kontrol){
                                                            $edv_durum = $teklif_kontrol['details']->edv_durum;
                                                        }
                                                        else {
                                                            $edv_durum = $teklif_details->kdv;
                                                        }
                                                        ?>
                                                        <option <?php echo ($edv_durum)?'selected':''; ?> value='1'>Dahil</option>
                                                        <option <?php echo (!$edv_durum)?'selected':''; ?> value='0'>Hariç</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group  col-sm-4">
                                                <label class="col-sm-12 col-form-label" for="product_name">Valyuta təklif edin</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control para_birimi">
                                                        <?php
                                                        $para_birimi=$teklif_details->para_birimi;
                                                        if($teklif_kontrol){
                                                            $para_birimi = $teklif_kontrol['details']->para_birimi;
                                                        }
                                                        foreach (para_birimi() as $items){
                                                            $id=$items['id'];
                                                            $name=$items['code'];
                                                            $selected='';
                                                            if($id==$para_birimi){
                                                                $selected='selected';
                                                            }
                                                            echo "<option code='$name' $selected value='$id'>$name</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-12 row" style="padding: 0;">
                                            <div class="form-group  col-sm-4">
                                                <label class="col-sm-12 col-form-label" for="avans_price">Avans Ödemesi</label>
                                                <div class="col-sm-12">

                                                    <?php
                                                    $avans_price=0;
                                                    if($teklif_kontrol){
                                                        $avans_price=$teklif_kontrol['details']->avans_price;
                                                    }
                                                    ?>
                                                    <input value="<?php echo $avans_price?>" class="form-control avans_price" onkeyup="amount_max(this)"  id="avans_price">
                                                </div>
                                            </div>
                                            <div class="form-group  col-sm-8">
                                                <label class="col-sm-2 col-form-label" for="product_name">Durum:</label>
                                                <div class="col-sm-12">
                                                    <?php
                                                    foreach (teklif_durumlari($form_id,$cari_id)['data'] as $value){
                                                        echo $value['status'].$value['phone'];
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <table class="table">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>MALZEME</td>
                            <td>Varyasyon</td>
                            <td>Teklif Miktarı</td>
                            <td>Birim</td>
                            <td>Vahid qiymət</td>
                            <td>Endirim</td>
                            <td>ƏDV Oran</td>
                            <td>ƏDV</td>
                            <td>Cemi (EDVSİZ)</td>
                            <td>ÜMUMI CƏMI (EDV Daxıl)</td>
                            <td>Not</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        $eq=0;
                        $talep_type = $details->talep_type;
                        foreach ($items_ as $items){
                            if($talep_type==1){
                            if($teklif_kontrol){


                                $details_items = teklif_update_item_kontrol($items->id,$details_id);
                                $product_name = product_name($items->product_id);
                                $unit_name = units_($items->unit_id)['name'];
                                if($items->product_type==2){
                                    $product_name = cari_product_details($items->product_id)->product_name;
                                    $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
                                }

                                ?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $product_name; ?></td>
                                    <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
                                    <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$details_items->qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name ?></span></div></td>
                                    <td>
                                        <select style='width: 125px;'  class="form-control select-box new_unit_id">
                                            <?php foreach (units() as $unit_items){
                                                $selected='';
                                                $id_=$unit_items['id'];
                                                $name=$unit_items['name'];
                                                if($id_==$items->unit_id){
                                                    $selected='selected';
                                                }
                                                echo "<option $selected value='$id_'>$name</option>";
                                            }?>
                                        </select>
                                    </td>
                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->price'  class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                    <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->discount'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->edv_oran'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
            <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($details_items->edv_type)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$details_items->edv_type)?'selected':''; ?>  value="0">Haric</option></select></td>

            <td><input value="<?php echo $details_items->sub_total ?>" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
            <td><input value="<?php echo $details_items->total ?>" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
            <td><input type="text" class="form-control item_desc" value="<?php echo $details_items->item_desc;?>"></td>
            <input type="hidden" class="item_edvsiz_hidden" value="<?php echo $details_items->sub_total ?>">
            <input type="hidden" class="edv_tutari_hidden" value="<?php echo $details_items->kdv_total ?>">
            <input type="hidden" class="item_umumi_hidden" value="<?php echo $details_items->sub_total ?>">
            <input type="hidden" class="item_umumi_cemi_hidden" value="<?php echo $details_items->total ?>">
            <input type="hidden" class="item_discount_hidden" value="<?php echo $details_items->discount_total ?>">
            <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
            </tr>
            <?php
            }
                            else{
                                        $details = cari_to_teklif_details($items->id,$teklif_id);
                                        $price = floatval($details->price);
                                        $endirim = floatval(0);
                                        $edv = floatval(0);



                                        $product_name = product_name($items->product_id);
                                        $unit_name = units_($items->unit_id)['name'];
                                        if($items->product_type==2){
                                            $product_name = cari_product_details($items->product_id)->product_name;
                                            $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $product_name ?></td>
                                            <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$items->product_qty'  max='$items->product_qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name?></span></div></td>
                                    <td>
                                        <select style='width: 125px;'  class="form-control select-box new_unit_id">
                                            <?php foreach (units() as $unit_items){
                                                $selected='';
                                                $id_=$unit_items['id'];
                                                $name=$unit_items['name'];
                                                if($id_==$items->unit_id){
                                                    $selected='selected';
                                                }
                                                echo "<option $selected value='$id_'>$name</option>";
                                            }?>
                                        </select>
                                    </td>
                                    <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$price' max='$price' class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                                    <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$endirim'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                    <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$teklif_details->kdv_oran'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                    <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($teklif_details->kdv)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$teklif_details->kdv)?'selected':''; ?>  value="0">Haric</option></select></td>
                                    <td><input value="0" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                    <td><input value="0" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                                    <td><input type="text" class="form-control item_desc" value="<?php echo $details->notes;?>"></td>
                                    <input type="hidden" class="item_edvsiz_hidden">
                                    <input type="hidden" class="edv_tutari_hidden">
                                    <input type="hidden" class="item_umumi_hidden">
                                    <input type="hidden" class="item_umumi_cemi_hidden">
                                    <input type="hidden" class="item_discount_hidden">
                                    <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
                                    </tr>
                                    <?php
                                    }
                                    $i++;
                                    $eq++;
                            }
                            elseif($talep_type==2){
                                    if($teklif_kontrol){


                                        $details_items = teklif_update_item_kontrol($items->id,$details_id);
                                        $product_name = product_name($items->product_id);
                                        $unit_name = units_($items->unit_id)['name'];
                                        if($items->product_type==2){
                                            $product_name = cari_product_details($items->product_id)->product_name;
                                            $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
                                        }

                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $product_name; ?></td>
                                            <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$details_items->qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name ?></span></div></td>
                                            <td>
                                                <select style='width: 125px;'  class="form-control select-box new_unit_id">
                                                    <?php foreach (units() as $unit_items){
                                                        $selected='';
                                                        $id_=$unit_items['id'];
                                                        $name=$unit_items['name'];
                                                        if($id_==$items->unit_id){
                                                            $selected='selected';
                                                        }
                                                        echo "<option $selected value='$id_'>$name</option>";
                                                    }?>
                                                </select>
                                            </td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->price'  class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->discount'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->edv_oran'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                            <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($details_items->edv_type)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$details_items->edv_type)?'selected':''; ?>  value="0">Haric</option></select></td>

                                            <td><input value="<?php echo $details_items->sub_total ?>" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                            <td><input value="<?php echo $details_items->total ?>" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                                            <td><input type="text" class="form-control item_desc" value="<?php echo $details_items->item_desc;?>"></td>
                                            <input type="hidden" class="item_edvsiz_hidden" value="<?php echo $details_items->sub_total ?>">
                                            <input type="hidden" class="edv_tutari_hidden" value="<?php echo $details_items->kdv_total ?>">
                                            <input type="hidden" class="item_umumi_hidden" value="<?php echo $details_items->sub_total ?>">
                                            <input type="hidden" class="item_umumi_cemi_hidden" value="<?php echo $details_items->total ?>">
                                            <input type="hidden" class="item_discount_hidden" value="<?php echo $details_items->discount_total ?>">
                                            <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
                                        </tr>
                                        <?php
                                    }
                                    else{
                                        $details = cari_to_teklif_details($items->id,$teklif_id);
                                        $price = floatval($details->price);
                                        $endirim = floatval(0);
                                        $edv = floatval(0);
                                        $product_name = product_name($items->product_id);
                                        $unit_name = units_($items->unit_id)['name'];
                                        if($items->product_type==2){
                                            $product_name = cari_product_details($items->product_id)->product_name;
                                            $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $product_name ?></td>
                                            <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$items->product_qty'  max='$items->product_qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name?></span></div></td>
                                            <td>
                                                <select style='width: 125px;'  class="form-control select-box new_unit_id">
                                                    <?php foreach (units() as $unit_items){
                                                        $selected='';
                                                        $id_=$unit_items['id'];
                                                        $name=$unit_items['name'];
                                                        if($id_==$items->unit_id){
                                                            $selected='selected';
                                                        }
                                                        echo "<option $selected value='$id_'>$name</option>";
                                                    }?>
                                                </select>
                                            </td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$price' max='$price' class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$endirim'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                            <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$teklif_details->kdv_oran'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                            <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($teklif_details->kdv)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$teklif_details->kdv)?'selected':''; ?>  value="0">Haric</option></select></td>
                                            <td><input value="0" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                            <td><input value="0" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                                            <td><input type="text" class="form-control item_desc" value="<?php echo $details->notes;?>"></td>
                                            <input type="hidden" class="item_edvsiz_hidden">
                                            <input type="hidden" class="edv_tutari_hidden">
                                            <input type="hidden" class="item_umumi_hidden">
                                            <input type="hidden" class="item_umumi_cemi_hidden">
                                            <input type="hidden" class="item_discount_hidden">
                                            <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
                                        </tr>
                                        <?php
                                    }
                                    $i++;
                                    $eq++;
                            }
                            elseif($talep_type==3){
                                if($teklif_kontrol){


                                    $details_items = teklif_update_item_kontrol($items->id,$details_id);

                                    if($details->id < 3193){
                                        $product_name = cost_details($items->product_id)->name;
                                    }
                                    else {
                                        $product_name = who_demirbas($items->product_id)->name;
                                    }

                                    $unit_name = units_($items->unit_id)['name'];

                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $product_name; ?></td>
                                        <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$details_items->qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name ?></span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->price'  class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->discount'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$details_items->edv_oran'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                        <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($details_items->edv_type)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$details_items->edv_type)?'selected':''; ?>  value="0">Haric</option></select></td>

                                        <td><input value="<?php echo $details_items->sub_total ?>" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                        <td><input value="<?php echo $details_items->total ?>" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                                        <td><input type="text" class="form-control item_desc" value="<?php echo $details_items->item_desc;?>"></td>
                                        <input type="hidden" class="item_edvsiz_hidden" value="<?php echo $details_items->sub_total ?>">
                                        <input type="hidden" class="edv_tutari_hidden" value="<?php echo $details_items->kdv_total ?>">
                                        <input type="hidden" class="item_umumi_hidden" value="<?php echo $details_items->sub_total ?>">
                                        <input type="hidden" class="item_umumi_cemi_hidden" value="<?php echo $details_items->total ?>">
                                        <input type="hidden" class="item_discount_hidden" value="<?php echo $details_items->discount_total ?>">
                                        <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
                                    </tr>
                                    <?php
                                }
                                else{

                                    $details = cari_to_teklif_details($items->id,$teklif_id);
                                    $price = floatval($details->price);
                                    $endirim = floatval(0);
                                    $edv = floatval(0);

                                    if($details_id < 3193){
                                        $product_name = cost_details($items->product_id)->name;
                                    }
                                    else {
                                        $product_name = who_demirbas($items->product_id)->name;
                                    }
                                    $unit_name = units_($items->unit_id)['name'];
                                    if($items->product_type==2){
                                        $product_name = cari_product_details($items->product_id)->product_name;
                                        $unit_name = units_(cari_product_details($items->product_id)->unit_id)['name'];
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $product_name ?></td>
                                        <td><?php echo talep_form_product_options_teklif_html($items->id); ?></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq'  value='$items->product_qty'  max='$items->product_qty' class='form-control item_qty'>" ?><span class="input-group-addon font-xs text-right"><?php echo $unit_name?></span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$price' max='$price' class='form-control item_price'>" ?><span class="input-group-addon font-xs text-right item_para_birimi"><?php echo para_birimi_id(1)['code']?></span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$endirim'  class='form-control item_discount'>" ?><span class="input-group-addon font-xs text-right item_discount_type">%</span></div></td>
                                        <td><?php echo "<div class='input-group '><input type='number' eq='$eq' value='$teklif_details->kdv_oran'  class='form-control item_kdv'>" ?><span class="input-group-addon font-xs text-right">%</span></div></td>
                                        <td><select class="form-control item_edv_durum"><option  eq='<?php echo $eq; ?>' <?php echo ($teklif_details->kdv)?'selected':''; ?>  value="1">Dahil</option><option eq='<?php echo $eq; ?>'  <?php echo (!$teklif_details->kdv)?'selected':''; ?>  value="0">Haric</option></select></td>
                                        <td><input value="0" type="number" class="form-control item_umumi" eq='<?php echo $eq; ?>'  disabled></td>
                                        <td><input value="0" type="number" class="form-control item_umumi_cemi" eq='<?php echo $eq; ?>'  disabled></td>
                                        <td><input type="text" class="form-control item_desc" value="<?php echo $details->notes;?>"></td>
                                        <input type="hidden" class="item_edvsiz_hidden">
                                        <input type="hidden" class="edv_tutari_hidden">
                                        <input type="hidden" class="item_umumi_hidden">
                                        <input type="hidden" class="item_umumi_cemi_hidden">
                                        <input type="hidden" class="item_discount_hidden">
                                        <input type="hidden" value="<?php echo $items->id ?>" class="item_id">
                                    </tr>
                                    <?php
                                }
                                $i++;
                                $eq++;
                            }

                        } ?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="8" style="text-align: end;font-weight: 600;">Cəmi:</td>
                            <td style="font-weight: 600;"><span id="alt_sub_total">0 AZN</span></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align: end;font-weight: 600;">Güzəşt:</td>
                            <td style="font-weight: 600;"><span id="alt_discount_total">0 AZN</span></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align: end;font-weight: 600;">Net Cemi:</td>
                            <td style="font-weight: 600;"><span id="net_cemi_total">0 AZN</span></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align: end;font-weight: 600;">ƏDV:</td>
                            <td style="font-weight: 600;"><span id="alt_edv_total">0 AZN</span></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align: end;font-weight: 600;">ümumi cəmi:</td>
                            <td style="font-weight: 600;"><span id="alt_total">0 AZN</span></td>
                        </tr>
                        <tr>
                            <td colspan="8" style="text-align: end;font-weight: 600;"><button type="button" class="btn btn-success guncelle"><i class="fa fa-save"></i>&nbsp;Güncelle</button></td>
                        </tr>
                        <input type="hidden" class="alt_net_cemi_total">
                        <input type="hidden" class="alt_sub_total_val">
                        <input type="hidden" class="alt_discount_total_val">
                        <input type="hidden" class="alt_edv_total_val">
                        <input type="hidden" class="alt_total_val">
                        </tfoot>
                        </table>
                        <input type="hidden" id="teklif_id" value="<?php echo $teklif_id?>">
                        <input type="hidden" id="cari_id" value="<?php echo $cari_id?>">
                        <input type="hidden" id="form_id" value="<?php echo $form_id?>">
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    let nakliye=0;
    let kdv=0;
    let method=0;
    let cari_id=27;
    let form_id=2;
</script>
<style>
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
        $('.teslimat_tutar').keyup();
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
            if(parseFloat($('.item_kdv').eq(0).val())>0){
                edv_tutari_tes = teslimat_tutar* (parseFloat(item_kdv)/100);
                cemi = edv_tutari_tes-parseFloat(edv_tutari)
                cemi_total=cemi+edv_tutari;
            }
            else {
                edv_tutari_tes = 0;
            }
        }
        else
        {
            let  one_itemkdv = parseFloat($('.item_kdv').eq(0).val());
            if(one_itemkdv > 0){
                edv_tutari_tes = teslimat_tutar* (parseFloat(one_itemkdv)/100);

            }
            else {
                edv_tutari_tes=0;
            }
            cemi = edv_tutari_tes-parseFloat(edv_tutari)
            cemi_total=teslimat_tutar;
        }


        $('.teslimat_cemi_hidden').val(teslimat_tutar);
        $('.teslimat_edv_total_hidden').val(edv_tutari_tes);
        $('.teslimat_total_hidden').val(teslimat_tutar);
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

        //let item_edvsiz = item_price/(1+(item_kdv/100));
        let item_edvsiz = item_price;
        let cemi = parseFloat(item_qty)*parseFloat(item_edvsiz);

        let edvsiz=0;
        let edvsiz_item=0;
        let edv_tutari=0;
        let edv_tutari_price=0;
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



            // edv_tutari = item_umumi_cemi * (parseFloat(item_kdv)/100);
            // edvsiz = cemi-parseFloat(edv_tutari)
            //

             cemi = cemi / (1+ (parseFloat(item_kdv)/100));
             edv_tutari = cemi *(parseFloat(item_kdv)/100);
             edv_tutari_price = cemi * (parseFloat(item_kdv)/100);

        }
        else {

            edv_tutari = item_umumi_cemi *(parseFloat(item_kdv)/100);


            //
            // edv_tutari = item_umumi_cemi * (parseFloat(item_kdv)/100);
            // item_umumi_cemi=item_umumi_cemi+parseFloat(edv_tutari);
            // cemi = cemi-parseFloat(edv_tutari)
            // edvsiz=cemi;

            edv_tutari_price = 0;
        }


        edvsiz_item = item_price-edv_tutari_price;

        $('.item_edvsiz_hidden').eq(eq).val(cemi.toFixed(4));
        $('.item_edvsiz_hidden_price').eq(eq).val(edvsiz_item.toFixed(4));

        $('.edv_tutari_hidden').eq(eq).val(edv_tutari.toFixed(4));

        $('.item_discount_hidden').eq(eq).val(discount.toFixed(4));

        $('.item_umumi').eq(eq).val(cemi.toFixed(4));
        $('.item_umumi_hidden').eq(eq).val(cemi.toFixed(4));

        $('.item_umumi_cemi').eq(eq).val(item_umumi_cemi.toFixed(4));
        $('.item_umumi_cemi_hidden').eq(eq).val(item_umumi_cemi.toFixed(4));

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
            cemi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
            cemi_umumi_total +=parseFloat($('.item_umumi_hidden').eq(i).val());
            item_discount_total +=parseFloat($('.item_discount_hidden').eq(i).val());
            item_edvsiz_total +=parseFloat($('.item_edvsiz_hidden').eq(i).val());
            edv_tutari_total +=parseFloat($('.edv_tutari_hidden').eq(i).val());
        }


        let para_birimi  =$('option:selected', '.para_birimi').attr('code');



        let teslimat_cemi_hidden=  parseFloat($('.teslimat_cemi_hidden').val());
        let teslimat_edv_total_hidden=  parseFloat($('.teslimat_edv_total_hidden').val());
        let teslimat_total_hidden=  parseFloat($('.teslimat_total_hidden').val());

        item_edvsiz_total=cemi_total+teslimat_cemi_hidden;
        edv_tutari_total=edv_tutari_total+teslimat_edv_total_hidden;
        cemi_umumi_total=cemi_umumi_total+teslimat_total_hidden;

        $('#alt_sub_total').empty().text(item_edvsiz_total.toFixed(2)+' '+para_birimi)
        $('.alt_sub_total_val').val(item_edvsiz_total.toFixed(4));



        $('#alt_discount_total').empty().text(item_discount_total.toFixed(2)+' '+para_birimi)
        $('.alt_discount_total_val').val(item_discount_total.toFixed(4));

        let net_cemi_total = item_edvsiz_total-item_discount_total;
        $('#net_cemi_total').empty().text(net_cemi_total.toFixed(2)+' '+para_birimi)
        $('.alt_net_cemi_total').val(net_cemi_total.toFixed(4));

        $('#alt_edv_total').empty().text(edv_tutari_total.toFixed(2)+' '+para_birimi)
        $('.alt_edv_total_val').val(edv_tutari_total.toFixed(4));

        let teslimat_tutar = parseFloat($('.teslimat_tutar').val());
        let alt_total = net_cemi_total+edv_tutari_total;
        $('#alt_total').empty().text(alt_total.toFixed(2)+' '+para_birimi)
        $('.alt_total_val').val(alt_total.toFixed(4));
        $('#avans_price').attr('max',alt_total.toFixed(4));
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
                    'new_unit_id':$('.new_unit_id').eq(i).val(),
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
                avans_price : $('.avans_price').val(),
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
                        content:responses.message,
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




</script>
