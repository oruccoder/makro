<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Onay Bekleyen Virmanlar</span></h4>
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
                                        <table class="table datatable-show-all" id="virman" width="100%">
                                            <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Talap Eden Kasa</td>
                                                <td>Talap Edilen Kasa</td>
                                                <td>Tarih</td>
                                                <td>Açıklama</td>
                                                <td>İşlem</td>
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
<script>
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();



    })


    function draw_data() {
        $('#virman').DataTable({
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
                'url': "<?php echo site_url('virman/ajax_list_bekleyen')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
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
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                    }
                }
            ]
        });
    };

    $(document).on('click','.view',function (){
        let id=$(this).attr('talep_id');
        const width = $(window).width();

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Transfer İşlemi Görüntüle',
            icon: 'fa fa-eye',
            type: 'dark',
            scrollToPreviousElement: false,
            boxWidth: (width < 700) ? (width - 50) + 'px' : 'auto',
            useBootstrap: (width < 700) ? false : true,
            columnClass: 'col-md-12',
            containerFluid: true, // this will add 'container-fluid' instead of 'container'
            draggable: false,
            content:function (){
                let self = this;
                let html=`<div class="content">
                            <div class="row">

                      <table class="table virman_onay_list " style="width: 100%">
                        <thead>
                        <tr>
                            <td>Sıra</td>
                            <td>Personel</td>
                            <td>İşlem Görecek Kasa</td>
                            <td>Talep Tutarı</td>
                            <td>Onaylanan Tutar</td>
                            <td>Açıklama</td>
                            <td>Onay Tarihi</td>
                            <td>Durum</td>
                            <td>İşlem</td>
                        </tr>
                        </thead>
<tbody></tbody>
                       </table>
                </div>
                </div>
`;
                let data = {
                    id: id,
                }

                $.post(baseurl + 'virman/info_onay',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);

                    $.each(responses.items_onay, function (index, value) {
                        let kasa_id = value.out_account_id;
                        let talep_price = value.out_price_text;
                        let status='Bekliyor';

                        let out_input=value.onaylanan_price_out;
                        if(value.onaylanan_price_out==0){
                            out_input = value.out_price;
                        }

                        let input=value.out_price_text;
                        let att_tutar = value.account_out_price;
                        if(value.onaylanan_price_out==0){
                            att_tutar=value.account_out_price
                        }

                        if(value.sort==2){
                            kasa_id = value.in_account_id;
                            talep_price = value.in_price_text;
                            input=value.onaylanan_price_in_text;
                            att_tutar = value.account_in_price;
                            if(value.onaylanan_price_in==0){
                                att_tutar=value.account_in_price
                            }
                        }

                        let button='';
                        let desc=value.desc;
                        if(value.us_id==value.aauth_id){
                             button =`<button class='btn btn-danger talep_change' tutar='`+att_tutar+`' tip=2 virman_onay_id='`+value.id+`' type='button'><i class='fa fa-ban'></i></button>&nbsp;
                                    <button class='btn btn-success talep_change' tip=1 tutar='`+att_tutar+`' virman_onay_id='`+value.id+`' type='button'><i class='fa fa-check'></i></button>&nbsp;`;
                        }

                        if(value.status==1){
                            status='Onaylandı';
                        }
                        else if(value.status==2){
                            status='İptal Edildi';
                        }

                        $(".virman_onay_list>tbody").append(`
                            <tr>
                                <td>`+value.sort+`</td>
                                <td>`+value.user_id+`</td>
                                <td>`+kasa_id+`</td>
                                <td>`+talep_price+`</td>
                                <td>`+input+`</td>
                                <td>`+desc+`</td>
                                <td>`+value.update_at+`</td>
                                <td>`+status+`</td>
                                <td>`+button+`</td>
                            </tr>
                            `);
                    });
                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm one_dialog",
                }
            },
            onContentReady: function () {
                dialPay.$el.find('.jconfirm-scrollpane').css('display', 'block');
                dialPay.$el.find('.jconfirm-row').css('display', 'block');
                dialPay.$el.find('.jconfirm-cell').css('display', 'block');
            }
        });
    })

    $(document).on('click','.talep_change',function (){
        let tip = $(this).attr('tip');
        let tutar = $(this).attr('tutar');
        let virman_onay_id = $(this).attr('virman_onay_id');
        let title='İptal Etme İşlemi';
        let icon='fa fa-ban';
        let type='red';
        let content='İşlemi İptal Etmek İstediğinizden Emin Misiniz?<br><input type="text" placeholder="İptal Açıklması Zorunludur" class="form-control desc">';
        if(tip==1) //onay
        {
            title='Onay Verme İşlemi';
            icon='fa fa-check';
            type='green';
            content='İşleme Onay Vermek İstediğinizden?<br><input type="number" class="form-control onaylanan_tutar" value="'+tutar+'"><br><input type="text" value="İnceledim Onaylıyorum" class="form-control desc">';
        }
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: title,
            icon: icon,
            type: type,
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:content,
            buttons: {
                formSubmit: {
                    text: 'işlemi Tamamla',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            tip:  tip,
                            onaylanan_tutar:  $('.onaylanan_tutar').val(),
                            desc:  $('.desc').val(),
                            virman_onay_id:  virman_onay_id
                        }
                        $.post(baseurl + 'virman/talep_change',data,(response) => {
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
                                                $('.one_dialog').click();
                                                $('#virman').DataTable().destroy();
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
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
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


