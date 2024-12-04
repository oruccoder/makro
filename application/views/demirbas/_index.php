<div class="page-header-content header-elements-lg-inline">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Gider Yönetimi Kontrol Paneli</span></h4>
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table" id="demisbas_list" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Gider Kodu</th>
                                            <th>Adı</th>
                                            <th>Form Tipi</th>
                                            <th>İşlemler</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        draw_data();
    });
    function draw_data() {
        $('#demisbas_list').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('demirbas/ajax_list')?>",
                'type': 'POST',
                'data': {'tip':'bakiye'}
            },
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Grup',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Grup',
                            icon: 'fa fa-plus',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form action="" class="formName" id='data_form'>
                                       <div class="form-group col-md-12 one_group">
                                          <label for="name">Gruplar</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id[]">
                                            <?php
                            if(demirbas_group_list()){
                            echo "<option value='0'>Seçiniz</option>";
                            foreach (demirbas_group_list() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                            }
                            else {
                            ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                            }

                            ?>
                                        </select>
                                        </div>
                                         <div class="form-group col-md-12">
                                          <label for="name">Yeni Group</label>
                                          <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                          <div class="form-group col-md-12">
                                          <label for="name">Açıklama</label>
                                         <input class='form-control' id='desc' name="desc">
                                        </div>
                                        </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        $.post(baseurl + 'demirbas/create_save',$('#data_form').serialize(),(response)=>{
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
                                                            action: function () {
                                                                $('#demisbas_list').DataTable().destroy();
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
                                                    content: responses.message,
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
                    }
                },
                {
                    text: '<i class="fa fa-plus"></i> Yeni Gider Kalemi',
                    action: function(e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Gider Kalemi',
                            icon: 'fa fa-plus',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form action="" class="formName" id='data_form'>
                                       <div class="form-group col-md-12 one_group">
                                          <label for="name">Gruplar</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id[]">
                                            <?php
                            if(demirbas_group_list()){
                            echo "<option value='0'>Seçiniz</option>";
                            foreach (demirbas_group_list() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
                            }
                            else {
                            ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
                            }

                            ?>
                                        </select>
                                        </div>
                                         <div class="form-group col-md-12">
                                          <label for="name">Gider Kalemi</label>
                                          <input type="text" class="form-control" id="name" name="name">
                                        </div>
                                          <div class="form-group col-md-12">
                                          <label for="name">Açıklama</label>
                                         <input class='form-control' id='desc' name="desc">
                                        </div>
                                        </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        $('#loading-box').removeClass('d-none');

                                        $.post(baseurl + 'demirbas/create_save',$('#data_form').serialize(),(response)=>{
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
                                                            action: function () {
                                                                // $('#demisbas_list').DataTable().destroy();
                                                                // draw_data();
                                                                location.reload();
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
                                                    content: responses.message,
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
                    }
                },
                {
                    extend: 'excelHtml5',
                    footer: true,

                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });
    }

    $(document).on('change','.group_id',function (){
        let id = $(this).val();

        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_parent_kontrol',data,(response)=>{
            let responses = jQuery.parseJSON(response);
            let eq=$(this).parent().index();

            if(responses.status==200){

                let class_name = $(this).attr('class');
                if(class_name=='form-control select-box group_id'){


                    if($(this).val()==0){
                        $('.add_group').eq(parseInt(eq)-1).remove();
                    }

                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;
                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }



                }
                else {
                    $('.add_group').remove();
                }


                let add_grp = $('.add_group').length;
                if(parseInt(add_grp)){
                    let say = parseInt(add_grp)-1;
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id[]">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.add_group').eq(say).after(html);

                }
                else {
                    let html=`<div class="form-group col-md-12 add_group">
                                          <label for="name">Alt Gruplar</label>
                                           <select class="form-control select-box group_id" name="group_id[]">
                                           <option value='0'>Seçiniz</option>`;


                    $.each(responses.items, function (index, items) {
                        let name =items.name;
                        let id =items.id;
                        html+=`<option value="`+id+`">`+name+`</option>`;
                    });
                    html+=`</select></div>`;


                    $('.one_group').after(html);
                }
            }
            else {

                if($(this).val()==0){
                    $('.add_group').eq(parseInt(eq)-1).remove();
                }

                if($(this).attr('types')=='ones'){

                    $('.add_group').remove();
                }
                else {
                    let sonraki = parseInt(eq)+1;
                    let count = $('.add_group').length;

                    for(let i=eq;i <= count;i++){
                        $('.add_group').eq(i).remove();
                    }
                }



                $.alert({
                    theme: 'material',
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


        });
    })
</script>