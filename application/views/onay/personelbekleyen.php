<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Personel Talepleri</span></h4>
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
                                        <table id="cari_gider_talep_list" class="table datatable-show-all" width="100%">
                                            <thead>
                                            <tr>
                                                <td>
                                                    <input class="form-control all_select" type="checkbox" style="width: 30px;">
                                                </td>
                                                <td>No</td>
                                                <td>Personel</td>
                                                <td>Talep Kodu</td>
                                                <td>Proje</td>
                                                <td>Metod</td>
                                                <td>Tutar</td>
                                                <td>İşlemler</td>
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
    var url = '<?php echo base_url() ?>carigidertalep/file_handling';
    $(document).ready(function () {

        $('.select-box').select2();

        draw_data();


        function draw_data() {
            let type = $('#tip').val();
            let url_ajax='';
            let status = $('#status').val();
            let tip=type;

            if(type==2){
                url_ajax="<?php echo site_url('onay/personel_gider_ajax_list')?>";

            }
            else if(type==3){
                url_ajax="<?php echo site_url('onay/personel_avans_ajax_list')?>"

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
                                                        talep_id:$(item).attr('id'),
                                                        pay_personel_id:$('.pay_personel_id').val()
                                                    })
                                                });

                                                $('#loading-box').removeClass('d-none');
                                                let data = {
                                                    tip:2,
                                                    crsf_token: crsf_hash,
                                                    product_details: product_details,
                                                }
                                                $.post(baseurl + 'onay/all_payment_cari',data,(response)=>{
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
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    }
                ]
            });
        };
    })
</script>


