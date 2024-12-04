<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex ">
            <h4><span class="font-weight-semibold"> TALEPLER </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<?php

$pers_id_onay = array_merge($this->session->userdata('cari_talep_pers'),$this->session->userdata('mt_talep_pers'));



?>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <form action="#">
                    <fieldset class="mb-3">
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <select class="form-control select2 select-box" id="project_select" name="proje_id">
                                    <option value="0" selected="selected">Proje</option>
                                    <?php
                                    foreach (all_projects() as $agd) { ?>
                                        <option value="<?php echo $agd->id ?>"><?php echo $agd->name ?></option>

                                    <?php } ?>

                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control select2 select-box" id="employee_select" name="pers_id">
                                    <option value="0" selected="selected">Personel</option>
                                    <?php
                                    foreach ($pers_id_onay as $agd) {
                                        if($agd!=0){


                                        ?>
                                        <option value="<?php echo $agd ?>"><?php echo personel_details($agd) ?></option>

                                    <?php  }} ?>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <button class="btn btn-danger btn-sm rounded" id="search" type="button">
                                    <i class="ft-power"></i>FILTRELE
                                </button>


                                <a href="/form/bekleyen_talepler" class="btn btn-success btn-sm rounded" >
                                    <i class="fas fa-ban"></i> TEMIZLE
                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="container-fluid">
                    <section>
                        <div class="row">
                            <div class="col-xl-4 col-sm-4 col-4 col-xs-4 mb-4">
                                <h3 class="text-danger" style="text-align:center">Malzeme Talep Onay Kimde Raporu</h3>
                                <div class="table-responsive">
                                    <table id="invoices_talep_onay_report" class="table responsive" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Proje</th>
                                            <th>Talep No</th>
                                            <th>Onay Sırası</th>
                                            <th>Durum</th>
                                            <th>Cari - Toplam</th>
                                            <th>Görüntüle</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-4 col-4 col-xs-4 mb-4">
                                <h3 class="text-danger" style="text-align:center">Cari Gider Onay Kimde Raporu</h3>
                                <div class="table-responsive">
                                    <table id="invoices_cari_talep_onay_report" class="table responsive" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Proje</th>
                                            <th>Talep No</th>
                                            <th>Onay Sırası</th>
                                            <th>Durum</th>
                                            <th>Görüntüle</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-4 col-4 col-xs-4 mb-4">
                                <h3 class="text-danger" style="text-align:center">Cari Avans Onay Kimde Raporu</h3>
                                <div class="table-responsive">
                                    <table id="invoices_cari_avans_onay_report" class="table responsive" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Proje</th>
                                            <th>Talep No</th>
                                            <th>Onay Sırası</th>
                                            <th>Durum</th>
                                            <th>Görüntüle</th>
                                        </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">


    $('#search').click(function () {
        var project_select = $('#project_select').val();
        var employee_select = $('#employee_select').val();

        let val=10;
        let page='all';
        if(employee_select > 0){
            page='personel';
            val=-1;
        }

        $('#invoices_cari_talep_onay_report').DataTable().destroy();
        invoices_cari_talep_onay_report(page,employee_select,project_select);

        $('#invoices_cari_avans_onay_report').DataTable().destroy();
        invoices_cari_avans_onay_report(page,employee_select,project_select);

        $('#invoices_talep_onay_report').DataTable().destroy();
        invoices_talep_onay_report(page,employee_select,project_select);


        $('.custom-select').val(val)
        $('.custom-select').change()


    });


    $(document).ready(function (){


        invoices_cari_talep_onay_report('all',0,0);
        invoices_cari_avans_onay_report('all',0,0);
        invoices_talep_onay_report('all',0,0);

    })
    function invoices_cari_talep_onay_report(page,pers_id,proje_id){
        $('#invoices_cari_talep_onay_report').DataTable({
            autoWidth: false,
            select: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [ 10,100,-1],
                [10,100,"Tümü"]
            ],
            'ajax': {
                'url': baseurl+'/onay/invoices_cari_onay_report',
                'type': 'POST',
                'data': {
                    tip:1,
                    page: page,
                    pers_id: pers_id,
                    proje_id:proje_id
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [ 4 ]
            }],
            dom: 'Blfrtip',
            buttons: []
        });
    }
    function invoices_cari_avans_onay_report(page,pers_id,proje_id){
        $('#invoices_cari_avans_onay_report').DataTable({
            autoWidth: false,
            select: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [ 10,100,-1],
                [10,100,"Tümü"]
            ],
            'ajax': {
                'url': baseurl+'/onay/invoices_cari_onay_report',
                'type': 'POST',
                'data': {
                    tip:2,
                    page: page,
                    pers_id: pers_id,
                    proje_id:proje_id
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [ 4 ]
            }],
            dom: 'Blfrtip',
            buttons: []
        });
    }
    function invoices_talep_onay_report(page,pers_id,proje_id){
        $('#invoices_talep_onay_report').DataTable({
            autoWidth: false,
            select: true,
            processing: true,
            serverSide: true,
            aLengthMenu: [
                [ 10,100,-1],
                [10,100,"Tümü"]
            ],
            'ajax': {
                'url': baseurl+'/onay/invoices_talep_onay_report',
                'type': 'POST',
                'data': {
                    tip:1,
                    page: page,
                    pers_id: pers_id,
                    proje_id:proje_id
                }
            },
            columnDefs: [{
                orderable: false,
                targets: [ 4 ]
            }],
            dom: 'Blfrtip',
            buttons: []
        });
    }


    $(document).on('click','.talep_bildirimi_gonder',function (){
        let pers_id = $(this).attr('pers_id');
        let talep_type = $(this).attr('talep_type');
        let baslik='';
        let code= $(this).attr('code');
        let content_message='';
        if(talep_type=='cari_gider'){
            baslik='Cari Gider Talebi İçin Mail Bildirimi!'
            content_message=' Lütfen Onayınızda Bekleyen '+code+' olan Cari Gider Talebini Onaylayınız';
        }
        else if(talep_type=='cari_avans'){
            baslik='Cari Avans Talebi İçin Mail Bildirimi!'
            content_message=' Lütfen Onayınızda Bekleyen '+code+' olan Cari Avans Talebini Onaylayınız';
        }
        else if(talep_type=='mt_talep'){
            baslik='Malzeme Talebi İçin Mail Bildirimi!'
            content_message=' Lütfen Onayınızda Bekleyen '+code+' olan Malzeme Talebini Onaylayınız';
        }

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: baslik,
            icon: 'fa fa-envelope',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<input value="'+content_message+'" class="content_message form-control"><p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Mail Bildirimi Yap',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            pers_id: pers_id,
                            baslik: baslik,
                            content_message: $('.content_message').val(),
                        }
                        $.post(baseurl + 'malzemetalep/dashboard_mail',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-chechk',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.messages,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                location.reload();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Dikkat!',
                                    content: responses.messages,
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
    })
</script>


