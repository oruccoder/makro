<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">BORDRO DÜZENLEMEDE BEKLEYEN PERSONELLER</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">

                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>


                <div class="col-md-2">
                    <button class="btn btn-success" id="status_chage">Seçili Olanlara Durum Bildir</button>
                </div>

                <hr>
                <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>

                        <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                        <th><?php echo $this->lang->line('Employee') ?></th>
                        <th>Bordro Tarihi</th>
                        <th>Düzenleme İsteyen Personel</th>
                        <th>Düzenleme Talep Tarihi</th>
                        <th>İşlem</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
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


<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>
<script type="text/javascript">

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })

    $(document).ready(function () {
        draw_data();

    });
    function draw_data() {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('raporlar/ajax_edit_report')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
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
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
                {
                    messageTop: "<div style='text-align: center'><img src='http://muhasebe.italicsoft.com/userfiles/company/16058809601269056269.png?t=88' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',

                    footer: true,
                    title:"<h3 style='text-align: center'>Personel Kesintisi</h3>",
                    exportOptions: {
                        columns: [0, 1, 2, 3]
                    }
                },
            ],

        });
    };
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('click', ".view", function (e) {
        let edit_id = $(this).attr('edit_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "large",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;

                html+='<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<h3 style="text-align: center;">Talep Edilen Tutarlar</h3><div class="tables"></div>'+
                    '</div>' +
                    '</form>';


                let data = {
                    crsf_token: crsf_hash,
                    edit_id: edit_id,
                }
                let table_report ='';
                $.post(baseurl + 'raporlar/edit_details_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);

                    table_report +=`<table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Toplam Avans</th>
                                                                    <th>Banka Avans</th>
                                                                    <th>Nakit Avans</th>
                                                                    <th>Kesilecek Banka T.</th>
                                                                    <th>Kesilecek Nakit T.</th>
                                                                    <th>Nakit Geri Ö.</th>
                                                                    <th>Bankadan Ödenilecek</th>
                                                                    <th>Bankadan Hakediş</th>
                                                                    <th>Nakit Ödenilecek</th>
                                                                    <th>Nakit Hakediş</th>
                                                                </tr>
                                                            </thead>
                                                           <tbody>`;
                    responses.old_data.forEach((item_,index) => {
                        table_report +=`<tr>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.toplam_avans+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.banka_avans+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.nakit_avans+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.aylik_kesinti+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.aylik_kesinti_nakit+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.nakit_geri_odenen+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.odenilecek_meblaq+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.banka_hakedis+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.nakit_odenilecek+`</td>
                                                                                <td style="text-align: center;font-weight: 900;">`+item_.nakit_hakedis+`</td>
                                                                            </tr>`;
                    })
                    responses.new_data.forEach((item_,index) => {
                        table_report +=`<tr>
                                                                                <td><input class="form-control toplam_avans" value="`+item_.toplam_avans+`" type="number"></td>
                                                                                <td><input class="form-control banka_avans" value="`+item_.banka_avans+`" type="number"></td>
                                                                                <td><input class="form-control nakit_avans" value="`+item_.nakit_avans+`" type="number"></td>
                                                                                <td><input class="form-control aylik_kesinti" value="`+item_.aylik_kesinti+`" type="number"></td>
                                                                                <td><input class="form-control aylik_kesinti_nakit" value="`+item_.aylik_kesinti_nakit+`" type="number"></td>
                                                                                <td><input class="form-control nakit_geri_odenen" value="`+item_.nakit_geri_odenen+`" type="number"></td>
                                                                                <td><input class="form-control odenilecek_meblaq" value="`+item_.odenilecek_meblaq+`" type="number"></td>
                                                                                <td><input class="form-control banka_hakedis" value="`+item_.banka_hakedis+`" type="number"></td>
                                                                                <td><input class="form-control nakit_odenilecek" value="`+item_.nakit_odenilecek+`" type="number"></td>
                                                                                <td><input class="form-control nakit_hakedis" rep_id="`+item_.rep_id+`" value="`+item_.nakit_hakedis+`" type="number"></td>
                                                                            </tr>`;
                    })

                    table_report +=`</tbody></table>`;
                    $('.tables').empty().html(table_report);

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
                        let salary_details=[];
                        $('#loading-box').removeClass('d-none');
                        $('.nakit_hakedis').each((index,item) => {
                            salary_details.push({
                                rep_id : $(item).attr('rep_id'),
                                edit_id : edit_id,
                                nakit_hakedis : $(item).val(),
                                nakit_odenilecek : $('.nakit_odenilecek').eq(index).val(),
                                banka_hakedis : $('.banka_hakedis').eq(index).val(),
                                odenilecek_meblaq : $('.odenilecek_meblaq').eq(index).val(),
                                nakit_geri_odenen : $('.nakit_geri_odenen').eq(index).val(),
                                aylik_kesinti_nakit : $('.aylik_kesinti_nakit').eq(index).val(),
                                aylik_kesinti : $('.aylik_kesinti').eq(index).val(),
                                nakit_avans : $('.nakit_avans').eq(index).val(),
                                banka_avans : $('.banka_avans').eq(index).val(),
                                toplam_avans : $('.toplam_avans').eq(index).val(),
                            })
                        });

                        let data_confirm = {
                            crsf_token: crsf_hash,
                            details:salary_details
                        }

                        $.post(baseurl + 'raporlar/edit_details_update',data_confirm,(response) => {
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
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

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
                            return false;
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

    $(document).on('click',"#status_chage",function (e){
        let checked_count = $('.one_select:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir Personel Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }
        else {
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content: '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<input class="form-control" id="desc" placeholder="İnceledim">'+
                    '</div>' +
                    '<div class="form-group">' +
                    '<select id="status" class="form-control"><option value="2">Onayla</option><option value="3">İptal Et</option></select>'+
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {

                            let placeholder = $('#desc').attr('placeholder');
                            let desc = $('#desc').val();
                            if(desc.length == 0){
                                desc = placeholder;
                            }

                            let edit_table_id = [];
                            $('.one_select:checked').each((index,item) => {
                                edit_table_id.push($(item).attr('edit_id'))
                            });
                            let data = {
                                crsf_token: crsf_hash,
                                status: $('#status').val(),
                                edit_table_id: edit_table_id,
                                desc: desc
                            }

                            $.post(baseurl + 'raporlar/edit_table_status',data,(response) => {
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
                                        content: responses.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    $('#invoices').DataTable().destroy();
                                    draw_data();
                                    return false;

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
                                return false;
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
        }
    })


</script>
