<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 11.02.2020
 * Time: 16:15
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
                                <a style="color: white"><?php echo $this->lang->line('dosya_detaylari') ?></a>
                            </header>


                            <div class="panel-body form-horizontal">


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('dosya_no') ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="dosya_no" id="dosya_no" value="<?php echo numaric(6);?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Proje Adı</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="proje_id">
                                            <option value="0">Proje Seçiniz</option>
                                            <?php foreach (all_projects() as $prj)
                                            {
                                                echo "<option value='$prj->id'>$prj->name</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('baslama_tarihi') ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control required" name="baslama_tarihi" id="baslama_tarihi"
                                               data-toggle="datepicker"
                                               autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('bitis_tarihi') ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bitis_tarihi" id="bitis_tarihi"
                                               data-toggle="datepicker"
                                               autocomplete="false">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">Açıklama</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name">İhale Şekli</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="ihale_sekli" id="ihale_sekli">
                                            <option value="0">Seçiniz</option>
                                            <?php
                                            foreach (ihale_tipi() as $clist) {

                                                ?>
                                                <option value="<?php echo $clist->id ?>"><?php echo $clist->name ?></option>


                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label" for="name"><?php echo $this->lang->line('Status') ?></label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status" id="status">
                                            <option value="0">Kapalı</option>
                                            <option value="1">Açık</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row odeme_hidd"  style="display: none;">
                                    <label class="col-sm-4 col-form-label" for="name">Ödeme Tarihi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control required" name="odeme_tarihi" id="odeme_tarihi"
                                               data-toggle="datepicker"
                                               autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd" style="display: none;">
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
                                                        $balance=amountFormat(hesap_balance($cid));
                                                        echo "<option value='$cid'>$holder ($balance)</option>";
                                                    }


                                                }
                                                echo "</optgroup>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd" style="display: none;">

                                    <label class="col-sm-4 col-form-label"
                                           for="invoice_para_birimi"><?php echo $this->lang->line('odeme_para_birimi') ?></label>

                                    <div class="col-sm-7">
                                        <select name="para_birimi" id="para_birimi" class="form-control">
                                            <?php
                                            foreach (para_birimi()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['code'];
                                                echo "<option value='$title'>$title</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row odeme_hidd" style="display: none;">

                                    <label class="col-sm-4 col-form-label"
                                           for="invoice_kur_degeri"><?php echo $this->lang->line('invoice_kur_degeri') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control " placeholder="Kur"
                                               name="kur_degeri" id="kur_degeri" value="1">
                                    </div>
                                    <div class="col-sm-4">
                                        <a style="color: #fff;" class="btn btn-success kur" id="kur_al"><?php echo $this->lang->line('online_button') ?></a>
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd" style="display: none;">
                                    <label class="col-sm-4 col-form-label" for="name">Tutar (KDV Dahil)</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="tutar" id="tutar" >
                                    </div>
                                </div>
                                <div class="form-group row odeme_hidd" style="display: none;">
                                    <label class="col-sm-4 col-form-label" for="name">KDV Oranı</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="kdv_orani" id="kdv_orani" >
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-2 col-form-label"></label>

                                    <div class="col-sm-12">
                                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                               value="<?php echo $this->lang->line('Add transaction') ?>" data-loading-text="Adding...">
                                        <input type="hidden" value="ihale/action" id="action-url">
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


        }
        else
        {
            $('.cari_personel').css('display','none');
        }


    });
    $(document).on('change', "#status", function (e) {
        if($(this).val()==0)
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
