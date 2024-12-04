<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Yeni Fatura</span></h4>
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
                                        <form method="post" id="data_form">


            <div class="row">

                <div class="col-sm-4">

                </div>

                <div class="col-sm-3"></div>

                <div class="col-sm-2"></div>

                <div class="col-sm-3">

                </div>

            </div>

            <div class="row">


                <div class="col-sm-6 cmp-pnl">
                    <div id="customerpanel" class="inner-cmp-pnl">
                        <div class="form-group row">
                            <div class="frmSearch col-sm-12"><label for="cst"
                                                                    class="caption"><?php echo $this->lang->line('Search Client'); ?></label>
                                <input type="text" class="form-control round" name="cst" id="customer-box"
                                       placeholder="Müşteri Adı veya Telefon Numarası Giriniz" autocomplete="off"/>

                                <div id="customer-box-result"></div>
                            </div>

                        </div>
                        <div id="customer">
                            <div class="clientinfo">
                                <?php echo $this->lang->line('Client Details'); ?>
                                <hr>
                                <?php echo '  <input type="hidden" name="customer_id" id="customer_id" value="' . $invoice['csd'] . '">
                                <div id="customer_company"><strong>' . $invoice['company'] . '</strong></div>
                            </div>
                            <div class="clientinfo">
                            <div id="customer_name"><strong>' . $invoice['name'] . '</strong></div>
                            </div>
                            <div class="clientinfo">

                                <div id="customer_address1"><strong>' . $invoice['address'] . '<br>' . $invoice['city'] . ',' . $invoice['country'] . '</strong></div>
                            </div>

                            <div class="clientinfo">

                                <div type="text" id="customer_phone">Phone: <strong>' . $invoice['phone'] . '</strong><br>Email: <strong>' . $invoice['email'] . '</strong></div>
                            </div>'; ?>
                                <hr>
                                <div id="customer_pass"></div>


                                <div class="col-md-6"  style="padding-bottom: 10px;">
                                    <?php echo $this->lang->line('invoice_type') ?>

                                    <input type="text" class="form-control round" disabled value="<?php echo invoice_type_name($invoice['invoice_type_id']);?>">
                                    <input type="hidden" id="invoice_type" name="invoice_type" value="<?php echo $invoice['invoice_type_id'];?>">
                                    <!--select name="invoice_type" id="invoice_type" class="selectpicker form-control round">
                                        <?php foreach (invoice_type() as $row) {
                                            $selected=($row['id']==$invoice['invoice_type_id'])?'selected':'';
                                            echo '<option '.$selected.' value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                        } ?>

                                    </select-->
                                </div>




                            </div>


                        </div>
                    </div>
                    <div class="col-sm-6 cmp-pnl">
                        <div class="inner-cmp-pnl">


                            <div class="form-group row">

                                <div class="col-sm-12"><span class="red"><?php echo $this->lang->line('Edit Invoice') ?></span><h3
                                            class="title"><?php echo $this->lang->line('Invoice Properties') ?></h3>
                                </div>

                            </div>
                            <div class="form-group row">
                                <input type="hidden" class="form-control round" placeholder="Invoice #" name="invocieno"
                                       value="<?php echo $invoice['tid']; ?>" readonly>

                                <input type="hidden" name="iid"
                                       value="<?php echo $invoice['iid']; ?>">

                                <div class="col-sm-3"><label for="invocieno"
                                                             class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                    <div class="input-group">

                                        <input type="text" class="form-control round" placeholder="Invoice #" name="invoice_no"
                                               value="<?php echo $invoice['invoice_no']; ?>" >


                                    </div>
                                </div>
                                <div class="col-sm-3"><label for="invocieno"
                                                             class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round" placeholder="Reference #" name="refer"
                                               value="<?php echo $invoice['refer'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3"><label for="invociedate"
                                                             class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round required"  data-toggle="invoicedate"
                                               placeholder="Billing Date" name="invoicedate" autocomplete="false"
                                               value="<?php echo dateformat($invoice['invoicedate']) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3"><label for="invocieduedate"
                                                             class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round required editdate" name="invocieduedate"
                                               placeholder="Due Date" autocomplete="false"
                                               value="<?php echo dateformat($invoice['invoiceduedate']) ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">


                                <div class="col-sm-3">
                                    <label for="invoice_para_birimi" class="caption">Alt Firma</label>

                                    <div class="input-group">
                                        <select name="alt_cari_id" id="alt_cari_id" class="form-control select-box">
                                            <?php
                                            echo "<option value='0'>Seçiniz</option>";
                                            foreach (all_customer()  as $row) {
                                                $cid = $row->id;
                                                $title = $row->company;
                                                if($invoice['alt_cari_id']==$cid)
                                                {
                                                    echo "<option selected value='$cid'>$title</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-3"><label for="invoice_para_birimi"
                                                             class="caption"><?php echo $this->lang->line('invoice_para_birimi'); ?></label>

                                    <div class="input-group">
                                        <select name="para_birimi" id="para_birimi" class="form-control">
                                            <?php
                                            foreach (para_birimi()  as $row) {
                                                $cid = $row['id'];
                                                $title = $row['code'];
                                                if($invoice['para_birimi']==$cid)
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
                                <div class="col-sm-3"><label for="invocieduedate"
                                                             class="caption"><?php echo $this->lang->line('invoice_kur_degeri') ?></label>

                                    <div class="input-group">
                                        <input type="text" class="form-control round" placeholder="Kur"
                                               name="kur_degeri" value="<?php echo $invoice['kur_degeri'] ?>" id="kur_degeri">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="invocieduedate" class="caption">Təhvil Alındı</label>
                                    <div style="font-size: 10px" class="form-text text-muted">Eğer Seçili İse Stok Güncellenmeyecektir</div>
                                    <div class="input-group">
                                        <?php $che=''; if(isset($invoice['stok_guncelle']))
                                        {
                                            if($invoice['stok_guncelle']==1)
                                            {
                                                $che="checked";
                                            }
                                            else {
                                                $che="";
                                            }


                                        }
                                        ?>
                                        <input type="checkbox"  <?php echo $che;?> class="form-control" name="stok_durumu">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row hidden">
                                <div class="col-sm-6">
                                    <label for="taxformat"
                                           class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                    <select class="form-control round" onchange="changeTaxFormat(this.value)"
                                            id="taxformat">

                                          <?php echo $taxlist; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                        <select class="form-control round" onchange="changeDiscountFormat(this.value)"
                                                id="discountFormat">
                                            <?php echo '<option value="' . $invoice['format_discount'] . '">'.$this->lang->line('Do not change').'</option>'; ?>
                                              <?php echo $this->common->disclist() ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                        <select class="form-control round"
                                                id="discount_format" name="discount_format">

                                            <?php if($invoice['format_discount']=='%'){
                                                echo " <option selected value='%'>Yüzde (%)</option>
                                                       <option value='flat'>Sabit</option>

                                                    ";
                                            }else
                                            {
                                                echo " <option  value='%'>Yüzde (%)</option>
                                                       <option selected value='flat'>Sabit</option>

                                                    ";
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                        <input type="text" class="form-control" placeholder="İndirim" onkeyup="disc_degis(this.value)" name="discount_rate" id="discount_rate"
                                               value="<?php echo $invoice['discount_rate'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('invoice_tip') ?></label>
                                        <select class="form-control" name="ithalat_ihracat_tip">
                                            <option value="0">Fatura</option>
                                            <option value="1">İhracat</option>
                                            <option value="0">İthalat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('dosya_no') ?></label>
                                        <select class="form-control" name="dosya_id">
                                            <option value="0">Seçiniz</option>
                                            <?php foreach (ihracat_dosyaları() as $dosya)
                                            {
                                                echo '<option value="'.$dosya->id.'">'.$dosya->dosya_no.'</option>';
                                            } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">



                                <div class="col-sm-4">
                                    <label for="toAddInfo"
                                           class="caption">Proje Seçiniz</label>
                                    <select class="form-control select-box" name="proje_id" id="proje_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_projects() as $project){


                                                $proje_id=$invoice['proje_id'];
                                                if($proje_id==$project->id )
                                                {
                                                    ?>
                                                    <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                    <?php
                                                }
                                                ?>
                                        <?php } ?>

                                    </select>

                                </div>

                                <div class="col-sm-4">
                                    <label for="toAddInfo" class="caption">Bölüm Seçiniz</label>
                                    <select name="bolum_id" class="form-control select-box" id="bolum_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_bolum_proje($invoice['proje_id']) as $project){


                                            $bolum_id=$invoice['bolum_id'];
                                            if($bolum_id==$project->id )
                                            {
                                                ?>
                                                <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="toAddInfo" class="caption">Aşama Seçiniz</label>
                                    <select name="asama_id" class="form-control select-box" id="asama_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_bolum_asama($invoice['proje_id']) as $project){


                                            $asama_id=$invoice['asama_id'];
                                            if($asama_id==$project->id )
                                            {
                                                ?>
                                                <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="toAddInfo" class="caption">Alt Aşama Seçiniz</label>
                                    <select name="alt_asama_id" class="form-control select-box" id="alt_asama_id">
                                        <?php foreach (all_asama_alt_asama($invoice['asama_id']) as $project){


                                            $asama_id=$invoice['alt_asama_id'];
                                            if($asama_id==$project->id )
                                            {
                                                ?>
                                                <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="toAddInfo" class="caption">İş Kalemi Seçiniz</label>
                                    <select name="task_id" class="form-control select-box" id="task_id">
                                        <option value="0">Seçiniz</option>
                                        <?php foreach (all_bolum_task($invoice['alt_asama_id']) as $project){


                                            $task_id=$invoice['task_id'];
                                            if($task_id==$project->id )
                                            {
                                                ?>
                                                <option selected value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                <?php
                                            }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="toAddInfo" class="caption">Ödeme Tipi</label>
                                    <select name="paymethod" class="form-control" id="paymethod">
                                        <?php foreach (account_type_islem() as $acc)
                                        {
                                            $task_id=$invoice['method'];
                                            if($acc->id==$task_id)
                                            {
                                                echo "<option selected value='$acc->id'>$acc->name</option>";
                                            }
                                            else
                                                {
                                                    echo "<option value='$acc->id'>$acc->name</option>";
                                                }


                                        } ?>
                                    </select>
                                </div>



                                <div class="col-sm-4">
                                    <label for="toAddInfo"
                                           class="caption">Avans Talep Formu</label>
                                    <select class="form-control select-box" name="avans_talep_formu[]" multiple>
                                        <option value="0">Avans Talep Formu Seçiniz</option>

                                        <?php

                                        if(talep_list(5)){
                                         foreach (talep_list(5) as $talep)
                                            {
                                                if(invoice_to_talep_sorgu($_GET['id'],5)){
                                                    if(in_array($talep->id,invoice_to_talep_sorgu($_GET['id'],5)))
                                                    {
                                                        echo "<option selected value='$talep->id'>$talep->talep_no</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='$talep->id'>$talep->talep_no</option>";
                                                    }
                                                }


                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="toAddInfo"
                                           class="caption">Malzeme Talep Formu</label>
                                    <select class="form-control select-box" name="malzeme_talep_id[]" multiple>
                                        <option value="0">Malzeme Talep Formu Seçiniz</option>

                                        <?php
                                        if(talep_list(1)){
                                            foreach (talep_list(1) as $talep)
                                            {
                                                if(invoice_to_talep_sorgu($_GET['id'],1)){
                                                    if(in_array($talep->id,invoice_to_talep_sorgu($_GET['id'],1)))
                                                    {
                                                        echo "<option selected value='$talep->id'>$talep->talep_no</option>";
                                                    }
                                                    else
                                                    {
                                                        echo "<option value='$talep->id'>$talep->talep_no</option>";
                                                    }
                                                }


                                            }
                                        }


                                       ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">

                                    <label for="toAddInfo"
                                           class="caption">Satın Alma Formu</label>
                                    <select class="form-control select-box" name="satinalma_talep_id[]" multiple>
                                        <option value="0">Satın Alma Talep Formu Seçiniz</option>
                                        <?php
                                        if(talep_list(2)){
                                            foreach (talep_list(2) as $talep)
                                            {
                                            if(invoice_to_talep_sorgu($_GET['id'],2)){
                                                if(in_array($talep->id,invoice_to_talep_sorgu($_GET['id'],2)))
                                                {
                                                    echo "<option selected value='$talep->id'>$talep->talep_no</option>";
                                                }
                                                else
                                                {
                                                    echo "<option value='$talep->id'>$talep->talep_no</option>";
                                                }
                                            }

                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="toAddInfo"
                                           class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                    <textarea class="form-control round" name="notes"
                                              rows="2"><?php echo $invoice['notes'] ?></textarea>
                                </div>
                                <div class="col-sm-4">
                                    <label for="toAddInfo"
                                           class="caption">Forma2 Listesi</label>
                                    <select class="form-control select-box" multiple name="forma2_id[]" id="forma2_id">

                                        <?php
                                        if(count($forma2_)){
                                             foreach ($forma2_ as $val)
                                            {
                                                echo "<option selected value='$val->id'>$val->invoice_no</option>";
                                            }
                                        }
                                        else {
                                            echo "<option value=''>Cari Seçiniz</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-sm-12">
                                    <label for="toAddInfo"
                                           class="caption">Tehvil Listesi</label>
                                    <select class="form-control select-box" multiple name="tehvil_id[]" id="tehvil_id">

                                        <?php
                                        if(count($tehvil_list)){
                                            foreach ($tehvil_list as $val)
                                            {
                                                echo "<option selected value='$val->id'>$val->invoice_no</option>";
                                            }
                                        }
                                        else {
                                            echo "<option value=''>Cari Seçiniz</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>


                <div id="saman-row">
                    <table class="table responsive">
                        <thead>

                        <tr class="item_header bg-gradient-directional-blue white">
                            <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                            <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                            <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                            <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Amount') . ' <span class="currenty">(' . $this->config->item('currency'); ?>)</span>
                            </th>
                            <th width="15%" class="text-center">Depo</th>
                            <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr></thead> <tbody>
                        <?php $i = 0;
                        foreach ($products as $row) {
                            echo '<tr >
                        <td>
                        <input type="hidden" id="tax_type-' . $i . '" value="' . $row['tax_type'] . '">
                        <input type="text" class="form-control text-center" disabled id="productname-' . $i . '"   value="' . $row['product'] . '">
                        <input type="hidden" class="form-control text-center" id="productname-' . $i . '" name="product_name[]"  value="' . $row['product'] . '">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . +$row['qty'] . '" ><input type="hidden" name="old_product_qty[]" value="' . $row['qty'] . '" ></td>
                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . $row['price'] . '"></td>
                        <td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' . $i . '"
                                    onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                    autocomplete="off"  value="' . $row['tax'] . '"></td>

                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                   onkeypress="return isNumber(event)" id="discount-' . $i . '"
                                   onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off"  value="' . $row['discount'] . '"></td>
                        <td>
                            <strong><span class="ttlText" id="result-' . $i . '">' . $row['subtotal'] . '</span></strong> <span class="currenty">' . $this->config->item('currency') . '</span></td>
                           <td>
                           <input type="hidden" value="'.$row["depo_id"].'" name="old_depo_id_item[]" class="old_depo_id_item">
                                    <select name="depo_id_item[]"  class="select2 form-control">';



                                        foreach ($warehouse as $rows) {
                                        $cid = $rows->id;
                                        $title = $rows->title;
                                        if($row["depo_id"]==$cid)
                                        {
                                            echo '<option selected value='.$cid.'>'.$title.'</option>';
                                        }
                                        else
                                            {
                                                echo '<option value='.$cid.'>'.$title.'</option>';
                                            }


                                        }


                                    echo '</select>
                                </td>
                        <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button>
                        </td>
                        <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . $row['totaltax'] . '">
                        <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . $row['totaldiscount'] . '">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . $row['subtotal'] . '">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
                             <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">
                                   <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['code'] . '">
                    </tr> ';
                            $i++;
                        } ?>
                        <tr class="last-item-row sub_c">
                            <td class="add-row">
                                <button type="button" class="btn btn-success" aria-label="Left Align" id="addproducts">
                                    <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                </button>
                            </td>
                            <td colspan="7"></td>
                        </tr>
                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="5" align="right">
                                <input type="hidden" value="0" id="subtotal"  name="subtotal">
                                <strong><?php echo $this->lang->line('Sub Total') ?></strong>
                            </td>
                            <td align="left" colspan="2"><span
                                        class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                <span id="subtotalr" class="lightMode"></span></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="5" align="right">
                                <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                            <td align="left" colspan="2"><span
                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                <span id="discs" class="lightMode"><?php echo $invoice['discount'] ?></span></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="5" align="right">
                                <strong><?php echo $this->lang->line('Net Total') ?></strong></td>
                            <td align="left" colspan="2"><span
                                        class="currenty lightMode"><?php echo $this->config->item('currency');
                                   ?></span>
                                <input type="hidden" id="nettotalinp">
                                <span id="nettotal" class="lightMode">0</span></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="5" align="right">
                                <input type="hidden" value="<?php echo $invoice['subtotal'] ?>" id="subttlform"
                                                                 name="subtotal">
                                <input type="hidden" value="<?php echo $invoice['subtotal'] ?>" id="subttlform2" >

                                <strong><?php echo $this->lang->line('Total Tax') ?></strong>
                            </td>
                            <td align="left" colspan="2"><span
                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                <span id="taxr" class="lightMode"><?php echo $invoice['tax'] ?></span></td>

                        </tr>




                        <tr class="sub_c" style="display: table-row;">
                            <td class="hidden" colspan="2"><?php if ($exchange['active'] == 1){
                                echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                <select name="mcurrency"
                                        class="selectpicker form-control">

                                    <?php
                                    echo '<option value="' . $invoice['multi'] . '">Do not change</option><option value="0">None</option>';
                                    foreach ($currency as $row) {

                                        echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                    } ?>

                                </select><?php } ?></td>
                            <td colspan=3 align="right"><strong><?php echo $this->lang->line('Grand Total') ?> (<span
                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                            </td>
                            <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                id="invoiceyoghtml"
                                                                value="<?php echo $invoice['total']; ?>" readonly="">

                            </td>
                        </tr>
                        <tr class="sub_c" style="display: table-row;">
                            <td class="hidden" colspan="2"><?php echo $this->lang->line('Payment Terms') ?>
                                <select name="pterms" class="selectpicker form-control"><?php echo '<option value="' . $invoice['termid'] . '">*' . $invoice['termtit'] . '</option>';
                                    foreach ($terms as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                    } ?>


                                </select></td>
                            <td align="right" colspan="5">

                                <button type="button" class="btn btn-success" id="new_update">Güncelle</button>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>


                <input type="hidden" value="<?php echo $this->aauth->get_user()->loc ?>" id="loc_id">

                <input type="hidden" value="invoices/editaction" id="action-url">
                <input type="hidden" value="search" id="billtype">
                <input type="hidden" value="<?php echo $i ; ?>" name="counter" id="ganak">
                <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                <input type="hidden" value="<?=$this->common->taxhandle_edit($invoice['taxstatus']) ?>" name="taxformat" id="tax_format">
                <input type="hidden" value="<?= $invoice['format_discount'] ; ?>" name="discountFormat" id="discount_format">
                <input type="hidden" value="<?= $invoice['taxstatus'] ; ?>" name="tax_handle" id="tax_status">
                <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                  <input type="hidden" value="<?=@number_format(($invoice['ship_tax']/$invoice['shipping'])*100,2,'.','') ?>" name="shipRate" id="ship_rate">
                    <input type="hidden" value="<?=$invoice['ship_tax_type']; ?>" name="ship_taxtype" id="ship_taxtype">
                    <input type="hidden" value="<?= $invoice['ship_tax'] ; ?>" name="ship_tax" id="ship_tax">
                    <input type="hidden"  name="taxr2" id="taxr2">


        </form>
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


<script type="text/javascript"> $('.editdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});

    $(document).ready(function () {

        var para_birimi=$('#para_birimi').val();
        var loc_id=$('#loc_id').val();

        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/curr_degis',
            data:
            'para_birimi='+ para_birimi+
            '&loc='+ loc_id+
            '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                $('.currenty').text(data);
                //alert(data);
            }
        });

        let data = {
            crsf_token: crsf_hash,
            cid: $('#customer_id').val(),
        }

    });

    function forma_2list(cid){
        let data = {
            crsf_token: crsf_hash,
            cid: cid,
        }

        $.post(baseurl + 'invoices/forma2_list',data,(response) => {
            let responses = jQuery.parseJSON(response);
            let  table='';
            if(responses.details.length > 0){
                $('#forma2_id').empty().append('<option value="">Seçiniz</option>');;
                responses.details.forEach((item_,index) => {

                    $('#forma2_id').append('<option value="'+item_.id+'">'+item_.invoice_no+'</option>');;
                })
            }
            else {
                $("#forma2_id").empty().append('<option  value="">Forma 2 Bulunamadı</option>');
            }
        });

    }
    function tehvil_list(cid){
        let data = {
            crsf_token: crsf_hash,
            cid: cid,
        }

        $.post(baseurl + 'invoices/tehvil_list',data,(response) => {
            let responses = jQuery.parseJSON(response);
            let  table='';
            if(responses.details.length > 0){
                $('#tehvil_id').empty().append('<option value="">Seçiniz</option>');;
                responses.details.forEach((item_,index) => {

                    $('#tehvil_id').append('<option value="'+item_.id+'">'+item_.invoice_no+'</option>');;
                })
            }
            else {
                $("#tehvil_id").empty().append('<option  value="">Tehvil Formu Bulunamadı</option>');
            }
        });

    }

</script>


<script type="text/javascript">

    function disc_degis(deger) {
        if(deger!=0 || deger!='')
        {
            $('.discount').val(deger);
            $('.discount').trigger("keyup");
            $('.discount').attr('disabled',true)

        }
        else
        {
            $('.discount').attr('disabled',false)
        }

    }


    $(function () {
        $('.select-box').select2();

        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });

    $(document).ready(function () {

       // disc_degis($('#discount_rate').val());

        rowTotal(0);
        billUpyog();
        var cvalue = parseInt($('#ganak').val()) + 1;

        row = cvalue;

        var invoice_type = $("#invoice_type").val();

        $('.product_name').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'invoice_type=' + invoice_type + '&name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#warehouses option:selected").val() + '&' + d_csrf,
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
                var custom_discount = $('#custom_discount').val();
                if (custom_discount > 0) discount = deciFormat(custom_discount);

                var price = ui.item.data[1];
                var pid = ui.item.data[2];
                var dpid = ui.item.data[5];
                var unit = ui.item.data[6];
                var hsn = ui.item.data[7];
                var alert = ui.item.data[8];

                $('#amount-' + id[1]).val(1);
                $('#price-' + id[1]).val(price);
                $('#pid-' + id[1]).val(pid);
                $('#vat-' + id[1]).val(t_r);
                $('#discount-' + id[1]).val(discount);
                $('#dpid-' + id[1]).val(dpid);
                $('#units-' + id[1]).val(unit);
                $('#hsn-' + id[1]).val(hsn);
                $('#alert-' + id[1]).val(alert);
                rowTotal(cvalue);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });

    });


    $(document).ready(function () {



        $(document).on('change','#proje_id',function (e) {
            $('#asama_id').children('option').remove();
            $('#task_id').children('option').remove();
            $('#bolum_id').children('option').remove();
            $('#alt_asama_id').children('option').remove();
            var proje_id=$(this).val();
            $.ajax({
                url: '/projects/proje_bolum_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&pid=' + proje_id,
                success: function (data) {

                    $("#bolum_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#bolum_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                    });
                }
            });
        });

        $(document).on('change','#bolum_id',function (e) {
            $('#asama_id').children('option').remove();
            $('#task_id').children('option').remove();
            $('#alt_asama_id').children('option').remove();
            var bolum_id=$(this).val();
            var proje_id=$('#proje_id').val();
            $.ajax({
                url: '/projects/proje_ana_asamalari_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&bolum_id=' + bolum_id+'&proje_id=' + proje_id,
                success: function (data) {

                    $("#asama_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#asama_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                    });
                }
            });
        });

        $(document).on('change','#asama_id',function (e) {
            $('#task_id').children('option').remove();
            $('#alt_asama_id').children('option').remove();
            var asama_id=$(this).val();
            var proje_id=$('#proje_id').val();
            var bolum_id=$('#bolum_id').val();
            $.ajax({
                url: '/projects/proje_asamalari_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&asama_id=' + asama_id +'&proje_id=' + proje_id+'&bolum_id=' + bolum_id,
                success: function (data) {
                    $("#alt_asama_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#alt_asama_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');


                    });
                }
            });
        });

        $(document).on('change','#alt_asama_id',function (e) {
            $('#task_id').children('option').remove();
            var asama_id=$(this).val();
            var proje_id=$('#proje_id').val();
            $.ajax({
                url: '/projects/proje_is_kalemleri_ajax/',
                dataType: "json",
                method: 'post',
                data:  '&asama_id=' + asama_id +'&proje_id=' + proje_id,
                success: function (data) {
                    $("#task_id").append('<option  value=0">Seçiniz</option>');
                    jQuery.each(data, function (key, item) {

                        $("#task_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');


                    });
                }
            });
        });
    })

    $('#addproducts').on('click', function () {

        if($('#para_birimi').val())
        {
            var currencys=$('#para_birimi').val();
        }
        else
        {
            var currencys='AZN';
        }



        var cvalue = parseInt($('#ganak').val())+1;
        var invoice_type=$("#invoice_type").val();
        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;


//product row
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" id="productname-' + cvalue + '"></td><td>' +
            '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog(),paketleme_hesapla(' + functionNum + ')" autocomplete="off"' +
            ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"><input type="hidden" name="old_product_qty[]" value="0" > </td> <td><input type="text" ' +
            'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
            ' name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
            'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currencys +'</span> ' +
            '</strong></td> <td><select class="select2 form-control depo_id_item" name="depo_id_item[]"><?php         foreach ($warehouse as $rows) {
                $cid = $rows->id;
                $title = $rows->title;
                echo '<option value='.$cid.'>'.$title.'</option>';


            } ?>'+
            '</select>' +
            '</td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="">' +
            ' <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            ' <input type="hidden" name="invoice_item_id[]" value="0"> ' +
            '</tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);

        disc_degis($('#discount_rate').val());

        var sum=$('#subttlform').val();
        var cid = $('#customer_id').val();
        //kalan kredi hesaplama
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/c_credit',
            data:
                'cid='+ cid+
                '&sum='+ sum+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {

                $('#customer_hesaplaan_kalan_credit').html('Hesaplanan Kalan Kredi : <strong>'+data+'</strong>');
            }
        });

        var url_depolar='invoices/depolar';
        $.ajax({
            type: "POST",
            url: baseurl + url_depolar,
            data:crsf_token+'='+crsf_hash,
            success: function (data) {
                if(data)
                {

                    $('.depo_id_item').eq(cvalue).append($('<option>').val(0).text('Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $(".depo_id_item").eq(cvalue).append('<option value="'+ item.id +'">'+ item.title +'</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });

        row = cvalue;
        $('#productname-' + cvalue).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    //data: 'invoice_type='+invoice_type+'&name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid='+$("#warehouses option:selected").eq(cvalue).val()+'&'+d_csrf,
                    data: 'invoice_type='+invoice_type+'&name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid='+$('select[name="depo_id_item[]"]').find(":selected").val()+'&'+d_csrf,
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

                $('#amount-' + id[1]).val(1);
                $('#price-' + id[1]).val(ui.item.data[1]);
                $('#pid-' + id[1]).val(ui.item.data[2]);
                $('#vat-' + id[1]).val(t_r);
                $('#dpid-' + id[1]).val(ui.item.data[5]);
                $('#unit-' + id[1]).val(ui.item.data[6]);
                $('#hsn-' + id[1]).val(ui.item.data[7]);
                $('#alert-' + id[1]).val(ui.item.data[8]);
                rowTotal(cvalue);
                billUpyog();


            },
            create: function (e) {
                $(this).prev('.ui-helper-hidden-accessible').remove();
            }
        });


    });



    $(document).on('click','#new_update',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Fatura Güncelleme ',
            icon: 'fa fa-pen',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'Fatura Günellemek İstediğinizden Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        let name_say = $('.required').length;
                        let req = 0 ;
                        for (let i = 0; i < name_say;i++){
                            let name = $('.required').eq(i).val();
                            if(!parseInt(name) || name==''){
                                req++;
                            }
                        }
                        if(req > 0){
                            $.alert({
                                theme: 'material',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Dikkat!',
                                content: 'Yıldızlı Alanlar Zorunludur',
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
                        $.post(baseurl + 'invoices/editaction',$('#data_form').serialize(),(response)=>{
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
                                            action:function (){
                                                location.href = '/invoices/view?id='+data.id;
                                            }
                                        }
                                    }
                                });
                            }
                            else if(data.status==410) {
                                $('#loading-box').addClass('d-none');
                                $.alert({
                                    theme: 'modern',
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
                cancel:{
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }

            },
            onContentReady: function () {

                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
</script>
