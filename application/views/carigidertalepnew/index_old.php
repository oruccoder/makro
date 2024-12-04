<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Cari Gider Talebi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
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

                                <div class="form-row">

                                    <div class="col-md-2 form-group">
                                        <input type="button" name="search" id="aauth" value="Yaratdığın Taleplere Bak" class="btn btn-success form-control "/>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <input type="button" id="clear" value="Aramayi Sifirla" class="btn btn-warning form-control"/>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <?php $cts = paylist_form(); ?>
                                        <?php $count='<span class="badge badge-pill badge-default badge-danger badge-default badge-up" style="top:-1px !important;" id="count_pays">'.paylist_form().'</span>'; ?>
                                        <button type="button" id="paylist"  class="btn btn-info form-control">Ödeme Yapılmış Ancak Hizmet Tamamlanmamış <?php echo $count ?> </button>
                                    </div>

                                </div>

                            </section>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="cari_gider_talep_list" class="table datatable-show-all" width="100%">
                                            <thead>
                                            <tr>
                                                <td>Talep Kodu</td>
                                                <td>Cari</td>
                                                <td>Aciliyet</td>
                                                <td>Tarih</td>
                                                <td>Talep Eden</td>
                                                <td>Proje</td>
                                                <td>Tutar</td>
                                                <td>Qalıq Ödeme</td>
                                                <td>Durum</td>
                                                <td>Gider Durumu</td>
                                                <td>Fatura Durumu</td>
                                                <td>İşlemler</td>
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
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

    var url = '<?php echo base_url() ?>carigidertalepnew/file_handling';
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();

        $('#aauth').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data('aauth');
        });

        $('#paylist').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data('paylist');
        });


        $('#clear').click(function () {
            $('#cari_gider_talep_list').DataTable().destroy();
            draw_data();
        });

        function draw_data(aauth = 'absent',) {
            $('#cari_gider_talep_list').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                aLengthMenu: [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "Tümü"]
                ],
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('carigidertalepnew/ajax_list')?>",
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        aauth: aauth,
                    }
                },
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[12]);

                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0,1, 2, 3, 4, 5, 6, 7]
                        }
                    }
                ]
            });
        };
    })

    $(document).on('click', ".talep_sil", function (e) {
        let talep_id = $(this).attr('talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Talep İptal Etmek Üzeresiniz?<p/>' +
                '<p><b>Bu İşleme Ait Qaime ve Gider Hareketleri Var İse İptal Olacaktır</b><p/>' +
                '<input type="text" id="desc" class="form-control desc" placeholder="İptal Sebebi Zorunludur">' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'İptal Et',
                    btnClass: 'btn-blue',
                    action: function () {

                        let name = $('.desc').val()
                        if(!name){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'İptal Sebebi Zorunludur',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            file_id:  talep_id,
                            desc:  $('.desc').val(),
                            status:  10
                        }
                        $.post(baseurl + 'carigidertalepnew/status_upda',data,(response) => {
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
                                                $('#cari_gider_talep_list').DataTable().destroy();
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

    $(document).on('change','#demirbas_id',function (){
        let id =  $(this).val();
        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_firma_demirbas',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            let eq=$(this).parent().index();
            $("#firma_demirbas_id option").remove();
            if(responses.status==200){
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });
                responses.items.forEach((item_,index) => {
                    $('#firma_demirbas_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                })

            }
            else {

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
    })
</script>

