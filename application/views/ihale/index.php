<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 11.02.2020
 * Time: 15:52
 */
?>


<div class="content-body">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success box-shadow--4dp ripple has-ripple"  href="<?php echo  base_url("ihale/yeni_dosya") ?>" type="button"><i class="fa fa-plus"></i>&nbsp;<?php echo $this->lang->line('new_field') ?></a>
                    &nbsp;
                    &nbsp;
                </div>
                <div class="col-md-12">
                    <div class="btn-group box-shadow--8dp" role="group" style="background-color: white;margin: 15px 5px 5px -10px;border-radius: 3px !important;" >
                        <!--button class="btn btn-success group-buttons"> Ödenmişler </button>
                        <button class="btn btn-warning group-buttons"> Ödenecekler </button>
                        <button class="btn btn-info group-buttons"> Gecikmişler </button>
                        <button class="btn btn-danger group-buttons"> Tümü </button>   &nbsp;   &nbsp;
                        <select class="form-control select2" id="masraf_id" name="masraf_id" style="width: 297px !important;">
                            <option value="0">Masraf Gideri Seçiniz</option>
                            <?php
                        foreach ($ana_gider_kalemleri as $agd) {?>
                                <option value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>

                            <?php } ?>

                        </select>
                        &nbsp;   &nbsp;
                        <select class="form-control select2" id="alt_masraf_id" name="alt_masraf_id" style="width: 297px !important;">
                            <option value="0">Alt Gideri Seçiniz</option>


                        </select>
                        &nbsp;   &nbsp;
                        <select class="form-control select2" id="odeme_durumu" name="odeme_durumu" style="width: 297px !important;">
                            <option value="0">Ödeme Durumunu Seçiniz</option>
                            <option value="1">Ödenmedi</option>
                            <option value="2">Daha Sonra Ödenecek</option>
                            <option value="3">Ödendi</option>

                        </select!-->
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
                        <div class="row" style="padding-left: 13px;">

                            <div class="col-md-1"><?php echo $this->lang->line('dosya_date') ?></div>
                            <div class="col-md-2">
                                <input type="text" name="start_date" id="start_date"
                                       class="date30 form-control form-control-sm" autocomplete="off"/>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                       data-toggle="datepicker" autocomplete="off"/>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group row">
                                    <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                                    &nbsp;   &nbsp;
                                    <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>
                                </div>


                            </div>

                        </div>
                        <hr>
                        <table id="invoices" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                               width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line('dosya_no') ?></th>
                                <th><?php echo $this->lang->line('baslama_tarihi') ?></th>
                                <th><?php echo $this->lang->line('bitis_tarihi') ?></th>
                                <th><?php echo $this->lang->line('Status') ?></th>
                                <th><?php echo $this->lang->line('Description') ?></th>
                                <th><?php echo $this->lang->line('Actions') ?></th>


                            </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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


    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var masraf_id = $('#masraf_id').val();
        var alt_masraf_id = $('#alt_masraf_id').val();
        var odeme_durumu = $('#odeme_durumu').val();


        if (start_date != '' && end_date != '') {
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,masraf_id,alt_masraf_id,odeme_durumu);
        } else {
            alert("Tarih Seçiniz");
        }
    });

    $(document).ready(function () {

        $(function () {
            $('.select2').select2();
        });
        draw_data();


    });


    function draw_data(start_date = '', end_date = '',masraf_id='',alt_masraf_id='',odeme_durumu='') {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('ihale/ajax_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date,
                    masraf_id: masraf_id,
                    alt_masraf_id: alt_masraf_id,
                    odeme_durumu: odeme_durumu
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
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,6]
                    },
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '10pt' )

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );
                    }
                },
            ]
        });
    };


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('change', "#masraf_id", function (e) {
        $("#alt_masraf_id option").remove();
        var ana_masraf_id = $(this).val();
        $.ajax({
            type: "POST",
            url: baseurl + 'cost/alt_masraf_list',
            data:'masraf_id='+ana_masraf_id+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('#alt_masraf_id').append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#alt_masraf_id").append('<option value="'+ item.id +'">'+ item.name +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

    });

</script>
