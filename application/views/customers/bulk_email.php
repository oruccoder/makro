<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <!-- Form -->

        <div class="container contact">
            <div class="row">
        <form id="sendmail_form">
            <div class="row">
                <div class="col-xs-12">
                    <div class="input-group">
                        <div class="input-group-addon"><span class="icon-envelope-o"
                                                             aria-hidden="true"></span></div>
                        <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                               value="">
                    </div>

                </div>

            </div>


            <div class="row">
                <div class="col-xs-12 mb-1"><label
                        for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                    <input type="text" class="form-control"
                           name="customername" value=""></div>
            </div>
            <div class="row">
                <div class="col-xs-12 mb-1"><label
                        for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                    <input type="text" class="form-control"
                           name="subject" id="subject">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 mb-1"><label
                        for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                    <textarea name="text" class="summernote form-control" id="contents" title="Contents"></textarea></div>
            </div>

            <input type="hidden" class="form-control"
                   id="cid" name="tid" value="">
            <input type="hidden" id="action-url" value="communication/send_general_bulk">

            <button type="button" class="btn btn-primary"
                    id="sendNow"><?php echo $this->lang->line('Send') ?></button>

        </form>
            </div>
        </div>
        <!-- Form -->
    </div>
</article>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
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
    });


    $('#sendNow').on('click', function (e) {
        var o_data =  $("#sendmail_form").serialize();
        var action_url= $('#action-url').val();
        sendMail_g(o_data,action_url);
    });


    function sendMail_g(o_data,action_url) {

            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: o_data+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                }
            });

    }
</script>