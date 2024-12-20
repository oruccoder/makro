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
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-2 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" style="width: 100%" id="dpic" class="rounded-circle img-border"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>
                        <!-- Menü Ekle -->
                        <?php $this->load->view('customers/customer_menu'); ?>
                    </div>

                    <div class="col-md-10">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                   aria-controls="tab1" href="#tab1" role="tab"
                                   aria-selected="true">Hesap Özeti</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-13" data-toggle="tab"
                                   aria-controls="tab13" href="#tab13" role="tab"
                                   aria-selected="true">Onaylanmış Bekleyen Ödemeler</a>
                            </li>

                            <!--                            <li class="nav-item">-->
                            <!--                                <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"-->
                            <!--                                   href="#tab2" role="tab"-->
                            <!--                                   aria-selected="false">Sözleşme Hesap Özeti</a>-->
                            <!--                            </li>-->
                            <!--                            <li class="nav-item">-->
                            <!--                                <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"-->
                            <!--                                   href="#tab3" role="tab"-->
                            <!--                                   aria-selected="false">Forma2 Hesap Özeti</a>-->
                            <!--                            </li>-->
                            <!--                            <li class="nav-item">-->
                            <!--                                <a class="nav-link" id="base-tab-12" data-toggle="tab" aria-controls="tab12"-->
                            <!--                                   href="#tab12" role="tab"-->
                            <!--                                   aria-selected="false">Avans Hesap Özeti</a>-->
                            <!--                            </li>-->

                            <li class="nav-item">
                                <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                   href="#tab4" role="tab"
                                   aria-selected="false">KDV Bilgileri</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-5" data-toggle="tab" aria-controls="tab5"
                                   href="#tab5" role="tab"
                                   aria-selected="false">Cari Kart Bilgileri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-6" data-toggle="tab" aria-controls="tab6"
                                   href="#tab6" role="tab"
                                   aria-selected="false">Banka Bilgileri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-7" data-toggle="tab" aria-controls="tab7"
                                   href="#tab7" role="tab"
                                   aria-selected="false">Fatura Bilgileri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-8" data-toggle="tab" aria-controls="tab8"
                                   href="#tab8" role="tab"
                                   aria-selected="false">Teslimat Bilgileri</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-9" data-toggle="tab" aria-controls="tab9"
                                   href="#tab9" role="tab"
                                   aria-selected="false">Diğer Bilgiler</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-10" data-toggle="tab" aria-controls="tab10"
                                   href="#tab10" role="tab"
                                   aria-selected="false">Durum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="base-tab-11" data-toggle="tab" aria-controls="tab11"
                                   href="#tab11" role="tab"
                                   aria-selected="false">Belgeler</a>
                            </li>


                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab"
                                 aria-expanded="true">


                                <form action="<?php echo base_url() ?>customers/statement" method="post" role="form">

                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                           value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <input type="hidden" id="para_birimi" name="para_birimi"
                                           value="<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi); ?>">

                                    <input type="hidden" name="customer" value="<?php echo $customer_id ?>">


                                    <div class="form-group row" style="display: none">
                                        <label class="col-sm-3 col-form-label"
                                               for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                                        <div class="col-sm-9">
                                            <select name="trans_type" class="form-control">
                                                <option value='All'><?php echo $this->lang->line('All Transactions') ?></option>
                                                <option value='Expense'><?php echo $this->lang->line('Debit') ?></option>
                                                <option value='Income'><?php echo $this->lang->line('Credit') ?></option>
                                            </select>


                                        </div>
                                    </div>

                                </form>
                                <div class="extres_cust" id="div_print_ex">
                                    <div class="row" style="padding-bottom: 10px;">

                                        <div class="col-md-2">
                                            <input type="text" name="start_date_hesap_ozeti" id="start_date_hesap_ozeti"
                                                   class="date30 form-control form-control-sm" autocomplete="off"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="end_date_hesap_ozeti" id="end_date_hesap_ozeti"
                                                   class="form-control form-control-sm"
                                                   data-toggle="datepicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-1">
                                            <input type="button" name="search_hesap_ozeti" id="search_hesap_ozeti"
                                                   value="Filtrele" class="btn btn-info btn-sm"/>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" type="button" value="Temizle"
                                               class="btn btn-info btn-sm">Temizle</a>
                                        </div>

                                    </div>
                                    <div style="padding-bottom: 10px;">

                                        <a href="/customers/view?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>&forma2_durum=1"
                                           class="btn btn-info btn-sm">Forma2'li Hesapla</a>

                                        <a href="/customers/view?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>&forma2_durum=2"
                                           class="btn btn-success btn-sm">Qaimeli Hesapla</a>

                                        <a href="/customers/view?id=<?php echo $details['id'] ?>"
                                           class="btn btn-warning btn-sm">Tümü</a>

                                        <?php if (@$_GET['kdv_durum'] == 0) { ?>
                                            <a href="/customers/view?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>&kdv_durum=1"
                                               class="btn btn-primary btn-sm">KDV'siz Hesapla</a>
                                        <?php } else { ?>
                                            <a href="/customers/view?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>&kdv_durum=0"
                                               class="btn btn-primary btn-sm">KDV'li Hesapla</a>

                                        <?php } ?>

                                        <?php if (@$_GET['tahvil_durum'] == 0) { ?>
                                            <a href="/customers/view?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>&tahvil_durum=1"
                                               class="btn btn-primary btn-sm">Tehvil Hariç Hesapla</a>
                                        <?php } else { ?>
                                            <a href="/customers/view?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>&tahvil_durum=0"
                                               class="btn btn-primary btn-sm">Tehvil Dahil Hesapla</a>

                                        <?php } ?>

                                        <a href="/customers/fatura_kdv_raporu?para_birimi=<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi) ?>&id=<?php echo $details['id'] ?>"
                                           class="btn btn-primary btn-sm">KDV Raporu</a>

                                    </div>

                                    <table id="extres_cust" class="table datatable-show-all" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th>Firma</th>
                                            <th>KAYIT TARİXİ</th>
                                            <th>ƏMƏLİYYAT NÖVÜ</th>
                                            <th>Proje Adı</th>
                                            <th>QAİMƏ NÖMRƏSİ</th>
                                            <th>ÖDƏNİŞ NÖVÜ</th>
                                            <th class="no-sort">BORC</th>
                                            <th class="no-sort">ALACAQ</th>
                                            <th class="no-sort">QALIQ</th>
                                            <th class="no-sort">Açıklama</th>
                                            <th class="no-sort">İşlem Tarihi</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="no-sort"></th>
                                            <th class="no-sort"></th>
                                            <th class="no-sort"></th>
                                            <th class="no-sort"></th>

                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>

                                    </table>


                                </div>
                            </div>

                            <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="link-tab2"
                                 aria-expanded="true">

                                <form action="<?php echo base_url() ?>customers/statement" method="post" role="form">

                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                           value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <input type="hidden" id="para_birimi" name="para_birimi"
                                           value="<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi); ?>">

                                    <input type="hidden" name="customer" value="<?php echo $customer_id ?>">
                                    <input type="hidden" name="proje_ids" id="proje_ids" value="0">


                                    <div class="form-group row" style="display: none">
                                        <label class="col-sm-3 col-form-label"
                                               for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                                        <div class="col-sm-9">
                                            <select name="trans_type" class="form-control">
                                                <option value='All'><?php echo $this->lang->line('All Transactions') ?></option>
                                                <option value='Expense'><?php echo $this->lang->line('Debit') ?></option>
                                                <option value='Income'><?php echo $this->lang->line('Credit') ?></option>
                                            </select>


                                        </div>
                                    </div>

                                </form>


                                <div class="extres_cust_sozlesme">
                                    <table id="extres_cust_sozlesme"
                                           class="table datatable-show-all" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Firma</th>
                                            <th><?php echo $this->lang->line('Date') ?></th>
                                            <th><?php echo $this->lang->line('transaction_type') ?></th>
                                            <th>Proje Adı</th>
                                            <th><?php echo $this->lang->line('Invoice Number') ?></th>
                                            <th><?php echo $this->lang->line('payment_type') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="no-sort"></th>
                                            <th class="no-sort"></th>

                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>


                            </div>
                            <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="link-tab3"
                                 aria-expanded="true">

                                <div class="extres_cust_forma2">
                                    <table id="extres_cust_forma2"
                                           class="table datatable-show-all" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Firma</th>
                                            <th><?php echo $this->lang->line('Date') ?></th>
                                            <th><?php echo $this->lang->line('transaction_type') ?></th>
                                            <th>Proje Adı</th>
                                            <th><?php echo $this->lang->line('Invoice Number') ?></th>
                                            <th><?php echo $this->lang->line('payment_type') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="no-sort"></th>
                                            <th class="no-sort"></th>

                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab12" role="tabpanel" aria-labelledby="link-tab12"
                                 aria-expanded="true">

                                <form action="<?php echo base_url() ?>customers/statement" method="post" role="form">

                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                           value="<?php echo $this->security->get_csrf_hash(); ?>">

                                    <input type="hidden" id="para_birimi" name="para_birimi"
                                           value="<?php echo(isset($_GET['para_birimi']) ? $_GET['para_birimi'] : $para_birimi); ?>">

                                    <input type="hidden" name="customer" value="<?php echo $customer_id ?>">
                                    <input type="hidden" name="proje_ids" id="proje_ids" value="0">


                                    <div class="form-group row" style="display: none">
                                        <label class="col-sm-3 col-form-label"
                                               for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                                        <div class="col-sm-9">
                                            <select name="trans_type" class="form-control">
                                                <option value='All'><?php echo $this->lang->line('All Transactions') ?></option>
                                                <option value='Expense'><?php echo $this->lang->line('Debit') ?></option>
                                                <option value='Income'><?php echo $this->lang->line('Credit') ?></option>
                                            </select>


                                        </div>
                                    </div>


                                </form>


                                <div class="extres_cust_avans">
                                    <table id="extres_cust_avans"
                                           class="table datatable-show-all" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Firma</th>
                                            <th><?php echo $this->lang->line('Date') ?></th>
                                            <th><?php echo $this->lang->line('transaction_type') ?></th>
                                            <th>Proje Adı</th>
                                            <th><?php echo $this->lang->line('Invoice Number') ?></th>
                                            <th><?php echo $this->lang->line('payment_type') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                            <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="no-sort"></th>
                                            <th class="no-sort"></th>

                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>


                            </div>
                            <div class="tab-pane" id="tab13" role="tabpanel" aria-labelledby="link-tab13"
                                 aria-expanded="true">
                                <div class="extres_cust_odeme_bekleyen">
                                    <table id="extres_cust_odeme_bekleyen"
                                           class="table datatable-show-all" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th>Firma</th>
                                            <th><?php echo $this->lang->line('Date') ?></th>
                                            <th><?php echo $this->lang->line('transaction_type') ?></th>
                                            <th>Proje Adı</th>
                                            <th>Talep No</th>
                                            <th>Tutar</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="no-sort"></th>

                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="link-tab4"
                                 aria-expanded="true">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                        <table class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <th>Ödenen Esas Meblağ</th>
                                                <th>Gönderilmesi Gereken KDV</th>
                                                <th>Ödenen KDV</th>
                                                <th>KDV Bakiyesi</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td><?php echo amountFormat(kdv_odemesi(1, $customer_id)); ?></td>
                                                <td><?php echo amountFormat(kdv_odemesi(2, $customer_id)); ?></td>
                                                <td><?php echo amountFormat(kdv_odemesi(3, $customer_id)); ?></td>
                                                <td><?php $bakiye = kdv_odemesi(4, $customer_id);
                                                    echo amountFormat(abs($bakiye)) . ($bakiye > 0 ? " (A)" : " (B)"); ?></td>
                                            </tr>
                                            </tbody>

                                        </table>

                                    </div>

                                    <div class="form-group row">

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="link-tab5"
                                 aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Folder_path') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['folder_path'] ?>"
                                                       name="folder_path">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('cari_tipi') ?></label>

                                            <div class="col-sm-8">
                                                <?php if ($customer['cari_tipi'] == 1) {
                                                    $cari_tipi = "Özel";

                                                } else if ($customer['cari_tipi'] == 2) {
                                                    $cari_tipi = "Devlet";

                                                } else {
                                                    $cari_tipi = "Seçilmemiş";

                                                }


                                                ?>
                                                <input class="form-control" value="<?php echo $cari_tipi ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Company') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Company') ?>"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['company'] ?>" name="company">
                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="country"><?php echo $this->lang->line('Country') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Ülke"
                                                       class="form-control margin-bottom b_input" disabled
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
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['region'] ?>" name="region"
                                                       id="region">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="city"><?php echo $this->lang->line('City') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $this->lang->line('City') ?>"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['city'] ?>" name="city"
                                                       id="mcustomer_city">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="postbox"><?php echo $this->lang->line('PostBox') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Posta Kodu"
                                                       class="form-control margin-bottom b_input" disabled
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
                                                       class="form-control margin-bottom b_input" disabled
                                                       name="address" value="<?php echo $customer['address'] ?>"
                                                       id="mcustomer_address1">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="phone"><?php echo $this->lang->line('FirmaPhone') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('FirmaPhone') ?>"
                                                       class="form-control margin-bottom required b_input" disabled
                                                       name="phone" value="<?php echo $customer['phone'] ?>"
                                                       id="mcustomer_phone">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="email"><?php echo $this->lang->line('FirmaEmail') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('FirmaEmail') ?>"
                                                       class="form-control margin-bottom required b_input" disabled
                                                       name="email" value="<?php echo $customer['email'] ?>"
                                                       id="mcustomer_email">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Authorized person') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Authorized person') ?>"
                                                       class="form-control margin-bottom b_input required" disabled
                                                       name="name" value="<?php echo $customer['name'] ?>"
                                                       id="mcustomer_name">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('yetkili_tel') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('yetkili_tel') ?>"
                                                       class="form-control margin-bottom b_input required" disabled
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
                                                       class="form-control margin-bottom b_input required" disabled
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
                                                       class="form-control margin-bottom b_input required" disabled
                                                       name="yetkili_gorev"
                                                       value="<?php echo $customer['yetkili_gorev'] ?>"
                                                       id="yetkili_gorev">
                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('sorumlu_personel') ?></label>

                                            <div class="col-sm-8">
                                                <input class="form-control" disabled
                                                       value="<?php echo personel_details($customer['sorumlu_personel']) ?>">

                                            </div>
                                        </div>
                                        <div class="form-group row mt-1">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('sorumlu_muhasebe_personeli') ?></label>

                                            <div class="col-sm-8">
                                                <input class="form-control" disabled
                                                       value="<?php echo personel_details($customer['sorumlu_muhasebe_personeli']) ?>">

                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Sektor') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="Firma Sektörü"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['sektor'] ?>" name="sektor">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="name"><?php echo $this->lang->line('Company About') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Company About') ?>"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['company_about'] ?>"
                                                       name="company_about">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="taxid"><?php echo $this->lang->line('voyn') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $this->lang->line('voyn') ?>"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['taxid'] ?>" name="taxid">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="taxid"><?php echo $this->lang->line('edv') ?></label>

                                            <div class="col-sm-8">
                                                <input type="text" placeholder="<?php echo $this->lang->line('edv') ?>"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo round($customer['kdv_orani']) ?>"
                                                       name="kdv_orani">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="musteri_tipi"><?php echo $this->lang->line('sirket_tipi') ?></label>

                                            <div class="col-sm-8">


                                                <?php if ($customer['sirket_tipi'] == 1) {
                                                    $sirket_tipi = 'Tekil Firması';
                                                } else if ($customer['sirket_tipi'] == 2) {
                                                    $sirket_tipi = 'Grup Firması';
                                                } else {
                                                    $sirket_tipi = 'Seçilmemiş';
                                                }
                                                ?>

                                                <input class="form-control" disabled
                                                       value="<?php echo $sirket_tipi; ?>">


                                            </div>
                                        </div>

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label" for="product_name">Alt
                                                Firmalar</label>
                                            <div class="col-sm-8">

                                                <?php
                                                $html = '';
                                                foreach (customer_parent($customer['id']) as $key => $value) {
                                                    $sayi = floatval($key) + floatval(1);
                                                    $html .= ' ' . $sayi . ' - ' . customer_details($value)['company'];
                                                } ?>
                                                <input class="form-control" disabled value="<?php echo $html ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="musteri_tipi"><?php echo $this->lang->line('Customer group') ?></label>

                                            <div class="col-sm-8">
                                                <input class="form-control" disabled
                                                       value="<?php echo geopos_customer_type_id($customer['musteri_tipi'])['name'] ?>">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab6" role="tabpanel" aria-labelledby="link-tab6"
                                 aria-expanded="true">
                                <div class="saman-row">
                                    <table class="table datatable-show-all" id="bank_bilgileri_table">
                                        <thead>
                                        <tr>
                                            <th>Banka Adı</th>
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
                                                </tr>

                                                <?php
                                            }
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab7" role="tabpanel" aria-labelledby="link-tab7"
                                 aria-expanded="true">

                                <div class="saman-row">
                                    <table class="table datatable-show-all" id="invoice_bilgileri_table">
                                        <thead>
                                        <tr>

                                            <th>Ünvan Adı</th>

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
                                                </tr>

                                                <?php
                                            }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab8" role="tabpanel" aria-labelledby="link-tab8"
                                 aria-expanded="true">

                                <div class="saman-row">
                                    <table class="table datatable-show-all" id="teslimat_bilgileri_table">
                                        <thead>
                                        <tr>
                                            <th>Ünvan Adı</th>
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
                                                </tr>

                                                <?php
                                            }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab9" role="tabpanel" aria-labelledby="link-tab9"
                                 aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"
                                                   for="Discount"><?php echo $this->lang->line('Discount') ?> </label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="İskonto Oranı"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['discount_c']; ?>" name="discount">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="customer_teminat"><?php echo $this->lang->line('Customer Teminat') ?></label>

                                            <div class="col-sm-10">
                                                <?php
                                                foreach (teminat_type() as $teminat) {
                                                    $id = $teminat->id;
                                                    $name = $teminat->name;
                                                    if ($id == $customer['teminat_type']) {
                                                        ?>
                                                        <input type="text" placeholder="İskonto Oranı"
                                                               class="form-control margin-bottom b_input" disabled
                                                               value="<?php echo $name ?>">
                                                        <?php

                                                    }
                                                }
                                                ?>

                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="customer_teminat_desc"><?php echo $this->lang->line('Customer Teminat Description') ?></label>

                                            <div class="col-sm-10">
                                                <input type="text"
                                                       placeholder="<?php echo $this->lang->line('Customer Teminat Description') ?>"
                                                       class="form-control margin-bottom b_input" disabled
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
                                                       class="form-control margin-bottom b_input" disabled
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
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo $customer['customer_credit_you']; ?>"
                                                       name="customer_credit_you">
                                            </div>
                                        </div>
                                        <!-- Kredi Bilgileri -->

                                        <div class="form-group row">

                                            <label class="col-sm-2 col-form-label"
                                                   for="currency">Dil</label>

                                            <div class="col-sm-10">

                                                <input type="text"
                                                       class="form-control margin-bottom b_input" disabled
                                                       value="<?php echo ucfirst($customer['lang']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <div class="col-sm-12 saman-row">
                                                <table class="table" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Tip</th>
                                                        <th>İsim - Soyisim</th>
                                                        <th>Tel</th>
                                                        <th>Mail</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php if (isset($customer_pers)) {
                                                        foreach ($customer_pers as $pers) {
                                                            ?>

                                                            <tr>
                                                                <td>
                                                                    <?php foreach (role_name() as $role) {
                                                                        $id = $role['id'];
                                                                        $name = $role['name'];
                                                                        if ($pers->tip == $id) {
                                                                            echo "<input class='form-control'  disabled value='$name'>";
                                                                        }


                                                                    } ?>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" name="ekstra_fullname[]"
                                                                           disabled
                                                                           value="<?php echo $pers->fullname ?>">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" name="ekstra_tel[]"
                                                                           disabled value="<?php echo $pers->tel ?>">
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" name="ekstra_mail[]"
                                                                           disabled value="<?php echo $pers->mail ?>">
                                                                </td>

                                                            </tr>

                                                        <?php }
                                                    } ?>


                                                    </tbody>

                                                </table>

                                                <input type="hidden" value="0" name="counter" id="ganak">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab10" role="tabpanel" aria-labelledby="link-tab10"
                                 aria-expanded="true">
                                <table class="table datatable-show-all">
                                    <thead>
                                    <tr>
                                        <th>Tür</th>
                                        <th>Borç</th>
                                        <th>Alacak</th>
                                        <th>Banka Ödenen</th>
                                        <th>Banka Gelen</th>
                                        <th>KDV Ödenen</th>
                                        <th>KDV Gelen</th>
                                        <th>Nakit Ödenen</th>
                                        <th>Nakit Gelen</th>
                                        <th>Banka Qalıq</th>
                                        <th>Kdv Qalıq</th>
                                        <th>Nakit Qalıq</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Qaime Esas Meblağ</td>
                                        <td><?php $invoice_type = "1,2";
                                            $method = 'invoice';
                                            $tip = "0";
                                            $bak1 = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdvsiz_borc']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdvsiz_borc'] : 0;
                                            echo amountFormat($bak1); ?></td>
                                        <td><?php $invoice_type = "1,2";
                                            $method = 'invoice';
                                            $tip = "0";
                                            $bak2 = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdvsiz_alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdvsiz_alacak'] : 0;
                                            echo amountFormat($bak2); ?></td>
                                        <td><?php $invoice_type = "3,4,17,18";
                                            $method = 'transaction';
                                            $tip = "3";
                                            $kdv_borc_banka = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc'] : 0;
                                            echo amountFormat($kdv_borc_banka); ?></td>
                                        <td><?php $invoice_type = "3,4,17,18";
                                            $method = 'transaction';
                                            $tip = "3";
                                            $kdv_alacak_banka = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak'] : 0;
                                            echo amountFormat($kdv_alacak_banka); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <?php
                                            $banka_qaliq = floatval($bak1) - floatval($kdv_alacak_banka);
                                            $banka_qaliq_sonuc = amountFormat(abs($banka_qaliq)) . ($banka_qaliq > 0 ? " (B)" : " (A)");

                                            $banka_qaliq_2 = floatval($bak2) - floatval($kdv_borc_banka);
                                            $banka_qaliq_sonuc = amountFormat(abs($banka_qaliq_2)) . ($banka_qaliq_2 > 0 ? " (A)" : " (B)");

                                            $qaliq = ($banka_qaliq - ($banka_qaliq_2));

                                            if (abs($banka_qaliq) > abs($banka_qaliq_2)) {
                                                $str = $banka_qaliq > 0 ? " (B)" : " (A)";
                                            } else {
                                                $str = $banka_qaliq_2 > 0 ? " (A)" : " (B)";
                                            }
                                            echo amountFormat(abs($qaliq)) . $str;

                                            ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Qaime EDV Meblağ</td>
                                        <td><?php $invoice_type = "1,2";
                                            $method = 'invoice';
                                            $tip = "0";
                                            $kdv_borc = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdv_borc']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdv_borc'] : 0;
                                            echo amountFormat($kdv_borc); ?></td>
                                        <td><?php $invoice_type = "1,2";
                                            $method = 'invoice';
                                            $tip = "0";
                                            $kdv_alacak = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdv_alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['kdv_alacak'] : 0;
                                            echo amountFormat($kdv_alacak); ?></td>
                                        <td><?php $invoice_type = '19,20';
                                            $method = 'transaction';
                                            $tip = "3";
                                            $kdv_borc_banka_edv = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc'] : 0;
                                            echo amountFormat($kdv_borc_banka_edv); ?></td>
                                        <td></td>
                                        <td><?php $invoice_type = '19,20';
                                            $method = 'transaction';
                                            $tip = "4";
                                            $kdv_borc_banka_edv = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc'] : 0;
                                            echo amountFormat($kdv_borc_banka_edv); ?></td>
                                        <td><?php $invoice_type = '19,20';
                                            $method = 'transaction';
                                            $tip = "4";
                                            $kdv_alacak_banka_edv = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak'] : 0;
                                            echo amountFormat($kdv_alacak_banka_edv); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php $sonuc = $kdv_alacak - $kdv_borc_banka_edv + $kdv_alacak_banka_edv;
                                            $str_s = $sonuc > 0 ? " (A)" : " (B)";
                                            echo amountFormat(abs($sonuc)) . $str_s; ?></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Nağd Qaime</td>
                                        <td><?php $invoice_type = '38';
                                            $method = 'invoice';
                                            $tip = "0";
                                            $nakit_invoice_borc = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['borc'] : 0;
                                            echo amountFormat($nakit_invoice_borc); ?></td>
                                        <td><?php $invoice_type = '38';
                                            $method = 'invoice';
                                            $tip = "0";
                                            $nakit_invoice_alacak = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak'] : 0;
                                            echo amountFormat($nakit_invoice_alacak); ?></td>
                                        <td><?php echo amountFormat(0) ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><?php $invoice_type = '38';
                                            $method = 'invoice';
                                            $tip = "0";
                                            $nakit_invoice_alacak = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak'] : 0;
                                            echo amountFormat($nakit_invoice_alacak); ?></td>
                                        <td><?php $invoice_type = '3,4,14,43,44,45,46,17,18';
                                            $method = 'invoice';
                                            $tip = "1";
                                            $nakit_alacak = isset(cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak']) ? cari_alacak_borc_bakiye($_GET['id'], $tip, $method, $invoice_type)['alacak'] : 0;
                                            echo amountFormat($nakit_alacak); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab11" role="tabpanel" aria-labelledby="link-tab11"
                                 aria-expanded="true">
                                <div class="">

                                    <h4 class="title">
                                        <?php echo $this->lang->line('Documents') ?>
                                    </h4>
                                    <div class="row">

                                        <div class="col-md-2">Sözleşme Tarihi</div>
                                        <div class="col-md-2">
                                            <input type="text" name="start_date" id="start_date"
                                                   class="date30 form-control form-control-sm" autocomplete="off"/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="end_date" id="end_date"
                                                   class="form-control form-control-sm"
                                                   data-toggle="datepicker" autocomplete="off"/>
                                        </div>

                                        <div class="col-md-2">
                                            <input type="button" name="search" id="search" value="Filtrele"
                                                   class="btn btn-info btn-sm"/>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" type="button" name="search" id="search" value="Temizle"
                                               class="btn btn-info btn-sm">Temizle</a>
                                        </div>

                                    </div>
                                    <hr>


                                    <table id="doctable" class="table datatable-show-all"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line('Title') ?></th>
                                            <th>Başlangıç Tarihi</th>
                                            <th>Bitiş Tarihi</th>
                                            <th>Proje</th>
                                            <th>Dosya Tipi</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>


                                </div>

                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>









<style>


    .filterIcon {
        height: 16px;
        width: 16px;
    }

    .modalFilter {
        display: none;
        height: auto;
        background: #FFF;
        border: solid 1px #ccc;
        padding: 8px;
        position: absolute;
        z-index: 1001;
        width: 15% !important;
    }

    th {
        white-space: nowrap;
    }

    .modalFiltersoz, .modalFilterforma2, .modalFilteravans {
        display: none;
        height: auto;
        background: #FFF;
        border: solid 1px #ccc;
        padding: 8px;
        position: absolute;
        z-index: 1001;
        width: 15% !important;
    }

    [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
        position: absolute;
        left: -9999px;
        opacity: 0
    }

    [type="checkbox"] + label {
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        display: inline-block;
        height: 25px;
        line-height: 25px;
        font-size: 1rem;
        -webkit-user-select: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        -ms-user-select: none
    }

    [type="checkbox"] + label:before, [type="checkbox"]:not(.filled-in) + label:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 18px;
        height: 18px;
        z-index: 0;
        border: 2px solid #5a5a5a;
        border-radius: 1px;
        margin-top: 2px;
        transition: .2s
    }

    [type="checkbox"]:not(.filled-in) + label:after {
        border: 0;
        -webkit-transform: scale(0);
        transform: scale(0)
    }

    [type="checkbox"]:not(:checked):disabled + label:before {
        border: none;
        background-color: rgba(0, 0, 0, 0.26)
    }

    [type="checkbox"].tabbed:focus + label:after {
        -webkit-transform: scale(1);
        transform: scale(1);
        border: 0;
        border-radius: 50%;
        box-shadow: 0 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: rgba(0, 0, 0, 0.1)
    }

    [type="checkbox"]:checked + label:before {
        top: -4px;
        left: -5px;
        width: 12px;
        height: 22px;
        border-top: 2px solid transparent;
        border-left: 2px solid transparent;
        border-right: 2px solid #26a69a;
        border-bottom: 2px solid #26a69a;
        -webkit-transform: rotate(40deg);
        transform: rotate(40deg);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform-origin: 100% 100%;
        transform-origin: 100% 100%
    }

    [type="checkbox"]:checked:disabled + label:before {
        border-right: 2px solid rgba(0, 0, 0, 0.26);
        border-bottom: 2px solid rgba(0, 0, 0, 0.26)
    }

    [type="checkbox"]:indeterminate + label:before {
        top: -11px;
        left: -12px;
        width: 10px;
        height: 22px;
        border-top: none;
        border-left: none;
        border-right: 2px solid #26a69a;
        border-bottom: none;
        -webkit-transform: rotate(90deg);
        transform: rotate(90deg);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform-origin: 100% 100%;
        transform-origin: 100% 100%
    }

    [type="checkbox"]:indeterminate:disabled + label:before {
        border-right: 2px solid rgba(0, 0, 0, 0.26);
        background-color: transparent
    }

    [type="checkbox"].filled-in + label:after {
        border-radius: 2px
    }

    [type="checkbox"].filled-in + label:before, [type="checkbox"].filled-in + label:after {
        content: '';
        left: 0;
        position: absolute;
        transition: border .25s, background-color .25s, width .20s .1s, height .20s .1s, top .20s .1s, left .20s .1s;
        z-index: 1
    }

    [type="checkbox"].filled-in:not(:checked) + label:before {
        width: 0;
        height: 0;
        border: 3px solid transparent;
        left: 6px;
        top: 10px;
        -webkit-transform: rotateZ(37deg);
        transform: rotateZ(37deg);
        -webkit-transform-origin: 20% 40%;
        transform-origin: 100% 100%
    }

    [type="checkbox"].filled-in:not(:checked) + label:after {
        height: 20px;
        width: 20px;
        background-color: transparent;
        border: 2px solid #5a5a5a;
        top: 0px;
        z-index: 0
    }

    [type="checkbox"].filled-in:checked + label:before {
        top: 0;
        left: 1px;
        width: 8px;
        height: 13px;
        border-top: 2px solid transparent;
        border-left: 2px solid transparent;
        border-right: 2px solid #fff;
        border-bottom: 2px solid #fff;
        -webkit-transform: rotateZ(37deg);
        transform: rotateZ(37deg);
        -webkit-transform-origin: 100% 100%;
        transform-origin: 100% 100%
    }

    [type="checkbox"].filled-in:checked + label:after {
        top: 0;
        width: 20px;
        height: 20px;
        border: 2px solid #26a69a;
        background-color: #26a69a;
        z-index: 0
    }

    [type="checkbox"].filled-in.tabbed:focus + label:after {
        border-radius: 2px;
        border-color: #5a5a5a;
        background-color: rgba(0, 0, 0, 0.1)
    }

    [type="checkbox"].filled-in.tabbed:checked:focus + label:after {
        border-radius: 2px;
        background-color: #26a69a;
        border-color: #26a69a
    }

    [type="checkbox"].filled-in:disabled:not(:checked) + label:before {
        background-color: transparent;
        border: 2px solid transparent
    }

    [type="checkbox"].filled-in:disabled:not(:checked) + label:after {
        border-color: transparent;
        background-color: #BDBDBD
    }

    [type="checkbox"].filled-in:disabled:checked + label:before {
        background-color: transparent
    }

    [type="checkbox"].filled-in:disabled:checked + label:after {
        background-color: #BDBDBD;
        border-color: #BDBDBD
    }

    .switch, .switch * {
        -webkit-user-select: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        -ms-user-select: none
    }

    .modalFilter .modal-content {
        max-height: 250px;
        overflow-y: auto;
        border: none !important;
        box-shadow: none !important;
    }
    @media (min-width: 576px)
        .modal-content {
            box-shadow: none !important;
        }

        .modalFilter .modal-footer {
            background: #FFF;
            height: 55px;
            padding-top: 20px;
            padding-right: 0px;
        }

        .modalFilter .btn {
            padding: 0 1em;
            height: 28px;
            line-height: 28px;
            text-transform: none;
        }


        .modalFiltersoz .modal-content {
            max-height: 250px;
            overflow-y: auto;
            border: none !important;
        }

        .modalFiltersoz .modal-footer {
            background: #FFF;
            height: 35px;
            padding-top: 20px;
            padding-right: 0px;
        }

        .modalFiltersoz .btn {
            padding: 0 1em;
            height: 28px;
            line-height: 28px;
            text-transform: none;
        }

        .modalFilterforma2 .modal-content {
            max-height: 250px;
            overflow-y: auto;
            border: none !important;
        }

        .modalFilterforma2 .modal-footer {
            background: #FFF;
            height: 35px;
            padding-top: 20px;
            padding-right: 0px;
        }

        .modalFilterforma2 .btn {
            padding: 0 1em;
            height: 28px;
            line-height: 28px;
            text-transform: none;
        }

        .modalFilteravans .modal-content {
            max-height: 250px;
            overflow-y: auto;
            border: none !important;
        }

        .modalFilteravans .modal-footer {
            background: #FFF;
            height: 35px;
            padding-top: 20px;
            padding-right: 0px;
        }

        .modalFilteravans .btn {
            padding: 0 1em;
            height: 28px;
            line-height: 28px;
            text-transform: none;
        }

        #mask, #forma2, #avans {
            display: none;
            background: transparent;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            opacity: 1000;
        }

        #mask_soz, #forma2, #avans {
            display: none;
            background: transparent;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            opacity: 1000;
        }

        input[type="radio"], input[type="checkbox"] {
            width: 22px;
        }
</style>
<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Email</h4>
            </div>

            <div class="modal-body">
                <form id="sendmail_form">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $details['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Customer Name') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $details['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="cid" name="tid" value="<?php echo $details['id'] ?>">
                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNow"><?php echo $this->lang->line('Send') ?></button>
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
                               for="name">Kasa</label>
                        <select name="acid" class="form-control" id="acid">
                            <?php foreach (not_account_acik() as $acc) {
                                $id = $acc['id'];
                                $holder = $acc['holder'];
                                echo "<option value='$id'>$holder</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tip</label>
                        <select name="alacakak_borc" class="form-control" id="alacakak_borc">
                            <?php foreach (cari_alacak_borc() as $acc) {
                                echo "<option value='$acc->id'>$acc->description</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Firma Seçiniz</label><br>
                        <select style="width: 300px" class="form-control select-box" id="alt_customer_id"
                                name="alt_customer_id">
                            <option>Seçiniz</option>
                            <?php foreach (all_customer() as $customer) {
                                echo "<option value='" . $customer->id . "'>" . $customer->company . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">İşlem Tipi</label>
                        <select name="islem_tipi" class="form-control" id="islem_tipi">
                            <option value="0">Seçiniz</option>
                            <option value="2">Finans İşlemi</option>
                            <option value="3">KDV</option>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label" for="name">İşlemler</label>
                        <select name="islem_listesi" class="form-control" id="islem_listesi">
                            <option value="0">İşlem Tipi Seçiniz</option>
                        </select>
                    </div>


                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tutar</label>
                        <input class="form-control" type="text" name="alacak_tutar" id="alacak_tutar">
                    </div>


                    <div class="col-sm-12">
                        <label class="col-form-label" for="name">Oran (%)</label>
                        <input class="form-control" type="text" id='oran' name="oran">
                    </div>


                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Hesaplanan Tutar</label>
                        <input class="form-control" type="text" name="hesaplanan_tutar" id="hesaplanan_tutar">
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tarih</label>
                        <input type="date" class="form-control required"
                               placeholder="Billing Date" name="dates">
                    </div>

                    <br>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="action-url-alacak" value="transactions/cari_alacak_borc">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_alacak"><?php echo $this->lang->line('Yes') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="pop_model_kontrol" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">İşlem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_controller">

                    <input name="controller_cari_id" type="hidden" value="<?php echo $_GET['id'] ?>">
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tarih</label>
                    </div>
                    <div class="col-sm-12">
                        <input type="date" id="controller_date" name="controller_date" class="form-control">
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Açıklama</label>
                    </div>
                    <div class="col-sm-12">
                        <textarea class="form-control" name="controller_notes" id="controller_notes"></textarea>
                    </div>

                    </br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                        <input type="hidden" id="url_controller" value="customers/controller_save">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_controller"><?php echo $this->lang->line('Yes') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="pop_model_alacaklandirma_musteri" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">İşlem</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model_alacak_">

                    <input name="cari_id" type="hidden" value="<?php echo $_GET['id'] ?>">
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Proje</label>
                    </div>
                    <div class="col-sm-12">
                        <select name="proje_id_alacak" class="form-control select-box" id="proje_id_alacak">
                            <?php foreach (all_projects() as $acc) {
                                echo "<option value='$acc->id'>$acc->name</option>";
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
                            <option value="39">Cari Alacaklandır</option>
                            <option value="40">Cari Borçlandır</option>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Metod</label>
                        <select name="alacak_metod" class="form-control" id="paymethod">
                            <?php foreach (account_type_islem() as $acc) {
                                echo "<option value='$acc->id'>$acc->name</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-form-label"
                               for="name">Tarih</label>
                        <input type="date" class="form-control" name="tarix" placeholder="Tarix daxiledın" id="tarix">

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
                        <input type="hidden" id="url_alacak" value="customers/cari_alacaklandir_borclandir">
                        <button type="button" class="btn btn-primary"
                                id="submit_model_alacak_"><?php echo $this->lang->line('Yes') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="location_logo" value="<?php $loc = location($this->aauth->get_user()->loc);
echo base_url('userfiles/company/' . $loc['logo']) ?>">
<style>

    #extres_cust_length, #extres_cust_info, #extres_cust_paginate, #extres_cust_filter {
        display: none;
    }

    #extres_cust_sozlesme_length, #extres_cust_sozlesme_info, #extres_cust_sozlesme_paginate, #extres_cust_sozlesme_filter {
        display: none;
    }

    #extres_cust_avans_length, #extres_cust_avans_info, #extres_cust_avans_paginate, #extres_cust_avans_filter {
        display: none;
    }


    #extres_cust_odeme_bekleyen_length, extres_cust_odeme_bekleyen_info, #extres_cust_odeme_bekleyen_paginate, #extres_cust_odeme_bekleyen_filter {
        display: none;
    }

    #extres_cust_forma2_length, #extres_cust_forma2_info, #extres_cust_forma2_paginate, #extres_cust_forma2_filter {
        display: none;
    }

    #extres_cust_length, #extres_cust_info, #extres_cust_paginate, #extres_cust_filter {
        display: none;
    }


    .table th, .table td {
        padding-bottom: 7px !important;
        padding-top: 4px !important;
        padding-left: 10px !important;
        padding-right: 0px !important;
        font-size: 12px !important;
    }

    table tfoot {
        display: table-row-group;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
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

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this document') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="customers/delete_document">
                <input type="hidden" id="cid" value="<?php echo $_GET['id'] ?>">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
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

            </div>
        </div>
    </div>
</div>
<div id="mask"></div>
<div id="mask_soz"></div>
<div id="mask_forma2"></div>
<div id="mask_avans"></div>
<input type="hidden" id="cari_unvan" value="<?php echo customer_details($_GET['id'])['company'] ?>">
<input type="hidden" id="cari_yetkili" value="<?php echo customer_details($_GET['id'])['name'] ?>">
<input type="hidden" id="bas_d" value="">
<input type="hidden" id="bit_d" value="">
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script type="text/javascript">

    $(document).on('click', ".banka_details, .invoice_details, .teslimat_details", function (e) {
        e.preventDefault();
        var tip = $(this).attr('tip');
        var id = $(this).attr('id');

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'customers/view_customer_details_';
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

    $('#sdate_2').datepicker('setDate', '<?php echo date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))); ?>');

</script>


<script type="text/javascript">


    $(function () {
        $('.select-box').select2();
    });


    function currencyFormat(num) {

        var deger = num.toFixed(2).replace('.', ',');
        return deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' AZN';
    }


    var cari = $('#cari_unvan').val();
    var direktor = $('#cari_yetkili').val();
    var string_bakiye = 0;
    var bakiye_ba = '';
    var firma = "MAKRO 2000 EĞİTİM TEKNOLOJİLERİ İNŞAAT TAAHHÜT İÇ VE DIŞ TİCARET ANONİM ŞİRKETİNİN AZƏRBAYCAN RESPUBLİKASINDAKI FİLİALI";
    var firma_direktor = "Lokman Biter";
    var text = "";


    var table;
    var tables;

    var tables_forma2;
    var tablesf;
    var tablebo;
    var url = $('#location_logo').val();

    var modalFilterArray = {};
    var modalFilterArray_soz = {};
    var modalFilterArray_forma2 = {};
    var modalFilterArray_avans = {};
    var modalFilterArray_odeme = {};


    $(document).on('click', '#base-tab1, #base-tab2, #base-tab3,#base-tab4, #base-tab5, #base-tab6, #base-tab7, #base-tab7, #base-tab9, #base-tab10, #base-tab11, #base-tab-12, #base-tab-13', function () {

        $('#extres_cust').DataTable().draw();
        $('#extres_cust_sozlesme').DataTable().draw();
        $('#extres_cust_forma2').DataTable().draw();
        $('#extres_cust_avans').DataTable().draw();
        $('#extres_cust_odeme_bekleyen').DataTable().draw();
        $('#doctable').DataTable().draw();

    });


    $(document).ready(function () {


        draw_data();
        draw_data_belgeler();

        var colArray = [0, 2, 3, 5];
        var tableName_ = 'extres_cust';

        extre_table_filter(tableName_, colArray);

        $('#loading-box').removeClass('d-none');
        setTimeout(function () {
            var test = $("#extres_cust tfoot tr th").eq(8).text();

            var res = test.split("AZN");

            bakiye_ba = res[1];
            string_bakiye = test;

            if (bakiye_ba == ' (B)') {
                text = ` -de ` + string_bakiye + ` borcu var.`;
            } else {
                text = ` -ə ` + string_bakiye + ` alacağı (avansı(artıq ödəməsi) var.`;
            }
            $('#loading-box').addClass('d-none');
        }, 1000);

        draw_data_soz();

        var colArray_soz = [0, 2, 3, 5];
        var tableName_soz = 'extres_cust_sozlesme';
        extre_table_filter_soz(tableName_soz, colArray_soz);


        draw_data_forma2();

        var colArray_forma2 = [0, 2, 3, 5];
        var tableName_forma2 = 'extres_cust_forma2';
        extre_table_filter_forma2(tableName_forma2, colArray_forma2);


        draw_data_avans();

        var colArray_avans = [0, 2, 3, 5];
        var tableName_avans = 'extres_cust_avans';
        extre_table_filter_avans(tableName_avans, colArray_avans);


        draw_data_odeme_bekleyen();
        var colArray_odeme_bekleyen = [3];
        var tableName_odeme_bekleyen = 'extres_cust_odeme_bekleyen';
        extre_table_filter_odeme_bekleyen(tableName_odeme_bekleyen, colArray_odeme_bekleyen);

    });


    function draw_data(start_date = '', end_date = '', proje_id = 0, parent_id = 0) {
        var bas_tarihi = $('#bas_d').val();
        var bitis_tarihi = $('#bit_d').val();


        table = $('#extres_cust').DataTable({
            dom: 'Bfrtip',
            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style', data[8]);

            },
            'order': [],
            "ordering": false,
            'ajax': {
                'url': "<?php echo site_url('customers/ekstre')?>",
                'type': 'POST',
                'dataType': 'json',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    'para_birimi': $('#para_birimi').val(),
                    'kdv_tipi': 0,
                    'cid':<?php echo @$_GET['id'] ?>,
                    'proje_id': proje_id,
                    'parent_id': parent_id,
                    'tyd': '<?php echo @$_GET['t'] ?>',
                    'kdv_durum': '<?php echo @$_GET['kdv_durum'] ?>',
                    'tahvil_durum': '<?php echo @$_GET['tahvil_durum'] ?>',
                    'forma2_durum': '<?php echo @$_GET['forma2_durum'] ?>',
                    'start_date': start_date,
                    'end_date': end_date
                }
            },
            "drawCallback": function (settings) {
                // Here the response
                var response = settings.json['bakiye'];
                $('#bakiye_string').val(response);
                $('.dataTables_scrollBody').scrollTop(9999999)

            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            "footerCallback": function (row, data, start, end, display) {

                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                  var floatVal = function (i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/[^0-9,-]+/g, '').replace(',', '.')) || 0 :
                        typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(7)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));


                $(api.column(7).footer()).html(tatals);
                $(api.column(6).footer()).html(tatals2);
                $(api.column(8).footer()).html(bakiyes + ' ' + string);


            },
            buttons: [


                {
                    messageTop: "<div style='text-align: center'><img src='" + url + "' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',
                    title: '<h3 style="text-align: center">Hesap Özeti</h3>',
                    footer: true,
                    exportOptions: {
                        columns: [10, 2, 4, 5, 6, 7, 8]
                    }
                },
                {

                    messageTop: "<div style='text-align: center'><h3><b>ÜZLƏŞDİRMƏ AKTI</b></h3></br><p>Biz aşağıda imza edənlər " + cari + "-nin direktoru " + direktor + " ve " + firma + " -nın direktoru " + firma_direktor + " tərəfindən " +
                        "təsdiq edirik ki, qarşılıqlı yoxlamaya əsasən aşağıda qeyd olunmuş göstəricilər düzgündür və tərəflər arasında qarşılıqlı borclar aşağıda göstərilənlərə uyğundur.</p></div>",
                    messageBottom: "" +
                        "<p style='text-align: center;'>" + bitis_tarihi + "-cı il tarixinə " + firma + "-nin  " + cari + text + "</p>" +
                        "<div class='row'>" +
                        "<div style='float: right' class='col-sm'>MAKRO 2000 EĞİTİM TEKNOLOJİLERİ İNŞAAT TAAHHÜT İÇ VE DIŞ</br> TİCARET ANONİM ŞİRKETİNİN AZƏRBAYCAN RESPUBLİKASINDAKI FİLİALI</br> MÜHASİBATLIQ ŞÖBƏSİ : </br></br></br></br>___________________</br></br></br>Direktör : " + firma_direktor + " </br></br></br>TARİX : " + bitis_tarihi + "</div>" +
                        "<div style='text-align: end' class='col-sm'>" + cari + "</br> MÜHASİBATLIQ ŞÖBƏSİ : </br></br></br></br>___________________</br></br></br>Direktör : ___________________ </br></br></br>TARİX : " + bitis_tarihi + "</div>" +

                        "</div>" +
                        "<div style='text-align: center;'><br><br><br><p style='font-size: 10px;text-align: center'>" + firma + "<br/>" +
                        "+994 12 597 48 18 , +994 50 286 20 05 , +994 12 597 48 18	<br/>" +
                        "World Business Center, Səməd Vurğun 43, Nəsimi rayonu, 3-cü mərtəbə, Bakı/Azərbaycan</br>muhasebe@makro2000.com.tr</p></div>",
                    extend: 'print',
                    text: 'Üzleşdirme Aktı',
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '10pt')
                        var test = $("#extres_cust tfoot tr th").eq(8).text();
                        var res = test.split("AZN");
                        string_bakiye = test;
                        if (bakiye_ba == ' (B)') {
                            text = ` -de ` + string_bakiye + ` borcu var.`;
                        } else {
                            text = ` -ə ` + string_bakiye + ` alacağı (avansı(artıq ödəməsi) var.`;
                        }


                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', '10pt');

                    },
                    title: '<h3 style="text-align: center"><b>' + firma + ' ile ' + cari + ' ARASINDA ' + bas_tarihi + '-Cİ İL TARİXİNDƏN ' + bitis_tarihi + '-ci il TARİXİNƏDƏK</b></h3>',
                    fontSize: 10,
                    footer: true,
                    exportOptions: {
                        columns: [10, 2, 4, 5, 6, 7, 8]
                    }
                }

            ]


        });


    }

    function extre_table_filter(tableName, colArray) {

        setTimeout(function () {
            $.each(colArray, function (i, arg) {
                $('.' + tableName + ' thead th:eq(' + arg + ')').append('<img src="/filters.png" class="filterIcon" onclick="showFilter(event,\'' + tableName + '_' + arg + '\')" />');
            });

            var template = '<div class="modalFilter">' +
                '<div class="modal-content">' +
                '{0}</div>' +
                '<div class="modal-footer">' +
                '<a href="#!" onclick="clearFilter(this, {1}, \'{2}\');"  class=" btn btn-warning btn-sm">Temizle</a>' +
                '<a href="#!" onclick="performFilter(this, {1}, \'{2}\');"  class=" btn btn-info btn-sm">Filtrele</a>' +
                '</div>' +
                '</div>';
            $.each(colArray, function (index, value) {
                table.columns().every(function (i) {
                    if (value === i) {
                        var column = this,
                            content = '<input type="text" class="filterSearchText" onkeyup="filterValues(this)" /> <br/>';
                        var columnName = $(this.header()).text().replace(/\s+/g, "_");
                        var distinctArray = [];
                        column.data().each(function (d, j) {
                            if (distinctArray.indexOf(d) == -1) {
                                var id = tableName + "_" + columnName + "_" + j; // onchange="formatValues(this,' + value + ');
                                content += '<div><input class="" type="checkbox" value="' + d + '"  id="' + id + '"/><label for="' + id + '"> ' + d + '</label></div>';
                                distinctArray.push(d);
                            }
                        });
                        var newTemplate = $(template.replace('{0}', content).replace('{1}', value).replace('{1}', value).replace('{2}', tableName).replace('{2}', tableName));
                        $('body').append(newTemplate);
                        modalFilterArray[tableName + "_" + value] = newTemplate;
                        content = '';
                    }
                });
            });

        }, 2000);
    }

    function draw_data_soz(proje_id = 0) {


        tables = $('#extres_cust_sozlesme').DataTable({
            'processing': true,
            "ordering": false,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style', data[7]);
            },
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/ekstre_sozlesme')?>",
                'type': 'POST',
                'dataType': 'json',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    'para_birimi': $('#para_birimi').val(),
                    'kdv_tipi': 0,
                    'cid':<?php echo @$_GET['id'] ?>,
                    'proje_id': proje_id,
                    'tyd': '<?php echo @$_GET['t'] ?>',
                    'kdv_durum': '<?php echo @$_GET['kdv_durum'] ?>',
                    'tahvil_durum': '<?php echo @$_GET['tahvil_durum'] ?>'

                }
            },
            'columnDefs': [
                {
                    'targets': [],
                    'orderable': false,
                },

            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    messageTop: "<div style='text-align: center'><img src='" + url + "' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',
                    title: '<h3 style="text-align: center">Sözleşme Hesap Özeti</h3>',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 4, 5, 6, 7]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                  var floatVal = function (i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/[^0-9,-]+/g, '').replace(',', '.')) || 0 :
                        typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(7)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(7).footer()).html(tatals);
                $(api.column(6).footer()).html(tatals2);
                $(api.column(8).footer()).html(bakiyes + ' ' + string);

            }
        });


    }

    function extre_table_filter_soz(tableName, colArray) {

        setTimeout(function () {
            $.each(colArray, function (i, arg) {
                $('.' + tableName + ' thead th:eq(' + arg + ')').append('<img src="/filters.png" class="filterIcon" onclick="showFiltersoz(event,\'' + tableName + '_' + arg + '\')" />');
            });

            var template = '<div class="modalFiltersoz">' +
                '<div class="modal-content">' +
                '{0}</div>' +
                '<div class="modal-footer">' +
                '<a href="#!" onclick="clearFiltersoz(this, {1}, \'{2}\');"  class=" btn btn-warning btn-sm">Temizle</a>' +
                '<a href="#!" onclick="performFiltersoz(this, {1}, \'{2}\');"  class=" btn btn-info btn-sm">Filtrele</a>' +
                '</div>' +
                '</div>';
            $.each(colArray, function (index, value) {
                tables.columns().every(function (i) {
                    if (value === i) {
                        var column = this,
                            content = '<input type="text" class="filterSearchText" onkeyup="filterValuessoz(this)" /> <br/>';
                        var columnName = $(this.header()).text().replace(/\s+/g, "_");
                        var distinctArray = [];
                        column.data().each(function (d, j) {
                            if (distinctArray.indexOf(d) == -1) {
                                var id = tableName + "_" + columnName + "_" + j; // onchange="formatValues(this,' + value + ');
                                content += '<div><input class="" type="checkbox" value="' + d + '"  id="' + id + '"/><label for="' + id + '"> ' + d + '</label></div>';
                                distinctArray.push(d);
                            }
                        });
                        var newTemplate = $(template.replace('{0}', content).replace('{1}', value).replace('{1}', value).replace('{2}', tableName).replace('{2}', tableName));
                        $('body').append(newTemplate);
                        modalFilterArray_soz[tableName + "_" + value] = newTemplate;
                        content = '';
                    }
                });
            });

        }, 2000);
    }


    function draw_data_forma2(proje_id = 0) {


        tables_forma2 = $('#extres_cust_forma2').DataTable({
            'processing': true,
            "ordering": false,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style', data[7]);
            },
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/ekstre_forma2')?>",
                'type': 'POST',
                'dataType': 'json',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    'para_birimi': $('#para_birimi').val(),
                    'kdv_tipi': 0,
                    'cid':<?php echo @$_GET['id'] ?>,
                    'proje_id': proje_id,
                    'tyd': '<?php echo @$_GET['t'] ?>',
                    'kdv_durum': '<?php echo @$_GET['kdv_durum'] ?>',
                    'tahvil_durum': '<?php echo @$_GET['tahvil_durum'] ?>'

                }
            },
            'columnDefs': [
                {
                    'targets': [0, 1, 2],
                    'orderable': false,
                },
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    messageTop: "<div style='text-align: center'><img src='" + url + "' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',
                    title: '<h3 style="text-align: center">Forma2 Hesap Özeti</h3>',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 4, 5, 6, 7]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                  var floatVal = function (i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/[^0-9,-]+/g, '').replace(',', '.')) || 0 :
                        typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(7)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(7).footer()).html(tatals);
                $(api.column(6).footer()).html(tatals2);
                $(api.column(8).footer()).html(bakiyes + ' ' + string);

            }
        });


    }

    function extre_table_filter_forma2(tableName, colArray) {

        setTimeout(function () {
            $.each(colArray, function (i, arg) {
                $('.' + tableName + ' thead th:eq(' + arg + ')').append('<img src="/filters.png" class="filterIcon" onclick="showFilterforma2(event,\'' + tableName + '_' + arg + '\')" />');
            });

            var template = '<div class="modalFilterforma2">' +
                '<div class="modal-content">' +
                '{0}</div>' +
                '<div class="modal-footer">' +
                '<a href="#!" onclick="clearFilterforma2(this, {1}, \'{2}\');"  class=" btn btn-warning btn-sm">Temizle</a>' +
                '<a href="#!" onclick="performFilterforma2(this, {1}, \'{2}\');"  class=" btn btn-info btn-sm">Filtrele</a>' +
                '</div>' +
                '</div>';
            $.each(colArray, function (index, value) {
                tables_forma2.columns().every(function (i) {
                    if (value === i) {
                        var column = this,
                            content = '<input type="text" class="filterSearchText" onkeyup="filterValuesforma2(this)" /> <br/>';
                        var columnName = $(this.header()).text().replace(/\s+/g, "_");
                        var distinctArray = [];
                        column.data().each(function (d, j) {
                            if (distinctArray.indexOf(d) == -1) {
                                var id = tableName + "_" + columnName + "_" + j; // onchange="formatValues(this,' + value + ');
                                content += '<div><input class="" type="checkbox" value="' + d + '"  id="' + id + '"/><label for="' + id + '"> ' + d + '</label></div>';
                                distinctArray.push(d);
                            }
                        });
                        var newTemplate = $(template.replace('{0}', content).replace('{1}', value).replace('{1}', value).replace('{2}', tableName).replace('{2}', tableName));
                        $('body').append(newTemplate);
                        modalFilterArray_forma2[tableName + "_" + value] = newTemplate;
                        content = '';
                    }
                });
            });

        }, 2000);
    }


    function draw_data_avans(proje_id = 0) {


        tablesf = $('#extres_cust_avans').DataTable({
            'processing': true,
            'serverSide': true,
            "ordering": false,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style', data[7]);
            },
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/ekstre_avans')?>",
                'type': 'POST',
                'dataType': 'json',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    'para_birimi': $('#para_birimi').val(),
                    'kdv_tipi': 0,
                    'cid':<?php echo @$_GET['id'] ?>,
                    'proje_id': proje_id,
                    'tyd': '<?php echo @$_GET['t'] ?>',
                    'kdv_durum': '<?php echo @$_GET['kdv_durum'] ?>',
                    'tahvil_durum': '<?php echo @$_GET['tahvil_durum'] ?>'

                }
            },
            'columnDefs': [
                {
                    'targets': [0, 1, 2],
                    'orderable': false,
                },
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    messageTop: "<div style='text-align: center'><img src='" + url + "' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',
                    title: '<h3 style="text-align: center">Avans Hesap Özeti</h3>',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 4, 5, 6, 7]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                  var floatVal = function (i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/[^0-9,-]+/g, '').replace(',', '.')) || 0 :
                        typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(7)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);

                total2 = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                // Update footer

                var bakiye = floatVal(total2) - floatVal(total);
                var string = '';
                if (floatVal(total2) > floatVal(total)) {

                    string = '(B)';
                } else {
                    string = '(A)'
                }

                var tatals = currencyFormat(floatVal(total));
                var tatals2 = currencyFormat(floatVal(total2));
                var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                $(api.column(7).footer()).html(tatals);
                $(api.column(6).footer()).html(tatals2);
                $(api.column(8).footer()).html(bakiyes + ' ' + string);

            }
        });


    }

    function extre_table_filter_avans(tableName, colArray) {

        setTimeout(function () {
            $.each(colArray, function (i, arg) {
                $('.' + tableName + ' thead th:eq(' + arg + ')').append('<img src="/filters.png" class="filterIcon" onclick="showFilteravans(event,\'' + tableName + '_' + arg + '\')" />');
            });

            var template = '<div class="modalFilteravans">' +
                '<div class="modal-content">' +
                '{0}</div>' +
                '<div class="modal-footer">' +
                '<a href="#!" onclick="clearFilteravans(this, {1}, \'{2}\');"  class=" btn btn-warning btn-sm">Temizle</a>' +
                '<a href="#!" onclick="performFilteravans(this, {1}, \'{2}\');"  class=" btn btn-info btn-sm">Filtrele</a>' +
                '</div>' +
                '</div>';
            $.each(colArray, function (index, value) {
                tablesf.columns().every(function (i) {
                    if (value === i) {
                        var column = this,
                            content = '<input type="text" class="filterSearchText" onkeyup="filterValuesavans(this)" /> <br/>';
                        var columnName = $(this.header()).text().replace(/\s+/g, "_");
                        var distinctArray = [];
                        column.data().each(function (d, j) {
                            if (distinctArray.indexOf(d) == -1) {
                                var id = tableName + "_" + columnName + "_" + j; // onchange="formatValues(this,' + value + ');
                                content += '<div><input class="" type="checkbox" value="' + d + '"  id="' + id + '"/><label for="' + id + '"> ' + d + '</label></div>';
                                distinctArray.push(d);
                            }
                        });
                        var newTemplate = $(template.replace('{0}', content).replace('{1}', value).replace('{1}', value).replace('{2}', tableName).replace('{2}', tableName));
                        $('body').append(newTemplate);
                        modalFilterArray_avans[tableName + "_" + value] = newTemplate;
                        content = '';
                    }
                });
            });

        }, 2000);
    }


    function draw_data_odeme_bekleyen(proje_id = 0) {


        tablebo = $('#extres_cust_odeme_bekleyen').DataTable({
            'processing': true,
            'serverSide': true,
            "ordering": false,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'createdRow': function (row, data, dataIndex) {

                $(row).attr('style', data[7]);
            },
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/ekstre_bekleyen_odeme')?>",
                'type': 'POST',
                'dataType': 'json',
                'data': {
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash,
                    'para_birimi': $('#para_birimi').val(),
                    'kdv_tipi': 0,
                    'cid':<?php echo @$_GET['id'] ?>,
                    'proje_id': proje_id,
                    'tyd': '<?php echo @$_GET['t'] ?>',
                    'kdv_durum': '<?php echo @$_GET['kdv_durum'] ?>',
                    'tahvil_durum': '<?php echo @$_GET['tahvil_durum'] ?>'

                }
            },
            'columnDefs': [
                {
                    'targets': [0, 1, 2],
                    'orderable': false,
                },
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    messageTop: "<div style='text-align: center'><img src='" + url + "' style='max-height:180px;max-width:90px;'>",
                    messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                        "+994 12 597 48 18<br/>" +
                        "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                    extend: 'print',
                    title: '<h3 style="text-align: center">Onaylanmış Bekleyen Ödemeler</h3>',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 3, 4, 5]
                    }
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                  var floatVal = function (i) {
                    return typeof i === 'string' ?
                        parseFloat(i.replace(/[^0-9,-]+/g, '').replace(',', '.')) || 0 :
                        typeof i === 'number' ? i : 0;
                };

                // Total over all pages
                total = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return floatVal(a) + floatVal(b);
                    }, 0);


                var tatals = currencyFormat(floatVal(total));


                $(api.column(5).footer()).html(tatals);


            }
        });


    }

    function extre_table_filter_odeme_bekleyen(tableName, colArray) {

        setTimeout(function () {
            $.each(colArray, function (i, arg) {
                $('.' + tableName + ' thead th:eq(' + arg + ')').append('<img src="/filters.png" class="filterIcon" onclick="showFilterodeme(event,\'' + tableName + '_' + arg + '\')" />');
            });

            var template = '<div class="modalFilteravans">' +
                '<div class="modal-content">' +
                '{0}</div>' +
                '<div class="modal-footer">' +
                '<a href="#!" onclick="clearFilterodeme(this, {1}, \'{2}\');"  class=" btn btn-warning btn-sm">Temizle</a>' +
                '<a href="#!" onclick="performFilterodeme(this, {1}, \'{2}\');"  class=" btn btn-info btn-sm">Filtrele</a>' +
                '</div>' +
                '</div>';
            $.each(colArray, function (index, value) {
                tablebo.columns().every(function (i) {
                    if (value === i) {
                        var column = this,
                            content = '<input type="text" class="filterSearchText" onkeyup="filterValueOdeme(this)" /> <br/>';
                        var columnName = $(this.header()).text().replace(/\s+/g, "_");
                        var distinctArray = [];
                        column.data().each(function (d, j) {
                            if (distinctArray.indexOf(d) == -1) {
                                var id = tableName + "_" + columnName + "_" + j; // onchange="formatValues(this,' + value + ');
                                content += '<div><input class="" type="checkbox" value="' + d + '"  id="' + id + '"/><label for="' + id + '"> ' + d + '</label></div>';
                                distinctArray.push(d);
                            }
                        });
                        var newTemplate = $(template.replace('{0}', content).replace('{1}', value).replace('{1}', value).replace('{2}', tableName).replace('{2}', tableName));
                        $('body').append(newTemplate);
                        modalFilterArray_odeme[tableName + "_" + value] = newTemplate;
                        content = '';
                    }
                });
            });

        }, 2000);
    }


    $(document).on('change', "#islem_tipi", function (e) {

        $("#islem_listesi option").remove();
        var islem_tipi = $('#islem_tipi option:selected').val();
        var alt_customer_id = $('#alt_customer_id option:selected').val();
        var alacakak_borc = $('#alacakak_borc option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/islem_listesi_getir',
            data:
                'islem_tipi=' + islem_tipi +
                '&alt_customer_id=' + alt_customer_id +
                '&alacakak_borc=' + alacakak_borc +
                '&' + crsf_token + '=' + crsf_hash,
            success: function (data) {
                if (data) {

                    $('#islem_listesi').append($('<option>').val(0).text('İşlemi Seçiniz'));

                    jQuery.each(jQuery.parseJSON(data), function (key, item) {
                        $("#islem_listesi").append('<option kalan="' + item.tutar_o + '" value="' + item.id + '">' + item.tutar + '-' + item.note + '</option>');
                    });
                    //$('#pay_type').append($('<option>').val(3).text('Tahsilat'));
                }

            }
        });


    });

    $("#oran").keyup(function () {

        var oran = $("#oran").val();
        var alacak_tutar = $("#alacak_tutar").val();
        var hesaplama = (alacak_tutar * oran) / 100;
        $("#hesaplanan_tutar").val(hesaplama.toFixed(2));

    });


    $(document).on('click', "#submit_model_alacak", function (e) {
        e.preventDefault();
        var o_data = $("#form_model_alacak").serialize();
        var action_url = $('#form_model_alacak #action-url-alacak').val();
        $("#pop_model_alacaklandirma").modal('hide');
        saveMDataHak(o_data, action_url);
    });

    $(document).on('click', "#submit_model_alacak_", function (e) {
        e.preventDefault();
        var o_data = $("#form_model_alacak_").serialize();
        var action_url = $('#form_model_alacak_ #url_alacak').val();
        $("#pop_model_alacaklandirma_musteri").modal('hide');
        saveMDataHak(o_data, action_url);
    });
    $(document).on('click', "#submit_model_controller", function (e) {
        e.preventDefault();
        var o_data = $("#form_model_controller").serialize();
        var action_url = $('#form_model_controller #url_controller').val();
        $("#pop_model_kontrol").modal('hide');
        saveMDataHak(o_data, action_url);
    });


    function saveMDataHak(o_data, action_url) {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
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


    function filterValues(node) {
        var searchString = $(node).val().toUpperCase().trim();
        var rootNode = $(node).parent();
        if (searchString == '') {
            rootNode.find('div').show();
        } else {
            rootNode.find("div").hide();
            rootNode.find("div:contains('" + searchString + "')").show();
        }
    }

    function showFilter(e, index) {
        $('.modalFilter').hide();
        $(modalFilterArray[index]).css({left: 0, top: 0});
        var th = $(e.target).parent();
        var pos = th.offset();
        console.log(th);
        $(modalFilterArray[index]).width(th.width() * 0.75);
        $(modalFilterArray[index]).css({'left': pos.left, 'top': pos.top});
        $(modalFilterArray[index]).show();
        $('#mask').show();
        e.stopPropagation();
    }

    function performFilter(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        var searchString = '', counter = 0;

        rootNode.find('input:checkbox').each(function (index, checkbox) {
            if (checkbox.checked) {
                searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                counter++;
            }
        });
        $('#' + tableId).DataTable().column(i).search(
            searchString,
            true, false
        ).draw();
        rootNode.hide();
        $('#mask').hide();

    }

    function clearFilter(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        rootNode.find(".filterSearchText").val('');
        rootNode.find('input:checkbox').each(function (index, checkbox) {
            checkbox.checked = false;
            $(checkbox).parent().show();
        });
        $('#' + tableId).DataTable().column(i).search(
            '',
            true, false
        ).draw();
        rootNode.hide();
        $('#mask').hide();
    }


    function filterValuessoz(node) {
        var searchString = $(node).val().toUpperCase().trim();
        var rootNode = $(node).parent();
        if (searchString == '') {
            rootNode.find('div').show();
        } else {
            rootNode.find("div").hide();
            rootNode.find("div:contains('" + searchString + "')").show();
        }
    }

    function performFiltersoz(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        var searchString = '', counter = 0;

        rootNode.find('input:checkbox').each(function (index, checkbox) {
            if (checkbox.checked) {
                searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                counter++;
            }
        });
        $('#' + tableId).DataTable().column(i).search(
            searchString,
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_soz').hide();

    }

    function showFiltersoz(e, index) {
        $('.modalFiltersoz').hide();
        $(modalFilterArray_soz[index]).css({left: 0, top: 0});
        var th = $(e.target).parent();
        var pos = th.offset();
        console.log(th);
        $(modalFilterArray_soz[index]).width(th.width() * 0.75);
        $(modalFilterArray_soz[index]).css({'left': pos.left, 'top': pos.top});
        $(modalFilterArray_soz[index]).show();
        $('#mask_soz').show();
        e.stopPropagation();
    }

    function clearFiltersoz(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        rootNode.find(".filterSearchText").val('');
        rootNode.find('input:checkbox').each(function (index, checkbox) {
            checkbox.checked = false;
            $(checkbox).parent().show();
        });
        $('#' + tableId).DataTable().column(i).search(
            '',
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_soz').hide();
    }


    function filterValuesforma2(node) {
        var searchString = $(node).val().toUpperCase().trim();
        var rootNode = $(node).parent();
        if (searchString == '') {
            rootNode.find('div').show();
        } else {
            rootNode.find("div").hide();
            rootNode.find("div:contains('" + searchString + "')").show();
        }
    }

    function performFilterforma2(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        var searchString = '', counter = 0;

        rootNode.find('input:checkbox').each(function (index, checkbox) {
            if (checkbox.checked) {
                searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                counter++;
            }
        });
        $('#' + tableId).DataTable().column(i).search(
            searchString,
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_soz').hide();

    }

    function showFilterforma2(e, index) {
        $('.modalFilterforma2').hide();
        $(modalFilterArray_forma2[index]).css({left: 0, top: 0});
        var th = $(e.target).parent();
        var pos = th.offset();
        console.log(th);
        $(modalFilterArray_forma2[index]).width(th.width() * 0.75);
        $(modalFilterArray_forma2[index]).css({'left': pos.left, 'top': pos.top});
        $(modalFilterArray_forma2[index]).show();
        $('#mask_forma2').show();
        e.stopPropagation();
    }

    function clearFilterforma2(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        rootNode.find(".filterSearchText").val('');
        rootNode.find('input:checkbox').each(function (index, checkbox) {
            checkbox.checked = false;
            $(checkbox).parent().show();
        });
        $('#' + tableId).DataTable().column(i).search(
            '',
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_forma2').hide();
    }


    function filterValuesavans(node) {
        var searchString = $(node).val().toUpperCase().trim();
        var rootNode = $(node).parent();
        if (searchString == '') {
            rootNode.find('div').show();
        } else {
            rootNode.find("div").hide();
            rootNode.find("div:contains('" + searchString + "')").show();
        }
    }

    function filterValueodeme(node) {
        var searchString = $(node).val().toUpperCase().trim();
        var rootNode = $(node).parent();
        if (searchString == '') {
            rootNode.find('div').show();
        } else {
            rootNode.find("div").hide();
            rootNode.find("div:contains('" + searchString + "')").show();
        }
    }

    function performFilteravans(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        var searchString = '', counter = 0;

        rootNode.find('input:checkbox').each(function (index, checkbox) {
            if (checkbox.checked) {
                searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                counter++;
            }
        });
        $('#' + tableId).DataTable().column(i).search(
            searchString,
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_avans').hide();

    }

    function performFilterodeme(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        var searchString = '', counter = 0;

        rootNode.find('input:checkbox').each(function (index, checkbox) {
            if (checkbox.checked) {
                searchString += (counter == 0) ? checkbox.value : '|' + checkbox.value;
                counter++;
            }
        });
        $('#' + tableId).DataTable().column(i).search(
            searchString,
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_odeme').hide();

    }

    function showFilteravans(e, index) {
        $('.modalFilteravans').hide();
        $(modalFilterArray_avans[index]).css({left: 0, top: 0});
        var th = $(e.target).parent();
        var pos = th.offset();
        console.log(th);
        $(modalFilterArray_avans[index]).width(th.width() * 0.75);
        $(modalFilterArray_avans[index]).css({'left': pos.left, 'top': pos.top});
        $(modalFilterArray_avans[index]).show();
        $('#mask_avans').show();
        e.stopPropagation();
    }

    function showFilterodeme(e, index) {
        $('.modalFilterodeme').hide();
        $(modalFilterArray_odeme[index]).css({left: 0, top: 0});
        var th = $(e.target).parent();
        var pos = th.offset();
        console.log(th);
        $(modalFilterArray_odeme[index]).width(th.width() * 0.75);
        $(modalFilterArray_odeme[index]).css({'left': pos.left, 'top': pos.top});
        $(modalFilterArray_odeme[index]).show();
        $('#mask_odeme').show();
        e.stopPropagation();
    }

    function clearFilteravans(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        rootNode.find(".filterSearchText").val('');
        rootNode.find('input:checkbox').each(function (index, checkbox) {
            checkbox.checked = false;
            $(checkbox).parent().show();
        });
        $('#' + tableId).DataTable().column(i).search(
            '',
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_avans').hide();
    }

    function clearFilterodeme(node, i, tableId) {
        var rootNode = $(node).parent().parent();
        rootNode.find(".filterSearchText").val('');
        rootNode.find('input:checkbox').each(function (index, checkbox) {
            checkbox.checked = false;
            $(checkbox).parent().show();
        });
        $('#' + tableId).DataTable().column(i).search(
            '',
            true, false
        ).draw();
        rootNode.hide();
        $('#mask_odeme').hide();
    }

    function draw_data_belgeler(start_date = '', end_date = '') {
        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('customers/document_load_list')?>",
                "type": "POST",
                'data': {
                    start_date: start_date,
                    end_date: end_date,
                    'cid': <?=$_GET['id'] ?>,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                }
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },

            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    text: '<i class="fa fa-file"></i> Yeni Belge Ekle',
                    action: function (e, dt, node, config) {
                        $.confirm({
                            theme: 'modern',
                            closeIcon: true,
                            title: 'Yeni Belge Ekle',
                            icon: 'fa fa-plus',
                            type: 'dark',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "col-md-6 mx-auto",
                            containerFluid: !0,
                            smoothContent: true,
                            draggable: false,
                            content: `<form id="document_form">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Belge Adı</label>
                    <input type="text" class="form-control required" id="name" placeholder="Açık Pickup">
                </div>
                <div class="form-group col-md-6">
                    <label for="firma_id">Belge Tipi Adı</label>
                    <select class="form-control select-box required" id="file_type_id">
                        <option value="0">Seçiniz</option>
                        <?php foreach (customer_file_type() as $emp) {
                                echo "<option value='{$emp->id}'>{$emp->name}</option>";
                            } ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="baslangic_date">Başlangıç Tarihi</label>
                    <input type="date" class="form-control required" id="baslangic_date">
                </div>
                <div class="form-group col-md-3">
                    <label for="bitis_date">Bitiş Tarihi</label>
                    <input type="date" class="form-control required" id="bitis_date">
                </div>
                <div class="form-group col-md-6">
                    <label for="proje_id">Proje</label>
                    <select class="form-control select-box required" id="proje_id">
                        <option value="0">Seçiniz</option>
                        <?php foreach (all_projects() as $emp) {
                                echo "<option value='{$emp->id}'>{$emp->code}</option>";
                            } ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="resim">Dosya</label>
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <table id="files" class="files"></table><br>
                    <span class="btn btn-success fileinput-button" style="width: 100%">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Seçiniz...</span>
                        <input id="fileupload_" type="file" name="files[]">
                        <input type="hidden" class="image_text required" name="image_text" id="image_text">
                    </span>
                </div>
            </div>
        </form>`,
                            buttons: {
                                formSubmit: {
                                    text: 'Ekle',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        let valid = true;

                                        // Tüm alanları kontrol et
                                        $('#document_form .required').each(function () {
                                            if (!$(this).val() || $(this).val() === "0") {
                                                $(this).addClass('is-invalid');
                                                valid = false;
                                            } else {
                                                $(this).removeClass('is-invalid');
                                            }
                                        });

                                        if (!valid) {
                                            $.alert({
                                                theme: 'modern',
                                                icon: 'fa fa-exclamation',
                                                type: 'red',
                                                title: 'Hata',
                                                content: 'Lütfen tüm alanları doldurun!',
                                            });
                                            return false;
                                        }

                                        $('#loading-box').removeClass('d-none');

                                        let data = {
                                            crsf_token: crsf_hash,
                                            bitis_date: $('#bitis_date').val(),
                                            baslangic_date: $('#baslangic_date').val(),
                                            file_type_id: $('#file_type_id').val(),
                                            name: $('#name').val(),
                                            proje_id: $('#proje_id').val(),
                                            cari_id: "<?php echo $_GET['id'];?>",
                                            image_text: $('#image_text').val(),
                                        };

                                        $.post(baseurl + 'customers/add_document', data, (response) => {
                                            let responses = jQuery.parseJSON(response);
                                            $('#loading-box').addClass('d-none');
                                            if (responses.status === 'Success') {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-check',
                                                    type: 'green',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "small",
                                                    title: 'Başarılı',
                                                    content: responses.message,
                                                    buttons: {
                                                        formSubmit: {
                                                            text: 'Tamam',
                                                            btnClass: 'btn-blue',
                                                            action: function () {
                                                                $('#doctable').DataTable().destroy();
                                                                draw_data_belgeler();
                                                            }
                                                        }
                                                    }
                                                });
                                            } else if (responses.status === 'Error') {
                                                $.alert({
                                                    theme: 'modern',
                                                    icon: 'fa fa-exclamation',
                                                    type: 'red',
                                                    animation: 'scale',
                                                    useBootstrap: true,
                                                    columnClass: "col-md-4 mx-auto",
                                                    title: 'Dikkat!',
                                                    content: responses.message,
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
                            },
                            onContentReady: function () {
                                $('.select-box').select2({
                                    dropdownParent: $(".jconfirm-box-container")
                                });

                                $('#fileupload_').fileupload({
                                    url: '<?php echo base_url() ?>customers/file_handling',
                                    dataType: 'json',
                                    formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                    done: function (e, data) {
                                        let img = 'default.png';
                                        $.each(data.result.files, function (index, file) {
                                            img = file.name;
                                        });
                                        $('#image_text').val(img);
                                    },
                                    progressall: function (e, data) {
                                        const progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#progress .progress-bar').css('width', progress + '%');
                                    }
                                }).prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');

                                var jc = this;
                                this.$content.find('form').on('submit', function (e) {
                                    e.preventDefault();
                                    jc.$$formSubmit.trigger('click');
                                });
                            }
                        });
                    }

                }
            ]

        });
    }

    $(document).on('click', ".talep_sil", function () {
        let edit_id = $(this).attr('talep_id');

        if (!edit_id) {
            $.alert({
                theme: 'modern',
                icon: 'fa fa-exclamation',
                type: 'red',
                title: 'Hata',
                content: 'Geçerli bir talep ID bulunamadı!',
            });
            return;
        }

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-exclamation',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
            <form class="formName">
                <div class="form-group">
                    <p>Dosyayı silmek üzeresiniz. Emin misiniz?</p>
                </div>
            </form>`,
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            edit_id: edit_id,
                        };

                        $.post(baseurl + 'customers/remove_document', data, function (response) {
                            $('#loading-box').addClass('d-none');

                            try {
                                let responses = JSON.parse(response);

                                if (responses.status === 'Success') {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons: {
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    $('#doctable').DataTable().destroy();
                                                    draw_data_belgeler();
                                                }
                                            }
                                        }
                                    });
                                } else {
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: responses.message || 'Silme işlemi sırasında bir hata oluştu.',
                                        buttons: {
                                            prev: {
                                                text: 'Tamam',
                                                btnClass: "btn btn-link text-dark",
                                            }
                                        }
                                    });
                                }
                            } catch (e) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    title: 'Hata',
                                    content: 'Sunucudan geçersiz bir yanıt alındı.',
                                });
                            }
                        }).fail(function () {
                            $('#loading-box').addClass('d-none');
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                title: 'Hata',
                                content: 'Sunucuya erişim sağlanamadı. Lütfen tekrar deneyin.',
                            });
                        });

                        return false;
                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: "btn btn-warning btn-sm",
                }
            },
            onContentReady: function () {
                let jc = this;
                this.$content.find('form').on('submit', function (e) {
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click');
                });
            }
        });
    });


    $(document).on('click', '.edit', function () {
        let edit_id = $(this).attr('talep_id');

        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Belge Düzenle',
            icon: 'fa fa-edit',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-6 mx-auto",
            containerFluid: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = `
                <form id="editDocumentForm">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name_update">Belge Adı</label>
                            <input type="text" class="form-control required" id="name_update" placeholder="Belge Adı">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="file_type_id">Belge Tipi Adı</label>
                            <select class="form-control select-box required" id="file_type_id">
                                <option value="0">Seçiniz</option>
                                <?php foreach (customer_file_type() as $emp): ?>
                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="baslangic_date">Başlangıç Tarihi</label>
                            <input type="date" class="form-control required" id="baslangic_date">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bitis_date">Bitiş Tarihi</label>
                            <input type="date" class="form-control required" id="bitis_date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="proje_id">Proje</label>
                            <select class="form-control select-box required" id="proje_id">
                                <option value="0">Seçiniz</option>
                                <?php foreach (all_projects() as $emp): ?>
                                    <option value="<?php echo $emp->id; ?>"><?php echo $emp->code; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="resim">Dosya</label>
                            <div>
                                <img class="myImg update_image" style="width: 100%; max-width: 300px;">
                            </div>
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <table id="files" class="files"></table>
                            <br>
                            <span class="btn btn-success fileinput-button" style="width: 100%">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Seçiniz...</span>
                                <input id="fileupload_" type="file" name="files[]">
                                <input type="hidden" class="image_text required" name="image_text" id="image_text">
                            </span>
                        </div>
                    </div>
                </form>`;

                let data = { crsf_token: crsf_hash, edit_id: edit_id };

                $.post(baseurl + 'customers/document_get_info', data, (response) => {
                    let responses = jQuery.parseJSON(response);
                    $('#name_update').val(responses.items.title);
                    $('#baslangic_date').val(responses.items.baslangic_date);
                    $('#bitis_date').val(responses.items.bitis_date);
                    $('#proje_id').val(responses.items.proje_id).select2().trigger('change');
                    $('#file_type_id').val(responses.items.file_type_id).select2().trigger('change');
                    $('#image_text').val(responses.items.filename);
                    $('.update_image').attr('src', baseurl + "userfiles/documents/" + responses.items.filename);
                });

                return html;
            },
            buttons: {
                formSubmit: {
                    text: 'Güncelle',
                    btnClass: 'btn-blue',
                    action: function () {
                        let valid = true;

                        // Tüm gerekli alanların dolu olup olmadığını kontrol et
                        $('#editDocumentForm .required').each(function () {
                            if (!$(this).val() || $(this).val() === '0') {
                                $(this).addClass('is-invalid');
                                valid = false;
                            } else {
                                $(this).removeClass('is-invalid');
                            }
                        });

                        if (!valid) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                title: 'Hata',
                                content: 'Lütfen tüm alanları doldurun!',
                            });
                            return false;
                        }

                        $('#loading-box').removeClass('d-none');

                        let data = {
                            crsf_token: crsf_hash,
                            edit_id: edit_id,
                            name: $('#name_update').val(),
                            baslangic_date: $('#baslangic_date').val(),
                            bitis_date: $('#bitis_date').val(),
                            proje_id: $('#proje_id').val(),
                            cari_id: "<?php echo $_GET['id'];?>",
                            file_type_id: $('#file_type_id').val(),
                            image_text: $('#image_text').val(),
                        };

                        $.post(baseurl + 'customers/update_document', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status == 'Success') {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#doctable').DataTable().destroy();
                                                draw_data_belgeler();
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    title: 'Hata',
                                    content: responses.message,
                                });
                            }
                        });
                    }
                }
            },
            onContentReady: function () {
                $('.select-box').select2({ dropdownParent: $(".jconfirm-box-container") });

                $('#fileupload_').fileupload({
                    url: '<?php echo base_url() ?>customers/file_handling',
                    dataType: 'json',
                    formData: { '<?=$this->security->get_csrf_token_name()?>': crsf_hash },
                    done: function (e, data) {
                        let img = 'default.png';
                        $.each(data.result.files, function (index, file) {
                            img = file.name;
                        });
                        $('#image_text').val(img);
                    },
                    progressall: function (e, data) {
                        let progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css('width', progress + '%');
                    }
                });
            }
        });
    });


    $('#search_hesap_ozeti').click(function () {
        var start_date = $('#start_date_hesap_ozeti').val();
        var end_date = $('#end_date_hesap_ozeti').val();
        $('#bas_d').val(start_date);
        $('#bit_d').val(end_date);

        if (start_date != '' && end_date != '') {
            $('#extres_cust').DataTable().destroy();
            draw_data(start_date, end_date);


        } else {
            alert("Date range is Required");
        }


        $('#loading-box').removeClass('d-none');

        setTimeout(function () {

            var test = $("#extres_cust tfoot tr th").eq(8).text();
            var res = test.split("AZN");
            string_bakiye = test;
            if (bakiye_ba == ' (B)') {
                text = ` -de ` + string_bakiye + ` borcu var.`;
            } else {
                text = ` -ə ` + string_bakiye + ` alacağı (avansı(artıq ödəməsi) var.`;
            }
            $('#loading-box').addClass('d-none');
        }, 1000);


    });

    $(document).on('click','.parcali',function (){
        let pay_id =  $(this).attr('avans_id');

        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'İşlem Görüntüleme',
            icon: 'fa fa-eye',
            type: 'green',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: function () {
                let self = this;
                let html = ''; // Yönlendirilmiş ve Tek Yapılan randevu 1,3
                let responses;

                html+='<form action="" class="formName">' +
                    '<div class="form-group islem_ozeti">' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                    pay_id: pay_id,
                }

                $.post(baseurl + 'formainvoices/islem_details_avans',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });

                    let text='';
                    let responses = jQuery.parseJSON(response);
                    if(responses.status==200){
                        text =`<table class="table">
                                    <thead>
                                        <tr>
                                        <th>İşlem Tarihi</th>
                                        <th>İşlem Tutarı</th>
                                        <th>Ödeme Detayları</th>
                                        <th>Avans Detayları</th>
                                        </tr>
                                    </thead>
<tbody>
<tr>
<td>`+responses.details.invoicedate+`</td>
<td>`+currencyFormat(floatVal(responses.details.total))+`</td>
<td><a href='/transactions/view?id=`+responses.details.id+`'  class='btn btn-success' target="_blank">Ödemeyi Görüntüle</a></td>
<td><a href='/customeravanstalep/view/`+pay_id+`'  class='btn btn-success' target="_blank">Avans Görüntüle</a></td>
<input type="hidden"  class="form-control transaction_id" value="`+responses.details.id+`">
<input type="hidden"  class="form-control avans_id" value="`+responses.details.term+`">
<input type="hidden"  class="form-control method" value="`+responses.details.method+`">
</td>
</tbody>
                                </table>`;

                        if(responses.islme_durum){
                            text +=`<table class="table">
                                    <thead>
                                        <tr>
                                        <th>İşlem Tarihi</th>
                                        <th>İşlem Detayları</th>
                                        <th>İşlem Tutarı</th>
                                        <th>Bağlı Olduğu Forma 2</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            $.each(responses.islem_details, function (index, items) {
                                text+=`<tr>
                                        <td>`+items.created_at+`</td>
                                        <td>`+items.desc+`</td>
                                        <td>`+currencyFormat(floatVal(items.amount))+`</td>
                                        <td>`+items.invoice_no+`</td>
                                       </tr>`;
                            });
                            text+=`</tbody>
                                </table>`;
                        }
                    }
                    $('.islem_ozeti').empty().html(text);

                });

                return $('#person-container').html();
            },
            onContentReady:function (){

            },
            buttons: {

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
    })


    function currencyFormat(num) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' AZN';
    }

    var floatVal = function (i) {
        return typeof i === 'string' ?
            parseFloat(i.replace(/[^0-9,-]+/g, '').replace(',', '.')) || 0 :
            typeof i === 'number' ? i : 0;
    };

    function amount_max(obj){

        let max = $(obj).attr('max');
        if(parseFloat($(obj).val())>parseFloat(max)){
            $(obj).val(parseFloat(max))
            return false;
        }
    }
</script>
