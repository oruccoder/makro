<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 4.02.2020
 * Time: 13:04
 */
?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <?php if($detay==0){?>

                        <button class="btn btn-success box-shadow--4dp ripple has-ripple"  id="guncelleme" type="button"><i class="fa fa-refresh"></i>&nbsp;Güncelle</button>
                        <a class="btn btn-success box-shadow--4dp ripple has-ripple"  href="/projects/is_kalemleri?id=<?php echo $proje_id?>&detay=1" type="button"><i class="fa fa-refresh"></i>&nbsp;Detaylı Analiz</a>
                        &nbsp;
                    <?php } ?>

                </div>
                <div class="col-md-12">
                    <input type="hidden" id="proje_id" value="<?php echo $proje_id ?>">
                    <input type="hidden" id="detay" value="<?php echo $detay ?>">
                    <?php if($detay==1){?>
                        <div class="btn-group box-shadow--8dp" role="group" style="width:100% !important;background-color: white;margin: 15px 5px 5px -20px;border-radius: 3px !important;" >
                            <label style="background-color: #ff0100;color: white;margin-left: 20px;padding: 10px;">Fazla Yapılmış İşler</label>
                            <label style="background-color: #0f6b98;color: white;margin-left: 20px;padding: 10px;">Tam Yapılmış İşler</label>
                            <label style="background-color: #4c5553;color: white;margin-left: 20px;padding: 10px;">Eksik Yapılmış İşler</label>
                        </div>
                    <?php } ?>
                    <div class="btn-group box-shadow--8dp" role="group" style="width:100% !important;background-color: white;margin: 15px 5px 5px -20px;border-radius: 3px !important;" >
                        <!--button class="btn btn-success group-buttons"> Ödenmişler </button>
                        <button class="btn btn-warning group-buttons"> Ödenecekler </button>
                        <button class="btn btn-info group-buttons"> Gecikmişler </button>
                        <button class="btn btn-danger group-buttons"> Tümü </button!-->   &nbsp;   &nbsp;
                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <select class="form-control select2" id="bolum_id" name="bolum_id" style="
    width: 250px !important;
">
                                <option value="0">Bölüm Seçiniz</option>
                                <?php
                                foreach ($bolumler as $agd) {?>
                                    <option value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>

                                <?php } ?>

                            </select>
                            &nbsp;   &nbsp;</div>
                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <select class="form-control select2" id="asama_id" name="asama_id" style="
    width: 250px !important;
">
                                <option value="0">Aşama Seçiniz</option>


                            </select>
                            &nbsp;   &nbsp;</div>

                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <select class="form-control select2" id="alt_asama_id" name="alt_asama_id" style="
    width: 250px !important;
">
                                <option value="0">Alt Aşama Seçiniz</option>
                            </select>
                            &nbsp;   &nbsp;</div>

                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <select class="form-control select2" id="durumu" name="durumu" style="
    width: 250px !important;
">
                                <option value="0">Durum Seçiniz</option>
                                <?php
                                foreach (is_kalemleri_status() as $agd) {?>
                                    <option value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <select class="form-control select2" id="simeta_status" name="simeta_status" style="
    width: 250px !important;
">
                                <option value="">Simeta Durumu Seçiniz</option>
                                <option value="1">İş Listesinde Var</option>
                                <option value="2">İş Listesinde Yok</option>

                            </select>
                        </div>
                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <select class="form-control select2" id="is_durumu" name="is_durumu" style="
    width: 250px !important;
">
                                <option value="0">İş Durumu</option>
                                <option value="1">Fazla Yapılmış İşler</option>
                                <option value="2">Az Yapılmış İşler</option>
                                <option value="3">Tam Yapılmış İşler</option>
                            </select>
                        </div>

                    </div>


                </div>

                <div class="col-md-12">
                    <div class="btn-group box-shadow--8dp" role="group" style="width:100% !important;background-color: white;margin: 15px 5px 5px -20px;border-radius: 3px !important;" >

                        <div class="col-md-2 col-lg-2 col-xs-2">
                            <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                            &nbsp;   &nbsp;
                            <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>

                        </div>
                    </div>
                </div>
            </div>
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
                <div class="grid_3 grid_4 animated fadeInRight">
                    <div class="table-responsive">

                        <hr>
                        <form id="data">


                            <table id="invoices" style="display: block;
    overflow: auto;" class="genis table table-striped table-bordered zero-configuration" width="100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bölüm</th>
                                    <th>Bağlı Olduğu Aşama</th>
                                    <th>Aşama</th>
                                    <th>İş Kalemi</th>
                                    <th>Miktar</th>
                                    <th>Birim</th>
                                    <th>Birim Fiyatı</th>
                                    <th>Oran</th>
                                    <th>Tutar</th>
                                    <th>Görülmüş İşler</th>
                                    <th>Tutar 2</th>
                                    <th>Güncel Durum</th>
                                    <th>Simeta Durumu</th>
                                    <?php if($detay==0){?>
                                        <th>Yeni Durum</th>
                                    <?php } ?>


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
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <th class="no-sort"></th>
                                    <?php if($detay==0){?>
                                        <th class="no-sort"></th>
                                    <?php } ?>

                                </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>

</style>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('DeleteCost') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p><?php echo $this->lang->line('delete_this_cost') ?> ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="cost/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<style>
    .group-buttons
    {
        outline: none !important;
        border-radius: 0px !important;
        border: 1px solid gray;
    }
</style>

<script>

    $('#guncelleme').click(function () {
        jQuery.ajax({

            url: "<?php echo site_url('projects/is_kalemi_guncelle')?>",
            type: 'POST',
            data: $('form').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('.gorulmus_is_qty').val(0);
                    $('.tutar_2').val(0);

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
    })

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var bolum_id = $('#bolum_id').val();
        var asama_id = $('#asama_id').val();
        var alt_asama_id = $('#alt_asama_id').val();
        var durumu = $('#durumu').val();
        var simeta_status = $('#simeta_status').val();
        var is_durumu = $('#is_durumu').val();


        if (start_date != '' && end_date != '') {
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,bolum_id,asama_id,durumu,is_durumu,simeta_status,alt_asama_id);
        } else {
            alert("Tarih Seçiniz");
        }
    });

    $(document).ready(function () {

        $(function () {
            $('.select2').select2({ width: '150px' });
        });
        draw_data();


    });

    $(document).on('keyup','.gorulmus_is_qty',function(e){
        var eq = $(this).parent().parent().index();
        var deger=$(this).val();
        var fiyat=$('.fiyat').eq(eq).val();
        var oran=$('.oran').eq(eq).val();

        var new_deger = (fiyat*deger*oran)/100;
        // var new_deger=fiyat*deger;
        $('.tutar_2_inp').eq(eq).val(parseFloat(new_deger));
        $('.tutar_2').eq(eq).val(parseFloat(new_deger));
    })



    function draw_data(start_date = '', end_date = '',bolum_id='',asama_id='',durumu='',is_durumu='',simeta_status='',alt_asama_id='') {
        var url="<?php echo site_url('projects/ajax_list_is_kalemleri')?>";
        var detay=0;
        if($("#detay").val()==1)
        {
            detay=1;
        }

        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style',data[14]);
            },
            'order': [],
            'ajax': {
                'url': url,
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    pid: $('#proje_id').val(),
                    start_date: start_date,
                    end_date: end_date,
                    bolum_id: bolum_id,
                    alt_asama_id: alt_asama_id,
                    asama_id: asama_id,
                    durumu: durumu,
                    is_durumu: is_durumu,
                    detay: detay,
                    simeta_status: simeta_status,
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
                        columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6,7,8,9,10,11,12]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' ),



                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );

                    },

                },
            ]
        });
    };


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('change', "#bolum_id", function (e) {
        $("#asama_id option").remove();
        var bolum_id = $(this).val();
        var proje_id = $('#proje_id').val();
        $.ajax({
            type: "POST",
            url: '/projects/proje_ana_asamalari_ajax/',
            data:'bolum_id='+bolum_id+'&'+'proje_id='+proje_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#asama_id').append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#asama_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });

    $(document).on('change','#asama_id',function (e) {
        $('#alt_asama_id').children('option').remove();
        var asama_id=$(this).val();
        var proje_id=$('#proje_id').val();
        var bolum_id=$('#bolum_id').val();
        $.ajax({
            url: '/projects/proje_asamalari_ajax/',
            dataType: "json",
            method: 'post',
            data:  '&asama_id=' + asama_id +'&proje_id=' + proje_id+'&bolum_id=' + bolum_id,
            success: function (data) {
                $("#alt_asama_id").append('<option  value="0">Seçiniz</option>');
                jQuery.each(data, function (key, item) {

                    $("#alt_asama_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');


                });
            }
        });
    });

</script>
