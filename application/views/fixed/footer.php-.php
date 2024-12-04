</div>
</div>
</div>

<div class="container"  id="messages" style="position: fixed;bottom: 0;display: none">
    <div class="row">
        <div class="alert alert-danger" role="alert">

        </div>
    </div>

</div>

<link rel="stylesheet" type="text/css" href="/app-assets/js/datetimepickers/jquery.datetimepicker.css"/>
<script src="/app-assets/js/datetimepickers/jquery.datetimepicker.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/app-assets/js/datetimepickers/build/jquery.datetimepicker.full.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="/app-assets/js/datetimepickers/build/jquery.datetimepicker.full.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- BEGIN VENDOR JS-->
<script type="text/javascript">
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });


    $('[data-toggle="datepicker"]').datepicker('setDate', '<?php echo dateformat(date('Y-m-d')); ?>');

    $('[data-toggle="invoicedate"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
    $('[data-toggle="invoicedate"]').datepicker();



    $('[data-toggle="editdatepicker"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });




    $('[data-toggle="filter_date"]').datepicker({
        autoHide: true,
        format: '<?php echo $this->config->item('dformat2'); ?>'
    });
    $('[data-toggle="filter_date"]').datepicker();




    $('#sdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('#sdate').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');
    $('.date30').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
    $('.date30').datepicker('setDate', '<?php echo dateformat(date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d'))))); ?>');


</script>


<script src="<?php echo
base_url(); ?>assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/unslider-min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script src="<?= base_url() ?>app-assets/js/core/app-menu.js"></script>
<script src="<?= base_url() ?>app-assets/js/core/app.js"></script>
<script type="text/javascript" src="<?= base_url() ?>app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="<?php echo base_url(); ?>assets/myjs/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>app-assets/vendors/js/tables/datatable/datatables.min.js"></script>

<script type="text/javascript">var dtformat = $('#hdata').attr('data-df');
    var currency = $('#hdata').attr('data-curr');</script>
<script src="<?php echo base_url('assets/myjs/custom.js') ; ?>"></script>
<script src="<?php echo base_url('assets/myjs/basic.js') ; ?>"></script>
<script src="<?php echo base_url('assets/myjs/control.js') ; ?>"></script>

<script type="text/javascript">
    $.ajax({

        url: baseurl + 'manager/pendingtasks',
        dataType: 'json',
        success: function (data) {
            $('#tasklist').html(data.tasks);
            $('#taskcount').html(data.tcount);

        },
        error: function (data) {
            $('#response').html('Error')
        }

    });

    $( document ).ready(function() {
        mesaj_kontrol()
    });

    function mesaj_kontrol() {
        $.ajax({

            url: baseurl + 'messages/mesaj_kontrol',
            dataType: 'json',
            success: function (data) {
                $('#messages').css('display','block')
                $('#messages div div').html(data.message)
             }

            });
        
        }





</script>


</body>
</html>

<script>
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
</script>
<style>
    .xdsoft_datetimepicker{
        z-index:99999999999 !important;
    }
</style>