
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $account['holder'].' '; echo $this->lang->line('Details') ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            Hesap Detayları
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
                                    <div class="col-lg-1">
                                        <input type="text" name="start_date" id="start_date"
                                               class="date30 form-control form-control-sm" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                               data-toggle="datepicker" autocomplete="off"/>
                                    </div>
                                    <div class="col-lg-1">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                                    </div>
<!--                                    <div class="col-lg-2">-->
<!--                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>-->
<!--                                    </div>-->

                                     <div class="col-lg-1">
                                         <a href="/accounts/pers_razi?id=<?php echo $_GET['id']?>" type="button"  class="btn btn-info btn-sm">Razı</a>
                                    </div>

                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <table id="trans_table" class="table datatable-show-all" cellspacing="0"
                           width="100%">
                        <thead>
                        <tr>

                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Kasa</th>
                            <th>Cari</th>
                            <th>Mədaxil</th>
                            <th>Məharic</th>
                            <th>Bakiye</th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('type') ?></th>
                            <th>Personel</th>
                            <th>Açıklama</th>
                            <th>Talep</th>
                            <th>İşlem</th>


                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Kasa</th>
                            <th>Cari</th>
                            <th>Mədaxil</th>
                            <th>Məharic</th>
                            <th>Bakiye</th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('type') ?></th>
                            <th>Personel</th>
                            <th>Açıklama</th>
                            <th>Talep</th>
                            <th>İşlem</th>


                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
<script>
</script>
<script type="text/javascript">
    var table='';
    function draw_data(start_date = '', end_date = '') {
        table = $('#trans_table').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('accounts/account_details?id=') . $_GET['id']?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    end_date: end_date
                }
            },
            "columnDefs": [
                { "type": "date", targets: 0 }
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5,9]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns:  [0, 1, 2, 3, 4, 6,7,8,9]
                    }
                },
            ],

        });
    }

    // $('#trans_table').on( 'page.dt', function () {
    //     var info = table.page.info();
    //     console.log(info);
    //     $('#pageInfo').html( 'Showing page: '+info.page+' of '+info.pages );
    // } );

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if (start_date != '' && end_date != '') {
            $('#trans_table').DataTable().destroy();
            draw_data(start_date, end_date);
        } else {
            alert("Date range is Required");
        }
    });


    $(document).ready(function () {

        draw_data()
    });


</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).on('click', ".price_update", function (e) {
        let invoice_id = $(this).attr('data-object-id');
        let price = $(this).attr('price');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Tutar Güncelleme!',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_rp">'+
                    '<input class="form-control price_update_val" id="price_update" value="'+floatVal(price)+'" name="price_update">'+
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                });



                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        var name = this.$content.find('.price_update_val').val();
                        if(!name){
                            ('#loading-box').addClass('d-none');
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tüm Alanlar Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;

                        }
                        let data = {
                            invoice_id:invoice_id,
                            price:$('#price_update').val(),
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'accounts/price_update',data,(response)=>{
                            let responses = jQuery.parseJSON(response);

                            if(responses.status=='Success'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'grey',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: 'Başarılı Bir Şekilde Güncellendi.',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#trans_table').DataTable().destroy();
                                draw_data();
                            }
                            else if(responses.status=='Error'){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
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
    })

    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };
</script>
