<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Employee') ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                     <h5 class="title">
                <a href="<?php echo base_url('employee/add') ?>"
                                                               class="btn btn-primary btn-sm rounded">
                    <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i>Yeni Ekle
                </a>


                <a  href='#pop_model_alacaklandirma' data-toggle='modal' data-remote='false'  class="btn btn-primary btn-sm rounded" id="pers_alacaklandir">
                    <i class="fa fa-money" aria-hidden="true" title="Yeni Ekle"></i>Personel Alacaklandır / Borçlandır
                </a>

                <button class="btn btn-success btn-sm rounded" id="personel_expense">
                    <i class="fa fa-money"  title="Yeni Ekle"></i>Personel Alacak / Borç
                </button>
<!--                <button class="btn btn-warning btn-sm rounded" id="mezuniyet_cikar">-->
<!--                    <i class="fa faTOPLAM MAAŞ-money"  title="Yeni Ekle"></i>Mezuiniyet-->
<!--                </button>-->
                <button class="btn btn-danger btn-sm rounded" id="is_cikis">
                    <i class="ft-power"></i>İş Çıkışı Bildir
                </button>
                <button class="btn btn-success btn-sm rounded" id="prim_talep">
                    <i class="fa fa-plus"></i>Prim / Ceza Talebi Oluştur
                </button>
            </h5>
            </div>
        </div>
        <div class="card">
            <table id="emptable" class="table datatable-show-all">
                <thead>
                <tr>
                    <th><input type="checkbox" class="form-control all_select" style="width: 30px;"></th>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th>Role</th>
                    <th>Aktif Çalıştığı Proje</th>
                    <th>Bakiye</th>
                    <th><?php echo $this->lang->line('Status') ?></th>
                    <th><?php echo $this->lang->line('Actions') ?></th>


                </tr>
                </thead>
                <tbody class="table datatable-show-all">
                <?php $i = 1;

                foreach ($employee as $row) {

                    $aid = $row['id'];
                    $username = $row['username'];
                    $name = $row['name'];
                    $proje_name = $row['proje_name'];
                    $role = roles($row['roleid']);
                    $status = $row['banned'];
                    $bakiye=0;
                    if($this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id==21 || $this->aauth->get_user()->id == 61 || $this->aauth->get_user()->id == 1007 || $this->aauth->get_user()->id == 62){
                        $bakiye=personel_bakiye_report($row['id']);
                    }


                    if ($status == 1) {
                        $status = 'Pasif';
                        $btn = "<a href='#' data-object-id='" . $aid . "'  data-object1-id='" . $aid . "'  class='btn btn-blue btn-sm delete-object' title='Enable'><i class='icon-eye-slash' title='SEbiwwwww'></i> Aktif</a>";
                    } else {
                        $status = 'Aktif';
                        $btn = "<a href='#' data-object-id='" . $aid . "' class='btn btn-success btn-sm delete-object' title='Disable'><i class='fa fa-chain-broken'></i> " . $this->lang->line('Disable') . "</a>";
                    }

                    echo "<tr>
                    <td><input type='checkbox' class='form-control one_select' pers_id ='".$aid."'</td>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$role</td>
                    <td>$proje_name</td>
                    <td>$bakiye</td>
                    <td>$status</td>
                    <td><a href='" . base_url("employee/update?id=$aid") . "' class='btn btn-success btn-sm'> " . $this->lang->line('edit') . "</a>&nbsp;&nbsp;<a href='" . base_url("employee/view?id=$aid") . "' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp;&nbsp;$btn&nbsp;&nbsp;
                    <button  data-object-id='" . $aid . "' class='btn btn-success btn-sm maas_pers' title='Maas Düzenleme'><i class='fa fa-money'></i> Maaş / Proje</button>
                    </td></tr>";
                    $i++;
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
       
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#emptable').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,

                    }
                ],
            });


        });


        $(document).on('click', ".maas_pers", function (e) {

           let pers_id =  $(this).attr('data-object-id')
            let data = {
                crsf_token: crsf_hash,
                personel_id: pers_id,
            }
            $.post(baseurl + 'employee/personel_salary',data,(values) => {
                let value = jQuery.parseJSON(values);
                if(value.status=='Success'){
                    $.confirm({
                        theme: 'material',
                        closeIcon: true,
                        title: 'Personel Maaş Düzenlemesi',
                        icon: 'fa fa-exclamation',
                        type: 'dark',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-6 mx-auto",
                        containerFluid: !0,
                        smoothContent: true,
                        draggable: false,
                        content: function () {
                            let self = this;
                            let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                            let responses;
                            html+='<form action="" class="formName">' +
                                '<div class="form-group">' +
                                '<label>Toplam Maaş</label>' +
                                '<input type="number" name="salary" id="salary" class="name form-control"/>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Banka Maaş</label>' +
                                '<input type="number" name="bank_salary" id="bank_salary" class="name form-control"/>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Kelbecer Farkı</label>' +
                                '<input type="number" name="net_salary" id="net_salary" class="name form-control"/>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Maaş Tipi</label>' +
                                '<select class="form-control name" id="salary_type" name="salary_type"><option>Seçiniz</option></select>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Günlük Maaş</label>' +
                                '<input type="number" id="salary_day" class="form-control">' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Çalıştığı Proje</label>' +
                                '<select class="form-control select-box name" id="proje_id" name="proje_id"><option>Seçiniz</option></select>' +
                                '</div>' +
                                '</form>';

                            let data = {
                                crsf_token: crsf_hash,
                                personel_id: pers_id,
                            }
                            $.post(baseurl + 'employee/personel_salary',data,(response) => {
                                self.$content.find('#person-list').empty().append(html);
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
                                let responses = jQuery.parseJSON(response);

                                $('#salary_day').val(responses.item.salary_day);
                                $('#bank_salary').val(responses.item.bank_salary);
                                $('#net_salary').val(responses.item.net_salary);
                                $('#salary').val(responses.item.salary);
                                responses.salary_type.forEach((item_,index) => {
                                    if(item_.id==responses.item.salary_type){
                                        $('#salary_type').append(new Option(item_.name, item_.id, true, true)).trigger('change');
                                    }
                                    else {
                                        $('#salary_type').append(new Option(item_.name, item_.id, false, false));
                                    }

                                })
                                responses.all_proje.forEach((item_,index) => {
                                    if(item_.id==responses.item.proje_id){
                                        $('#proje_id').append(new Option(item_.name, item_.id, true, true)).trigger('change');
                                    }
                                    else {
                                        $('#proje_id').append(new Option(item_.name, item_.id, false, false));
                                    }

                                })
                            });


                            self.$content.find('#person-list').empty().append(html);
                            return $('#person-container').html();
                        },
                        onContentReady:function (){
                        },
                        buttons: {
                            formSubmit: {
                                text: 'Güncelle',
                                btnClass: 'btn-blue',
                                action: function () {
                                    var name = this.$content.find('.name').val();
                                    if(!name){
                                        $.alert({
                                            theme: 'material',
                                            icon: 'fa fa-exclamation',
                                            type: 'red',
                                            animation: 'scale',
                                            useBootstrap: true,
                                            columnClass: "col-md-4 mx-auto",
                                            title: 'Dikkat!',
                                            content: 'Tüm Alanlar Zorunludur',
                                            buttons:{
                                                prev: {
                                                    text: 'Tamam',
                                                    btnClass: "btn btn-link text-dark",
                                                }
                                            }
                                        });
                                        return false;
                                    }
                                    let salary = $('#salary').val()
                                    let bank_salary = $('#bank_salary').val()
                                    let salary_type = $('#salary_type').val()
                                    let salary_day = $('#salary_day').val()
                                    let net_salary = $('#net_salary').val()
                                    let proje_id = $('#proje_id').val()
                                    jQuery.ajax({
                                        url: baseurl + 'employee/salary_update',
                                        dataType: "json",
                                        method: 'post',
                                        data: 'proje_id='+proje_id+'&salary='+salary+'&bank_salary='+salary+'&net_salary='+net_salary+'&bank_salary='+bank_salary+'&salary_type='+salary_type+'&salary_day='+salary_day+'&pers_id='+pers_id+'&'+crsf_token+'='+crsf_hash,
                                        beforeSend: function(){
                                            $('#loading-box').removeClass('d-none');

                                        },
                                        success: function (data) {
                                            if (data.status == "Success") {
                                                $.alert(data.message);
                                                $('#loading-box').addClass("d-none");

                                            } else {
                                                $.alert(data.message);

                                            }
                                        },
                                        error: function (data) {
                                            $.alert(data.message);
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
                        content: value.message,
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }

            })


        })

        $(document).on('click', "#is_cikis", function (e) {
            let checked_count = $('.one_select:checked').length;
            if(checked_count==0){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Herhangi Bir Personel Seçilmemiş!',
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
                    theme: 'material',
                    closeIcon: true,
                    title: 'İş Çıkış Bildirme',
                    icon: 'fa fa-exclamation',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-6 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: function () {
                        let self = this;
                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                        let responses;
                        html+='<form action="" class="formName">' +
                            '<div class="form-group">' +
                            '<label>İş Çıkış Tarihi</label>' +
                            '<input class="form-control is_ciskis" id="is_cikis_date" name="is_cikis_date" type="date">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Hesap Kesim Tarihi</label>' +
                            '<input class="form-control is_ciskis" id="hesap_kesim_date" name="hesap_kesim_date" type="date">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Ayrılma Sebebi</label>' +
                            '<input class="form-control is_ciskis" id="is_cikis_desc" name="is_cikis_desc name" type="text">' +
                            '</div>' +
                            '</form>';

                        let data = {
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                            self.$content.find('#person-list').empty().append(html);
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            });
                            let responses = jQuery.parseJSON(response);

                        });


                        self.$content.find('#person-list').empty().append(html);
                        return $('#person-container').html();
                    },
                    onContentReady:function (){
                    },
                    buttons: {
                        formSubmit: {
                            text: 'Güncelle',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.is_ciskis').val();
                                if(!name){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Tüm Alanlar Zorunludur',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    return false;
                                }
                                let is_cikis_desc = $('#is_cikis_desc').val();
                                let is_cikis_date = $('#is_cikis_date').val();
                                let hesap_kesim_date = $('#hesap_kesim_date').val();
                                let personel_details = [];
                                $('.one_select:checked').each((index,item) => {
                                    personel_details.push($(item).attr('pers_id'));
                                })
                                jQuery.ajax({
                                    url: baseurl + 'employee/personel_is_cikis_update',
                                    dataType: "json",
                                    method: 'post',
                                    data: 'hesap_kesim_date='+hesap_kesim_date+'&pers_id='+personel_details+'&is_cikis_desc='+is_cikis_desc+'&is_cikis_date='+is_cikis_date+'&'+crsf_token+'='+crsf_hash,
                                    beforeSend: function(){
                                        $('#loading-box').removeClass('d-none');

                                    },
                                    success: function (data) {
                                        if (data.status == "Success") {
                                            $.alert(data.message);
                                            $('#loading-box').addClass("d-none");

                                        } else {
                                            $.alert(data.message);

                                        }
                                    },
                                    error: function (data) {
                                        $.alert(data.message);
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
            }


        })

        $(document).on('click', "#prim_talep", function (e) {
            let checked_count = $('.one_select:checked').length;
            if(checked_count==0){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Herhangi Bir Personel Seçilmemiş!',
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
                    theme: 'material',
                    closeIcon: true,
                    title: 'Prim Talebi',
                    icon: 'fa fa-exclamation',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-6 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: function () {
                        let self = this;
                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                        let responses;
                        html+='<form action="" class="formName">' +
                            '<div class="form-group">' +
                            '<label>Tutar</label>' +
                            '<input class="form-control is_ciskis" id="tutar" name="tutar" type="number">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Açıklama</label>' +
                            '<input class="form-control is_ciskis" id="aciklama" name="aciklama" type="text">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Proje</label>' +
                            '<select class="form-control is_ciskis select-box" name="proje_id_modal" id="proje_id_modal"></select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Proje Müdürü</label>' +
                            '<select class="form-control is_ciskis select-box" name="proje_muduru" id="proje_muduru"></select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Tip</label>' +
                            '<select class="form-control is_ciskis" name="type" id="type"><option value="1">Prim</option><option value="2">Ceza</option></select>' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Prim/Ceza Maaş Ayı</label>' +
                            '<select class="form-control hesaplanan_ay_" name="hesaplanan_ay_" id="hesaplanan_ay_">'+
                            '<option value="">Seçiniz</option>'+
                            '<option value="1">01 - Ocak</option>'+
                            '<option value="2">02 - Şubat</option>'+
                            '<option value="3">03 - Mart</option>'+
                            '<option value="4">04 - Nisan</option>'+
                            '<option value="5">05 - Mayıs</option>'+
                            '<option value="6">06 - Haziran</option>'+
                            '<option value="7">07 - Temmuz</option>'+
                            '<option value="8">08 - Ağustos</option>'+
                            '<option value="9">09 - Eylül</option>'+
                            '<option value="10">10 - Ekim</option>'+
                            '<option value="11">11 - Kasım</option>'+
                            '<option value="12">12 - Aralık</option>'+
                            '</select>' +
                            '</div>' +
                            '<div class="form-group">'+`

                            <div class="col-sm-12">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <table id="files" class="files"></table>
                            <br>
                            <span class="btn btn-success fileinput-button" style="width: 100%">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>İmzalı Dosya...</span>
                            <input id="fileupload_" type="file" name="files[]">
                            <input type="hidden" class="image_text" name="image_text" id="image_text">
                            </span>
                            </div>`+'</form>';

                            let data = {
                                crsf_token: crsf_hash,
                            }


                            $.post(baseurl + 'employee/projeler',data,(response) => {
                                self.$content.find('#person-list').empty().append(html);
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
                                let responses = jQuery.parseJSON(response);
                                responses.item.forEach((item_,index) => {
                                    $('#proje_id_modal').append(new Option(item_.name, item_.id, false, false));
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
                            });

                            $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });
                                let responses = jQuery.parseJSON(response);
                                responses.item.forEach((item_,index) => {
                                    $('#proje_muduru').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                                })

                            });


                        self.$content.find('#person-list').empty().append(html);


                        return $('#person-container').html();

                    },
                    onContentReady:function (){

                    },
                    buttons: {
                        formSubmit: {
                            text: 'Talep Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.is_ciskis').val();
                                var hesaplanan_ay = this.$content.find('.hesaplanan_ay_').val();
                                var image_text_ = this.$content.find('.image_text').val();
                                if(!name || !image_text_){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Tüm Alanlar Zorunludur',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    return false;
                                }

                                if(!hesaplanan_ay){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Hesaplanacak Maaş Ayını seçmelisiniz',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    return false;
                                }
                                let tutar = $('#tutar').val();
                                let image_text = $('#image_text').val();
                                let hesaplanan_ay_ = $('#hesaplanan_ay_').val();
                                let proje_muduru = $('#proje_muduru').val();
                                let aciklama = $('#aciklama').val();
                                let proje_id_modal = $('#proje_id_modal').val();
                                let type = $('#type').val();
                                let personel_details = [];
                                $('.one_select:checked').each((index,item) => {
                                    personel_details.push($(item).attr('pers_id'));
                                })
                                jQuery.ajax({
                                    url: baseurl + 'employee/personel_prim_talep',
                                    dataType: "json",
                                    method: 'post',
                                    data: 'hesaplanan_ay='+hesaplanan_ay_+'filed_upload='+image_text+'&proje_muduru='+proje_muduru+'&type='+type+'&tutar='+tutar+'&pers_id='+personel_details+'&aciklama='+aciklama+'&proje_id_modal='+proje_id_modal+'&'+crsf_token+'='+crsf_hash,
                                    beforeSend: function(){
                                        $('#loading-box').removeClass('d-none');

                                    },
                                    success: function (data) {
                                        if (data.status == "Success") {
                                            $.alert(data.message);
                                            $('#loading-box').addClass("d-none");

                                        } else {
                                            $.alert(data.message);

                                        }
                                    },
                                    error: function (data) {
                                        $.alert(data.message);
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
            }


        })

        $(document).on('click', "#mezuniyet_cikar", function (e) {
            let checked_count = $('.one_select:checked').length;
            if(checked_count==0){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Herhangi Bir Personel Seçilmemiş!',
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
                    theme: 'material',
                    closeIcon: true,
                    title: 'Mezuniyet',
                    icon: 'fa fa-exclamation',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-6 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: function () {
                        let self = this;
                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                        let responses;
                        html+='<form action="" class="formName">' +
                            '<div class="form-group">' +
                            '<label>Mezuniyet Gün</label>' +
                            '<input class="form-control mezuniyet_gun" id="mezuniyet_gun" name="mezuniyet_gun" type="number">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Mezuniyete Çıkış Tarihi</label>' +
                            '<input class="form-control mezuniyet_gun" id="mezuniyet_start_date" name="mezuniyet_start_date" type="date">' +
                            '</div>' +
                            '</form>';

                        let data = {
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                            self.$content.find('#person-list').empty().append(html);
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            });
                            let responses = jQuery.parseJSON(response);

                        });


                        self.$content.find('#person-list').empty().append(html);
                        return $('#person-container').html();
                    },
                    onContentReady:function (){
                    },
                    buttons: {
                        formSubmit: {
                            text: 'Güncelle',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.mezuniyet_gun').val();
                                if(!name){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Tüm Alanlar Zorunludur',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    return false;
                                }
                                let mezuniyet_gun = $('#mezuniyet_gun').val();
                                let mezuniyet_start_date = $('#mezuniyet_start_date').val();
                                let personel_details = [];
                                $('.one_select:checked').each((index,item) => {
                                    personel_details.push($(item).attr('pers_id'));
                                })
                                jQuery.ajax({
                                    url: baseurl + 'employee/personel_mezuniyet',
                                    dataType: "json",
                                    method: 'post',
                                    data: 'mezuniyet_start_date='+mezuniyet_start_date+'&mezuniyet_gun='+mezuniyet_gun+'&pers_id='+personel_details+'&'+crsf_token+'='+crsf_hash,
                                    beforeSend: function(){
                                        $('#loading-box').removeClass('d-none');

                                    },
                                    success: function (data) {
                                        if (data.status == "Success") {
                                            $.alert(data.message);
                                            $('#loading-box').addClass("d-none");

                                        } else {
                                            $.alert(data.message);

                                        }
                                    },
                                    error: function (data) {
                                        $.alert(data.message);
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
            }


        })


        $(document).on('click', "#personel_expense", function (e) {
            let checked_count = $('.one_select:checked').length;
            if(checked_count==0){
                $.alert({
                    theme: 'material',
                    icon: 'fa fa-exclamation',
                    type: 'red',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-4 mx-auto",
                    title: 'Dikkat!',
                    content: 'Herhangi Bir Personel Seçilmemiş!',
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
                    theme: 'material',
                    closeIcon: true,
                    title: 'Personel Alacak / Borç',
                    icon: 'fa fa-exclamation',
                    type: 'dark',
                    animation: 'scale',
                    useBootstrap: true,
                    columnClass: "col-md-6 mx-auto",
                    containerFluid: !0,
                    smoothContent: true,
                    draggable: false,
                    content: function () {
                        let self = this;
                        let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                        let responses;
                        html+='<form action="" class="formName">' +
                            '<div class="form-group">' +
                            '<label>Tutar</label>' +
                            '<input class="form-control modal_alacak" id="tutar_expense" name="tutar" type="number">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Açıklama</label>' +
                            '<input class="form-control modal_alacak" id="aciklama_expense" name="aciklama" type="text">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Tip</label>' +
                            '<select class="form-control modal_alacak" name="alacakak_borc" id="alacakak_borc"><option value="0">Seçiniz</option><option value="26">Personel Alacaklandır</option><option value="34">Personel Borçlandır(Kasa Çıkışı Olmadan)</option><option value="52">Personel Borçlandır(Kasa Çıkışı)</option><option value="53">Personel Cərimə</option></select>' +
                            '</div>' +
                            '<div class="form-group" >' +
                            '<label>Ödeme Tipi</label>' +
                            '<select class="form-control modal_alacak" name="method" id="method"><option value="0">Seçiniz</option><option value="1">Nakit</option><option value="3">Banka</option></select>' +
                            '</div>' +
                            '<div class="form-group account_pers d-none" >' +
                            '<label>Kasa</label><br/>' +
                            '<select class="form-control select-box" name="csd" id="csd"></select>' +
                            '</div>' +
                            '<div class="form-group vade_pers d-none" >' +
                            '<label>Vade Sayısı</label>' +
                            '<input class="form-control" id="vade" name="vade" min="1" value="1" type="number"><span class="text-danger" id="aylik_tutar"></span>' +
                            '</div>' +
                            '<div class="form-group">'+`

                            <div class="col-sm-12 cerime_pers d-none">
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <table id="files" class="files"></table>
                            <br>
                            <span class="btn btn-success fileinput-button" style="width: 100%">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>İmzalı Dosya...</span>
                            <input id="fileupload" type="file" name="files[]">
                            <input type="hidden" class="image" name="image" id="image">
                            </span>
                            </div>`+
                             `<div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="send-sms-alacak" name="send-sms-alacak" checked>
                                     <label class="form-check-label" for="defaultCheck1">
                                      Sms Gönder
                                        </label>
                                </div>
                            </div>
                            </form>`;

                        let data = {
                            crsf_token: crsf_hash,
                        }


                        $.post(baseurl + 'employee/kasalar',data,(response) => {
                            self.$content.find('#person-list').empty().append(html);
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            });

                            let responses = jQuery.parseJSON(response);
                            responses.item.forEach((item_,index) => {
                                $('#csd').append(new Option(item_.holder, item_.id, false, false));
                            })

                            $('#fileupload').fileupload({
                                url: url,
                                dataType: 'json',
                                formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                done: function (e, data) {
                                    var img='default.png';
                                    $.each(data.result.files, function (index, file) {
                                        img=file.name;
                                    });

                                    $('#image').val(img);
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
                        });

                        $.post(baseurl + 'employee/ajax_emp_list',data,(response) => {
                            $('.select-box').select2({
                                dropdownParent: $(".jconfirm-box-container")
                            });
                            let responses = jQuery.parseJSON(response);
                            responses.item.forEach((item_,index) => {
                                $('#proje_muduru').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                            })

                        });


                        self.$content.find('#person-list').empty().append(html);


                        return $('#person-container').html();

                    },
                    onContentReady:function (){

                    },
                    buttons: {
                        formSubmit: {
                            text: 'Oluştur',
                            btnClass: 'btn-blue',
                            action: function () {
                                var name = this.$content.find('.modal_alacak').val();
                                if(!name){
                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: 'Tüm Alanlar Zorunludur',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                    return false;
                                }
                                let tutar_expense = $('#tutar_expense').val();
                                let aciklama_expense = $('#aciklama_expense').val();
                                let alacakak_borc = $('#alacakak_borc').val();
                                let method = $('#method').val();
                                let send_sms = $('#send-sms-alacak').prop('checked');
                                let acid = $('#csd').val();
                                let vade = $('#vade').val();
                                let image = $('#image').val();
                                let personel_details = [];
                                $('.one_select:checked').each((index,item) => {
                                    personel_details.push($(item).attr('pers_id'));
                                })
                                jQuery.ajax({
                                    url: baseurl + 'employee/personel_ajax_alacak_borc',
                                    dataType: "json",
                                    method: 'post',
                                    data: 'send_sms='+send_sms+'&vade='+vade+'&filed_upload='+image+'&tutar_expense='+tutar_expense+'&aciklama_expense='+aciklama_expense+'&alacakak_borc='+alacakak_borc+'&pers_id='+personel_details+'&method='+method+'&acid='+acid+'&'+crsf_token+'='+crsf_hash,
                                    beforeSend: function(){
                                        $('#loading-box').removeClass('d-none');

                                    },
                                    success: function (data) {
                                        if (data.status == "Success") {
                                            $.alert(data.message);
                                            $('#loading-box').addClass("d-none");

                                        } else {
                                            $.alert(data.message);

                                        }
                                    },
                                    error: function (data) {
                                        $.alert(data.message);
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
            }


        })

        function currencyFormat(num) {

            var deger=  num.toFixed(2).replace('.',',');
            return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
        }

    $(document).on('change','#alacakak_borc',function (){
            let id = $(this).val();
            if(id == 34 || id == 52){
             $('.vade_pers').removeClass('d-none');
             if(id == 52){
                 $('.account_pers').removeClass('d-none');
             }
             else {
                 $('.account_pers').addClass('d-none');
             }
            }
            else {
                $('.vade_pers').addClass('d-none');
            }

            if(id==53){

                $('.cerime_pers').removeClass('d-none');
                $('.account_pers').addClass('d-none');
                $('.account_pers').addClass('d-none');
            }
            else {
                $('.cerime_pers').addClass('d-none');
            }
        })


        $(document).on('keyup','#vade',function (){
            let vade_sayisi = $(this).val();
            let tutar = $('#tutar_expense').val();
            if(tutar != 0){
                let aylik_tutar = parseFloat(tutar)/parseFloat(vade_sayisi);
                $('#aylik_tutar').empty().html('Aylık Ödeme Tutarı : '+currencyFormat(aylik_tutar))
            }

        })

    </script>


    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Hesap Pasifleştirme</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Bu kullanıcıyı pasif yapmak istediğinizden emin misiniz? <br><strong>Bu hesap devre dışı kalacaktır.</strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="employee/disable_user">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Onayla
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">İptal</button>
                </div>
            </div>
        </div>
    </div>

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">


                        <div class="modal-body">
                            <p>Personeli Silmek İstediğinizden Emin Misiniz? <br><strong>Eski Bilgiler Silinebilir.Pasif Yapmanız Önerilir</strong></p>
                        </div>
                        <div class="modal-footer">


                            <input type="hidden" class="form-control required"
                                   name="empid" id="empid" value="">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url" value="employee/delete_user">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Delete'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div id="pop_model_maas" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Hakediş</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_all">


                    <div class="modal-body">
                        <p>Tüm personnelerin hakedişlerini hesaplamak istediğinizden emin misiniz?</p>
                    </div>
                    <div class="modal-footer">



                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url-all" value="employee/all_hakedis">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_hakedis"><?php echo $this->lang->line('Yes') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>

<script>
    var url = '<?php echo base_url() ?>transactions/file_handling';
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:


        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img='default.png';
                $.each(data.result.files, function (index, file) {
                   img=file.name;
                });

                $('#image').val(img);
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


    });




    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });

    $(document).on('click', "#submit_model_alacak", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_alacak").serialize();
        var action_url= $('#form_model_alacak #action-url-alacak').val();
        $("#pop_model_alacaklandirma").modal('hide');
        saveMDataHak(o_data,action_url);
    });

    $(document).on('click', "#submit_model_hakedis", function (e) {
        e.preventDefault();
        var o_data =  $("#form_model_all").serialize();
        var action_url= $('#form_model_all #action-url-all').val();
        $("#pop_model_maas").modal('hide');
        saveMDataHak(o_data,action_url);
    });

    function saveMDataHak(o_data,action_url) {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data+'&'+crsf_token+'='+crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {


                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }


    $(function () {
        $('.select-box').select2();
    });

    $(document).on('change','.all_select',function (){
        let status = $(this).prop('checked');
        if(status){
            $('.one_select').prop('checked',true)
        }
        else {
            $('.one_select').prop('checked',false)
        }
    })
</script>
