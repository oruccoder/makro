<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bordro İşlemleri</span></h4>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4" style="    width: 800px;">
                                        <table class="stripe row-border order-column nowrap" id="project_table" style="width:100%">
                                            <thead>
                                            <tr>

                                                <th>No</th>
                                                <th>Personel Adı</th>
                                                <th>Bordro Dönemi</th>
                                                <th>Bankadan Ödenilecek</th>
                                                <th>Nakit Ödenilecek</th>
                                                <th><input type="checkbox" class="form-control all_checked"></th>
                                            </tr>
                                            </thead>
                                        </table>

                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select-box').select2();
        draw_data();
    })
    function draw_data() {
        $('#project_table').DataTable({
            'serverSide': true,
            'stateSave': true,
            scrollX:        "300px",
            scrollCollapse: true,
            fixedColumns:   {
                left: 7
            },
            paging:         false,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'ordering': false,
            'ajax': {
                'url': "<?php echo site_url('salary/ajax_list_odenis')?>",
                'type': 'POST',
                'data': {
                    'tip': '-',
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-user-plus"></i> Ödeme Yap',
                    action: function ( e, dt, node, config ) {

                        let checked_count = $('.one_checkbox:checked').length;
                        if (checked_count == 0) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Herhangi Personel Seçilmemiş!',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }



                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'İşlem Yap ',
                            icon: 'fa fa-question',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: function () {
                                let self = this;
                                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                let responses;

                                html+='<form action="" class="formName">' +
                                    '<div class="form-group">' +
                                    '<label>Ödeme Tip</label>' +
                                    '<select id="method"  class="form-control name" ><option value="1">Nakit Maaşlar Ödensin</option><option value="3">Banka Maaşları Ödensin</option></select>' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<label>Kasa</label>' +
                                    '<select class="form-control select-box name" name="acid" id="acid"><option value="0">Seçiniz</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '</form>';

                                let data = {
                                    crsf_token: crsf_hash,
                                }

                                $.post(baseurl + 'controller/ajax_account_emp',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    });
                                    let responses = jQuery.parseJSON(response);
                                    responses.item.forEach((item_,index) => {
                                        $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                                    })

                                });

                                return $('#person-container').html();
                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Güncelle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let bordro_details=[];
                                        let method_id = [];
                                        $('.one_checkbox:checked').each((index,item) => {
                                            bordro_details.push({
                                                bordro_pay_set_id:$(item).data('bordro_pay_set_id'),
                                                bordro_item_id:$(item).data('bordro_item_id'),
                                                nakit_durum:$(item).data('nakit_durum'),
                                                banka_durum:$(item).data('banka_durum'),

                                            })

                                            method_id.push($(item).data('method'))
                                        });

                                        let uniq_method = $.grep(method_id, function(v, k) {
                                            return $.inArray(v, method_id) === k;
                                        });



                                        if(uniq_method.length > 1){
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Farklı Ödeme Metodları Seçilemez!',
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
                                            bordro_details:  bordro_details,
                                            method:  $('#method').val(),
                                            acid:  $('#acid').val(),
                                        }
                                        $.post(baseurl + 'salary/create_pay',data,(response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if(responses.status==200){
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons:{
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#project_table').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });

                                            }
                                            else if(responses.status==410){

                                                $.alert({
                                                    theme: 'modern',
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
                                        })

                                    }
                                },
                                cancel:{
                                    text: 'Vazgeç',
                                    btnClass: "btn btn-danger btn-sm",
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $(document).on('change','#proje_id_modal',function (e){

                                    let data = {
                                        crsf_token: crsf_hash,
                                        proje_id : $(this).val()
                                    }

                                    $.post(baseurl + 'employee/proje_to_pers',data,(response) => {
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm-box-container")
                                        });
                                        $('#pers_id').empty().trigger("change");
                                        let responses = jQuery.parseJSON(response);
                                        $('#pers_id').append(new Option('Tüm Projedeki Personeller', 0, false, false)).trigger('change');
                                        responses.item.forEach((item_,index) => {
                                            $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                                        })
                                    });
                                })
                            }
                        });
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                }
            ]
        });
    };

    $(document).on('change','.all_checked',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_checkbox').prop('checked',true)
        }
        else {
            $('.one_checkbox').prop('checked',false)
        }
    })

</script>