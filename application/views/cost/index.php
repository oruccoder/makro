
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
                                    <div class="col-md-2">
                                        <select class="form-control select2" id="masraf_id" name="masraf_id" style="width: 297px !important;">
                                            <option value="0">Masraf Gideri Seçiniz</option>
                                            <?php
                                            foreach ($ana_gider_kalemleri as $agd) {?>
                                                <option value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>

                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control select2" id="alt_masraf_id" name="alt_masraf_id" style="width: 297px !important;">
                                            <option value="0">Alt Gideri Seçiniz</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control select2" id="odeme_durumu" name="odeme_durumu" style="width: 297px !important;">
                                            <option value="0">Ödeme Durumunu Seçiniz</option>
                                            <option value="1">Ödenmedi</option>
                                            <option value="2">Daha Sonra Ödenecek</option>
                                            <option value="3">Ödendi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>

                                    <div class="col-md-2">
                                        <a class="btn btn-danger box-shadow--4dp ripple has-ripple"  href="<?php echo  base_url("cost/yeni_gider") ?>" type="button"><i class="fa fa-plus"></i>&nbsp;Yeni Gider İşlemi Gir</a>
                                    </div>
                                    <div class="col-md-2">
                                        <a class="btn btn-success box-shadow--4dp ripple has-ripple" href="<?php echo  base_url("cost/gider_kalemleri") ?>" type="button"><i class="fa fa-edit"></i>&nbsp;Gider Kalemleri</a>
                                    </div>
<!--                                    <div class="col-lg-2">-->
<!--                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>-->
<!--                                    </div>-->
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('ana_gider_hesabi') ?></th>
                            <th><?php echo $this->lang->line('gider_hesabi') ?></th>
                            <th><?php echo $this->lang->line('Total Amount') ?></th>
                            <th><?php echo $this->lang->line('Net Total') ?></th>
                            <th><?php echo $this->lang->line('Total Tax') ?></th>
                            <th><?php echo $this->lang->line('Total') ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>
                            <th class="no-sort"></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
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
            aLengthMenu: [
                [ 10, 50, 100, 200,-1],
                [10, 50, 100, 200,"Tümü"]
            ],
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('cost/ajax_list')?>",
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
            ], "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var floatVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\AZN,.]/g, '')/100 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total_qty = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                total_alt = api
                    .column( 4 ,{ page: 'current'})
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                total_kdv = api
                    .column( 5 ,{ page: 'current'})
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );

                total = api
                    .column( 6,{ page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0 );



                // Update footer



                var total_alt =currencyFormat(floatVal(total_alt.toFixed(2)));
                var total_kdv =currencyFormat(floatVal(total_kdv.toFixed(2)));
                var total =currencyFormat(floatVal(total.toFixed(2)));


                $( api.column( 4 ).footer() ).html(total_alt);
                $( api.column( 5 ).footer() ).html(total_kdv);
                $( api.column( 6 ).footer() ).html(total);
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
