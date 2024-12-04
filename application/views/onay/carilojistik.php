<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Cari Lojistik Talepleri</span></h4>
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
                                        <h3 id="totals"></h3>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <table id="cari_gider_talep_list" class="table datatable-show-all" width="100%">
                                            <thead>
                                            <tr>
                                                <td>
                                                   #
                                                </td>
                                                <td>No</td>
                                                <td>Cari</td>
                                                <td>Araç</td>
                                                <td>Lokasyon</td>
                                                <td>Talep Tipi</td>
                                                <td>Talep Açıklaması</td>
                                                <td>Talep Kodu</td>
                                                <td>Proje</td>
                                                <td>Metod</td>
                                                <td>Tutar</td>
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
<input type="hidden" value="<?php echo $type?>" id="tip">
<input type="hidden" value="<?php echo $status?>" id="status">
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })


    $(document).on('change','.one_select',function (){
        let status = $(this).prop('checked');
        let array=[];
        array.push({
            id:$(this).attr('id'),
            price:$(this).attr('price'),
        });
        if(status){
            let _serials = localStorage.getItem('talep_serials');
            _serials = JSON.parse(_serials);
            if(_serials){
                let _filtered = array[0];
                let otherRows = $.grep(_serials, function( item ) {
                    return item.id !== _filtered.id;
                });
                otherRows.push(_filtered);

                localStorage.setItem('talep_serials',JSON.stringify(otherRows));
            }
            else{
                localStorage.setItem('talep_serials',JSON.stringify(array));
            }

        }
        else {
            let _serials = localStorage.getItem('talep_serials');
            _serials = JSON.parse(_serials);


            if(_serials){
                let _filtered = array[0];
                let filterSerial = $.grep(_serials, function( item ) {
                    return item.id !== _filtered.id;
                });
                localStorage.setItem('talep_serials',JSON.stringify(filterSerial));
            }
            else {
                localStorage.setItem('talep_serials',JSON.stringify(array));
            }

            //filterSerial.push(_serials);


        }

        let _serials_new = localStorage.getItem('talep_serials');
        total_price=0;
        _serials_new = JSON.parse(_serials_new);
        if(_serials_new){
            for(let j=0; j<_serials_new.length;j++){
                total_price+=parseFloat(_serials_new[j].price);
            }
        }
        else {
            total_price=parseFloat(total);
        }
        $('#totals').empty().text(total_price);




    })

    var url = '<?php echo base_url() ?>carigidertalep/file_handling';
    $(document).ready(function () {

        localStorage.clear();
        $('.select-box').select2();

        draw_data();


        function draw_data() {
            let type = $('#tip').val();
            let status = $('#status').val();
            let url_ajax='';
            let tip=type;

            if(type==2){
                url_ajax="<?php echo site_url('onay/cari_gider_ajax_list')?>";

            }
            else if(type==6){
                url_ajax="<?php echo site_url('onay/cari_lojistik_ajax_list')?>"

            }
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
                    'url': url_ajax,
                    'type': 'POST',
                    'data': {
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                        'status':status,
                        'tip':tip
                    }
                },
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[9]);

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

                            text: '<i class="fa fa-plus"></i> Atama Yap',
                            className: 'atama_button' ,
                            action: function(e, dt, node, config) {

                    let checked_count = $('.one_select:checked').length;
                    if(checked_count==0){
                        $.alert({
                            theme: 'modern',
                            icon: 'fa fa-exclamation',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            title: 'Dikkat!',
                            content: 'Herhangi Bir Talep Seçilmemiş!',
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
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Atama Yap',
                            icon: 'fa fa-pen',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-4 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form action="" class="formName">
                                        <div class="form-group">
                                        <select class="form-control select-box pay_personel_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (account_personel() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                        </div>
                                        <div class="form-group">
                                        <label>Talep Edilecek Kasa</label></br><span style="font-size: 13px;font-weight: 700;color: #1a1a1a;text-decoration: underline;">Personel Ödemeyi Hangi Kasadan Transfer Etsin?</span>
                                        <select class="form-control select-box account_type">
                                            <option value="0">Kendi Kasası</option>
                                            <?php foreach (account_personel() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                        <?php } ?>
                                    </select>
                                        </div>
                                        </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Güncelle',
                                    btnClass: 'btn-blue',
                                    action: function () {

                                        let account_id = $('.pay_personel_id').val();
                                        if(!parseInt(account_id)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content: 'Personel Zorunludur',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false;
                                        }

                                        let product_details=[];
                                        $('.one_select:checked').each((index,item) => {
                                            product_details.push({
                                                talep_item_id:$(item).attr('id'),
                                                pay_personel_id:$('.pay_personel_id').val()
                                            })
                                        });

                                        $('#loading-box').removeClass('d-none');
                                        let data = {
                                            tip:6,
                                            crsf_token: crsf_hash,
                                            product_details: product_details,
                                        }
                                        $.post(baseurl + 'onay/all_payment_cari_lojistik',data,(response)=>{
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
                                                                $('#cari_gider_talep_list').DataTable().destroy();
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
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })
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


                }

                    },
                    {

                        text: '<i class="fa fa-money-bill"></i> Ödeme Yap',
                        className: 'odeme_button' ,
                        action: function(e, dt, node, config) {

                            let checked_count = $('.one_select:checked').length;
                            if(checked_count==0){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Herhangi Bir Talep Seçilmemiş!',
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


                                let tutar =$('.one_select:checked').attr('price');
                                let id =$('.one_select:checked').attr('id');
                                $.confirm({
                                    theme: 'modern',
                                    closeIcon: true,
                                    title: 'Dikkat',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    containerFluid: !0,
                                    smoothContent: true,
                                    draggable: false,
                                    content:`<form action="" class="formName">
            <div class="form-group">
            <p>Cariye Ödeme Yapmak İstediğinizden Emin Misiniz?<p/>
             <input class="form-control alacak_tutar"  type="number" value="`+tutar+`"  max='`+tutar+`'onkeyup="amount_max(this)">
             </div>
               <div class="form-group">
            <input class="form-control not" placeholder='Açıklama'>
            </div>
             <div class="form-group">
            <select class="form-control cach_personel select-box">
                <option value="0">Parayı Verdiğiniz Personel</option>
                <?php foreach (all_personel() as $emp) {
                                        $emp_id = $emp->id;
                                        $name = $emp->name;
                                        $selected = '';
                                        echo '<option  value="' . $emp_id . '">' . $name . '</option>';
                                    }
                                    ?>
                </select>
            </div>
            <div class="form-group">
            <select class="form-control account_id">
            <option value="0">Kasa Seçiniz</option>
            <?php foreach (personel_account($this->aauth->get_user()->id) as $emp) {
                                        $emp_id = $emp['id'];
                                        $name = $emp['holder'];
                                        $selected = '';
                                        echo '<option  value="' . $emp_id . '">' . $name . '</option>';
                                    }
                                    ?>
            </selected>
            </div>
            </form>`,

                                    buttons: {
                                        formSubmit: {
                                            text: 'Güncelle',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                let account_id = $('.account_id').val();
                                                if(!parseInt(account_id)){
                                                    $.alert({
                                                        theme: 'material',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content:'Kasa Seçmek Zorunludur',
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
                                                    talep_item_id:id,
                                                    account_id:$('.account_id').val(),
                                                    alacak_tutar:$('.alacak_tutar').val(),
                                                    cach_personel:$('.cach_personel').val(),
                                                    not:$('.not').val(),
                                                }
                                                $.post(baseurl + 'nakliye/customer_payment_update',data,(response)=>{
                                                    let responses = jQuery.parseJSON(response);
                                                    if(responses.status=='Success'){
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
                                                                        //let remove = '#remove'+ item_id
                                                                        location.reload()
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
                                                            content:responses.message,
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


                        }

                    },
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    }
                ],
                "initComplete": function(settings, json) {
                   if(status==12){
                       $('.atama_button').attr('disabled',true)
                   }
                    if(status==11){
                        $('.odeme_button').attr('disabled',true)
                    }
                }
            });
        };
    })

    $(document).on('click','.mt_info_arac',function (){
        let n_item_id =$(this).attr('n_item_id');
        let m_talep_id =$(this).attr('m_talep_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Detaylar',
            icon: 'fa fa-question',
            type: 'light',
            animation: 'zoom',
            columnClass: 'col-md-12',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;
                html+='<form action="" class="formName">' +
                    '<div class="form-group table_mt_info">'+
                    '</div>' +
                    '</form>';

                let data = {
                    n_item_id: n_item_id,
                    m_talep_id: m_talep_id,
                    nakliye_id: $('#talep_id').val(),
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    table_report =`
                        <table id="table_mt_info"  class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Yükleme Tarihi</th>
                            <th>Ürün</th>
                            <th>Yükleyen Personel</th>
                            <th>Yüklenen Miktar</th>
                            <th>Teslim Alınan Miktar</th>

                        </tr>
                        </thead>

                    </table>`;
                    $('.table_mt_info').empty().html(table_report);
                    draw_data_mt_arac(n_item_id,m_talep_id,$('#talep_id').val());
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

    function draw_data_mt_arac(n_item_id,m_talep_id,talep_id=0) {
        $('#table_mt_info').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[6]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            'ajax': {
                'url': "<?php echo site_url('nakliye/mt_info_arac')?>",
                'type': 'POST',
                'data': {
                    n_item_id: n_item_id,
                    m_talep_id: m_talep_id,
                    talep_id: talep_id
                }
            },
            'columnDefs': [
                {
                    'targets': [1],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2,3, 4,5]
                    }
                }

            ]
        });
    };



</script>


