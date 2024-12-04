<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></h4>

        </div>
        </div>
        </div>

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>



            <div class="content">
                <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" id="dpic" class="rounded-circle img-border height-150"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>

                        <!-- Menü Ekle -->
                        <?php $this->load->view('customers/customer_menu'); ?>


                    </div>
                    <div class="col-md-10">
                        <div id="mybutton" class="mb-1">

                            <div class="">
                                <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                            class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?>
                                </a>
                                <a href="#sendMail" data-toggle="modal" data-remote="false"
                                   class="btn btn-primary btn-md " data-type="reminder"><i
                                            class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                </a>


                                <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                   class="btn btn-info btn-md"><i
                                            class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                </a>


                                <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
                                   class="btn btn-danger btn-md"><i
                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                </a>
                            </div>

                        </div>
                        <hr>
                        <h4>Hizmet Razılaştırmaları</h4>
<!--                        <button type="button" style="margin-top: 20px" id="new_razilastirma" cari_id="--><?php //echo $details['id'] ?><!--" class="btn btn-info"><i class="fa fa-plus"></i>  Yeni Razılaştırma</button>-->
<!--                    -->

                        <table id="invoices" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th>Proje</th>
                                <th>R. No</th>
                                <th>Muqavele No</th>
                                <th>Geçerlilik Tarihi</th>
                                <th>Ödeme Tipi</th>
                                <th>Odeme Şekli</th>
                                <th>Oran</th>
                                <th>PDF</th>
                                <th>Onay Durumu</th>
                                <th>Prt Durumu</th>
                                <th>İşlemler</th>


                            </tr>
                            </thead>
                            <tbody>
                            </tbody>

                            <tfoot>
                            <tr>

                                <th>Proje</th>
                                <th>R. No</th>
                                <th>Muqavele No</th>
                                <th>Geçerlilik Tarihi</th>
                                <th>Ödeme Tipi</th>
                                <th>Odeme Şekli</th>
                                <th>Oran</th>
                                <th>PDF</th>
                                <th>Onay Durumu</th>
                                <th>Prt Durumu</th>
                                <th>İşlemler</th>

                            </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>


            </div>
        </div>
    </div>


    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        var url = '<?php echo base_url() ?>razilastirma/file_handling';



        $(document).on('click', "#new_razilastirma", function (e) {
            let cari_id = $(this).attr('cari_id');
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'RAZILAŞTIRMA PROTOKOLÜ',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                columnClass: 'xlarge',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group">'+
                        '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<label>Proje</label>' +
                        '<select id="proje_id" class="form-control select-box"></select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Ödeme Tipi</label>' +
                        '<select id="odeme_tipi" class="form-control select-box"></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Ödeme Şekli</label>' +
                        '<select id="odeme_sekli" class="form-control select-box"></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Para Birimi</label>' +
                        '<select id="cur_id" class="form-control select-box"></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>KDV Durumu</label>' +
                        '<select id="tax_status" class="form-control select-box"><option value="yes">Dahil</option><option value="no">Hariç</option></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>KDV Oranı</label>' +
                        '<input type="number" class="form-control" id="tax_oran">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Avans Oranı</label>' +
                        '<input type="number" class="form-control" id="oran">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Muqavele No</label>' +
                        '<input type="text" class="form-control" id="muqavele_no">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Açıklama</label>' +
                        '<input type="description" class="form-control" id="description">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Geçerlilik Tarihi</label>' +
                        '<input type="date" class="form-control" id="date">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Proje Müdürü</label>' +
                        '<select id="proje_mudur_id" class="form-control select-box"></select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Genel Müdür</label>' +
                        '<select id="genel_mudur_id" class="form-control select-box"></select>' +
                        '</div>' +

                        '<div class="col-md-12">'+`
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <table id="files" class="files"></table>
                                        <br>
                                        <span class="btn btn-success fileinput-button" style="width: 100%">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Protokol İmzalı Dosya...</span>
                                        <input id="fileupload_" type="file" name="files[]">
                                        <input type="hidden" class="image_text" name="image_text" id="image_text">
                                        </span>`+
                        '</div>' +
                        '<div class="col-md-12 mt-2">' +
                        '<button class="btn btn-succes" type="button" id="get_task">Görülecek İşleri Getir</button>' +
                        '</div>' +
                        '<div class="col-md-12 table_rp mt-2">'+
                        '</div>' +
                        '</div>' +




                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    let table_report='';
                    $.post(baseurl + 'razilastirma/get_tables',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        let responses = jQuery.parseJSON(response);
                        responses.projeler.forEach((item_,index) => {
                            $('#proje_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.odeme_tipi.forEach((item_,index) => {
                            $('#odeme_tipi').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.odeme_metodlari.forEach((item_,index) => {
                            $('#odeme_sekli').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.personeller.forEach((item_,index) => {
                            $('#proje_mudur_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.personeller.forEach((item_,index) => {
                            $('#genel_mudur_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.para_birimleri.forEach((item_,index) => {
                            $('#cur_id').append(new Option(item_.code, item_.id, false, false)).trigger('change');
                        })
                        $('#fileupload_').fileupload({
                            url: url,
                            dataType: 'json',
                            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                            done: function (e, data) {
                                var img='default.png';
                                $.each(data.result.files, function (index, file) {
                                    img=file.name;
                                });

                                $('#image_text').val(img);
                            },
                            progressall: function (e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                $('#progress .progress-bar').css(
                                    'width',
                                    progress + '%'
                                );
                            }
                        }).prop('disabled', !$.support.fileInput)
                            .parent().addClass($.support.fileInput ? undefined : 'disabled');


                        table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Görülecek İş</th>
                                <th>Aşama</th>
                                <th>Birim Fiyatı</th>
                                <th>Miktarı</th>
                                 <th>Birim</th>
                                <th>Toplam Tutar</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody id="todo_tbody">

                        </tbody>

                    </table>`;
                        $('.table_rp').empty().html(table_report);
                    });


                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Protokol Oluştur',
                        btnClass: 'btn-blue',
                        action: function () {
                            var image_text = this.$content.find('#image_text').val();
                            var pid = this.$content.find('.pid').val();
                            var oran = this.$content.find('#oran').val();
                            if(!image_text){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'PDF Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }
                            if(!oran){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Oran Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

                            }
                            if(!pid){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Lütfen İş Kalemi Seçiniz',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

                            }
                            let product_details = [];
                            let count = $('input[name="price[]"]').length;
                            for (let i=0; i < count; i++){
                                product_details.push({
                                    'pid':$('.pid').eq(i).val(),
                                    'qty':$('.qty').eq(i).val(),
                                    'price':$('.price').eq(i).val(),
                                    'unit_id':$('.unit_id').eq(i).val(),
                                    'toplam_tutar':$('.item_toplam_tutar_hidden').eq(i).val(),
                                });
                            }
                            let data = {
                                proje_id:$('#proje_id').val(),
                                cur_id:$('#cur_id').val(),
                                tax_status:$('#tax_status').val(),  // KDV DURUMu
                                tax_oran:$('#tax_oran').val(),  // KDV Oranı
                                description:$('#description').val(),
                                muqavele_no:$('#muqavele_no').val(),
                                date:$('#date').val(),
                                oran:$('#oran').val(),
                                cari_id:cari_id,
                                odeme_tipi:$('#odeme_tipi').val(),
                                odeme_sekli:$('#odeme_sekli').val(),
                                image_text:$('#image_text').val(),
                                genel_mudur_id:$('#genel_mudur_id').val(),
                                proje_mudur_id:$('#proje_mudur_id').val(),
                                product_details:product_details,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'razilastirma/save_razilastirma',data,(response)=>{
                                $('#loading-box').removeClass('d-none');
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
                                                    $('#loading-box').addClass('d-none');
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data()

                                                }
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');

                                }
                                else if(responses.status=='Error'){

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
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


        $(document).on('click', "#get_task", function (e) {
            $.confirm({
                theme: 'modern',
                icon: 'fa fa-check',
                type: 'green',
                title: 'RAZILAŞTIRMA PROTOKOLÜ',
                animation: 'scale',
                columnClass: 'xlarge',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+=`<div class="modal-body">
                <table id="todotable"class="table table-striped table-bordered zero-configuration" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Adı</th>
                        <th>Aşama</th>
                        <th>Bölüm</th>
                        <th>Miktar</th>
                    </tr>
                    </thead>
                    <tbody >

                    </tbody>

                </table>
            </div>`;

                    let data = {
                        crsf_token: crsf_hash,
                    }

                    let table_report='';
                    $.post(baseurl + 'razilastirma/get_tables',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });
                        let responses = jQuery.parseJSON(response);
                        new_draw_data($('#proje_id').val())
                    });

                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Seçilenleri Listeye Ekle',
                        btnClass: 'btn-blue',
                        action: function () {
                            let selected_id = [];
                            if($('.task_id:checked').length > 0){
                                $('.task_id:checked').each((index,item) => {
                                    let id = parseInt($(item).val());
                                    if(id > 0){
                                        selected_id.push({
                                            'pid':id,
                                            'bolum':$(item).attr('proje_bolum_name'),
                                            'bolum_id':$(item).attr('proje_bolum_id'),
                                            'asama':$(item).attr('ana_asama_name'),
                                            'asama_id':$(item).attr('ana_asama_id'),
                                            'product_name':$(item).attr('hizmet_name'),
                                            'birim_fiyati':$(item).attr('birim_fiyati'),
                                            'quantity_':$(item).attr('quantity_'),
                                            'total_fiyat':$(item).attr('total_fiyat'),
                                            'unit_id':$(item).attr('unit_id'),
                                            'unit_name':$(item).attr('unit_name'),
                                        });
                                    }
                                });
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
                                    content: 'En Az 1 İş Kalemi Seçmelisiniz',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }


                            let count=0;

                            let options='';

                            let data_post_ = {
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'razilastirma/birimler',data_post_,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $.each(responses.birimler,function (index){
                                    options+=`<option value='`+responses.birimler[index].id+`'>`+responses.birimler[index].name+`</option>`;
                                })
                            })

                            setTimeout(function(){
                                let q=0;
                                for (let i = 0 ; i < selected_id.length; i++){

                                    q = parseInt($('.qty').length);


                                    var cvalue = i;
                                    var functionNum = "'" + cvalue + "'";
                                    let pid=selected_id[i].pid;
                                    let product_name=selected_id[i].product_name;
                                    let asama_name=selected_id[i].asama;
                                    let unit_id=selected_id[i].unit_id;
                                    let quantity_=selected_id[i].quantity_;
                                    let birim_fiyati=selected_id[i].birim_fiyati;
                                    let total_fiyat=selected_id[i].total_fiyat;

                                    let quantity="<input onkeyup='item_hesap("+q+")'  eq='"+q+"' type='number' value='"+quantity_+"' class='form-control qty' name='qty[]'><input type='hidden' class='pid' value='"+pid+"' name='pid[]'>"
                                    let price="<input onkeyup='item_hesap("+q+")' eq='"+q+"' type='number' value='"+birim_fiyati+"' class='form-control price' name='price[]'>"
                                    let toplam_tutar = "<span class='item_toplam_tutar'>"+total_fiyat+"</span><input type='hidden' class='item_toplam_tutar_hidden' value='"+total_fiyat+"'>";

                                    let birim="<select class='form-control unit_id' name='unit_id[]'>"+options+"</select>";
                                    let status="<button  type='button' class='btn btn-danger removeProd'>Sil</button>"


                                    var data = `<tr>
                                    <td>`+product_name+`</td>
                                    <td>`+asama_name+`</td>
                                    <td>`+price+`</td>
                                    <td>`+quantity+`</td>
                                    <td>`+birim+`</td>
                                    <td>`+toplam_tutar+`</td>
                                    <td>`+status+`</td>
                                    </tr>`;
                                    //ajax request
                                    // $('#saman-row').append(data);
                                    $('#invoices_report tbody').append(data);
                                    $('.unit_id').eq(q).val(unit_id);
                                    q++;
                                    function item_hesap(eq){
                                        let item_qty= $('.qty').eq(eq).val();
                                        let item_price= $('.price').eq(eq).val();
                                        let toplam_tutar = parseFloat(item_price) *parseFloat(item_qty);
                                        $('.item_toplam_tutar').eq(eq).empty().text(toplam_tutar.toFixed(2))
                                        $('.item_toplam_tutar_hidden').eq(eq).val(toplam_tutar.toFixed(2))
                                    }


                                }
                            }, 1000);






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
        $(document).on('click', '.removeProd', function () {
            $(this).closest('tr').remove();
            return false;
        });

        function new_draw_data(prje_id){
            $('#todotable').DataTable().destroy();
            $('#todotable').DataTable({
                "processing": true,
                "serverSide": true,
                aLengthMenu: [
                    [ 100, 10, 50, 200,-1],
                    [100, 10, 50, 200,"Tümü"]
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
                    'url': "<?php echo site_url('razilastirma/ajax_list')?>",
                    'type': 'POST',
                    'data': {'cid':<?php echo $id ?>, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
            });
        }

        $(document).on('click','.view',function (){
            let id = $(this).attr('data-object-id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'RAZILAŞTIRMA PROTOKOLÜ',
                icon: 'fa fa-eye',
                type: 'green',
                animation: 'scale',
                columnClass: 'xlarge',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<label>Proje</label></br>' +
                        '<b><span id="proje_id"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Ödeme Tipi</label></br>' +
                        '<b><span id="odeme_tipi"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Ödeme Şekli</label></br>' +
                        '<b><span id="odeme_sekli"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Para Birimi</label></br>' +
                        '<b><span id="cur_id"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>KDV Durum</label></br>' +
                        '<b><span id="kdv_durum"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>KDV Oranı</label></br>' +
                        '<b><span id="kdv_oran"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Avans Oranı</label></br>' +
                        '<b><span id="oran"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Muqavele No</label></br>' +
                        '<b><span id="muqavele_no"></span></b>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Geçerlilik Tarihi</label></br>' +
                        '<b><span id="date"></span></b>' +
                        '</div>' +
                        '<div class="col-md-12">' +
                        '<label>PDF</label></br>' +
                        '<b><span id="pdf"></span></b>' +
                        '</div>' +
                        '<div class="col-md-12 table_rp_view">'+
                        '</div>' +
                        '</div>' +
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
                        $('#cur_id').empty().html(responses.cur_name)
                        $('#kdv_durum').empty().html(responses.tax_durum)
                        $('#kdv_oran').empty().html(responses.details.tax_oran)
                        $('#pdf').empty().html("<a href='/userfiles/product/"+responses.details.file+"' class='btn btn-info' target='_blank'>PDF GÖRÜNTÜLE</a>")

                        table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Görülecek İş</th>
                                <th>Birim Fiyatı</th>
                                <th>Miktarı</th>
                                <th>Birim</th>
                                <th>Toplam Tutar</th>
                            </tr>
                        </thead><tbody id="todo_tbody">`;

                        responses.item_details.forEach((item_,index) => {
                            table_report+=` <tr>
                                            <td>`+item_.name+`</td>
                                            <td>`+item_.price+`</td>
                                            <td>`+item_.qty+`</td>
                                            <td>`+item_.unit_name+`</td>
                                            <td>`+item_.toplam_tutar+`</td>
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
        $(document).on('click','.edit',function (){
            let id = $(this).attr('data-object-id');
            $.confirm({
                theme: 'material',
                closeIcon: true,
                title: 'RAZILAŞTIRMA PROTOKOLÜ',
                icon: 'fa fa-exclamation',
                type: 'dark',
                animation: 'scale',
                columnClass: 'xlarge',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group">' +
                        '<div class="row">' +
                        '<div class="col-md-6">' +
                        '<label>Proje</label>' +
                        '<select id="proje_id" class="form-control select-box"></select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Ödeme Tipi</label>' +
                        '<select id="odeme_tipi" class="form-control select-box"></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Ödeme Şekli</label>' +
                        '<select id="odeme_sekli" class="form-control select-box"></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Para Birimi</label>' +
                        '<select id="cur_id" class="form-control select-box"></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>KDV Durumu</label>' +
                        '<select id="tax_status" class="form-control select-box"><option value="yes">Dahil</option><option value="no">Hariç</option></select>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>KDV Oranı</label>' +
                        '<input type="number" class="form-control" id="tax_oran">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Avans Oranı</label>' +
                        '<input type="number" class="form-control" id="oran">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Muqavele No</label>' +
                        '<input type="text" class="form-control" id="muqavele_no"><input type="hidden" id="razilastirma_id">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Açıklama</label>' +
                        '<input type="description" class="form-control" id="description">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Geçerlilik Tarihi</label>' +
                        '<input type="date" class="form-control" id="date">' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Proje Müdürü</label>' +
                        '<select id="proje_mudur_id" class="form-control select-box"></select>' +
                        '</div>' +
                        '<div class="col-md-6">' +
                        '<label>Genel Müdür</label>' +
                        '<select id="genel_mudur_id" class="form-control select-box"></select>' +
                        '</div>' +
                        '<div class="col-md-12">'+`
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                        <table id="files" class="files"></table>
                                        <br>
                                        <span class="btn btn-success fileinput-button" style="width: 100%">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Protokol İmzalı Dosya...</span>
                                        <input id="fileupload_" type="file" name="files[]">
                                        <input type="hidden" class="image_text" name="image_text" id="image_text">
                                        </span>`+
                        '</div>' +
                        '<div class="col-md-12 mt-2">' +
                        '<button class="btn btn-succes" type="button" id="get_task">Görülecek İşleri Getir</button>' +
                        '</div>' +
                        '<div class="col-md-12 table_rp mt-2">'+
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">'+
                    '<thead>'+
                    '       <tr>'+
                    '           <th>Görülecek İş</th>'+
                    '           <th>Aşama</th>'+
                    '           <th>Birim Fiyatı</th>'+
                    '           <th>Miktarı</th>'+
                    '           <th>Birim</th>'+
                    '           <th>Toplam Tutar</th>'+
                    '           <th>İşlem</th>'+
                    '       </tr>'+
                    '       </thead><tbody id="todo_tbody"></tbody></table>'+
                        '</form>';


                    let data = {
                        crsf_token: crsf_hash,
                        id: id,
                    }

                    let table_report='';
                    $.post(baseurl + 'razilastirma/get_tables',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });

                        let responses = jQuery.parseJSON(response);
                        responses.projeler.forEach((item_, index) => {
                            $('#proje_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.odeme_tipi.forEach((item_, index) => {
                            $('#odeme_tipi').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.odeme_metodlari.forEach((item_, index) => {
                            $('#odeme_sekli').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })

                        responses.personeller.forEach((item_,index) => {
                            $('#proje_mudur_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.personeller.forEach((item_,index) => {
                            $('#genel_mudur_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                        })
                        responses.para_birimleri.forEach((item_,index) => {
                            $('#cur_id').append(new Option(item_.code, item_.id, false, false)).trigger('change');
                        })
                        $.post(baseurl + 'razilastirma/get_razi_info',data,(retuns) => {
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            });
                            let datas = jQuery.parseJSON(retuns);
                            $('#proje_id').val(datas.details.proje_id).trigger("change");
                            $('#tax_status').val(datas.details.tax_status).trigger("change");
                            $('#cur_id').val(datas.details.cur_id).trigger("change");
                            $('#genel_mudur_id').val(datas.genel_muduru).trigger("change");
                            $('#proje_mudur_id').val(datas.proje_muduru).trigger("change");
                            $('#odeme_tipi').val(datas.details.odeme_tipi).trigger("change");
                            $('#odeme_sekli').val(datas.details.odeme_sekli).trigger("change");
                            $('#oran').val(datas.details.oran);
                            $('#muqavele_no').val(datas.details.muqavele_no);
                            $('#razilastirma_id').val(datas.details.id);
                            $('#description').val(datas.details.description);
                            $('#tax_oran').val(datas.details.tax_oran);
                            $('#date').val(datas.details.date);
                            $('#image_text').val(datas.details.file);

                            $('#fileupload_').fileupload({
                                url: url,
                                dataType: 'json',
                                formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                done: function (e, data) {
                                    var img='default.png';
                                    $.each(data.result.files, function (index, file) {
                                        img=file.name;
                                    });

                                    $('#image_text').val(img);
                                },
                                progressall: function (e, data) {
                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                    $('#progress .progress-bar').css(
                                        'width',
                                        progress + '%'
                                    );
                                }
                            }).prop('disabled', !$.support.fileInput)
                                .parent().addClass($.support.fileInput ? undefined : 'disabled');


                            let options=[];

                            let data_post_ = {
                                crsf_token: crsf_hash,
                            }

                            $.post(baseurl + 'razilastirma/birimler',data_post_,(response) => {
                                let responses = jQuery.parseJSON(response);
                                options = responses.birimler;

                                // $.each(responses.birimler,function (index){
                                //     options+=`<option value='`+responses.birimler[index].id+`'>`+responses.birimler[index].name+`</option>`;
                                // })
                            })

                            table_report='';
                            setTimeout(function(){
                                datas.item_details.forEach((item_,index) => {
                                    let quantity="<input onkeyup='item_hesap("+index+")'  type='number' value='"+item_.qty+"' class='form-control qty' name='qty[]'><input type='hidden' class='pid' value='"+item_.task_id+"' name='pid[]'>";
                                    let price="<input onkeyup='item_hesap("+index+")'  type='number' value='"+item_.price+"' class='form-control price' name='price[]'>";

                                    let options_val='';
                                    $.each(options,function (index){
                                        if(options[index].id==item_.unit_id){
                                            options_val+=`<option selected value='`+options[index].id+`'>`+options[index].name+`</option>`;
                                        }
                                        else {
                                            options_val+=`<option value='`+options[index].id+`'>`+options[index].name+`</option>`;
                                        }

                                    })
                                    let toplam_tutar = "<span class='item_toplam_tutar'>"+item_.toplam_tutar+"</span><input type='hidden' class='item_toplam_tutar_hidden' value='"+item_.toplam_tutar+"'>";
                                    let birim="<select class='form-control unit_id' name='unit_id[]'>"+options_val+"</select>";
                                    let status="<button  type='button' class='btn btn-danger removeProd'>Sil</button>";
                                    let asama_name=''
                                    table_report+=` <tr>
                                                    <td>`+item_.name+`</td>
                                                    <td>`+asama_name+`</td>
                                                    <td>`+price+`</td>
                                                    <td>`+quantity+`</td>
                                                    <td>`+birim+`</td>
                                                    <td>`+toplam_tutar+`</td>
                                                    <td>`+status+`</td>
                                                    </tr>`;
                                });

                                $('#invoices_report tbody').append(table_report);



                            }, 1000);



                        });
                    })



                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                onContentReady:function (){
                },
                buttons: {
                    formSubmit: {
                        text: 'Protokol Güncelle',
                        btnClass: 'btn-blue',
                        action: function () {

                            var image_text = this.$content.find('#image_text').val();
                            var pid = this.$content.find('.pid').val();
                            var oran = this.$content.find('#oran').val();
                            if(!image_text){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'PDF Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }
                            if(!oran){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Oran Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

                            }
                            if(!pid){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Lütfen İş Kalemi Seçiniz',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;

                            }
                            let product_details = [];
                            let count = $('input[name="price[]"]').length;
                            for (let i=0; i < count; i++){
                                product_details.push({
                                    'pid':$('.pid').eq(i).val(),
                                    'qty':$('.qty').eq(i).val(),
                                    'price':$('.price').eq(i).val(),
                                    'toplam_tutar':$('.item_toplam_tutar_hidden').eq(i).val(),
                                    'unit_id':$('.unit_id').eq(i).val(),
                                });
                            }
                            let data = {
                                razilastirma_id:$('#razilastirma_id').val(),
                                proje_id:$('#proje_id').val(),
                                cur_id:$('#cur_id').val(),
                                tax_status:$('#tax_status').val(),  // KDV DURUMu
                                tax_oran:$('#tax_oran').val(),  // KDV Oranı
                                description:$('#description').val(),
                                muqavele_no:$('#muqavele_no').val(),
                                date:$('#date').val(),
                                oran:$('#oran').val(),
                                odeme_tipi:$('#odeme_tipi').val(),
                                odeme_sekli:$('#odeme_sekli').val(),
                                image_text:$('#image_text').val(),
                                genel_mudur_id:$('#genel_mudur_id').val(),
                                proje_mudur_id:$('#proje_mudur_id').val(),
                                product_details:product_details,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'razilastirma/update_razilastirma',data,(response)=>{
                                $('#loading-box').removeClass('d-none');
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
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
                                                    $('#loading-box').addClass('d-none');
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data()

                                                }
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');

                                }
                                else if(responses.status=='Error'){

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
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
        $(document).on('click','.delete',function (){
            let id = $(this).attr('data-object-id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Razılaştırma Sil',
                icon: 'fa fa-trash',
                type: 'red',
                animation: 'scale',
                columnClass: 'small',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content:'İşlemi Geri Alamazsınız',
                buttons: {
                    formSubmit: {
                        text: 'Sil',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');

                            let data = {
                                id:id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'razilastirma/delete_razilastirma',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
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
                                                    $('#loading-box').addClass('d-none');
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data()

                                                }
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');

                                }
                                else if(responses.status=='Error'){

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
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
                icon: 'fa fa-question',
                type: 'orange',
                closeIcon: true,
                title: 'RAZILAŞTIRMA PROTOKOLÜ ONAYA SUN',
                animation: 'scale',
                columnClass: 'col-md-6 col-md-offset-3',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content:'İşlemi Geri Alamazsınız',
                buttons: {
                    formSubmit: {
                        text: 'Onay Sistemini Başlat',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');

                            let data = {
                                id:id,
                                crsf_token: crsf_hash,
                            }
                            $.post(baseurl + 'razilastirma/onay_start',data,(response)=>{
                                let responses = jQuery.parseJSON(response);
                                if(responses.status=='Success'){
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
                                                    $('#loading-box').addClass('d-none');
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data()

                                                }
                                            }
                                        }
                                    });
                                    $('#loading-box').addClass('d-none');

                                }
                                else if(responses.status=='Error'){

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
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

        $(document).on('click','.razilastirma_onay_detay',function (){
            let id = $(this).attr('data-object-id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'RAZILAŞTIRMA ONAY DETAYI',
                icon: 'fa fa-eye',
                type: 'orange',
                animation: 'scale',
                columnClass: 'medium',
                containerFluid: true, // this will add 'container-fluid' instead of 'container'
                draggable: false,
                content: function () {
                    let self = this;
                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                    let responses;
                    html+='<form action="" class="formName">' +
                        '<div class="form-group table_rp">'+
                        '</div>' +
                        '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                        id: id,
                    }

                    let table_report='';
                    $.post(baseurl + 'razilastirma/onay_details_get',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        $('.select-box').select2({
                            dropdownParent: $(".jconfirm-box-container")
                        });

                        let responses = jQuery.parseJSON(response);

                        table_report =responses.html;
                        $('.table_rp').empty().html(table_report);
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






        function item_hesap(eq){
            let item_qty= $('.qty').eq(eq).val();
            let item_price= $('.price').eq(eq).val();
            let toplam_tutar = parseFloat(item_price) *parseFloat(item_qty);
            $('.item_toplam_tutar').eq(eq).empty().text(toplam_tutar.toFixed(2))
            $('.item_toplam_tutar_hidden').eq(eq).val(toplam_tutar.toFixed(2))
        }
    </script>
