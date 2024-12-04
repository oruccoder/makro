<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">


                    <div class="message"></div>
                </div>
                <div class="card-body">
                <form id="data_form">

                    <input type="hidden" name="customer_id_cart" value="<?php echo $user_id_cart; ?>">


                    <div class="row">


                        <div class="col-sm-6 cmp-pnl">
                            <div id="customerpanel" class="inner-cmp-pnl">
                                <div class="form-group row">
                                    <div class="fcol-sm-12">
                                        <h3 class="title">
                                            <?php echo $this->lang->line('Bill To') ?>
                                            <a href='#'  class="btn btn-primary  btn-sm " data-toggle="modal" class="a_href" data-target="#addCustomer" title="Cari Ekle"> <i class="fa fa-plus-square"></i>
                                            </a>
                                        </h3>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="frmSearch col-sm-12"><label for="cst"
                                                                            class="caption"><?php echo $this->lang->line('Search Client'); ?></label>
                                        <input type="text" class="form-control round" name="cst" id="customer-box"
                                               placeholder="Müşteri Adı veya Telefon Numarası Giriniz"
                                               autocomplete="off"/>

                                        <div id="customer-box-result"></div>
                                    </div>

                                </div>
                                <div id="customer">
                                    <div class="clientinfo">
                                        <?php echo $this->lang->line('Client Details'); ?>
                                        <hr>
                                        <input type="hidden" name="customer_id" id="customer_id" value="0">
                                        <div id="customer_name"></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="customer_address1"></div>
                                    </div>

                                    <div class="clientinfo">

                                        <div id="customer_phone"></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="customer_credit"></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="customer_kalan_credit"></div>
                                    </div>
                                    <div class="clientinfo">

                                        <div id="customer_hesaplaan_kalan_credit"></div>
                                    </div>
                                    <hr>
                                    <div id="customer_pass"></div>




                                </div>


                            </div>
                        </div>
                        <div class="col-sm-6 cmp-pnl">
                            <div class="inner-cmp-pnl">


                                <div class="form-group row">

                                    <div class="col-sm-12"><h3
                                                class="title"><?php echo $this->lang->line('Purchase Properties') ?></h3>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Purchase Number') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Invoice #"
                                                   name="invocieno"
                                                   value="<?php echo $lastinvoice + 1 ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieno"
                                                                 class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round" placeholder="Reference #"
                                                   name="refer">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <div class="col-sm-6"><label for="invociedate"
                                                                 class="caption"><?php echo $this->lang->line('Purchase Date'); ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required"
                                                   placeholder="Billing Date" name="invoicedate"
                                                   data-toggle="datepicker"
                                                   autocomplete="false">
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><label for="invocieduedate"
                                                                 class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control round required" id="tsn_due"
                                                   name="invocieduedate"
                                                   placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row hidden">
                                    <div class="col-sm-6">
                                        <label for="taxformat"
                                               class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                        <select class="form-control round"
                                                onchange="changeTaxFormat(this.value)"
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

                                                <?php echo $this->common->disclist() ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                            <select class="form-control round"
                                                    id="discount_format" name="discount_format">

                                                <?php echo " <option  value='%'>Yüzde (%)</option>
                                                       <option selected value='flat'>Sabit</option>";
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                            <input type="text" class="form-control" placeholder="İndirim" onkeyup="disc_degis(this.value)" name="discount_rate" id="discount_rate"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Proje Bilgileri -->

                                <div class="form-group row">

                                    <div class="col-sm-3">
                                        <label for="status" class="caption"><?php echo $this->lang->line('Warehouse') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                            <select name="warehouses" id="warehouses" class="form-control select-box">
                                                <?php

                                                foreach (depolar() as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="status" class="caption"><?php echo $this->lang->line('purchase_status') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                            <input id="invoice_type" type="hidden" value="1" >
                                            <select name="status" class="form-control select-box">
                                                <?php

                                                foreach (purchase_status() as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['name'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>
                                    <div class="col-sm-3"><label for="project_name"
                                                                 class="caption"><?php echo $this->lang->line('project_name') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Proje Adı "
                                                   name="project_name">
                                        </div>
                                    </div>
                                    <div class="col-sm-3"><label for="project_adresi"
                                                                 class="caption"><?php echo $this->lang->line('project_adresi') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Proje Adresi"
                                                   name="project_adresi">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4"><label for="project_sehir"
                                                                 class="caption"><?php echo $this->lang->line('project_sehir') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Proje Şehri "
                                                   name="project_sehir">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"><label for="project_yetkli_no"
                                                                 class="caption"><?php echo $this->lang->line('project_yetkli_no') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Proje Yetkili Numarası"
                                                   name="project_yetkli_no">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"><label for="proje_yetkili_adi"
                                                                 class="caption"><?php echo $this->lang->line('proje_yetkili_adi') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Proje Yetkili Adı"
                                                   name="proje_yetkili_adi" >
                                        </div>
                                    </div>
                                </div>

                                <!-- Proje Bilgileri -->
                                <!-- Araç Bilgileri -->

                                <div class="form-group row">
                                    <div class="col-sm-4"><label for="plaka_no"
                                                                 class="caption"><?php echo $this->lang->line('plaka_no') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Plaka "
                                                   name="plaka_no">
                                        </div>
                                    </div>
                                    <div class="col-sm-4"><label for="sofor_name"
                                                                 class="caption"><?php echo $this->lang->line('sofor_name') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Şöför Adı"
                                                   name="sofor_name" >
                                        </div>
                                    </div>
                                    <div class="col-sm-4"><label for="sofor_tel"
                                                                 class="caption"><?php echo $this->lang->line('sofor_tel') ?></label>

                                        <div class="input-group">
                                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                 aria-hidden="true"></span></div>
                                            <input type="text" class="form-control" placeholder="Şöför Telefonu"
                                                   name="sofor_tel"  >
                                        </div>
                                    </div>
                                </div>

                                <!-- Araç Bilgileri -->


                                <div class="form-group row">
                                    <div class="col-sm-6" >

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption">Sorumlu Personel</label>

                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="icon-file-text-o" aria-hidden="true"></span></div>
                                                <select name="personel_id" class="form-control select-box">
                                                    <?php
                                                    echo "<option value='0'>Personel Seçiniz</option>";
                                                    foreach ($emp as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['name'];
                                                        echo "<option value='$cid'>$title</option>";
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="toAddInfo"
                                               class="caption"><?php echo $this->lang->line('Purchase Note') ?></label>
                                        <textarea class="form-control round" name="notes" rows="2"></textarea></div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6" style="display: none">

                                        <div class="form-group">
                                            <label for="discountFormat"
                                                   class="caption">Proje</label>
                                            <select name="proje_id" class="form-control select-box">
                                                <?php
                                                if($projeler)
                                                {
                                                    echo "<option value='0'>Proje Seçiniz</option>";
                                                    foreach ($projeler as $row) {
                                                        $cid = $row['id'];
                                                        $title = $row['name'];
                                                        echo "<option value='$cid'>$title</option>";
                                                    }
                                                }
                                                else
                                                    {
                                                        echo "<option value='0'>Proje Yok</option>";
                                                    }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div id="saman-row">
                        <table class="table-responsive tfr my_stripe">

                            <thead>
                            <tr class="item_header bg-gradient-directional-amber">
                                <th width="30%" class="text-center"><?php echo $this->lang->line('Item Name') ?></th>
                                <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                <th width="10%" class="text-center">
                                    <?php echo $this->lang->line('Amount') ?>
                                    (<?= currency($this->aauth->get_user()->loc); ?>)
                                </th>
                                <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                            </tr>

                            </thead>  <tbody>

                            <!-- Sepette Ürün Var ise -->
                            <?php if($products!=0) {
                                $i = 0;
                                foreach ($products as $row) {

                                    $subtotal = $row['miktar'] * $row['price'];
                                    echo '<tr >
                        <td><input type="text" class="form-control text-center" name="product_name[]"  value="' . $row['product_name'] . '">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . +$row['miktar'] . '" ><input type="hidden" name="old_product_qty[]" value="' . $row['miktar'] . '" ></td>
                        <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                   autocomplete="off" value="' . $row['price'] . '"></td>
                        <td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' . $i . '"
                                    onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                                    autocomplete="off"  value="' . $row['kdv'] . '"></td>
                       
                        <td><input type="text" class="form-control discount" name="product_discount[]"
                                   onkeypress="return isNumber(event)" id="discount-' . $i . '"
                                   onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off"  value="' . $row['discount'] . '"></td>
                        <td><span class="currenty">' . $this->config->item('currency') . '</span>
                            <strong><span class="ttlText" id="result-' . $i . '">' . $subtotal . '</span></strong></td>
                        <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button>
                        </td>
                        <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . $row['totaltax'] . '">
                        <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . $row['totaldiscount'] . '">
                        <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . $subtotal . '">
                        <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['product_id'] . '">
                             <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">
                                   <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['product_model'] . '">
                    </tr> ';
                                    $i++;

                                }
                            }else { ?>

                            <tr>
                                <td><input type="text" class="form-control text-center" name="product_name[]"
                                           placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0' autofocus>
                                </td>
                                <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                           onkeypress="return isNumber(event)"  onkeyup="rowTotal('0'), billUpyog(),paketleme_hesapla('0')"
                                           autocomplete="off" value="1"><input type="hidden" id="alert-0" value="" name="alert[]"> </td>
                                <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0"
                                           onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
                                           autocomplete="off"></td>
                                <td><input type="text" class="form-control discount" name="product_discount[]"
                                           onkeypress="return isNumber(event)" id="discount-0"
                                           onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                                <td>
                                    <strong><span class='ttlText' id="result-0">0</span></strong>
                                    <span class="currenty"> <?= currency($this->aauth->get_user()->loc); ?></span>
                                </td>
                                <td class="text-center">

                                </td>
                                <input type="hidden" name="taxa[]" id="taxa-0" value="0">
                                <input type="hidden" name="disca[]" id="disca-0" value="0">
                                <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-0" value="0">
                                <input type="hidden" class="pdIn" name="pid[]" id="pid-0" value="0">
                                <input type="hidden" name="unit[]" id="unit-0" value="">
                                <input type="hidden" name="hsn[]" id="hsn-0" value="">
                            </tr>

                            <?php } ?>


                            <tr class="last-item-row sub_c">
                                <td class="add-row">
                                    <button type="button" class="btn btn-success" aria-label="Left Align" id="addproduct">
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
                                    <span id="subtotalr" class="lightMode">0</span></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="5" align="right">
                                    <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency');
                                        if (isset($_GET['project'])) {
                                            echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                        } ?></span>
                                    <span id="discs" class="lightMode">0</span></td>
                            </tr>


                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="5" align="right">
                                    <strong><?php echo $this->lang->line('Net Total') ?></strong></td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?php echo $this->config->item('currency');
                                        if (isset($_GET['project'])) {
                                            echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                        } ?></span>
                                    <input type="hidden" id="nettotalinp">
                                    <span id="nettotal" class="lightMode">0</span></td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td colspan="5" align="right">
                                    <input type="hidden" value="0" id="subttlform"  name="subtotal">
                                    <strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                </td>
                                <td align="left" colspan="2"><span
                                            class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                    <span id="taxr" class="lightMode">0</span></td>
                            </tr>


                            <tr class="sub_c hidden">
                            <td colspan="5" align="right">
                                <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                            <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                                onkeypress="return isNumber(event)"
                                                                placeholder="Value"
                                                                name="shipping" autocomplete="off"
                                                                onkeyup="billUpyog()"> ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency');?> <span id="ship_final">0</span> )</td>
                            </tr>

                            <tr class="sub_c" style="display: table-row;">
                                <td class="hidden" colspan="2"><?php if ($exchange['active'] == 1){
                                    echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                                    <select name="mcurrency"
                                            class="selectpicker form-control">
                                        <option value="0">Default</option>
                                        <?php foreach ($currency as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                        } ?>

                                    </select><?php } ?></td>
                                <td colspan="5" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                                        (<span
                                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                </td>
                                <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                                    id="invoiceyoghtml" readonly="">

                                </td>
                            </tr>
                            <tr class="sub_c" style="display: table-row;">
                                <td class="hidden" colspan="2"><?php echo $this->lang->line('Payment Terms') ?> <select name="pterms"
                                                                                                                        class="selectpicker form-control"><?php foreach ($terms as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                        } ?>

                                    </select></td>
                                <td align="right" colspan="6"><input class="btn btn-success sub-btn btn-lg"
                                                                     value="<?php echo $this->lang->line('Generate Order') ?> "
                                                                     id="submit-data" data-loading-text="Creating...">

                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" value="new_i" id="inv_page">
                    <input type="hidden" value="purchase/action" id="action-url">
                    <input type="hidden" value="puchase_search" id="billtype">
                    <input type="hidden" value="0" name="counter" id="ganak">
                    <input type="hidden" value="<?= currency($this->aauth->get_user()->loc); ?>" name="currency">
                    <input type="hidden" value="<?=$taxdetails['handle']; ?>" name="taxformat" id="tax_format">
                    <input type="hidden" value="<?=$taxdetails['format']; ?>" name="tax_handle" id="tax_status">
                    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                    <input type="hidden" value="<?=$this->common->disc_status()['disc_format']; ?>" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?=$this->common->disc_status()['ship_rate']; ?>" name="shipRate" id="ship_rate">
                    <input type="hidden" value="<?=$this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype" id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
                    <input type="hidden" value="0" id="custom_discount">

                </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>





    $('#invoice_type').on('change',function () {
        $('#customer-box').prop('disabled',false);
    });


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
        //kalan kredi hesaplama


        return sum;

    };

    $(document).ready(function () {

        disc_degis($('#discount_rate').val());
        $('#productname-0').focus();
        SubTotal();
        billUpyog();


    });

    function paketleme_hesapla(num) {
        var qty = formInputGet("#amount", num);
        var product_id=formInputGet("#pid", num);
        $.ajax({
            url: baseurl + 'search_products/paketleme_hesapla',
            type: "POST",
            data: 'qty='+qty+'&product_id='+product_id+'&'+d_csrf,
            success: function (data) {
                if(data)
                {
                    if(data==0)
                    {
                        $('#amount-'+num).css('background-color','white');
                        $('#amount-'+num).css('color','#5a5a5a');
                    }
                    else
                        {
                            $('#amount-'+num).css('background-color','red');
                            $('#amount-'+num).css('color','white');
                        }
                }


            }
        });

    }



    $('#addproducte').on('click', function () {






        var cvalue = parseInt($('#ganak').val())+1;


        var nxt=parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;




//product row
        var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" ' +
            'placeholder="Ürün Adını veya Kodunu Giriniz" autofocus id="productnamee-' + cvalue + '"></td><td>' +
            '<input type="text" class="form-control req amnt" name="product_qty[]" ' +
            'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog(),paketleme_hesapla(' + functionNum + ')" autocomplete="off"' +
            ' value="0" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
            'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" ' +
            'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
            ' name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
            'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
            'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currency +'</span> ' +
            '</strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
            '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
            'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> ' +
            '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
            '</tr>';
        //ajax request
        // $('#saman-row').append(data);
        $('tr.last-item-row').before(data);



        row = cvalue;

        $('#productnamee-'+cvalue).focus();

        $('#productnamee-' + cvalue).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: baseurl + 'search_products/' + billtype,
                    dataType: "json",
                    method: 'post',
                    data: 'name_startsWith='+request.term+'&type=product_list&row_num='+row+'&wid'+$("#warehouses option:selected").val()+'&'+d_csrf,
                    success: function (data) {


                        response(data);

                    }
                });
            },
            autoFocus: true,
            minLength: 0,
            select: function (event, ui) {



                var durum=true;
                for(var i=0; i < $('.amnt').length;i++)
                {
                    var prd_name2= $('#productnamee-' + i).val();
                    var prd_name= $('#productname-0').val();
                    if(prd_name==ui.item[0] || prd_name2==ui.item[0] )
                    {
                        durum=false;

                        var sayi= $('.amnt').eq(i).val();

                        var qty=parseInt(sayi)+parseInt(1);


                        $('.amnt').eq(i).val(qty);

                        $('#productnamee-' + cvalue).val('');

                        return false;


                    }
                }

                if(durum==true)
                {
                    id_arr = $(this).attr('id');

                    id = id_arr.split("-");
                    var t_r = ui[3];
                    if ($("#taxformat option:selected").attr('data-trate')) {

                        var t_r = $("#taxformat option:selected").attr('data-trate');
                    }
                    var discount = ui[4];
                    var custom_discount=$('#custom_discount').val();
                    if(custom_discount>0) discount=deciFormat(custom_discount);

                    $('#amount-' + id[1]).val(1);
                    $('#price-' + cvalue).val(ui.item[1]);
                    $('#pid-' + id[1]).val(ui.item[2]);
                    $('#vat-' + id[1]).val(t_r);
                    $('#discount-' + id[1]).val(discount);
                    $('#dpid-' + id[1]).val(ui.item[5]);
                    $('#unit-' + id[1]).val(ui.item[6]);
                    $('#hsn-' + id[1]).val(ui.item[7]);
                    $('#alert-' + id[1]).val(ui.item[8]);

                    $('#productnamee-' + cvalue).val(ui.item[0]);
                }




                rowTotal(cvalue);
                billUpyog();
                $('#addproducte').click();




            }
        })
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {



            if(item.label == 'No Match Found'){
                return $( "<li id='ac' style='width: 29%;background-color: #d7dede;padding: 5px;'>" )
                    .data( "item.autocomplete", item )
                    .append( item.value )
                    .appendTo( ul )
                    .css("cursor", "default");
            } else {
                return $( "<li aria-selected='true' style='width: 29%;background-color: #d7dede;padding: 5px;'>" )
                    .data( "item.autocomplete", item )
                    .append( (item[0]) )
                    .appendTo( ul )
                    .css("cursor", "default");
            }



        }






        var sideh2 = document.getElementById('rough').scrollHeight;
        var opx3 = sideh2 + 50;
        document.getElementById('rough').style.height = opx3 + "px";
    });



    function disc_degis(deger) {
        if(deger!=0 || deger!="")
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



</script>