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
                                                <div class="col-sm-6 cmp-pnl">
                                                    <div id="customerpanel" class="inner-cmp-pnl">
                                                        <div class="form-group row">
                                                            <div class="fcol-sm-12">
                                                                <h3 class="title">
                                                                   Cari Seçiniz
                                                                </h3>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">

                                                            <div class="frmSearch col-sm-12">
                                                                <label for="cst" class="caption">Cari Seçiniz</label><span class='text-danger'>*</span>

                                                                <select class="select-box form-control" name="customer_id" disabled id="customer_id">
                                                                    <option value="0">Fatura Tipi Seçiniz</option>
                                                                    <?php foreach (all_customer() as $customer_item){
                                                                        echo '<option value="'.$customer_item->id.'">'.$customer_item->company.'</option>';
                                                                    } ?>
                                                                </select>
<!--                                                                <input disabled title="Fatura Tipini Seçiniz" type="text" class="form-control " name="cst" id="customer-box"-->
<!--                                                                       placeholder="Müşteri Adı veya Telefon Numarası Giriniz"-->
<!--                                                                       autocomplete="off"/>-->
<!---->
<!--                                                                <div id="customer-box-result"></div>-->
                                                            </div>

                                                        </div>
                                                        <div id="customer">
<!--                                                            <div class="clientinfo">-->
<!--                                                                --><?php //echo $this->lang->line('Client Details'); ?>
<!--                                                                <hr>-->
<!--                                                                <input type="hidden" name="customer_id" class="zorunlu" id="customer_id" value="0">-->
<!--                                                                <div id="customer_company"></div>-->
<!--                                                            </div>-->
<!--                                                            <div class="clientinfo" style="display: none">-->
<!---->
<!--                                                                <div id="customer_name"></div>-->
<!--                                                            </div>-->
<!--                                                            <div class="clientinfo">-->
<!---->
<!--                                                                <div id="customer_address1"></div>-->
<!--                                                            </div>-->
<!---->
<!--                                                            <div class="clientinfo">-->
<!---->
<!--                                                                <div id="customer_phone"></div>-->
<!--                                                            </div>-->
<!--                                                            <div class="clientinfo">-->
<!---->
<!--                                                                <div id="customer_credit"></div>-->
<!--                                                            </div>-->
<!--                                                            <div class="clientinfo">-->
<!---->
<!--                                                                <div id="customer_kalan_credit"></div>-->
<!--                                                            </div>-->
<!--                                                            <div class="clientinfo">-->
<!---->
<!--                                                                <div id="customer_hesaplaan_kalan_credit"></div>-->
<!--                                                            </div>-->
<!--                                                            <hr>-->
<!--                                                            <div id="customer_pass"></div>-->



                                                            <div class="form-group row">
                                                                <div class="col-sm-6"><label for="invocieno"
                                                                                             class="caption"><?php echo $this->lang->line('invoice_type') ?></label><span class='text-danger'>*</span>

                                                                    <div class="input-group">

                                                                        <select name="invoice_type" id="invoice_type" class="selectpicker form-control zorunlu">
                                                                            <option value="0">Fatura Tipini Seçiniz</option>
                                                                            <?php foreach (invoice_type() as $row) {
                                                                                echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                                                                            } ?>

                                                                        </select>
                                                                    </div>
                                                                </div>
<!--                                                                <div class="col-sm-6"><label for="invocieno"-->
<!--                                                                                             class="caption">--><?php //echo $this->lang->line('invoice_iscilik_label') ?><!--</label>-->
<!---->
<!--                                                                    <div class="input-group">-->
<!--                                                                        <a style="color: #fff;" class="btn btn-success iscilik_fiyati_al" id="iscilik_fiyati_al">--><?php //echo $this->lang->line('invoice_iscilik_button') ?><!--</a>-->
<!---->
<!--                                                                    </div>-->
<!--                                                                </div>-->
                                                            </div>




                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="col-sm-6 cmp-pnl">
                                                    <div class="inner-cmp-pnl">


                                                        <div class="form-group row">

                                                            <div class="col-sm-12"><h3
                                                                        class="title"><?php echo $this->lang->line('Invoice Properties') ?></h3>
                                                            </div>

                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-3"><label for="invocieno"
                                                                                         class="caption"><?php echo $this->lang->line('Invoice Number') ?></label><span class='text-danger'>*</span>

                                                                <div class="input-group">

                                                                    <input type="text" class="zorunlu form-control  required" placeholder="Invoice #" name="invoice_no" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"><label for="invocieno"
                                                                                         class="caption"><?php echo $this->lang->line('Reference') ?></label>

                                                                <div class="input-group">
                                                                    <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                                                         aria-hidden="true"></span></div>
                                                                    <input type="text" class="form-control " placeholder="Reference #"
                                                                           name="refer">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"><label for="invociedate"
                                                                                         class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label><span class='text-danger'>*</span>

                                                                <div class="input-group">
                                                                    <div class="input-group-addon"><span class="icon-calendar4"
                                                                                                         aria-hidden="true"></span></div>


                                                                    <input type="text" class="form-control  required zorunlu"
                                                                           placeholder="Fatura Tarihi" name="invoicedate" id="invoice_date"
                                                                           data-toggle="invoicedate"
                                                                           autocomplete="false">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"><label for="invocieduedate"
                                                                                         class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                                                                <div class="input-group">
                                                                    <div class="input-group-addon"><span class="icon-calendar-o"
                                                                                                         aria-hidden="true"></span></div>
                                                                    <input type="text" class="form-control " id="tsn_due"
                                                                           name="invocieduedate"
                                                                           placeholder="Due Date" data-toggle="datepicker" autocomplete="false">
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
                                                                            echo "<option value='$cid'>$title</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>



                                                            <div class="col-sm-3">
                                                                <label for="invoice_para_birimi" class="caption"><?php echo $this->lang->line('invoice_para_birimi'); ?></label>

                                                                <div class="input-group">
                                                                    <select name="para_birimi" id="para_birimi" class="form-control">
                                                                        <?php
                                                                        foreach (para_birimi()  as $row) {
                                                                            $cid = $row['id'];
                                                                            $title = $row['code'];
                                                                            echo "<option value='$title'>$title</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3"><label for="invocieduedate"
                                                                                         class="caption"><?php echo $this->lang->line('invoice_kur_degeri') ?></label>

                                                                <div class="input-group">
                                                                    <input type="text" class="form-control " placeholder="Kur"
                                                                           name="kur_degeri" id="kur_degeri" value="1">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="invocieduedate" class="caption">Stok Güncelleme</label>
                                                                <div style="font-size: 10px" class="form-text text-muted">Eğer Seçili İse Stok Güncellenmeyecektir</div>
                                                                <div class="input-group">
                                                                    <input type="checkbox" checked class="form-control" name="stok_durumu">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row hidden">
                                                            <div class="col-sm-6">
                                                                <label for="taxformat"
                                                                       class="caption"><?php echo $this->lang->line('Tax') ?></label>
                                                                <select class="form-control "
                                                                        onchange="changeTaxFormat(this.value)"
                                                                        id="taxformat">

                                                                    <?php echo $taxlist; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">

                                                                <div class="form-group">
                                                                    <label for="discountFormat"
                                                                           class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                                                    <select class="form-control " onchange="changeDiscountFormat(this.value)"
                                                                            id="discountFormat">

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
                                                                    <select class="form-control "
                                                                            id="discount_format" name="discount_format">

                                                                        <?php echo " <option  value='%'>Yüzde (%)</option>
                                                                                    <option selected value='flat'>Sabit</option>";
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">

                                                                <div class="form-group">
                                                                    <label for="discountFormat"
                                                                           class="caption"><?php echo $this->lang->line('Discount') ?></label>
                                                                    <input type="text" class="form-control" placeholder="İndirim" onkeyup="disc_degis(this.value)" name="discount_rate" id="discount_rate"
                                                                    >
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
                                                                       class="caption">Proje Seçiniz</label><span class='text-danger'>*</span>
                                                                <select class="form-control select-box required zorunlu" name="proje_id" id="proje_id">
                                                                    <option value="0">Seçiniz</option>
                                                                    <?php foreach (all_projects() as $project){ ?>
                                                                        <option value="<?php  echo $project->id ?>"><?php  echo $project->name ?></option>
                                                                    <?php } ?>

                                                                </select>

                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo" class="caption">Bölüm Seçiniz</label>
                                                                <select name="bolum_id" class="form-control select-box" id="bolum_id">
                                                                    <option value="0">Seçiniz</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo" class="caption">Aşama Seçiniz</label>
                                                                <select name="asama_id" class="form-control select-box" id="asama_id">
                                                                    <option value="0">Seçiniz</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo" class="caption">Alt Seçiniz</label>
                                                                <select name="alt_asama_id" class="form-control select-box" id="alt_asama_id">
                                                                    <option value="0">Seçiniz</option>
                                                                </select>
                                                            </div>


                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo" class="caption">İş Kalemi Seçiniz</label>
                                                                <select name="task_id" class="form-control select-box" id="task_id">
                                                                    <option value="0">Seçiniz</option>

                                                                </select>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo" class="caption">Ödeme Tipi</label>
                                                                <select name="paymethod" class="form-control" id="paymethod">
                                                                    <?php foreach (account_type_islem() as $acc)
                                                                    {
                                                                        echo "<option value='$acc->id'>$acc->name</option>";

                                                                    } ?>
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo"
                                                                       class="caption">Avans Talep Formu</label>
                                                                <select class="form-control select-box" multiple name="avans_talep_formu[]">
                                                                    <option value="0">Avans Talep Formu Seçiniz</option>
                                                                    <?php foreach (talep_list(5) as $talep)
                                                                    {
                                                                        echo "<option value='$talep->id'>$talep->talep_no</option>";
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo"
                                                                       class="caption">Malzeme Talep Formu</label>
                                                                <select class="form-control select-box" multiple name="malzeme_talep_id[]">
                                                                    <option value="0">Malzeme Talep Formu Seçiniz</option>
                                                                    <?php foreach (talep_list(1) as $talep)
                                                                    {
                                                                        echo "<option value='$talep->id'>$talep->talep_no</option>";
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <label for="toAddInfo"
                                                                       class="caption">Nakliye Talep Formu</label>
                                                                <select id="search_input_nakliye" class="select-box" multiple name="search_input_nakliye[]" style="width: 300px; height: 150px;"></select>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <label for="toAddInfo"
                                                                       class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                                                <textarea class="form-control " name="notes" rows="2"></textarea>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="toAddInfo"
                                                                       class="caption">Forma2 Listesi</label>
                                                                <select class="form-control select-box" multiple name="forma2_id[]" id="forma2_id">
                                                                    <option value="0">Cari Seçiniz</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <label for="toAddInfo"
                                                                       class="caption">Tehvil Formu Listesi</label>
                                                                <select class="form-control select-box" multiple name="tehvil_id[]" id="tehvil_id">
                                                                    <option value="0">Cari ve Fatura Tipi Seçiniz</option>

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
                                                        <th width="30%"  class="text-center sozle_hid">Açıklama</th>
                                                        <th width="8%" class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                                                        <th width="10%" class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                                                        <th width="10%" class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>
                                                        <th width="7%" class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                                                        <th width="10%" class="text-center">
                                                            <?php echo $this->lang->line('Amount') ?>
                                                            <span class="currenty">(<?= currency($this->aauth->get_user()->loc); ?>)</span>
                                                        </th>
                                                        <th width="15%" class="text-center">Depo</th>
                                                        <th width="5%" class="text-center"><?php echo $this->lang->line('Action') ?></th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="text" class="form-control text-center" name="product_name[]"
                                                                   placeholder="<?php echo $this->lang->line('Enter Product name') ?>" id='productname-0'>
                                                        </td>
                                                        <td class="sozle_hid"><input type="text" class="form-control text-center" name="item_desc[]"
                                                                                     id='item_desc-0'>
                                                        </td>
                                                        <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-0"
                                                                   onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()"
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
                                                        <td>
                                                            <select name="depo_id_item[]" class="select2 form-control depo_id_item select-box">
                                                                <?php
                                                                foreach ($warehouse as $rows) {
                                                                    $cid = $rows->id;
                                                                    $title = $rows->title;
                                                                    echo "<option value='$cid'>$title</option>";

                                                                }?>


                                                            </select>
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

                                                    </tbody>

                                                    <tfoot>
                                                    <tr class="last-item-row sub_c">
                                                        <td class="add-row">
                                                            <button type="button" class="btn btn-success" aria-label="Left Align" id="addproduct">
                                                                <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                                            </button>
                                                        </td>
                                                        <td colspan="7"></td>
                                                    </tr>
                                                    <tr class="sub_c" style="display: table-row;">
                                                        <td colspan="4" align="right">
                                                            <input type="hidden" value="0" id="subtotal"  name="subtotal">
                                                            <strong><?php echo $this->lang->line('Sub Total') ?></strong>
                                                        </td>
                                                        <td align="left" colspan="1"><span
                                                                    class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                                            <span id="subtotalr" class="lightMode">0</span></td>
                                                        <td align="left" colspan="1">
                                                            <select id="ara_top_pre" class="form-control">
                                                                <option value="1">(+)</option>
                                                                <option value="2">(-)</option>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <input value="0" onkeyup="kusurat_hesapla(this,'ara_toplam')" id="ara_top_kus" name="ara_top_kus" class="form-control" type="text">
                                                        </td>
                                                    </tr>
                                                    <tr class="sub_c" style="display: table-row;">
                                                        <td colspan="4" align="right">
                                                            <strong><?php echo $this->lang->line('Total Discount') ?></strong></td>
                                                        <td align="left" colspan="2"><span
                                                                    class="currenty lightMode"><?php echo $this->config->item('currency');
                                                                if (isset($_GET['project'])) {
                                                                    echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                                                } ?></span>
                                                            <span id="discs" class="lightMode">0</span></td>
                                                    </tr>
                                                    <tr class="sub_c" style="display: table-row;">
                                                        <td colspan="4" align="right">
                                                            <strong><?php echo $this->lang->line('Net Total') ?></strong></td>
                                                        <td align="left" colspan="1"><span
                                                                    class="currenty lightMode"><?php echo $this->config->item('currency');
                                                                if (isset($_GET['project'])) {
                                                                    echo '<input type="hidden" value="' . intval($_GET['project']) . '" name="prjid">';
                                                                } ?></span>
                                                            <input type="hidden" id="nettotalinp">
                                                            <span id="nettotal" class="lightMode">0</span></td>

                                                        <td align="left" colspan="1">
                                                            <select id="net_total_pre" class="form-control">
                                                                <option value="1">(+)</option>
                                                                <option value="2">(-)</option>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <input value="0" onkeyup="kusurat_hesapla(this,'net_toplam')" id="net_toplam_kus" name="net_toplam_kus" class="form-control" type="text">
                                                        </td>
                                                    </tr>
                                                    <tr class="sub_c" style="display: table-row;">
                                                        <td colspan="4" align="right">
                                                            <input type="hidden" value="0" id="subttlform"  name="subtotal">
                                                            <input type="hidden" value="0" id="subttlform2" >
                                                            <strong><?php echo $this->lang->line('Total Tax') ?></strong>
                                                        </td>
                                                        <td align="left" colspan="1"><span
                                                                    class="currenty lightMode"><?= $this->config->item('currency');?></span>
                                                            <span id="taxr" class="lightMode">0</span>
                                                            <input type="hidden" value="0" id="taxr2" >
                                                        </td>

                                                        <td align="left" colspan="1">
                                                            <select id="tax_pre" class="form-control">
                                                                <option value="1">(+)</option>
                                                                <option value="2">(-)</option>
                                                            </select>

                                                        </td>
                                                        <td>
                                                            <input value="0" onkeyup="kusurat_hesapla(this,'tax_hesapla')" id="tax_kus" name="tax_kus" class="form-control" type="text">
                                                        </td>
                                                    </tr>
                                                    <tr class="sub_c hidden">
                                                        <td colspan="4" align="right">
                                                            <strong><?php echo $this->lang->line('Shipping') ?></strong></td>
                                                        <td></td>
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
                                                        <td colspan="2" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                                                                (<span
                                                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                                                        </td>
                                                        <td></td>
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
                                                        <td align="right" colspan="6">
                                                            <button type="button" class="btn btn-success" value="Kaydet" id="new_create">Kaydet</button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>



                                                </table>
                                            </div>
                                            <input type="hidden" value="new_i" id="inv_page">
                                            <input type="hidden" value="<?php echo $this->aauth->get_user()->loc ?>" id="loc_id">
                                            <input type="hidden" value="invoices/action" id="action-url">
                                            <input type="hidden" value="search" id="billtype">
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
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sozle_hid
    {
        display: none;
    }
</style>
<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-purple white">

                    <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('Add Customer') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
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

                                <label class="col-sm-2 col-form-label  col-form-label-sm"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control form-control-sm">
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
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="customer1s"
                                           id="copy_address">
                                    <label class="custom-control-label"
                                           for="copy_address"><?php echo $this->lang->line('Same As Billing') ?></label>
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
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="Ekle"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/i18n/tr.min.js"></script>

<script>







    $(document).ready(function () {

        disc_degis($('#discount_rate').val());

        alert('<?php echo $this->lang->line('invoice_type_message'); ?>');





    });

    let val = 0;
    $('#satinalma_talep_id').on('change',function (){
        $('.my_stripe tbody tr').remove();
        $('.my_stripe .ek_tr').remove();
        let id = $(this).val();
        let customer_id = $('#customer_id').val();
        if(customer_id!=0){

            $.ajax({
                type: "POST",
                url: baseurl + 'invoices/talep_invoice_stock',
                data:
                    'cari_id='+ customer_id+
                    '&sf_id='+ id+
                    '&'+crsf_token+'='+crsf_hash,
                success: function (data) {
                    let details = jQuery.parseJSON(data);
                    if(details.status=='Success'){
                        jQuery.each(details.details, function (key, item) {
                            if($('#para_birimi').val())
                            {
                                var currencys=$('#para_birimi').val();
                            }
                            else
                            {
                                var currencys='AZN';
                            }

                            var cvalue = key;
                            var invoice_type=$("#invoice_type").val();
                            var nxt=parseInt(cvalue);
                            $('#ganak').val(nxt);
                            var functionNum = "'" + cvalue + "'";

                            let kdv=0;
                            let price =0;
                            let _item_price = parseFloat(item.price)*parseFloat(item.kur);
                            if(item.kdv_dahil_haric==1){
                                kdv =18;
                                price =parseFloat(_item_price / 1.18).toFixed(3);
                            }
                            else {
                                kdv = 18;
                                price = parseFloat(_item_price).toFixed(3);
                            }
                            var data_ = '<tr  class="ek_tr"><td><input type="text" class="form-control text-center" value="'+item.product_name+'" name="product_name[]" ' +
                                'placeholder="Ürün Adını veya Kodunu Giriniz" id="productname-' + cvalue + '"></td><td>' +
                                '<input type="text" class="form-control req amnt" name="product_qty[]" value="'+item.qty+'" ' +
                                'id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog(),paketleme_hesapla(' + functionNum + ')" autocomplete="off"' +
                                ' value="1" ><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" ' +
                                'class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" value="'+price+'" onkeypress="return isNumber(event)" ' +
                                'onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat"' +
                                ' name="product_tax[]" id="vat-' + cvalue + '" value="'+kdv+'" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
                                'autocomplete="off"></td><td><input type="text" class="form-control discount" ' +
                                'name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" ' +
                                'autocomplete="off"></td> <td><strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span><span class="currenty">' + currencys +'</span> ' +
                                '</strong></td> <td><select class="select2 form-control depo_id_item select-box" name="depo_id_item[]"></select></td><td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
                                ' <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0">' +
                                '<input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" ' +
                                'id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="'+item.product_id+'"> ' +
                                '<input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="'+item.unit_id+'">' +
                                ' <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> ' +
                                ' <input type="hidden" name="invoice_item_id[]" value="0"> ' +
                                '</tr>';
                            $('.my_stripe tbody').after(data_);

                            $('.select-box').select2();

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

                        });

                        $('.amnt').each(function (index) {
                            rowTotal(index);
                            billUpyog();
                            SubTotal();
                        });

                        let talep =[] ;
                        for(let k=0; k < details.malzeme_talep.length; k++){

                            talep.push(details.malzeme_talep[k])
                        }


                        $('#proje_id').val(details.proje[0]); // Change the value or make some change to the internal state
                        $('#proje_id').trigger('change.select2'); // Notify only Select2 of changes

                        $('#malzeme_talep_id').val(talep);
                        $('#malzeme_talep_id').trigger('change.select2'); // Notify only Select2 of changes

                    }
                    else {
                        alert(details.messages)
                    }


                }

            });

        }else{
            alert("Cari Seçiniz!");
            for (let i = 0; i <= id.length; i++){
                $('#satinalma_talep_id').select2('val', id[i]);
            }
        }
    })


    $('#invoice_type').on('change',function () {
        //$('#customer-box').prop('disabled',false);
            $('#customer_id').prop('disabled',false);

        if($("#invoice_type").val()==36 || $("#invoice_type").val()==35 )
        {
            $('.sozle_hid').css('display','table-cell');
        }
        else
        {
            $('.sozle_hid').css('display','none');
        }

        forma_2list(customer_id);
        tehvil_list(customer_id);


    });

    $('#iscilik_fiyati_al').click(function () {

        var product_id=$('#pid-0').val();

        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/iscilik_fiyati_al',
            data:
                'product_id='+ product_id+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                var price=$('#price-0').val();
                var urun_adi=$('#productname-0').val();
                var prices=parseFloat(price)+parseFloat(data);
                $('#price-0').val(prices)
                $('#productname-0').val(urun_adi+'-'+' İşçilik Dahil');

            }
        });

    });

    $('#kur_al').click(function () {
        var para_birimi=$('#para_birimi').val();
        var invoice_date=$('#invoice_date').val();
        var loc_id=$('#loc_id').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/kur_al',
            data:
                'para_birimi='+ para_birimi+
                '&invoice_date='+ invoice_date+
                '&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                $('#kur_degeri').val(data);

            }
        });

        $('#hdata').attr('data-curr',para_birimi);

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
        $("#taxr2").val(taxc);

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


<script type="text/javascript">

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

                $("#bolum_id").append('<option  value="0">Seçiniz</option>');
                jQuery.each(data, function (key, item) {

                    $("#bolum_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');
                });
            }
        });

        $.ajax({
            dataType: "json",
            method: 'post',
            url: baseurl + 'search_products/proje_deposu',
            data:'proje_id='+ proje_id,
            success: function (data) {
                $(".depo_id_item").append('<option  selected value="'+ data.id +'">'+ data.name+'</option>');

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

                $("#asama_id").append('<option  value="0">Seçiniz</option>');
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
                $("#alt_asama_id").append('<option  value="0">Seçiniz</option>');
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
                $("#task_id").append('<option  value="0">Seçiniz</option>');
                jQuery.each(data, function (key, item) {

                    $("#task_id").append('<option  value="'+ item.id +'">'+ item.name+'</option>');


                });
            }
        });
    });

    function kusurat_hesapla(obj,str) {
        /*
        if(str=='ara_toplam')
        {
            var ara_top=parseFloat($('#subttlform2').val());

            if($('#ara_top_pre').val()==1)
            {
                //toplama
                var kusurat=$(obj).val();
                var subtotal = parseFloat(ara_top)+parseFloat(kusurat);
                $("#subtotalr").html(subtotal);
                $('#subttlform').val(subtotal)

            }
            else
                {
                    var kusurat=$(obj).val();
                    var subtotal = parseFloat(ara_top)-parseFloat(kusurat);
                    $("#subtotalr").html(subtotal);
                    $('#subttlform').val(subtotal)

                    //çıkarma
                }
        }
        else if(str=='net_toplam')
        {
            var ara_top=parseFloat($('#subttlform2').val());

            if($('#net_total_pre').val()==1)
            {
                var ara_toplam=$('#subttlform').val();
                var indirim=parseFloat($('#discs').html());

                //toplama
                var kusurat=parseFloat($(obj).val());
                var net_total =ara_toplam-indirim;
                var yeni_net=net_total+kusurat;
                $("#nettotal").html(yeni_net);
                $('#nettotalinp').val(yeni_net)

            }
            else
                {
                    var ara_toplam=$('#subttlform').val();
                    var indirim=parseFloat($('#discs').html());

                    //toplama
                    var kusurat=parseFloat($(obj).val());
                    var net_total =ara_toplam-indirim;
                    var yeni_net=net_total-kusurat;
                    $("#nettotal").html(yeni_net);
                    $('#nettotalinp').val(yeni_net)

                    //çıkarma
                }
        }
        else if(str=='tax_hesapla')
        {
            var total_tax=parseFloat($('#taxr2').val());

            var net=parseFloat($('#nettotalinp').val())

            if($('#tax_pre').val()==1)
            {


                //toplama
                var kusurat=parseFloat($(obj).val());
                var yeni_net=total_tax+kusurat;
                $("#taxr").html(yeni_net);
                $("#invoiceyoghtml").val(deciFormat(yeni_net+net));

            }
            else
            {
                var kusurat=parseFloat($(obj).val());
                var yeni_net=total_tax-kusurat;
                $("#taxr").html(yeni_net);
                $("#invoiceyoghtml").val(deciFormat(yeni_net+net));

                //çıkarma
            }
        }

         */

    }


    $(document).on('click', '#new_create', function () {
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Fatura Oluşturma ',
            icon: 'fa fa-question',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: 'Fatura Oluşturulacak Emin Misiniz?',
            buttons: {
                formSubmit: {
                    text: 'Evet',
                    btnClass: 'btn-blue',
                    action: function () {
                        // Zorunlu alan kontrolü
                        let valid = true;
                        let requiredFields = ['customer_id', 'invoice_type', 'invoice_no', 'invoicedate', 'notes']; // Zorunlu alanların "name" değerlerini belirtin
                        requiredFields.forEach((name) => {
                            let field = $(`[name="${name}"]`);
                            if (!field.val().trim()) {
                                valid = false;
                                field.addClass('is-invalid'); // Hata durumunda kırmızı border
                                field.focus();
                            } else {
                                field.removeClass('is-invalid');
                            }
                        });

                        if (!valid) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
                                title: 'Hata!',
                                content: 'Lütfen tüm zorunlu alanları doldurunuz.',
                                buttons: {
                                    ok: {
                                        text: 'Tamam',
                                        btnClass: "btn btn-danger btn-sm",
                                    }
                                }
                            });
                            return false;
                        }

                        // Eğer tüm kontroller geçerliyse devam et
                        $('#loading-box').removeClass('d-none');
                        $.post(baseurl + 'invoices/action', $('#data_form').serialize(), (response) => {
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
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
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function () {
                                                location.href = '/invoices/view?id=' + data.id;
                                            }
                                        }
                                    }
                                });
                            } else if (data.status == 410) {
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
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    });

    $(document).ready(function() {
        // Select2 başlangıç ayarları
        $('#search_input_nakliye').select2({
            placeholder: "Nakliye aramak için yazın...",
            allowClear: true,
            language: {
                inputTooShort: function () {
                    return "3 karakter daha yazın...";
                },
                noResults: function () {
                    return "Sonuç bulunamadı veya cari seçilmedi";
                },
                searching: function () {
                    return "Arama yapılıyor...";
                }
            },
            ajax: {
                url: "<?php echo base_url('invoices/search_cari_to_nakliye'); ?>", // AJAX isteğinin gönderileceği URL
                dataType: 'json',
                delay: 250, // Gecikme süresi
                data: function (params) {
                    return {
                        search: params.term, // Kullanıcının yazdığı değer
                        cari_id: $('#customer_id').val() // CSD ID
                    };
                },
                processResults: function (data) {
                    if (data.status === 200) {
                        return {
                            results: $.map(data.data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.code
                                };
                            })
                        };
                    } else {
                        return {
                            results: [{ id: '', text: data.message }]
                        };
                    }
                },
                cache: true
            },
            minimumInputLength: 3 // En az 3 karakter yazıldığında AJAX isteği gönderilir
        });
    });


</script>
