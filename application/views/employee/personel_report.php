<div class="content-body">
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="container">
                <div class="row">

                    <div class="col-md-12" style="text-align: center" >
                        <label class="form-label">Proje Seçiniz</label>
                        <select class="form-control filter select-box" filter_search="proje" id="proje"  multiple>
                            <?php
                            $proje=[];
                            if($_GET['proje']){
                                $proje = explode(',',$_GET['proje']);
                            }
                            foreach (all_projects() as $pers){

                                if (in_array($pers->id, $proje)) {
                                    echo "<option selected value='".$pers->id."'>".$pers->name."</option>";
                                }
                                else {
                                    echo "<option value='".$pers->id."'>".$pers->name."</option>";
                                }
                                ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>


            <div class="card-body">

                <table id="emptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Firma Durumu</th>
                        <th>Proje</th>
                        <th>Departman</th>
                        <th>Maaş</th>
                        <th>Nakit</th>
                        <th>Banka</th>
                        <th>Toplam Banka Avans</th>
                        <th>Toplam Nakit Avans</th>
                        <th>Kalan Banka</th>
                        <th>Kalan Nakit</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;



                    $gayri_resmi_maas_total=0;
                    $resmi_maas_total=0;
                    $maas_total=0;
                    $toplam_banka_avans=0;
                    $toplam_nakit_avans=0;
                    $b_resmi_maas_total=0;
                    $departman="";
                    $proje_=[];
                    if($_GET){


                        if(!empty($_GET['departman'])){
                            $departman = explode(',',$_GET['departman']);
                        }
                        if(!empty($_GET['proje'])){
                            $proje_ = explode(',',$_GET['proje']);
                        }
                    }


                    foreach ($employee as $row) {
                        if(!empty($_GET)){
                            if(!empty($_GET['departman'])){
                                $dept = explode(',',$_GET['departman']);
                                foreach ($dept as $val){
                                    if($val==$row['dept']){
                                        $aid = $row['id'];
                                        $username = $row['username'];
                                        $name = $row['name'];
                                        $firma_durumu = $row['firma_durumu'];
                                        $proje = proje_name($row['proje_id']);
                                        $role = roles($row['roleid']);
                                        $maas = $row['salary'];
                                        $resmi_maas = $row['resmi_maas'];
                                        $gayti_resmi_maas = $row['gayri_resmi_maas'];
                                        $departman = personel_depertman($row['dept'])['val1'];
                                        $avans_banka = avans($row['id'],3)['avans'];
                                        $avans_nakit = avans($row['id'],1)['avans'];
                                        $nakit_kalan = floatval($gayti_resmi_maas)-floatval($avans_nakit);
                                        $banka_kalan = floatval($resmi_maas)-floatval($avans_banka);

                                        $gayri_resmi_maas_total+=$gayti_resmi_maas;
                                        $resmi_maas_total+=$resmi_maas;
                                        $maas_total+=$maas;
                                        $toplam_banka_avans+=$avans_banka;
                                        $toplam_nakit_avans+=$avans_nakit;
                                        if($firma_durumu!=''){
                                            $b_resmi_maas_total+=$resmi_maas;
                                        }

                                        echo "<tr>
                                                <td><td>".$row['id']."</td></td>
                                                 <td>$name</td>
                                                <td>$firma_durumu</td>
                                                <td>$proje</td>
                                                <td>$departman</td>
                                                <td>$maas</td>
                                                <td>$gayti_resmi_maas</td>
                                                <td>$resmi_maas</td>
                                                <td>$avans_banka</td>
                                                <td>$avans_nakit</td>
                                                <td>$banka_kalan</td>
                                                <td>$nakit_kalan</td>
                                                                 ";
                                        $i++;
                                    }
                                }
                            }
                            if(!empty($_GET['proje'])){
                                $proje_ = explode(',',$_GET['proje']);
                                foreach ($proje_ as $val){
                                    if($val==$row['proje_id']){
                                        $aid = $row['id'];
                                        $username = $row['username'];
                                        $name = $row['name'];
                                        $firma_durumu = $row['firma_durumu'];
                                        $proje = proje_name($row['proje_id']);
                                        $role = roles($row['roleid']);
                                        $maas = $row['salary'];
                                        $resmi_maas = $row['resmi_maas'];
                                        $gayti_resmi_maas = $row['gayri_resmi_maas'];
                                        $departman = personel_depertman($row['dept'])['val1'];
                                        $avans_banka = avans($row['id'],3)['avans'];
                                        $avans_nakit = avans($row['id'],1)['avans'];
                                        $nakit_kalan = floatval($gayti_resmi_maas)-floatval($avans_nakit);
                                        $banka_kalan = floatval($resmi_maas)-floatval($avans_banka);

                                        $gayri_resmi_maas_total+=$gayti_resmi_maas;
                                        $resmi_maas_total+=$resmi_maas;
                                        $maas_total+=$maas;
                                        $toplam_banka_avans+=$avans_banka;
                                        $toplam_nakit_avans+=$avans_nakit;
                                        if($firma_durumu!=''){
                                            $b_resmi_maas_total+=$resmi_maas;
                                        }

                                        echo "<tr>
                                                <td>".$row['id']."</td>
                                                 <td>$name</td>
                                                <td>$firma_durumu</td>
                                                <td>$proje</td>
                                                <td>$departman</td>
                                                <td>$maas</td>
                                                <td>$gayti_resmi_maas</td>
                                                <td>$resmi_maas</td>
                                                <td>$avans_banka</td>
                                                <td>$avans_nakit</td>
                                                <td>$banka_kalan</td>
                                                <td>$nakit_kalan</td>
                                                                 ";
                                        $i++;
                                    }
                                }
                            }
                        }
                        else {
                            $aid = $row['id'];
                            $username = $row['username'];
                            $name = $row['name'];
                            $firma_durumu = $row['firma_durumu'];
                            $proje = proje_name($row['proje_id']);
                            $role = roles($row['roleid']);
                            $maas = $row['salary'];
                            $resmi_maas = $row['resmi_maas'];
                            $gayti_resmi_maas = $row['gayri_resmi_maas'];
                            $departman = personel_depertman($row['dept'])['val1'];
                            $avans_banka = avans($row['id'],3)['avans'];
                            $avans_nakit = avans($row['id'],1)['avans'];
                            $nakit_kalan = floatval($gayti_resmi_maas)-floatval($avans_nakit);
                            $banka_kalan = floatval($resmi_maas)-floatval($avans_banka);

                            $gayri_resmi_maas_total+=$gayti_resmi_maas;
                            $resmi_maas_total+=$resmi_maas;
                            $maas_total+=$maas;
                            $toplam_banka_avans+=$avans_banka;
                            $toplam_nakit_avans+=$avans_nakit;
                            if($firma_durumu!=''){
                                $b_resmi_maas_total+=$resmi_maas;
                            }

                            echo "<tr>
                                                <td>".$row['id']."</td>
                                                 <td>$name</td>
                                                <td>$firma_durumu</td>
                                                <td>$proje</td>
                                                <td>$departman</td>
                                                <td>$maas</td>
                                                <td>$gayti_resmi_maas</td>
                                                <td>$resmi_maas</td>
                                                <td>$avans_banka</td>
                                                <td>$avans_nakit</td>
                                                <td>$banka_kalan</td>
                                                <td>$nakit_kalan</td>
                                                                 ";
                            $i++;
                        }

                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th><?php echo amountFormat($b_resmi_maas_total) ?></th>
                        <th></th>
                        <th></th>
                        <th><?php echo amountFormat($maas_total);?></th>
                        <th><?php echo amountFormat($gayri_resmi_maas_total);?></th>
                        <th><?php echo amountFormat($resmi_maas_total);?></th>
                        <th><?php echo amountFormat($toplam_banka_avans);?></th>
                        <th><?php echo amountFormat($toplam_nakit_avans);?></th>
                        <th><?php echo amountFormat(floatval($resmi_maas_total)-floatval($toplam_banka_avans));?></th>
                        <th><?php echo amountFormat(floatval($gayri_resmi_maas_total)-floatval($toplam_nakit_avans));?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {



        //datatables
        $('#emptable').DataTable({
            responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                }
            ],
        });


    });

    $('.filter').on('change',function (){
        let val = $(this).val();
        let filter_search = $(this).attr('filter_search');


        var queries = [];


        if(val!=0){

            $.each(document.location.search.substr(1).split('&'),function(c,q){
                var i = q.split('=');
                if(i!=''){

                    queries.push({
                        'filter_search' : i[0].toString(),
                        'val' :  i[1].toString()
                    })

                }
            });

            let url = '?';

            if(queries.length > 0){
                for (let k=0; k < queries.length; k++){
                    if(filter_search!=queries[k].filter_search){
                        url+='&'+queries[k].filter_search+'='+queries[k].val;
                    }

                }
                url+= '&'+filter_search+'='+val;
            }
            else {
                url+= filter_search+'='+val;
            }


            //console.log(url);
            window.location.href= url;

        }
        else {
            window.location.href= "/employee/personel_report";
        }


    })

    $('.delemp').click(function (e) {
        e.preventDefault();
        $('#empid').val($(this).attr('data-object-id'));


    });
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

<div id="pop_model_alacaklandirma" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">İşlem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_alacak">

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Personeli Seçiniz</label><br>
                        <select style="width: 300px" class="form-control select-box" name="alacak_pers_id">
                            <option>Seçiniz</option>
                            <?php foreach (personel_list() as $pers){
                                echo "<option value='".$pers['id']."'>".$pers['name']."</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tutar</label>
                        <input class="form-control" type="text" name="alacak_tutar">
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tip</label>
                        <select name="alacakak_borc" class="form-control" id="alacakak_borc">
                            <?php foreach (personel_alacak_borc() as $acc)
                            {
                                echo "<option value='$acc->id'>$acc->description</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Metod</label>
                        <select name="alacak_metod" class="form-control" id="paymethod">
                            <?php foreach (account_type_islem() as $acc)
                            {
                                echo "<option value='$acc->id'>$acc->name</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Not</label>
                        <input class="form-control" name="alacak_not" type="text">
                    </div>

                    <br>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url-alacak" value="employee/pers_alacaklandir">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_alacak"><?php echo $this->lang->line('Yes') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

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
</script>
