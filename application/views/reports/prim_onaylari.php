<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex ">
            <h4 class="card-title">Onay Bekleyen Prim / Ceza</h4>
        </div>
        </div>
        </div>


<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="invoices_table" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>

                        <th>#</th>
                        <th>Oluşturma Tarihi</th>
                        <th>Hakeden Personel</th>
                        <th>Tip</th>
                        <th>Talep Oluşturan Personel</th>
                        <th>Proje</th>
                        <th>Açıklama</th>
                        <th>Tutar</th>
                        <th>Onaylanan Tutar</th>
<!--                        <th>Proje Müdürü Durumu</th>-->
                        <th>Dosya</th>
                        <th>İşlem</th>


                    </tr>
                    </thead>
                    <tbody>
<!--                    --><?php //if($item) {
//                        $prim_desc='';
//                        foreach ($item as $items){
//
//                            $proje_adi = proje_name($items->proje_id);
//                            ?>
<!--                            <tr>-->
<!---->
<!--                                <td>#</td>-->
<!--                                <td>--><?php //echo $items->created_at ?><!--</td>-->
<!--                                <td>--><?php //echo personel_details($items->personel_id) ?><!--</td>-->
<!--                                --><?php
//
//                                $image='<a target="_blank" href="' . base_url() . 'userfiles/product/' . $items->file . '"   class="btn btn-info btn-sm"><span class="fa fa-file"></span> Dosya</a>';
//                                if($items->type == 1){
//                                    echo "<td>Prim</td>";
//                                    $prim_desc='Prim';
//                                }else {
//                                    echo "<td>Ceza</td>";
//                                    $prim_desc='Ceza';
//
//                                }
//                                ?>
<!--                                <td>--><?php //echo personel_details($items->user_id) ?><!--</td>-->
<!--                                <td>--><?php //echo $proje_adi ?><!--</td>-->
<!--                                <td>--><?php //echo $items->aciklama ?><!--</td>-->
<!--                                <td>--><?php //echo amountFormat($items->tutar) ?><!--</td>-->
<!--                                <td>--><?php //echo amountFormat($items->onaylanan_tutar) ?><!--</td>-->
<!--                                <td>--><?php //echo $items->description ?><!--</td>-->
<!---->
<!--                                <td>--><?php //echo $image ?><!--</td>-->
<!--                                --><?php
//                                if($items->status==0){
//                                    echo "<td><button tutar='$items->tutar' type ='$prim_desc' class='btn btn-success onayla' type='button' personel_prim_onay='$items->personel_prim_onay_id'>İşlem Yap</button></td>";
//                                }
//                                elseif($items->status==1){
//                                    echo "<td>Onaylandı</td>";
//                                }
//                                elseif($items->status==2){
//                                    echo "<td>İptal Edildi</td>";
//                                }
//
//                                ?>
<!---->
<!--                            </tr>-->
<!--                            --><?//
//                        }
//                    }?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<style>
    .modal-dialog {
        max-width: 50% !important;
    }
    .col-sm-6{
        padding-bottom: 10px !important;
    }
</style>

<script>



    $(document).ready(function () {

        $('.select-box').select2();
        $('#invoices_table').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            aLengthMenu: [
                [ 100, 50, 10, 200,-1],
                [100, 50, 10, 200,"Tümü"]
            ],
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('reports/prim_onaylari_list')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                }
            },
            'columnDefs': [
                {
                    'targets': [0,1,2,3,4,5,6,7,8,9,10],
                    'orderable': false,
                }
            ],
            dom: 'Blfrtip',
            buttons: [
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

    })

    $(document).on('click', ".onayla", function (e) {
        let personel_prim_onay = $(this).attr('personel_prim_onay');
        let type = $(this).attr('type');
        let tutar = $(this).attr('tutar');
        let personel_prim_id = $(this).attr('personel_prim_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-question',
            type: 'green',
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
                    '<p>Onaya Sunulan '+type+' Güncellemek Üzeresiniz<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="İnceledim Onayladım" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Onaylanan Tutar</label>' +
                    '<input type="text" name="tutar" id="tutar" value="'+tutar+'" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Durum</label>' +
                    '<select class="form-control name" name="durum" id="durum"><option value="1">Onayla</option><option value="2">İptal Et</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Ödeme Metodu</label>' +
                    '<select class="form-control name" name="method" id="method"><option value="1">Nakit</option><option value="2">Bankadan</option>' +
                    '</select>' +
                    '</div>' +
                    '</form>';

                    let data = {
                        crsf_token: crsf_hash,
                        personel_prim_id: personel_prim_id,
                    }

                $.post(baseurl + 'reports/proje_mudur_prim_method',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);
                    // if(responses.method==1){
                    //     $("#method").val(1).change();
                    // }
                    // else if(responses.method==2){
                    //     $("#method").val("2").change();
                    // }
                    $("#method").val("2").change();

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
                        let placeholder = this.$content.find('#desc').attr('placeholder');
                        let desc = this.$content.find('#desc').val();
                        let status_id = this.$content.find('#status_id').val();
                        let tutar = this.$content.find('#tutar').val();
                        if (desc.length == 0) {
                            desc = placeholder;
                        }
                        let durum = $('#durum').val()
                        let method = $('#method').val()
                        jQuery.ajax({
                            url: baseurl + 'reports/prim_update',
                            dataType: "json",
                            method: 'post',
                            data: 'method='+method+'&durum='+durum+'&tutar='+tutar+'&desc='+desc+'&personel_prim_onay_id='+personel_prim_onay+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fas fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-8 mx-auto",
                                        title: 'Başarılı!',
                                        content: data.message,
                                        buttons:{
                                            prev: {
                                                text: 'Kapat',
                                                btnClass: "btn btn-link text-dark",
                                                action: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: data.message,
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }
                            },
                            error: function (data) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
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

