<div class="content-body">
    <div class="card">
        <div class="card-content">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
            <div class="card-body">
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
                        <div class="form-group">
                            <div class="fcol-sm-12">
                                <a href='#'
                                   class="btn btn-primary btn-sm round"
                                   data-toggle="modal"
                                   data-target="#addCustomer">
                                    <?php echo $this->lang->line('Add Client') ?>
                                </a>
                            </div>
                        </div>

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
                                                             class="caption"><?php echo $this->lang->line('Purchase Order') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round" placeholder="Invoice #" name="invocieno"
                                               value="<?php echo $invoice['tid']; ?>" readonly> <input type="hidden" name="iid"
                                                                                                       value="<?php echo $invoice['iid']; ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6"><label for="invocieno"
                                                             class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round" placeholder="Reference #" name="refer"
                                               value="<?php echo $invoice['refer'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">

                                <div class="col-sm-6"><label for="invociedate"
                                                             class="caption"><?php echo $this->lang->line('Purchase Date'); ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round required editdate"
                                               placeholder="Billing Date" name="invoicedate" autocomplete="false"
                                               value="<?php echo dateformat($invoice['invoicedate']) ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6"><label for="invocieduedate"
                                                             class="caption"><?php echo $this->lang->line('Order Due Date') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control round required editdate" name="invocieduedate"
                                               placeholder="Due Date" autocomplete="false"
                                               value="<?php echo dateformat($invoice['invoiceduedate']) ?>">
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

                                     <option value="yes">Yes</option>
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
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="discountFormat"
                                               class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                        <input type="text" class="form-control" placeholder="İndirim" onkeyup="disc_degis(this.value)" name="discount_rate" id="discount_rate"
                                               value="<?php echo $invoice['discount_rate'] ?>">
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
                                                if($invoice['depo_id']==$cid)
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
                                                if($invoice['status']==$cid)
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

                                <div class="col-sm-3"><label for="project_name"
                                                             class="caption"><?php echo $this->lang->line('project_name') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Proje Adı "
                                               name="project_name" value="<?php echo $invoice['proje_adi'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-3"><label for="project_adresi"
                                                             class="caption"><?php echo $this->lang->line('project_adresi') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Proje Adresi"
                                               name="project_adresi" value="<?php echo $invoice['proje_adresi'];?>">
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
                                               name="project_sehir" value="<?php echo $invoice['proje_sehir'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-4"><label for="project_yetkli_no"
                                                             class="caption"><?php echo $this->lang->line('project_yetkli_no') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Proje Yetkili Numarası"
                                               name="project_yetkli_no"  value="<?php echo $invoice['proje_tel'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-4"><label for="proje_yetkili_adi"
                                                             class="caption"><?php echo $this->lang->line('proje_yetkili_adi') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Proje Yetkili Adı"
                                               name="proje_yetkili_adi"  value="<?php echo $invoice['proje_yetkili_adi'];?>">
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
                                               name="plaka_no" value="<?php echo $invoice['plaka_no'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-4"><label for="sofor_name"
                                                             class="caption"><?php echo $this->lang->line('sofor_name') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Şöför Adı"
                                               name="sofor_name"  value="<?php echo $invoice['sofor_name'];?>">
                                    </div>
                                </div>
                                <div class="col-sm-4"><label for="sofor_tel"
                                                             class="caption"><?php echo $this->lang->line('sofor_tel') ?></label>

                                    <div class="input-group">
                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                             aria-hidden="true"></span></div>
                                        <input type="text" class="form-control" placeholder="Şöför Telefonu"
                                               name="sofor_tel"  value="<?php echo $invoice['sofor_tel'];?>">
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
                                                $pers_id=$invoice['personel_id'];
                                                foreach ($emp as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['name'];
                                                    if($pers_id==$cid)
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
                                </div>
                                <div class="col-sm-6">
                                    <label for="toAddInfo"
                                           class="caption"><?php echo $this->lang->line('Purchase Note') ?></label>
                                    <textarea class="form-control round" name="notes"
                                              rows="2"><?php echo $invoice['notes'] ?></textarea></div>
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
                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Amount') . ' (' . $this->config->item('currency'); ?>
                                )
                            </th>
                            <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr></thead> <tbody>
                        <?php $i = 0;
                        foreach ($products as $row) {
                            echo '<tr >
                        <td>
                        <input type="text" class="form-control text-center" disabled id="productname-' . $i . '"  value="' . $row['product'] . '">
                        <input type="hidden" class="form-control text-center"  name="product_name[]" id="productname-' . $i . '"  value="' . $row['product'] . '">
                        </td>
                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
                                   onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog(),paketleme_hesapla(' . $i . ')"
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
                        <td><span class="currenty">' . $this->config->item('currency') . '</span>
                            <strong><span class="ttlText" id="result-' . $i . '">' . $row['subtotal'] . '</span></strong></td>
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
                                    if (isset($_GET['project'])) {
                                        echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                    } ?></span>
                                <input type="hidden" id="nettotalinp">
                                <span id="nettotal" class="lightMode">0</span></td>
                        </tr>

                        <tr class="sub_c" style="display: table-row;">
                            <td colspan="5" align="right"><input type="hidden"
                                                                 value="<?php echo $invoice['subtotal'] ?>"
                                                                 id="subttlform"
                                                                 name="subtotal"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
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
                            <td colspan=5 align="right"><strong><?php echo $this->lang->line('Grand Total') ?> (<span
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
                            <td align="right" colspan="5"><input type="submit" class="btn btn-success sub-btn"
                                                                 value="<?php echo $this->lang->line('Update') ?>"
                                                                 id="submit-data" data-loading-text="Updating...">
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>

                <input type="hidden" value="purchase/editaction" id="action-url">
                <input type="hidden" value="puchase_search" id="billtype">

                <input type="hidden" value="<?php echo $i ; ?>" name="counter" id="ganak">
                <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
                <input type="hidden" value="<?=$this->common->taxhandle_edit($invoice['taxstatus']) ?>" name="taxformat" id="tax_format">
                <input type="hidden" value="<?= $invoice['format_discount'] ; ?>" name="discountFormat" id="discount_format">
                <input type="hidden" value="<?= $invoice['taxstatus'] ; ?>" name="tax_handle" id="tax_status">
                <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
                <input type="hidden" value="<?=@number_format(($invoice['ship_tax']/$invoice['shipping'])*100,2,'.','') ?>" name="shipRate" id="ship_rate">
                <input type="hidden" value="<?=$invoice['ship_tax_type']; ?>" name="ship_taxtype" id="ship_taxtype">
                <input type="hidden" value="<?= $invoice['ship_tax'] ; ?>" name="ship_tax" id="ship_tax">


        </form>
            </div>
    </div>
    </div>
</div>

<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom crequired" name="email"
                                           id="mcustomer_email">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address" id="mcustomer_address1">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city" id="mcustomer_city">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region"
                                           class="form-control margin-bottom" name="region">
                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom" name="country" id="mcustomer_country">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox"
                                           class="form-control margin-bottom" name="postbox">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <input type="text" placeholder="Company"
                                           class="form-control margin-bottom" name="company">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" placeholder="TAX ID"
                                           class="form-control margin-bottom" name="taxid" id="mcustomer_city">
                                </div>


                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control">
                                        <?php
                                        foreach ($customergrouplist as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>


                        </div>

                        <!-- shipping -->
                        <div class="col-sm-6">
                            <h5><?php echo $this->lang->line('Shipping Address') ?></h5>
                            <div class="form-group row">

                                <div class="input-group">
                                    <label class="display-inline-block custom-control custom-radio ml-1">
                                        <input type="checkbox" name="customer1" class="custom-control-input"
                                               id="copy_address">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description ml-0"><?php echo $this->lang->line('Same As Billing') ?></span>
                                    </label>

                                </div>

                                <div class="col-sm-10">
                                    <?php echo $this->lang->line("leave Shipping Address") ?>
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name_s"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name_s" name="name_s"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone_s"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone_s" id="mcustomer_phone_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email_s"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom" name="email_s"
                                           id="mcustomer_email_s">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address_s"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address_s"
                                           id="mcustomer_address1_s">
                                </div>
                            </div>
                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="City"
                                           class="form-control margin-bottom" name="city_s" id="mcustomer_city_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="Region" id="region_s"
                                           class="form-control margin-bottom" name="region_s">
                                </div>

                            </div>

                            <div class="form-group row">


                                <div class="col-sm-6">
                                    <input type="text" placeholder="Country"
                                           class="form-control margin-bottom" name="country_s" id="mcustomer_country_s">
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" placeholder="PostBox" id="postbox_s"
                                           class="form-control margin-bottom" name="postbox_s">
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript"> $('.editdate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});</script>
<script>
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


    $(document).ready(function () {

        disc_degis($('#discount_rate').val());

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
</script>