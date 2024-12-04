<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Anbar Transfer List</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success status_change" tip_id="1"><i class="fa fa-check"></i></button>
                        <button class="btn btn-danger status_change" tip_id="2"><i class="fa fa-ban"></i></button>
                    </div>
                </div>

                        <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <td>
                                    <input class="form-control all_select" type="checkbox" style="margin-left: 17px;width: 16px;">
                                </td>
                                <th>Tələb Nomresi</th>
                                <th>Çıxış Anbarı</th>
                                <th>Giriş Anbarı</th>
                                <th>Mahsul</th>
                                <th>Varyasyon</th>
                                <th>Miqdar</th>
                                <th>Yeni Miqdar</th>
                                <th>Ölçü Vahidi</th>
                                <th>Açıqlama</th>
                                <th>İşlemi Yapan Personel</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            draw_data()
        });
        function draw_data() {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('stocktransfer/transfer_onay_list')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: []
            });
        }

        $(document).on('change','.all_select',function (){
            let status = $(this).prop('checked');
            if(status){
                $('.one_select').prop('checked',true)
            }
            else {
                $('.one_select').prop('checked',false)
            }
        })

        $(document).on('click','.status_change',function (){
            let checked_count = $('.one_select:checked').length;
            if (checked_count == 0) {
                $.alert({
                    theme: 'modern',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Herhangi Bir Ürün Seçilmemiş!',
                    buttons: {
                        prev: {
                            text: 'Tamam',
                            btnClass: "btn btn-link text-dark",
                        }
                    }
                });
                return false;
            }
            else {
                let tip = $(this).attr('tip_id');
                $.confirm({
                    theme: 'modern',
                    closeIcon: true,
                    title: 'Durum Bildir',
                    icon: 'fa fa-pen',
                    type: 'green',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content:'<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<p>Güncellemek Üzeresiniz Emin Misiniz?<p/>'+
                        '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Güncelle',
                            btnClass: 'btn-blue',
                            action: function () {

                                let product_details=[];
                                $('.one_select:checked').each((index,item) => {
                                    let eq = $(item).attr('eq');
                                    product_details.push({
                                        new_qty:$('.new_qty').eq(eq).val(),
                                        notifation_id:$(item).attr('notifation_id'),
                                        type_id:$(item).attr('type_id'),
                                        stock_id:$(item).attr('stock_id'),
                                    })
                                });

                                $('#loading-box').removeClass('d-none');
                                let data = {
                                    tip:tip,
                                    crsf_token: crsf_hash,
                                    product_details: product_details,
                                }
                                $.post(baseurl + 'stocktransfer/transfer_update',data,(response)=>{
                                    let responses = jQuery.parseJSON(response);
                                    if(responses.status==200){
                                        $('#loading-box').addClass('d-none');
                                        $.alert({
                                            theme: 'modern',
                                            icon: 'fa fa-check',
                                            type: 'green',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Başarılı',
                                            content: responses.message,
                                            buttons:{
                                                formSubmit: {
                                                    text: 'Tamam',
                                                    btnClass: 'btn-blue',
                                                    action: function () {
                                                        $('#invoices').DataTable().destroy();
                                                        draw_data();
                                                    }
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
                            text: 'Vazgeç',
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

            }

        })
    </script>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/talep.css">
