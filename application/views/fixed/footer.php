

<div class="navbar navbar-expand-lg navbar-light">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
            <i class="icon-unfold mr-2"></i>
            Footer
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-footer">
        <div class="navbar-collapse collapse" id="navbar-footer">
                <span class="navbar-text">
                    &copy; 2022. Makro2000 - ERP
                </span>
            <ul class="navbar-nav ml-lg-auto">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link font-weight-semibold">
                            <span class="text">
                                <i class="fas fa-hard-hat mr-2"></i> <span><?php echo $this->aauth->get_user()->username ?></span>
                            </span>
					</a>

				</li>
                <li class="nav-item">
                    <a href="https://makro2000.com.tr" class="navbar-nav-link font-weight-semibold">
                            <span class="text-pink">
                                <i class="fas fa-hard-hat mr-2"></i> makro2000.com.tr
                            </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a>
                        <img style="width: 30%" src="https://local.makro2000.com.tr/userfiles/company/16112148532133612669.png">
                    </a>

                </li>

            </ul>
        </div>
    </div>
</div>
<div id="loading-box" class="d-none">
    <div class="lds-ripple"><div></div><div></div></div>
</div>
<audio id="new_massage">
    <source src="<?= base_url().'userfiles/sound/new-message.mp4'?>" type="audio/mpeg">
</audio>
<a class="message_fixed" href="/chat">
    <span class="count_messaj">0</span>
<i class="icon-bubble9 me-3 icon-2x" style="background: #92c830;
  padding: 11px;
  border-radius: 50%;"></i>
</a>

<style>
    .count_messaj {
        position: absolute;
        top: 2px;
        left: 25px;
        width: 20px;
        height: 20px;
        line-height: 20px;
        text-align: center;
        background-color: #ff702a;
        border-radius: 50%;
        color: #fff;
        font-weight: 600;
        font-size: 10px;
        z-index: 999;

    }

    .message_fixed:hover {
        text-decoration: none;
        color: white;
    }

    .message_fixed {
        position: fixed;
        right: 64px;
        bottom: 4px;
        color: white;
        text-align: center;
    }
</style>


<script src="<?php echo base_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');</script>
<script src="<?= base_url().'assets/myjs/custom.js?v='.rand(11111,99999) ?>"></script>
<script src="<?php echo base_url('assets/myjs/basic.js') ; ?>"></script>
<script src="<?= base_url().'assets/myjs/control.js?v='.rand(11111,99999) ?>"></script>
<!-- BEGIN VENDOR JS-->


<script>

    // $(document).ready(function () {
    //     let data = {
    //         durum:0
    //     }
    //     $.post(baseurl + 'chat/new_message_kontrol',data,(response) => {
    //         let responses = jQuery.parseJSON(response);
    //         $('.count_messaj').html(responses.count);
    //     });
    // });
    //
    // setInterval(function(){
    //     uyari_kontrol(0);
    // }, 10000);

    function uyari_kontrol(durum=0){
        let data = {
            durum:durum
        }
        $.post(baseurl + 'chat/new_message_kontrol',data,(response) => {
            let responses = jQuery.parseJSON(response);
            if (responses.status == 200) {

                $('#new_massage').get(0).play();
                uyari_kontrol(1);

            }

            $('.count_messaj').html(responses.count);
        });
    }
</script>

<script type="text/javascript">




    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');
    $('.date30').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');

    function cleartalep(){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Talep Listesi',
            icon: 'fa fa-trash',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-3 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Talep Listenizi Boşaltmak İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'projestoklari/talep_list_clear',data,(response) => {
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
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })

                $('#fileupload_').fileupload({
                    url: url,
                    dataType: 'json',
                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                    done: function (e, data) {
                        var img='default.png';
                        $.each(data.result.files, function (index, file) {
                            img=file.name;
                        });

                        $('#image_text').val(img);
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


    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        dateFormat: 'dd-mm-yy'
    });


    $('[data-toggle="datepicker"]').datepicker('setDate', '<?php echo dateformat(date('Y-m-d')); ?>');

    $('[data-toggle="invoicedate"]').datepicker({
        autoHide: true,
        dateFormat: 'dd-mm-yy'
    });





    $('[data-toggle="editdatepicker"]').datepicker({
        autoHide: true,
        dateFormat: 'dd-mm-yy'
    });




    $('[data-toggle="filter_date"]').datepicker({
        autoHide: true,
        dateFormat: 'dd-mm-yy'
    });
    $('[data-toggle="filter_date"]').datepicker();
</script>

<style>
    .xdsoft_datetimepicker{
        z-index:99999999999 !important;
    }
    .dropdown, .dropleft, .dropright, .dropup{
        list-style: none !important;
    }
</style>

