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
                <div id="invoice-template" class="card-body" style="text-align: center;">


                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-12 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location(5);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="" style="max-height: 70px;"><br><br>
                        </div>

                    </div>
                    <!--/ Invoice Company Details -->


                    <!--/ Invoice Customer Details -->

                    <!-- Invoice Items Details -->

                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table">
                                <p style="text-align: center"><?php echo onay_bekleyen_izinler_durum($pers_id,$detail['id'])?></p>
                                <form id="data_form" type="POST">

                                    <table class="table">
                                        <tr>
                                            <th>Personel</th>
                                            <th>İzin Sebebi</th>
                                            <th>Başlangıç Tarihi</th>
                                            <th>Bitiş Tarihi</th>
                                        </tr>
                                        <tr>
                                            <td><?php echo $detail['emp_fullname']?></td>
                                            <td><?php echo $detail['izin_sebebi']?></td>
                                            <td><?php echo $detail['bas_date'].' '.$detail['bas_saati']?></td>
                                            <td><?php echo $detail['bitis_date'].' '.$detail['bit_saati']?></td>
                                        </tr>

                                    </table>

                                    <input id="pers_id" name="pers_id" type="hidden" value="<?php echo $pers_id;?>">
                                    <input id="izin_id" name="izin_id" type="hidden" value="<?php echo $id;?>">
                                    <button type="button" class="btn btn-info btn-xs durum_degistir" status="1" >Ödenişli Təstiqle</button>
                                    <button type="button" class="btn btn-info btn-xs durum_degistir" status="2">Öz Hesabına Təstiqle</button>
                                    <button type="button" class="btn btn-info btn-xs durum_degistir" status="3">İptal Et</button>

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
                            .btn-group-xs>.btn, .btn-xs
                            {
                                margin: 5px;
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

    $(document).on('click',".durum_degistir",function(e) {


        var status=$(this).attr('status');

        jQuery.ajax({
            url: baseurl + 'billing/izin_talebi_onay?tip='+status,
            type: 'POST',
            data: $('#data_form').serialize(),
            dataType: 'json',
            beforeSend: function(){
                $(this).html('Bekleyiniz');

            },
            success: function (data) {
                if (data.status == "Success") {

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

        $('.select-box').select2();
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
