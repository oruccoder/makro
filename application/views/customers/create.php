<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> <?php echo $this->lang->line('Add New Customer') ?> </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>


<div class="content">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="card-body">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="base-tab4" data-toggle="tab"
                           aria-controls="tab1" href="#tab1" role="tab"
                           aria-selected="true"><?php echo $this->lang->line('cari_kart_bilgileri') ?></a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="base-tab5" data-toggle="tab" aria-controls="tab2"
                           href="#tab2" role="tab"
                           aria-selected="false"><?php echo $this->lang->line('bank_bilgileri') ?></a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab3"
                           href="#tab3" role="tab"
                           aria-selected="false"><?php echo $this->lang->line('Billing Address') ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                           href="#tab4" role="tab"
                           aria-selected="false"><?php echo $this->lang->line('Shipping Address') ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab5"
                           href="#tab5" role="tab"
                           aria-selected="false"><?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Settings') ?></a>
                    </li>

                </ul>

                <form method="post" id="data_form" class="form-horizontal">
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab"
                             aria-expanded="true">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('cari_tipi') ?></label>

                                        <div class="col-sm-8">
                                            <select id="cari_tipi" class="form-control" name="cari_tipi">
                                                <option value="0">Seçiniz</option>
                                                <option value="1">Özel</option>
                                                <option value="2">Devlet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Company') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Company') ?>"
                                                   class="form-control margin-bottom b_input" name="company">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="country"><?php echo $this->lang->line('Country') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Ülke"
                                                   class="form-control margin-bottom b_input" name="country"
                                                   id="mcustomer_country">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="region"><?php echo $this->lang->line('Region') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Region') ?>"
                                                   class="form-control margin-bottom b_input" name="region"
                                                   id="region">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="city"><?php echo $this->lang->line('City') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('City') ?>"
                                                   class="form-control margin-bottom b_input" name="city"
                                                   id="mcustomer_city">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Posta Kodu"
                                                   class="form-control margin-bottom b_input" name="postbox"
                                                   id="postbox">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="address"><?php echo $this->lang->line('Address') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Address') ?>"
                                                   class="form-control margin-bottom b_input" name="address"
                                                   id="mcustomer_address1">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="phone"><?php echo $this->lang->line('FirmaPhone') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('FirmaPhone') ?>"
                                                   class="form-control margin-bottom required b_input" name="phone"
                                                   id="mcustomer_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="email"><?php echo $this->lang->line('FirmaEmail') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('FirmaEmail') ?>"
                                                   class="form-control margin-bottom required b_input" name="email"
                                                   id="mcustomer_email">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Authorized person') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Authorized person') ?>"
                                                   class="form-control margin-bottom b_input required" name="name"
                                                   id="mcustomer_name">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('yetkili_tel') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('yetkili_tel') ?>"
                                                   class="form-control margin-bottom b_input required"
                                                   name="yetkili_tel" id="yetkili_tel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('yetkili_mail') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('yetkili_mail') ?>"
                                                   class="form-control margin-bottom b_input required"
                                                   name="yetkili_mail" id="yetkili_mail">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('yetkili_gorev') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('yetkili_gorev') ?>"
                                                   class="form-control margin-bottom b_input required"
                                                   name="yetkili_gorev" id="yetkili_gorev">
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('sorumlu_personel') ?></label>

                                        <div class="col-sm-8">
                                            <select class="select-box form-control" name="sorumlu_personel">
                                                <option value="0">Seçiniz</option>
                                                <?php foreach (personel_list() as $customers) {
                                                    $id = $customers['id'];
                                                    $name = $customers['name'];
                                                    echo "<option value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-1">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('sorumlu_muhasebe_personeli') ?></label>

                                        <div class="col-sm-8">
                                            <select class="select-box form-control"
                                                    name="sorumlu_muhasebe_personeli">
                                                <option value="0">Seçiniz</option>
                                                <?php foreach (personel_list() as $customers) {
                                                    $id = $customers['id'];
                                                    $name = $customers['name'];
                                                    echo "<option value='$id'>$name</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Sektor') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Firma Sektörü"
                                                   class="form-control margin-bottom b_input" name="sektor">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="name"><?php echo $this->lang->line('Company About') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Company About') ?>"
                                                   class="form-control margin-bottom b_input" name="company_about">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="taxid"><?php echo $this->lang->line('voyn') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('voyn') ?>"
                                                   class="form-control margin-bottom b_input" name="taxid">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="taxid"><?php echo $this->lang->line('edv') ?></label>

                                        <div class="col-sm-8">
                                            <input type="text" placeholder="<?php echo $this->lang->line('edv') ?>"
                                                   class="form-control margin-bottom b_input" name="kdv_orani">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="musteri_tipi"><?php echo $this->lang->line('sirket_tipi') ?></label>

                                        <div class="col-sm-8">
                                            <select name="sirket_tipi" class="form-control required b_input">
                                                <option value="1">Tekil Firması</option>
                                                <option value="2">Grup Firması</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="product_name"><?php echo $this->lang->line('parent_grup_firma') ?></label>
                                        <div class="col-sm-8">
                                            <select class="select-box form-control" name="parent_id">
                                                <option value="0">Seçiniz</option>
                                                <?php foreach (all_customer() as $customers) {
                                                    echo "<option value='$customers->id'>$customers->company</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="musteri_tipi"><?php echo $this->lang->line('Customer group') ?></label>

                                        <div class="col-sm-8">
                                            <select name="musteri_tipi" class="form-control required b_input">
                                                <?php foreach (geopos_customer_type() as $cus) {
                                                    echo "<option value='$cus->id'>$cus->name</option>";
                                                } ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="link-tab2"
                             aria-expanded="true">
                            <a href="#bank_popup" data-toggle="modal" data-remote="false" class="btn btn-info">Yeni
                                Banka Bilgileri</a>

                            </br>
                            </br>
                            <div class="saman-row">
                                <table class="table" id="bank_bilgileri_table">
                                    <tr>

                                        <th>Banka Adı</th>
                                        <th>Eylem</th>
                                    </tr>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>


                        </div>
                        <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="link-tab3"
                             aria-expanded="true">
                            <a href="#invoice_popup" data-toggle="modal" data-remote="false" class="btn btn-info">Yeni
                                Fatura Adresi</a>

                            </br>
                            </br>

                            <div class="saman-row">
                                <table class="table" id="invoice_bilgileri_table">
                                    <tr>

                                        <th>Ünvan Adı</th>
                                        <th>Eylem</th>
                                    </tr>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="link-tab4"
                             aria-expanded="false">
                            <a href="#teslimat_popup" data-toggle="modal" data-remote="false" class="btn btn-info">Yeni
                                Teslimat Adresi</a>

                            </br>
                            </br>
                            <div class="saman-row">
                                <table class="table" id="teslimat_bilgileri_table">
                                    <tr>

                                        <th>Ünvan Adı</th>
                                        <th>Eylem</th>
                                    </tr>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="link-tab5"
                             aria-expanded="false">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="İskonto Oranı"
                                                   class="form-control margin-bottom b_input" name="discount">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customer_teminat"><?php echo $this->lang->line('Customer Teminat') ?></label>

                                        <div class="col-sm-10">
                                            <select name="teminat_type" class="form-control b_input">

                                                <?php

                                                echo $teminat;
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customer_teminat_desc"><?php echo $this->lang->line('Customer Teminat Description') ?></label>

                                        <div class="col-sm-10">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Customer Teminat Description') ?>"
                                                   class="form-control margin-bottom b_input"
                                                   name="customer_teminat_desc">
                                        </div>
                                    </div>
                                    <!-- Kredi Bilgileri -->
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customer_credit"><?php echo $this->lang->line('Customer Credit Amounth') ?></label>

                                        <div class="col-sm-10">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Customer Credit Amounth') ?>"
                                                   class="form-control margin-bottom b_input"
                                                   name="customer_credit">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="customer_credit"><?php echo $this->lang->line('Customer Credit Amounth You') ?></label>

                                        <div class="col-sm-10">
                                            <input type="text"
                                                   placeholder="<?php echo $this->lang->line('Customer Credit Amounth You') ?>"
                                                   class="form-control margin-bottom b_input"
                                                   name="customer_credit_you">
                                        </div>
                                    </div>
                                    <!-- Kredi Bilgileri -->
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency"><?php echo $this->lang->line('customer_login') ?></label>

                                        <div class="col-sm-10">
                                            <select name="c_login" class="form-control b_input">

                                                <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                                                <option value="0"><?php echo $this->lang->line('No') ?></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label"
                                               for="password_c"><?php echo $this->lang->line('New Password') ?></label>

                                        <div class="col-sm-10">
                                            <input type="text"
                                                   placeholder="Boş Bırakıldığında Otomatik Şifre Oluşur"
                                                   class="form-control margin-bottom b_input" name="password_c"
                                                   id="password_c">
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <label class="col-sm-2 col-form-label"
                                               for="currency">Dil</label>

                                        <div class="col-sm-10">
                                            <select name="language" class="form-control b_input">

                                                <?php

                                                echo $langs;
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-sm-12 saman-row">
                                            <table class="table">
                                                <tr>
                                                    <th>Tip</th>
                                                    <th>İsim - Soyisim</th>
                                                    <th>Tel</th>
                                                    <th>Mail</th>
                                                    <th>Eylem</th>
                                                </tr>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <select class="form-control" name="ekstra_pers_tipi[]">
                                                            <option value="0">Seçiniz</option>
                                                            <?php foreach (role_name() as $role) {
                                                                $id = $role['id'];
                                                                $name = $role['name'];
                                                                echo "<option value='$id'>$name</option>";
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="ekstra_fullname[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="ekstra_tel[]">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="ekstra_mail[]">
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>

                                                <tr class="last-item-row sub_c">
                                                    <td class="add-row">
                                                        <button type="button" class="btn btn-success btn-sm"
                                                                aria-label="Left Align" id="addproduct_pers">
                                                            <i class="fa fa-plus-square"></i> <?php echo $this->lang->line('Add Row') ?>
                                                        </button>
                                                    </td>
                                                    <td colspan="7"></td>
                                                </tr>

                                                </tbody>

                                            </table>

                                            <input type="hidden" value="0" name="counter" id="ganak">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="form-group row">
                    <input type="hidden" value="customers/addcustomer" id="action-url">
                </div>
                <div id="mybutton">
                    <input type="submit" id="submit-data"
                           class="btn btn-lg btn btn-primary margin-bottom round float-xs-right mr-2"
                           value="<?php echo $this->lang->line('Add customer') ?>"
                           data-loading-text="Adding...">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="bank_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Banka Bilgileri</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_model_urun_gunc">

                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('hesap_numarasi') ?></label>
                            <input class="form-control" name="hesap_numarasi">

                        </div>
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('iden_numarasi') ?></label>
                            <input class="form-control" name="iden_numarasi">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka') ?></label>
                            <input class="form-control" name="banka">

                        </div>
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('banka_unvan') ?></label>
                            <input class="form-control" name="banka_unvan">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_tel') ?></label>
                            <input class="form-control" name="banka_tel">

                        </div>
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_fax') ?></label>
                            <input class="form-control" name="banka_fax">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('kod') ?></label>
                            <input class="form-control" name="kod">

                        </div>
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('swift') ?></label>
                            <input class="form-control" name="swift">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('banka_voen') ?></label>
                            <input class="form-control" name="banka_voen">

                        </div>
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('muh_hesab') ?></label>
                            <input class="form-control" name="muh_hesab">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('invoice_para_birimi') ?></label>
                            <select name="para_birimi" id="para_birimi" class="form-control">
                                <?php
                                foreach (para_birimi() as $row) {
                                    $cid = $row['id'];
                                    $title = $row['code'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="customers/session_bank">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_session"><?php echo $this->lang->line('ekle'); ?></button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<div id="invoice_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Fatura Bilgileri</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_invoice">

                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('unvan') ?></label>
                            <input class="form-control" name="unvan_invoice" placeholder="Ev,İş vs.">

                        </div>
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Country') ?></label>
                            <input class="form-control" name="country_invoice"
                                   placeholder="<?php echo $this->lang->line('Country') ?>">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Region') ?></label>
                            <input class="form-control" name="sehir_invoice"
                                   placeholder="<?php echo $this->lang->line('Region') ?>">

                        </div>

                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('City') ?></label>
                            <input class="form-control" name="city_invoice"
                                   placeholder="<?php echo $this->lang->line('City') ?>">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('PostBox') ?></label>
                            <input class="form-control" name="post_invoice"
                                   placeholder="<?php echo $this->lang->line('PostBox') ?>">

                        </div>

                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Address') ?></label>
                            <input class="form-control" name="adres_invoice"
                                   placeholder="<?php echo $this->lang->line('Address') ?>">

                        </div>

                    </div>

                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Phone') ?></label>
                            <input class="form-control" name="phone_invoice"
                                   placeholder="<?php echo $this->lang->line('Phone') ?>">

                        </div>

                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('email_') ?></label>
                            <input class="form-control" name="email_invoice"
                                   placeholder="<?php echo $this->lang->line('email_') ?>">

                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="customers/session_invoice">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_session_invoice"><?php echo $this->lang->line('ekle'); ?></button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<div id="teslimat_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Teslimat Bilgileri</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_teslimat">

                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('unvan') ?></label>
                            <input class="form-control" name="unvan_teslimat" placeholder="Ev,İş vs.">

                        </div>
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Country') ?></label>
                            <input class="form-control" name="country_teslimat"
                                   placeholder="<?php echo $this->lang->line('Country') ?>">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Region') ?></label>
                            <input class="form-control" name="sehir_teslimat"
                                   placeholder="<?php echo $this->lang->line('Region') ?>">

                        </div>

                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('City') ?></label>
                            <input class="form-control" name="city_teslimat"
                                   placeholder="<?php echo $this->lang->line('City') ?>">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('PostBox') ?></label>
                            <input class="form-control" name="post_teslimat"
                                   placeholder="<?php echo $this->lang->line('PostBox') ?>">

                        </div>

                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Address') ?></label>
                            <input class="form-control" name="adres_teslimat"
                                   placeholder="<?php echo $this->lang->line('Address') ?>">

                        </div>

                    </div>

                    <div class="row">
                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Phone') ?></label>
                            <input class="form-control" name="phone_teslimat"
                                   placeholder="<?php echo $this->lang->line('Phone') ?>">

                        </div>

                        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('email_') ?></label>
                            <input class="form-control" name="email_teslimat"
                                   placeholder="<?php echo $this->lang->line('email_') ?>">

                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url" value="customers/session_teslimat">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_session_teslimat"><?php echo $this->lang->line('ekle'); ?></button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<script>


    $('#addproduct_pers').on('click', function () {
        var cvalue = parseInt($('#ganak').val()) + 1;

        var option = ` <?php foreach (role_name() as $role) {
            $id = $role['id'];
            $name = $role['name'];
            echo "<option value='$id'>$name</option>";
        } ?>`;

        var data = '' +
            '<tr>' +
            '<td>' + '<select class="form-control" name="ekstra_pers_tipi[]"> ' + '<option value="0">Seçiniz</option> ' + option +
            '</select>' +
            '</td>' +
            '<td><input class="form-control" name="ekstra_fullname[]"> ' + '</td> <td> <input class="form-control" name="ekstra_tel[]"> </td> <td> ' +
            '<input class="form-control" name="ekstra_mail[]"></td> ' +
            '<td><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" >' +
            ' <i class="fa fa-minus-square"></i> </button></td> ' +
            '</tr>';

        $('tr.last-item-row').before(data);

    });

    $('.saman-row').on('click', '.removeProd', function () {
        $(this).closest('tr').remove();
    });

    $('.saman-row').on('click', '.delete_bank, .delete_invoice, .delete_teslimat', function () {

        $(this).closest('tr').remove();
        var id = $(this).attr('id');
        var tip = $(this).attr('tip');
        var action_url = 'customers/remove_sessioan'
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: {
                'tip': tip,
                'id': id
            },
            dataType: 'json',
            success: function (data) {

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });

    });

    $(document).on('click', "#submit_model_session_teslimat", function (e) {
        e.preventDefault();
        var o_data = $("#form_teslimat ").serialize();
        var action_url = $('#teslimat_popup #action-url').val();
        $("#teslimat_popup").modal('hide');
        saveMDataa(o_data, action_url, 'teslimat_bilgileri_table', 3);

    });
    $(document).on('click', "#submit_model_session_invoice", function (e) {
        e.preventDefault();
        var o_data = $("#form_invoice ").serialize();
        var action_url = $('#invoice_popup #action-url').val();
        $("#invoice_popup").modal('hide');
        saveMDataa(o_data, action_url, 'invoice_bilgileri_table', 2);

    });

    $(document).on('click', "#submit_model_session", function (e) {
        e.preventDefault();
        var o_data = $("#form_model_urun_gunc ").serialize();
        var action_url = $('#bank_popup #action-url').val();
        $("#bank_popup").modal('hide');
        saveMDataa(o_data, action_url, 'bank_bilgileri_table', 1);

    });

    function saveMDataa(o_data, action_url, table, tip) {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    if (tip == 1) //banka
                    {
                        $('#' + table + ' tbody:last-child').before('<tr><td>' + data.bank_adi + '</td><td>' + data.eylem + '</td></tr>');


                    } else if (tip == 2) // invoice
                    {
                        $('#' + table + ' tbody:last-child').before('<tr><td>' + data.unvan + '</td><td>' + data.eylem + '</td></tr>');
                    } else if (tip == 3) // teslimat
                    {
                        $('#' + table + ' tbody:last-child').before('<tr><td>' + data.unvan + '</td><td>' + data.eylem + '</td></tr>');
                    }


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
</script>

