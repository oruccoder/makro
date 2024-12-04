<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 11.02.2020
 * Time: 17:26
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

            <div class="col-xl-12 col-lg-12 col-xs-12">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-xs-12">
                        <section class="panel panel-primary box-shadow--16dp">
                            <header class="panel-heading">
                                <a style="color: white"><?php echo $this->lang->line('dosya_detaylari') ?></a>
                            </header>
                            <div class="panel-body">

                                <input type="hidden" value="<?php echo $invoices->id;?>" name="ihracat_id">


                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label" for="name"><?php echo $this->lang->line('dosya_no') ?></label>
                                        <div class="col-sm-12">
                                            <input type="text" disabled class="form-control" name="dosya_no" id="dosya_no" value="<?php echo $invoices->dosya_no ?>" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label" for="name"><?php echo $this->lang->line('Customer') ?></label>
                                        <div class="col-sm-12">
                                            <input type="text" disabled class="form-control"  value="<?php echo $invoices->cari_unvan ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label" for="name"><?php echo $this->lang->line('baslama_tarihi') ?></label>
                                        <div class="col-sm-12">
                                            <input type="text" disabled class="form-control" name="baslama_tarihi" value="<?php echo dateformat($invoices->baslangic_tarihi) ?>" id="baslama_tarihi">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label" for="name"><?php echo $this->lang->line('bitis_tarihi') ?></label>
                                        <div class="col-sm-12">
                                            <input type="text" disabled class="form-control"  value="<?php echo dateformat($invoices->bitis_tarihi) ?>" name="bitis_tarihi" id="bitis_tarihi">
                                        </div>
                                    </div>
                                </div>




                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label" for="name">Açıklama</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" disabled name="description"><?php echo $invoices->description ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                         <label class="col-sm-12 col-form-label" for="name"><?php echo $this->lang->line('gumrukcu_cari') ?></label>
                                        <div class="col-sm-12">
                                            <input type="text" disabled class="form-control"  value="<?php echo $invoices->gumrukcu_firma_unvan ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="card-content">
                                    <div class="card-body">
                                        <nav>
                                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="base-tab1" data-toggle="tab"
                                                       aria-controls="tab1" href="#tab1_id" role="tab"
                                                       aria-selected="true"><?php echo $this->lang->line('stok_kayitlari') ?></a>

                                                    <a class="nav-item nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                                       href="#tab2_id" role="tab"
                                                       aria-selected="false"><?php echo $this->lang->line('gider_kayitlari') ?></a>
                                                    <a class="nav-item nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                                       href="#tab3_id" role="tab"
                                                       aria-selected="false"><?php echo $this->lang->line('gumrukcu_odeme_tahsilat')?></a>
                                                    <a class="nav-item nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                                       href="#tab4_id" role="tab"
                                                       aria-selected="false"><?php echo $this->lang->line('gider_dagilimi')?></a>

                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div role="tabpanel" class="tab-pane fade show active" id="tab1_id" aria-labelledby="base-tab1" aria-expanded="true">
                                                <div class="form-group row mt-1">
                                                    <div class="col-md-12">

                                                        <table id="stoklar" class="table table-striped table-bordered zero-configuration"
                                                               cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                                <th><?php echo $this->lang->line('Product Code') ?></th>
                                                                <th><?php echo $this->lang->line('Product Name') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('unit') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('Qty') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('Rate') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('tutar') ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>

                                                            <?php



                                                            if(ihracat_urunleri($invoices->id))
                                                            {
                                                                foreach (ihracat_urunleri($invoices->id) as $ih_prd)
                                                                {
                                                                    ?>
                                                                    <tr>

                                                                        <td><?php echo dateformat($ih_prd->invoicedate) ?></td>
                                                                        <td><?php echo $ih_prd->code ?></td>
                                                                        <td><?php echo $ih_prd->product ?></td>
                                                                        <td><?php echo product_unit($ih_prd->pid )?></td>
                                                                        <td><?php echo round($ih_prd->qty,2) ?></td>
                                                                        <td><?php echo amountFormat($ih_prd->price*$ih_prd->kur_degeri)?></td>
                                                                        <td><?php echo amountFormat($ih_prd->subtotal*$ih_prd->kur_degeri) ?></td>

                                                                    </tr>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" value="<?php echo $invoices->id ?>" id="invoices_id" >
                                            <input type="hidden" value="<?php echo $invoices->gumrukcu_firma_id ?>" id="gumrukcu_firma_id" >
                                            <div role="tabpanel" class="tab-pane" id="tab2_id" aria-labelledby="base-tab2">
                                                <div class="form-group row mt-1">
                                                    <div class="col-md-12">

                                                        <table id="ihracat_giderleri" class="table table-striped table-bordered zero-configuration"
                                                               cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                                <th><?php echo $this->lang->line('masraf_name') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('tutar') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('Description') ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>

                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>

                                                            </tr>
                                                            </tfoot>


                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab3_id" aria-labelledby="base-tab3" >
                                                <div class="form-group row mt-1">
                                                    <div class="col-md-12">

                                                        <table id="gumrukcu_giderleri" class="table table-striped table-bordered zero-configuration"
                                                               cellspacing="0" width="100%">
                                                            <thead>
                                                            <tr>
                                                                <th><?php echo $this->lang->line('Date') ?></th>
                                                                <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                                <th><?php echo $this->lang->line('Invoice Number') ?></th>
                                                                <th><?php echo $this->lang->line('payment_type') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                                <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>

                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>

                                                            </tr>
                                                            </tfoot>



                                                        </table>

                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="tab4_id" aria-labelledby="base-tab4" >
                                                <form method="post" id="data_form" class="form-horizontal">
                                                    <div class="form-group row mt-1">
                                                        <label class="col-sm-2 col-form-label"
                                                               for="dagitim_sekli">Dağıtım Şekli</label>
                                                        <div class="col-sm-3">
                                                            <select class="form-control" id="dagitim_sekli">
                                                                <?php $dagitim_sekli=dagitim_sekli($invoices->id );
                                                                if($dagitim_sekli!=0)
                                                                {
                                                                    if($dagitim_sekli==1)
                                                                    {
                                                                        ?>
                                                                        <option selected value="1">Manuel</option>
                                                                        <option value="2">Fiyata Göre</option>
                                                                        <?php
                                                                    }
                                                                    else
                                                                        {
                                                                            ?>
                                                                            <option  value="1">Manuel</option>
                                                                            <option selected value="2">Fiyata Göre</option>
                                                                            <?php
                                                                        }
                                                                    ?>

                                                                    <?php
                                                                }
                                                                else
                                                                    {
                                                                        ?>
                                                                        <option  value="1">Manuel</option>
                                                                        <option  value="2">Fiyata Göre</option>
                                                                        <?php
                                                                    }
                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <button type="submit" id="submit-data" class="btn btn-success margin-bottom">Dağıtımı Yap</button>
                                                            <input type="hidden" value="ihracat/action_gider_dagitim" id="action-url">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label class="col-sm-12 col-form-label"
                                                                   for="toplam_gider" id="toplam_gider_lab"></label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mt-1">
                                                        <div class="col-md-12">

                                                            <table id="gider_stok" class="table table-striped table-bordered zero-configuration"
                                                                   cellspacing="0" width="100%">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th><?php echo $this->lang->line('Product Code') ?></th>
                                                                    <th><?php echo $this->lang->line('Product Name') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('unit') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('doviz_cinsi') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('Qty') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('dagilim_sekli') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('oran') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('dag_birim_fiyati') ?></th>
                                                                    <th class="no-sort"><?php echo $this->lang->line('dag_fiyati') ?></th>
                                                                </tr>
                                                                </thead>
                                                                <?php

                                                                if(ihracat_urunleri($ihracat_id))
                                                                {
                                                                    $oran=0;
                                                                    $dag_birim_fiy=0;
                                                                    $dag_tutar_azn=0;
                                                                    $i=0;
                                                                    $toplam_azn_price=0;
                                                                    $toplam_qunatiy=0;
                                                                    $readonly='';
                                                                    foreach (ihracat_urunleri($ihracat_id) as $ih_prd)
                                                                    {
                                                                        if(ihracat_maliyet_dagitim($ihracat_id)!=0)
                                                                        {
                                                                           if(maliyet_dagilim_ogren($ihracat_id,$ih_prd->pid)!=0)
                                                                           {
                                                                               $oran=maliyet_dagilim_ogren($ihracat_id,$ih_prd->pid)['dagilim_oran'];
                                                                               $dag_birim_fiy=maliyet_dagilim_ogren($ihracat_id,$ih_prd->pid)['birim_fiyati_maliyeti'];
                                                                               $dag_tutar_azn=maliyet_dagilim_ogren($ihracat_id,$ih_prd->pid)['toplam_tutar_maliyeti'];

                                                                               $readonly="readonly='true'";

                                                                           }
                                                                        }
                                                                        $i++;

                                                                        ?>
                                                                        <tr>

                                                                            <td><?php echo $i; ?></td>
                                                                            <td><?php echo $ih_prd->code ?></td>
                                                                            <td><?php echo $ih_prd->product ?></td>
                                                                            <td><?php echo product_unit($ih_prd->pid )?></td>
                                                                            <td><?php echo para_birimi_id($ih_prd->para_birimi)['code']; ?></td>

                                                                            <td><?php echo round($ih_prd->qty,2) ?></td>
                                                                            <td><input class="form-control dagilim_sekli" quantitiy="<?php echo $ih_prd->qty;?>" b_price="<?php echo $ih_prd->price*$ih_prd->kur_degeri;?>" price="<?php echo $ih_prd->subtotal*$ih_prd->kur_degeri;?>" value="Manuel" readonly="true" product_id="<?php echo $ih_prd->pid;?>" id="dagilim_sekli-<?php echo $ih_prd->pid;?>" name="dagilim_sekli[]"></td>
                                                                            <td><input class="form-control dagilim_oran" id="dagilim_oran-<?php echo $ih_prd->pid;?>" <?php echo $readonly;?> value="<?php echo $oran; ?>" name="dagilim_oran[]"></td>
                                                                            <td><input class="form-control birim_fiyati"  id="birim_fiyati-<?php echo $ih_prd->pid;?>" value="<?php echo $dag_birim_fiy;?>" readonly="true" name="birim_fiyati[]"></td>
                                                                            <td><input class="form-control tutar" id="tutar-<?php echo $ih_prd->pid;?>" readonly="true" value="<?php echo $dag_tutar_azn;?>" name="tutar[]"></td>


                                                                            <input type="hidden" name="product_id[]"  value="<?php echo $ih_prd->pid;?>">
                                                                            <input type="hidden" name="quantity[]"  value="<?php echo $ih_prd->qty;?>">
                                                                            <input type="hidden" name="alis_fiyati[]"  value="<?php echo $ih_prd->price*$ih_prd->kur_degeri;?>">
                                                                        </tr>


                                                                        <?php
                                                                        $toplam_azn_price+=$ih_prd->subtotal*$ih_prd->kur_degeri;
                                                                        $toplam_qunatiy+=$ih_prd->qty;
                                                                        ?>


                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <input type="hidden" name="toplam_azn_price" id="toplam_azn_price" value="<?php echo $toplam_azn_price;?>">
                                                                    <input type="hidden" name="ihracat_id"  value="<?php echo $ihracat_id;?>">
                                                                    <input type="hidden" name="toplam_quantitiy" id="toplam_quantitiy" value="<?php echo round($toplam_qunatiy,2);?>">
                                                                    <input type="hidden" name="toplam_gider" id="toplam_gider" value="<?php echo ihracat_toplam_gider($ihracat_id);?>">
                                                                    <?php
                                                                }
                                                                ?>


                                                            </table>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
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

    $(document).on('keyup','.dagilim_oran',function (e) {

        var toplam_gider=$('#toplam_gider').val();
        $('#toplam_gider_lab').text('Toplam Gider : '+currencyFormat(parseFloat(toplam_gider)));
        var urun_sayisi=$('.dagilim_sekli').length;
        var orant_top=0;
        var p = $(this).parent().parent();
        var ind = $(p).index();

        console.log(ind);
        for(var i=0; i<urun_sayisi;i++)
        {
            var product_id=$('.dagilim_sekli').eq(i).attr('product_id');
            var orans=$('#dagilim_oran-'+product_id).val();
            orant_top=parseFloat(orant_top)+parseFloat(orans);

        }

        if(orant_top>100)
        {
            alert('Oranları Eşitlemeniz gerekmektedir');
            $(this).val(0)
            $('.tutar').eq(ind).val(0);

        }

        var oran=$(this).val();

        var product_q=$('.dagilim_sekli').eq(ind).attr('quantitiy');
        var dag_tutar=(toplam_gider/100)*oran;

        var b_dag=dag_tutar/product_q;

        $('.dagilim_oran').eq(ind).val(oran);
        $('.birim_fiyati').eq(ind).val(b_dag.toFixed(3));
        $('.tutar').eq(ind).val(dag_tutar.toFixed(3));

    });

    $(document).on('change','#dagitim_sekli',function (e) {

        if($(this).val()==1)
        {
            $('.dagilim_sekli').attr('readonly',true);
            $('.dagilim_oran').attr('readonly',false);
            $('.birim_fiyati').attr('readonly',true);
            $('.tutar').attr('readonly',true);


            var urun_sayisi=$('.dagilim_sekli').length;

            for(var i=0; i<urun_sayisi;i++)
            {

                var product_price=$('.dagilim_sekli').eq(i).attr('price');
                var b_price=$('.dagilim_sekli').eq(i).attr('b_price');
                var product_id=$('.dagilim_sekli').eq(i).attr('product_id');
                var dag_tutar=carpan*product_price;
                var dag_b_tutar=carpan*b_price;
                var dag_oran=(dag_tutar/toplam_gider)*100;
                $('#tutar-'+product_id).val(0);
                $('#birim_fiyati-'+product_id).val(0);
                $('#dagilim_sekli-'+product_id).val('Manuel');
                $('#dagilim_oran-'+product_id).val(0);
            }







        }
        else if($(this).val()==2)
        {

            $('.dagilim_sekli').attr('readonly',true);
            $('.dagilim_oran').attr('readonly',true);
            $('.birim_fiyati').attr('readonly',true);
            $('.tutar').attr('readonly',true);

            var toplam_azn_price=$('#toplam_azn_price').val();
            var toplam_gider=$('#toplam_gider').val();

            $('#toplam_gider_lab').text('Toplam Gider : '+currencyFormat(parseFloat(toplam_gider)));

            var carpan=toplam_gider/toplam_azn_price;


            var urun_sayisi=$('.dagilim_sekli').length;

            for(var i=0; i<urun_sayisi;i++)
            {

                var product_price=$('.dagilim_sekli').eq(i).attr('price');
                var b_price=$('.dagilim_sekli').eq(i).attr('b_price');
                var product_id=$('.dagilim_sekli').eq(i).attr('product_id');
                var dag_tutar=carpan*product_price;
                var dag_b_tutar=carpan*b_price;
                var dag_oran=(dag_tutar/toplam_gider)*100;
                $('#tutar-'+product_id).val(dag_tutar.toFixed(3));
                $('#birim_fiyati-'+product_id).val(dag_b_tutar.toFixed(3));
                $('#dagilim_sekli-'+product_id).val('Fiyata Göre');
                $('#dagilim_oran-'+product_id).val(dag_oran.toFixed(3));

            }

        }

});


    function currencyFormat(num) {

        var deger=num.toFixed(3).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }


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
    $(document).ready(function() {

        var ihracat_id=$('#invoices_id').val();
        var gumrukcu_firma_id=$('#gumrukcu_firma_id').val();

        $('#ihracat_giderleri').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('ihracat/ajax_ihracat_giderleri')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    ihracat_id: ihracat_id,
                    gumrukcu_firma_id: gumrukcu_firma_id
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '14pt')

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ], "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages

                total_alt = api
                    .column( 3 ,{ page: 'current'})
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );


                var total_alt =currencyFormat(floatVal(total_alt.toFixed(2)));

                $(api.column(3).footer()).html(total_alt);
            }
        });

        $('#gumrukcu_giderleri').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('ihracat/ajax_gumrukcu_giderleri')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    ihracat_id: ihracat_id,
                    gumrukcu_firma_id: gumrukcu_firma_id
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    },
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '14pt')

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ], "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '') / 100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages

                borc = api
                    .column( 4 ,{ page: 'current'})
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                    alacak = api
                        .column( 5 ,{ page: 'current'})
                        .data()
                        .reduce( function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0 );


                var bakiye = floatVal(borc)-floatVal(alacak);
                var string='';
                if(floatVal(borc)>floatVal(alacak))
                {

                    string='(B)';
                }
                else
                {
                    string='(A)'
                }

                var borc =currencyFormat(floatVal(borc.toFixed(2)));
                var alacak =currencyFormat(floatVal(alacak.toFixed(2)));
                var bakiyes =currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(4).footer()).html(borc);
                $(api.column(5).footer()).html(alacak);
                $( api.column( 6 ).footer() ).html(bakiyes+' '+string);
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

