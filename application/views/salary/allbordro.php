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
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <select class="select-box form-control" id="ay" name="ay" >
                                                    <option  value="">Bordro Ayi</option>
                                                    <?php foreach (az_month() as $row)
                                                    {
                                                        $selected='';
                                                        if($m==$row->id){
                                                            $selected='selected';
                                                        }
                                                        echo "<option $selected value='$row->id'>$row->month</option>";
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" id="yil" name="yil" >
                                                    <option <?php if($y==2024) echo 'selected' ?> id="2023">2024</option>
                                                    <option <?php if($y==2025) echo 'selected' ?> id="2025">2025</option>
                                                    <option <?php if($y==2023) echo 'selected' ?> id="2023">2023</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="select-box form-control" id="b_proje" name="b_proje">
                                                    <option selected value="0">Tüm Bordrolar</option>
                                                    <?php foreach (all_projects() as $items){
                                                        echo "<option value='$items->id'>$items->name</option>";
                                                    }  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-4 col_projects">
                                        <table class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>Bordro Kodu</td>
                                                <td><span class="code">-</span><input type="hidden" class="bordro_id_hid"></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Tarihi</td>
                                                <td><span class="b_date"><?php echo az_month($m)->month.' | '.$y; ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Projesi</td>
                                                <td><span class="proje_name">-</span></td>
                                            </tr>
                                            <tr>
                                                <td>Toplam Personel</td>
                                                <td><span class="total_pers"><?php echo $total_pers ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>Bordro Durumu</td>
                                                <td><span class="bordro_status">-</span></td>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-md-3 mb-4 d-none" id="one_chart_div">
                                        <h4 style="text-align: center"><span class="code"></span> Bordrosu İçin Grafik</h4>
                                        <canvas id="onechart"></canvas>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h4 style="text-align: center"><span class="b_date"><?php echo az_month($m)->month.' | '.$y; ?></span> Tarihi İçin Bordro Grafiği</h4>
                                        <canvas id="allchart"></canvas>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <h4 style="text-align: center"><span class="b_date"><?php echo az_month($m)->month.' | '.$y; ?></span> Tarihi İçin Banka / Nakit Ödemesi</h4>
                                        <canvas id="allchart_pay"></canvas>
                                    </div>
                                    <hr>
                                    <div class="col-12 mb-4" style="    width: 800px;">


                                        <table class="stripe row-border order-column nowrap project_table" id="project_table" style="width:100%">
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
                                                <th>Maaş Tamamlama</th>
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
<!--                                                <th>Alacak Nakit Bakiye</th>-->
<!--                                                <th>Borç Nakit Bakiye</th>-->
<!--                                                <th>Alacak Banka Bakiye</th>-->
                                                <th>Bakiye</th>
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
<input type="hidden" value="<?php echo $this->aauth->get_user()->id?>" class="aauth_id">
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
        $('#loading-box').removeClass('d-none');
        $('.select-box').select2();
        draw_data(0, <?php echo $m ?>, <?php echo $y ?>);
        all_chart_function(0);
        all_chart_pay(<?php echo $nakit_odenilcek ?>, <?php echo $bankadan_odenilecek ?>,'<?php echo $azn_nakit_odenilcek ?>', '<?php echo $azn_bankadan_odenilecek ?>');

        setTimeout(function() {
            $('#loading-box').addClass('d-none');
            let aauth_id = $('.aauth_id').val();
            if(aauth_id!=39){
                $('.razi_button_c').addClass('d-none')
            }
            else {
                $('.razi_button_c').removeClass('d-none')
            }
        }, 2000);

    })

    function all_chart_function(id){
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
    }

    function all_chart_pay(nakit_o,banka_o,azn_nakit,azn_banka){

        var ctxP = document.getElementById("allchart_pay").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Toplam Nakit "+azn_nakit, "Toplam Banka "+azn_banka],
                datasets: [{
                    data: [nakit_o, banka_o],
                    backgroundColor: ["#4d5360", "#14cb19"],
                    hoverBackgroundColor: ["#4d5360", "#14cb19"]
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    function one_chart_function(proje_personel_count,bordro_item_count,fark){
        var ctxP = document.getElementById("onechart").getContext('2d');
        var myPieChart = new Chart(ctxP, {
            type: 'pie',
            data: {
                labels: ["Toplam Personel", "Bordrosu Oluşmuş Personel","Bordrosu Oluşmamış Personel"],
                datasets: [{
                    data: [proje_personel_count,bordro_item_count ,fark ],
                    backgroundColor: ["#F7464A", "#46BFBD","#091818"],
                    hoverBackgroundColor: ["#FF5A5E", "#5AD3D1","#091818"]
                }]
            },
            options: {
                responsive: true
            }
        });
    }


    $(document).on('change','#ay, #yil, #b_proje',function (){
        let ay = $('#ay').val();
        let yil = $('#yil').val();
        let proje_id = $('#b_proje').val();

        let data = {
            proje_id:proje_id,
            ay:ay,
            yil:yil,
        }
        $.post(baseurl + 'salary/all_bordro_details',data,(response) => {
            let responses = jQuery.parseJSON(response);
            $('#loading-box').addClass('d-none');
            if(responses.status==200){
                $('.b_date').empty().text(responses.date);
                $('#project_table').DataTable().destroy();
                if(parseInt(proje_id)){
                    if(responses.bordro_details){
                        $('.code').empty().text(responses.bordro_details.code);
                        $('.bordro_id_hid').val(responses.bordro_details.id);
                        $('.total_pers').empty().text(responses.total_pers);
                        $('.proje_name').empty().text(responses.proje_name);
                        $('.bordro_status').empty().text(responses.bordro_status);
                        $('#one_chart_div').removeClass('d-none');
                        $('.col_projects').addClass('col-3');
                        $('.col_projects').removeClass('col-6');

                        one_chart_function(responses.proje_personel_count,responses.bordro_item_count,responses.fark)
                        all_chart_pay(responses.nakit_odenilcek,responses.bankadan_odenilecek,responses.azn_nakit_odenilcek,responses.azn_bankadan_odenilecek);
                    }


                }
                draw_data(proje_id,ay,yil);
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
            else if(responses.status==500)
            {
                all_chart_pay(responses.nakit_odenilcek,responses.bankadan_odenilecek,responses.azn_nakit_odenilcek,responses.azn_bankadan_odenilecek);


                $('.code').empty().text('-');
                $('.total_pers').empty().text(responses.count);
                $('.proje_name').empty().text('-');
                $('.bordro_status').empty().text('-');
                $('#one_chart_div').addClass('d-none');
                $('#project_table').DataTable().destroy();
                draw_data(0, $('#ay').val(), $('#yil').val());
                $('.col_projects').removeClass('col-3');
                $('.col_projects').addClass('col-6');
            }
        })

    })

    function draw_data(id,m,y) {
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
                    'bordro_id': 0,
                    'proje_id': id,
                    'tip': 'all_bordro',
                    'm':m,
                    'y': y,
                }
            },
            dom: 'Blfrtip',
            buttons: [
                    {

                        extend: 'excelHtml5',
                        footer: true,
                    }
                ,{
                    text: '<i class="fa fa-user-plus razi_button"></i> Razıları Kasaya Al',
                    action: function ( e, dt, node, config ) {

                        let bordro_id_hid = $('.bordro_id_hid').val();
                        if(bordro_id_hid){
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'İşlemler',
                                icon: 'fa fa-check',
                                type: 'green',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "Small",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content: function () {
                                    let self = this;
                                    let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                                    let responses;

                                    html+='<form action="" class="formName">' +
                                        '<div class="form-group">' +
                                        '<label>Kasa</label>' +
                                        '<select class="form-control name" name="acid" id="acid"><option value="0">Seçiniz</option>' +
                                        '</select>' +
                                        '</div>' +
                                        '<div class="form-group">' +
                                        '<label>Toplam Tutar : <span id="total_tutar"></span></label>' +
                                        '<div class="tables"></div>'+
                                        '</div>' +
                                        '</form>';


                                    let data = {
                                        crsf_token: crsf_hash,
                                        bordro_id_hid: bordro_id_hid,
                                    }
                                    let table_report ='';
                                    $.post(baseurl + 'salary/ajax_account_bordro_razi',data,(response) => {
                                        self.$content.find('#person-list').empty().append(html);
                                        let responses = jQuery.parseJSON(response);
                                        if(responses.status==200){
                                            responses.item.forEach((item_,index) => {
                                                $('#acid').append(new Option(item_.holder, item_.id, false, false)).trigger('change');
                                            })


                                            table_report =`<table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Personel</th>
                                                                    <th>Yatırılacak Tutar</th>
                                                                    <th>Nakit Çekilecek Tutar</th>
                                                                </tr>
                                                            </thead>
                                                           <tbody>`;
                                            responses.nakit.forEach((item_,index) => {
                                                table_report +=`<tr>
                                                                    <td>`+item_.name+`</td>
                                                                    <td>`+item_.tutar+`</td>
                                                                    <td><input bordro_item_id='`+item_.bordro_item_id+`' class="form-control cekilecek_tutar" value="0" type="number"></td>
                                                                </tr>`;
                                            })

                                            table_report +=`</tbody></table>`;
                                            $('.tables').empty().html(table_report);
                                            $('#total_tutar').empty().text(responses.toplam_tutar);
                                        }
                                        else {
                                            $('.formName').empty().text;
                                            $('.formName').append(responses.message)
                                        }


                                    });
                                    self.$content.find('#person-list').empty().append(html);
                                    return $('#person-container').html();
                                },
                                onContentReady:function (){
                                },
                                buttons: {
                                    formSubmit: {
                                        text: 'Kaydet',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            let details = [];
                                            if($('#acid').val()==''){
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: 'Kasa Seçiniz',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                                return false;
                                            }
                                            let say=0;
                                            $('.cekilecek_tutar').each((index,item) => {
                                                if($('.cekilecek_tutar').eq(index).val()==0){
                                                    say++
                                                }
                                                else {
                                                    details.push({
                                                        'bordro_item_id':$('.cekilecek_tutar').eq(index).attr('bordro_item_id'),
                                                        'value':$('.cekilecek_tutar').eq(index).val()
                                                    })
                                                }
                                            });

                                            if(say){
                                                $.alert({
                                                    theme: 'material',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: 'Nakit Çekilecek Tutar 0 Olamaz',
                                                    buttons:{
                                                        prev: {
                                                            text: 'Tamam',
                                                            btnClass: "btn btn-link text-dark",
                                                        }
                                                    }
                                                });
                                                return false;
                                            }

                                            let data = {
                                                crsf_token: crsf_hash,
                                                details: details,
                                                account_id: $('#acid').val(),
                                            }
                                            $.post(baseurl + 'salary/create_razi_kasa',data,(response) => {
                                                $('#loading-box').removeClass('d-none');
                                                let responses = jQuery.parseJSON(response);
                                                if(responses.status==200){
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
                                                else if(responses.status==410){
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
                                        text: 'Geri',
                                        btnClass: "btn btn-danger btn-sm",
                                        action: function () {
                                            $('#islemler').click()

                                        }

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
                        else{
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Razı İşlemleri Tüm Bordro Seçiliyken yapılamaz Lütfen Bordro Seçiniz',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                        }

                    },
                    className: 'razi_button_c'
                }
                ]

        });
    };



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
