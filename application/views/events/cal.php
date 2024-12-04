<link rel="stylesheet" type="text/css"
      href="<?= base_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css">
<link href="<?php echo base_url(); ?>assets/c_portcss/bootstrapValidator.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/c_portcss/bootstrap-colorpicker.min.css"
      rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo base_url(); ?>assets/c_portcss/custom.css" rel="stylesheet"/>

<script src='<?php echo base_url(); ?>assets/c_portjs/bootstrap-colorpicker.min.js'></script>


<div class="content-body">
    <div class="card">

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <!-- Notification -->
                <div class="alert"></div>


                <div id='calendar'></div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Kapat</span></button>
            </div>
            <div class="modal-body">
                <div class="error"></div>
                <form class="form-horizontal" id="crud-form">
                    <input type="hidden" id="start">
                    <input type="hidden" id="end">
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="title"><?php echo $this->lang->line('Add Event') ?></label>

                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="title">Kurum / Firma</label>
                        <div class="col-md-8">
                            <input id="kurum_firma" name="kurum_firma" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="title">Yetkili Kişi</label>
                        <div class="col-md-8">
                            <input id="yetkkili_kisi" name="yetkkili_kisi" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="title">Telefon</label>
                        <div class="col-md-8">
                                <input id="telefon" name="telefon" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="title">Konu</label>
                        <div class="col-md-8">
                            <input id="title" name="title" type="text" class="form-control input-md"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="description">Görüşme Sebebi</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="etkinlik_saati">Randevu Başlangıç Saati</label>
                        <div class="col-md-8">
                            <select class="form-control select2" id="etkinlik_saati" name="etkinlik_saati">
                                <?php echo saatler(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="etkinlik_saati">Randevu Bitiş Saati</label>
                        <div class="col-md-8">
                            <select class="form-control select2" id="etkinlik_saati_bitis" name="etkinlik_saati_bitis">
                                <?php echo saatler(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="etkinlik_saati">Yeni Durum</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" disabled id="yeni_durum">
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="etkinlik_saati">Durum</label>
                        <div class="col-md-8">
                            <select class="form-control" id="status" name="status">
                                <option value="0">Bekliyor</option>
                                <option value="2">Onaylandı</option>
                                <option value="1">Görüşme Tamamlandı</option>

                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="etkinlik_saati"><?php echo $this->lang->line('personel_listesi_etkinlik') ?></label>
                        <div class="col-md-8">

                                <select class="form-control Tarihi" name="personel_l[]" id="personel_l" multiple="multiple" style="width: 100%!important;">

                                    <?php foreach (personel_list() as $emp){
                                        $emp_id=$emp['id'];
                                        $name=$emp['name'];
                                        ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                    <?php } ?>
                                </select>

                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 control-label"
                               for="color"><?php echo $this->lang->line('Color') ?></label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control input-md"
                                   readonly="readonly"/>
                            <span class="help-block">Renk Seçiniz</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<style>
    .fc-time
    {
        display: none;
    }
</style>

<script src="<?= base_url() ?>app-assets/vendors/js/extensions/moment.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/fullcalendar.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/lang-all.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/lang/tr.js"></script>

<script>
    $(function(){

        var currentDate; // Holds the day clicked when adding a new event
        var currentEvent; // Holds the event object when editing an event

        $('#color').colorpicker(); // Colopicker


        var base_url=baseurl; // Here i define the base_url

        // Fullcalendar
        $('#calendar').fullCalendar({
            lang:'tr',
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },

            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url+'events/getEvents',
            selectable: true,
            eventOrder: 'etkinlik_saati',
            selectHelper: true,
            editable: true, // Make the event resizable true
            select: function(start, end) {

                $('#start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                // Open modal to add event
                modal({
                    // Available buttons when adding
                    buttons: {
                        add: {
                            id: 'add-event', // Buttons id
                            css: 'btn-success', // Buttons class
                            label: 'Ekle' // Buttons label
                        }
                    },
                    title: 'Etkinlik Ekle' // Modal title
                });
            },

            eventDrop: function(event, delta, revertFunc,start,end) {

                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if(event.end){
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                }else{
                    end = start;
                }


                $.post(base_url+'events/dragUpdateEvent',
                    'id='+event.id+
                    '&start='+start+
                    '&end='+end+'&'+
                    '&personel_l='+personel_l+'&'+
                    'etkinlik_saati='+$('#etkinlik_saati').val()+'&'+
                    'etkinlik_saati_bitis='+$('#etkinlik_saati_bitis').val()+'&'+
                    'kurum_firma='+$('#kurum_firma').val()+'&'+
                    'yetkkili_kisi='+$('#yetkkili_kisi').val()+'&'+
                    'telefon='+$('#telefon').val()+'&'+
                    +crsf_token+'='+crsf_hash, function(result){
                    $('.alert').addClass('alert-success').text('Event updated successful');
                    $('.modal').modal('hide');
                    $('#calendar').fullCalendar("refetchEvents");
                    hide_notify();

                });



            },
            eventResize: function(event,dayDelta,minuteDelta,revertFunc) {

                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if(event.end){
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                }else{
                    end = start;
                }

                $.post(base_url+'events/dragUpdateEvent',
                    'id='+event.id+
                    '&start='+start+
                    '&end='+end+'&'+
                    '&etkinlik_saati='+$('#etkinlik_saati').val()+'&'+
                    '&etkinlik_saati_bitis='+$('#etkinlik_saati_bitis').val()+'&'+
                    '&kurum_firma='+$('#kurum_firma').val()+'&'+
                    '&yetkkili_kisi='+$('#yetkkili_kisi').val()+'&'+
                    '&telefon='+$('#telefon').val()+'&'+
                    '&personel_l='+$('#personel_l').val()+'&'+
                     crsf_token+'='+crsf_hash, function(result){
                    $('.alert').addClass('alert-success').text('Event updated successful');
                    $('.modal').modal('hide');
                    $('#calendar').fullCalendar("refetchEvents");
                    hide_notify();

                });


            },

            // Event Mouseover
            eventMouseover: function(calEvent, jsEvent, view){

                var tooltip = '<div class="event-tooltip">' + calEvent.description + '</div>';
                $("body").append(tooltip);

                $(this).mouseover(function(e) {
                    $(this).css('z-index', 10000);
                    $('.event-tooltip').fadeIn('500');
                    $('.event-tooltip').fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $('.event-tooltip').css('top', e.pageY + 10);
                    $('.event-tooltip').css('left', e.pageX + 20);
                });
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.event-tooltip').remove();
            },
            // Handle Existing Event Click
            eventClick: function(calEvent, jsEvent, view) {
                // Set currentEvent variable according to the event clicked in the calendar
                currentEvent = calEvent;

                // Open modal to edit or delete event
                modal({
                    // Available buttons when editing
                    buttons: {
                        delete: {
                            id: 'delete-event',
                            css: 'btn-danger',
                            label: 'Sil'
                        },
                        update: {
                            id: 'update-event',
                            css: 'btn-success',
                            label: 'Düzenle'
                        }
                    },
                    title: 'Etkiliği Düzenle',
                    event: calEvent
                });
            }

        });

        // Prepares the modal window according to data passed
        function modal(data) {



            // Set modal title
            $('.modal-title').html(data.title);
            // Clear buttons except Cancel
            $('.modal-footer button:not(".btn-default")').remove();
            // Set input values

            $('#start').val(data.start);
            $('#end').val(data.end);
            var yeni_durum='';



            $('#title').val(data.event ? data.event.title : '');
            $('#description').val(data.event ? data.event.description : '');
            $('#etkinlik_saati').val(data.event ? data.event.etkinlik_saati_rel : '');
            $('#etkinlik_saati_bitis').val(data.event ? data.event.etkinlik_saati_bitis_rel : '');

            $('#kurum_firma').val(data.event ? data.event.kurum_firma : '');
            $('#yetkkili_kisi').val(data.event ? data.event.yetkkili_kisi : '');
            $('#telefon').val(data.event ? data.event.telefon : '');

            if(data.event)
            {
                    if(data.event.status==0)
                {
                    yeni_durum="Bekliyor";
                }
                else if(data.event.status==2)
                {
                    yeni_durum="Onaylandı";
                }
                else if(data.event.status==1)
                {
                    yeni_durum="Görüşme Tamamlandı";
                }

            }



            $('#yeni_durum').val(yeni_durum);
            //PErsoneller

            if(data.event) {
                var personller = data.event.pers_id;
                if (personller) {
                    $('#personel_l').val(null).trigger('change');
                    var studentSelect = $('#personel_l');
                    var array_pers_id = personller.split(",");


                    for (var i = 0; i < array_pers_id.length; i++) {

                        var pers_id = array_pers_id[i];
                        var pers_name = pers_name_func(array_pers_id[i]);
                        var newOption = new Option(pers_name, pers_id, true, true);
                        studentSelect.append(newOption).trigger('change');

                    }

                }
                else {
                    $('#personel_l').val(null).trigger('change');
                }
            }


            //PErsoneller

            $('#color').val(data.event ? data.event.color : '#3a87ad');
            // Create Butttons
            $.each(data.buttons, function(index, button){
                $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>')
            })
            //Show Modal
            $('.modal').modal('show');
        }

        // Handle Click on Add Button
        $('.modal').on('click', '#add-event',  function(e){
            if(validator(['title', 'description'])) {
                $.post(base_url+'events/addEvent',
                    'title='+$('#title').val()+
                    '&description='+$('#description').val()+
                    '&color='+$('#color').val()+
                    '&start='+$('#start').val()+
                    '&end='+$('#end').val()+
                    '&etkinlik_saati='+$('#etkinlik_saati').val()+
                    '&etkinlik_saati_bitis='+$('#etkinlik_saati_bitis').val()+
                    '&kurum_firma='+$('#kurum_firma').val()+
                    '&yetkkili_kisi='+$('#yetkkili_kisi').val()+
                    '&telefon='+$('#telefon').val()+
                    '&personel_l='+$('#personel_l').val()+
                    '&'+crsf_token+'='+crsf_hash , function(result){
                        $('.alert').addClass('alert-success').text('Event added successful');
                        $('.modal').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                        hide_notify();
                    });
            }
        });


        // Handle click on Update Button
        $('.modal').on('click', '#update-event',  function(e){
            if(validator(['title', 'description'])) {

                $.post(base_url+'events/updateEvent',
                    'id='+currentEvent.id+
                    '&title='+$('#title').val()+
                    '&description='+
                    $('#description').val()+
                    '&color='+$('#color').val()+
                    '&etkinlik_saati='+$('#etkinlik_saati').val()+
                    '&etkinlik_saati_bitis='+$('#etkinlik_saati_bitis').val()+
                    '&kurum_firma='+$('#kurum_firma').val()+
                    '&yetkkili_kisi='+$('#yetkkili_kisi').val()+
                    '&telefon='+$('#telefon').val()+
                    '&personel_l='+$('#personel_l').val()+
                    '&status='+$('#status').val()+
                    '&'+crsf_token+'='+crsf_hash,
                    function(result){
                        $('.alert').addClass('alert-success').text('Event updated successful');
                        $('.modal').modal('hide');
                        $('#calendar').fullCalendar("refetchEvents");
                        hide_notify();


                    });
            }
        });
//hide color
        $("#link_to_cal").change(function ()
        {

            $('#hidden_div').show();


        });


        // Handle Click on Delete Button

        $('.modal').on('click', '#delete-event',  function(e){
            $.get(base_url+'events/deleteEvent?id=' + currentEvent.id, function(result){
                $('.alert').addClass('alert-success').text('Event deleted successful !');
                $('.modal').modal('hide');
                $('#calendar').fullCalendar("refetchEvents");
                hide_notify();
            });
        });

        function hide_notify()
        {
            setTimeout(function() {
                $('.alert').removeClass('alert-success').text('');
            }, 2000);
        }


        // Dead Basic Validation For Inputs
        function validator(elements) {
            var errors = 0;
            $.each(elements, function(index, element){
                if($.trim($('#' + element).val()) == '') errors++;
            });
            if(errors) {
                $('.error').html('Please insert title and description');
                return false;
            }
            return true;
        }

        $('#adate').fullCalendar({
            lang:'tr',
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url+'user/getAttendance',
            selectable: false,
            selectHelper: false,
            editable: false, // Make the event resizable true
            select: function(start,end) {

                $('#start').val(moment(start+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));

            }





        });

        $('#holidays').fullCalendar({
            lang:'tr',
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            eventLimit: true, // allow "more" link when too many events
            events: base_url+'user/getHolidays',
            selectable: false,
            selectHelper: false,
            editable: false, // Make the event resizable true
            select: function(start,end) {

                $('#start').val(moment(start+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));
                $('#end').val(moment(end+' 00:00:00').format('YYYY-MM-DD HH:mm:ss'));

            }





        });

    });

    $('#personel_l').select2();




        function pers_name_func(id) {

            var ret;
            $.ajax({
                type: "POST",
                async: false,
                url: baseurl + 'events/pers_name',
                data:
                'pers_id='+ id+
                '&'+crsf_token+'='+crsf_hash,
                success: function (data) {
                  ret=data;
                }
            });
            return ret;
        }
</script>

<?php /*
 Code for localization
<script src="<?= base_url() ?>app-assets/vendors/js/fullcalendar/locale/es.js"></script>
 */

