<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Bordro İşlemleri</span></h4>
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
                                    <div class="col-6 mb-4">
                                        <table class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>Bordro Kodu</td>
                                                <td><?php echo $details->code ?></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Tarihi</td>
                                                <td><?php echo az_month($details->ay)->month.' | '.$details->yil; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Projesi</td>
                                                <td><?php echo proje_name($details->proje_id); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Oluşturan Personel</td>
                                                <td><?php echo personel_details($details->aauth_id); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Toplam Personel</td>
                                                <td><?php echo count($details_items); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Durumu</td>
                                                <td><?php echo bordro_status($details->status)->name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Onay Durumu</td>
                                                <td><button type="button" data-proje_id="<?php echo $details->proje_id?>" class="btn btn-success users_view"><i class="fa fa-eye"></i></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Hareketleri</td>
                                                <td><a href="/salary/bordro_history/<?php echo $details->id?>" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i> Hareketleri Görüntüle</a></td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h4 style="text-align: center"><?php echo $details->code ?> Bordrosu İçin Grafik</h4>
                                        <canvas id="onechart"></canvas>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h4 style="text-align: center"><?php echo az_month($details->ay)->month.' | '.$details->yil ?> Tarihi İçin Bordro Grafiği</h4>
                                        <canvas id="allchart"></canvas>
                                    </div>
                                    <hr>
                                    <div class="col-12 mb-4" style="width: 800px;">
                                        <table class="stripe row-border order-column nowrap" id="project_table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Personel Adı</th>
                                                <th>Toplam Maaş</th>
                                                <th>Brüt Maaş</th>
                                                <th>Net Maaş</th>
                                                <th>Resmi İş Günü</th>
                                                <th>Faktiki İş Günü <i class="fa fa-check all_check" data-text="gercek_is_gunu"></i></th>
                                                <th>Faktiki R. İş Günü <i class="fa fa-check all_check" data-text="r_gercek_is_gunu"></i></th>
                                                <th>Düşülen Gün <i class="fa fa-check all_check" data-text="dusulen_gun"></i></th>
                                                <th>Mezuniyet <i class="fa fa-check all_check" data-text="mezuniyet"></i></th>
                                                <th>Maaş Tamamlama Meblağı</th>
                                                <th>Prim</th>
                                                <th>Ceza</th>
                                                <th>Aylık Banka Hakediş</th>
                                                <th>Aylık Nakit Hakediş</th>
                                                <th>Banka Avans</th>
                                                <th>Nakit Avans</th>
                                                <th>Nakit Kesilecek</th>
                                                <th>Banka Kesilecek</th>
                                                <th>Bankadan Ödenilecek</th>
                                                <th>Nakit Ödenilecek</th>
                                                <th>Maaş Tipi</th>
                                                <th>Hesaplanan</th>
                                                <th>Mezuniyet Meblağ</th>
                                                <th>Hastalık <i class="fa fa-check all_check" data-text="hastalik"></i></th>
                                                <th>Cəmi</th>
                                                <th>DSMF (İG)</th>
                                                <th>İşsizlik(İG)</th>
                                                <th>İ.T.S (İG) </th>
                                                <th>DSMF (İşçi)</th>
                                                <th>İşsizlik (İşçi)</th>
                                                <th>İ.T.S</th>
                                                <th>Gelir Vergisi</th>
                                                <th>Ödəniləcək məbləğ</th>
                                                <th>Bakiye</th>
<!--                                                <th>Alacak Nakit Bakiye</th>-->
<!--                                                <th>Borç Nakit Bakiye</th>-->
<!--                                                <th>Alacak Banka Bakiye</th>-->
<!--                                                <th>Borç Banka Bakiye</th>-->
                                                <th><input type="checkbox" class="form-control all_checked"></th>

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
<style>
    .dataTables_wrapper .dataTables_filter {
        display: none;
    }

    .dataTables_scrollHead {
        position: sticky !important;
        top: 0px;
        z-index: 99;
        background-color: white;
        box-shadow: 0px 5px 5px 0px rgba(82, 63, 105, 0.08);
    }
    .scroll {
        font-size: 32px;
        font-size: bold;
        color: #207b23;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .scroll:hover {
        color: gray;
        cursor: pointer;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select-box').select2();
        draw_data();
    })


    //pie
    var ctxP = document.getElementById("onechart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Toplam Personel", "Bordrosu Oluşmuş Personel","Bordrosu Oluşmamış Personel"],
            datasets: [{
                data: [<?php echo count(proje_to_employe($details->proje_id)); ?>, <?php echo count($details_items)?>,<?php echo count(proje_to_employe($details->proje_id))-count($details_items)?> ],
                backgroundColor: ["#F7464A", "#46BFBD","#091818"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1","#091818"]
            }]
        },
        options: {
            responsive: true
        }
    });

    var ctxP = document.getElementById("allchart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
        type: 'pie',
        data: {
            labels: ["Toplam Personel", "Bu Ay İçin Bordrosu Oluşmuş Personel","Bordrosu Oluşmamış Personel"],
            datasets: [{
                data: [<?php echo count(all_personel()); ?>, <?php echo count($all_details_items_ay_yil)?>,<?php echo count(all_personel())-count($all_details_items_ay_yil); ?>],
                backgroundColor: ["#4d5360", "#fdb45c","#091818"],
                hoverBackgroundColor: ["#4d5360", "#fdb45c","#091818"]
            }]
        },
        options: {
            responsive: true
        }
    });

    $(document).on('click','.users_view',function (){
        let proje_id = $(this).data('proje_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Maaş Onay Sıralaması',
            icon: 'fa fa-money',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function (){
                let self = this;
                let html=`<form>
  <div class="form-row">
<div class="form-group col-md-12">
<button type="button" class="btn btn-secondary new_personel"><i class="fa fa-plus"></i></button>
</div>
<table class="add-row-table table">
    <thead>
        <tr>
            <th>Personel</th>
            <th>Sıralama</th>
            <th>İşlem</th>
        </tr>
    </thead>
 <tbody>
</tbody>

</table>

  </div>
</form>`;
                let data = {
                    proje_id: proje_id,
                }


                $.post(baseurl + 'projects/maas_sort_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);


                    let table_report='';
                    if(responses.items.length > 0){
                        responses.items.forEach((item,key) => {
                            $('.add-row-table tbody').append(`
<tr>
                                    <td><select class="form-control select-box sort_personel_id">
                                      <option value='0'>Personel Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select></td>
                                    <td>`+item.sort+`</td>
                                <td>
                                <button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button>
                                </td>
                        </tr>`);

                            $('.sort_personel_id').eq(key).val(item.user_id)
                        })
                    }
                    else {
                        $('.add-row-table tbody').append(`
<tr>
                                    <td><select class="form-control select-box sort_personel_id">
                                    <option value='0'>Personel Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                        $emp_id=$emp->id;
                        $name=$emp->name;
                        ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select></td>
                                    <td>1</td>
                                    <td></td>
                        </tr>`);
                    }

                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let details=[];
                        let log=0;
                        let sort = $('.sort_personel_id').length;
                        for (let i =0; i <sort;i++){
                            if($('.sort_personel_id').eq(i).val()==0){
                                log=1;
                            }
                            details.push({
                                'user_id': $('.sort_personel_id').eq(i).val(),
                                'sort':parseInt(i)+1,
                                'proje_id':proje_id
                            });
                        }
                        if (log) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Personel Seçiniz',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }

                        console.log(details)
                        $('#loading-box').removeClass('d-none');

                        let emp=[];
                        // $.each($('[name="employee[]"]').val(),function(index,item){
                        //     emp.push(item);
                        // })

                        let data = {
                            crsf_token: crsf_hash,
                            proje_id:proje_id,
                            details:details,
                        }
                        $.post(baseurl + 'projects/salary_sort_update',data,(response) => {
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
                                                $('#project_table').DataTable().destroy();
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
    $(document).on('click','.new_personel',function (){

        let eq = $('.add-row-table tbody tr').length;
        let say=parseInt(eq)+1;
        $('.add-row-table tbody').append(`
<tr>
                                    <td><select class="form-control select-box sort_personel_id">
                                      <option value='0'>Personel Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
        $emp_id=$emp->id;
        $name=$emp->name;
        ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select></td>
                                    <td>`+say+`</td>
                                <td>
                                <button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button>
                                </td>
                        </tr>`);
        $('.select-box').select2({
            dropdownParent: $(".jconfirm-box-container")
        })

    })
    $(document).on('click', '.delete_line', function () {
        $(this).parent().parent().remove();
        $('.select-box').select2({
            dropdownParent: $(".jconfirm-box-container")
        })

    })

    function draw_data() {
        $('#project_table').DataTable({
            'serverSide': true,
            'stateSave': true,
            scrollX:        "300px",
            scrollCollapse: true,
            fixedColumns:   {
                left: 7
            },
            paging:         false,
            aLengthMenu: [
                [10, 50, 100, 200, -1],
                [10, 50, 100, 200, "Tümü"]
            ],
            'ordering': false,
            'ajax': {
                'url': "<?php echo site_url('salary/ajax_list_items')?>",
                'type': 'POST',
                'data': {
                    'bordro_id': <?php echo $details->id?>,
                    'tip': 'list',
                }
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-check"></i> Seçilileri Onaya Sun',
                    action: function ( e, dt, node, config ) {

                        let checked_count = $('.one_checked_salary:checked').length;
                        if (checked_count == 0) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Herhangi Personel Seçilmemiş!',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Bordro ',
                            icon: 'fa fa-user-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`Onaya Sunmak Üzeresiniz Emin Misiniz?`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let bordro_details=[];
                                        $('.one_checked_salary:checked').each((index,item) => {
                                            bordro_details.push({
                                                bordro_item_id:$(item).val(),
                                                bordro_id:<?php echo $details->id?>,
                                                banka_alacak_bakiye:$(item).data('banka_alacak_bakiye'),
                                                banka_borc_bakiye:$(item).data('banka_borc_bakiye'),
                                                nakit_alacak_bakiye:$(item).data('nakit_alacak_bakiye'),
                                                nakit_borc_bakiye:$(item).data('nakit_borc_bakiye'),
                                                prim:$(item).data('prim'),
                                                ceza:$(item).data('ceza'),
                                                aylik_banka_hakedis:$(item).data('aylik_banka_hakedis'),
                                                aylik_nakit_hakedis:$(item).data('aylik_nakit_hakedis'),
                                                banka_avans:$(item).data('banka_avans'),
                                                nakit_avans:$(item).data('nakit_avans'),
                                                bankadan_odenilecek:$(item).data('bankadan_odenilecek'),
                                                nakit_odenilecek:$(item).data('nakit_odenilecek'),
                                                maas_tipi:$(item).data('maas_tipi'),
                                                hesaplanan:$(item).data('hesaplanan'),
                                                mezuniyet_tutar:$(item).data('mezuniyet_tutar'),
                                                cemi:$(item).data('cemi'),
                                                dsmf_isveren:$(item).data('dsmf_isveren'),
                                                issizlik_isveren:$(item).data('issizlik_isveren'),
                                                icbari_sigorta_isveren:$(item).data('icbari_sigorta_isveren'),
                                                dsmf_isci:$(item).data('dsmf_isci'),
                                                issizlik_isci:$(item).data('issizlik_isci'),
                                                icbari_sigorta_isci:$(item).data('icbari_sigorta_isci'),
                                                gelir_vergisi:$(item).data('gelir_vergisi'),
                                                odenilecek_meblaq:$(item).data('odenilecek_meblaq'),
                                                dusulen_gune_gore_meblaq:$(item).data('dusulen_gune_gore_meblaq'),
                                                toplam_maas:$(item).data('toplam_maas'),
                                                brut_maas:$(item).data('brut_maas'),
                                                net_maas:$(item).data('net_maas'),
                                            })
                                        });

                                        let data = {
                                            bordro_details:  bordro_details,
                                            bordro_id:<?php echo $details->id?>,
                                        }
                                        $.post(baseurl + 'salary/create_onay',data,(response) => {
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
                                                                $('#project_table').DataTable().destroy();
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
                                    text: 'Vazgeç',
                                    btnClass: "btn btn-danger btn-sm",
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $(document).on('change','#proje_id_modal',function (e){

                                    let data = {
                                        crsf_token: crsf_hash,
                                        proje_id : $(this).val()
                                    }

                                    $.post(baseurl + 'employee/proje_to_pers',data,(response) => {
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm-box-container")
                                        });
                                        $('#pers_id').empty().trigger("change");
                                        let responses = jQuery.parseJSON(response);
                                        $('#pers_id').append(new Option('Tüm Projedeki Personeller', 0, false, false)).trigger('change');
                                        responses.item.forEach((item_,index) => {
                                            $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                                        })
                                    });
                                })
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-trash"></i> Seçilileri Bordrodan Kaldır',
                    action: function ( e, dt, node, config ) {

                        let checked_count = $('.one_checked_salary:checked').length;
                        if (checked_count == 0) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "small",
                                title: 'Dikkat!',
                                content: 'Herhangi Personel Seçilmemiş!',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Bordrodan Personel Kaldır ',
                            icon: 'fa fa-trash',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`Kaldırmak İstediğinizden Emin Misiniz?`,
                            buttons: {
                                formSubmit: {
                                    text: 'Kaldır',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let bordro_details=[];
                                        $('.one_checked_salary:checked').each((index,item) => {
                                            bordro_details.push({
                                                bordro_item_id:$(item).val(),
                                            })
                                        });

                                        let data = {
                                            bordro_details:  bordro_details,
                                            bordro_id:<?php echo $details->id?>,
                                        }
                                        $.post(baseurl + 'salary/bordro_item_delete',data,(response) => {
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
                                                                $('#project_table').DataTable().destroy();
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
                                    text: 'Vazgeç',
                                    btnClass: "btn btn-danger btn-sm",
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })

                                $(document).on('change','#proje_id_modal',function (e){

                                    let data = {
                                        crsf_token: crsf_hash,
                                        proje_id : $(this).val()
                                    }

                                    $.post(baseurl + 'employee/proje_to_pers',data,(response) => {
                                        $('.select-box').select2({
                                            dropdownParent: $(".jconfirm-box-container")
                                        });
                                        $('#pers_id').empty().trigger("change");
                                        let responses = jQuery.parseJSON(response);
                                        $('#pers_id').append(new Option('Tüm Projedeki Personeller', 0, false, false)).trigger('change');
                                        responses.item.forEach((item_,index) => {
                                            $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                                        })
                                    });
                                })
                            }
                        });
                    }
                },
                {
                    text: '<i class="fa fa-user-plus"></i> Bordroya Personel Ekle',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Bordroya Personel Ekle ',
                            icon: 'fa fa-user-plus',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: function (){
                                let self = this;
                                let html=`<form>
  <div class="form-row">
<div class="form-group col-md-12">
<select class="form-control select-box" id="pers_id"></select>
</div>
</form>`;
                                let data = {
                                    crsf_token: crsf_hash,
                                    proje_id : <?php echo $details->proje_id?>
                                }

                                $.post(baseurl + 'employee/proje_to_pers',data,(response) => {
                                    self.$content.find('#person-list').empty().append(html);
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    });
                                    $('#pers_id').empty().trigger("change");
                                    let responses = jQuery.parseJSON(response);
                                    responses.item.forEach((item_,index) => {
                                        $('#pers_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                                    })


                                });

                                self.$content.find('#person-list').empty().append(html);
                                return $('#person-container').html();
                            },
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let data = {
                                            pers_id:  $('#pers_id').val(),
                                            bordro_id:<?php echo $details->id?>,
                                        }
                                        $.post(baseurl + 'salary/bordro_item_create',data,(response) => {
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
                                                                $('#project_table').DataTable().destroy();
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
                                    text: 'Vazgeç',
                                    btnClass: "btn btn-danger btn-sm",
                                }
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
                            }
                        });
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,
                }
            ]
        });
    };

    $(document).on('keypress','.all_text',function (event){
        let deger = $(this).val();
        let bordro_item_id = $(this).data('bordro_id');
        let column = $(this).data('column');

        if (event.key === "Enter") {
            let data = {
                bordro_item_id: bordro_item_id,
                deger:deger,
                column:column,
            }
            $.post(baseurl + 'salary/item_update',data,(response) => {
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
                                    $('#project_table').DataTable().destroy();
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
    })
    $(document).on('click','.all_check',function (){
        let deger = $(this).data('text');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni Değeri Tümüne Uygula',
            icon: 'fa fa-check',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `<form>
  <div class="form-row">
<div class="form-group col-md-12">
<input type="number" class="form-control" id="new_value">
  </div>
</form>`,
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                      let log = $('#new_value').val();
                        if(!log) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Personel Seçiniz',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }
                        let data = {

                            column:deger,
                            deger:log,
                            bordro_id:<?php echo $details->id ?>,
                        }
                        $.post(baseurl + 'salary/salary_text_update',data,(response) => {
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
                                                $('#project_table').DataTable().destroy();
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

    $(document).on('change','.all_checked',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_checked_salary').prop('checked',true)
        }
        else {
            $('.one_checked_salary').prop('checked',false)
        }
    })

    $(".right-scroll").on('click', function() {
        document.querySelector('.dataTables_scrollBody').scrollLeft += 40;
    })
    $(".left-scroll").on('click', function() {
        document.querySelector('.dataTables_scrollBody').scrollLeft -= 40;
    })
    document.onkeydown = (e) => {
        e = e || window.event;
        if (e.keyCode === 39) {
            document.querySelector('.dataTables_scrollBody').scrollLeft += 40;
        } else if (e.keyCode === 37) {
            document.querySelector('.dataTables_scrollBody').scrollLeft -= 40;
        }
    };
</script>