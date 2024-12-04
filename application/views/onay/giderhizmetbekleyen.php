<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Hizmet Tamamlanması Bekleyen Gider Talepleri</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="text-align: center">
                        <button class="btn btn-success status_change" tip_id="1"><i class="fa fa-check"></i> Seçili Olanları İş Görüldü Onayı Ver</button>
                    </div>
                </div>

                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <td>
                            <input class="form-control all_select" type="checkbox" style="margin-left: 17px;width: 16px;">
                        </td>
                        <th>Tələb Nomresi</th>
                        <th>Tarih</th>
                        <th>Cari</th>
                        <th>Proje</th>
                        <th>Tutar</th>
                        <th>Talep Görüntüle</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
                'url': "<?php echo site_url('carigidertalepnew/giderhizmetbekleyenlist')?>",
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
                content: 'Herhangi Bir Talep Seçilmemiş!',
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
                                let id = $(item).val();
                                product_details.push({
                                    id:id
                                })
                            });

                            $('#loading-box').removeClass('d-none');
                            let data = {
                                product_details: product_details,
                            }
                            $.post(baseurl + 'carigidertalepnew/hizmetconfirm',data,(response)=>{
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