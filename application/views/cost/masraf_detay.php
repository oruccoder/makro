<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 7.02.2020
 * Time: 19:02
 */
?>


<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Giderler</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content-wrapper">
        <div class="content-inner">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <a class="btn btn-danger box-shadow--4dp ripple has-ripple"  href="<?php echo  base_url("cost/yeni_gider") ?>" type="button"><i class="fa fa-plus"></i>&nbsp;Yeni Gider İşlemi Gir</a>
                                    </div>
                                    <div class="col-lg-2">
                                        <a class="btn btn-success box-shadow--4dp ripple has-ripple" href="<?php echo  base_url("cost/gider_kalemleri") ?>" type="button"><i class="fa fa-edit"></i>&nbsp;Gider Kalemleri</a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <input type="text" name="start_date" id="start_date"
                                               class="date30 form-control form-control-sm" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                               data-toggle="datepicker" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="odeme_durumu" name="odeme_durumu" style="width: 297px !important;">
                                            <option value="0">Ödeme Durumunu Seçiniz</option>
                                            <option value="1">Ödenmedi</option>
                                            <option value="2">Daha Sonra Ödenecek</option>
                                            <option value="3">Ödendi</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('masraf_kalemi') ?></th>
                            <th><?php echo $this->lang->line('Invoice Number') ?></th>
                            <th><?php echo $this->lang->line('payment_type') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                            <th><?php echo $this->lang->line('Actions') ?></th>
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
                            <th></th>

                        </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="masraf_id" name="masraf_id" value="<?php echo $masraf_id; ?>">

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
        var odeme_durumu = $('#odeme_durumu').val();


        if (start_date != '' && end_date != '') {
            $('#invoices').DataTable().destroy();
            draw_data(start_date, end_date,odeme_durumu);
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


    function draw_data(start_date = '', end_date = '',odeme_durumu='') {

        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            aLengthMenu: [
                [ 10, 50, 100, 200],
                [10, 50, 100, 200]
            ],
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('cost/masraf_detay_ajax')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    masraf_id: $('#masraf_id').val(),
                    start_date: start_date,
                    end_date: end_date,
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
            ],"footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                total2 = api
                    .column( 4)
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );
                // Update footer

                var bakiye = floatVal(total2)-floatVal(total);
                var string='';
                if(floatVal(total2)>floatVal(total))
                {

                    string='(B)';
                }
                else
                {
                    string='(A)'
                }

                var tatals =currencyFormat(floatVal(total.toFixed(2)));
                var tatals2 =currencyFormat(floatVal(total2.toFixed(2)));
                var bakiyes =currencyFormat(floatVal(Math.abs(bakiye.toFixed(2))));

                $( api.column( 5 ).footer() ).html(tatals);
                $( api.column( 4 ).footer() ).html(tatals2);
                $( api.column( 6 ).footer() ).html(bakiyes+' '+string);
            }
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

