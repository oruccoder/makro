<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Rol Tesdiq Sehifesi</span></h4>
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
                                        <table id="invoices" class="table datatable-responsive" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>Kod</td>
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
                'url': "<?php echo site_url('roleapproval/ajax_role_approval_list')?>",
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
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Add New',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: ' Vəzifə qeyd edin !',
                            icon: 'fa fa-add',
                            type: 'red',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "medium",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`
                                <div class="row">
                             <div class="col-md-12">
                                 <lable> Vezife Secin !</lable>
                                <select id="user_role_select" class="form-control select-box user_role_select">
                                <option value='0'> Vezife Secin !</option>
                                   <?php
                            foreach (all_roles() as $item) {
                                echo "<option data-name='$item->name' value='$item->role_id'>$item->name</option>";
                            }
                            ?>
                                </select>
                             </div>
                             </div>
                             `,
                            buttons: {
                                formSubmit: {
                                    text: 'Devam',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let user_role_select=$('.user_role_select').val();
                                        v_name = $(".user_role_select").find(":selected").data("name");
                                        v_id = user_role_select;
                                        if(!parseInt(user_role_select)){
                                            $.alert({
                                                theme: 'material',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Dikkat!',
                                                content:  'VEZIFE ZORUNLUDUR',
                                                buttons:{
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });

                                            return false;
                                        }

                                        $.confirm({
                                            theme: 'modern',
                                            closeIcon: false,
                                            title: ' Istifadeci ve Sira nomresi qeyd edin !',
                                            icon: 'fa fa-external-link-square-alt 3x',
                                            type: 'dark',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-10 mx-auto",
                                            containerFluid: !0,
                                            smoothContent: true,
                                            draggable: false,
                                            content: `<form >
                                                            <div class="row">
                                                                 <div class="col-md-6">
                                                                 <input type='hidden' value='`+user_role_select+`' id="user_role_select" >
                                                                     <lable> Istifadeci Secin !</lable>
                                                                    <select id="user_role_select" class="form-control select-box user_select">
                                                                    <option value='0'> Istifadeci Secin !</option>
                                                                       <?php
                                                                                foreach (all_personel() as $item) {
                                                                                    echo "<option data-name='$item->name' value='$item->id'>$item->name</option>";
                                                                                }
                                                                                ?>
                                                                    </select>
                                                                 </div>
                                                              <div class="col-md-5">
                                                                     <lable> Istifadeci Secin !</lable>
                                                                     <input type="number" class="form-control select-box user_row_number">
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
                                                              <th scope="col">Vezife</th>
                                                              <th scope="col"> Istifadeci</th>
                                                              <th scope="col"> Sira Nomresi </th>
                                                              <th scope="col"> Sil </th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>

                                                          </tbody>
                                                        </table>
                                                       `,
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
                                                                v_id: $('#result tbody tr').eq(i).attr('v_id'),
                                                                user_id: $('#result tbody tr').eq(i).attr('user_id'),
                                                                sort: $('#result tbody tr').eq(i).attr('sort'),

                                                            }

                                                            collection.push(data)
                                                        }


                                                        let data_post = {
                                                            collection: collection,
                                                            crsf_token: crsf_hash,
                                                        }

                                                        $.post(baseurl + 'roleapproval/create',data_post,(response)=>{
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
                                                // bind to events
                                                var jc = this;
                                                this.$content.find('form').on('submit', function (e) {
                                                    // if the user submits the form by pressing enter in the field.
                                                    e.preventDefault();
                                                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                                                });
                                            }
                                        });

                                        setTimeout(function(){
                                            $('.select-box').select2({
                                                dropdownParent: $(".jconfirm")
                                            })
                                            $('#loading-box').addClass('d-none');
                                        }, 1000);
                                    }
                                },
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm")
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

                    }
                }
            ]
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
        let user_role_select = $(".user_role_select").val();
        let user_select = $(".user_select").val();
        let user_row_number = $(".user_row_number").val();
        let sonuc_sort = false;
        let sonuc_user = false;
        let message='';
        if(sort_array){
            sonuc_sort = search(user_row_number,sort_array);
        }
        if(user_array){
            sonuc_user = search(user_select,user_array);
        }

        if(sonuc_sort)
        {
            message='Sıralama Daha Önce Kullanıldı';
        }
        if(sonuc_user)
        {
            message='Kullanıcı Daha Önce Kullanıldı';
        }

        if(!(sonuc_sort || sonuc_user))
        {
            sort_array.push(user_row_number);
            user_array.push(user_select);

            if(i==0){
                i=i+1;
            }
            else {
                i++;
            }
            $("#result>tbody").append('<tr id="remove'+i+'"  v_id="'+v_id+'" user_id="'+user_select+'" sort="'+user_row_number+'" class="result-row">' +
                '<td>' +i+ '</td> ' +
                '<td>' + v_name + '</td>' +
                '<td>' + name + '</td> ' +
                '<td>' + user_row_number + '</td> ' +
                '<td> <button data-id="'+i+'" class="btn btn-danger remove"  user_id="'+user_select+'" sort="'+user_row_number+'"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
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
    $(document).on('click','.edit-stockio',function (){
        let roleapp_id = $(this).data('id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: ' Istifadeci ve Sira nomresi qeyd edin !',
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
                                 <div class="col-md-6">
                                 <input type='hidden' id="user_role_select" >
                                     <lable> Istifadeci Secin !</lable>
                                    <select id="user_role_select" class="form-control select-box user_select">
                                    <option value='0'> Istifadeci Secin !</option>
                                       <?php
                                        foreach (all_personel() as $item) {
                                            echo "<option data-name='$item->name' value='$item->id'>$item->name</option>";
                                        }
                                        ?>
                                    </select>
                                 </div>
                              <div class="col-md-5">
                                     <lable> Istifadeci Secin !</lable>
                                     <input type="number" class="form-control select-box user_row_number">
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
                                  <th scope="col">Vezife</th>
                                  <th scope="col"> Istifadeci</th>
                                  <th scope="col"> Sira Nomresi </th>
                                  <th scope="col"> Sil </th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                            </table>
                           `;

                            let data = {
                                crsf_token: crsf_hash,
                                roleapp_id: roleapp_id,
                            }
                            $.post(baseurl + 'roleapproval/info',data,(response) => {
                                self.$content.find('#person-list').empty().append(html);
                                let responses = jQuery.parseJSON(response);
                                $('#user_role_select').val(responses.item.approval_id);
                                let no=1;
                                 v_name = responses.role_details.name;
                                 v_id = roleapp_id;
                                $.each(responses.item_details, function (i, item) {
                                    sort_array.push(item.short);
                                    user_array.push(item.staff_id);

                                    $("#result>tbody").append('<tr id="remove'+i+'"  v_id="'+roleapp_id+'" user_id="'+item.staff_id+'" sort="'+item.short+'" class="result-row">' +
                                        '<td>' +no+ '</td> ' +
                                        '<td>' + v_name + '</td>' +
                                        '<td>' + item.name + '</td> ' +
                                        '<td>' + item.short + '</td> ' +
                                        '<td> <button data-id="'+i+'" class="btn btn-danger remove"  user_id="'+item.staff_id+'" sort="'+item.short+'"><i class="fa fa-trash" aria-hidden="true"></i></button> </td>' +
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
                                v_id: $('#result tbody tr').eq(i).attr('v_id'),
                                user_id: $('#result tbody tr').eq(i).attr('user_id'),
                                sort: $('#result tbody tr').eq(i).attr('sort'),

                            }

                            collection.push(data)
                        }


                        let data_post = {
                            collection: collection,
                            roleapp_id: roleapp_id,
                            crsf_token: crsf_hash,
                        }

                        $.post(baseurl + 'roleapproval/update',data_post,(response)=>{
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