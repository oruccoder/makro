
<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Chat Yönetimi</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
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
                                    <div class="panel messages-panel">
                                        <div class="contacts-list">
                                            <div class="col-md-12 row">
                                                <button class="new_message btn btn-success mb-2">Yeni Mesaj&nbsp;<i class="icon-bubble9 me-3 icon-2x"></i></button>
                                            </div>
                                            <div class="inbox-categories">
                                                <div data-toggle="tab" data-target="#inbox" class="active"> Sohbetler </div>
                                            </div>
                                            <div class="tab-content">
                                                <div id="inbox" class="contacts-outter-wrapper tab-pane active">
                                                    <div class="contacts-outter">
                                                        <ul class="list-unstyled contacts">
                                                            <?php if($user_ids) {
                                                                foreach ($user_ids as $user_values){
                                                                    $details_son_message = son_mesaj_detaylari($user_values->user_id);

                                                                    ?>
                                                                    <li data-toggle="tab" class="messages_button" data-target="#inbox-message-<?php echo $user_values->user_id ?>" user_id="<?php echo $user_values->user_id ?>">
                                                                        <div class="message-count" user_id="<?php echo $user_values->user_id ?>"> <?php echo mesaj_durumu($user_values->user_id); ?> </div>
                                                                        <img alt="" class="img-circle medium-image" src="<?php echo base_url('userfiles/employee/' . $user_values->picture); ?>">
                                                                        <!-- Son Attığı Mesaj-->
                                                                        <div class="vcentered info-combo">
                                                                            <h3 class="no-margin-bottom name"> <?php echo $user_values->name ?> </h3>
                                                                            <h5> <?php echo $details_son_message->message; ?>
                                                                            </h5>
                                                                        </div>
                                                                        <div class="contacts-add">
                                                                            <span class="message-time"> <?php echo $details_son_message->times ?> </span>
                                                                        </div>
                                                                        <!-- Son Attığı Mesaj-->
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }?>




                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-content">
                                            <?php if($user_ids) {
                                                foreach ($user_ids as $user_values){
                                                    ?>

                                                    <input type="hidden" class="hid_mk_user mk_chat_id-user_id" value="<?php echo $user_values->user_id; ?>">
                                                    <div class="tab-pane message-body" id="inbox-message-<?php echo $user_values->user_id ?>" user_id="<?php echo $user_values->user_id ?>">
                                                        <div class="message-chat">
                                                            <div class="chat-body add_chat-<?php echo $user_values->user_id ?>">
                                                                <?php
                                                                $all_messages = all_messages($user_values->user_id);
                                                                foreach ($all_messages as $items){
//                                                                    $span='Görülmedi';
//                                                                    if($items->visable){
//                                                                        $span='Görüldü';
//                                                                    }
                                                                    $picture =personel_details_full($items->auth_id)['picture'];
                                                                    ?>
                                                                    <input type="hidden" class="hid_mk_chat mk_chat_id-<?php echo $user_values->user_id ?>" value="<?php echo $items->id; ?>">


                                                                    <?php

                                                                    if($items->user_id==$user_values->user_id){

                                                                        ?>

                                                                        <div class="message info">
                                                                            <img alt="" class="img-circle medium-image" src="<?php echo base_url('userfiles/employee/' . $picture); ?>">

                                                                            <div class="message-body">
                                                                                <div class="message-info">
                                                                                    <h4> <?php echo personel_details($items->auth_id) ?> </h4>
                                                                                    <h5> <i class="fa fa-clock-o"></i> <?php echo $items->created_at ?></h5>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="message-text">
                                                                                    <?php echo $items->message ?><br>
<!--                                                                                    <span class="text-muted message-text_span" style="font-size:9px">--><?php //echo $span ?><!--</span>-->
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <?php
                                                                    }else{
                                                                        ?>
                                                                        <div class="message my-message">
                                                                            <img alt="" class="img-circle medium-image" src="<?php echo base_url('userfiles/employee/' . $picture); ?>">
                                                                            <div class="message-body">
                                                                                <div class="message-body-inner">
                                                                                    <div class="message-info">
                                                                                        <h4>  <?php echo personel_details($items->auth_id) ?> </h4>
                                                                                        <h5> <i class="fa fa-clock-o"></i> <?php echo $items->created_at ?></h5>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="message-text">
                                                                                        <?php echo $items->message ?><br>
<!--                                                                                        <span class="text-muted " style="font-size:9px">--><?php //echo $span ?><!--</span>-->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                            </div>

                                                            <div class="chat-footer">
                                                                <textarea class="send-message-text messages_tex-<?php echo $user_values->user_id ?>" user_id="<?php echo $user_values->user_id ?>" onkeypress="onTestChange(<?php echo $user_values->user_id ?>);"></textarea>
<!--                                                                <label class="upload-file">-->
<!--                                                                    <input type="file" required="">-->
<!--                                                                    <i class="fa fa-paperclip"></i>-->
<!--                                                                </label>-->
                                                                <button type="button" class_name="<?php echo $user_values->user_id ?>" class="send-message-button btn-info"> <i class="fas fa-mail-bulk me-3 fa-2x"></i> </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
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
<audio id="myAudio">
<source src="<?= base_url().'userfiles/sound/read-sound.mp3'?>" type="audio/mpeg">
</audio>



<script>
    $(document).on('click','.messages_button',function (){
        $(".chat-body").animate({ scrollTop: 100000 }, 100);

        message_kontrol();
        setTimeout(function () {
            let att=$(this).attr('user_id');
            let data = {
                user_id:att
            }
            $.post(baseurl + 'chat/count_control',data,(response) => {
                let responses = jQuery.parseJSON(response);
                if (responses.status == 200) {
                    $('.message-count').attr('user_id', att).html(responses.count);
                } else {
                    setTimeout(function () {
                        let active_ = $('.contacts .active').attr("user_id");
                        $('.message-count').attr('user_id', att).html(responses.count);
                    }, 1000);
                }
            });
        }, 100);
    })

    function onTestChange(class_name_) {
        var key = window.event.keyCode;
        if (key === 13) {

            let messages=$('.messages_tex-'+class_name_).val();
            let cs_name='add_chat-'+class_name_;
            post_sent(class_name_,messages,cs_name);
        }
    }


    function GetTodayDate() {
        let tdate = new Date();
        let dd = tdate.getDate(); //yields day
        let MM = tdate.getMonth(); //yields month
        let yyyy = tdate.getFullYear(); //yields year
        let time = tdate.getHours() + ":" + tdate.getMinutes() + ":" + tdate.getSeconds();
        let currentDate= yyyy+ "-" +( MM+1) + "-" + dd+" "+time;


        return currentDate;
    }





    $(document).on('click','.send-message-button',function (){
        let att=$(this).attr('class_name');
        let messages=$('.messages_tex-'+att).val();
        let class_name='add_chat-'+att;
        post_sent(att,messages,class_name);

    })


    function post_sent(to_id,text,cs_name){

        $('#loading-box').removeClass('d-none');
        let d =GetTodayDate();
        let data = {
            to_id:to_id,
            text:text,
        }
        $.post(baseurl + 'chat/add_message',data,(response) => {
            $('#loading-box').addClass('d-none');
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                $('.'+cs_name+'').append(`
          <div class="message info">
                                                                            <img alt="" class="img-circle medium-image" src="<?php echo base_url('userfiles/employee/' . personel_details_full($this->aauth->get_user()->id)['picture']); ?>">
                                                                            <div class="message-body">
                                                                                <div class="message-body-inner">
                                                                                    <div class="message-info">
                                                                                        <h4>  <?php echo personel_details_full($this->aauth->get_user()->id)['name'] ?> </h4>
                                                                                        <h5> <i class="fa fa-clock-o"></i> `+d+`</h5>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="message-text">
                                                                                       `+text+`
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        `);

                $('.send-message-text').val('');
                setTimeout(function () {
                    $('.send-message-text').val('');
                }, 100);



            }
            else if(responses.status==410){

            }
        })


        setTimeout(function () {
            $(".chat-body").animate({ scrollTop: 1000000 }, 100);
        }, 100);

    }

    function message_kontrol(){
        let mk_user_id_count = $('.mk_chat_id-user_id').length
        let details = [];
        // for(let i = 0; i < mk_user_id_count; i++ ){
        //    let user_id = $('.mk_chat_id-user_id').eq(i).val();
        //     let chat_id_count = $('.mk_chat_id-'+user_id).length;
        //     for (let j = 0; j < chat_id_count; j++ ){
        //         let = mk_chat_id = $('.mk_chat_id-'+user_id).eq(j).val();
        //         details.push({
        //             'user_id': user_id,
        //             'mk_chat_id':mk_chat_id
        //         });
        //     }
        // }

        let data = {
            details:details
        }
        $.post(baseurl + 'chat/messages_kontrol',data,(response) => {
            $('#loading-box').addClass('d-none');
            let responses = jQuery.parseJSON(response);
            if(responses.status==200){
                let auth_id=responses.auth_id;
                responses.all_messages.forEach((item,key) => {
                    if(item.auth_id==auth_id){

                    }
                    else {

                        setTimeout(function () {

                        let pers_name = item.pers_name;
                        let picture = "<?php echo base_url('userfiles/employee/'); ?>"+item.picture;
                        let cs_name='add_chat-'+item.auth_id;

                        let count_contler_id =  $('.contacts .active').attr("user_id");
                        if(count_contler_id){
                            let count_contler=$('.mk_chat_id-'+count_contler_id).val();
                            let tf=true;
                            for (let y=0; y<$('.mk_chat_id-'+count_contler_id).length; y++){
                                if($('.mk_chat_id-'+count_contler_id).eq(y).val()==item.id){
                                    tf=false;
                                }
                            }
                            if(tf){

                                $('.hid_mk_chat').append(`<input type="hidden" class="hid_mk_chat mk_chat_id-`+item.auth_id+`" value="`+item.id+`">`);


                                let mk_user_id_count = $('.hid_mk_user').length

                                for(let i = 0; i < mk_user_id_count; i++ ){
                                    let user_id = $('.mk_chat_id-user_id').eq(i).val();
                                    if(user_id!=item.auth_id){
                                        $('.hid_mk_user').append(`<input type="hidden" class="hid_mk_user mk_chat_id-user_id" value="`+item.auth_id+`">`);
                                    }
                                }


                                $('#myAudio').get(0).play();
                                $('.'+cs_name+'').append(`
          <div class="message my-message">
                                                                            <img alt="" class="img-circle medium-image" src="`+baseurl+`userfiles/employee/`+item.picture+`">
                                                                            <div class="message-body">
                                                                                <div class="message-body-inner">
                                                                                    <div class="message-info">
                                                                                        <h4>`+item.name+`</h4>
                                                                                        <h5> <i class="fa fa-clock-o"></i> `+item.created_at+`</h5>
                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="message-text">
                                                                                       `+item.message+`
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        `);

                            }
                        }

                        }, 5000);

                    }

                })




                $('.send-message-text').val('');
                setTimeout(function () {
                    $('.send-message-text').val('');
                }, 100);

                $(".chat-body").animate({ scrollTop: 1000000 }, 100);

            }
            else if(responses.status==410){

            }
            let count = responses.count;
            if(count){
                let mes_ = $('.message-count').length;
                count.forEach((count_item,count_key) => {
                    for(let l=0; l < mes_; l++){
                        if($('.message-count').eq(l).attr('user_id')==count_item.auth_id){
                            $('.message-count').attr('user_id',count_item.auth_id).html(count_item.sayi);
                        }
                    }

                })
            }

        })


    }


    setInterval(function(){

        // let active_element = document.activeElement.className;
        // if(document.activeElement.attributes.user_id.value)



        message_kontrol();
        setTimeout(function () {
        let active_ = $('.contacts .active').attr("user_id");
        if(active_){
                let data = {
                    user_id:active_
                }
                $.post(baseurl + 'chat/count_control',data,(response) => {
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        $('.message-count').attr('user_id',active_).html(responses.count);
                    }
                    else {
                        $('.message-count').attr('user_id',active_).html(responses.count);
                    }
                })
            }
        }, 1000);

    }, 10000);



</script>

<link href="<?= base_url().'assets/css/chat.css?v='.rand(11111,99999) ?>" rel="stylesheet" type="text/css">
<script src="<?= base_url().'assets/js/chat.min.js?v='.rand(11111,99999)?>"></script>
<script src="<?= base_url().'assets/js/chatb.min.js?v='.rand(11111,99999)?>"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="<?php echo base_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>
<script>

    $(document).on('click','.new_message',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni Mesaj',
            icon: 'icon-bubble9 me-3 icon-2x',
            type: 'orange',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:`<form action="" class="formName">
                <div class="form-group">
                    <select class="form-control select-box by_user zorunlu">
                            <?php
            foreach (all_personel() as $item) {
                echo "<option value='$item->id'>$item->name</option>";
            }
            ?>
                    </select>
                </div>
                <div class="form-group">
                <textarea class='form-control text-mesaj' placeholder="Mesajınız"></textarea>
                </div>
                </form>`,
            buttons: {
                formSubmit: {
                    text: 'Mesaj Gönder',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            to_id: $('.by_user').val(),
                            text: $('.text-mesaj').val(),
                        }
                        $.post(baseurl + 'chat/add_message',data,(response) => {
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
                                    content: 'Başarılı Bir Şekilde Mesajınız İletildi Bekleyiniz...',
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.reload();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status==419){

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

            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
$(function() {
$('.select-box').select2();
})
</script>