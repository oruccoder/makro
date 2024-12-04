Pusher.logToConsole = true;

let pusher = new Pusher('163c06034a4a4bd4f419', {
    cluster: 'ap2'
});

let channel = pusher.subscribe('pusher');
channel.bind('notification', function(listen) {

    if(listen.event.type == 'engineer'){
        $('#engineer-notification-box').removeClass('d-none');
        $('#engineer-notification-count').empty().text(listen.event.count);
    }

});
