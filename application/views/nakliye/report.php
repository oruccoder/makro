<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Nakliye Talebi Detay Raporu</span></h4>
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
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="cari_id" name="cari_id" >
                                            <option  value="">Cari</option>
                                            <?php foreach (all_customer() as $row)
                                            {
                                                echo "<option value='$row->id'>$row->company</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="proje_id" name="proje_id" >
                                            <option value="0">Proje Seçiniz</option>
                                            <?php foreach (all_projects() as $rows)
                                            {
                                                ?><option value="<?php echo $rows->id?>"><?php echo $rows->code?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <select class="select-box form-control" id="status" name="status" >
                                            <option  value="">Talep Tipi</option>
                                            <?php foreach (nakliye_item_tip() as $rows)
                                            {
                                                ?><option value="<?php echo $rows->id?>"><?php echo $rows->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-6" style="background: #3d6c6d;padding: 2px 0px 0px 70px;color: aliceblue;">
                                        <span class="text-bold-300" style="font-size: 23px;font-weight: 400;">Toplam Tutar : </span><span style="font-size: 23px;font-weight: 900;" class="text-bold-300 total_price">0,00 AZN</span>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <div class="col-lg-1">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                    <div class="col-lg-1">
                                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-success btn-md">Temizle</a>
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
                                    <div class="col-12 mb-4">
                                        <table id="cari_gider_talep_list" class="table datatable-show-all" width="100%">
                                            <thead>
                                            <tr>
                                                <td><input class="form-control all_select" type="checkbox" style="width: 30px;"></td>
                                                <td>Talep Kodu</td>
                                                <td>Tarih</td>
                                                <td>Talep Eden</td>
                                                <td>Açıklama</td>
                                                <td>İtem Kodu</td>
                                                <td>Proje</td>
                                                <td>Cari</td>
                                                <td>Birim Fiyatı</td>
                                                <td>Miktar</td>
                                                <td>Toplam Tutar</td>
                                                <td>Item Durumu</td>
                                                <td>Lokasyon</td>
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


    })


    $('#search').click(function () {
        var proje_id = $('#proje_id').val();
        var cari_id = $('#cari_id').val();
        var talep_tipi = $('#talep_tipi').val();
        $('#cari_gider_talep_list').DataTable().destroy();
        draw_data('absent',proje_id,cari_id,talep_tipi);

    });

    function draw_data(aauth = 'absent',proje_id=0,cari_id=0,talep_tipi=0) {
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
                'url': "<?php echo site_url('nakliye/ajax_list_report')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    aauth: aauth,
                    proje_id: proje_id,
                    cari_id: cari_id,
                    talep_tipi: talep_tipi,
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style',data[13]);

            },
            dom: 'Blfrtip',
            buttons: [

                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7,8,9,10,11,12]
                    }
                }
            ]
        });
    };

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
                        $.post(baseurl + 'nakliye/status_upda',data,(response) => {
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


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }

        let total=0;

        for(let i=0; i < $('.one_select:checked').length; i++){
            let tutar=0;
            if(parseFloat($('.one_select:checked').eq(i).val())){
                tutar=parseFloat($('.one_select:checked').eq(i).val());
            }
            total+=tutar;
        }
        $('.total_price').empty().text(currencyFormat(total));
    })

    $(document).on('change','.one_select',function (){
        let total=0;

        $('.one_select:checked').each(function(i){
            if($(this).val()){
                total+= parseFloat($(this).val());
            }

        });
        $('.total_price').empty().text(currencyFormat(total));
    })
</script>

