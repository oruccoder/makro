<div class="content-body">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="thermal_a" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="content-body">
                <div id="invoice-template" class="card-body" style="    text-align: center;">


                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="" style="max-height: 70px;"><br><br>
                            <p class="font_11"> <?php echo 'Talep Eden : ' . personel_details($invoice['emp_id']) . '</p>';?>
                            <p class="font_11"> <?php echo 'Talep Eden Tel : <a href="tel:0' . personel_details_full($invoice['emp_id'])['phone'] . '">İletişime Geç</a></p>';?>
                            <p class="font_11">Teklif Talep Formu</p>
                            <p class="font_11"> <?php echo 'Talep No : '. $invoice['dosya_no'] . '</p>'; ?>
<!--                            <p class="font_11" style="-->
<!--    background: #16538a;-->
<!--    padding: 5px;-->
<!--    color: white;-->
<!--    font-weight: 500;-->
<!--    font-size: 14px;-->
<!--"> Qiymətinizi ƏDV Daxil Veriniz</p>-->
                            <p class="font_11"><a  style="width: 107px !important;" href="/billing/firma_teklif_onay_pdf?pers_id=<?php echo $_GET['pers_id'];?>&id=<?php echo $_GET['id'];?>&oturum=<?php echo $_GET['oturum'];?>&token=<?php echo $_GET['token'];?>" class="btn btn-info input-xs">PDF Olarak Görüntüle</a> </p>

                        </div>

                    </div>
                    <!--/ Invoice Company Details -->


                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table">
                                <form id="data_form" type="POST">
                                    <table class="table table-responsive" id="stoklar">
                                        <thead style="font-size: 11px;">

                                        <tr>
                                            <th>#</th>
                                            <th style="text-align: center">Məhsulun Adı</th>
                                            <th style="text-align: center">Detay</th>
                                            <th style="text-align: center">Marka</th>
                                            <th colspan="2" class="text-center">Miqdarı</th>

                                            <?php if($_GET['oturum']!=1)
                                            {

                                                $old_q=intval($_GET['oturum'])-1;
                                                echo " <th class='text-center'>Əvvəlki Qiymət</th>";
                                                echo " <th class='text-center'>Yeni Qiymət</th>";
                                            }
                                            else
                                            {
                                                echo " <th class='text-center'>Qiymət</th>";
                                            }
                                            ?>
                                            <th>EDV</th>
                                            <th>Çatdırılma</th>
                                            <th>Ödənis</th>
                                            <th>İstehsalçı Ülke</th>
                                            <!--th>Ödəniş Tarixi</th-->
                                            <th>Not</th>
                                            <th>Fəaliyyət</th>

                                        </tr>
                                        </thead>
                                        <style>
                                            .input-xs
                                            {
                                                height: 26px;
                                                font-size: 9px;
                                                width: 70px;
                                            }
                                        </style>

                                        <tbody style="font-size: 11px;">

                                        <?php $c = 1;
                                        $sub_t = 0;
                                        $i = 0;
                                        $talep_id=$invoice['id'];


                                        foreach ($products as $row) {
                                            $old_catdirilma='0';
                                            $old_odenis='0';
                                            $old_ulke='';
                                            $old_note='';
                                            echo '<tr>
                                                    <td scope="row">' . $c . '</td>
                                                    <td>'. $row->product_name. '</td>
                                                    <td>'. $row->product_detail. '</td>
                                                    <td>'. $row->marka. '<input type="hidden" name="marka[]" value="'.$row->marka.'"></td>
                                                    <td>' . intval($row->product_qty) . '</td>
                                                    <td>' . $row->unit . '</td>
                                                    ';
                                            if($_GET['oturum']!=1)
                                            {
                                                $old_q=intval($_GET['oturum'])-1;
                                                $old_price = amountFormat(ihale_fiyat_bul($firma_id,$row->item_id,$old_q,$tid));
                                                $old_catdirilma = ihale_details($firma_id,$row->item_id,$old_q,$tid,'nakliye_durumu');
                                                $old_odenis = ihale_details($firma_id,$row->item_id,$old_q,$tid,'odeme');
                                                $old_ulke = ihale_details($firma_id,$row->item_id,$old_q,$tid,'ulke');
                                                $old_note = ihale_details($firma_id,$row->item_id,$old_q,$tid,'aciklama');
                                                $edv_durum = ihale_details($firma_id,$row->item_id,$old_q,$tid,'kdv');
                                                $edv_durum_text='';
                                                if($edv_durum){
                                                    $edv_durum_text='Hariç';
                                                }
                                                else {
                                                    $edv_durum_text='Dahil';
                                                }
                                                echo "<td>$old_price</td>";
                                                echo "<td><input name='fiyat[]' type='number' class='form-control input-xs fiyat'></td>";
                                            }

                                            else
                                            {
                                                echo '<td><input name="fiyat[]" type="number"  class="form-control input-xs fiyat"></td>';
                                            }
                                            echo '<td>';



                                            if($old_catdirilma!='0')
                                            {

                                                echo "<input class='form-control input-xs' disabled value='$old_catdirilma'><input type='hidden' name='nakliye_durumu[]' value='$old_catdirilma'>";
                                            }
                                            else
                                            {
                                                echo '  <select class="form-control input-xs nakliye_durumu" name="nakliye_durumu[]">
                                                                        <option value="Dahil">Dahil</option>
                                                                        <option value="Hariç">Hariç</option>
                                                                        </select>';
                                            }



                                            echo'

                                                    </td>
                                                    <td>';

                                            if($old_catdirilma!='0')
                                            {

                                                echo "<input class='form-control input-xs' disabled value='$edv_durum_text'><input type='hidden' name='nakliye_durumu[]' value='$edv_durum'>";
                                            }
                                            else
                                            {
                                                echo '  <select class="form-control input-xs nakliye_durumu" name="kdv_durumu[]">
                                                                        <option value="0">Hariç</option>
                                                                        <option value="1">Dahil</option>
                                                                        </select>';
                                            }
                                            echo'

                                                    </td>
                                                    <td>';

                                            if($old_odenis!='0')
                                            {

                                                echo "<input class='form-control input-xs' disabled value='$old_odenis'><input type='hidden' name='odeme[]' value='$old_odenis'>";
                                            }
                                            else
                                            {
                                                echo '<select class="form-control input-xs odeme" name="odeme[]">
                                                                    <option value="Vadəli">Vadəli</option>
                                                                    <option value="Əvvəlcə">Əvvəlcə</option>
                                                                </select>';
                                            }

                                            $ulke=isset($old_ulke)?$old_ulke:'';
                                            $not=isset($old_note)?$old_note:'';
                                            echo '</td>
                                                     <td><input name="ulke[]" class="form-control input-xs ulke" value="'.$ulke.'"></td>

                                                     <td><input name="not[]" class="form-control input-xs not" value="'.$not.'"></td>

                                                    <input type="hidden" class="item_id" name="item_id[]" value="'.$row->id.'">
                                                    <input type="hidden" class="oturum" name="oturum[]" value="'.$_GET['oturum'].'">
                                                    <input type="hidden" class="talep_id" name="talep_id[]" value="'.$talep_id.'">
                                                    <input type="hidden" class="pers_id" name="pers_id[]" value="'.$_GET['pers_id'].'">
                                                    <input type="hidden" name="odeme_tarihi[]" value="-" class="form-control input-xs odeme_tarihi">
                                                    <td>-</td>
                                                </tr>';




                                            $c++;
                                            $i++;
                                        }?>

                                        <!--td><input name="odeme_tarihi[]" class="form-control input-xs odeme_tarihi"></td-->
                                        <tr class="last-item-row sub_c">

                                        </tr>


                                        </tbody>

                                    </table>
                                    <table>
                                        <tbody>
                                        <tr>
                                            <th style="border-top:none!important;" colspan="1" scope="row"><button id="add_product" type="button" class="btn btn-info btn-xs">Xətt Əlavə Edin</button></th>
                                            <th style="border-top:none!important;" colspan="1" scope="row"><button id="tumunu_onayla" type="button" class="btn btn-info btn-xs">Təstiqle</button></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <input type="hidden" value="<?php echo $i ; ?>" name="counter" id="ganak">
                                </form>
                            </div>
                        </div>
                        <style>
                            .table th, .table td
                            {
                                padding: 7px !important;
                            }
                            .mt-2, .my-2
                            {
                                margin-top: 0 !important;
                            }
                            .font_11
                            {
                                font-size: 11px;
                            }
                        </style>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

    $('#stoklar').on('click', '.removeProd', function () {
        $(this).closest('tr').remove();
    });

    $('#add_product').on('click', function () {
        var cvalue = parseInt($('#ganak').val())+1;

        var data = '<tr>' +
            '<td scope="row">' + cvalue + '</td>' +
            '<td><input type="text" class="form-control text-center input-xs" name="product_name[]"  id="productname-' + cvalue + '"></td>' +
            '<td><input type="text" class="form-control text-center input-xs" name="product_marka[]" placeholder="marka" id="product_marka-' + cvalue + '"></td>' +
            '<td>' +'<input type="text" class="form-control req amnt input-xs" name="product_qty[]" ' +'id="amount-' + cvalue + '" autocomplete="off"' + ' value="1"></td> ' +
            '<td>' +'<input type="text" class="form-control req unit input-xs" name="product_unit[]" ' +'id="unit-' + cvalue + '" autocomplete="off"' + ' value="Adet"></td> ' +
            '<td><input type="text" ' + 'class="form-control req prc input-xs" name="product_fiyat[]" id="price-' + cvalue + '" autocomplete="off"></td>' +
            '<td> <select class="form-control input-xs nakliye_durumu" name="product_nakliye_durumu[]"><option value="Dahil">Dahil</option><option value="Hariç">Hariç</option></select></td>'+
            '<td> <select class="form-control input-xs product_kdv_durumu" name="product_kdv_durumu[]"><option value="0">Hariç</option><option value="1">Dahil</option></select></td>'+
            '<td> <select class="form-control input-xs odeme" name="product_odeme[]">  <option value="Vadəli">Vadəli</option><option value="Əvvəlcə">Əvvəlcə</option></select></td>'+
            '<td><input name="product_ulke[]" class="form-control input-xs ulke"></td>'+
            '<input type="hidden" name="product_odeme_tarihi[]">'+
            '<td><input name="product_not[]" class="form-control input-xs not">  <input type="hidden" class="product_oturum" name="product_oturum[]" value="<?php echo $_GET['oturum']?>"></td>'+
            '<td><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button></td>'+
            '</tr>';

        $('tr.last-item-row').before(data);

        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
    })

    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>invoices/file_handling?id=<?php echo $invoice['id'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>invoices/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['id'] ?>" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a></td></tr>');

                });
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
    });




    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });

    $(document).on('click',"#tumunu_onayla",function(e) {


        jQuery.ajax({
            url: baseurl + 'billing/firma_teklif_onay_',
            type: 'POST',
            data: $('#data_form').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {

                    $('#'+$('#object-id').val()).remove();
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#invoice-template').remove();
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
    });

    $(document).on('click', ".onayla,.iptal", function (e) {
        e.preventDefault();
        var eq=$(this).parent().parent().index();
        var talep_id=$(".talep_id").eq(eq).val();
        var item_id=$(".item_id").eq(eq).val();
        var fiyat=$(".fiyat").eq(eq).val();
        var odeme=$(".odeme").eq(eq).val();
        var nakliye_durumu=$(".nakliye_durumu").eq(eq).val();
        var odeme_tarihi=$(".odeme_tarihi").eq(eq).val();
        var pers_id=<?php echo  $_GET['pers_id']; ?>;

        jQuery.ajax({
            url: baseurl + 'billing/avans_talep_product_status',
            type: 'POST',
            data: {
                'item_id':item_id,
                'talep_id':talep_id,
                'fiyat':fiyat,
                'odeme':odeme,
                'nakliye_durumu':nakliye_durumu,
                'odeme_tarihi':odeme_tarihi,
                'pers_id':pers_id
            },
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');
                $(this).prop('disabled', true); // disable button

            },
            success: function (data) {

                if (data.status == "Success") {

                    $('#'+$('#object-id').val()).remove();
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




    });


    $(document).on('click', ".islem_bitir", function (e) {
        e.preventDefault();
        var talep_id=<?php echo  $_GET['id']; ?>;
        var pers_id=<?php echo  $_GET['pers_id']; ?>;

        jQuery.ajax({
            url: baseurl + 'billing/avans_talep_islem_bitir',
            type: 'POST',
            data: {
                'talep_id':talep_id,
                'pers_id':pers_id,
            },
            dataType: 'json',
            beforeSend: function(){
                $(".islem_bitir").html('Bekleyiniz');
                $(".islem_bitir").prop('disabled', true); // disable button

            },
            success: function (data) {
                if (data.status == "Success") {
                    $('#'+$('#object-id').val()).remove();
                    $('#invoice-template').remove();
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




    });
</script>



<script type="text/javascript">


    $(function () {
        $('.summernote').summernote({
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });

    });





</script>
