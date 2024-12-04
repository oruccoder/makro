<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bekleyen Razılaştırmalar</span></h4>
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
                        <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th>Cari</th>
                                <th>Proje</th>
                                <th>Razılaştırma No</th>
                                <th>Muqavele No</th>
                                <th>Geçerlilik Tarihi</th>
                                <th>Odeme Şekli</th>
                                <th>PDF</th>
                                <th>Onay Durumu</th>
                                <th>İşlemler</th>
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

        var url = '<?php echo base_url() ?>razilastirma/file_handling';



        function new_draw_data(prje_id){
            $('#todotable').DataTable().destroy();
            $('#todotable').DataTable({
                "processing": true,
                "serverSide": true,
                aLengthMenu: [
                    [ 10, 50, 100, 200,-1],
                    [10, 50, 100, 200,"Tümü"]
                ],
                'createdRow': function (row, data, dataIndex) {
                    $(row).attr('data-block', '0');
                    $(row).attr('style', data[13]);
                },
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('razilastirma/todo_load_list_forma2')?>",
                    "type": "POST",
                    data: {'pid': prje_id, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                "columnDefs": [
                    {
                        "targets": [1],
                        "orderable": true,
                    },
                ],

            });
        }

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
                    'url': "<?php echo site_url('razilastirma/ajax_list_bekleyen')?>",
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

        $(document).on('click','.view',function (){
            let id = $(this).attr('data-object-id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'RAZILAŞTIRMA PROTOKOLÜ',
                icon: 'fa fa-check',
                type: 'green',
                animation: 'scale',
                columnClass: 'small',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<label>Proje</label></br>' +
                        '<b><span id="proje_id"></span></b>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Ödeme Şekli</label></br>' +
                        '<b><span id="odeme_sekli"></span></b>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Oran</label></br>' +
                        '<b><span id="oran"></span></b>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Muqavele No</label></br>' +
                        '<b><span id="muqavele_no"></span></b>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Geçerlilik Tarihi</label></br>' +
                        '<b><span id="date"></span></b>' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>PDF</label></br>' +
                        '<b><span id="pdf"></span></b>' +
                        '</div>' +
                        '<div class="form-group table_rp_view">'+
                        '</div>' +
                        '</form>';


                    let data = {
                        crsf_token: crsf_hash,
                        id: id,
                    }

                    let table_report='';
                    $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        let responses = jQuery.parseJSON(response);
                        $('#proje_id').empty().html(responses.details.proje_name)
                        $('#odeme_tipi').empty().html(responses.details.odeme_tipi_name)
                        $('#odeme_sekli').empty().html(responses.details.odeme_sekli_name)
                        $('#oran').empty().html(responses.details.oran)
                        $('#muqavele_no').empty().html(responses.details.muqavele_no)
                        $('#date').empty().html(responses.details.date)
                        $('#pdf').empty().html("<a href='/userfiles/product/"+responses.details.file+"' class='btn btn-info' target='_blank'>PDF GÖRÜNTÜLE</a>")

                        table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Görülecek İş</th>
                                <th>Birim Fiyatı</th>
                                <th>Miktarı</th>
                            </tr>
                        </thead><tbody id="todo_tbody">`;

                        responses.item_details.forEach((item_,index) => {
                            table_report+=` <tr>
                                            <td>`+item_.name+`</td>
                                            <td>`+item_.price+`</td>
                                            <td>`+item_.qty+`</td>
                                            </tr>`;
                        });


                        table_report+=`</tbody></table>`;
                        $('.table_rp_view').empty().html(table_report);


                    });

                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
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

        $(document).on('click','.razilastirma_onay',function (){
            let id = $(this).attr('data-object-id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'RAZILAŞTIRMA PROTOKOLÜ DURUM BİLDİR',
                icon: 'fa fa-question',
                type: 'orange',
                animation: 'scale',
                columnClass: 'Small',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<label>Açıklama</label></br>' +
                        '<input type="text" placeholder="İnceledim Onayladım" id="desc" class="form-control">' +
                        '</div>' +
                        '<div class="form-group">' +
                        '<label>Durum</label></br>' +
                        '<select class="form-control" id="status"><option value="1">Onayla</option><option value="2">İptal Et</option></select>' +
                        '</div>' +
                        '</form>';


                    let data = {
                        crsf_token: crsf_hash,
                        id: id,
                    }

                    let table_report='';
                    $.post(baseurl + 'razilastirma/get_razi_info',data,(response) => {
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
                        text: 'Durum Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            var status = this.$content.find('#status').val();
                            var desc = this.$content.find('#desc').val();
                            if(status==2){
                                if(!desc){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Dikkat!',
                                        content: 'İptal Ettiğiniz Halde Açıklama Girmek Zorunludur',
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
                                    let placeholder = this.$content.find('#desc').attr('placeholder');
                                    let value = this.$content.find('#desc').val();
                                    if(value.length == 0){
                                        desc = placeholder;
                                    }

                                }

                            }

                            let data = {
                                id:id,
                                desc:desc,
                                status:status,
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'razilastirma/onay_olustur',data,(response)=>{
                                $('#loading-box').addClass('d-none');
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
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
                                                    draw_data()

                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status=='Error'){

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
                                    $('#loading-box').addClass('d-none');
                                }
                            });







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

    </script>
