<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">


                    <div class="col-sm-12 cmp-pnl">


                        <div class="inner-cmp-pnl">


                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="fis_no" class="caption">Cari Tipi</label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <?php if(isset($edit_data))
                                        { ?>
                                            <select class="form-control" name="invoice_type" id="invoice_type">
                                                <?php foreach (forma2_invoice_type() as $type) {
                                                    if ($edit_data['invoice_type_id'] == $type->id) {
                                                        echo "<option selected value='$type->id'>$type->description</option>";
                                                    } else {
                                                        echo "<option value='$type->id'>$type->description</option>";
                                                    }
                                                }
                                                ?>        </select> <?php



                                        } else { ?>
                                            <select class="form-control" name="invoice_type" id="invoice_type">
                                                <?php foreach (forma2_invoice_type() as $type){
                                                    echo "<option value='$type->id'>$type->description</option>";
                                                } ?>
                                            </select>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="customer_name" class="caption">Cari</label>



                                    <?php
                                    $names='';
                                    if(isset($edit_data)){

                                        $names=customer_details($edit_data['csd'])['company'];
                                        ?>

                                        <?

                                    }?>

                                    <input type="text" class="form-control required" id="customer_fis"
                                           placeholder="Cari" value="<?php echo $names ?>"
                                           autocomplete="off"/>

                                    <div id="customer-box-result-2"></div>

                                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo  $edit_data['csd'] ?>">

                                </div>


                                <div class="col-sm-1"><label for="fis_no"
                                                             class="caption">Ödemeler</label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>


                                        <button class="btn btn-warning" id="pay_list_edit" form_id="<?php echo $forma_2_id?>" type="button" >Ödemeleri Getir</button>
                                    </div>
                                </div>



                                <div class="col-sm-1"><label for="fis_no" class="caption"><?php echo $this->lang->line('muqavele_no') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>

                                        <select class="form-control select-box" id="hizmet_protokol" multiple name="hizmet_protokol[]">
                                            <?php
                                            if(protokoller($edit_data['csd'])){

                                                foreach (protokoller($edit_data['csd']) as $value){

                                                    if(in_array($value->id,$muqavele))
                                                    {
                                                        ?>
                                                        <option selected value="<?php echo $value->id; ?>" > <?php echo $value->code?></option>
                                                        <?
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <option value="<?php echo $value->id; ?>"> <?php echo $value->code?></option>
                                                        <?
                                                    }

                                                }

                                            }



                                            ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-sm-2">
                                    <label for="customer_name"class="caption">Fatura Durumu</label>
                                    <select class="form-control " id="invoice_durumu" name="invoice_durumu">
                                        <?php if(isset($edit_data)){ ?>
                                            <?php if($edit_data['refer']==1){ ?>
                                                <option selected value="1">Fatura Kesildi</option>
                                                <option value="2">Fatura Kesilmedi</option>
                                            <?php } else if($edit_data['refer']==2)
                                            {
                                                ?>
                                                <option  value="1">Fatura Kesildi</option>
                                                <option selected value="2">Fatura Kesilmedi</option>
                                                <?php
                                            }

                                        }
                                        else
                                        {
                                            ?>
                                            <option  value="1">Fatura Kesildi</option>
                                            <option  value="2">Fatura Kesilmedi</option>
                                            <?php
                                        } ?>
                                    </select>

                                </div>





                                <div class="col-sm-2">
                                    <label for="fis_date" class="caption"><?php echo $this->lang->line('form2_date'); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" data-toggle="editdatepicker" class="form-control  required"
                                               placeholder="Fiş Tarihi" name="fis_date" value="<?php echo isset($edit_data['invoicedate'])?dateformat($edit_data['invoicedate']):'' ?>"
                                        >
                                    </div>
                                </div>
                                <div class="col-sm-2">

                                    <label for="fis_name" class="caption"><?php echo $this->lang->line('sorumlu_personel'); ?></label>
                                    <select name="sorumlu_pers_id" class="form-control select-box required">
                                        <option value="">Seçiniz</option>
                                        <?php foreach ($emp as $pers) {
                                            $cid=$pers['id'];
                                            $cname=$pers['name'];
                                            if($cid==$edit_data['sorumlu_pers_id'])
                                            {
                                                ?>
                                                <option selected value="<?php echo $cid; ?>"> <?php echo $cname?></option>
                                                <?php
                                            }else
                                            {
                                                ?>
                                                <option value="<?php echo $cid; ?>"><?php echo $cname?></option>
                                                <?php
                                            }
                                            ?>

                                        <?php } ?>
                                    </select>

                                </div>


                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="taxformat" class="caption">P. Sorumlusu</label>
                                    <select class="form-control select-box proje_sorumlu_id required" name="proje_sorumlu_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];

                                            if($edit_data['proje_sorumlu_id']==$emp_id)
                                            {
                                                echo "<option selected value='$emp_id'>$name</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='$emp_id'>$name</option>";
                                            }

                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label for="taxformat" class="caption">Proje Müdürü</label>
                                    <select class="form-control select-box proje_muduru_id" name="proje_muduru_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];

                                            if($edit_data['proje_muduru_id']==$emp_id)
                                            {
                                                echo "<option selected value='$emp_id'>$name</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='$emp_id'>$name</option>";
                                            }

                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2">

                                    <label for="taxformat" class="caption">Genel Müdürü</label>
                                    <select class="form-control select-box genel_mudur_id" name="genel_mudur_id">

                                        <?php foreach (personel_list() as $emp){
                                            $emp_id=$emp['id'];
                                            $name=$emp['name'];

                                            if($edit_data['genel_mudur_id']==$emp_id)
                                            {
                                                echo "<option selected value='$emp_id'>$name</option>";
                                            }
                                            else
                                            {
                                                echo "<option value='$emp_id'>$name</option>";
                                            }

                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="fis_note"
                                           class="caption"><?php echo $this->lang->line('forma2_note') ?></label>
                                    <textarea class="form-control " name="fis_note"  rows="1"><?php echo isset($edit_data['notes'])?$edit_data['notes']:'' ?></textarea>
                                </div>

                                <div class="col-sm-3">
                                    <label for="fis_note"
                                           class="caption">Muqavele No</label>
                                    <input class="form-control required" value="<?php echo isset($edit_data['muqavele_no'])?$edit_data['muqavele_no']:'' ?>" name="muqavele_no_new">
                                </div>
                            </div>

                        </div>
                    </div>



                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">

                            <thead>
                            <tr class="item_header bg-gradient-directional-light">
                                <th width="15%" class="text-center"><?php echo $this->lang->line('proje_yerleri') ?></th>
                                <th width="15%" class="text-center"><?php echo $this->lang->line('Milestones Title') ?></th>
                                <th width="30%" class="text-center"><?php echo $this->lang->line('gorulmus_isler') ?></th>
                                <th width="10%" class="text-center">Açıklama</th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('forma_2_unit') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('forma_2_quantity') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('forma_2_qiymet') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('forma_2_cemi') ?></th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

                            </thead>
                            <tbody>

                            <?php
                            $i =0;
                            foreach ($products as $prd){
                                ?>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control text-center bolum" name="bolum[]" disabled id="bolum-<?php echo $i; ?>"
                                               value="<?php echo bolum_getir($prd->bolum_id) ?>" >
                                        <input type="hidden" name="bolum_id[]" id="bolum_id_val-<?php echo $i; ?>" value="<?php echo $prd->bolum_id ?>">
                                    </td>

                                    <td><input type="text" class="form-control text-center asama" name="asama[]"  disabled id="asama-<?php echo $i; ?>"
                                               value="<?php echo task_to_asama($prd->asama_id) ?>" >
                                        <input type="hidden" name="asama_id[]" id="asama_id_val-<?php echo $i; ?>" value="<?php echo $prd->asama_id ?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control text-center"  value="<?php echo $prd->product ?>" disabled>
                                        <input type="hidden"  name="product_name[]" value="<?php echo $prd->product ?>"
                                               placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-<?php echo $i; ?>'>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control req item_desc" name="item_desc[]" id="item_desc-<?php echo $i; ?>"
                                               value="<?php echo $prd->item_desc ?>">

                                    </td>
                                    <td>

                                        <?php
                                        $birim_name='';
                                        $birim_id='';

                                        foreach (units() as $birimler){
                                            if($birimler['id']==$prd->unit){
                                                $birim_name=$birimler['name'];
                                                $birim_id=$birimler['id'];
                                                ?>

                                                <input type="text" class="form-control req" disabled value="<?php echo $birimler['name'] ?>">
                                                <input type="hidden"  name="unit_id[]"  class="form-control req" value="<?php echo $birimler['id'] ?>">
                                                <?
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><input type="text" class="form-control req amnt qiymet_hesap" indexval="<?php echo $i; ?>" name="product_qty[]" id="product_qty-<?php echo $i; ?>"
                                               autocomplete="off" value="<?php echo round($prd->qty,2) ?>">

                                    </td>

                                    <td><input type="text" class="form-control req unt" id="qiymet-<?php echo $i; ?>" disabled value="<?php echo $prd->price ?>">
                                        <input type="hidden" name="product_qiymet[]" id="qiymetval-<?php echo $i; ?>"  value="<?php echo $prd->price ?>">
                                    </td>


                                    <td>
                                        <input type="text" class="form-control req unt" disabled id="cemi-<?php echo $i; ?>" value="<?php echo $prd->subtotal ?>">
                                        <input type="hidden" class="form-control req unt"  name="product_cemi[]" id="cemival-<?php echo $i; ?>" value="<?php echo $prd->subtotal ?>">
                                        <input type="hidden" class="pdIn" name="pid[]" id="pid-<?php echo $i; ?>" value="<?php echo $prd->pid ?>">
                                    </td>



                                    <td class="text-center">
                                        <button type="button" data-rowid='<?php echo $i; ?>' class="btn btn-danger removeProd btn-sm"  title="Remove" ><i class="fa fa-minus-square "></i> </button>
                                        <button type="button" data-rowid="<?php echo $i; ?>" class="btn btn-warning clones btn-sm" title="Kopyala"
                                                proje_id="<?php echo $prd->proje_id ?>"  bolum_id="<?php echo $prd->bolum_id ?>" asama="<?php echo task_to_asama($prd->asama_id) ?>" asama_id="<?php echo $prd->asama_id ?>" bolum="<?php echo bolum_getir($prd->bolum_id) ?>"
                                                product_name="<?php echo $prd->product ?>" item_desc="" total_fiyat="<?php echo $prd->subtotal ?>" unit_name="<?php echo $birim_name; ?>"
                                                birim_fiyati="<?php echo $prd->price ?>" quantity="<?php echo round($prd->qty,2) ?>" pid="<?php echo $prd->pid ?>" unit_id="<?php echo $prd->unit; ?>" > <i class="fa fa-clone"></i> </button>
                                    </td>
                                </tr>
                                <?php  $i++; }
                            ?>

                            <tr class="last-item-row sub_c">

                            </tr>

                            </tbody>


                        </table>
                        <tabl>
                            <tr class="sub_c" style="display: table-row;">

                                <td align="right" colspan="9"><input type="submit" class="btn btn-success sub-btn btn-lg"
                                                                     value="<?php echo isset($id)?$this->lang->line('edit_fis'):$this->lang->line('save_fis'); ?> "
                                                                     id="submit-data-forma2" data-loading-text="Creating...">

                                </td>
                            </tr>
                        </tabl>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <?php
                    $pay_array_value =0;
                    $price_array =0;
                    $pay_array_value =$pay_array;
                    $price_array =$price_ar;
                    ?>
                    <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
                    <input type="hidden" value="<?php echo $id; ?>" name="forma_2_id" id="forma_2_id">
                    <input type="hidden" value="invoices/forma_2_update" id="action-url">

                    <input type="hidden" value="search_form_2" id="billtype">
                    <input type="hidden" value="search_newproducts" id="billtype2">
                    <input type="hidden" id="pay_array" value="<?php  echo $pay_array_value ?>" name="pay_array">
                    <input type="hidden" id="price_array" value="<?php  echo $price_array ?>" name="price_array">



                </form>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 100%;height: 100%;margin: 0;padding: 0;" role="document">
        <div class="modal-content " style="height: auto;min-height: 100%;border-radius: 0;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">İş Hacimleri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="todotable"class="table table-striped table-bordered zero-configuration" width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipi</th>
                        <th>Adı</th>
                        <th>Bölüm</th>
                        <th>Bağlı Olduğu Aşama</th>
                        <th>Aşama</th>
                        <th>Fiyat</th>
                        <th>Birim</th>
                        <th>Miktar</th>
                        <th>Oran</th>
                        <th>Toplam Fiyat</th>
                        <!--th>Başlangıç Tarihi</-th>
                        <th>Bitiş Tarihi</th-->
                        <th>Anlık Maliyet</th>
                        <th>Sorumlu Personel</th>
                        <th>Cari / Firma</th>
                        <th><?php echo $this->lang->line('Status') ?></th>


                    </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                <button type="button" id="liste_create" class="btn btn-primary">Seçilenleri Listeye Ekle</button>
            </div>
        </div>
    </div>
</div>
<script>

    let _serials;

    var rowTotal_form = function (numb)
    {
        var amountVal = formInputGet("#product_qty", numb);
        var priceVal = formInputGet("#qiymet", numb);



        var totalValue=parseFloat(amountVal)*parseFloat(priceVal);

        var totalID = "#cemi-" + numb;
        var totalID = "#cemi_val-" + numb;
        $(totalID).val(totalValue);
    }


    $("#customer_fis").keyup(function () {

        var cari_type=1;
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchform',
            data: 'keyword=' + $(this).val() +'&'+'cari_type=' + cari_type+'&'+crsf_token+'='+crsf_hash,
            beforeSend: function () {
                $("#customer_fis").css("backg", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result-2").show();
                $("#customer-box-result-2").html(data);
                $("#customer_fis").css("backg", "none");

            }
        });
    });

    function selectProjectFis(cid, company) {

        $('#proje_id').val(cid);
        $('#proje_name').val(company);
        $("#customer-box-result").hide();


    }

    function selectCustomerFis(cid, company) {

        $('#customer_id').val(cid);
        $('#customer_fis').val(company);
        $("#customer-box-result-2").hide();

        let data = {
            crsf_token: crsf_hash,
            customer_id: cid,
        }

        $.post(baseurl + 'invoices/customer_pay_list',data,(response) => {
            let responses = jQuery.parseJSON(response);
            let  table='';
            if(responses.cari_protokol.length > 0){
                $('#hizmet_protokol').empty().append('<option value="">Seçiniz</option>');;
                responses.cari_protokol.forEach((item_,index) => {

                    $('#hizmet_protokol').append('<option value="'+item_.id+'">'+item_.code+'</option>');;
                })

                $.confirm({
                    theme: 'material',
                    closeIcon: true,
                    title: 'Cari Ödemeleri Listesi',
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
                            '<label>Cari Ödemeleri</label>' +
                            '<div id="cari_table"></div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        let data = {
                            crsf_token: crsf_hash,
                            customer_id: cid,
                        }

                        $.post(baseurl + 'invoices/customer_pay_list',data,(response) => {
                            self.$content.find('#person-list').empty().append(html);
                            let responses = jQuery.parseJSON(response);
                            let  table='';


                            if(responses.count!=0){
                                table =`<table class="table"><thead><tr>
                    <td>#</td>
                    <td>Tutar</td>
                    <td>Onaylanan Tutar</td>
                    <td>Tip</td>
                    <td>Not</td>
                    <td>Tarih</td>
                    </tr>`;

                                let pay_array = $('#pay_array').val();
                                let arr = pay_array.split(',');




                                responses.data.forEach((item_,index) => {
                                    let checked = '';
                                    if(jQuery.inArray(item_.id, arr) !== -1){
                                        checked = 'checked';
                                    }
                                    table+=`<tr>
                                <td><input `+checked+` type="checkbox" class="form-control name transaction_id" name="transaction_id[]" value="`+item_.id+`"></td>
                                <td>`+item_.amount+`</td>
                                <td><input value="`+item_.total+`" class="form-control onaylanan_tutar" name="onaylanan_tutar[]"></td>
                                <td>`+item_.tip+`</td>
                                <td>`+item_.notes+`</td>
                                <td>`+item_.date+`</td>
                            </tr>`;
                                })
                                table +=`</tbody></table>`
                            }
                            else {
                                table='<p style="text-align: center">Herhangi Bir Ödeme Bulunamadı</p>';
                            }

                            $('#cari_table').empty().html(table);

                        });


                        self.$content.find('#person-list').empty().append(html);
                        return $('#person-container').html();
                    },
                    onContentReady:function (){
                    },
                    buttons: {
                        formSubmit: {
                            text: 'Seçili Olanları Forma2 ye Bağla ',
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

                                let id=[];
                                let length = $("input[type='checkbox']:checked").length;
                                if(length > 0 ){
                                    for(let i = 0; i< length; i++){
                                        id.push ($("input[type='checkbox']:checked").eq(i).val() );
                                    }

                                    $('#pay_array').val(id);

                                    $.alert({
                                        theme: 'material',
                                        icon: 'fa fa-exclamation',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Başarılı!',
                                        content: 'Başarılı Bir Şekilde Seçildi',
                                        buttons:{
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }

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
                $('#hizmet_protokol').empty().append('<option value="">Protokol Mevcut Değil</option>');;
                alert("Protokol Mevcut Değil");
                return false;
            }


        });

    }

    $(document).on('change','#hizmet_protokol',function (e) {
        let id = $(this).val();
        let selected_id = [];
        let data_post = {
            crsf_token: crsf_hash,
            id: id,
        }
        $.post(baseurl + 'razilastirma/get_item',data_post,(response) => {
            let responses = jQuery.parseJSON(response);
            let  table='';
            if(responses.details.length > 0){
                let count=0;
                if(parseInt($('#ganak').val())!=0){
                    count = $('#ganak').val();
                    $('.my_stripe tbody tr td').remove()
                }
                else {
                    $('#ganak').val(0);
                    $('.my_stripe tbody tr').eq(0).remove()
                }

                let i = 0;
                responses.details.forEach((item_,index) => {
                    let data_post_v = {
                        crsf_token: crsf_hash,
                        asama_id: item_.asama_id,
                        unit: item_.unit,
                    }
                    let ana_asama_name='';
                    let unit_name_s='';
                    $.post(baseurl + 'razilastirma/get_item_details',data_post_v,(response_item) => {
                        let value = jQuery.parseJSON(response_item);
                        ana_asama_name = value.ana_asama_adi;
                        unit_name_s = value.unit_n;
                        var cvalue = parseInt(i);
                        var functionNum = "'" + cvalue + "'";
                        let pid=item_.id;
                        let bolum=item_.bolum_adi;
                        let bolum_id=item_.bolum_id;
                        let asama=ana_asama_name;
                        let asama_id=item_.asama_id;
                        let product_name=item_.name;
                        let item_desc='';
                        let proje_id=item_.proje_id;
                        let birim_fiyati=item_.r_price;
                        let quantity=item_.r_qty;
                        let total_fiyat=parseFloat(item_.r_qty)*parseFloat(item_.r_price);
                        let unit_id=item_.r_unit_id;
                        let unit_name=item_.r_unit_name;

                        var data = '<tr>' +
                            '<td><input type="text" class="form-control text-center bolum" disabled name="bolum[]"'+
                            'value="'+bolum+'" id="bolum-' + cvalue + '">   <input type="hidden" name="bolum_id[]" value="'+bolum_id+'" id="bolum_id_val-' + cvalue + '" class="bolum_id"> </td>'+
                            '<td><input type="text" class="form-control text-center asama" disabled name="asama[]"'+
                            'placeholder="<?php echo $this->lang->line('Milestones Title') ?>" value="'+asama+'" id="asama-' + cvalue + '">  <input type="hidden" value="'+asama_id+'" name="asama_id[]" id="asama_id_val-' + cvalue + '"> </td>'+
                            '<td><input type="text" class="form-control text-center"' +
                            'placeholder="Ürün Adını veya Kodunu Giriniz" disabled id="productnames-' + cvalue + '" value="'+product_name+'"></td><td><input type="text" class="form-control text-center" name="item_desc[]" ' +
                            'placeholder="Açıklama" id="item_desc-' + cvalue + '" value="'+item_desc+'"></td><td><input type="text" ' +
                            'class="form-control req unt" value="'+unit_name+'" disabled name="product_unit[]" id="units-' + cvalue + '" onkeypress="return isNumber(event)" ' +
                            'autocomplete="off"></td>' +
                            '<td>' +
                            '<input type="numaric" class="form-control amnt qiymet_hesap" indexval="'+cvalue+'" value="'+quantity+'" name="product_qty[]"  id="product_qty-' + cvalue + '" >' +
                            '</td> ' +
                            '<td><input type="number" class="form-control req unt qiymet_hesap product_qiymet" indexval="'+cvalue+'"  disabled  max_num="'+birim_fiyati+'" value="'+birim_fiyati+'" id="qiymet-' + cvalue + '"></td>'+
                            '<td><input type="text" class="form-control req unt" disabled  value="'+total_fiyat+'" id="cemi-' + cvalue + '"></td>'+
                            '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd btn-sm" title="Remove" >' +
                            ' <i class="fa fa-minus-square"></i> </button> <button type="button" data-rowid="' + cvalue + '" ' +
                            'class="btn btn-warning clone btn-sm" title="Kopyala" proje_id="'+proje_id+'"  bolum_id="'+bolum_id+'" asama="'+asama+'" asama_id="'+asama_id+'" bolum="'+bolum+'" product_name="'+product_name+'" item_desc="'+item_desc+'" total_fiyat="'+total_fiyat+'" unit_name="'+unit_name+'" birim_fiyati="'+birim_fiyati+'" quantity="'+quantity+'" pid="'+pid+'" unit_id="'+unit_id+'" birim_fiyati="'+birim_fiyati+'" >' +
                            ' <i class="fa fa-clone"></i> </button> </td>' +

                            '<input type="hidden" value="'+pid+'"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
                            '<input type="hidden" value="'+unit_id+'" name="unit_id[]" id="unit_id-' + cvalue + '">'+
                            '<input type="hidden" name="product_qiymet[]" value="'+birim_fiyati+'">'+
                            '<input type="hidden" name="product_name[]" value="'+product_name+'">'+
                            '<input type="hidden" name="product_cemi[]" id="cemi_val-' + cvalue + '" value="'+total_fiyat+'">'+

                            '</tr>';
                        //ajax request
                        // $('#saman-row').append(data);
                        $('tr.last-item-row').before(data);
                        i++;

                    })


                })


            }


        });



    })

    $(document).on('click', '.clone', function (e) {
        let eq = $(this).attr("data-rowid");
        let proje_id = $(this).attr("proje_id");
        let bolum_id = $(this).attr("bolum_id");
        let asama = $(this).attr("asama");
        let asama_id = $(this).attr("asama_id");
        let bolum = $(this).attr("bolum");
        let product_name = $(this).attr("product_name");
        let item_desc = $(this).attr("item_desc");
        let total_fiyat = $(this).attr("total_fiyat");
        let unit_name = $(this).attr("unit_name");
        let birim_fiyati = $(this).attr("birim_fiyati");
        let quantity = $(this).attr("quantity");
        let pid = $(this).attr("pid");
        let unit_id = $(this).attr("unit_id");


        let data_post_ = {
            crsf_token: crsf_hash,
            bolum_id: bolum_id,
            proje_id: proje_id,
        }
        let options = '';
        $.post(baseurl + 'projects/asamalar_list_ajax',data_post_,(response) => {
            let responses = jQuery.parseJSON(response);

            console.log(responses.birimler);
            $.each(responses.birimler,function (index){
                options+=`<option value='`+responses.birimler[index].id+`'>`+responses.birimler[index].name+`</option>`;
            })
        })




        setTimeout(function(){
            let cvalue = parseFloat(eq)+1;
            var data = '<tr>' +
                '<td><input type="text" class="form-control text-center bolum" disabled name="bolum[]"'+
                'value="'+bolum+'" id="bolum-' + cvalue + '">   <input type="hidden" name="bolum_id[]" value="'+bolum_id+'" id="bolum_id_val-' + cvalue + '" class="bolum_id"> </td>'+
                '<td><select class="form-control select-box asama" name="asama_id[]" eq="'+cvalue+'">'+options+'</select></td>'+
                '<td><input type="text" class="form-control text-center"' +
                'placeholder="Ürün Adını veya Kodunu Giriniz" disabled id="productnames-' + cvalue + '" value="'+product_name+'"></td><td><input type="text" class="form-control text-center" name="item_desc[]" ' +
                'placeholder="Açıklama" id="item_desc-' + cvalue + '" value="'+item_desc+'"></td><td><input type="text" ' +
                'class="form-control req unt" value="'+unit_name+'" disabled name="product_unit[]" id="units-' + cvalue + '" onkeypress="return isNumber(event)" ' +
                'autocomplete="off"></td>' +
                '<td>' +
                '<input type="numaric" class="form-control amnt qiymet_hesap" indexval="'+cvalue+'" value="'+quantity+'" name="product_qty[]"  id="product_qty-' + cvalue + '" >' +
                '</td> ' +
                '<td><input type="number" class="form-control req unt qiymet_hesap product_qiymet" name="product_qiymet[]"  indexval="'+cvalue+'"   max_num="'+birim_fiyati+'" value="'+birim_fiyati+'"  onkeyup="rowTotal_form(' + cvalue + ')" id="qiymet-' + cvalue + '"></td>'+
                '<td><input type="text" class="form-control req unt" disabled  value="'+total_fiyat+'" id="cemi-' + cvalue + '"></td>'+
                '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger btn-sm removeProd" title="Remove" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td>' +

                '<input type="hidden" value="'+pid+'"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
                '<input type="hidden" value="'+unit_id+'" name="unit_id[]" id="unit_id-' + cvalue + '">'+
                '<input type="hidden" name="product_name[]" value="'+product_name+'">'+
                '<input type="hidden" name="product_cemi[]" id="cemi_val-' + cvalue + '" value="'+total_fiyat+'">'+

                '</tr>';
            //ajax request
            // $('#saman-row').append(data);
            $('tr.last-item-row').before(data);
        }, 1000);
    })




    $("#submit-data-forma2").on("click", function(e) {
        e.preventDefault();
        var o_data =  $("#data_form").serialize();
        var action_url= $('#action-url').val();
        addObject_forma2(o_data,action_url);
    });
    function addObject_forma2(action,action_url) {
        var errorNum = farmCheck();
        var $btn;
        if (errorNum > 0) {
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("#notify .message").html("<strong>Hata</strong>: Lüten Zorunlu Alanları Doldurunuz!!");
            $("html, body").scrollTop($("body").offset().top);
        } else {

            let _serials = localStorage.getItem('pay_history');

            if(_serials) {
                _serials = JSON.parse(_serials);
            }
            let id = [];
            let price = [];
            if(!_serials==null){
                for(let i = 0; i < _serials[0]['id'].length;i++){
                    id.push(_serials[0]['id'][i]);
                    price.push(_serials[0]['price'][i]);
                }
            }

            console.log(price);
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: 'price='+price+'&'+'pay_id='+id+'&'+action+'&'+crsf_token+'='+crsf_hash,
                dataType: 'json',
                beforeSend: function () {
                    $("#submit-data").attr("disabled","true");
                },
                success: function (data) {
                    if (data.status == "Success") {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $("#data_form").remove();
                        $("#submit-data").prop('disabled',false);
                    } else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                        $("#submit-data").prop('disabled',false);
                    }

                    $("#submit-data").prop('disabled',false);
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#submit-data").prop('disabled',false);

                }
            });
        }
    }

    $(document).on('keyup', '.qiymet_hesap', function (e) {
        let eq = $(this).attr("indexval");

        var amountVal = formInputGet("#product_qty", eq);
        var priceVal = formInputGet("#qiymet", eq);
        let max = document.getElementById("qiymet-"+eq).attributes.max_num.value

        if(parseFloat(priceVal) > parseFloat(max)){
            document.getElementById("qiymet-"+eq).value=parseFloat(max)
            return false;
        }

        var totalValue=parseFloat(amountVal)*parseFloat(priceVal);

        var totalID_ = "#cemi-" + eq;
        var totalID = "#cemi_val-" + eq;
        $(totalID).val(totalValue);
        $(totalID_).val(totalValue);
    })

    $('#pay_list_edit').on('click', function () {

        let cid = $('#customer_id').val();
        let invoice_id = $(this).attr('form_id');

        localStorage.clear();
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Cari Ödemeleri Listesi',
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
                html += '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Cari Ödemeleri</label>' +
                    '<div id="cari_table"></div>' +
                    '</div>' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    customer_id: cid,
                    invoice_id: invoice_id,
                }

                $.post(baseurl + 'invoices/customer_pay_list_edit', data, (response) => {
                    self.$content.find('#person-list').empty().append(html);
                    let responses = jQuery.parseJSON(response);
                    let table = '';
                    if (responses.count != 0) {
                        table = `<table class="table"><thead><tr>
                    <td>#</td>
                    <td>Tutar</td>
                    <td>Onaylanan Tutar</td>
                    <td>Tip</td>
                    <td>Not</td>
                    <td>Tarih</td>
                    </tr>`;


                        let pay_array = $('#pay_array').val();
                        let arr = pay_array.split(',');
                        responses.data.forEach((item_, index) => {
                            let checked = '';
                            if(jQuery.inArray(item_.id, arr) !== -1){
                                checked = 'checked';
                            }

                            table += `<tr>
                                <td><input ` + checked + ` type="checkbox"  index="`+index+`" class="form-control name transaction_id" name="transaction_id[]" value="` + item_.id + `"></td>
                                <td>` + item_.amount + `</td>
                                 <td><input value="`+item_.total+`" class="form-control onaylanan_tutar" name="onaylanan_tutar[]"></td>
                                <td>` + item_.tip + `</td>
                                <td>` + item_.notes + `</td>
                                <td>` + item_.date + `</td>
                            </tr>`;
                        })
                        table += `</tbody></table>`
                    } else {
                        table = '<p style="text-align: center">Herhangi Bir Ödeme Bulunamadı</p>';
                    }

                    $('#cari_table').empty().html(table);

                });


                self.$content.find('#person-list').empty().append(html);
                return $('#person-container').html();
            },
            onContentReady: function () {
            },
            buttons: {
                formSubmit: {
                    text: 'Seçili Olanları Forma2 ye Bağla ',
                    btnClass: 'btn-blue',
                    action: function () {
                        var name = this.$content.find('.name').val();
                        if (!name) {
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Tüm Alanlar Zorunludur',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                            return false;
                        }

                        let id = [];
                        let price = [];
                        let length = $("input[type='checkbox']:checked").length;
                        if (length > 0) {
                            for (let i = 0; i < length; i++) {
                                id.push($("input[type='checkbox']:checked").eq(i).val());
                                let index = $("input[type='checkbox']:checked").eq(i).attr('index');
                                price.push($(".onaylanan_tutar").eq(index).val());
                            }

                            let pay_history = (localStorage.getItem('pay_history') == null) ? localStorage.setItem('pay_history',JSON.stringify([])) : localStorage.getItem('pay_history');

                            _serials = JSON.parse(localStorage.getItem('pay_history'));
                            _serials.push({
                                id: id,
                                price: price
                            });
                            localStorage.setItem('pay_history',JSON.stringify(_serials));
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'green',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Başarılı!',
                                content: 'Başarılı Bir Şekilde Seçildi',
                                buttons: {
                                    prev: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-link text-dark",
                                    }
                                }
                            });
                        }

                    }
                },
                cancel: {
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


    $(document).ready(function (){

        $(".qiymet_hesap").keyup(function () {
            let eq = $(this).attr("indexval");
            var amountVal = formInputGet("#product_qty", eq);
            var priceVal = formInputGet("#qiymet", eq);

            var totalValue=parseFloat(amountVal)*parseFloat(priceVal);

            let max = document.getElementById("qiymet-"+eq).attributes.max_num.value

            if(parseFloat(priceVal) > parseFloat(max)){
                document.getElementById("qiymet-"+eq).value=parseFloat(max)
                return false;
            }
            var totalID_ = "#cemi-" + eq;
            var totalID = "#cemi_val-" + eq;
            $(totalID).val(totalValue);
            $(totalID_).val(totalValue);
        })

        $('.clones').on('click',function (){
            let eq = $(this).attr("data-rowid");
            let proje_id = $(this).attr("proje_id");
            let bolum_id = $(this).attr("bolum_id");
            let asama = $(this).attr("asama");
            let asama_id = $(this).attr("asama_id");
            let bolum = $(this).attr("bolum");
            let product_name = $(this).attr("product_name");
            let item_desc = $(this).attr("item_desc");
            let total_fiyat = $(this).attr("total_fiyat");
            let unit_name = $(this).attr("unit_name");
            let birim_fiyati = $(this).attr("birim_fiyati");
            let quantity = $(this).attr("quantity");
            let pid = $(this).attr("pid");
            let unit_id = $(this).attr("unit_id");


            let data_post_ = {
                crsf_token: crsf_hash,
                bolum_id: bolum_id,
                proje_id: proje_id,
            }
            let options = '';
            $.post(baseurl + 'projects/asamalar_list_ajax',data_post_,(response) => {
                let responses = jQuery.parseJSON(response);

                console.log(responses.birimler);
                $.each(responses.birimler,function (index){
                    options+=`<option value='`+responses.birimler[index].id+`'>`+responses.birimler[index].name+`</option>`;
                })
            })




            setTimeout(function(){

                let len = parseFloat($('.asama').length)-1;
                let cvalue = parseFloat(len)+parseFloat(1);
                var data = '<tr>' +
                    '<td><input type="text" class="form-control text-center bolum" disabled name="bolum[]"'+
                    'value="'+bolum+'" id="bolum-' + cvalue + '">   <input type="hidden" name="bolum_id[]" value="'+bolum_id+'" id="bolum_id_val-' + cvalue + '" class="bolum_id"> </td>'+
                    '<td><select class="form-control select-box asama" name="asama_id[]" eq="'+cvalue+'">'+options+'</select></td>'+
                    '<td><input type="text" class="form-control text-center"' +
                    'placeholder="Ürün Adını veya Kodunu Giriniz" disabled id="productnames-' + cvalue + '" value="'+product_name+'"></td><td><input type="text" class="form-control text-center" name="item_desc[]" ' +
                    'placeholder="Açıklama" id="item_desc-' + cvalue + '" value="'+item_desc+'"></td><td><input type="text" ' +
                    'class="form-control req unt" value="'+unit_name+'" disabled name="product_unit[]" id="units-' + cvalue + '" onkeypress="return isNumber(event)" ' +
                    'autocomplete="off"></td>' +
                    '<td>' +
                    '<input type="numaric" class="form-control amnt qiymet_hesap" indexval="'+cvalue+'" value="'+quantity+'" name="product_qty[]"  id="product_qty-' + cvalue + '" >' +
                    '</td> ' +
                    '<td><input type="number" class="form-control req unt product_qiymet qiymet_hesap" indexval="'+cvalue+'" name="product_qiymet[]"  max_num="'+birim_fiyati+'" value="'+birim_fiyati+'" id="qiymet-' + cvalue + '"></td>'+
                    '<td><input type="text" class="form-control req unt" disabled  value="'+total_fiyat+'" id="cemi-' + cvalue + '"></td>'+
                    '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger btn-sm removeProd" title="Remove" >' +
                    ' <i class="fa fa-minus-square"></i> </button> </td>' +

                    '<input type="hidden" value="'+pid+'"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
                    '<input type="hidden" value="'+unit_id+'" name="unit_id[]" id="unit_id-' + cvalue + '">'+
                    '<input type="hidden" name="product_name[]" value="'+product_name+'">'+
                    '<input type="hidden" name="product_cemi[]" id="cemi_val-' + cvalue + '" value="'+total_fiyat+'">'+

                    '</tr>';
                //ajax request
                // $('#saman-row').append(data);
                $('tr.last-item-row').before(data);
            }, 1000);
        })
    })


    $(document).on('keyup', '.qiymet_hesap', function (e) {
        let eq = $(this).attr("indexval");
        var amountVal = formInputGet("#product_qty", eq);
        var priceVal = formInputGet("#qiymet", eq);

        let max = document.getElementById("qiymet-"+eq).attributes.max_num.value

        if(parseFloat(priceVal) > parseFloat(max)){
            document.getElementById("qiymet-"+eq).value=parseFloat(max)
            return false;
        }

        var totalValue=parseFloat(amountVal)*parseFloat(priceVal);

        var totalID_ = "#cemi-" + eq;
        var totalID = "#cemi_val-" + eq;
        $(totalID).val(totalValue);
        $(totalID_).val(totalValue);
    })

</script>
