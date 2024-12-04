<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Gidere İşlenmesi Bekleyen Malzeme Talepleri</span></h4>
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
                                            <th>Mt Code</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($items) {
                                            foreach ($items as $values){
                                                $i=1;
                                                $id = $values->id;
                                                $code = $values->code;

                                                echo "<tr>
                                                            <td>$i</td>
                                                            <td>$code</td>
                                                            <td><a href='/malzemetalep/view/$id' target='_blank' class='btn btn-info'><i class='fa fa-eye'></i></a> </td>
                                                         
                                                        </tr>";
                                                $i++;
                                            }
                                        }?>
                                        </tbody>
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
    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })

    $(document).on('click','.create_save',function (){
        let file_id =$(this).attr('file_id');
        let checked_count = $('.one_select:checked').length;
        if(checked_count==0){
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-4 mx-auto",
                title: 'Dikkat!',
                content: 'Herhangi Bir İtem Seçilmemiş!',
                buttons:{
                    prev: {
                        text: 'Tamam',
                        btnClass: "btn btn-link text-dark",
                    }
                }
            });
            return false;
        }
        else {

            $.confirm({
                theme: 'modern',
                closeIcon: false,
                title: 'Gider İşle',
                icon: 'fa fa-plus',
                type: 'green',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-12 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:`<form action="" class="formName" id='data_form'>
                                       <div class="form-group col-md-12">
                                          <label for="name">Demirbaş Grubu</label>
                                           <select class="form-control select-box" id="demirbas_id" name="demirbas_id">
                                            <?php
                if(demirbas_group_list(1)){
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

                                        <div class="form-group col-md-12 one_group">
                                          <label for="name">Gider Kalemi Grubu</label>
                                           <select class="form-control select-box group_id" types='ones' id="group_id" name="group_id">
                                            <option value='0'>Demirbaş Grubu Seçiniz</option>
                                        </select>
                                        </div>
                                        </form>`,
                buttons: {
                    formSubmit: {
                        text: 'Gidere İşle',
                        btnClass: 'btn-blue',
                        action: function () {
                            let form = $('#data_form').serialize();
                            let demirbas_id = $('#demirbas_id').val()


                            let product_details=[];
                            $('.one_select:checked').each((index,item) => {
                                let eq = $(item).attr('eq');
                                product_details.push({

                                    talep_form_product_id:$(item).attr('talep_form_product_id'),
                                    new_unit_id:$(item).attr('new_unit_id'),
                                    new_item_price:$(item).attr('new_item_price'),
                                    new_item_qty:$(item).attr('new_item_qty'),
                                    item_umumi_cemi_hidden:$(item).attr('item_umumi_cemi_hidden'),
                                    product_id:$(item).attr('product_id'),
                                    form_id:$(item).attr('form_id'),

                                })
                            });

                            if(!demirbas_id){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'Demirbaş grubu zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }

                            $('#loading-box').removeClass('d-none');


                            let len  = $("select[name=group_id]").length;
                            let grp_id = 0;
                            for(let i =0; i < len; i++){
                                grp_id = $("select[name=group_id]").eq(i).val()
                            }

                            let data = {
                                group_id: grp_id,
                                demirbas_id: demirbas_id,
                                file_id: file_id,
                                product_details: product_details,
                                type: 3,
                            }
                            $.post(baseurl + 'demirbas/gider_create_form',data,(response)=>{
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
                                                    location.reload()
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
                    cancel: {
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })

                    $(".input_tag").tagsinput('items')

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
    })

    $(document).on('change','#demirbas_id',function (){
        $("#group_id option").remove();
        let id = $(this).val();
        let data = {
            group_id: id
        }
        $.post(baseurl + 'demirbas/get_parent_list',data,(response)=>{
            let responses = jQuery.parseJSON(response);



            if(responses.status==200){
                $('#group_id').append(new Option('Seçiniz', '', false, false));
                responses.items.forEach((item_,index) => {
                    $('#group_id').append(new Option(item_.name, item_.id, false, false));
                })
            }
            else {

                $('#group_id').append(new Option('Alt Grup Yoktur', 0, false, false));
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
                                           <select class="form-control select-box group_id" name="group_id">
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
                                           <select class="form-control select-box group_id" name="group_id">
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