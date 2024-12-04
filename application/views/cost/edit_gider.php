<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 16:30
 */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="tab-content px-1 pt-1">
            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>

            </div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="col-xl-12 col-lg-12 col-xs-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <section class="panel panel-primary box-shadow--16dp">
                            <header class="panel-heading">
                                <a style="color: white">Masraf Detayları</a>
                            </header>


                            <div class="panel-body form-horizontal">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Masraf Kalemleri</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" id="masraf_id" name="masraf_id">
                                            <option value="0">Masraf Gideri Seçiniz</option>
                                            <?php  $select_=''; foreach ($ana_gider_kalemleri as $gd) {

                                                if($ana_gider_kalemi==$gd->id)
                                                {
                                                    $select_='selected';
                                                }
                                                else
                                                    {
                                                        $select_='';
                                                    }

                                                ?>
                                                <optgroup <?php echo $select_ ?> label="<?php echo $gd->name ?>">

                                                    <?php
                                                    foreach ($alt_gider_kalemleri as $agd) {
                                                        if($agd->parent_id==$gd->id)
                                                        {
                                                            if($edit_data->masraf_id==$agd->id)
                                                            {
                                                            ?>
                                                            <option selected value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>
                                                            <?php
                                                            }
                                                            else
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>
                                                                    <?php
                                                                }
                                                        }
                                                        ?>

                                                    <?php } ?>
                                                </optgroup>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">İşlem Tarihi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control required editdate" value="<?php echo dateformat($edit_data->invoicedate);?>" name="islem_date" id="islem_date"

                                               autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Fiş / Belge No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $edit_data->invoice_no ?>" name="belge_no" id="belge_no" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Açıklama</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control"  name="description"><?php echo $edit_data->notes ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Tip</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="tip" id="tip">

                                            <option <?php if($edit_data->refer==0) { echo  'selected'; } else { echo '';} ?> value="0">Seçiniz</option>
                                            <option <?php if($edit_data->refer==1) { echo  'selected'; } else { echo '';} ?> value="1">Cari</option>
                                            <option <?php if($edit_data->refer==2) { echo  'selected'; } else { echo '';} ?> value="2">Personel</option>
                                            <option <?php if($edit_data->refer==3) { echo  'selected'; } else { echo '';} ?> value="3">Fatura</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row cari_personel" style="<?php if($edit_data->refer==0) echo 'display: none' ?>">
                                    <label class="col-sm-4 col-form-label" for="name">Cari/Personel/Fatura</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" style="width: 100%" name="cari_personel_fatura" id="cari_personel">
                                            <?php if($edit_data->refer==1)
                                            {
                                                //Eğer Cari İse cari bilgileri
                                                foreach (all_customer() as $customer)
                                                {
                                                    if($customer->id==$edit_data->csd)
                                                    {
                                                        echo "<option selected value='$customer->id'>$customer->company</option>";
                                                    }
                                                    else
                                                        {
                                                            echo "<option value='$customer->id'>$customer->company</option>";
                                                        }

                                                }
                                            }
                                            else if($edit_data->refer==2)
                                            {
                                                // Eğer personel ise personel bilgileri
                                                foreach (personel_list() as $customer)
                                                {
                                                    if($customer['id']==$edit_data->csd)
                                                    {
                                                        echo "<option selected value='".$customer['id']."'>".$customer['name']."</option>";
                                                    }
                                                    else
                                                        {
                                                            echo "<option value='".$customer['id']."'>".$customer['name']."</option>";
                                                        }

                                                }

                                            }  else if($edit_data->refer==3)
                                            {
                                                // Eğer fatura ise personel bilgileri
                                                foreach (all_invoice_gider() as $customer)
                                                {
                                                    if($customer->id==$edit_data->csd)
                                                    {
                                                        echo "<option selected value='$customer->id'>$customer->invoice_no".' '."$customer->invoice_type</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='$customer->id'>$customer->invoice_no</option>";
                                                    }

                                                }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row proje_id">
                                    <label class="col-sm-4 col-form-label" for="name">Proje</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" style="width: 100%" name="proje_id" id="proje_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (all_projects()  as $project)
                                            {
                                                if($edit_data->proje_id==$project->id)
                                                {
                                                    echo "<option selected value='".$project->id."'>".$project->name."</option>";
                                                }
                                                else
                                                    {
                                                        echo "<option value='".$project->id."'>".$project->name."</option>";
                                                    }

                                            } ?>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Bölüm Seçiniz</label>
                                    <div class="col-sm-8">
                                        <select name="bolum_id" class="form-control select-box" id="bolum_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (all_bolum_proje($edit_data->proje_id) as $project){


                                                $bolum_id=$edit_data->bolum_id;
                                                if($bolum_id==$project->id )
                                                {
                                                    ?>
                                                    <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Aşama Seçiniz</label>
                                    <div class="col-sm-8">
                                        <select name="asama_id" class="form-control select-box" id="asama_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (all_bolum_asama($edit_data->bolum_id) as $project){


                                                $asama_id=$edit_data->asama_id;
                                                if($asama_id==$project->id )
                                                {
                                                    ?>
                                                    <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">İş Kalemi Seçiniz</label>
                                    <div class="col-sm-8">
                                        <select name="task_id" class="form-control select-box" id="task_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (all_bolum_task($edit_data->asama_id) as $project){


                                                $task_id=$edit_data->task_id;
                                                if($task_id==$project->id )
                                                {
                                                    ?>
                                                    <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Ödeme Durumu</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="odeme_durumu" class="form-control" disabled value="<?php
                                        if($edit_data->odeme_durumu==0) { echo 'Daha Sonra Ödenecek'; }
                                        else  if($edit_data->odeme_durumu==1) { echo 'Ödendi'; }
                                        else  if($edit_data->odeme_durumu==2) { echo 'Kısmi Ödeme'; }

                                        ?>">
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd"  style="<?php   if($edit_data->odeme_durumu==0) { echo 'display: none;'; } ?>">
                                    <label class="col-sm-4 col-form-label" for="name">Ödeme Tarihi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control editdate required" value="<?php echo dateformat($edit_data->invoiceduedate);?>" name="odeme_tarihi" id="odeme_tarihi"
                                               autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd" style="<?php   if($edit_data->odeme_durumu==0) { echo 'display: none;'; } ?>">
                                    <label class="col-sm-4 col-form-label" for="name">Kasa / Hesap</label>
                                    <div class="col-sm-8">
                                        <select name="account" class="form-control" id="account">
                                            <option value="0">Seçiniz</option>
                                            <?php
                                            foreach (account_type() as $ac_type)
                                            {

                                                $name=$ac_type['name'];
                                                echo "<optgroup label='$name'>";
                                                foreach ($accounts as $row) {
                                                    $cid = $row['id'];
                                                    $acn = $row['acn'];
                                                    $holder = $row['holder'];
                                                    if($ac_type['id']==$row['account_type'])
                                                    {
                                                        if($edit_data->acid==$row['id'])
                                                        {
                                                            $balance=amountFormat(hesap_balance($cid));
                                                            echo "<option selected value='$cid'>$holder ($balance)</option>";
                                                        }
                                                        else
                                                        {
                                                            $balance=amountFormat(hesap_balance($cid));
                                                            echo "<option value='$cid'>$holder ($balance)</option>";
                                                        }
                                                    }


                                                }
                                                echo "</optgroup>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row odeme_hidd" >
                                    <label class="col-sm-4 col-form-label" for="name">Ödeme Şekli</label>
                                    <div class="col-sm-8">
                                        <select name="paymethod" class="form-control" id="paymethod">
                                            <?php foreach (account_type_islem() as $acc)
                                            {
                                                if($edit_data->method==$acc->id)
                                                {
                                                    echo "<option selected value='$acc->id'>$acc->name</option>";
                                                }
                                                else
                                                    {
                                                        echo "<option value='$acc->id'>$acc->name</option>";
                                                    }

                                            } ?>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-4 col-form-label"
                                           for="invoice_para_birimi"><?php echo $this->lang->line('odeme_para_birimi') ?></label>

                                    <div class="col-sm-7">
                                        <select name="para_birimi" id="para_birimi" class="form-control">
                                            <?php
                                            foreach (para_birimi()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['code'];
                                                if($edit_data->para_birimi==$cid)
                                                {
                                                    echo "<option selected value='$cid'>$title</option>";
                                                }
                                                else
                                                    {
                                                        echo "<option value='$cid'>$title</option>";
                                                    }

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-4 col-form-label"
                                           for="invoice_kur_degeri"><?php echo $this->lang->line('invoice_kur_degeri') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control " placeholder="Kur"
                                               name="kur_degeri" value="<?php echo $edit_data->kur_degeri; ?>" id="kur_degeri">
                                    </div>
                                    <div class="col-sm-4">
                                        <a style="color: #fff;" class="btn btn-success kur" id="kur_al"><?php echo $this->lang->line('online_button') ?></a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Tutar</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $edit_data->total; ?>" name="tutar" id="tutar" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">KDV Oranı</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" value="<?php echo $edit_data->tax_oran; ?>"  name="kdv_orani" id="kdv_orani" >
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd" style="<?php   if($edit_data->odeme_durumu==0) { echo 'display: none;'; } ?>">
                                    <label class="col-sm-4 col-form-label" for="name">Ödenen Tutar</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $odenen_tutar=0;
                                        if($edit_data->odeme_durumu!=0)
                                        {
                                            $odenen_tutar=$edit_data->total;
                                        } ?>
                                        <input type="text" class="form-control" value="<?php echo $odenen_tutar; ?>" name="odenen_tutar" id="odenen_tutar">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"></label>

                                    <div class="col-sm-12">
                                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                               value="Düzenle" data-loading-text="Adding...">
                                        <input type="hidden" value="cost/edit_action" id="action-url">

                                        <input type="hidden" value="<?php echo $edit_data->inv_id ?>" name="trans_id">
                                        <input type="hidden" value="<?php echo $edit_data->inv_id?>" name="inv_id">
                                    </div>
                                </div>
                            </div>


                        </section>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="sub_gider_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Gider Kalemi Tanımlama</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"
                               for="name">Ana Kalem</label>
                        <div class="col-sm-8">
                            <input type="text" readonly class="form-control margin-bottom" id="ana_gider">
                            <input type="hidden" name="ana_gider_id" id="ana_gider_id">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-4 col-form-label"
                               for="phone">Gider Kalemi</label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Elektrik" class="form-control margin-bottom" name="gider_kalemi" id="gider_kalemi">
                            <input type="hidden" name="gider_id" id="gider_id">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="type" name="type" value="">
                <input type="hidden" id="action-url">
                <input type="hidden" id="delete-url" value="cost/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger"
                        id="deleteGider">Sil</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="addGiderButton">Kaydet</button>

                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>


<div id="gider_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Ana Masraf Kalemi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label"
                               for="name">Ana Masraf Kalemi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control margin-bottom" id="ana_gider_name">
                            <input type="hidden" name="ana_gider_id2" id="ana_gider_id2">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="type" name="type" value="">
                <input type="hidden" id="action-url" value="cost/anaUpdate">
                <input type="hidden" id="delete-url" value="cost/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-danger"
                        id="deleteGider2">Sil</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="updateGiderButton">Kaydet</button>

                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    function editgider(id,name) {
        $('#ana_gider_name').val(name);
        $('#ana_gider_id2').val(id);
        $('#gider_model').modal({backdrop: 'static', keyboard: false});
    }
    function EditSubAccount(id,alt_id, ana_gider, type,$parent_value) {

        $('#gider_kalemi').val('');
        $('#type').val('');
        $('#gider_id').val(alt_id);
        $('#ana_gider_id').val(id);
        $('#action-url').val('cost/gider_kalemi_i');
        if(type==0)
        {
            $('#deleteGider').css('display','none');
        }
        else
        {
            $('#deleteGider').css('display','block');
        }

        $('#ana_gider').val(ana_gider);
        $('#gider_kalemi').val($parent_value);
        $('#type').val(type);
        $('#sub_gider_model').modal({backdrop: 'static', keyboard: false});
    }

    $("#addGiderButton").on("click", function() {
        var o_data = 'id=' + $('#ana_gider_id').val()+'&alt_id=' + $('#gider_id').val()+'&gider_kalemi='+ $('#gider_kalemi').val()+'&type='+ $('#type').val();
        var action_url= $('#sub_gider_model #action-url').val();
        addObject(o_data,action_url);
    });

    $("#deleteGider").on("click", function() {
        var o_data = 'id=' + $('#gider_id').val();
        var action_url= $('#sub_gider_model #delete-url').val();
        addObject(o_data,action_url);
    });

    $("#deleteGider2").on("click", function() {
        var o_data = 'id=' + $('#ana_gider_id2').val();
        var action_url= $('#gider_model #delete-url').val();
        addObject(o_data,action_url);
    });

    $("#updateGiderButton").on("click", function() {
        var o_data = 'id=' + $('#ana_gider_id2').val()+'&gider_kalemi='+ $('#ana_gider_name').val();
        var action_url= $('#gider_model #action-url').val();
        addObject(o_data,action_url);
    });

    $(function () {
        $('.select2').select2();
    });

    $(document).on('change', "#tip", function (e) {
        $("#cari_personel option").remove();
        if($(this).val()!=0)
        {
            $('.cari_personel').css('display','flex');
            var tip=$(this).val();
            var url='';
            if(tip==1) //cari
            {
                url='cost/cari_list';
                $.ajax({
                    type: "POST",
                    url: baseurl + url,
                    data:crsf_token+'='+crsf_hash,
                    success: function (data) {
                        if(data)
                        {

                            $('#cari_personel').append($('<option>').val(0).text('Seçiniz'));

                            jQuery.each(jQuery.parseJSON(data), function (key, item) {
                                $("#cari_personel").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                            });
                            //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                        }

                    }
                });
            }
            else if(tip==2)
            {
                url='cost/personel_list';
                $.ajax({
                    type: "POST",
                    url: baseurl + url,
                    data:crsf_token+'='+crsf_hash,
                    success: function (data) {
                        if(data)
                        {

                            $('#cari_personel').append($('<option>').val(0).text('Seçiniz'));

                            jQuery.each(jQuery.parseJSON(data), function (key, item) {
                                $("#cari_personel").append('<option value="'+ item.id +'">'+ item.name+'</option>');
                            });
                            //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                        }

                    }
                });
            }
            else if(tip==3)
            {
                url='cost/invoice_list'
                $.ajax({
                    type: "POST",
                    url: baseurl + url,
                    data:crsf_token+'='+crsf_hash,
                    success: function (data) {
                        if(data)
                        {

                            $('#cari_personel').append($('<option>').val(0).text('İşlem Yapılacak Faturayı Seçiniz'));

                            jQuery.each(jQuery.parseJSON(data), function (key, item) {
                                $("#cari_personel").append('<option value="'+ item.id +'">'+ item.invoice_no+'-'+item.type +'</option>');
                            });
                            //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                        }

                    }
                });
            }
            else if(tip==4)
            {
                url='cost/project_list'
                $.ajax({
                    type: "POST",
                    url: baseurl + url,
                    data:crsf_token+'='+crsf_hash,
                    success: function (data) {
                        if(data)
                        {

                            $('#cari_personel').append($('<option>').val(0).text('İşlem Yapılacak Projeyi Seçiniz'));

                            jQuery.each(jQuery.parseJSON(data), function (key, item) {
                                $("#cari_personel").append('<option value="'+ item.id +'">'+ item.name+'</option>');
                            });
                            //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                        }

                    }
                });
            }


        }
        else
        {
            $('.cari_personel').css('display','none');
        }


    });
    $(document).on('change', "#odeme_durumu", function (e) {
        if($(this).val()!=0)
        {
            $('.odeme_hidd').css('display','flex');
        }
        else
        {
            $('.odeme_hidd').css('display','none');
        }


    });
    $('#kur_al').click(function () {
        var para_birimi=$('#para_birimi').val();
        var invoice_date=$('#islem_date').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/kur_al',
            data:
                'para_birimi='+ para_birimi+
                '&invoice_date='+ invoice_date+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                $('#kur_degeri').val(data);

            }
        });


    });

</script>
<style>

    .panel-heading {
        border-bottom: 1px dotted rgba(0, 0, 0, 0.2);
        padding: 15px;
        text-transform: uppercase;
        color: #535351;
        font-size: 14px;
        font-weight: bold;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    .panel-primary>.panel-heading {
        color: #fff;
        background-color: #337ab7;
        border-color: #337ab7;
    }
    .panel
    {
        border: none;
        margin-bottom: 20px;
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 4px;
        -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
    .box-shadow--16dp {
        box-shadow: 0 16px 24px 2px rgba(0, 0, 0, .14), 0 6px 30px 5px rgba(0, 0, 0, .12), 0 8px 10px -5px rgba(0, 0, 0, .2);
    }
    .panel-body {
        padding: 15px;
    }


</style>

<script>

    $(document).ready(function () {



        $(document).on('change','#proje_id',function (e) {
            $('#asama_id').children('option').remove();
            $('#task_id').children('option').remove();
            $('#bolum_id').children('option').remove();
            var proje_id=$('#proje_id').val();
            $.ajax({
                url: '/projects/proje_bolum_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&pid=' + proje_id,
                success: function (data) {

                    $("#bolum_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#bolum_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                    });
                }
            });
        });

        $(document).on('change','#bolum_id',function (e) {
            $('#asama_id').children('option').remove();
            $('#task_id').children('option').remove();
            var bolum_id=$(this).val();
            var proje_id=$('#proje_id').val();
            $.ajax({
                url: '/projects/proje_asamalari_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&bolum_id=' + bolum_id+'&proje_id=' + proje_id,
                success: function (data) {

                    $("#asama_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {


                        $("#asama_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                    });
                }
            });
        });

        $(document).on('change','#asama_id',function (e) {
            $('#task_id').children('option').remove();
            var asama_id=$(this).val();
            var proje_id=$('#proje_id').val();
            $.ajax({
                url: '/projects/proje_is_kalemleri_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&asama_id=' + asama_id +'&proje_id=' + proje_id,
                success: function (data) {
                    $("#task_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#task_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');


                    });
                }
            });
        });
    })
</script>


