<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yetkiler</span></h4>
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
                                    <div class="col-12 mb-4">
                                        <table id="invoices" class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <th>Istifadeci Rolu</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
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





<!-- dfefe-->

<style>
    .group-buttons {
        outline: none !important;
        border-radius: 0px !important;
        border: 1px solid gray;
    }
</style>

<script>

    $(document).ready(function () {
        draw_data()
    });
    let v_name='';
    let sort_array=[];
    let user_array=[];
    let v_id='';
    function draw_data() {
        $('#invoices').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('permissions/ajax_list')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'status_id':1}
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: []
        });
    }


    function search(nameKey, myArray){
        if ($.inArray(nameKey, myArray) === -1) {
            return false;
        }
        else {
            return true;
        }
    }

    $(document).on('click','#add-approval',function(){
        let i =  $("#result tbody tr").length;
        let name = $(".user_select").find(":selected").data("name");
        let user_select = $(".user_select").val();
        let sonuc_user = false;
        let message='';

        if(user_array){
            sonuc_user = search(user_select,user_array);
        }

        if(sonuc_user)
        {
            message='Modül Daha Önce Kullanıldı';
        }

        if(!sonuc_user)
        {
            user_array.push(user_select);
            if(i==0){
                i=i+1;
            }
            else {
                i++;
            }

            let read_text='<i class="fa fa-ban"></i>';
            let write_text='<i class="fa fa-ban"></i>';
            let update_text='<i class="fa fa-ban"></i>';
            let delete_text='<i class="fa fa-ban"></i>';

            let read = $('.read').prop('checked')?1:0;;
            let write = $('.write').prop('checked')?1:0;;
            let update = $('.update').prop('checked')?1:0;;
            let delete_ = $('.delete').prop('checked')?1:0;;
            if(read){
                read_text='<i class="fa fa-check"></i>';
            }
            if(write){
                write_text='<i class="fa fa-check"></i>';
            }
            if(update){
                update_text='<i class="fa fa-check"></i>';
            }
            if(delete_){
                delete_text='<i class="fa fa-check"></i>';
            }


            $("#result>tbody").append('<tr id="remove'+i+'" delete="'+delete_+'"  update="'+update+'"  read="'+read+'" write="'+write+'"  user_id="'+user_select+'" class="result-row">' +
                '<td>' +i+ '</td> ' +
                '<td>' + name + '</td>' +
                '<td>' + read_text+ '</td>' +
                '<td>' + write_text + '</td>' +
                '<td>' + update_text + '</td>' +
                '<td>' + delete_text + '</td>' +
                '<td> <button data-id="'+i+'" class="btn btn-danger remove"  user_id="'+user_select+'"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                '</tr>');
        }
        else {
            $.alert({
                theme: 'material',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content:  message,
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
        }


    });

    //edit
    $(document).on('click','.edit',function (){
        let id = $(this).data('id');
        let role_id = $(this).attr('role_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Yetkilendirme',
            icon: 'fa fa-external-link-square-alt 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-10 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function (){
                let self = this;
                let html = `<form>
                            <div class="row">
                                 <div class="col-md-3">
                                 <input type='hidden' id="user_role_select" >
                                     <lable> Module Seçin</lable>
                                    <select id="user_role_select" class="form-control select-box user_select">
                                    <option value='0'>Modül Seçiniz</option>
                                       <?php
                                        foreach (modul_list() as $item) {
                                            echo "<option data-name='$item->module' value='$item->id'>$item->module</option>";
                                        }
                                        ?>
                                    </select>
                                 </div>
                                <div class="col-md-2">
                                     <lable> Görüntüleme </lable>
                                     <input type="checkbox" class="form-control read">
                                 </div>
                                    <div class="col-md-2">
                                     <lable> Ekleme </lable>
                                     <input type="checkbox" class="form-control write">
                                 </div>
                                    <div class="col-md-2">
                                     <lable> Güncelleme </lable>
                                     <input type="checkbox" class="form-control update">
                                 </div>
                                    <div class="col-md-2">
                                     <lable> Silme </lable>
                                     <input type="checkbox" class="form-control delete">
                                 </div>
                                 <div class="col-md-1">
                                    <button type="button" id="add-approval" class="btn btn-primary mt-2 "> Ekle </buttton>
                                  </div>
                            </div>
                             </form>
                             <p class="test"></p>
                                  <table id="result" class="table ">
                              <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Modül</th>
                                  <th scope="col"> Görüntüleme</th>
                                  <th scope="col"> Ekleme </th>
                                  <th scope="col"> Güncelleme </th>
                                  <th scope="col"> Silme </th>
                                  <th scope="col"> İşlem </th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                           `;

                let data = {
                    crsf_token: crsf_hash,
                    role_id: role_id,
                }
                $.post(baseurl + 'permissions/info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    let no=1;
                    $.each(responses.items, function (i, item) {
                        let read_text='<i class="fa fa-ban"></i>';
                        let write_text='<i class="fa fa-ban"></i>';
                        let update_text='<i class="fa fa-ban"></i>';
                        let delete_text='<i class="fa fa-ban"></i>';

                        if(parseInt(item.read)){
                            read_text='<i class="fa fa-check"></i>';
                        }
                        if(parseInt(item.write)){
                            write_text='<i class="fa fa-check"></i>';
                        }
                        if(parseInt(item.update)){
                            update_text='<i class="fa fa-check"></i>';
                        }
                        if(parseInt(item.delete)){
                            delete_text='<i class="fa fa-check"></i>';
                        }
                        user_array.push(item.module_id);
                        $("#result>tbody").append('<tr id="remove'+i+'" delete="'+item.delete+'"  update="'+item.update+'"  read="'+item.read+'" write="'+item.write+'" user_id="'+item.module_id+'" class="result-row">' +
                            '<td>' +no+ '</td> ' +
                            '<td>' + item.module_name + '</td>' +
                            '<td>' + read_text+ '</td>' +
                            '<td>' + write_text + '</td>' +
                            '<td>' + update_text + '</td>' +
                            '<td>' + delete_text + '</td>' +
                            '<td> <button data-id="'+i+'" class="btn btn-danger remove"  user_id="'+item.module_id+'"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
                            '</tr>');
                        no++;
                    });


                });
                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Göndər',
                    btnClass: 'btn-blue',
                    action: function () {
                        let count = $("#result tbody tr").length;
                        let collection = [];
                        let data=[];

                        if(parseInt(count)==0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Herhangi Bir User Eklenmemiş',
                                buttons:{
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false
                        }

                        for(let i=0; i < count; i++ ){
                            data = {
                                read: $('#result tbody tr').eq(i).attr('read'),
                                write: $('#result tbody tr').eq(i).attr('write'),
                                delete: $('#result tbody tr').eq(i).attr('delete'),
                                update: $('#result tbody tr').eq(i).attr('update'),
                                module_id: $('#result tbody tr').eq(i).attr('user_id'),

                            }

                            collection.push(data)
                        }


                        let data_post = {
                            collection: collection,
                            role_id: role_id,
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'permissions/update',data_post,(response)=>{
                            $('#loading-box').removeClass('d-none');
                            let data = jQuery.parseJSON(response);
                            if(data.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function () {
                                                sort_array=[];
                                                user_array=[];
                                                $('#invoices').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
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
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action:function (){
                        sort_array=[];
                        user_array=[];
                    }
                }
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
    //edit

    //delete
    $(document).on('click','.cancel-stockio' ,function(){
        let roleapp_id = $(this).data('id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-trash',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>Silmek Üzeresiniz Emin Misiniz?<p/>'+
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            roleapp_id:roleapp_id,
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'roleapproval/delete',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action:function (){
                                                $('#invoices').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });
                            }
                            else {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content:  responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                            }

                        });

                    }
                },
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
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
    //delete

    //row_remove
    $(document).on('click','.remove' ,function(){
        let remove = '#remove'+ $(this).data('id')
        let removeItem = $(this).attr('sort')
        let removeItem2 = $(this).attr('user_id')

        sort_array =  jQuery.grep(sort_array, function(value) {
            return value != removeItem;
        });
        user_array =  jQuery.grep(user_array, function(value) {
            return value != removeItem2;
        });


        $(remove).remove();
    })
    //row_remove
</script>