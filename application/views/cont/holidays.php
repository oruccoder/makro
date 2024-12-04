<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Tatil Günleri</span></h4>
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
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="invoices"  class="table display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tarih</th>
                                                <th>Açıklama</th>
                                                <th>İşlem</th>

                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </tfoot>

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
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    .multiselect-container>li{
        width: max-content !important;
    }

    select:invalid{
        color: gray;
    }
    .select2 {
        width: max-content !important; ;
    }


</style>



<div id="person-container" class="d-none">
    <div class="media-list p-2" id="person-list"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.19/daterangepicker.css" integrity="sha512-DG39shQ6p6XXWvyFHLmDiSkWvNcHJlcsyrPtTSyM2SvSeK+nHxsKYWxtvrIJNSo+PwhzNNqOZoeM4IM3YN57Mw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.19/daterangepicker.js" integrity="sha512-6LIPT63EUP55i7cSGGfeKhSq/XlfrZhbR9cVVQrjCe0HtA6XSwID9DnQCCC9C8hsWMV0sJ7QC4brSUnEYBxVqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" integrity="sha512-S1l1mfpQS+XBPSgS8cCqElwRx24IcAYrwxLJg6WaFkG9J8bfNuilkoqkGny/rz7jS7Bo03qnzeBtE9LElt/fDg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js" integrity="sha512-51zCUepQrZHYlWe4Sb3sbjdjbIjYuYFRIQ0s55cUM+65qRN4PlwuFnwPdtKW5xsPXHqjn5r/mJtgxbr7fahsTA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>


<script type="text/javascript">

    $(document).on('click', ".pop_model_desc", function (e) {
        e.preventDefault();
        var cont_id=$(this).attr('cont_id')

        $('#pop_model_desc').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'controller/desc';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+cont_id,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#aciklama').html(data);

            }

        });

    });

    let table='';



    function draw_data(start_date = '',hesap_yil='') {

        table = $('#invoices').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            fixedHeader: true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[28]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('controller/holidays_ajax')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    start_date: start_date,
                    hesap_yil: hesap_yil,
                }
            },
            'columnDefs': [
                {
                    'targets': [0,3],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Bildirim Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'material',
                            closeIcon: true,
                            title: 'Tatil Bidirimi',
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
                                    '<div class="form-group">' +
                                    '<label>Açıklama</label>' +
                                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control" />' +
                                    '</div>' +
                                    '<div class="form-group">' +
                                    '<label>Tarih</label>' +
                                    '<input type="date" id="start_date" class="form-control name" >' +
                                    '</div>' +
                                    '</form>';

                                let data = {
                                    crsf_token: crsf_hash,
                                }


                                $.post(baseurl + 'employee/projeler',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    });
                                    let responses = jQuery.parseJSON(response);
                                });



                                return $('#person-container').html();
                            },
                            onContentReady:function (){

                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Girişi Yap',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');
                                        var name = this.$content.find('.name').val();
                                        if(!name){
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
                                            $('#loading-box').addClass('d-none');
                                        }
                                        let desc = $('#desc').val()
                                        let start_date = $('#start_date').val()
                                        jQuery.ajax({
                                            url: baseurl + 'controller/holidays_add',
                                            dataType: "json",
                                            method: 'post',
                                            data: 'start_date='+start_date+'&desc='+desc+'&'+crsf_token+'='+crsf_hash,
                                            beforeSend: function(){
                                                $('#loading-box').removeClass('d-none');

                                            },
                                            success: function (data) {
                                                if (data.status == "Success") {
                                                    $.alert(data.message);
                                                    $('#loading-box').addClass("d-none");

                                                } else {
                                                    $.alert(data.message);
                                                    $('#loading-box').addClass("d-none");

                                                }

                                                let start_date = $('#hesap_ay').val();
                                                let hesap_yil = $('#hesap_yil').val();
                                                $('#invoices').DataTable().destroy();
                                                draw_data(start_date,hesap_yil)
                                            },
                                            error: function (data) {
                                                $.alert(data.message);
                                                $('#loading-box').addClass("d-none");
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
                },

                {
                    extend: 'excelHtml5',
                    footer: true,

                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });
        $('#invoices tfoot').css('display','none');
    };


    $(document).ready(function () {

        $('.select-box').select2();
        $('#table_visable').multiselect({
            enableHTML: true,
            nonSelectedText:'Göster / Gizle',
            onChange: function(element, checked) {
                let  column = table.column( element.val() );
                if(checked){

                    column.visible(true);
                }
                else {
                    column.visible(false);

                }
            }
        });




        draw_data();


    });

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');


        if(status){
            $('.one_select').prop('checked',true)

        }
        else {
            $('.one_select').prop('checked',false)
        }


    })



    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }



    $(document).on('change','#hesap_ay',function (e){
        let id=  $(this).val();
        let hesap_yil = $('#hesap_yil').val();
        $('#invoices').DataTable().destroy();
        draw_data(id,hesap_yil);
    })
    $(document).on('change','#hesap_yil',function (e){
        let id=  $(this).val();
        let hesap_ay = $('#hesap_ay').val();
        $('#invoices').DataTable().destroy();
        draw_data(hesap_ay,id);
    })

    $(document).on('click','.delete_job',function (){

        let job_id = $(this).attr('id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
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
                    '<div class="form-group">' +
                    '<p>İptal Etmek Üzeresiniz Emin Misiniz?<p/>'+
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady:function (){
            },
            buttons: {
                formSubmit: {
                    text: 'Eminim',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            id:job_id,
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'controller/cancel_holidays',data,(response)=>{
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
                                    content: 'Başarılı Bir Şekilde İptal Edildi!',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                let start_date = $('#hesap_ay').val();
                                let hesap_yil = $('#hesap_yil').val();
                                $('#invoices').DataTable().destroy();
                                draw_data(start_date,hesap_yil)
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
                                    content: 'Hata Aldınız! Yöneticiye Başvurun',
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

    $(document).on('click', ".update", function (e) {
        let id = $(this).attr('id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Tatil Bidirimi',
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
                    '<div class="form-group">' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="Açıklama" class="form-control" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Tarih</label>' +
                    '<input type="date" id="start_date" class="form-control name" >' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    id: id,
                }


                $.post(baseurl + 'controller/holidays_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    $('#desc').val(responses.details.description);
                    $('#start_date').val(responses.details.date);
                });



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
                        var name = this.$content.find('.name').val();
                        if(!name){
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
                            $('#loading-box').addClass('d-none');
                        }
                        let desc = $('#desc').val()
                        let start_date = $('#start_date').val()
                        jQuery.ajax({
                            url: baseurl + 'controller/holidays_update',
                            dataType: "json",
                            method: 'post',
                            data: 'id='+id+'&start_date='+start_date+'&desc='+desc+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $('#loading-box').removeClass('d-none');

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    $('#loading-box').addClass("d-none");

                                } else {
                                    $.alert(data.message);
                                    $('#loading-box').addClass("d-none");

                                }

                                let start_date = $('#hesap_ay').val();
                                let hesap_yil = $('#hesap_yil').val();
                                $('#invoices').DataTable().destroy();
                                draw_data(start_date,hesap_yil)
                            },
                            error: function (data) {
                                $.alert(data.message);
                                $('#loading-box').addClass("d-none");
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
