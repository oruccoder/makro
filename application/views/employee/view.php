<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold"><?php echo $this->lang->line('Employee Details') ?></span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <div class="row">
                    <div class="col-md-3 border-right">

                        <?php if(isset($employee['picture']))
                        {
                            ?>
                            <div style="border-radius: 100%;overflow: hidden;background: linear-gradient(#00000000,#676767);position: relative;width: 100%;">
                                <img alt="image" class="img-responsive col"
                                     src="<?php echo base_url('userfiles/employee/' . pesonel_picture_url($employee['id'])); ?>">
                            </div>

                            <?php
                        } ?>


                        <hr>
                        <div class="options">
                            <a href="#pop_model" data-toggle="modal" data-remote="false"
                               class="btn btn-purple btn-block"><i
                                        class="icon-eye"></i> <?php echo $this->lang->line('maas_prim') ?>
                            </a>
                        </div>
                        <br>
                        <div class="options">
                            <a href="<?php echo base_url('employee/update?id=' . $eid) ?>"
                               class="btn btn-purple btn-block"><i
                                        class="icon-pencil"></i> <?php echo $this->lang->line('edit') ?>
                            </a>
                        </div>
                        <br/>
                        <div class="options">
                            <a target="_blank" href="<?php echo base_url('employee/ise_alim_print?id=' . $eid) ?>"
                               class="btn btn-purple btn-block"><i
                                        class="fa fa-print"></i> <?php echo $this->lang->line('ise_alim_form_print') ?>
                            </a>
                        </div>
                        <br/>
                        <?php if($employee['ayrilma_sebebi']!=''){ ?>
                            <div class="options">
                                <a target="_blank" href="<?php echo base_url('employee/is_cikis_print?id=' . $eid) ?>"
                                   class="btn btn-purple btn-block"><i
                                            class="fa fa-print"></i> <?php echo $this->lang->line('istene_cikis_form_print') ?>
                                </a>
                            </div>
                        <?php } ?>
                        <hr>

                        <h4><strong><?php echo $employee['name'] ?></strong></h4>
                        <p><i class="icon-map-marker"></i> <?php echo $employee['city'] ?></p>

                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Address') ?>
                                    : </strong><?php echo $employee['address'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('City') ?>
                                    : </strong><?php echo $employee['city'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Region') ?>
                                    : </strong><?php echo $employee['region'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Country') ?>
                                    : </strong><?php echo $employee['country'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('posta_kodu') ?>
                                    : </strong><?php echo $employee['postbox'] ?>
                            </div>

                        </div>
                        <hr>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('ise_baslangic_tarihi') ?></strong> <?php echo dateformat($employee['date_created']); ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('maas') ?></strong> <?php echo amountFormat($employee['salary'])  ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Phone') ?></strong> <?php echo $employee['phone']; ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong>EMail</strong> <?php echo $employee['email']; ?>
                            </div>

                        </div>


                    </div>

                    <div class="col-md-9">
                        <div class="card-content">
                            <div class="card-body">

                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active show" id="base-tab1" data-toggle="tab"
                                           aria-controls="tab1" href="#tab1" role="tab"
                                           aria-selected="true"><?php echo $this->lang->line('pers_odeme') ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab2" data-toggle="tab" aria-controls="tab2"
                                           href="#tab2" role="tab"
                                           aria-selected="false"><?php echo $this->lang->line('pers_izin') ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab3" data-toggle="tab" aria-controls="tab3"
                                           href="#tab3" role="tab"
                                           aria-selected="false">Raporlar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                                           href="#tab4" role="tab"
                                           aria-selected="false"><?php echo $this->lang->line('pers_mesai')?></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab5" data-toggle="tab"
                                           aria-controls="tab5" href="#tab5" role="tab"
                                           aria-selected="true">Razı</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab6" data-toggle="tab"
                                           aria-controls="tab5" href="#tab6" role="tab"
                                           aria-selected="true">İş Avansları</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab7" data-toggle="tab"
                                           aria-controls="tab7" href="#tab7" role="tab"
                                           aria-selected="true">Personel Giderleri</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="base-tab8" data-toggle="tab"
                                           aria-controls="tab8" href="#tab8" role="tab"
                                           aria-selected="true">Personel Hastalık Ve Mezuniyet</a>
                                    </li>




                                </ul>

                                <div class="tab-content px-1 pt-1">
                                    <div role="tabpanel" class="tab-pane active show" id="tab1" aria-labelledby="active-tab" aria-expanded="true">
                                        <h3 style="text-align: center">Personel Ekstresi</h3>
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extres" class="table table-striped table-bordered zero-configuration"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                        <th><?php echo $this->lang->line('payment_type') ?></th>
                                                        <th class="no-sort"><?php echo $this->lang->line('borc') ?></th>
                                                        <th class="no-sort"><?php echo $this->lang->line('alacak') ?></th>
                                                        <th class="no-sort"><?php echo $this->lang->line('bakiye') ?></th>
                                                        <th class="no-sort">Açıklama</th>
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
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                        <h3 style="text-align: center">Personel Borç Ekstresi</h3>
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extre_borclandirma" class="table table-striped table-bordered zero-configuration"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th><?php echo $this->lang->line('transaction_type') ?></th>
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
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="link-tab" aria-expanded="true">

                                        <div class="col-md-12">
                                            <div class="responsive">
                                                <table id="izinler" class=" table table-striped table-bordered zero-configuration" cellspacing="0"
                                                       width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Talep No</th>
                                                        <th>Başlangıç Tarihi</th>
                                                        <th>Bitiş Tarihi</th>
                                                        <th>Bildirim Durumu</th>
                                                        <th>Durum</th>
                                                        <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <h4 class="title">
                                            <a
                                                    href="<?php echo base_url('employee/adddocument?id=' . $_GET['id']) ?>"
                                                    class="btn btn-primary btn-sm rounded">
                                                <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i>
                                            </a>
                                        </h4>
                                        <div class="row">

                                            <div class="col-md-2">Tarih</div>
                                            <div class="col-md-2">
                                                <input type="text" name="start_date" id="start_date"
                                                       class="date30 form-control form-control-sm" autocomplete="off"/>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="end_date" id="end_date" class="form-control form-control-sm"
                                                       data-toggle="datepicker" autocomplete="off"/>
                                            </div>

                                            <div class="col-md-2">
                                                <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>
                                            </div>

                                        </div>
                                        <hr>
                                        <hr>


                                        <table id="doctable" class="table table-striped table-bordered zero-configuration"
                                               cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $this->lang->line('Title') ?></th>
                                                <th>Dosya Tipi</th>
                                                <th>Araç</th>
                                                <th>Belge Başlangıç Tarihi</th>
                                                <th>Bitiş Tarihi</th>
                                                <th><?php echo $this->lang->line('Action') ?></th>


                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false"></div>
                                    <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extre_razi" class="table table-striped table-bordered zero-configuration"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th><?php echo $this->lang->line('transaction_type') ?></th>
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
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab6" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extre_is" class="table table-striped table-bordered zero-configuration"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th><?php echo $this->lang->line('transaction_type') ?></th>
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
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab7" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extre_gider" class="table table-striped table-bordered zero-configuration"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th><?php echo $this->lang->line('transaction_type') ?></th>
                                                        <th><?php echo $this->lang->line('payment_type') ?></th>
                                                        <th class="no-sort">Tutar</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>

                                                    <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
                                                </table>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab8" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false">
                                        <div class="form-group row mt-1">
                                            <div class="col-md-12">

                                                <table id="extre_mezuniyet" class="table table-striped table-bordered zero-configuration"
                                                       cellspacing="0" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th><?php echo $this->lang->line('Date') ?></th>
                                                        <th>Tip</th>
                                                        <th>İşlem</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>

                                                    <tfoot>
                                                    <tr>
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>
                                                        <th class="no-sort"></th>

                                                    </tr>
                                                    </tfoot>
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
                    <input type="hidden" id="action-url" value="employee/delete_document">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Calculate Total Sales') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <?php echo $this->lang->line('Do you want mark') ?>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-sm-3">
                                <label class="col-form-label"
                                       for="name">Gün Sayısı</label>
                                <input type="text" class="form-control" id="gun_sayisi" onkeyup="maas_hesapla()" name="gun_sayisi" placeholder="Hesaplanacak Gün Sayısı" value="30"
                                       autocomplete="false">
                            </div>

                            <div class="col-sm-3">
                                <label class="col-form-label"
                                       for="name">Ay</label>
                                <select class="form-control" name="hesaplanacak_ay" id="hesaplanacak_ay" onchange="maas_gunu_hesapla(this.value)">
                                    <option value="01">Ocak</option>
                                    <option value="02">Şubat</option>
                                    <option value="03">Mart</option>
                                    <option value="04">Nisan</option>
                                    <option value="05">Mayıs</option>
                                    <option value="06">Haziran</option>
                                    <option value="07">Temmuz</option>
                                    <option value="08">Ağustos</option>
                                    <option value="09">Eylül</option>
                                    <option value="10">Ekim</option>
                                    <option value="11">Kasım</option>
                                    <option value="12">Aralık</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label"
                                       for="name">Hakediş</label>
                                <input type="text" class="form-control" id="new_maas"  name="new_maas"  placeholder="Aylık Maaş" value="<?php echo $employee['salary'] ?>">
                                <input type="hidden" class="form-control" id="banka_maas"  name="banka_maas"  value="<?php echo $employee['resmi_maas'] ?>">
                                <input type="hidden" class="form-control" id="nakit_maas"  name="nakit_maas"  value="<?php echo $employee['gayri_resmi_maas'] ?>">

                                <!--input type="hidden" class="form-control" id="new_maas" value="<?php echo $employee['salary'] ?>" -->
                            </div>

                            <div class="col-sm-6">
                                <label class="col-form-label" for="name">Banka</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" onchange="maas_hesapla()" class="form-control" id="resmi" name="resmi">
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <label class="col-form-label" for="name">Nakit</label>
                                <div class="col-sm-6">
                                    <input type="checkbox" onchange="maas_hesapla()"  class="form-control" id="nakit" name="nakit">
                                </div>


                            </div>



                        </div>

                        <div class="modal-footer">
                            <input type="hidden" class="form-control required"
                                   name="eid" id="invoiceid" value="<?php echo $eid ?>">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                            <input type="hidden" id="action-url"  value="employee/calc_sales">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Yes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="form_cat" role="dialog">

        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">İzin Nedeni</th>
                        <th scope="col">Başlangıç Tarihi</th>
                        <th scope="col">Başlangıç Saati</th>
                        <th scope="col">Bitiş Tarihi</th>
                        <th scope="col">Bitiş Saati</th>

                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td id="pers_id"></td>
                        <span class="help-block"></span>
                        <td id="izin_sebebi"></td>
                        <span class="help-block"></span>
                        <td id="bas_date"></td>
                        <span class="help-block"></span>
                        <td id="bas_saati"></td>
                        <span class="help-block"></span>
                        <td id="bitis_date"></td>
                        <span class="help-block"></span>
                        <td id="bit_saati"></td>
                        <span class="help-block"></span>


                    </tr>

                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                </div>
            </div>
        </div>

    </div>
</div>


<style>
    #extres_length, #extres_info, #extres_paginate, #extres_filter
    {
        display: none;
    }
    #extre_gider_length, #extre_gider_info, #extre_gider_paginate, #extre_gider_filter
    {
        display: none;
    }
    #extre_mezuniyet_length, #extre_mezuniyet_info, #extre_mezuniyet_paginate, #extre_mezuniyet_filter
    {
        display: none;
    }

    #extre_razi_length, #extre_razi_info, #extre_razi_paginate, #extre_razi_filter
    {
        display: none;
    }
    #extre_borclandirma_length, #extre_borclandirma_info, #extre_borclandirma_paginate, #extre_borclandirma_filter
    {
        display: none;
    }
</style>
<script>

    function maas_hesapla() {
        var deger=$('#gun_sayisi').val();

        var new_maas = $('#new_maas').val();

        var banka_maas = $('#banka_maas').val();

        var nakit_maas = $('#nakit_maas').val();


        if($("#resmi").prop('checked')==true && $("#nakit").prop('checked')==false)
        {
            var gunluk = parseFloat(banka_maas) / 30;
        }
        else if($("#resmi").prop('checked')==false && $("#nakit").prop('checked')==true)
        {
            var gunluk = parseFloat(nakit_maas) / 30;
        }
        else
        {
            var gunluk = parseFloat(new_maas) / 30;
        }



        var hesapla=0;
        var hesaplaa = gunluk * deger;
        if(hesaplaa>new_maas)
        {
            hesapla=new_maas;

        }
        else
        {
            hesapla = parseFloat(gunluk )* parseFloat(deger);

        }

        $('#new_maas_inp').val(hesapla);



    }
    function edit_person(id)
    {
        $('.help-block').empty();
        $.ajax({
            url : "<?php echo site_url('employee/pers_view/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {

                $('[id="pers_id"]').val(data.id);
                $('[id="izin_sebebi"]').text(data.izin_sebebi);
                $('[id="bas_date"]').text(data.bas_date);
                $('[id="bas_saati"]').text(data.bas_saati);
                $('[id="bitis_date"]').text(data.bitis_date);
                $('[id="bit_saati"]').text(data.bit_saati);
                $('#form_cat').modal('show'); // show bootstrap modal when complete loaded
                // Set title to Bootstrap modal title



            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function maas_gunu_hesapla(val)
    {
        var resmi=0;
        var nakit=0;
        if($("#resmi").prop('checked')==true)
        {
            resmi = 1;
        }
        if($("#nakit").prop('checked')==true)
        {
            nakit = 1;
        }

        $.ajax({
            url : '/employee/maas_gunu_hesaplamasi',
            type: "POST",
            dataType: "JSON",
            data:{
                id:<?php echo @$_GET['id'] ?>,
                ay:val,
                resmi:resmi,
                nakit:nakit,
            } ,
            success: function(data)
            {
                if(data.status=='Success')

                {
                    alert(data.message);
                    $('#gun_sayisi').prop('disabled',true)
                    $('#gun_sayisi').val(data.gun);
                    $('#new_maas_inp').val(0);
                }
                else
                {

                    $('#gun_sayisi').prop('disabled',false)
                    $('#gun_sayisi').val(data.gun);
                    $('#gun_sayisi').keyup();

                }

            }
        });
    }
    $(document).ready(function() {


        $('#base-tab2').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab1').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab3').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab7').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab5').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab4').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab6').on('click', function () {
            $('.sorting').click()
        });
        $('#base-tab8').on('click', function () {
            $('.sorting').click()
        });
        $(document).ready(function () {

            $('.sorting').click();
            $('#extres').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY": "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_data')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi': 'tumu',
                        'cid':<?php echo @$_GET['id'] ?>,
                        'tyd': '<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '') / 100 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);

                    total2 = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    // Update footer

                    var bakiye = floatVal(total2) - floatVal(total);
                    var string = '';
                    if (floatVal(total2) > floatVal(total)) {

                        string = '(B)';
                    }
                    else {
                        string = '(A)'
                    }

                    var tatals = currencyFormat(floatVal(total));
                    var tatals2 = currencyFormat(floatVal(total2));
                    var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                    $(api.column(4).footer()).html(tatals);
                    $(api.column(3).footer()).html(tatals2);
                    $(api.column(5).footer()).html(bakiyes + ' ' + string);
                }
            });
            $('#extre_is').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY": "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_is')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi': 'tumu',
                        'cid':<?php echo @$_GET['id'] ?>,
                        'tyd': '<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '') / 100 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);

                    total2 = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    // Update footer

                    var bakiye = floatVal(total2) - floatVal(total);
                    var string = '';
                    if (floatVal(total2) > floatVal(total)) {

                        string = '(B)';
                    }
                    else {
                        string = '(A)'
                    }

                    var tatals = currencyFormat(floatVal(total));
                    var tatals2 = currencyFormat(floatVal(total2));
                    var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                    $(api.column(4).footer()).html(tatals);
                    $(api.column(3).footer()).html(tatals2);
                    $(api.column(5).footer()).html(bakiyes + ' ' + string);
                }
            });
            $('#extre_gider').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY": "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_gider')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi': 'tumu',
                        'cid':<?php echo @$_GET['id'] ?>,
                        'tyd': '<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '') / 100 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    var total_ = currencyFormat(floatVal(total));

                    $(api.column(3).footer()).html(total_);
                }
            });

           mezuniyet_draw_data()

            $('#extre_razi').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY": "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_data_razi')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi': 'tumu',
                        'cid':<?php echo @$_GET['id'] ?>,
                        'tyd': '<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '') / 100 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);

                    total2 = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    // Update footer

                    var bakiye = floatVal(total2) - floatVal(total);
                    var string = '';
                    if (floatVal(total2) > floatVal(total)) {

                        string = '(B)';
                    }
                    else {
                        string = '(A)'
                    }

                    var tatals = currencyFormat(floatVal(total));
                    var tatals2 = currencyFormat(floatVal(total2));
                    var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                    $(api.column(4).footer()).html(tatals);
                    $(api.column(3).footer()).html(tatals2);
                    $(api.column(5).footer()).html(bakiyes + ' ' + string);
                }
            });
            $('#extre_borclandirma').DataTable({


                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY": "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('employee/ekstre_data_borclandirma')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi': 'tumu',
                        'cid':<?php echo @$_GET['id'] ?>,
                        'tyd': '<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                    {
                        extend: 'print',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4,5]
                        }
                    },
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var floatVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\AZN,.]/g, '') / 100 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);

                    total2 = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return floatVal(a) + floatVal(b);
                        }, 0);


                    // Update footer

                    var bakiye = floatVal(total2) - floatVal(total);
                    var string = '';
                    if (floatVal(total2) > floatVal(total)) {

                        string = '(B)';
                    }
                    else {
                        string = '(A)'
                    }

                    var tatals = currencyFormat(floatVal(total));
                    var tatals2 = currencyFormat(floatVal(total2));
                    var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                    $(api.column(4).footer()).html(tatals);
                    $(api.column(3).footer()).html(tatals2);
                    $(api.column(5).footer()).html(bakiyes + ' ' + string);
                }
            });

            draw_data_izinler()

        });



        function currencyFormat(num) {

            var deger = num.toFixed(2).replace('.', ',');
            return deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' AZN';
        }

        function draw_data_izinler(){
            $('#izinler').DataTable({
                'processing': true,
                'serverSide': true,
                "scrollCollapse": true,
                "scrollY":        "700px",
                'stateSave': true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('personelaction/ajax_list_izinler')?>",
                    'type': 'POST',
                    'data': {
                        'tip':"w",
                        'cid':<?php echo $employee['id'] ?>,
                        'tyd':'<?php echo @$_GET['t'] ?>',
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false
                    }
                ],
                dom: 'Blfrtip',

            });
        }

        $(document).on('click','.eye-permit',function (){
            let permit_id = $(this).data('id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'İzin Görüntüle',
                icon: 'fa fa-eye',
                type: 'dark',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "col-md-6 mx-auto",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:function (){
                    let self = this;
                    let html=`<form>
                             <div class="row">
                               <div class="card col-md-12">
									  <ul class="list-group list-group-flush" style="text-align: justify;">
									  </ul>
									</div>
                            </div>
                                </form>`;

                    let data = {
                        crsf_token: crsf_hash,
                        permit_id: permit_id,
                    }


                    let li='';
                    $.post(baseurl + 'personelaction/get_info_permit_confirm',data,(response) => {
                        self.$content.find('#person-list').empty().append(html);
                        let responses = jQuery.parseJSON(response);
                        if(responses.status==200){
                            $.each(responses.item, function (index, item) {

                                let durum='Bekliyor';
                                let desc='';
                                if(item.staff_status==1){
                                    durum='Onaylandı';
                                }
                                else if(item.staff_status==2){
                                    durum='İptal Edildi';
                                    desc=`<li>`+item.staff_desc+`</li>`;
                                }
                                li+=`<li class="list-group-item"><b>`+item.sort+`. Personel Adı : </b>&nbsp;`+item.name+`</li><ul><li>`+durum+`</li>`+desc+`</ul>`;
                            });

                            $('.list-group-flush').empty().append(li);
                        }
                        else {
                            $('.list-group-flush').empty().append('<p>Bildirim Başlatılmamış</p>');
                        }


                    });
                    self.$content.find('#person-list').empty().append(html);
                    return $('#person-container').html();
                },
                buttons: {
                    cancel:{
                        text: 'Kapat',
                        btnClass: "btn btn-danger btn-sm",
                    }
                },
                onContentReady: function () {
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    })

                    $('#fileupload_').fileupload({
                        url: url,
                        dataType: 'json',
                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                        done: function (e, data) {
                            var img='default.png';
                            $.each(data.result.files, function (index, file) {
                                img=file.name;
                            });

                            $('#image_text').val(img);
                        },
                        progressall: function (e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $('#progress .progress-bar').css(
                                'width',
                                progress + '%'
                            );
                        }
                    }).prop('disabled', !$.support.fileInput)
                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
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





        $('.submit_model2').on('click', function () {

            setTimeout(function () {
                $('#extres').DataTable({


                    'processing': true,
                    'serverSide': true,
                    "scrollCollapse": true,
                    "scrollY": "700px",
                    'stateSave': true,
                    'order': [],
                    'ajax': {
                        'url': "<?php echo site_url('employee/ekstre_data')?>",
                        'type': 'POST',
                        'data': {
                            'para_birimi': 'tumu',
                            'cid':<?php echo @$_GET['id'] ?>,
                            'tyd': '<?php echo @$_GET['t'] ?>',
                            '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                        }
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
                                i.replace(/[\AZN,.]/g, '') / 100 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        // Total over all pages
                        total = api
                            .column(4)
                            .data()
                            .reduce(function (a, b) {
                                return floatVal(a) + floatVal(b);
                            }, 0);

                        total2 = api
                            .column(3)
                            .data()
                            .reduce(function (a, b) {
                                return floatVal(a) + floatVal(b);
                            }, 0);


                        // Update footer

                        var bakiye = floatVal(total2) - floatVal(total);
                        var string = '';
                        if (floatVal(total2) > floatVal(total)) {

                            string = '(B)';
                        }
                        else {
                            string = '(A)'
                        }

                        var tatals = currencyFormat(floatVal(total));
                        var tatals2 = currencyFormat(floatVal(total2));
                        var bakiyes = currencyFormat(floatVal(Math.abs(bakiye)));

                        $(api.column(4).footer()).html(tatals);
                        $(api.column(3).footer()).html(tatals2);
                        $(api.column(5).footer()).html(bakiyes + ' ' + string);
                    }
                });
            }, 3000);

        });
    });

    function draw_data(start_date='',end_date='')
    {
        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "ajax": {
                "url": "<?php echo site_url('employee/document_load_list')?>",
                "type": "POST",
                'data': {
                    start_date: start_date,
                    end_date: end_date,
                    'cid':<?=$_GET['id'] ?>,
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],

        });
    }
    $(document).ready(function () {

        draw_data();





    });

    $('#search').click(function () {
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        if (start_date != '' && end_date != '') {
            $('#doctable').DataTable().destroy();
            draw_data(start_date, end_date);
        } else {
            alert("Date range is Required");
        }
    });

    $(document).on('click', ".credit", function (e) {
        let id =$(this).attr('credit_id');
        $.confirm({
            theme: 'material',
            closeIcon: true,
            title: 'Borç Detayları',
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
                    '<div class="form-group table_rp">' +
                    '</div>' +
                    '</form>';

                let data = {
                    crsf_token: crsf_hash,
                }

                let table_report='';
                $.post(baseurl + 'employee/projeler',data,(response) => {
                    self.$content.find('#person-list').empty().append(html);
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    let responses = jQuery.parseJSON(response);

                    table_report =`
                        <table id="invoices_report"  class="table" style="width:100%;font-size: 12px;">
                        <thead>
                        <tr>
                            <th>Vade Tarihi</th>
                            <th>Tutar</th>
                            <th>Ödeme Tipi</th>
                            <th>Durum</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                           <th>Vade Tarihi</th>
                            <th>Tutar</th>
                            <th>Ödeme Tipi</th>
                            <th>Durum</th>
                        </tr>
                        </tfoot>

                    </table>`;
                    $('.table_rp').empty().html(table_report);
                    draw_data_report(id);
                });



                return $('#person-container').html();
            },
            onContentReady:function (){

            },
            buttons: {
                formSubmit: {
                    text: 'Girişi Yap',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
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
                            $('#loading-box').addClass('d-none');
                        }
                        let desc = $('#desc').val()
                        let start_date = $('#start_date').val()
                        let end_date = $('#end_date').val()


                        let job_status =  $('#job_status').prop('checked')?1:0;
                        let proje_id = $('#proje_id_modal').val()
                        let pers_id = $('#pers_id').val();
                        jQuery.ajax({
                            url: baseurl + 'controller/personel_takip_add',
                            dataType: "json",
                            method: 'post',
                            data: 'start_date='+start_date+'&end_date='+end_date+'&job_status='+job_status+'&desc='+desc+'&proje_id='+proje_id+'&pers_id='+pers_id+'&&'+crsf_token+'='+crsf_hash,
                            beforeSend: function(){
                                $('#loading-box').removeClass('d-none');
                                $('#loading-box').removeClass('d-none');

                            },
                            success: function (data) {
                                if (data.status == "Success") {
                                    $.alert(data.message);
                                    $('#loading-box').addClass("d-none");

                                } else {
                                    $.alert(data.message);
                                    $('#loading-box').addClass("d-none");

                                }

                                let id =$('#table_projects').val();
                                let start_date = $('#hesap_ay').val();
                                let hesap_yil = $('#hesap_yil').val();
                                let maas_type_id = $('#maas_type_filter').val();
                                $('#invoices').DataTable().destroy();
                                draw_data(start_date,id,maas_type_id,hesap_yil)
                            },
                            error: function (data) {
                                $.alert(data.message);
                                $('#loading-box').addClass("d-none");
                            }
                        });



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

    })
    function draw_data_report(credit_id) {

        $('#invoices_report').DataTable({
            'serverSide': true,
            'processing': true,
            "scrollX": true,
            'createdRow': function (row, data, dataIndex) {
                $(row).attr('style',data[25]);
            },
            aLengthMenu: [
                [ -1,10, 50, 100, 200],
                ["Tümü",10, 50, 100, 200]
            ],
            "order": [[ 1, "desc" ]],
            'ajax': {
                'url': "<?php echo site_url('employee/personel_credit_report')?>",
                'type': 'POST',
                'data': {
                    '<?=$this->security->get_csrf_token_name()?>': crsf_hash,
                    credit_id: credit_id,
                }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,

                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4,5,6,7,8,9,10]
                    }
                },
            ]
        });
    };

    $(document).on('click', ".delete_mezuniyet", function (e) {
        let talep_id = $(this).attr('mezuniyet_id');
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Dikkat',
            icon: 'fa fa-ban',
            type: 'red',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "small",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content:'<form action="" class="formName">' +
                '<div class="form-group">' +
                '<p>İşlemi Silmek Üzeresiniz Emin Misiniz?<p/>' +
                '</div>' +
                '</form>',
            buttons: {
                formSubmit: {
                    text: 'Sil',
                    btnClass: 'btn-red',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            talep_id: talep_id,
                        }
                        $.post(baseurl + 'employee/mezuniyet_sil',data,(response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if(responses.status=='Success'){
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "small",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                $('#extre_mezuniyet').DataTable().destroy();
                                                mezuniyet_draw_data();
                                            }
                                        }
                                    }
                                });

                            }
                            else if(responses.status=='Error'){

                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
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

    function mezuniyet_draw_data(){
        $('#extre_mezuniyet').DataTable({
            'processing': true,
            'serverSide': true,
            "scrollCollapse": true,
            "scrollY": "700px",
            'stateSave': true,
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('employee/mezuniyet')?>",
                'type': 'POST',
                'data': {
                    'para_birimi': 'tumu',
                    'cid':<?php echo @$_GET['id'] ?>,
                    'tyd': '<?php echo @$_GET['t'] ?>',
                    '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                }
            },
            'columnDefs': [
                {
                    'targets': [],
                    'orderable': false,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'pdf',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },

                {
                    extend: 'copy',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                }
            ],
        });
    }
</script>

