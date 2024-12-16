<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Projeler</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">

                <table id="project_table" class="table datatable-responsive" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Proje Kodu</th>
                        <th>Proje Adı</th>
                        <th><?php echo $this->lang->line('Due Date') ?></th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th><?php echo $this->lang->line('Status') ?></th>

                        <th><?php echo $this->lang->line('Actions') ?></th>

                    </tr>
                    </thead>
                </table>

                <input type="hidden" id="dashurl" value="projects/projects_stats">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        draw_data()
    });

    function draw_data(){
        $('#project_table').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'order': [],
            "ajax": {
                "url": "<?php echo site_url('projects/project_load_list')?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            'columnDefs': [
                {
                    'targets': [3],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-plus"></i> Yeni Proje Oluştur',
                    action: function ( e, dt, node, config ) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Proje Oluştur',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-8 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content:`<form>
                              <div class="form-row">
  	<div class="form-group col-md-12">
        <label class="col-form-label" for="name">Proje Kodu</label>
         <input type="text" placeholder="Proje Kodu" class="form-control margin-bottom  required" name="code" id='code'>
    </div>
  </div>
  <div class="form-row">
  	<div class="form-group col-md-12">
        <label class="col-form-label" for="name"><?php echo $this->lang->line('Project Title') ?></label>
         <input type="text" placeholder="Proje Adı" class="form-control margin-bottom  required" name="name" id='name'>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-label" for="project_adresi"><?php echo $this->lang->line('project_adresi') ?></label>
        <input type="text" placeholder="Proje Adresi" class="form-control margin-bottom  required" name="project_adresi" id='project_adresi'>
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="name"><?php echo $this->lang->line('Status') ?></label>
             <select id="status" class=' form-control select-box' class="form-control">
              <?php foreach ($project_status as $ps )
                            {
                            $id=$ps['id'];
                            $name=$ps['name'];
                            ?>
                  <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                  <?php  } ?>
            </select>
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>
            <select name="customer" class="form-control select-box" id="customer_statement">
              <?php foreach (all_customer() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->company;
                            ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
            </select>
     </div>
   </div>

  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="start_date">Başlangıç Tarihi</label>
      <input type="date" class="form-control" id="start_date">

    </div>

    <div class="form-group col-md-4">
      <label for="start_date">Vade Tarihi</label>
      <input type="date" class="form-control" id="edate">

    </div>
  <div class="form-group col-md-4">
      <label for="worth">Bütçe</label>
      <input type="number" class="form-control" id="worth">
    </div>

</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="worth">Sözleşme Tutarı</label>
      <input type="number" class="form-control" id="sozlesme_tutari">
    </div>
    <div class="form-group col-md-4">
      <label for="benzin_talebi">Sözleşme Numarası</label>
      <input type="text" class="form-control" id="sozlesme_numarasi">
    </div>
    <div class="form-group col-md-4">
      <label for="sozlesme_date">Sözleşme Tarihi</label>
      <input type="date" class="form-control" id="sozlesme_date">
    </div>

  </div>
  <hr>

</form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let errors = [];

                                        // Alan doğrulamaları
                                        if (!$('#name').val()) {
                                            errors.push('Proje Adı zorunludur.');
                                        }
                                        if (!$('#project_adresi').val()) {
                                            errors.push('Proje Adresi zorunludur.');
                                        }
                                        if (!$('#status').val()) {
                                            errors.push('Durum seçilmelidir.');
                                        }
                                        if (!$('#customer_statement').val()) {
                                            errors.push('Müşteri seçilmelidir.');
                                        }
                                        if (!$('#start_date').val()) {
                                            errors.push('Başlangıç Tarihi zorunludur.');
                                        }
                                        if (!$('#edate').val()) {
                                            errors.push('Vade Tarihi zorunludur.');
                                        }
                                        if (!$('#worth').val()) {
                                            errors.push('Bütçe zorunludur.');
                                        }
                                        if (!$('#sozlesme_tutari').val()) {
                                            errors.push('Sözleşme Tutarı zorunludur.');
                                        }
                                        if (!$('#sozlesme_numarasi').val()) {
                                            errors.push('Sözleşme Numarası zorunludur.');
                                        }
                                        if (!$('#sozlesme_date').val()) {
                                            errors.push('Sözleşme Tarihi zorunludur.');
                                        }
                                        // if (!$('#proje_muduru_id').val()) {
                                        //     errors.push('Proje Müdürü seçilmelidir.');
                                        // }
                                        // if (!$('#proje_sorumlusu_id').val()) {
                                        //     errors.push('Proje Sorumlusu seçilmelidir.');
                                        // }
                                        // if (!$('#muhasebe_muduru_id').val()) {
                                        //     errors.push('Muhasebe Müdürü seçilmelidir.');
                                        // }
                                        // if (!$('#genel_mudur_id').val()) {
                                        //     errors.push('Genel Müdür seçilmelidir.');
                                        // }

                                        // Eğer hata varsa, hataları göster ve işlemi durdur
                                        if (errors.length > 0) {
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                animation: 'scale',
                                                useBootstrap: true,
                                                columnClass: "col-md-4 mx-auto",
                                                title: 'Hata',
                                                content: errors.join('<br>'),
                                                buttons: {
                                                    prev: {
                                                        text: 'Tamam',
                                                        btnClass: "btn btn-link text-dark",
                                                    }
                                                }
                                            });
                                            return false; // İşlemi durdur
                                        }

                                        // Eğer tüm doğrulamalardan geçerse verileri gönder
                                        let data = {
                                            crsf_token: crsf_hash,
                                            name: $('#name').val(),
                                            project_adresi: $('#project_adresi').val(),
                                            status: $('#status').val(),
                                            customer: $('#customer_statement').val(),
                                            sdate: $('#start_date').val(),
                                            edate: $('#edate').val(),
                                            worth: $('#worth').val(),
                                            code: $('#code').val(),
                                            sozlesme_tutari: $('#sozlesme_tutari').val(),
                                            sozlesme_numarasi: $('#sozlesme_numarasi').val(),
                                            sozlesme_date: $('#sozlesme_date').val(),
                                            // proje_muduru_id: $('#proje_muduru_id').val(),
                                            // proje_sorumlusu_id: $('#proje_sorumlusu_id').val(),
                                            // genel_mudur_id: $('#genel_mudur_id').val(),
                                            // muhasebe_muduru_id: $('#muhasebe_muduru_id').val(),
                                            ptype: 0,
                                            progress: 0,
                                            priority: "Yüksek",
                                        };

                                        $('#loading-box').removeClass('d-none');
                                        $.post(baseurl + 'projects/addproject', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status == 200) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#project_table').DataTable().destroy();
                                                                draw_data();
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                            else if (responses.status == 410) {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: responses.message,
                                                    buttons: {
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
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                })




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
    $(document).on('click', '.delete_line', function () {
        $(this).parent().parent().remove();
        $('.select-box').select2({
            dropdownParent: $(".jconfirm-box-container")
        })

    })

    $(document).on('click','.maas_sort',function (){
        let proje_id = $(this).attr('proje_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Maaş Onay Sıralaması',
            icon: 'fa fa-money',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "medium",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function (){
                let self = this;
                let html=`<form>
  <div class="form-row">
<div class="form-group col-md-12">
<button type="button" class="btn btn-secondary new_personel"><i class="fa fa-plus"></i></button>
</div>
<table class="add-row-table table">
    <thead>
        <tr>
            <th>Personel</th>
            <th>Sıralama</th>
            <th>İşlem</th>
        </tr>
    </thead>
 <tbody>
</tbody>

</table>

  </div>
</form>`;
                let data = {
                    proje_id: proje_id,
                }


                $.post(baseurl + 'projects/maas_sort_info',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);


                    let table_report='';
                    if(responses.items.length > 0){
                        responses.items.forEach((item,key) => {
                            $('.add-row-table tbody').append(`
<tr>
                                    <td><select class="form-control select-box sort_personel_id">
                                      <option value='0'>Personel Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                            $emp_id=$emp->id;
                            $name=$emp->name;
                            ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select></td>
                                    <td>`+item.sort+`</td>
                                <td>
                                <button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button>
                                </td>
                        </tr>`);

                            $('.sort_personel_id').eq(key).val(item.user_id)
                        })
                    }
                    else {
                        $('.add-row-table tbody').append(`
<tr>
                                    <td><select class="form-control select-box sort_personel_id">
                                    <option value='0'>Personel Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
                        $emp_id=$emp->id;
                        $name=$emp->name;
                        ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select></td>
                                    <td>1</td>
                                    <td></td>
                        </tr>`);
                    }



                    /*$('#name').val(responses.items.name);
                    $('#project_adresi').val(responses.items.project_adresi);
                    $('#start_date').val(responses.items.sdate);
                    $('#edate').val(responses.items.edate);
                    $('#worth').val(responses.items.worth);
                    $('#sozlesme_tutari').val(responses.items.sozlesme_tutari);
                    $('#sozlesme_numarasi').val(responses.items.sozlesme_numarasi);
                    $('#sozlesme_date').val(responses.items.sozlesme_date);
                    $('#status').val(responses.items.status).select2().trigger('change');
                    $('#customer_statement').val(responses.items.cid).select2().trigger('change');
                    $('#proje_muduru_id').val(responses.items.proje_muduru_id).select2().trigger('change');
                    $('#proje_sorumlusu_id').val(responses.items.proje_sorumlusu_id).select2().trigger('change');
                    $('#muhasebe_muduru_id').val(responses.items.muhasebe_muduru_id).select2().trigger('change');
                    $('#genel_mudur_id').val(responses.items.genel_mudur_id).select2().trigger('change');*/
                });

                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let details=[];
                        let log=0;
                        let sort = $('.sort_personel_id').length;
                        for (let i =0; i <sort;i++){
                            if($('.sort_personel_id').eq(i).val()==0){
                                log=1;
                            }
                            details.push({
                                'user_id': $('.sort_personel_id').eq(i).val(),
                                'sort':parseInt(i)+1,
                                'proje_id':proje_id
                            });
                        }
                        if (log) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Personel Seçiniz',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });

                            return false;

                        }

                        $('#loading-box').removeClass('d-none');

                        let emp=[];
                        // $.each($('[name="employee[]"]').val(),function(index,item){
                        //     emp.push(item);
                        // })

                        let data = {
                            crsf_token: crsf_hash,
                            proje_id:proje_id,
                            details:details,
                        }
                        $.post(baseurl + 'projects/salary_sort_update',data,(response) => {
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
                                            action: function () {
                                                $('#project_table').DataTable().destroy();
                                                draw_data();
                                            }
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
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })




                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
    $(document).on('click','.new_personel',function (){

        let eq = $('.add-row-table tbody tr').length;
        let say=parseInt(eq)+1;
        $('.add-row-table tbody').append(`
<tr>
                                    <td><select class="form-control select-box sort_personel_id">
                                      <option value='0'>Personel Seçiniz</option>
                                        <?php foreach (all_personel() as $emp){
        $emp_id=$emp->id;
        $name=$emp->name;
        ?>
                                        <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                                    <?php } ?>
                                </select></td>
                                    <td>`+say+`</td>
                                <td>
                                <button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button>
                                </td>
                        </tr>`);
        $('.select-box').select2({
            dropdownParent: $(".jconfirm-box-container")
        })

    })
    $(document).on('click', '.edit_proje', function () {
        let proje_id = $(this).attr('proje_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Proje Düzenle',
            icon: 'fa fa-pen',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `<form>
 <div class="form-row">
  	<div class="form-group col-md-12">
        <label class="col-form-label" for="name"><?php echo $this->lang->line('Project Title') ?></label>
         <input type="text" placeholder="Proje Adı" class="form-control margin-bottom  required" name="name" id='name'>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
        <label class="form-label" for="project_adresi"><?php echo $this->lang->line('project_adresi') ?></label>
        <input type="text" placeholder="Proje Adresi" class="form-control margin-bottom  required" name="project_adresi" id='project_adresi'>
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="name"><?php echo $this->lang->line('Status') ?></label>
            <select id="status" class=' form-control select-box' class="form-control">
              <?php foreach ($project_status as $ps )
                {
                $id=$ps['id'];
                $name=$ps['name'];
                ?>
                  <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                  <?php  } ?>
            </select>
    </div>
    <div class="form-group col-md-4">
        <label class="form-label" for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>
            <select name="customer" class="form-control select-box" id="customer_statement">
              <?php foreach (all_customer() as $emp){
                $emp_id=$emp->id;
                $name=$emp->company;
                ?>
                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                            <?php } ?>
            </select>
     </div>
   </div>

  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="start_date">Başlangıç Tarihi</label>
      <input type="date" class="form-control" id="start_date">

    </div>

    <div class="form-group col-md-4">
      <label for="start_date">Vade Tarihi</label>
      <input type="date" class="form-control" id="edate">

    </div>
  <div class="form-group col-md-4">
      <label for="worth">Bütçe</label>
      <input type="number" class="form-control" id="worth">
    </div>

</div>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="worth">Sözleşme Tutarı</label>
      <input type="number" class="form-control" id="sozlesme_tutari">
    </div>
    <div class="form-group col-md-4">
      <label for="benzin_talebi">Sözleşme Numarası</label>
      <input type="text" class="form-control" id="sozlesme_numarasi">
    </div>
    <div class="form-group col-md-4">
      <label for="sozlesme_date">Sözleşme Tarihi</label>
      <input type="date" class="form-control" id="sozlesme_date">
    </div>

  </div>
  <hr>
    <div class="form-row">
    <div class="form-group col-md-3">
      <label for="proje_muduru_id">Proje Müdürü</label>
        <select class="form-control select-box required" id="proje_muduru_id">
     <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
        </select>

    </div>
  <div class="form-group col-md-3">
      <label for="genel_mudur_id">Proje Sorumlusu</label>
         <select class="form-control select-box required" id="proje_sorumlusu_id">
     <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
        </select>
    </div>
    <div class="form-group col-md-3">
      <label for="teknika_sorumlu_id">Muhasebe Müdürü</label>
       <select class="form-control select-box required" id="muhasebe_muduru_id">
     <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
        </select>
    </div>
     <div class="form-group col-md-3">
      <label for="teknika_sorumlu_id">Genel Müdür</label>
       <select class="form-control select-box required" id="genel_mudur_id">
     <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
        <?php } ?>
        </select>
    </div>
</div>

            </form>`;

                let data = {
                    proje_id: proje_id,
                };

                $.post(baseurl + 'projects/proje_info', data, (response) => {
                    let responses = jQuery.parseJSON(response);
                    $('#name').val(responses.items.name);
                    $('#project_adresi').val(responses.items.project_adresi);
                    $('#start_date').val(responses.items.sdate);
                    $('#edate').val(responses.items.edate);
                    $('#worth').val(responses.items.worth);
                    $('#sozlesme_tutari').val(responses.items.sozlesme_tutari);
                    $('#sozlesme_numarasi').val(responses.items.sozlesme_numarasi);
                    $('#sozlesme_date').val(responses.items.sozlesme_date);
                    $('#status').val(responses.items.status).select2().trigger('change');
                    $('#customer_statement').val(responses.items.cid).select2().trigger('change');
                    $('#proje_muduru_id').val(responses.items.proje_muduru_id).select2().trigger('change');
                    $('#proje_sorumlusu_id').val(responses.items.proje_sorumlusu_id).select2().trigger('change');
                    $('#muhasebe_muduru_id').val(responses.items.muhasebe_muduru_id).select2().trigger('change');
                    $('#genel_mudur_id').val(responses.items.genel_mudur_id).select2().trigger('change');
                });

                return html;
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name = $('#name').val().trim();
                        let project_adresi = $('#project_adresi').val().trim();
                        let status = $('#status').val();
                        let customer = $('#customer_statement').val();
                        let sdate = $('#start_date').val();
                        let edate = $('#edate').val();
                        let worth = $('#worth').val();
                        let sozlesme_tutari = $('#sozlesme_tutari').val();
                        let sozlesme_numarasi = $('#sozlesme_numarasi').val();
                        let sozlesme_date = $('#sozlesme_date').val();
                        let proje_muduru_id = $('#proje_muduru_id').val();
                        let proje_sorumlusu_id = $('#proje_sorumlusu_id').val();
                        let muhasebe_muduru_id = $('#muhasebe_muduru_id').val();
                        let genel_mudur_id = $('#genel_mudur_id').val();

                        // Tüm alanlar için kontrol
                        if (!name || !project_adresi || !status || !customer || !sdate || !edate || !worth || !sozlesme_tutari || !sozlesme_numarasi || !sozlesme_date || !proje_muduru_id || !proje_sorumlusu_id || !muhasebe_muduru_id || !genel_mudur_id) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Eksik Bilgi!',
                                content: 'Lütfen tüm alanları doldurun.',
                            });
                            return false; // İşlemi durdur
                        }

                        // AJAX ile veri gönderimi
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            p_id: proje_id,
                            name: name,
                            project_adresi: project_adresi,
                            status: status,
                            customer: customer,
                            sdate: sdate,
                            edate: edate,
                            worth: worth,
                            sozlesme_tutari: sozlesme_tutari,
                            sozlesme_numarasi: sozlesme_numarasi,
                            sozlesme_date: sozlesme_date,
                            proje_muduru_id: proje_muduru_id,
                            proje_sorumlusu_id: proje_sorumlusu_id,
                            genel_mudur_id: genel_mudur_id,
                            muhasebe_muduru_id: muhasebe_muduru_id,
                        };

                        $.post(baseurl + 'projects/updateProje', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#project_table').DataTable().destroy();
                                                draw_data();
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Hata!',
                                    content: responses.message,
                                });
                            }
                        });
                    }
                },
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });
            }
        });
    });



</script>
