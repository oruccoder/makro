<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Onay Bekleyen Virmanlar</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <table id="invoices_table" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Talep Eden Kasa</th>
                        <th>Talep Edilen Kasa</th>
                        <th>Tip</th>
                        <th>Talep Edilen Tutar</th>
                        <th>Onaylanan Tutar</th>
                        <th>Durum</th>
                        <th>Açıklama</th>
                        <th>İşlem Açıklaması</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($item) {
                        foreach ($item as $items){
                            $_doviz_transfer_id = doviz_transfer_item($items->id)->id;
                            $onaylanan_tutar = doviz_transfer_item($items->id)->onaylanan_tutar;
                            ?>
                            <tr>

                                <td>#</td>
                                <?php if($items->invoice_type_id == 27){
                                    echo "<td>".$items->account."</td>";
                                    echo "<td>".account_details($items->acid_)->holder."</td>";
                                }else {
                                    echo "<td>".account_details($items->acid_)->holder."</td>";
                                    echo "<td>".$items->account."</td>";

                                }

                                ?>
                                <td><?php echo $items->invoice_type_desc ?></td>
                                <td><?php echo amountFormat($items->total,$items->para_birimi) ?></td>
                                <td><?php echo amountFormat($onaylanan_tutar,$items->para_birimi) ?></td>
                                <td><?php echo invoice_status($items->status) ?></td>
                                <td><?php echo $items->notes ?></td>
                                <td><?php echo doviz_transfer_item($items->id)->status ?></td>
                                <?php if($items->onay_status == 1){
                                    if( invoice_status($items->status)!=1){

                                        echo "<td>".invoice_status($items->status)."</td>";
                                    }
                                    else {
                                        echo "<td>Onay Bekliyor</td>";
                                    }

                                }
                                else
                                {
                                    if( $items->status==1){

                                        echo "<td><button tutar='$items->total' class='btn btn-success onayla' type='button' item_id='$items->id' kur = '$items->kur_degeri'  doviz_id='$_doviz_transfer_id'>İşlem Yap</button></td>";
                                    }
                                    else {
                                        echo "<td>".invoice_status($items->status)."</td>";
                                    }




                                }
                                ?>

                            </tr>
                            <?
                        }
                    }?>

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

    })

    $(document).on('click', ".onayla", function (e) {
        let id = $(this).attr('doviz_id');
        let tutar_ = $(this).attr('tutar');
        let kur_degeri = $(this).attr('kur');
        let item_id = $(this).attr('item_id');
        // let tutar= parseFloat(tutar_)/parseFloat(kur_degeri);
        let tutar= parseFloat(tutar_);
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
                    '<p>Kasalar Arası Transfer İşlemine Durum Bildirmek Üzeresiniz!<p/>' +
                    '<label>Açıklama</label>' +
                    '<input type="text" name="desc" id="desc" placeholder="İnceledim Onayladım" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Onaylanan Tutar</label>' +
                    '<input type="text" name="tutar" id="tutar" value="'+tutar.toFixed(2)+'" class="form-control name" />' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Durum</label>' +
                    '<select class="form-control name" name="durum" id="durum"><option value="17">Onayla</option><option value="3">İptal Et</option>' +
                    '</select>' +
                    '</div>' +
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
                    responses.item.forEach((item_,index) => {
                        $('#user_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                    })

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
                        jQuery.ajax({
                            url: baseurl + 'reports/doviz_transfer_update',
                            dataType: "json",
                            method: 'post',
                            data: 'item_id='+item_id+'&durum='+durum+'&tutar='+tutar+'&desc='+desc+'&id='+id+'&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $(this).html('Bekleyiniz');
                                $(this).prop('disabled', true); // disable button

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    window.setTimeout(function () {
                                        window.location.reload();
                                    }, 1000);
                                } else {
                                    $.alert(data.message);
                                }
                            },
                            error: function (data) {
                                $.alert(data.message);
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

