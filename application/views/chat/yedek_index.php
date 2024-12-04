<div class="container" style="margin-top: 150px;" >
    <div class="row">

        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading"><span class="glyphicon glyphicon-user"></span> Users Online</div>
                <div class="panel-body">
                    <ul class="list-group" id="listaOnline">

                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="chat_window">
                <div class="top_menu">
                    <div class="buttons">
                        <div class="button close"></div>
                        <div class="button minimize"></div>
                        <div class="button maximize"></div>
                    </div>
                    <div class="title">Chat</div>
                </div>
                <ul class="messages"></ul>
                <div class="bottom_wrapper clearfix">
                    <div class="message_input_wrapper">
                        <input class="message_input" placeholder="Type your message here..." />
                    </div>
                    <div class="send_message">
                        <div class="icon"></div>
                        <div class="text">Send</div>
                    </div>
                </div>
            </div>
            <div class="message_template">
                <li class="message">
                    <div class="avatar"></div>
                    <div class="text_wrapper">
                        <div class="text"></div>
                    </div>
                </li>
            </div>

        </div>

    </div>
</div>
<style>
    * {
        box-sizing: border-box;
    }

    body {
        background-color: #edeff2;
        font-family: "Calibri", "Roboto", sans-serif;
    }

    .chat_window {
        margin-top: 250px;
        position: absolute;
        width: calc(100% - 20px);
        max-width: 800px;
        height: 500px;
        border-radius: 10px;
        background-color: #fff;
        left: 50%;
        top: 50%;
        transform: translateX(-50%) translateY(-50%);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        background-color: #f8f8f8;
        overflow: hidden;
    }

    .top_menu {
        background-color: #fff;
        width: 100%;
        padding: 20px 0 15px;
        box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
    }
    .top_menu .buttons {
        margin: 3px 0 0 20px;
        position: absolute;
    }
    .top_menu .buttons .button {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 10px;
        position: relative;
    }
    .top_menu .buttons .button.close {
        background-color: #f5886e;
    }
    .top_menu .buttons .button.minimize {
        background-color: #fdbf68;
    }
    .top_menu .buttons .button.maximize {
        background-color: #a3d063;
    }
    .top_menu .title {
        text-align: center;
        color: #bcbdc0;
        font-size: 20px;
    }

    .messages {
        position: relative;
        list-style: none;
        padding: 20px 10px 0 10px;
        margin: 0;
        height: 347px;
        overflow: scroll;
    }
    .messages .message {
        clear: both;
        overflow: hidden;
        margin-bottom: 20px;
        transition: all 0.5s linear;
        opacity: 0;
    }
    .messages .message.left .avatar {
        background-color: #f5886e;
        float: left;
        background-size: cover;
    }
    .messages .message.left .text_wrapper {
        background-color: #ffe6cb;
        margin-left: 20px;
    }
    .messages .message.left .text_wrapper::after, .messages .message.left .text_wrapper::before {
        right: 100%;
        border-right-color: #ffe6cb;
    }
    .messages .message.left .text {
        color: #c48843;
    }
    .messages .message.right .avatar {
        background-color: #fdbf68;
        float: right;
        background-size: cover;
    }
    .messages .message.right .text_wrapper {
        background-color: #c7eafc;
        margin-right: 20px;
        float: right;
    }
    .messages .message.right .text_wrapper::after, .messages .message.right .text_wrapper::before {
        left: 100%;
        border-left-color: #c7eafc;
    }
    .messages .message.right .text {
        color: #45829b;
    }
    .messages .message.appeared {
        opacity: 1;
    }
    .messages .message .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: inline-block;
    }
    .messages .message .text_wrapper {
        display: inline-block;
        padding: 20px;
        border-radius: 6px;
        width: calc(100% - 85px);
        min-width: 100px;
        position: relative;
    }
    .messages .message .text_wrapper::after, .messages .message .text_wrapper:before {
        top: 18px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
    }
    .messages .message .text_wrapper::after {
        border-width: 13px;
        margin-top: 0px;
    }
    .messages .message .text_wrapper::before {
        border-width: 15px;
        margin-top: -2px;
    }
    .messages .message .text_wrapper .text {
        font-size: 18px;
        font-weight: 300;
    }

    .bottom_wrapper {
        position: relative;
        width: 100%;
        background-color: #fff;
        padding: 20px 20px;
        position: absolute;
        bottom: 0;
    }
    .bottom_wrapper .message_input_wrapper {
        display: inline-block;
        height: 50px;
        border-radius: 25px;
        border: 1px solid #bcbdc0;
        width: calc(100% - 160px);
        position: relative;
        padding: 0 20px;
    }
    .bottom_wrapper .message_input_wrapper .message_input {
        border: none;
        height: 100%;
        box-sizing: border-box;
        width: calc(100% - 40px);
        position: absolute;
        outline-width: 0;
        color: gray;
    }
    .bottom_wrapper .send_message {
        width: 140px;
        height: 50px;
        display: inline-block;
        border-radius: 50px;
        background-color: #a3d063;
        border: 2px solid #a3d063;
        color: #fff;
        cursor: pointer;
        transition: all 0.2s linear;
        text-align: center;
        float: right;
    }
    .bottom_wrapper .send_message:hover {
        color: #a3d063;
        background-color: #fff;
    }
    .bottom_wrapper .send_message .text {
        font-size: 18px;
        font-weight: 300;
        display: inline-block;
        line-height: 48px;
    }

    .message_template {
        display: none;
    }


    /*custom*/

    main a{text-decoration: none}
    main{
        width: 30%;
        min-width: 480px;
        margin: 15% auto;
    }
    #form-container{
        border-radius: .25rem;
        padding: 1rem 0;
        background-color: #fff;
    }
    #form-container h1{
        text-align: center;
        font-size: 1.5rem;
        color:#f26957;
        padding: .8rem 0;

    }
    #form-container form{
        width: 85%;
        margin: 1rem auto;
    }
    .social-btn, input[type="email"], input[type="password"],input[type='submit']{
        display: block;
        outline: none;
        box-shadow: none;
        margin-bottom: 1.5rem;
        width:100%;
        color: #fff;
        line-height: 3.5rem;
        border-radius: .25rem;
        box-sizing: border-box;
        padding-right: 1rem;
    }
    p{position: relative ;}
    .social-btn i{
        display: inline-block;
        width: 5rem;
        padding-right: 1.5rem;
        font-size: 1.6rem;
        vertical-align: middle;
        text-align: center;
    }
    .fb-btn{background-color: #3b5998; transition: .1s background ease-in-out;}
    .gp-btn{background-color: #d34836;  transition: .1s background ease-in-out;}
    .fb-btn:hover{background-color: #3f60a5}
    .gp-btn:hover, input[type="submit"]:hover{background-color: #db4835;}

    .divider{
        content: '';
        display: block;
        height: 100%;
        box-sizing: border-box;
        position: absolute;
        top:0;
        left: 4.5rem;
    }
    .divider-fb{    box-shadow: 1px 0 0 .03em #496bae,3px 0 0 .03em #2f529b;}
    .divider-gp{    box-shadow: .15em 0 0 .03em #d36f62, .25em 0 0 .03em #cb321f;}


    .or-divider{position: relative; text-align: center; margin: 2.5rem 0;color: #dcc1c1;}
    .or-divider::after, .or-divider::before{
        content: "";
        box-sizing: border-box;
        display: block;
        width: 44%;
        height: .5rem;
        border-top: 1px solid #ffd0d0;
        border-bottom: 1px solid #ffd0d0;
        float: left;
        margin-top: 5px;
        text-align: center;
    }
    .or-divider::before{
        float: right;
    }

    ::-webkit-input-placeholder {  color: #3b5998; }
    :-moz-placeholder {   color: #3b5998;  }
    ::-moz-placeholder {   color: #3b5998;  }
    :-ms-input-placeholder {  color: #3b5998;  }

    input[type="email"], input[type="password"]{
        border:1px solid #dcc1c1;
        text-indent: 1rem;
        color: #666;
        transition: .1s font ease-in-out;
    }
    input[type="email"]:hover, input[type="password"]:hover{
        border:1px solid #d65646;
    }
    input[type="email"]:focus, input[type="password"]:focus,input[type="email"]:active, input[type="password"]:active{
        font-size: 1.1rem;
        border:1px solid #00c1a8;
        color: #3b5998;
    }


    /*Resetting chrome autofill */
    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 200px white inset;
        -webkit-text-fill-color: #666;
    }

    input[type='submit']{
        border:none;
        background-color: #d34836;
        cursor: pointer;
        font-size: 1.2rem;
    }
    #recover-new-account{
        width: 100%;
        margin: 0 auto;
        display: flex;
        flex-flow: row;
        justify-content: space-around;
    }
    #recover-new-account a{color: #00c1a8;text-align: center;}
    #recover-new-account a:hover{color: #03d0b6; }
    #recover-new-account{color: #dcc1c1}

    @media  only screen and (max-width:768px){
        html{font-size: 13px;}
        #form-container h1{font-size: 1.3rem}
        main{
            width: 70%;
            min-width: 300px;
        }
    }

    /* Finished Form Styling */

    aside a {
        text-align:center;
        text-decoration:none;
        color: #f92973;
        animation: animate 1s infinite;
    }
    aside a:hover{
        color: #00c1a8;
        text-decoration:underline;
    }
    @keyframes animate{
        0%{
            text-decoration:none;
        }
        20%{
            text-decoration:underline;
            -moz-text-decoration-color:#00c1a8;
            text-decoration-color:#00c1a8;
        }
        40%{
            text-decoration:none;
        }
        60%{
            text-decoration:underline;
            -moz-text-decoration-color:#00c1a8;
            text-decoration-color:#00c1a8;
        }
        80%{
            color: #00c1a8;
        }
    }
</style>

<script type="text/javascript">

    var url 		= 'http://makroerp/';
    var users_id 	= '21';
    var email 		= 'bsr.snr@gmail.com';
    var surl        = 'http://makroerp:889';
    var room        = 'application';

    var socket  = io.connect(surl);
    socket.emit('join:room', {'room_name' : room, 'email' : email});

    socket.on('message', function(data){

        var $message;
        var message_side = 'left';

        $message = $($('.message_template').clone().html());
        $message.addClass(message_side).find('.text').html(data.content);
        $message.addClass('appeared');
        $message.find('.avatar').css('background-image', 'url(' + data.avatar + ')');
        $('.messages').append($message);
        $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);

    });

    socket.on('get users',function(data){
        var html = "";
        for(i=0; i<data.length; i++ ){
            html += '<li class="list-group-item"><span class="label label-success">●</span> - '+data[i]+'</li>';
        }
        $('#listaOnline').html(html);

        console.log(data);
    });

    $(window).on('load', function(){
        get_chats(room);
    });

    function get_chats(group)
    {
        $.ajax({
            url 	: url+'chat/get_chats',
            data    : 'group='+group,
            type 	: 'POST',
            dataType: 'JSON',
            beforeSend: function()
            {

            },
            success: function(message)
            {
                $.each( message.data, function( key, value ) {
                    var $message;
                    var message_side = users_id == value.users_id ? 'right' : 'left';

                    $message = $($('.message_template').clone().html());
                    $message.addClass(message_side).find('.text').html(value.content);
                    $message.addClass('appeared');
                    $message.find('.avatar').css('background-image', 'url(' + value.avatar + ')');
                    $('.messages').append($message);
                });

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
        return false;
    }

    function send_message(text, group)
    {
        $.ajax({
            url 	: url+'chat/send',
            data    : 'group='+group+'&content='+text,
            type 	: 'POST',
            dataType: 'JSON',
            beforeSend: function()
            {

            },
            success: function(message)
            {
                if(message.status)
                {

                    socket.emit('send:message', message);

                    $('.message_input').val('');
                    var $message;
                    var message_side = 'right';

                    $message = $($('.message_template').clone().html());
                    $message.addClass(message_side).find('.text').html(message.content);
                    $message.addClass('appeared');
                    $message.find('.avatar').css('background-image', 'url(' + message.avatar + ')');
                    $('.messages').append($message);
                    $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, 300);
                }


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
        return false;
    }

    $(document).on('click', '.send_message', function(e){
        e.preventDefault();
        send_message($('.message_input').val(), room)
    });

    $('.message_input').keyup(function (e) {
        if (e.which === 13) {
            send_message($('.message_input').val(), room)
        }
    });




</script>