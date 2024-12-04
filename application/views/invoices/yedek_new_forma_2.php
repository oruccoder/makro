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
                                    <label for="fis_no" class="caption"><?php echo $this->lang->line('form_2_type') ?></label>

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

                                    <input type="text" class="form-control " id="customer_fis"
                                           placeholder="Cari" value="<?php echo $names ?>"
                                           autocomplete="off"/>

                                    <div id="customer-box-result-2"></div>

                                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo  isset($edit_data['csd'])?$edit_data['csd']:'' ?>">

                                </div>

                                <?php
                                $sm=3;
                                if(isset($edit_data)){
                                    $sm=1;
                                ?>
                                <div class="col-sm-2"><label for="fis_no"
                                                             class="caption">Forma2'ye Bağlanan Ödemeleri Düzenle</label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>


                                        <button class="btn btn-warning" id="pay_list_edit" form_id="<?php echo $_GET['id']?>" type="button" >Ödemeleri Getir</button>
                                    </div>
                                </div>
                                <?

                                }?>


                                <div class="col-sm-<?php echo $sm?>"><label for="fis_no"
                                                             class="caption"><?php echo $this->lang->line('muqavele_no') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control " placeholder="Muqavele No"
                                               name="fis_no"
                                               value="<?php echo isset($edit_data['invoice_no'])?$edit_data['invoice_no']:'' ?>">
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

                                <div class="col-sm-1">
                                    <label for="customer_name"class="caption">Ödeme Durumu</label>
                                    <select class="form-control " id="method" name="method">
                                        <?php if(isset($edit_data)){ ?>
                                            <?php if($edit_data['method']==1){ ?>
                                                <option selected value="1">Nakit</option>
                                                <option value="3">Banka</option>
                                            <?php } else if($edit_data['method']==3)
                                            {
                                                ?>
                                                <option  value="1">Nakit</option>
                                                <option selected value="3">Banka</option>
                                                <?php
                                            }
                                        }

                                        else
                                        {
                                            ?>
                                            <option  value="1">Nakit</option>
                                            <option  value="3">Banka</option>
                                            <?php
                                        } ?>
                                    </select>

                                </div>


                                <div class="col-sm-2">
                                    <label for="customer_name"class="caption">Proje</label>



                                    <?php
                                    $name='';
                                    if(isset($edit_data)){

                                        $name=proje_name($edit_data['proje_id']);

                                    }?>

                                    <input type="text" class="form-control " name="proje_name" id="proje_name"
                                           placeholder="Proje" value="<?php echo $name ?>"
                                           autocomplete="off"/>

                                    <div id="customer-box-result"></div>

                                    <input type="hidden" name="proje_id" id="proje_id" value="<?php echo  isset($edit_data['proje_id'])?$edit_data['proje_id']:'' ?>">

                                </div>






                            </div>
                            <div class="form-group row">



                                <div class="col-sm-2"><label for="fis_date"
                                                             class="caption"><?php echo $this->lang->line('form2_date'); ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                             aria-hidden="true"></span></div>

                                        <?php if(isset($edit_data['invoicedate'])) {?>
                                            <input type="text" data-toggle="editdatepicker" class="form-control  required"
                                                   placeholder="Fiş Tarihi" name="fis_date" value="<?php echo isset($edit_data['invoicedate'])?dateformat($edit_data['invoicedate']):'' ?>"
                                            >

                                        <?php } else { ?>
                                            <input type="text" class="form-control  required"
                                                   placeholder="Fiş Tarihi" name="fis_date"
                                                   data-toggle="datepicker"
                                            >
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="fis_note"
                                           class="caption"><?php echo $this->lang->line('forma2_note') ?></label>
                                    <textarea class="form-control " name="fis_note"  rows="2"><?php echo isset($edit_data['notes'])?$edit_data['notes']:'' ?></textarea>
                                </div>

                                <div class="col-sm-2">
                                    <label for="fis_name" class="caption"><?php echo $this->lang->line('sorumlu_personel'); ?></label>

                                    <div class="input-group">
                                        <select name="sorumlu_pers_id" class="form-control select-box ">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach ($emp as $pers) {

                                                $cid=$pers['id'];
                                                $cname=$pers['name'];
                                                if($edit_data['sorumlu_pers_id']==$cid)
                                                {
                                                    ?>
                                                    <option selected value="<?php echo $cid; ?>"><?php echo $cname?></option>
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

                                <div class="col-sm-1">
                                    <label for="fis_name" class="caption">Para Birimi</label>

                                    <div class="input-group">
                                        <select name="para_birimi" class="form-control">
                                            <?php  foreach (para_birimi()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['code'];
                                                if($edit_data['para_birimi']==$cid)
                                                {
                                                    echo "<option selected value='$title'>$title</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$title'>$title</option>";
                                                }


                                            }
                                            ?>

                                        </select>


                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <label for="is_hacimleri" class="caption">İş Hacimleri Getir</label>

                                    <div class="input-group">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" id="secim" data-target="#exampleModal">
                                            Seçim
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <label for="taxformat" class="col-form-label">Proje Sorumlusu</label>
                                    <select class="form-control select-box proje_sorumlu_id required" required name="proje_sorumlu_id">

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
                                <div class="col-sm-1">
                                    <label for="taxformat" class="col-form-label">Proje Müdürü</label>
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
                                <div class="col-sm-1">

                                    <label for="taxformat" class="col-form-label">Genel Müdürü</label>
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

                                <div class="col-sm-1">

                                    <label for="taxformat" class="col-form-label">KDV DURUMU</label>
                                    <select class="form-control tax_status" name="tax_status">

                                        <?php
                                        if($edit_data['tax_status']=='yes')
                                        {
                                            echo "<option selected value='yes'>KDV Dahil</option>";
                                            echo "<option value='no'>KDV Hariç</option>";
                                        }
                                        else if($edit_data['tax_status']=='no')
                                        {
                                            echo "<option  value='yes'>KDV Dahil</option>";
                                            echo "<option selected value='no'>KDV Hariç</option>";
                                        }
                                        else
                                        {
                                            echo "<option  value='yes'>KDV Dahil</option>";
                                            echo "<option value='no'>KDV Hariç</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-1">

                                    <label for="taxformat" class="col-form-label">KDV Oranı</label>
                                    <input type="number" class="form-control " placeholder="KDV Oranı"
                                           name="tax_oran"
                                           value="<?php echo isset($edit_data['tax_oran'])?$edit_data['tax_oran']:'' ?>">

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
                            $i=0;
                            if($products!=''){

                                foreach ($products as $prd){

                                    ?>

                                    <tr>
                                        <td>
                                            <input type="text" class="form-control text-center bolum" name="bolum[]" id="bolum-<?php echo $i; ?>"
                                                   value="<?php echo bolum_getir($prd->bolum_id) ?>" >
                                            <input type="hidden" name="bolum_id[]" id="bolum_id_val-<?php echo $i; ?>" value="<?php echo $prd->bolum_id ?>">
                                        </td>

                                        <td><input type="text" class="form-control text-center asama" name="asama[]"  id="asama-<?php echo $i; ?>"
                                                   value="<?php echo task_to_asama($prd->asama_id) ?>" >
                                            <input type="hidden" name="asama_id[]" id="asama_id_val-<?php echo $i; ?>" value="<?php echo $prd->asama_id ?>">
                                        </td>

                                        <td>
                                            <input type="text" class="form-control text-center"  value="<?php echo $prd->product ?>"
                                            <input type="hidden"  name="product_name[]" value="<?php echo $prd->product ?>"
                                                   placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-<?php echo $i; ?>'>
                                        </td>
                                        <td><input type="text" class="form-control req item_desc" name="item_desc[]" id="item_desc-<?php echo $i; ?>"
                                                   value="<?php echo $prd->item_desc ?>">

                                        </td>
                                        <td>

                                            <select class="form-control" name="unit_id[]" id="unit_id-<?php echo $i; ?>">
                                               <?php foreach (units() as $birimler){
                                                   if($birimler['id']==$prd->unit){
                                                       echo "<option selected value=".$birimler['id'].">".$birimler['name']."</option>";
                                                   }
                                                   else {
                                                       echo "<option value=".$birimler['id'].">".$birimler['name']."</option>";
                                                   }

                                               }?>
                                            </select>
                                            <!--<input type="text" class="form-control req unt" name="product_unit[]" id="units-<?php echo $i; ?>"
                                                   value="<?php echo units_($prd->unit)['name'] ?>">
                                            <input type="hidden" name="unit_id[]" id="unit_id-<?php echo $i; ?>" value="<?php echo $prd->unit ?>">-->
                                        </td>
                                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="product_qty-<?php echo $i; ?>"
                                                   autocomplete="off" value="<?php echo $prd->qty ?>">

                                        </td>

                                        <td><input type="text" class="form-control req unt" onkeyup="rowTotal_form('<?php echo $i; ?>')" name="product_qiymet[]" id="qiymet-<?php echo $i; ?>" value="<?php echo $prd->price ?>"></td>
                                        <td><input type="text" class="form-control req unt"  name="product_cemi[]" id="cemi-<?php echo $i; ?>" value="<?php echo $prd->subtotal ?>"></td>


                                        <input type="hidden" class="pdIn" name="pid[]" id="pid-<?php echo $i; ?>" value="<?php echo $prd->pid ?>">
                                        <input type="hidden" name="hsn[]" id="hsn-<?php echo $i; ?>" value="">
                                        <td class="text-center"><button type="button" data-rowid='<?php echo $i; ?>' class="btn btn-danger removeProd"
                                                                        title="Remove" ><i class="fa fa-minus-square"></i> </button> </td>
                                    </tr>



                                    <?php  $i++; }

                            } else { ?>
                                <tr>
                                    <td><input type="text" class="form-control text-center bolum" name="bolum[]" id="bolum-0"
                                               placeholder="<?php echo $this->lang->line('proje_yerleri') ?>" >
                                        <input type="hidden" name="bolum_id[]" id="bolum_id_val-0">
                                    </td>
                                    <td><input type="text" class="form-control text-center asama" name="asama[]"  id="asama-0"
                                               placeholder="<?php echo $this->lang->line('Milestones Title') ?>" >
                                        <input type="hidden" name="asama_id[]" id="asama_id_val-0">
                                    </td>
                                    <td><input type="text" class="form-control text-center product_name" name="product_name[]"
                                               placeholder="<?php echo $this->lang->line('Enter Product name') ?>" >
                                    </td>
                                    <td><input type="text" class="form-control text-center item_desc" name="item_desc[]"
                                               placeholder="Açıklama" >
                                    </td>
                                    <td><input type="text" class="form-control req unt" name="product_unit[]" id="units-0"
                                               autocomplete="off"></td>
                                    <td><input type="text" class="form-control req amnt" onkeyup="rowTotal_form('0')" name="product_qty[]" id="product_qty-0"
                                               onkeypress="return isNumber(event)"
                                               autocomplete="off" ><input type="hidden" id="alert-0" value="" name="alert[]"> </td>

                                    <td><input type="text" class="form-control req unt" onkeyup="rowTotal_form('0')" name="product_qiymet[]" id="qiymet-0"></td>
                                    <td><input type="text" class="form-control req unt"  name="product_cemi[]" id="cemi-0"></td>
                                    <td class="text-center"><button type="button" data-rowid='0' class="btn btn-danger removeProd"
                                                                    title="Remove" ><i class="fa fa-minus-square"></i> </button>
                                    </td>

                                    <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                    <input type="hidden" name="unit_id[]" id="unit_id-0" value="0">
                                    <input type="hidden" name="hsn[]" id="hsn-0" value="">

                                </tr>
                            <?php } ?>





                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align" count="<?php echo $i?>"
                                            id="addProductFis">
                                        <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                    </button>
                                </td>
                                <td colspan="7"></td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">

                                <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn btn-lg"
                                                                     value="<?php echo isset($id)?$this->lang->line('edit_fis'):$this->lang->line('save_fis'); ?> "
                                                                     id="submit-data-forma2" data-loading-text="Creating...">

                                </td>
                            </tr>

                            </tbody>

                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <?php
                    $pay_array_value =0;
                    $price_array =0;
                    if(isset($id)){
                        $pay_array_value =$pay_array;
                        $price_array =$price_ar;
                        ?>
                        <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
                        <input type="hidden" value="invoices/forma_2_save?id=<?php echo $id ?>" id="action-url">
                    <?php } else { ?>
                        <input type="hidden" value="invoices/forma_2_save" id="action-url">
                        <input type="hidden" value="0" name="counter" id="ganak">
                    <?php } ?>
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
    let _birimler;

    $('#secim').on('click',function (){
        $('#todotable').DataTable().destroy();
        $('#todotable').DataTable({
            "processing": true,
            "serverSide": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('data-block', '0');
                $(row).attr('style', data[13]);
                _birimler =  data[16];

            },
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('projects/todo_load_list_forma2')?>",
                "type": "POST",
                data: {'pid': $('#proje_id').val(), '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [1],
                    "orderable": true,
                },
            ],

        });
    })

    $('#liste_create').on('click',function (){


        let selected_id = [];
        $('.task_id').each((index,item) => {
            if($(item).prop("checked") == true){
                let id = parseInt($(item).val());
                if(id > 0){
                    selected_id.push({
                        'pid':id,
                        'bolum':$(item).attr('proje_bolum_name'),
                        'bolum_id':$(item).attr('proje_bolum_id'),
                        'asama':$(item).attr('ana_asama_name'),
                        'asama_id':$(item).attr('ana_asama_id'),
                        'product_name':$(item).attr('hizmet_name'),
                        'birim_fiyati':$(item).attr('birim_fiyati'),
                        'quantity_':$(item).attr('quantity_'),
                        'total_fiyat':$(item).attr('total_fiyat'),
                        'unit_id':$(item).attr('unit_id'),
                        'unit_name':$(item).attr('unit_name'),
                    });
                }
            }

        });

        let count=0;

        if(parseInt($('#ganak').val())!=0){
            count = $('#ganak').val();
        }
        else {
            $('#ganak').val(0);
            $('.my_stripe tbody tr').eq(0).remove()
        }
        let options='';

        for(i=0; i < _birimler.length; i++){
            options+=`<option value='`+_birimler[i].id+`'>`+_birimler[i].name+`</option>`;
        }
        for (let i = 0 ; i < selected_id.length; i++){
            var cvalue = parseInt(count)+parseInt(i);
            $('#ganak').val(cvalue);
            var functionNum = "'" + cvalue + "'";
            //count = $('#saman-row div').length;

            let pid=selected_id[i].pid;
            let bolum=selected_id[i].bolum;
            let bolum_id=selected_id[i].bolum_id;
            let asama=selected_id[i].asama;
            let asama_id=selected_id[i].asama_id;
            let product_name=selected_id[i].product_name;
            let item_desc=selected_id[i].item_desc;
            let birim_fiyati=selected_id[i].birim_fiyati;
            let quantity=selected_id[i].quantity_;
            let total_fiyat=selected_id[i].total_fiyat;
            let unit_id=selected_id[i].unit_id;
            let unit_name=selected_id[i].unit_name;



            var data = '<tr>' +
                '<td><input type="text" class="form-control text-center bolum" name="bolum[]"'+
                'value="'+bolum+'" id="bolum-' + cvalue + '">   <input type="hidden" name="bolum_id[]" value="'+bolum_id+'" id="bolum_id_val-' + cvalue + '" class="bolum_id"> </td>'+
                '<td><input type="text" class="form-control text-center asama" name="asama[]"'+
                'placeholder="<?php echo $this->lang->line('Milestones Title') ?>" value="'+asama+'" id="asama-' + cvalue + '">  <input type="hidden" value="'+asama_id+'" name="asama_id[]" id="asama_id_val-' + cvalue + '"> </td>'+
                '<td><input type="text" class="form-control text-center" name="product_name[]" ' +
                'placeholder="Ürün Adını veya Kodunu Giriniz" id="productnames-' + cvalue + '" value="'+product_name+'"></td><td><input type="text" class="form-control text-center" name="item_desc[]" ' +
                'placeholder="Açıklama" id="item_desc-' + cvalue + '" value="'+item_desc+'"></td>' +
                '<td>' +
                //'<input type="text" class="form-control unt" value="'+unit_name+'" name="product_unit[]" id="units-' + cvalue + '" autocomplete="off">' +
                '<select name="unit_id[]" id="unit_id-' + cvalue + '" class="form-control"><option value="'+unit_id+'">'+unit_name+'<option>' +options+
                '</select>' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control req amnt" value="'+quantity+'" name="product_qty[]" ' +

                'id="product_qty-' + cvalue + '" onkeypress="return isNumber(event)" autocomplete="off"' +
                '  onkeyup="rowTotal_form(' + cvalue + ')" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> ' +
                '<td><input type="text" class="form-control req unt" name="product_qiymet[]" value="0"  onkeyup="rowTotal_form(' + cvalue + ')" id="qiymet-' + cvalue + '"></td>'+
                '<td><input type="text" class="form-control req unt" name="product_cemi[]"  value="0" id="cemi-' + cvalue + '"></td>'+
                '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
                ' <i class="fa fa-minus-square"></i> </button> </td>' +
                '<input type="hidden" name="fire[]" id="fire-' + cvalue + '" value="0">' +
                '<input type="hidden" name="fire_quantity[]" id="fire_quantity-' + cvalue + '" value="0">' +
                '<input type="hidden" value="'+pid+'"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
                //'<input type="hidden" value="'+unit_id+'" name="unit_id[]" id="unit_id-' + cvalue + '" value="0">'+
                '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
                '</tr>';
            //ajax request
            // $('#saman-row').append(data);
            $('tr.last-item-row').before(data);
        }

        $("#exampleModal").modal("hide");




//product row




    })




    var rowTotal_form = function (numb)
    {
        var amountVal = formInputGet("#product_qty", numb);
        var priceVal = formInputGet("#qiymet", numb);

        var totalValue=amountVal*priceVal;

        var totalID = "#cemi-" + numb;
        $(totalID).val(totalValue);
    }




    //product total
    var samanYog = function () {

        var itempriceList = [];
        var idList = [];
        var r = 0;
        $('.ttInput').each(function () {
            var vv = $(this).val();
            var vid = $(this).attr('id');
            vid = vid.split("-");
            if (vv === '') {
                vv = 0;
            }

            itempriceList.push(vv);
            idList.push(vid[1]);
            r++;
        });
        var sum = 0;
        var taxc = 0;
        var discs = 0;
        var ganak = parseInt($("#ganak").val()) + 1;

        for (var z = 0; z < idList.length; z++) {
            var x = idList[z];
            if (parseFloat(itempriceList[z]) > 0) {
                sum += parseFloat(itempriceList[z]);
            }
            if (parseFloat($("#taxa-" + x).val()) > 0) {
                taxc += parseFloat($("#taxa-" + x).val());
            }
            if (parseFloat($("#disca-" + x).val()) > 0) {
                discs += parseFloat($("#disca-" + x).val());
            }
        }
        discs = deciFormat(discs);
        taxc = deciFormat(taxc);
        sum = deciFormat(sum);
        $("#discs").html(discs);
        $("#taxr").html(taxc);

        var cid = $('#customer_id').val();



        return sum;

    };

    //js eklenecek


    $('#addProductFis').on('click', function () {


        let count_ = $(this).attr("count")
        count_=parseInt(count_)+1;
        $(this).attr("count",count_);
        let cvalue = count_;

        // if($('#ganak').val()==0){
        //      cvalue = parseInt($('#ganak').val())+1;
        // }
        // else {
        //     cvalue = parseInt($('#ganak').val());
        // }
        //
        // var nxt=parseInt(cvalue);
        // $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;


//product row
        var data = '<tr>' +
            '<td><input type="text" class="form-control text-center bolum" name="bolum[]"'+
            'placeholder="<?php echo $this->lang->line('proje_yerleri') ?>" id="bolum-' + cvalue + '">   <input type="hidden" name="bolum_id[]" id="bolum_id_val-' + cvalue + '" class="bolum_id"> </td>'+
            '<td><input type="text" class="form-control text-center asama" name="asama[]"'+
            'placeholder="<?php echo $this->lang->line('Milestones Title') ?>" id="asama-' + cvalue + '">  <input type="hidden" name="asama_id[]" id="asama_id_val-' + cvalue + '"> </td>'+
            '<td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" id="productnames-' + cvalue + '"></td><td><input type="text" class="form-control text-center" name="item_desc[]" ' +
            'placeholder="Açıklama" id="item_desc-' + cvalue + '"></td><td><input type="text" ' +
            'class="form-control req unt" name="product_unit[]" id="units-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'autocomplete="off"></td>' +
            '<td>' +
            '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="product_qty-' + cvalue + '" onkeypress="return isNumber(event)" autocomplete="off"' +
            '  onkeyup="rowTotal_form(' + cvalue + ')" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> ' +
            '<td><input type="text" class="form-control req unt" name="product_qiymet[]"  onkeyup="rowTotal_form(' + cvalue + ')" id="qiymet-' + cvalue + '"></td>'+
            '<td><input type="text" class="form-control req unt" name="product_cemi[]"  id="cemi-' + cvalue + '"></td>'+
            '<td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td>' +
            '<input type="hidden" name="fire[]" id="fire-' + cvalue + '" value="0">' +
            '<input type="hidden" name="fire_quantity[]" id="fire_quantity-' + cvalue + '" value="0">' +
            '<input type="hidden"  class="pdIn" name="pid[]"  id="pid-' + cvalue + '"> ' +
            '<input type="hidden" name="unit_id[]" id="unit_id-' + cvalue + '" value="0">'+
            '<input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            '</tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);


        row = cvalue;

        var invoice_type=$("#invoice_type").val();

        $('#productnames-' + cvalue).autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+ cvalue).val()
                var asama_id=$('#asama_id_val-'+ cvalue).val()
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#warehouses option:selected").val() + '&' + d_csrf,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var product_d = item[0];
                            return {
                                label: product_d,
                                value: product_d,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                id_arr = $(this).attr('id');
                id = id_arr.split("-");
                var t_r = ui.item.data[3];
                if ($("#taxformat option:selected").attr('data-trate')) {

                    var t_r = $("#taxformat option:selected").attr('data-trate');
                }
                var discount = ui.item.data[4];
                var custom_discount=$('#custom_discount').val();
                if(custom_discount>0) discount=deciFormat(custom_discount);

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];
                var qty=ui.item.data[8];
                var unit_id=ui.item.data[9];

                $('#amount-' + cvalue).val(1);
                $('#product_qty-' + cvalue).val(qty);
                $('#qiymet-' + cvalue).val(0);
                $('#pid-' + cvalue).val(pid);
                $('#vat-' + cvalue).val(t_r);
                $('#discount-' + cvalue).val(discount);
                $('#dpid-' + cvalue).val(dpid);
                $('#units-' + cvalue).val(unit);
                $('#hsn-' + cvalue).val(hsn);
                $('#alert-' + cvalue).val(alert);
                $('#unit_id-' + cvalue).val(unit_id);
                rowTotal_form(cvalue);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('#bolum-' + cvalue).autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                $.ajax({
                    url: baseurl + 'search_products/proje_bolumleri',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var bolum_id = item[0];
                            return {
                                label: bolum_id,
                                value: bolum_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var bolum_id=ui.item.data[1];
                $('#bolum_id_val-'+cvalue).val(bolum_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('#asama-' + cvalue).autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-'+cvalue).val()
                $.ajax({
                    url: baseurl + 'search_products/proje_asamalari',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term + '&bolum_id=' + bolum_id,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var asama_id = item[0];
                            return {
                                label: asama_id,
                                value: asama_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var asama_id=ui.item.data[1];
                $('#asama_id_val-'+cvalue).val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });


        var sideh2 = document.getElementById('rough').scrollHeight;
        var opx3 = sideh2 + 50;
        document.getElementById('rough').style.height = opx3 + "px";



    });


    $("#proje_name").keyup(function () {

        var cari_type=2;
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearchform',
            data: 'keyword=' + $(this).val() +'&'+'cari_type=' + cari_type+'&'+crsf_token+'='+crsf_hash,
            beforeSend: function () {
                $("#proje_name").css("backg", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#proje_name").css("backg", "none");

            }
        });
    });

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



    $(document).ready(function () {

        alert("İş Kalemlerini eklemek İçin Önce Proje Seçiniz");
        samanYog();

        var cvalue = parseInt($('#ganak').val()) + 1;

        row = cvalue;

        var invoice_type = $("#invoice_type").val();

        $('.product_name').autocomplete({
            source: function (request, response) {

                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-0').val()
                var asama_id=$('#asama_id_val-0').val()

                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type+ '&proje_id=' + proje_id+ '&asama_id=' + asama_id+  '&bolum_id=' + bolum_id  + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#warehouses option:selected").val() + '&' + d_csrf,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var product_d = item[0];
                            return {
                                label: product_d,
                                value: product_d,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                id = 0;
                var discount = ui.item.data[4];
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price=ui.item.data[1];
                var pid=ui.item.data[2];
                var dpid=ui.item.data[5];
                var unit=ui.item.data[6];
                var hsn=ui.item.data[7];
                var alert=ui.item.data[8];
                var qty=ui.item.data[8];
                var unit_id=ui.item.data[9];

                $('#amount-0').val(1);
                $('#qiymet-0').val(0);
                $('#product_qty-0').val(qty);
                $('#pid-0').val(pid);
                $('#discount-0').val(discount);
                $('#dpid-0').val(dpid);
                $('#units-0').val(unit);
                $('#hsn-0').val(hsn);
                $('#alert-0').val(alert);
                $('#unit_id-0').val(unit_id);
                rowTotal_form(0);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

        $('#bolum-0').autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                $.ajax({
                    url: baseurl + 'search_products/proje_bolumleri',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var bolum_id = item[0];
                            return {
                                label: bolum_id,
                                value: bolum_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var bolum_id=ui.item.data[1];
                $('#bolum_id_val-0').val(bolum_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });
        $('#asama-0').autocomplete({
            source: function (request, response) {
                var proje_id=$('#proje_id').val()
                var bolum_id=$('#bolum_id_val-0').val()
                $.ajax({
                    url: baseurl + 'search_products/proje_asamalari',
                    dataType: "json",
                    method: 'post',
                    data: 'proje_id=' + proje_id+ '&name_startsWith=' + request.term + '&bolum_id=' + bolum_id,
                    success: function (data) {
                        response($.map(data, function (item) {
                            var asama_id = item[0];
                            return {
                                label: asama_id,
                                value: asama_id,
                                data: item
                            };
                        }));
                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {
                var asama_id=ui.item.data[1];
                $('#asama_id_val-0').val(asama_id)


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

    });


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


</script>
