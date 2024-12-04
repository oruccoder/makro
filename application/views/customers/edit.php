<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"> <?php echo $this->lang->line('Customer Details') ?> </span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
            <div class="content">
                <div class="card">
                    <div class="card-body">
                <form method="post" id="data_form" class="form-horizontal">

                        <input type="hidden" name="id" value="<?php echo $customer['id'] ?>">

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

                        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab"
                                 aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="country"><?php echo $this->lang->line('Folder_path') ?></label>
                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Folder_path'); ?>"
                                                       class="form-control margin-bottom"
                                                       value="<?php echo $customer['folder_path'] ?>" name="folder_path"
                                                       id="folder_path">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('cari_tipi') ?></label>

                                            <div class="col-sm-8">
                                                <select id="cari_tipi" class="form-control" name="cari_tipi">
                                                    <option value="0">Seçiniz</option>
                                                    <?php if ($customer['cari_tipi'] == 1) {
                                                        echo "<option value='1' selected>Özel</option>";
                                                        echo "<option value='2'>Devlet</option>";
                                                    } else if ($customer['cari_tipi'] == 2) {
                                                        echo "<option value='1' >Özel</option>";
                                                        echo "<option value='2' selected>Devlet</option>";
                                                    } else {
                                                        echo "<option value='1' >Özel</option>";
                                                        echo "<option value='2'>Devlet</option>";
                                                    }


                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Company') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Company') ?>"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['company'] ?>" name="company">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Ülke"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['country'] ?>" name="country"
                                                       id="mcustomer_country">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="region"><?php echo $this->lang->line('Region') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Region') ?>"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['region'] ?>" name="region"
                                                       id="region">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="city"><?php echo $this->lang->line('City') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $this->lang->line('City') ?>"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['city'] ?>" name="city"
                                                       id="mcustomer_city">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Posta Kodu"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['postbox'] ?>" name="postbox"
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
                                                       value="<?php echo $customer['address'] ?>"
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
                                                       value="<?php echo $customer['phone'] ?>" id="mcustomer_phone">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="email"><?php echo $this->lang->line('FirmaEmail') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('FirmaEmail') ?>"
                                                       class="form-control margin-bottom required b_input" name="email"
                                                       value="<?php echo $customer['email'] ?>" id="mcustomer_email">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Authorized person') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Authorized person') ?>"
                                                       class="form-control margin-bottom b_input required" name="name"
                                                       value="<?php echo $customer['name'] ?>" id="mcustomer_name">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('yetkili_tel') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('yetkili_tel') ?>"
                                                       class="form-control margin-bottom b_input required"
                                                       name="yetkili_tel" value="<?php echo $customer['yetkili_tel'] ?>"
                                                       id="yetkili_tel">
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
                                                       name="yetkili_mail"
                                                       value="<?php echo $customer['yetkili_mail'] ?>"
                                                       id="yetkili_mail">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('yetkili_gorev') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('yetkili_gorev') ?>"
                                                       class="form-control margin-bottom b_input required"
                                                       name="yetkili_gorev"
                                                       value="<?php echo $customer['yetkili_gorev'] ?>"
                                                       id="yetkili_gorev">
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
                                                        if ($customer['sorumlu_personel'] == $id) {
                                                            echo "<option selected value='$id'>$name</option>";
                                                        } else {
                                                            echo "<option value='$id'>$name</option>";
                                                        }

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

                                                        if ($customer['sorumlu_muhasebe_personeli'] == $id) {
                                                            echo "<option selected value='$id'>$name</option>";
                                                        } else {
                                                            echo "<option  value='$id'>$name</option>";
                                                        }

                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Sektor') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Firma Sektörü"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['sektor'] ?>" name="sektor">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Company About') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Company About') ?>"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['company_about'] ?>"
                                                       name="company_about">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="taxid"><?php echo $this->lang->line('voyn') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $this->lang->line('voyn') ?>"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['taxid'] ?>" name="taxid">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="taxid"><?php echo $this->lang->line('edv') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $this->lang->line('edv') ?>"
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo round($customer['kdv_orani']) ?>"
                                                       name="kdv_orani">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="musteri_tipi"><?php echo $this->lang->line('sirket_tipi') ?></label>

                                            <div class="col-sm-8">
                                                <select name="sirket_tipi" class="form-control required b_input">

                                                    <?php if ($customer['sirket_tipi'] == 1) {
                                                        echo "<option value='1' selected>Tekil Firması</option>";
                                                        echo "<option value='2'>Grup Firması</option>";
                                                    } else if ($customer['sirket_tipi'] == 2) {
                                                        echo "<option value='1' >Tekil Firması</option>";
                                                        echo "<option value='2' selected>Grup Firması</option>";
                                                    } else {
                                                        echo "<option value='1' >Tekil Firması</option>";
                                                        echo "<option value='2'>Grup Firması</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="product_name">Alt
                                                Firmalar</label>
                                            <div class="col-sm-8">
                                                <select class="select-box form-control" name="parent_id[]" multiple>
                                                    <option value="0">Seçiniz</option>
                                                    <?php foreach (all_customer() as $customers) {
                                                        if (in_array($customers->id, customer_parent($customer['id']))) {

                                                            echo "<option selected value='$customers->id'>$customers->company</option>";
                                                        } else {
                                                            echo "<option value='$customers->id'>$customers->company</option>";
                                                        }

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
                                                        if ($customer['musteri_tipi'] == $cus->id) {
                                                            echo "<option selected value='$cus->id'>$cus->name</option>";
                                                        } else {
                                                            echo "<option value='$cus->id'>$cus->name</option>";
                                                        }

                                                    } ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="ekstre_tipi">Ekstre Tipi</label>
                                            <div class="col-sm-8">
                                                <select class="select-box form-control" name="ekstre_tipi">
                                                    <?php foreach (all_ekstre_tipi() as $customers) {
                                                        if ($customers->id == $customer['ekstre_tipi']) {

                                                            echo "<option selected value='$customers->id'>$customers->name</option>";
                                                        } else {
                                                            echo "<option value='$customers->id'>$customers->name</option>";
                                                        }

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
                                    <table class="table table-striped" id="bank_bilgileri_table">
                                        <thead>
                                        <tr>
                                            <th>Banka Adı</th>
                                            <th>Eylem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($customer_b)) {
                                            $no = 0;
                                            foreach ($customer_b as $customers) {
                                                $no = $no + 1;
                                                ?>

                                                <tr>

                                                    <td><a href="#banka_details" data-toggle="modal" data-remote="false"
                                                           tip="1" id="<?php echo $customers->id ?>"
                                                           class="banka_details btn btn-info btn-sm"><?php echo $customers->banka ?></a>
                                                    </td>
                                                    <td><a href="#" class="btn btn-danger edit_remove" tip="1"
                                                           id="<?php echo $customers->id ?>">Sil</a></td>
                                                </tr>

                                                <?php
                                            }
                                        } ?>

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
                                    <table class="table table-striped" id="invoice_bilgileri_table">
                                        <thead>
                                        <tr>

                                            <th>Ünvan Adı</th>
                                            <th>Eylem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($customer_inv)) {
                                            $no = 0;
                                            foreach ($customer_inv as $customers) {
                                                $no = $no + 1;
                                                ?>

                                                <tr>

                                                    <td><a href="#invoice_details" data-toggle="modal"
                                                           data-remote="false" tip="2" id="<?php echo $customers->id ?>"
                                                           class="btn btn-info btn-sm invoice_details"><?php echo $customers->unvan_invoice ?></a>
                                                    </td>
                                                    <td><a href="#" class="btn btn-danger edit_remove" tip="2"
                                                           id="<?php echo $customers->id ?>">Sil</a></td>
                                                </tr>

                                                <?php
                                            }
                                        } ?>
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
                                    <table class="table table-striped" id="teslimat_bilgileri_table">
                                        <thead>
                                        <tr>
                                            <th>Ünvan Adı</th>
                                            <th>Eylem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (isset($customer_tes)) {
                                            $no = 0;
                                            foreach ($customer_tes as $customers) {
                                                $no = $no + 1;
                                                ?>

                                                <tr>

                                                    <td><a href="#teslimat_details" data-toggle="modal"
                                                           data-remote="false" tip="3" id="<?php echo $customers->id ?>"
                                                           class="teslimat_details btn btn-info btn-sm"><?php echo $customers->unvan_teslimat ?></a>
                                                    </td>
                                                    <td><a href="#" class="btn btn-danger edit_remove" tip="3"
                                                           id="<?php echo $customers->id ?>">Sil</a></td>
                                                </tr>

                                                <?php
                                            }
                                        } ?>
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
                                                       class="form-control margin-bottom b_input"
                                                       value="<?php echo $customer['discount_c']; ?>" name="discount">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="customer_teminat"><?php echo $this->lang->line('Customer Teminat') ?></label>

                                            <div class="col-sm-10">
                                                <select name="teminat_type" class="form-control b_input">

                                                    <?php
                                                    foreach (teminat_type() as $teminat) {
                                                        $id = $teminat->id;
                                                        $name = $teminat->name;
                                                        if ($id == $customer['teminat_type']) {
                                                            echo "<option selected value='$id'>$name</option>";
                                                        } else {
                                                            echo "<option value='$id'>$name</option>";
                                                        }
                                                    }
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
                                                       value="<?php echo $customer['customer_teminat_desc']; ?>"
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
                                                       value="<?php echo $customer['credit']; ?>"
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
                                                       value="<?php echo $customer['customer_credit_you']; ?>"
                                                       name="customer_credit_you">
                                            </div>
                                        </div>
                                        <!-- Kredi Bilgileri -->
                                        <!--div class="form-group row">

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
                                                <input type="text" placeholder="Boş Bırakıldığında Otomatik Şifre Oluşur"
                                                       class="form-control margin-bottom b_input" name="password_c" id="password_c">
                                            </div>
                                        </div-->
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="currency">Dil</label>

                                            <div class="col-sm-10">
                                                <select name="language" class="form-control b_input">
                                                    <?php
                                                    echo '<option value="' . $customer['lang'] . '">-' . ucfirst($customer['lang']) . '-</option>';
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
                                                    <thead>
                                                    <tr>
                                                        <th>Tip</th>
                                                        <th>İsim - Soyisim</th>
                                                        <th>Tel</th>
                                                        <th>Mail</th>
                                                        <th>Eylem</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php if (isset($customer_pers)) {
                                                        foreach ($customer_pers as $pers) {
                                                            ?>

                                                            <tr>
                                                                <td>
                                                                    <select class="form-control"
                                                                            name="ekstra_pers_tipi[]">
                                                                        <option value="0">Seçiniz</option>
                                                                        <?php foreach (role_name() as $role) {
                                                                            $id = $role['id'];
                                                                            $name = $role['name'];
                                                                            if ($pers->tip == $id) {
                                                                                echo "<option selected value='$id'>$name</option>";
                                                                            } else {
                                                                                echo "<option value='$id'>$name</option>";
                                                                            }

                                                                        } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" name="ekstra_fullname[]"
                                                                           value="<?php echo $pers->fullname ?>">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" name="ekstra_tel[]"
                                                                           value="<?php echo $pers->tel ?>">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" name="ekstra_mail[]"
                                                                           value="<?php echo $pers->mail ?>">
                                                                </td>
                                                                <td>
                                                                    <a href="#" class="btn btn-danger edit_remove"
                                                                       tip="4" id="<?php echo $pers->id ?>">Sil</a>
                                                                </td>
                                                            </tr>

                                                        <?php }
                                                    } else { ?>
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

                                                    <?php } ?>

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
                        <div class="form-group row">
                            <input type="hidden" value="customers/editcustomer" id="action-url">
                        </div>
                        <div id="mybutton">
                            <input type="submit" id="submit-data"
                                   class="btn btn-lg btn btn-primary margin-bottom round float-xs-right mr-2"
                                   value="Güncelle" data-loading-text="Adding...">
                        </div>
                    </div>
                </form>
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

<div id="banka_details" class="modal  fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                <h4 class="modal-title">Banka Detayları</h4>
            </div>
            <div class="modal-body" id="banka_view_object">
                <p></p>
            </div>
        </div>
    </div>
</div>
<div id="invoice_details" class="modal  fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                <h4 class="modal-title">Fatura Adresi Detayları</h4>
            </div>
            <div class="modal-body" id="invoice_view_object">
                <p></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="view-object-id" value="">

            </div>
        </div>
    </div>
</div>
<div id="teslimat_details" class="modal  fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                <h4 class="modal-title">Teslimat Adresi Detayları</h4>
            </div>
            <div class="modal-body" id="teslimat_view_object">
                <p></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="view-object-id" value="">

                <button type="button" data-dismiss="modal" id="guncelle_teslimat"
                        class="btn"><?php echo $this->lang->line('Close') ?></button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).on('click', '#customer_bank_edit', function () {

        var actionurl = $('#action-url-bank').val();
        $.ajax({
            url: baseurl + actionurl,
            data: $('#form_model_banka_edit').serialize(),
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                alert("Başarıyla Güncellendi");
                $("#banka_details").modal('hide');

            }

        });
    })

    $(document).on('click', '#customer_invoice_edit', function () {

        var actionurl = $('#action-url-invoice').val();
        $.ajax({
            url: baseurl + actionurl,
            data: $('#form_invoice_details').serialize(),
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                alert("Başarıyla Güncellendi");
                $("#invoice_details").modal('hide');
            }

        });
    })

    $(document).on('click', '#customer_teslimat_edit', function () {

        var actionurl = $('#action-url-teslimat').val();
        $.ajax({
            url: baseurl + actionurl,
            data: $('#form_teslimat_details').serialize(),
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                alert("Başarıyla Güncellendi");
                $("#teslimat_details").modal('hide');
            }

        });
    })

    $(document).on('click', ".banka_details, .invoice_details, .teslimat_details", function (e) {
        e.preventDefault();
        var tip = $(this).attr('tip');
        var id = $(this).attr('id');

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'customers/customer_details_';
        $.ajax({
            url: baseurl + actionurl,
            data: 'id=' + id + '&tip=' + tip,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                if (tip == 1) {
                    $('#banka_view_object').html(data);
                } else if (tip == 2) {
                    $('#invoice_view_object').html(data);
                } else if (tip == 3) {
                    $('#teslimat_view_object').html(data);
                }


            }

        });

    });


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


    $('.saman-row').on('click', '.edit_remove', function () {

        var confirmation = confirm("Bu İşlemi Yapmak İstediğinizden Emin Misiniz? Geri Alamazsınız!");

        if (confirmation) {
            $(this).closest('tr').remove();
            var id = $(this).attr('id');
            var tip = $(this).attr('tip');
            var action_url = 'customers/remove_data_cust'
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
        }

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

