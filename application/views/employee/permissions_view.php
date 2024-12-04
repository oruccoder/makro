<div class="content-body">
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
            <div id="invoice-template" class="card-body">
                <div class="row">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col-lg-12">
                            <div class="title-action">

                                <button onclick="izin_update(1,<?php echo $details->id ?>)"  class="btn btn-warning mb-1"><i
                                        class="icon-check"></i>Ödenişli Təstiqle</button>

                                <button onclick="izin_update(2,<?php echo $details->id ?>)" class="btn btn-warning mb-1"><i
                                        class="icon-check"></i>Öz Hesabına Təstiqle</button>
                                <button onclick="izin_update(3,<?php echo $details->id ?>)" class="btn btn-danger mb-1"><i
                                        class="icon-cancel"></i>İptal Et</button>

                                <?php
                                $href='/employee/print_izin?id='. $details->id;
                                ?>

                                <a href="<?php echo $href; ?>" target="_blank" class="btn btn-success mb-1 btn-min-width"><i
                                        class="icon-print"></i> <?php echo $this->lang->line('print_fis') ?></a>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row mt-2">
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                        <img src="<?php  $loc=location($details->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                             class="img-responsive p-1 m-b-2" style="max-height: 120px;">

                    </div>
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                        <h2>

                            <?php
                            echo "İzin Talebi"
                            ?>
                        </h2>
                        <p style="margin-bottom: 0;"> <?php echo 'Personel Adı : ' . $details->emp_fullname . '</p>';?>


                    </div>
                </div>
                <!--/ Invoice Company Details -->


                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table table-striped">
                                <thead>

                                <tr>
                                    <th>Başangıç Tarihi</th>
                                    <th class="text-xs-left">Bitiş tarihi</th>
                                    <th class="text-xs-left">İzin Sebebi</th>
                                    <th class="text-xs-left">Şöbə Müdiri (<?php echo personel_details($details->bolum_pers_id)?>)</th>
                                    <th class="text-xs-left">Ofis Meneceri (<?php echo personel_details($details->bolum_sorumlusu)?>)</th>
                                    <th class="text-xs-left">HR (<?php echo personel_details($details->finans_pers_id)?>)</th>
                                    <th class="text-xs-left">Direktör (<?php echo personel_details($details->genel_mudur)?>)</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $a=izin_durumu($details->bolum_pers_status);
                                $b=izin_durumu($details->status);
                                $c=izin_durumu($details->genel_mudur_status);
                                $d=izin_durumu($details->finas_pers_status);
                                echo "
                                <tr>
                                <td>$details->bas_date - $details->bas_saati</td>
                                <td>$details->bitis_date - $details->bit_saati</td>
                                <td>$details->izin_sebebi</td>
                                <td>$a</td>
                                <td>$b</td>
                                   <td>$d</td>
                                <td>$c</td>


</tr>
                                ";
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Invoice Footer -->


                <hr>


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
</script>




<script type="text/javascript">

    function izin_update(status,id)
    {

        jQuery.ajax({
            url: baseurl + 'employee/izin_update',
            type: 'POST',
            data: {
                'status':status,
                'id':id
            },
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {


                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 3000);

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
