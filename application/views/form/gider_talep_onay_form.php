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
                            <p class="font_11"> <?php echo $this->lang->line('project_name') . ': <b>' . $invoice['proje_name'] . '</b></p>';?>
                            <p class="font_11"> <?php echo 'Talep Eden : ' . personel_details($invoice['talep_eden_pers_id']) . '</p>';?>
                            <p class="font_11">Gider Talep Formu</p>
                            <p class="font_11"> <?php echo 'Talep No : '. $invoice['talep_no'] . '</p>'; ?>
                                <?php echo '<p class="font_11"><span class="text-muted">'.$this->lang->line('creation date').'  :</span> ' . dateformat($invoice['olusturma_tarihi']) . '</p> 
                            ';
                                ?>
                        </div>

                    </div>
                    <!--/ Invoice Company Details -->


                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table">
                                <form id="data_form" type="POST">
                                    <table class="table-responsive">
                                        <thead style="font-size: 11px;">

                                        <tr>
                                            <th>#</th>
                                            <th>Eylem</th>
                                            <th><?php echo $this->lang->line('Item Name') ?></th>
                                            <th>Not</th>
                                            <th class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                            <th class="text-center">Fiyat</th>

                                        </tr>
                                        </thead>

                                        <tbody style="font-size: 11px;">

                                        <?php $c = 1;
                                        $sub_t = 0;
                                        $talep_id=$invoice['id'];

                                        foreach ($products as $row) {

                                            $sub_t += $row['price'] * $row['qty'];
                                            $product_id = $row['product_id'];
                                            if(onay_durumlari_ogren_product(4,$_GET['id'],$product_id))
                                            {



                                                echo '<tr>
                                                    <th scope="row">' . $c . '</th>
                                                    <th scope="row"><button  class="btn btn-success btn-xs onayla" status="3" >✓</button>&nbsp
                                                    <button  class="btn btn-danger btn-xs iptal" status="4">X</button></th>
                                                    <td>' . $row['product_name'] .' '.$row['product_detail']. '</td>             
                                                    <td>  <input class="form-control input-xs note" name="note[]" id="inputxs" type="text"></td>       
                                                    <td>' . intval($row['qty']) .' '. units_($row['unit'])['name'] . '</td>                    
                                                    <td>'.amountFormat($row['price']) . '</td>                    
                                                    <input type="hidden" class="product_id" name="product_id[]" value="'.$product_id.'">
                                                    <input type="hidden" class="talep_id" name="talep_id[]" value="'.$talep_id.'">
                                                    <input type="hidden" class="pers_id" name="pers_id[]" value="'.$_GET['pers_id'].'">
                                                </tr>';


                                                $c++;
                                            }
                                        }?>
                                        <tr>
                                            <th colspan="4"></th>
                                            <th>Toplam</th>
                                            <th><?php echo amountFormat($sub_t)?></th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" scope="row"><button id="tumunu_onayla" type="button" class="btn btn-info btn-xs">Tümünü Təstiqle</button></th>
                                            <th colspan="3" scope="row"><button style="float: right;" class="btn btn-info btn-xs islem_bitir">İşlemi Bitir</button></th>
                                        </tr>
                                        <tr>
                                            <td colspan="6" style="text-align: end;">
                                                <?php echo $invoice['description'] ?>
                                            </td>
                                        </tr>

                                        </tbody>

                                    </table>
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
            url: baseurl + 'billing/gider_talep_product_status_toplu',
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
                    $( ".islem_bitir" ).trigger( "click" );
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
        var status=$(this).attr('status');

        var product_id=$(".product_id").eq(eq).val();
        var talep_id=$(".talep_id").eq(eq).val();
        var note=$(".note").eq(eq).val();
        var tip=4;
        var pers_id=<?php echo  $_GET['pers_id']; ?>;

        jQuery.ajax({
            url: baseurl + 'billing/gider_talep_product_status',
            type: 'POST',
            data: {
                'product_id':product_id,
                'talep_id':talep_id,
                'tip':tip,
                'note':note,
                'pers_id':pers_id,
                'status':status,
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
            url: baseurl + 'billing/gider_talep_islem_bitir',
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
