<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Employee') ?> <br>

            </h5>

            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <style>
                #emptable_length, #emptable_info, #emptable_paginate, #emptable_filter
                {
                    display: none;
                }
            </style>
            <style>
                table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
                {
                    padding-right: 114px !important;
                }
            </style>
            <form method="post" id="data_form">


            <div class="card-body">
                <div>
                    <input type="submit" class="btn btn-success sub-btn btn-md"
                           value="Hesap Oluştur"
                           id="submit-data" data-loading-text="Creating...">
                </div>
                <br>

                <table id="emptable" style="display: block;
    overflow: auto;" class="genis table table-striped table-bordered zero-configuration" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Personel Adı Soyadı</th>
                        <th>Birim</th>
                        <th>Əmək Haqqı</th>
                        <th>Norma İş (ay)</th>
                        <th>Aya Nisbətdə</th>
                        <th>Hesablanıb</th>
                        <th>Məzuniyyət və ya Son Haqq-Hesab (gun)</th>
                        <th>Məzuniyyət və ya Son Haqq-Hesab</th>
                        <th>Xəstəlik</th>
                        <th>Cəmi</th>
                        <th>DSMF (Fond)</th>
                        <th>İşsizlik (Fond)</th>
                        <th>DSMF</th>
                        <th>İşsizlik</th>
                        <th>Gəlir vergisi</th>
                        <th>Ödənilmiş (ə/h, məzuniyyət s.h.h.)</th>
                        <th>Cəmi Tutulur</th>
                        <th>Cəmi Ödənilir</th>



                    </tr>
                    </thead>

                    <tfoot>
                    <tr>

                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
                <input type="hidden" value="employee/bordro_hesaplandir" id="action-url">

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('#emptable').DataTable({

            'processing': true,
            'serverSide': true,
            ordering: false,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                //$(row).attr('style',data[5]);
            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('employee/list_emp')?>",
                "type": "POST",
                data: {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash

                }
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],

            <?php datatable_lang();?> dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]
                    }
                }
            ]


        });

        //datatables



    });

    $('.delemp').click(function (e) {
        e.preventDefault();
        $('#empid').val($(this).attr('data-object-id'));

    });
</script>


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Hesap Pasifleştirme</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Bu kullanıcıyı pasif yapmak istediğinizden emin misiniz? <br><strong>Bu hesap devre dışı kalacaktır.</strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="employee/disable_user">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Onayla
                </button>
                <button type="button" data-dismiss="modal" class="btn">İptal</button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).on("keyup",".gun_sayisi,.norma_is_sayisi,.mez_hesap_gun,.hastalik,.odenilmis_e_h",function (e) {
        hesaplama_s(e,this);
    });

    function hesaplama_s(e,obj)
    {
        var eq = $(obj).parent().parent().index();
        var resmi_maas=$(".resmi_maas").eq(eq).val();
        var odenilmis_e_h=$(".odenilmis_e_h").eq(eq).val();
        var hastalik=$(".hastalik").eq(eq).val();
        var mez_hesap=0;
        var dsmf_fond=0;
        var dsmf=0;
        var gelir_vergisi=0;
        var mez_hesap_gun=$(".mez_hesap_gun").eq(eq).val();
        var gun_sayisi=$(".gun_sayisi").eq(eq).val();
        var norma_is_sayisi=$(".norma_is_sayisi").eq(eq).val();
        var hesap=(resmi_maas/gun_sayisi)*norma_is_sayisi;
        $(".hesaplanan").eq(eq).text(currencyFormat(hesap));
        $(".hesaplanan_inp").eq(eq).val(hesap);


        if(mez_hesap_gun>0)
        {
            mez_hesap = (resmi_maas/30.4)*mez_hesap_gun
        }
        var hesaplanan=$('.hesaplanan_inp').eq(eq).val();

        $(".mez_hesap").eq(eq).text(currencyFormat(mez_hesap));
        $(".mesa_hesap_inp").eq(eq).val(mez_hesap);

        var cemi = parseFloat(hesaplanan)+parseFloat(mez_hesap)+parseFloat(hastalik);

        $(".cemi").eq(eq).text(currencyFormat(cemi));
        $(".cemi_inp").eq(eq).val(cemi);

        var fark=parseFloat(cemi)-parseFloat(hastalik);

        if(fark>200)
        {
            dsmf_fond=44+(parseFloat(fark)-200)*0.15;
        }
        else
            {
                dsmf_fond=parseFloat(fark)*0.22;
            }
        $(".dsmf_fond").eq(eq).text(currencyFormat(dsmf_fond));
        $(".dsmf_fond_inp").eq(eq).val(dsmf_fond);


        var issizlik=parseFloat(cemi)*0.005;
        $(".issizlik_fond").eq(eq).text(currencyFormat(issizlik));
        $(".issizlik_fond_inp").eq(eq).val(issizlik);

        $(".issizlik").eq(eq).text(currencyFormat(issizlik));
        $(".issizlik_inp").eq(eq).val(issizlik);


        var fark_=parseFloat(cemi)-parseFloat(hastalik);
        if(fark_>200)
        {
            dsmf=6+(parseFloat(fark_)-200)*0.10;
        }
        else
        {
            dsmf=parseFloat(fark_)*0.03;
        }



        $(".dsmf").eq(eq).text(currencyFormat(dsmf));
        $(".dsm_inp").eq(eq).val(dsmf);

        if(cemi>8000)
        {
           gelir_vergisi=(parseFloat(cemi)-8000)*0.14;
        }
        else
        {
            gelir_vergisi=0
        }

        $(".gelir_vergisi").eq(eq).text(currencyFormat(gelir_vergisi));
        $(".gelir_vergisi_inp").eq(eq).val(gelir_vergisi);

        var cemi_tutulan=parseFloat(odenilmis_e_h)+parseFloat(gelir_vergisi)+parseFloat(dsmf)+parseFloat(issizlik);

        $(".cemi_tutar").eq(eq).text(currencyFormat(cemi_tutulan));
        $(".cemi_tutar_inp").eq(eq).val(cemi_tutulan);

        var cemi_odenen = parseFloat(cemi)-parseFloat(cemi_tutulan);
        $(".cemi_odenen").eq(eq).text(currencyFormat(cemi_odenen));
        $(".cemi_odenen_inp").eq(eq).val(cemi_odenen);




    }

    var floatVal = function ( i ) {
        return typeof i === 'string' ?
            i.replace(/[\AZN,.]/g, '')/100 :
            typeof i === 'number' ?
                i : 0;
    };
    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }


    $(document).on('click', "#submit_model_alacak", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_alacak").serialize();
        var action_url= $('#form_model_alacak #action-url-alacak').val();
        $("#pop_model_alacaklandirma").modal('hide');
        saveMDataHak(o_data,action_url);
    });

    $(document).on('click', "#submit_model_hakedis", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_all").serialize();
        var action_url= $('#form_model_all #action-url-all').val();
        $("#pop_model_maas").modal('hide');
        saveMDataHak(o_data,action_url);
    });

    function saveMDataHak(o_data,action_url) {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data+'&'+crsf_token+'='+crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {


                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }


    $(function () {
        $('.select-box').select2();
    });
</script>
