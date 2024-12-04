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
                                <!--div class="col-sm-6">
                                    <label class="col-sm-12 col-form-label" for="name">Cariler</label>
                                    <div class="col-sm-12">
                                    <?php $i=1; foreach (ihale_to_customer($invoices->id) as $cari_name){
                                        echo "<p id='$cari_name->id' style='background-color: #edeff1;' class='form-control'>$i - $cari_name->company&nbsp;&nbsp;<a href='#' data-object-id='$cari_name->id' class='btn btn-danger btn-sm delete-cari'><span class='fa fa-trash'></span></a></p>";
                                    $i++;
                                    }
                                    ?>
                                    </div>
                                </-->
                                <div class="col-sm-6">
                                    <label class="col-sm-12 col-form-label" for="name">İhale Şekli</label>
                                    <div class="col-sm-12">
                                        <input type="text" disabled class="form-control"  value="<?php echo ihale_tipi_ogren($invoices->ihale_sekli)?>">
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
                                    <label class="col-sm-12 col-form-label" for="name">Proje</label>
                                    <div class="col-sm-12">
                                        <input class="form-control" disabled name="proje_name" value="<?php echo proje_name($invoices->proje_id) ?>">
                                    </div>

                            </div>
                            <div class="col-sm-12">
                                <label class="col-sm-12 col-form-label" for="name">Malzame Talep Formları</label>
                                <div class="col-sm-12">
<?php echo $href; ?>
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
                                               aria-selected="true">Stok Getir</a>

                                            <a class="nav-item nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                               href="#tab2_id" role="tab"
                                               aria-selected="false">İhale Durumu</a>



                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div role="tabpanel" class="tab-pane fade show active" id="tab1_id" aria-labelledby="base-tab1" aria-expanded="true">
                                            <input type="hidden" value="0" name="counter" id="ganak">

                                            <input type="hidden" value="0" id="gumrukcu_firma_id" >
                                            <div class="form-group row mt-1">
                                                <div class="col-md-12">


                                                    <div id="saman-row" class="">
                                                        <form method="post" id="data_form">
                                                            <div class="form-group row mt-1">
                                                                <label class="col-sm-2 col-form-label" for="dagitim_sekli">Malzeme Talep F.</label>
                                                                <div class="col-sm-4">
                                                                    <select class="form-control select2" id="malzeme_talep_listesi" multiple name="malzeme_talep_foru[]">
                                                                        <?php foreach (talep_list_proje(1,$invoices->proje_id) as $talep)
                                                                        {
                                                                            $id=$talep['id'];
                                                                            $talep_no=$talep['talep_no'];
                                                                            echo "<option value='$id'>$talep_no</option>";
                                                                        }

                                                                        ?>

                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <button type="button" id="urunleri_getir" class="btn btn-success margin-bottom">Ürünleri Getir</button>
                                                                </div>

                                                            </div>
                                                            <table class="table table-responsive tfr my_stripe">
                                                            <thead>
                                                            <tr class="item_header bg-gradient-directional-blue white">
                                                                <th width="20%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                                                <th width="10%" class="text-center">Ürün Bilgileri</th>
                                                                <th width="10%" class="text-center">Marka</th>
                                                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                                                <th width="5%" class="text-center">Birim</th>
                                                                <th width="30%" class="text-center">Firma</th>
                                                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                                            </tr>


                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td><input type="text" class="form-control" name="product_name[]" id="product_name-0"
                                                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                                                </td>
                                                                <td><input type="text" class="form-control" name="product_detail[]" id="product_detail-0"
                                                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                                                </td>
                                                                <td><input type="text" class="form-control" name="marka[]" id="marka-0"
                                                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                                                </td>

                                                                <td>
                                                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" name="unit[]" id="unit-0"
                                                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                                                </td>

                                                                <td>
                                                                   <select class="form-control select2" multiple name="firma[0][]">
                                                                       <option value="0">Seçiniz</option>
                                                                       <?php    foreach ($customer as $clist) {

                                                                           ?>
                                                                           <option value="<?php echo $clist->id ?>"><?php echo $clist->company ?></option>


                                                                       <?php } ?>
                                                                   </select>
                                                                </td>

                                                                <td class="text-center">
                                                                    <button type="hidden" class="removeProd"></button>
                                                                </td>
                                                            </tr>


                                                            <tr class="last-item-row sub_c" style="width: 100%;">
                                                                <td class="add-row" style="width: 50%;">
                                                                    <button type="button" class="btn btn-success" aria-label="Left Align" id="addproduct_talep">
                                                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                                                    </button>
                                                                </td>

                                                                <td align="right" colspan="12" style="width: 50%;">
                                                                    <input type="hidden" name="tip"  value="">
                                                                    <div style="display: flex;justify-content: flex-end;align-items: center;align-content: center;flex-direction: row;">
                                                                        <div class="mr-2">
                                                                            <div class="form-check">
                                                                            <input class="form-check-input send_smsm" type="checkbox" id="send-sms" name="send-sms" checked>
                                                                                <label class="form-check-label" for="defaultCheck1">
                                                                                    Sms Gönder
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <input type="submit" class="btn btn-success sub-btn btn-lg" value="Teklif İste" id="submit-data-ihale" data-loading-text="Creating...">
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                            </tr>


                                                            </tbody>
                                                        </table>
                                                            <input type="hidden" value="ihale/stok_kayit" id="action-url">
                                                            <input type="hidden" value="<?php echo $invoices->id ?>" name="talep_id" id="talep_id" >
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div role="tabpanel" class="tab-pane" id="tab2_id" aria-labelledby="base-tab2">
                                            <div class="form-group row mt-1">
                                                <div class="col-md-12" style="display: block;width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;-ms-overflow-style: -ms-autohiding-scrollbar;">
                                                    <table id="ihale_durumu" class="table table-striped table-bordered zero-configuration" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Firma Adı aaa</th>
                                                                <th>Adres</th>
                                                                <th class="no-sort">Telefon</th>
                                                                <th class="no-sort">Esas Meblağ</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th>Ortalama</th>
                                                                <th><?php echo $ortalama;?></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
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

<!-- <div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Stok Sil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p>İhale dosyasından ürünü silmek istediğinize emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="ihale/delete_stok">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div> -->

<div id="delete_cari" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Cari Sil</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p>İhale dosyasından cariyi silmek istediğinize emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id-cari" value="">
                <input type="hidden" id="action-url-cari" value="ihale/delete_cari">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm-cari"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="teklif_iste" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Tekrar Teklif İste</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_teklif" method="post">
                    <p>Tekrar Teklif istediğinizden emin misiniz? Farklı Firmaların Ürünlerini Seçmediğinize Emin Olunuz!</p>
                    <input type="hidden" name="mesaj" class="form-control" placeholder="Örn:Merhaba fiyatlarınızda indirim yapmanızı rica edeceğiz">
                    <input name="id_array" id="id_array" type="hidden">
                    <input name="ihale_id" id="ihale_id" type="hidden" value="<?php echo $_GET['id']?>">
                    <input name="firma_id" id="firma_id" type="hidden"">

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden"  id="action-url" value="ihale/tekrar_teklif_iste">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_t_teklif">Onayla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#stoklar').on('click', '.removeProd', function () {
        $(this).closest('tr').remove();
    });

    $(document).on('click', "#submit_model_t_teklif", function (e) {

        var o_data =  $("#form_model_teklif").serialize();
        var action_url= $('#form_model_teklif #action-url').val();
        $("#teklif_iste").modal('hide');
        saveMDataa(o_data,action_url);
    });

    $("#delete-confirm-cari").on("click", function() {
        var o_data = 'deleteid=' + $('#object-id-cari').val();
        var action_url= $('#delete_cari #action-url-cari').val();

        removeObjectCari(o_data,action_url);
    });

    function saveMDataa(o_data,action_url) {
        var errorNum = farmCheck();
        if (errorNum > 0) {
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("#notify .message").html("<strong>Hata</strong>");
            $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
        } else {
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {


                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $('#pstatus').html(data.pstatus);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            });
        }
    }

    function removeObjectCari(action,action_url) {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: action+'&'+crsf_token+'='+crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {

                    $('#'+$('#object-id-cari').val()).remove();
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

    $(document).on('click', ".delete-cari", function (e) {


        $('#object-id-cari').val($(this).attr('data-object-id'));

        document.cookie = "invoice_id="+$('#object-id-object-id-cari').val();
        $(this).closest('tr').attr('id',$(this).attr('data-object-id'));
        $('#delete_cari').modal({backdrop: 'static', keyboard: false});

    });


    var table;
    $(function () {
        $('.select2').select2();
        $('.details-control').text('')
        draw_data();

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

        var cvalue = parseInt($('#ganak').val()) + 1;

        row = cvalue;
        $('#product_name-0').autocomplete({
            source: function (request, response) {

                var proje_id=$('#proje_id').val()
                var invoice_type=0;
                var bolum_id=$('#bolum_id_val-0').val()
                var asama_id=$('#asama_id_val-0').val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-0').val();
                url=''

                url="search_products/malzeme_talep_search_stok";

                $.ajax({
                    url: baseurl + url,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&' + d_csrf,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var product_d = item[0];
                            return {
                                label: product_d,
                                value: product_d,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                id = 0;
                var discount = ui.item.data[4];
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];
                var qty=ui.item.data[8];
                var unit_id=ui.item.data[9];


                $('#product_qty-0').val(qty);
                $('#pid-0').val(pid);
                $('#dpid-0').val(dpid);
                $('#unit-0').val(unit_id);
                $('#hsn-0').val(hsn);
                $('#alert-0').val(alert);
                $('#unit_id-0').val(unit_id);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        var ihracat_id=$('#talep_id').val();
        var gumrukcu_firma_id=0;



        $('#gumrukcu_giderleri2').DataTable({
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

    $('#addproduct_talep').on('click', function () {

        if($('#para_birimi').val())
        {
            var currencys=$('#para_birimi').val();
        }
        else
        {

        }



        var cvalue = parseInt($('#ganak').val())+1;
        var invoice_type=$("#invoice_type").val();
        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;


//product row
        var data = ` <tr>
                                <td><input type="text" class="form-control" name="product_name[]" id="product_name-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                      <td><input type="text" class="form-control" name="product_detail[]" id="product_detail-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">
                                </td>
                                      <td><input type="text" class="form-control" name="marka[]" id="marka-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('enter product name requested') ?>">



                                <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-`+cvalue+`"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]"  id="unit-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>
                                <td>
                                <input name='product_index[]' value='`+cvalue+`' type='hidden'>
                                     <select class="form-control select2" name="firma[`+cvalue+`][]"  multiple id="firma-`+cvalue+`">
                                       <option value="0">Seçiniz</option>
                                       <?php    foreach ($customer as $clist) {

                                             ?>
                                           <option value="<?php echo $clist->id ?>"><?php echo $clist->company ?></option>


                                       <?php } ?>
                                   </select>
                                </td>


                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);

        $('.select2').select2();


        row = cvalue;
        $('#product_name-' + cvalue).autocomplete({
            source: function (request, response) {

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                var asama_id=$('#asama_id_val-'+cvalue).val()
                var bagli_oldugu_asama=$('#bagli_oldugu_asama_id_val-'+cvalue).val();
                url=''

                url="search_products/malzeme_talep_search_stok";

                $.ajax({
                    url: baseurl + url,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&bagli_oldugu_asama=' + bagli_oldugu_asama+ '&' + d_csrf,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var product_d = item[0];
                            return {
                                label: product_d,
                                value: product_d,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                id = 0;
                var discount = ui.item.data[4];
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];
                var qty=ui.item.data[8];
                var unit_id=ui.item.data[9];

                $('#amount-'+cvalue).val(1);
                $('#qiymet-'+cvalue).val(price);
                $('#product_qty-'+cvalue).val(qty);
                $('#pid-'+cvalue).val(pid);
                $('#discount-'+cvalue).val(discount);
                $('#dpid-'+cvalue).val(dpid);
                $('#unit-'+cvalue).val(unit_id);
                $('#hsn-'+cvalue).val(hsn);
                $('#alert-'+cvalue).val(alert);
                $('#unit_id-'+cvalue).val(unit_id);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });


    });



    $('#urunleri_getir').click(function () {

        $('#loading-box').removeClass('d-none');
        var array = [];
        $("#malzeme_talep_listesi :selected").map(function(i, el) {
            array.push($(el).val());
        }).get();
        $('.removeProd').closest('tr').remove();
        var cvalue=0;

        $.ajax({
            type: "POST",
            url: baseurl + 'ihale/ajax_talep_formlari',
            data:
                'malzeme_talep_id='+ array+
                '&'+crsf_token+'='+crsf_hash,
             success: function (data) {

                 let line='';
                 let responses = jQuery.parseJSON(data);

                 if(responses.status=='Success'){
                     responses.item.forEach((v,k) => {
                         $('#ganak').val(k);

                         var product_id = v['product_id'];
                         var product_name = v['product_name'];
                         var details = v['product_detail'];
                         var qty = v['qty'];
                         var unit = v['unit'];

                         line+= ` <tr>
                                <td><input type="hidden" name="product_id[]" value=`+product_id+`><input type="text" class="form-control" id="product_name-`+cvalue+`" name="product_name[]" value="`+product_name+`">
                                </td>
                                <td><input type="text" class="form-control" id="product_detail-`+cvalue+`" name="product_detail[]" value="`+details+`">
                                </td>
                                 <td><input type="text" class="form-control" id="marka-`+cvalue+`" name="marka[]" value="">
                                </td>
                                 </td>

                               <td>
                                    <input type="text" class="form-control req amnt" name="product_qty[]" id="amount-`+cvalue+`"
                                            value=`+qty+`><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td>
                                    <input type="text" class="form-control" name="unit[]" value=`+unit+`  id="unit-`+cvalue+`"
                                           placeholder="<?php echo $this->lang->line('Measurement Unit') ?>">
                                </td>

                                  <td>
                                    <input name='product_index[]' value='`+cvalue+`' type='hidden'>
                                     <select class="form-control select2" name="firma[`+cvalue+`][]" multiple id="firma-`+cvalue+`">
                                       <option value="0">Seçiniz</option>
                                       <?php    foreach ($customer as $clist) {

                         ?>
                                           <option value="<?php echo $clist->id ?>"><?php echo $clist->company ?></option>


                                       <?php } ?>
                                   </select>
                                </td>

                                 <td class="text-center"><button type="button" data-rowid="`+ cvalue + `" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td>
                            </tr>`;
                         //ajax request
                         // $('#saman-row').append(data);
                         cvalue=cvalue+1;



                     });
                     $('tr.last-item-row').before(line);
                     $('.select2').select2();
                     $('#loading-box').addClass('d-none');

                 }
                 else {
                     $.alert({
                         theme: 'modern',
                         icon: 'fa fa-exclamation',
                         type: 'red',
                         animation: 'scale',
                         useBootstrap: true,
                         columnClass: "small",
                         title: 'Dikkat!',
                         content: 'Zaman Aşımına Uğradı. Tekrar Deneyiniz!',
                         buttons:{
                             prev: {
                                 text: 'Tamam',
                                 btnClass: "btn btn-link text-dark",
                             }
                         }
                     });
                     $('#loading-box').addClass('d-none');
                 }






            }
        });




    });

    function draw_data(start_date = '', end_date = '') {
        table = $('#ihale_durumu').DataTable({
            'autoWidth': false,
            'responsive': false,
            'processing': true,
            'serverSide': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('ihale/ajax_list_firmalar')?>",
                'type': 'POST',
                'data': {
                    'start_date': start_date,
                    'dosya_id':'<?php echo $_GET['id'] ?>',
                    'end_date': end_date
                }
            },
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": true, //set not orderable
                    'className':'details-control',
                    render  : function( row, type, full, meta ) {
                        $('.details-control').text('')
                        return meta.row;
                    }

                },
            ],
            "dom": 'Blfrtip',
            buttons: [
                /*{
                    extend: 'excelHtml5',
                    action : function( e, dt, button, config ) {
                        exportTableToCSV.apply(this, [$('#crtstable'), 'export.xls']);

                    }
                },*/
                {
                    extend: 'print',
                    text: 'PDF',
                    action: function ( e, dt, button, config ) {
                        dt_print( e, dt, button, config, true )
                    },
                },

                {

                    extend: 'print',
                    action: function ( e, dt, button, config ) {
                        dt_print( e, dt, button, config, true )
                    },
                    exportOptions: {
                        columns: [0,1, 2,3, 4,5]
                    }
                },
            ],
        });








    };

    $('#ihale_durumu tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        var eq= row.index();
        var item_id = $('.item_id').eq(eq).val();
        var dosya_id = $('.dosya_id').eq(eq).val();
        var result;
        jQuery.ajax({
            url:'/ihale/ihale_item_stok',
            type: 'POST',
            data: {
                'item_id':item_id,
                'ihale_id':dosya_id,
            },
            dataType: 'json',
            success: function (data) {
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( siparis_format(data) ).show();
                    tr.addClass('shown');

                }
            }
        });


    } );

    $(document).on('click', "#id_aktar_btn", function (e) {
        var array = [];

        $(".ihale_items_firma_id:checked").map(function(){
            array.push($(this).val());
        });

        $('#id_array').val(array);
        $('#firma_id').val($(".ihale_items_firma_id:checked").eq(0).attr('firma_id'));

    });
    function totalUpdate(){
        var type_1 = 0;
        var type_2 = 0;
        var type_3 = 0;
        var type_4 = 0;
        $('.edit-price-row').each(function(){
            var type = parseFloat($(this).attr('data-type'));
            var text = $(this).text().replace(',','.').replace(' AZN','');
            if(type == 1){
                type_1 = parseFloat(text) + parseFloat(type_1);
            } else if(type == 2){
                type_2 = parseFloat(text) + parseFloat(type_2);
            } else if(type == 3){
                type_3 = parseFloat(text) + parseFloat(type_3);
            } else if(type == 4){
                type_4 = parseFloat(text) + parseFloat(type_4);
            }
        });
        $('.price_total_1').empty().text(currencyFormat(type_1));
        $('.price_total_2').empty().text(currencyFormat(type_2));
        $('.price_total_3').empty().text(currencyFormat(type_3));
        $('.price_total_4').empty().text(currencyFormat(type_4));
    }
    $(document).on('click', ".edit-price-row", function () {
        var id    = $(this).attr('data-id');
        var price = $(this).attr('data-price');
        var exp   = $(this).attr('expanded');

        if(id > 0 && exp == 'closed'){
            $(this).empty().append('<input type="text" class="form-control price-control" data-id="'+id+'" style="width:auto;" value="'+price+'"/>');
            $(this).attr('expanded','opened');
        }
    });

    $(document).on('keyup','.price-control',function(e){
        var id   = $(this).attr('data-id');
        var val  = $(this).val();
        var self = $(this);
        var firstPrice = $(this).parent().attr('firstPrice');
        $('.edit-price-row[data-id="'+id+'"]').attr('data-price',val);

        if(e.key == 'Enter'){
            $.post(baseurl+'/ihale/priceupdate',{ "id": id,"price": val, "firstPrice": firstPrice },function(response){
                if(response.status == "Success"){
                    $('#price-update-alert').removeClass('d-none').empty().html('<div  class="alert alert-success" role="alert" style="display: flex;flex-direction: row;align-content: center;justify-content: flex-start;align-items: center;"><a href="#" class="close mr-1 float-left" data-dismiss="alert" aria-label="close">&times;</a><p class="mb-0">'+response.message+'</p></div>');
                } else {
                    $('#price-update-alert').removeClass('d-none').empty().html('<div  class="alert alert-danger" role="alert" style="display: flex;flex-direction: row;align-content: center;justify-content: flex-start;align-items: center;"><a href="#" class="close mr-1 float-left" data-dismiss="alert" aria-label="close">&times;</a><p class="mb-0">'+response.message+'</p></div>');
                }
            },"json");
            $('.edit-price-row[expanded="opened"]').each(function(){
                var text = $($(this)[0].innerHTML).val();
                $(this).attr('expanded','closed').empty().text(currencyFormat(parseFloat($(this).attr('data-price'))));
            });
            totalUpdate();
        }
    });

    $(document).on('click','body', function(e){

        var clickedClass = $(e.target)[0].className;
        if(clickedClass != 'edit-price-row' && clickedClass != 'form-control price-control' && clickedClass != 'form-control ihale_items_firma_id'){

            $('.edit-price-row[expanded="opened"]').each(function(index,item){
                var text = $($(this)[0].innerHTML).val();
                $(this).attr('expanded','closed').empty().text(currencyFormat(parseFloat($(this).attr('data-price'))));
                var price = parseFloat($(item).attr('data-price'));
                var id = parseInt($(item).attr('data-id'));
                var firstPrice = parseFloat($(item).attr('firstPrice'));
                $.post(baseurl+'/ihale/priceupdate',{ "id": id,"price": price, "firstPrice": firstPrice },function(response){
                    if(response.status == "Success"){
                        $('#price-update-alert').removeClass('d-none').empty().html('<div  class="alert alert-success" role="alert" style="display: flex;flex-direction: row;align-content: center;justify-content: flex-start;align-items: center;"><a href="#" class="close mr-1 float-left" data-dismiss="alert" aria-label="close">&times;</a><p class="mb-0">'+response.message+'</p></div>');
                    } else {
                        $('#price-update-alert').removeClass('d-none').empty().html('<div  class="alert alert-danger" role="alert" style="display: flex;flex-direction: row;align-content: center;justify-content: flex-start;align-items: center;"><a href="#" class="close mr-1 float-left" data-dismiss="alert" aria-label="close">&times;</a><p class="mb-0">'+response.message+'</p></div>');
                    }
                },"json");
            });
            totalUpdate();
        }
    });

    function  siparis_format(d) {


        var table='' +
            '<div id="price-update-alert"></div>' +
            '<div class="button-group" style="padding-bottom: 10px;width:100%; height:80px; overflow:auto;">' +
            '<a href="#teklif_iste" data-toggle="modal" data-remote="false" id="id_aktar_btn" class="btn btn-info">Tekrar Teklif İste</a>&nbsp;&nbsp;' +
            ' </div>' +
            '<table style="display: block;width: 100%;min-height: .01%;overflow-x: auto;" class="table table-striped" cellpadding="5" cellspacing="0" border="0" >';
        table+='<tr>'+
            '<th>#</th>'+
            '<th>Ürün Adı</th>'+
            '<th>Ürün Detayı</th>'+
            '<th>Marka</th>'+
            '<th>İstehsalçı Ülke</th>'+
            '<th>Miktar</th>'+
            '<th>Fiyat 1</th>'+
            '<th>Fiyat 2</th>'+
            '<th>Fiyat 3</th>'+
            '<th>Fiyat 4</th>'+
            '<th>Ödeme Şekli</th>'+
            '<th>Nakliye Durumu</th>'+
            '<th>Ödeme Tarihi</th>'+
            '<th>Teklif Tarihi</th>'+
            '<th>Not</th>'+
            '<th>IP Adress</th>'+
            '</tr>'+
            '<tr>';
        var price_1_total=0;
        var price_2_total=0;
        var price_3_total=0;
        var price_4_total=0;

        var price_1_s=0;
        var price_2_s=0;
        var price_3_s=0;
        var price_4_s=0;

        for (var i=0; i< d.length; i++)
        {
            var price_1=0;
            var price_2=0;
            var price_3=0;
            var price_4=0;

            var id_1 = 0;
            var id_2 = 0;
            var id_3 = 0;
            var id_4 = 0;

            jQuery.ajax({
                url:'/ihale/teklif_ogren',
                type: 'POST',
                async:false,
                data: {
                    'item_id':d[i].item_id,
                    'ihale_id':d[i].ihale_id,
                    'firma_id':d[i].firma_id,
                },
                dataType: 'json',
                success: function (data) {
                    price_1 = data.price_1;
                    price_2 = data.price_2;
                    price_3 = data.price_3;
                    price_4 = data.price_4;

                    price_1_s = data.price_1_s;
                    price_2_s = data.price_2_s;
                    price_3_s = data.price_3_s;
                    price_4_s = data.price_4_s;

                    price_1_id = data.id_1;
                    price_2_id = data.id_2;
                    price_3_id = data.id_3;
                    price_4_id = data.id_4;
                }
            });

            table+=
                '<tr>' +
                '<td><input value="'+d[i].item_id+'" name="ihale_items_firma_id[]" type="checkbox" firma_id="'+d[i].firma_id+'" class="form-control ihale_items_firma_id"></td>'+
                    '<td>'+d[i].product_name+'</td>'+
                    '<td>'+d[i].product_detail+'</td>'+
                    '<td>'+d[i].marka+'</td>'+
                    '<td>'+d[i].ulke+'</td>'+
                '<td>'+d[i].product_qty+' '+d[i].unit+'</td>'+
                '<td class="edit-price-row" expanded="closed" data-id="'+price_1_id+'" firstPrice="'+price_1_s+'" data-price="'+price_1_s+'" data-type="1">'+price_1+'</td>'+
                '<td class="edit-price-row" expanded="closed" data-id="'+price_2_id+'" firstPrice="'+price_2_s+'" data-price="'+price_2_s+'" data-type="2">'+price_2+'</td>'+
                '<td class="edit-price-row" expanded="closed" data-id="'+price_3_id+'" firstPrice="'+price_3_s+'" data-price="'+price_3_s+'" data-type="3">'+price_3+'</td>'+
                '<td class="edit-price-row" expanded="closed" data-id="'+price_4_id+'" firstPrice="'+price_4_s+'" data-price="'+price_4_s+'" data-type="4">'+price_4+'</td>'+
                '<td>'+d[i].odeme+'</td>'+
                '<td>'+d[i].nakliye_durumu+'</td>'+
                '<td>'+d[i].odeme_tarihi+'</td>'+
                '<td>'+d[i].teklif_tarihi+'</td>'+
                '<td>'+d[i].aciklama+'</td>'+
                '<td>'+d[i].ip_address+'</td>'+
                '</tr> ';


            price_1_total=parseFloat(price_1_total)+parseFloat(price_1_s);
            price_2_total=parseFloat(price_2_total)+parseFloat(price_2_s);
            price_3_total=parseFloat(price_3_total)+parseFloat(price_3_s);
            price_4_total=parseFloat(price_4_total)+parseFloat(price_4_s);



        }

        table+=
            '<tfoot>' +
            '<tr>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td class="price_total_1">'+currencyFormat(price_1_total)+'</td>' +
            '<td class="price_total_2">'+currencyFormat(price_2_total)+'</td>' +
            '<td class="price_total_3">'+currencyFormat(price_3_total)+'</td>' +
            '<td class="price_total_4">'+currencyFormat(price_4_total)+'</td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '<td></td>' +
            '</tr>' +
            '</tfoot>';

        table+='</table>';

        return table;
    }

    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }



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
    $("#submit-data-ihale").on("click", function(e) {
        e.preventDefault();
        var o_data =  $("#data_form").serialize();
        var send_sms =   $('.send_smsm').prop('checked');
        var action_url= $('#action-url').val();
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'İhale Oluşturma',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            columnClass: 'small',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: 'İhale Oluşturmak Üzeresiniz Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Oluştur',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        jQuery.ajax({
                            url: baseurl + action_url,
                            type: 'POST',
                            data: o_data+'&'+crsf_token+'='+crsf_hash+'&send_smsm='+send_sms,
                            dataType: 'json',
                            beforeSend: function () {
                                $("#submit-data").attr("disabled","true");
                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'grey',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı',
                                        content: data.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'İhale Görüntüle',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    location.reload();

                                                }
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');
                                } else {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: data.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');
                                }

                                $("#submit-data").prop('disabled',false);
                            },
                            error: function (data) {
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');

                            }
                        });



                    }
                },
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {

                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }


        });


    });
</script>
