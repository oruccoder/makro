<div class="app-content content container-fluid">

    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div><div id="thermal_a" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
                <form method="post" id="data_form">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="input-group">
										<span class="input-group-addon round"> <a href='#'
                                                                                     class="btn btn-primary btn-sm round inline"
                                                                                     data-toggle="modal"
                                                                                     data-target="#Pos_addCustomer">
                                        <i class="icon icon-plus-circle"></i> <?php echo $this->lang->line('Add') ?>
                                    </a></span>
										<input type="text" class="col-md-6 form-control round mousetrap" name="cst"
                                           id="pos-customer-box"
                                           placeholder="<?php echo $this->lang->line('Enter Customer Name'); ?> "
                                           autocomplete="off"/>

									</div>

                            <div class="row ml-3">




                                <div id="customer-box-result" class="col-md-12"></div>
                                <div id="customer" class="col-md-12 ml-3">
                                    <div class="clientinfo">

                                        <input type="hidden" name="customer_id" id="customer_id" value="1">
                                        <div id="customer_name"><?php echo $this->lang->line('Default'); ?>: <strong>Walk In </strong></div>
                                    </div>


                                </div>
                            </div>

                            <div id="saman-row-pos" class="rqw mt-1">
                                <div class="col-md-12">
                                    <table id="pos_list" class="table-responsive tfr pos_stripe">
                                        <thead>
                                        <tr class="item_header bg-gradient-directional-deep-purple white">

                                            <th width="10%"
                                                class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                            <th width="20%"
                                                class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                            <th width="10%"
                                                class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>

                                            <th width="10%"
                                                class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                            <th width="10%" class="text-center">
                                                <?php echo $this->lang->line('Amount') ?>
                                            </th>
                                            <th width="5%"
                                                class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                        </tr>

                                        </thead>
                                        <tbody id="pos_items">

                                        </tbody>
                                    </table>
                                    <br>
                                    <hr>

                                    <div class="row mt-1">

                                        <div class="col-xs-6">
                                            <div class="col-xs-6"><input type="hidden" value="0" id="subttlform"
                                                                         name="subtotal"> <input type="hidden" value="0" id="custom_discount"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                            </div>
                                            <div class="col-xs-6"><span
                                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                                                <span id="taxr" class="lightMode">0</span></div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="col-xs-6">
                                                <strong><?php echo $this->lang->line('Total Discount') ?></strong></div>
                                            <div class="col-xs-6"><span
                                                        class="currenty lightMode"><?php echo $this->config->item('currency');
                                                    if (isset($_GET['project'])) {
                                                        echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                                    } ?></span>
                                                <span id="discs" class="lightMode">0</span></div>
                                        </div>


                                    </div>
                                    <div class="row mt-1">


                                        <div class="col-sm-6">
                                            <div class="col-xs-6">
                                                <strong><?php echo $this->lang->line('Shipping') ?></strong></div>
                                            <div class="col-xs-6"><input type="text" class="form-control shipVal"
                                                                         onkeypress="return isNumber(event)"
                                                                         placeholder="Value"
                                                                         name="shipping" autocomplete="off"
                                                                         onkeyup="billUpyog()"> ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency');?> <span id="ship_final">0</span> )</div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col-xs-6"><strong><?php echo $this->lang->line('Grand Total') ?>
                                                    (<span
                                                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                            </div>
                                            <div class="col-xs-6"><input type="text" name="total" class="form-control"
                                                                         id="invoiceyoghtml" readonly=""></div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row mt-2">

   <div class="col-xs-2">

                                        </div>
                                        <div class="col-xs-8">

                                            <a href="#" class="possubmit btn btn-lg btn-cyan sub-btn" data-type="6"
                                           ><i class="icon icon-drag"></i> <?php echo $this->lang->line('Draft') ?></a>   <a href="#" class="possubmit3 btn btn-lg btn-green sub-btn" data-type="6" data-toggle="modal"
                                               data-target="#basicPay"><i class="icon icon-cash"></i> <?php echo $this->lang->line('Payment') ?></a>   <a href="#" class="possubmit2 btn btn-lg btn-blue-grey sub-btn" data-type="4" data-toggle="modal"
                                               data-target="#cardPay"><i class="icon icon-cc"></i> <?php echo $this->lang->line('Card') ?></a>
                                        </div>






                                    </div>


                                    <hr>


                                    <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">

                                           <div id="coupon4" class="card-header">
                                            <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                                               aria-expanded="false" aria-controls="accordion41"
                                               class="card-title lead collapsed red"><i class="icon icon-plus-circle"></i>
                                                 <?php echo $this->lang->line('Coupon') ?></a> &nbsp; <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#product41"
                                               aria-expanded="false" aria-controls="product41"
                                               class="card-title lead collapsed grey"><i class="icon icon-plus-circle"></i>
                                                 <?php echo $this->lang->line('POS').' '.$this->lang->line('Settings') ?></a>  &nbsp;  <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion4"
                                               aria-expanded="false" aria-controls="accordion4"
                                               class="card-title lead collapsed light-blue"><i class="icon icon-plus-circle"></i>
                                                Drafts</a> &nbsp; <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion1"
                                               aria-expanded="false" aria-controls="accordion1"
                                               class="card-title lead collapsed indigo"><i
                                                        class="icon icon-plus-circle"></i> <?php echo $this->lang->line('Invoice Properties') ?>
                                            </a>
                                        </div>
                                        <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                                             class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="row p-1">
<div class="col-xs-12">
                                    <div class="input-group">

										<input type="text" class="form-control"
                                                                     id="coupon" name="coupon"><input type="hidden"
                                                                                                      name="coupon_amount"
                                                                                                      id="coupon_amount"
                                                                                                      value="0"><span class="input-group-addon round"> <button class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>


									</div></div>
    <div class="col-xs-12">

<span class="text-primary text-bold-600" id="r_coupon"></span></div></div>
                                        </div>


                                        <div id="product41" role="tabpanel" aria-labelledby="coupon4"
                                             class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="row p-1">
<div class="col-xs-12">
                                  <div class="col-md-4 grey text-xs-center"><?php echo $this->lang->line('Warehouse') ?> <select
                                                id="warehouses"
                                                class="selectpicker form-control round teal">
                                           <?php echo $this->common->default_warehouse(); echo  '<option value="0">'.$this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                                echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                            } ?>

                                        </select></div>
                                    <div class="col-md-4 grey text-xs-center"><?php echo $this->lang->line('Tax') ?>
                                                  <select class="form-control round"
                                                onchange="changeTaxFormat(this.value)"
                                                id="taxformat">
                                                     <?php echo $taxlist; ?>
                                        </select></div>
                                    <div class="col-md-4 grey text-xs-center">  <?php echo $this->lang->line('Discount') ?>
                                        <select class="form-control round teal" onchange="changeDiscountFormat(this.value)"
                                                id="discountFormat">

                                             <?php echo $this->common->disclist() ?>
                                        </select></div></div>
    <div class="col-xs-12">
                                    <input type="hidden" class="text-info" name="i_coupon" id="i_coupon"  value="">
<span class="text-primary text-bold-600" id="r_coupon"></span></div></div>
                                        </div>


                                        <div id="accordion1" role="tabpanel" aria-labelledby="heading1"
                                             class="card-collapse collapse" aria-expanded="false" style="">


                                            <div class="form-group row">
                                                <div class="col-sm-3"><label for="invocieno"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-file-text-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control" placeholder="Invoice #"
                                                               name="invocieno" id="invocieno"
                                                               value="<?php echo $lastinvoice + 1 ?>">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><label for="invocieno"
                                                                             class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control"
                                                               placeholder="Reference #"
                                                               name="refer">
                                                    </div>
                                                </div>


                                                <div class="col-sm-3"><label for="invociedate"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar4"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control required"
                                                               placeholder="Billing Date" name="invoicedate"
                                                               data-toggle="datepicker"
                                                               autocomplete="false">
                                                    </div>
                                                </div>
                                                <div class="col-sm-3"><label for="invocieduedate"
                                                                             class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                             aria-hidden="true"></span>
                                                        </div>
                                                        <input type="text" class="form-control required" id="tsn_due"
                                                               name="invocieduedate"
                                                               placeholder="Due Date" data-toggle="datepicker"
                                                               autocomplete="false">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <?php echo $this->lang->line('Payment Terms') ?> <select
                                                            name="pterms"
                                                            class="selectpicker form-control"><?php foreach ($terms as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                        } ?>

                                                    </select>
                                                    <?php if ($exchange['active'] == 1) {
                                                        echo $this->lang->line('Payment Currency client') ?>
                                                    <?php } ?>
                                                    <?php if ($exchange['active'] == 1) {
                                                        ?>
                                                        <select name="mcurrency"
                                                                class="selectpicker form-control">
                                                        <option value="0">Default</option>
                                                        <?php foreach ($currency as $row) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                                        } ?>

                                                        </select><?php } ?>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="toAddInfo"
                                                           class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                                    <textarea class="form-control" name="notes" rows="2"></textarea>
                                                </div>
                                            </div>


                                        </div>


                                        <div id="heading4" class="card-header">

                                        </div>
                                        <div id="accordion4" role="tabpanel" aria-labelledby="heading4"
                                             class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                                            <div class="card-body">
                                                <div class="card-block">
                                                    <ul>
                                                      <?php foreach ($draft_list as $rowd) {
                                                            echo '<li class="indigo p-1"><a href="'.base_url().'pos_invoices/draft?id=' . $rowd['id'] . '"> #' . $rowd['tid'] . ' (' . $rowd['invoicedate'] . ')</a></li>';
                                                        } ?></ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 border-amber bg-lighten-1 bg-faded round pt-1">


                            <div class="row">

                                <div class="col-md-12">

                                    <div class="col-md-9 col-sm-12  pb-1">
                                    <input type="text" class="form-control text-center round mousetrap" name="product_barcode"
                                           placeholder="Enter Product name or scan barcode " id="search_bar" autocomplete="off" autofocus="autofocus">
                                </div>  <div class="col-md-3  grey text-xs-center"> <select
                                                id="categories"
                                                class="selectpicker form-control round teal">
                                            <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                                            foreach ($cat as $row) {
                                                $cid = $row['id'];
                                                $title = $row['title'];
                                                echo "<option value='$cid'>$title</option>";
                                            }
                                            ?>
                                        </select></div>

                                </div>
                            </div>  <hr class="white">


                            <div class="row">
                                <div class="col-md-12 pt-0" id="pos_item">
                                    <!-- pos items -->
                                </div>
                            </div>
                        </div>


                    </div>
                    <br>


            </div>

            <input type="hidden" value="pos_invoices/action" id="action-url">
            <input type="hidden" value="search" id="billtype">
            <input type="hidden" value="0" name="counter" id="ganak">
            <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
               <input type="hidden" value="<?=$taxdetails['handle']; ?>" name="taxformat" id="tax_format">

                    <input type="hidden" value="<?=$taxdetails['format']; ?>" name="tax_handle" id="tax_status">
            <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">

            <input type="hidden" value="<?=$this->common->disc_status()['disc_format']; ?>" name="discountFormat" id="discount_format">
                    <input type="hidden" value="<?=$this->common->disc_status()['ship_rate']; ?>" name="shipRate" id="ship_rate">
                    <input type="hidden" value="<?=$this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype" id="ship_taxtype">
                    <input type="hidden" value="0" name="ship_tax" id="ship_tax">


            </form>
        </div>

    </div>
</div>
</div>
<div id="shortkeyboard" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ShortCuts</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Alt+X</td>
                        <td>Focus to products search</td>
                    </tr>
                    <tr>
                        <td>Alt+C</td>
                        <td>Focus to customer search</td>
                    </tr>

                     <tr>
                        <td>Alt+S (twice)</td>
                        <td>PayNow + Thermal Print</td>
                    </tr>
                    <tr>
                        <td>Alt+Z</td>
                        <td>Make Card Payment</td>
                    </tr>
                      <tr>
                        <td>Alt+Q</td>
                        <td>Select First product</td>
                    </tr>
                           <tr>
                        <td>Alt+N</td>
                        <td>Create New Invoice</td>
                    </tr>



                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="Pos_addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-green white">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="icon-user-plus"></i> <?php echo $this->lang->line('Add Customer') ?></h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-12">
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
                                           class="form-control margin-bottom" name="email"
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


                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/ >
                </div>
            </form>
        </div>
    </div>
</div>
<!--card-->
<div class="modal fade" id="cardPay" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="card_data" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p>

                    <form role="form" id="payment-form">

                        <div class="row">
                            <div class="col-xs-12 credit-card-box ">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="card-title mb-3">
                                            <label for="cardNumber"><?php echo $this->lang->line('Payment Gateways') ?></label>
                                            <select class="form-control" name="gateway"><?php


                                                $surcharge_t = false;
                                                foreach ($gateway as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['name'];
                                                    if ($row['surcharge'] > 0) {
                                                        $surcharge_t = true;
                                                        $fee = '(<span class="gate_total"></span>+' . amountFormat_s($row['surcharge']) . ' %)';
                                                    } else {
                                                        $fee = '';
                                                    }
                                                    echo "<option value='$cid'>$title $fee</option>";
                                                }
                                                ?>
                                            </select></div>
                                    </div>
                                    <div class="col-xs-6"><br><img class="img-responsive pull-right"
                                                                   src="<?php echo base_url('assets/images/accepted_c22e0.png') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cardNumber"><?php echo $this->lang->line('CARD NUMBER') ?></label>
                                    <div class="input-group">
                                        <input
                                                type="tel"
                                                class="form-control"
                                                name="cardNumber"
                                                placeholder="Valid Card Number"
                                                autocomplete="cc-number"
                                                required autofocus
                                        />
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardExpiry"><span
                                                class="hidden-xs"><?php echo $this->lang->line('EXPIRATION') ?></span><span
                                                class="visible-xs-inline"><?php echo $this->lang->line('EXP') ?></span> <?php echo $this->lang->line('DATE') ?>
                                    </label>
                                    <input
                                            type="tel"
                                            class="form-control"
                                            name="cardExpiry"
                                            placeholder="MM / YY"
                                            autocomplete="cc-exp"
                                            required
                                    />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC"><?php echo $this->lang->line('CV CODE') ?></label>
                                    <input
                                            type="password" maxlength="4"
                                            class="form-control"
                                            name="cardCVC"
                                            placeholder="CVC"
                                            autocomplete="cc-csc"
                                            required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="amount"><?php echo $this->lang->line('Amount') ?>
                                    </label>
                                    <input type="number" class="form-control" name="amount" id="card_total"
                                           value="0.00"
                                           required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block"
                                        type="submit"
                                        id="pos_card_pay" data-type="2"><?php echo $this->lang->line('Paynow') ?></button>
                            </div>
                        </div>
                        <div class="form-group">

                            <?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>

                        <input type="hidden" value="pos_invoices/action" id="pos_action-url">
                    </form>

                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="basicPay" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="basicpay_data" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p>

                    <form role="form" id="payment-form">
                    <div class="row">
                            <div class="col-xs-12 credit-card-box ">
                                <div class="text-xs-center"><h1 id="b_total"></h1></div>
                                <div class="row">
                                     <div class="col-xs-8">
                                        <div class="card-title">
                                            <label for="cardNumber"><?php echo $this->lang->line('Amount') ?></label>
                                    <div class="input-group">
                                        <input
                                                type="number"
                                                class="form-control  text-bold-600 blue-grey"
                                                name="p_amount"
                                                placeholder="Amount"
                                                id="p_amount" onkeyup="update_pay_pos()"
                                        />
                                        <span class="input-group-addon"><i class="icon icon-cash"></i></span>
                                    </div></div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="card-title">
                                            <label for="cardNumber"><?php echo $this->lang->line('Payment Method') ?></label>
                                            <select class="form-control" name="p_method"  id="p_method">
                                                <option value='Cash'><?php echo $this->lang->line('Cash') ?></option>
                                                <option value='Card Swipe'><?php echo $this->lang->line('Card Swipe') ?></option>
                                                 <option value='Bank'><?php echo $this->lang->line('Bank') ?></option>

                                            </select></div>
                                    </div>

                                </div>
                                <div class="form-group">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group  text-bold-600 red">
                                    <label for="amount"><?php echo $this->lang->line('Balance Due') ?>
                                    </label>
                                    <input type="number" class="form-control red" name="amount" id="balance1"
                                           value="0.00"
                                           required>
                                </div>
                            </div>
                             <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 text-g">
                                    <label for="b_change"><?php echo $this->lang->line('Change') ?></label>
                                    <input
                                            type="number"
                                            class="form-control green"
                                            name="b_change" id="change_p" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block"
                                        type="submit"
                                        id="pos_basic_pay"  data-type="4"><i class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Paynow') ?></button>
                            </div>
                        </div>

                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>


                    </form>

                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Your Register') ?></h4>
                    <?php echo $this->lang->line('Active') ?> - <span id="r_date"></span>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">


                   <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group  text-bold-600 green">
                                    <label for="amount"><?php echo $this->lang->line('Cash') ?>
                                    </label>
                                    <input type="number" class="form-control green" id="r_cash"
                                           value="0.00"
                                           readonly>
                                </div>
                            </div>
                             <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 blue">
                                    <label for="b_change blue"><?php echo $this->lang->line('Card') ?></label>
                                    <input
                                            type="number"
                                            class="form-control blue"
                                            id="r_card" value="0" readonly>
                                </div>
                            </div>
                        </div>

                     <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group  text-bold-600 indigo">
                                    <label for="amount"><?php echo $this->lang->line('Bank') ?>
                                    </label>
                                    <input type="number" class="form-control indigo" id="r_bank"
                                           value="0.00"
                                           readonly>
                                </div>
                            </div>
                             <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 red">
                                    <label for="b_change"><?php echo $this->lang->line('Change') ?>(-)</label>
                                    <input
                                            type="number"
                                            class="form-control red"
                                            id="r_change" value="0" readonly>
                                </div>
                            </div>
                        </div>




                        <div class="row" style="display:none;">
                            <div class="col-xs-12">
                                <p class="payment-errors"></p>
                            </div>
                        </div>




                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="close_register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Close') ?> <?php echo $this->lang->line('Your Register') ?></h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

<div class="row">   <div class="col-xs-4"> </div>
                            <div class="col-xs-4">
                                <a href="<?=base_url() ?>/register/close" class="btn btn-danger btn-lg btn-block"
                                        type="submit"
                                        id="pos_basic_pay"  data-type="4"><i class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Yes') ?></a>
                            </div><div class="col-xs-4"> </div>
                        </div>

                </div>
                <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="stock_alert" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title"><?php echo $this->lang->line('Stock Alert') ?> !</h4>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">

<div class="row p-1">  <div class="alert alert-danger mb-2" role="alert">
									<strong>Oh snap!</strong> <?php echo $this->lang->line('order or edit the stock') ?>
								</div>
                        </div>

                </div>
                <!-- Modal Footer -->


        </div>
    </div>
</div>
<script type="text/javascript">
    $.ajax({
        url: baseurl + 'search_products/pos_search',
        dataType: 'html',
        method:'POST',
        data: 'cid=' + $('#categories').val() + '&wid=' + $('#warehouses option:selected').val()+'&'+crsf_token+'='+crsf_hash,
        success: function (data) {
            $('#pos_item').html(data);
        }
    });
    function update_register(){
            $.ajax({
        url: baseurl + 'register/status',
        dataType: 'json',
        success: function (data) {
            $('#r_cash').val(data.cash);
             $('#r_card').val(data.card);
              $('#r_bank').val(data.bank);
               $('#r_change').val(data.change);
                $('#r_date').text(data.date);
        }
    });
    }

update_register();
    $(".possubmit").on("click", function (e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });

    $(".possubmit2").on("click", function (e) {
        e.preventDefault();
        $('#card_total').val($('#invoiceyoghtml').val());
    });

     $(".possubmit3").on("click", function (e) {
        e.preventDefault();
        $('#b_total').html($('#invoiceyoghtml').val());
        $('#p_amount').val($('#invoiceyoghtml').val());

    });

     function update_pay_pos()
     {
           var am_pos = $('#p_amount').val();
           var ttl_pos = $('#invoiceyoghtml').val();

           var due = parseFloat(ttl_pos-am_pos).toFixed(2);

           if(due>=0) {
               $('#balance1').val(due);
                 $('#change_p').val(0);
           }
           else{
               due=due*(-1)
                $('#balance1').val(0);
                 $('#change_p').val(due);
           }

     }

    $('#pos_card_pay').on("click", function (e) {
        e.preventDefault();
        $('#cardPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&'+ $("#card_data").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        update_register();
    });

       $('#pos_basic_pay').on("click", function (e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize()+'&p_amount='+$("#p_amount").val() +'&p_method='+$("#p_method option:selected").val() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
       addObject(o_data, action_url);

       setTimeout(
  function()
  {
      update_register();
  }, 3000);


    });
</script> <?php
/*
The MIT License (MIT)

Copyright (c) 2015 William Hilton

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
?>
<!-- Vendor libraries -->
<script type="text/javascript">
    var $form = $('#payment-form');
    $form.on('submit', payWithCard);

    /* If you're using Stripe for payments */
    function payWithCard(e) {
        e.preventDefault();

        /* Visual feedback */
        $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>')
            .prop('disabled', true);

        jQuery.ajax({

            url: '<?php echo base_url('billing/process_card') ?>',
            type: 'POST',
            data: $('#payment-form').serialize(),
            dataType: 'json',
            success: function (data) {

                $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            },
            error: function () {
                $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                /* Show Stripe errors on the form */
                $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                $form.find('.payment-errors').closest('.row').show();
                $form.find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                    .prop('disabled', true);
                $("#notify .message").html("<strong>Error</strong>: Please try again!");


            }

        });


    }

    /* Fancy restrictive input formatting via jQuery.payment library*/
    $('input[name=cardNumber]').payment('formatCardNumber');
    $('input[name=cardCVC]').payment('formatCardCVC');
    $('input[name=cardExpiry]').payment('formatCardExpiry');

    /* Form validation using Stripe client-side validation helpers */
    jQuery.validator.addMethod("cardNumber", function (value, element) {
        return this.optional(element) || Stripe.card.validateCardNumber(value);
    }, "Please specify a valid credit card number.");

    jQuery.validator.addMethod("cardExpiry", function (value, element) {
        /* Parsing month/year uses jQuery.payment library */
        value = $.payment.cardExpiryVal(value);
        return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
    }, "Invalid expiration date.");

    jQuery.validator.addMethod("cardCVC", function (value, element) {
        return this.optional(element) || Stripe.card.validateCVC(value);
    }, "Invalid CVC.");

    validator = $form.validate({
        rules: {
            cardNumber: {
                required: true,
                cardNumber: true
            },
            cardExpiry: {
                required: true,
                cardExpiry: true
            },
            cardCVC: {
                required: true,
                cardCVC: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('success').addClass('error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('error').addClass('success');
        },
        errorPlacement: function (error, element) {
            $(element).closest('.form-group').append(error);
        }
    });

    paymentFormReady = function () {
        if ($form.find('[name=cardNumber]').hasClass("success") &&
            $form.find('[name=cardExpiry]').hasClass("success") &&
            $form.find('[name=cardCVC]').val().length > 1) {
            return true;
        } else {
            return false;
        }
    }

    $form.find('[type=submit]').prop('disabled', true);
    var readyInterval = setInterval(function () {
        if (paymentFormReady()) {
            $form.find('[type=submit]').prop('disabled', false);
            clearInterval(readyInterval);
        }
    }, 250);

     $(document).ready(function () {
        Mousetrap.bind('alt+x', function () {
            $('#search_bar').focus();
        });
        Mousetrap.bind('alt+c', function () {
            $('#pos-customer-box').focus();
        });

        Mousetrap.bind('alt+z', function () {
            $('.possubmit2').click();
        });
        Mousetrap.bind('alt+n', function () {
           window.location.href = "<?=base_url('pos_invoices/create') ?>";
        });
             Mousetrap.bind('alt+q', function () {
            $('#posp0').click();
        });
                     Mousetrap.bind('alt+s', function () {
                         if($('#basicPay').hasClass('in')){
                               $('#pos_basic_print').click();
                         }
                         else{
                              $('.possubmit3').click();
                         }

        });
$('#search_bar').keypress(function(event){
  if(event.keyCode == 13){
     $('#posp0').click();
  }
});
    });
</script>