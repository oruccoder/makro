<?php

/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 30.11.2019
 * Time: 17:56
 */

$role_id = $this->aauth->get_user()->roleid;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/horizontal-menu.css">


</head>

<body class="horizontal-layout horizontal-menu 2-columns menu-expanded" data-open="hover" data-menu="horizontal-menu" data-col="2-columns">
    <span id="hdata" data-df="<?php echo $this->config->item('dformat2'); ?>" data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
    <!-- fixed-top-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
        <div class="navbar-wrapper">
            <div class="navbar-header">
                <ul class="nav navbar-nav flex-row">
                    <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
                    <li class="nav-item"><a class="navbar-brand" href="<?= base_url() ?>dashboard/"><img class="brand-logo" alt="logo" src="<?php echo base_url(); ?>userfiles/theme/logo-header.png">
                        </a></li>

                    <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
                </ul>
            </div>
            <div class="navbar-container content">
                <div class="collapse navbar-collapse" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">
                        <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>


                        <!--li class="dropdown  nav-item"><a id="maps" class="nav-link nav-link-label" href="#"
                                                      data-toggle="dropdown"><i
                                    class="ficon ft-map-pin success"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><i
                                                class="ficon ft-map-pin success"></i><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location') ?></span>
                                </h6>
                            </li>

                            <li class="dropdown-menu-footer"><span class="dropdown-item text-muted text-center blue"
                                > <?php $loc = location($this->aauth->get_user()->loc);
                                    echo $loc['cname']; ?></span>
                            </li>
                        </ul>
                    </li-->
                        <!--li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>pos_invoices/create"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="Access POS"><i
                                    class="icon-handbag"></i><?php echo $this->lang->line('POS') ?> </a>
                    </li-->
                        <li>

                            <div class="dropdown">
                                <button class="btn btn-info" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-plus fabtn" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <a href="<?php echo base_url(); ?>customers/create" class="dropdown-item" id="href1"><?php echo $this->lang->line('New Client') ?><span><b class="btn btn-info btn-sm" id="b1">Ekle</b></span></a>
                                    <a href="<?= base_url(); ?>invoices/create" class="dropdown-item" id="href1"><?php echo $this->lang->line('New Invoice'); ?><span><b class="btn btn-info btn-sm" id="b2">Ekle</b></span></a>
                                    <a href="<?= base_url(); ?>urun" class="dropdown-item" id="href1"><?php echo $this->lang->line('New Product'); ?><span><b class="btn btn-info btn-sm" id="b3">Ekle</b></span></a>
                                    <a href="<?php echo base_url(); ?>transactions/add" class="dropdown-item" id="href1"><?php echo $this->lang->line('yeni_islem') ?><span><b class="btn btn-info btn-sm" id="b4">Ekle</b></span></a>

                                    <a href="<?= base_url(); ?>purchase/create" class="dropdown-item" id="href1"><?php echo $this->lang->line('yeni_siparis'); ?><span><b class="btn btn-info btn-sm" id="b5">Ekle</b></span></a>
                                    <a href="<?= base_url(); ?>cost/yeni_gider" class="dropdown-item" id="href1">Yeni Gider<span><b class="btn btn-info btn-sm" id="b5">Ekle</b></span></a>
                                    <a href="<?= base_url(); ?>reports/onaylananlar" class="dropdown-item" id="href1">Ödeme Emri Verilenler<span><b class="btn btn-info btn-sm" id="b5">Görüntüle</b></span></a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>activecar/index" class="btn btn-info btn-md t_tooltip" title="Aktif Araç"><i class="fa fa-truck"></i>Aktif Araçlar</a>
                        </li>

                        <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>arac/mk_araclist" class="btn btn-info btn-md t_tooltip" title="Aktif Araç"><i class="fa fa-truck"></i>Makro2000 Araçlar</a>
                        </li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#" aria-haspopup="true" aria-expanded="false" id="search-input"><i class="ficon ft-search"></i></a>
                            <div class="search-input">
                                <input class="input" type="text" placeholder="<?php echo $this->lang->line('Search Customer') ?>" id="head-customerbox">
                            </div>
                            <div id="head-customerbox-result" class="dropdown-menu ml-5" aria-labelledby="search-input"></div>
                        </li>


                    </ul>





                    <ul class="nav navbar-nav float-right"><?php if ($this->aauth->premission(14)) { ?>


                            <li class="dropdown nav-item mega-dropdown">
                                <a href="https://pashabank.digital/login#/" target="_blank">
                                    <img style="position: inherit !important;width: 23%;background-color: white;float: right;" src="<?php echo base_url('userfiles/logo-pasha.png') ?>">
                                </a>
                            </li>
                            <li class="dropdown nav-item mega-dropdown">
                                <a class="dropdown-toggle nav-link " href="#" data-toggle="dropdown"> <?php echo $this->lang->line('Settings') ?></a>
                                <ul class="mega-dropdown-menu dropdown-menu row">
                                    <li class="col-md-3">

                                        <div id="accordionWrap" role="tablist" aria-multiselectable="true">
                                            <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading1" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap" href="#accordion1" aria-controls="accordion1"><i class="fa fa-leaf"></i> <?php echo $this->lang->line('Business') . '  ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion1" role="tabpanel" aria-labelledby="heading1" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/company"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Company') . ' ' . $this->lang->line('Settings') ?>
                                                                </a></li>
                                                            <li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>tools/setgoals"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Set Goals') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap" href="#accordion2" aria-controls="accordion2"> <i class="fa fa-calendar"></i><?php echo $this->lang->line('Localisation') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion2" role="tabpanel" aria-labelledby="heading2" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/currency"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/language"><i class="ft-chevron-right"></i>Languages</a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/dtformat"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Date & Time Format') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/theme"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Theme') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading3" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap" href="#accordion3" aria-controls="accordion3"> <i class="fa fa-lightbulb-o"></i><?php echo $this->lang->line('Miscellaneous') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion3" role="tabpanel" aria-labelledby="heading3" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>webupdate"><i class="ft-chevron-right"></i> Software
                                                                    Update</a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/email"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Email Config') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>transactions/categories"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Transaction Categories') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/misc_automail"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Email') . ' ' . $this->lang->line('Alert') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/about"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('About') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-md-3">

                                        <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                            <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading4" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion4" aria-controls="accordion4"><i class="fa fa-fire"></i><?php echo $this->lang->line('Advanced') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion4" role="tabpanel" aria-labelledby="heading4" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>restapi"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('REST API') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>cronjob"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Automatic Corn Job') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/custom_fields"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Custom') ?> <?php echo $this->lang->line('Fields') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/dual_entry"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Dual Entry') . ' ' . $this->lang->line('Accounting') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/logdata"><i class="ft-chevron-right"></i> Application
                                                                    Activity Log</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/debug"><i class="ft-chevron-right"></i> Debug Mode </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion5" aria-controls="accordion5"> <i class="fa fa-shopping-cart"></i><?php echo $this->lang->line('Billing') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion5" role="tabpanel" aria-labelledby="heading5" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/discship"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Discount') . ' & ' . $this->lang->line('Shipping') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/prefix"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Prefix') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/billing_terms"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Billing Terms') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/automail"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Auto Email SMS') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/warehouse"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Warehouse') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/zero_stock"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Zero Stock') . ' ' . $this->lang->line('Billing') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/pos_style"><i class="ft-chevron-right"></i><?php echo $this->lang->line('POS') . ' ' . $this->lang->line('Style') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading6" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion6" aria-controls="accordion6"><i class="fa fa-scissors"></i><?php echo $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion6" role="tabpanel" aria-labelledby="heading6" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/tax"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Tax') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/taxslabs"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-md-3">

                                        <div id="accordionWrap2" role="tablist" aria-multiselectable="true">
                                            <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading7" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion7" aria-controls="accordion7"><i class="fa fa-flask"></i><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion7" role="tabpanel" aria-labelledby="heading7" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>units"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Measurement Unit') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>units/variations"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>units/variables"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Variations') . ' ' . $this->lang->line('Variables') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading8" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion8" aria-controls="accordion8"> <i class="fa fa-money"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion8" role="tabpanel" aria-labelledby="heading8" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>paymentgateways/settings"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>paymentgateways"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Gateways') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>paymentgateways/currencies"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Currencies') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>paymentgateways/exchange"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency Exchange') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>paymentgateways/bank_accounts"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Bank Accounts') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading9" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion9" aria-controls="accordion9"><i class="fa fa-umbrella"></i><?php echo $this->lang->line('CRM') . ' & ' . $this->lang->line('HRM') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion9" role="tabpanel" aria-labelledby="heading9" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>employee/auto_attendance"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Self') . ' ' . $this->lang->line('Attendance') ?>
                                                                </a></li>

                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/registration"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('CRM') . ' ' . $this->lang->line('Settings') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>plugins/recaptcha"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Security') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/tickets"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Support Tickets') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </li>


                                    <li class="col-md-3">

                                        <div id="accordionWrap3" role="tablist" aria-multiselectable="true">
                                            <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading10" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap3" href="#accordion10" aria-controls="accordion10"><i class="fa fa-magic"></i><?php echo $this->lang->line('Plugins') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion10" role="tabpanel" aria-labelledby="heading10" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>plugins/recaptcha"><i class="ft-chevron-right"></i>reCaptcha Security</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>plugins/shortner"><i class="ft-chevron-right"></i> URL Shortener</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>plugins/twilio"><i class="ft-chevron-right"></i> SMS Configuration</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>paymentgateways/exchange"><i class="ft-chevron-right"></i>Currency Exchange
                                                                    API</a></li>
                                                            <?php plugins_checker(); ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading11" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap3" href="#accordion11" aria-controls="accordion11"> <i class="fa fa-eye"></i><?php echo $this->lang->line('Templates') . ' ' . $this->lang->line('Settings') ?>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion11" role="tabpanel" aria-labelledby="heading8" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>templates/email"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Email') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>templates/sms"><i class="ft-chevron-right"></i> SMS</a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/print_invoice"><i class="ft-chevron-right"></i> <?php echo $this->lang->line('Print Invoice') ?>
                                                                </a></li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>settings/theme"><i class="ft-chevron-right"></i><?php echo $this->lang->line('Theme') ?>
                                                                </a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card-header p-0 pb-1 border-0 mt-1" id="heading12" role="tab">
                                                    <a class=" text-uppercase black" data-toggle="collapse" data-parent="#accordionWrap3" href="#accordion12" aria-controls="accordion12"><i class="fa fa-print"></i>POS Printers</a>
                                                    </a>
                                                </div>
                                                <div class="card-collapse collapse mb-1 " id="accordion12" role="tabpanel" aria-labelledby="heading12" aria-expanded="true">
                                                    <div class="card-content">
                                                        <ul>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>printer/add"><i class="ft-chevron-right"></i>Add Printer</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="<?php echo base_url(); ?>printer"><i class="ft-chevron-right"></i> List Printers</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </li>



                        <?php } ?>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="taskcount">0</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2"><?php echo $this->lang->line('bekleyen_talepler') ?></span><span class="notification-tag badge badge-default badge-danger float-right m-0"><?= $this->lang->line('New') ?></span>
                                    </h6>
                                </li>
                                <li class="scrollable-container media-list" id="tasklist"></li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="<?php echo base_url('form/bekleyen_talepler') ?>"><?php echo $this->lang->line('talepleri_goruntule') ?></a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bildirimler" content="tüm Bildirimler"><a class="nav-link nav-link-label" href="/notification/index">
                                <i class="fa fa-exclamation"></i><span class="badge badge-pill badge-default badge-danger badge-default badge-up" id="notification_">0</span></a>
                        </li>


                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bekleyen Kasa Talepleri"  content="Bekleyen Kasa Talepleri"><a class="nav-link nav-link-label" href="/reports/kasa_talepleri"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-bank"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="kasacount"></span></a>-->
                        <!--                    </li>-->

                        <!--                    --><?php //if($this->aauth->get_user()->id == 21) {
                                                    //
                                                    //                        
                                                    ?>
                        <!--                        <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bekleyen Emeq Haqları"  content="Personel Çıkış"><a class="nav-link nav-link-label" href="#"-->
                        <!--                            ><i-->
                        <!--                                        class="fa fa-users"></i><span-->
                        <!--                                        class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                        id="cikispers"></span></a>-->
                        <!--                        </li>-->
                        <!---->
                        <!--                        <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bordro Düzenleme Onayı"  content="Bordro Düzenleme Onayı"><a class="nav-link nav-link-label" href="/raporlar/edit_salary_report"-->
                        <!--                            ><i-->
                        <!--                                        class="fa fa-users"></i><span-->
                        <!--                                        class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                        id="bordro_edit"></span></a>-->
                        <!--                        </li>-->
                        <!--                        --><? //
                                                        //                    }
                                                        //                    
                                                        ?>
                        <!---->
                        <!---->
                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Razılaştırmalar"  content="Bekleyen Razlaştırma Protokolleri"><a class="nav-link nav-link-label" href="/razilastirma/bekleyen_list"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-file"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="razi_count"></span></a>-->
                        <!--                    </li>-->
                        <!---->
                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bekleyen Emeq Haqları"  content="Bekleyen Emeq Haqları"><a class="nav-link nav-link-label" href="/reports/maas_onayi"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-money"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="maascount"></span></a>-->
                        <!--                    </li>-->
                        <!--                    --><?php //if($this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 61) {
                                                    //                        
                                                    ?>
                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bekleyen Maas Ödeme Emri"  content="Bekleyen Emeq Haqları"><a class="nav-link nav-link-label" href="/reports/maas_odemesi"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-credit-card"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="bekleyenmaascount"></span></a>-->
                        <!--                    </li>-->
                        <!---->
                        <!--                    --><?php //} 
                                                    ?>
                        <!--                    --><?php //if($this->aauth->get_user()->id == 61 || $this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 174) {
                                                    //                    
                                                    ?>
                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bekleyen Forma2"  content="Bekleyen Forma2"><a class="nav-link nav-link-label" href="/reports/bekleyen_forma_2"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-question-circle"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="forma2count"></span></a>-->
                        <!--                    </li>-->
                        <!--                    --><?php //} 
                                                    ?>
                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Bekleyen Prim"  content="Bekleyen Prim"><a class="nav-link nav-link-label" href="/reports/prim_onaylari"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-credit-card"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="bekleyenprimcount"></span></a>-->
                        <!--                    </li>-->
                        <!---->
                        <!--                    <li class="dropdown dropdown-notification nav-item t_tooltip" title="Lojistik Gideri"  content="Lojistik Gideri"><a class="nav-link nav-link-label" href="/lojistikgider/bekleyen_list"-->
                        <!--                        ><i-->
                        <!--                                    class="fa fa-truck"></i><span-->
                        <!--                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"-->
                        <!--                                    id="bekleyenlojistikgideri"></span></a>-->
                        <!--                    </li>-->
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i><span class="badge badge-pill badge-default badge-info badge-default badge-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <h6 class="dropdown-header m-0"><span class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span><span class="notification-tag badge badge-default badge-warning float-right m-0"><?php echo $this->aauth->count_unread_pms() ?><?php echo $this->lang->line('new') ?></span>
                                    </h6>
                                </li>
                                <li class="scrollable-container media-list">
                                    <?php //$list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);
                                    $list_pm = gelen_mesaj_header($this->aauth->get_user()->id);

                                    foreach ($list_pm as $row) {

                                        echo '<a href="' . base_url('messages/view?pid=' . $row->pid . '&id=' . $row->sender_id) . '">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm  rounded-circle"><img src="' . base_url('userfiles/employee/thumbnail/' . pesonel_picture_url($row->sender_id)) . '" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                    } ?> </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span style="    border-radius: 50%;
    overflow: hidden;
    background: linear-gradient(#00000000,#676767);
    position: relative;
    width: 30px;
    height: 30px;" class="avatar avatar-online"><img src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>" alt="avatar"><i></i></span><span class="user-name"><?php echo $this->lang->line('Account') ?></span></a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="<?php echo base_url(); ?>user/profile"><i class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <!-- Horizontal navigation-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content" data-menu="menu-container">

            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item"><a class="nav-link href" href="<?= base_url(); ?>dashboard/"><i class="icon-speedometer"></i><span><?= $this->lang->line('Dashboard') ?></span></a>

                </li>


                <li class="dropdown nav-item" data-menu="dropdown">
                    <?php
                    if ($this->aauth->premission(1) || $this->aauth->premission(9) || $this->aauth->premission(10)) { ?>
                        <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-basket-loaded"></i><span><?php echo $this->lang->line('sales') ?></span></a>
                    <?php } ?>
                    <ul class="dropdown-menu">


                        <?php
                        if ($this->aauth->premission(1)) { ?>
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-basket"></i><?php echo $this->lang->line('sales') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>invoices/create" data-toggle="dropdown"><?php echo $this->lang->line('New Invoice'); ?></a>
                                    </li>

                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>invoices" data-toggle="dropdown"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                                    </li>

                                </ul>
                            </li>

                        <?php } ?>
                        <?php
                        if ($this->aauth->premission(9)) { ?>
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-call-out"></i><?php echo $this->lang->line('Quotes') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>quote/create" data-toggle="dropdown"><?php echo $this->lang->line('New Quote'); ?></a>
                                    </li>

                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>quote" data-toggle="dropdown"><?php echo $this->lang->line('Manage Quotes'); ?></a>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php if ($this->aauth->premission(10)) { ?>
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-radio"></i><?php echo $this->lang->line('ManagesOrders') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>purchase/create" data-toggle="dropdown"><?php echo $this->lang->line('yeni_siparis'); ?></a>
                                    </li>

                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>purchase" data-toggle="dropdown"><?php echo $this->lang->line('Manage Orders'); ?></a></li>

                                </ul>
                            </li>

                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></i><?php echo $this->lang->line('requested') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>requested/create" data-toggle="dropdown"><?php echo $this->lang->line('requested_add'); ?></a>
                                    </li>

                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>requested" data-toggle="dropdown"><?php echo $this->lang->line('requested_list'); ?></a></li>

                                </ul>
                            </li>

                        <?php } ?>
                        <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>invoices/form2" data-toggle="dropdown"><i class="fa fa-file"></i><?php echo $this->lang->line('form_2'); ?>
                            </a>
                        </li>
                        <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>invoices/form2_report_ques" data-toggle="dropdown"><i class="fa fa-file"></i>Cari Bazlı Forma2 Raporu
                            </a>
                        </li>

                    </ul>
                </li>
                <?php
                if ($this->aauth->premission(3)) {
                ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-diamond"></i><span><?php echo $this->lang->line('CRM') ?></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-users"></i><?php echo $this->lang->line('Clients') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers/create" data-toggle="dropdown"><?php echo $this->lang->line('New Client') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers" data-toggle="dropdown"><?= $this->lang->line('Manage Clients'); ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers/potansiyel_musteriler" data-toggle="dropdown">Potansiyel Müşteriler</a>
                                    </li>

                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers/podratci" data-toggle="dropdown">Podratçı ve Siparişçi Müşteriler</a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>customers/controller_notes" data-toggle="dropdown">Cari Kontroller Notları</a>
                                    </li>
                                </ul>
                            </li>


                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-users"></i><?php echo $this->lang->line('Client Groups') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>clientgroup/create" data-toggle="dropdown"><?php echo $this->lang->line('new_cari_gruo') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>clientgroup" data-toggle="dropdown"><?= $this->lang->line('Manage_Group'); ?></a>
                                    </li>

                                </ul>
                            </li>



                            <!--li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a
                                    class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i
                                        class="fa fa-ticket"></i><?php echo $this->lang->line('Support Tickets') ?></a>
                            <ul class="dropdown-menu">
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>tickets/?filter=unsolved"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('UnSolved') ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>tickets"
                                                    data-toggle="dropdown"><?= $this->lang->line('Manage Tickets'); ?></a>
                                </li>
                            </ul>
                        </li-->

                        </ul>
                    </li>
                <?php }
                if ($this->aauth->premission(2)) { ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="ft-layers"></i><span><?php echo $this->lang->line('Stock') ?></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>urun" data-toggle="dropdown"><i class="fa fa-barcode"></i>Ürünler
                                </a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>productoption" data-toggle="dropdown"><i class="ft-wind"></i>Varyasyonlar</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>warehouse/index" data-toggle="dropdown"><i class="ft-wind"></i>Depolar</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>stockio" data-toggle="dropdown"><i class="ft-wind"></i>Stok Giriş/Çıkış İşlemleri</a>
                            </li>

                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>newproductcategory" data-toggle="dropdown"><i class="ft-wind"></i>Kategoriler</a>
                            </li>


                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>newunits" data-toggle="dropdown"><i class="ft-wind"></i>Ürün Ölçü Birimleri</a>
                            </li>











<!--                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-target"></i>--><?php //echo $this->lang->line('urun_olcu_birimleri') ?><!--</a>-->
<!--                                <ul class="dropdown-menu">-->
<!--                                    <li data-menu=""><a class="dropdown-item" href="--><?//= base_url(); ?><!--units/create" data-toggle="dropdown">--><?php //echo $this->lang->line('yeni_olcu_birimi'); ?><!--</a>-->
<!--                                    </li>-->
<!---->
<!--                                    <li data-menu=""><a class="dropdown-item" href="--><?php //echo base_url(); ?><!--units" data-toggle="dropdown">--><?php //echo $this->lang->line('olcu_birim_listesi'); ?><!--</a>-->
<!--                                </ul>-->
<!--                            </li>-->

                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>stocktransfer" data-toggle="dropdown"><i class="ft-wind"></i><?php echo $this->lang->line('Stock Transfer'); ?></a>
                            </li>



                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-radio"></i><?php echo $this->lang->line('ManagesSayim') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>sayim/create" data-toggle="dropdown"><?php echo $this->lang->line('new_sayim'); ?></a>
                                    </li>

                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>sayim" data-toggle="dropdown"><?php echo $this->lang->line('sayimlar'); ?></a></li>

                                </ul>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>products/custom_label" data-toggle="dropdown"><i class="fa fa-barcode"></i><?php echo $this->lang->line('barkod_tasarimi'); ?>
                                </a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>arac/index" data-toggle="dropdown"><i class="fa fa-barcode"></i>Araçlar
                                </a>
                            </li>
                            <!--                        <li data-menu=""><a class="dropdown-item"-->
                            <!--                                            href="--><?php //echo base_url(); 
                                                                                        ?>
                            <!--ihracat"-->
                            <!--                                            data-toggle="dropdown"><i-->
                            <!--                                        class="fa fa-barcode"></i>--><?php //echo $this->lang->line('ithalat_ihracat'); 
                                                                                                        ?>
                            <!--                            </a>-->
                            <!--                        </li>-->
                            <!--                        <li data-menu=""><a class="dropdown-item"-->
                            <!--                                            href="--><?php //echo base_url(); 
                                                                                        ?>
                            <!--form/tehvil_alinan_urunler"-->
                            <!--                                            data-toggle="dropdown"><i-->
                            <!--                                        class="fa fa-barcode"></i>--><?php //echo $this->lang->line('tehvil_alinan_urunler'); 
                                                                                                        ?>
                            <!--                            </a>-->
                            <!--                        </li>-->
                            <!--                        <li data-menu=""><a class="dropdown-item"-->
                            <!--                                            href="--><?php //echo base_url(); 
                                                                                        ?>
                            <!--form/tehvil_dosyalari"-->
                            <!--                                            data-toggle="dropdown"><i-->
                            <!--                                        class="fa fa-barcode"></i>--><?php //echo $this->lang->line('tehvil_dosyalari'); 
                                                                                                        ?>
                            <!--                            </a>-->
                            <!--                        </li>-->
                        </ul>
                    </li>
                <?php }
                if ($this->aauth->premission(5)) {
                ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-calculator"></i><span><?= $this->lang->line('finans_yonetimi') ?></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-book-open"></i><?php echo $this->lang->line('finans_islemleri') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>transactions/add" data-toggle="dropdown"><?php echo $this->lang->line('yeni_islem') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>transactions" data-toggle="dropdown"><?= $this->lang->line('islem_listesi'); ?></a>
                                    </li>
                                </ul>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>invoices/fakrorinq" data-toggle="dropdown"><i class="icon-wallet"></i>Fakrorinq</a>
                            </li>
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-wallet"></i><?php echo $this->lang->line('hesap_islemleri') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>accounts/add" data-toggle="dropdown"><?php echo $this->lang->line('yeni_hesap') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>accounts" data-toggle="dropdown"><?= $this->lang->line('hesap_listesi'); ?></a>
                                    </li>
                                </ul>
                            </li>


                            <!--li data-menu=""><a class="dropdown-item"
                                            href="<?php echo base_url(); ?>transactions/transfer"
                                            data-toggle="dropdown"><i class="fa fa-money"></i><?= $this->lang->line('New Transfer'); ?></a>
                        </li-->
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>transactions/doviz_transfer" data-toggle="dropdown"><i class="fa fa-money"></i>Kasalar Arası Virman</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>accounts/gunun_ozeti" data-toggle="dropdown"><i class="fa fa-money"></i><?= $this->lang->line('gunun_ozeti'); ?></a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>cost" data-toggle="dropdown"><i class="fa fa-money"></i><?= $this->lang->line('giderler'); ?></a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>ihale" data-toggle="dropdown"><i class="fa fa-money"></i>İhale</a>
                            </li>

                        </ul>
                    </li>

                <?php
                }
                if ($this->aauth->premission(7)) {
                ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="ft-file-text"></i><span><?php echo $this->lang->line('HRM') ?></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="ft-users"></i><?php echo $this->lang->line('Employees') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee" data-toggle="dropdown"><?php echo $this->lang->line('Employees') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee/permissions" data-toggle="dropdown"><?= $this->lang->line('Permissions'); ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee/toplu_maas_odeme" data-toggle="dropdown">Personel Maaş Ödemesi</a>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>employee/personel_report" data-toggle="dropdown">Personel Maaş Raporu</a>
                                    </li>
                                    <!--li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/attendances"
                                                    data-toggle="dropdown"><?= $this->lang->line('Attendance'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item"
                                                    href="<?php echo base_url(); ?>employee/holidays"
                                                    data-toggle="dropdown"><?= $this->lang->line('Holidays'); ?></a>
                                </li-->
                                </ul>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/departments"><i class="icon-folder"></i><?php echo $this->lang->line('Departments'); ?></a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/payroll_list"><i class="icon-notebook"></i><?php echo $this->lang->line('Payroll'); ?></a>
                            </li>

                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>employee/bordro_hesaplama"><i class="icon-notebook"></i>Bordro Hesaplama</a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>controller/holidays"><i class="icon-notebook"></i>Tatil Günleri</a>
                            </li>

                        </ul>
                    </li>
                <?php }

                if ($this->aauth->get_user()->id == 64) {
                    // if ($this->aauth->premission(6)) {
                ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-energy"></i><span><?php echo $this->lang->line('uretim_yonetimi') ?></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-trophy"></i><?php echo $this->lang->line('recete_islemleri') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>uretim/add_recete" data-toggle="dropdown"><?php echo $this->lang->line('yeni_recete') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>uretim/list_recete" data-toggle="dropdown"><?= $this->lang->line('recete_listesi'); ?></a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-trophy"></i><?php echo $this->lang->line('uretim_islemleri') ?></a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>uretim/yeni_uretim" data-toggle="dropdown"><?php echo $this->lang->line('yeni_uretim') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>uretim/uretim_list" data-toggle="dropdown"><?= $this->lang->line('uretim_listesi'); ?></a>
                                    </li>
                                </ul>
                            </li>

                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>uretim/uretim_hesaplama"><i class="icon-list"></i><?php echo $this->lang->line('uretim_hesaplama'); ?></a>
                            </li>


                        </ul>
                    </li>

                <?php }



                if ($this->aauth->premission(4)) {
                ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-briefcase"></i><span><?= $this->lang->line('Project') ?></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-calendar"></i><?php echo $this->lang->line('Project Management') ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>projects/addproject" data-toggle="dropdown"><?php echo $this->lang->line('New Project') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>projects" data-toggle="dropdown"><?= $this->lang->line('Manage Projects'); ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>projects/is_kalemleri_durumlari" data-toggle="dropdown">İş Kalemi Durumları</a>
                                    </li>

                                </ul>
                            </li>


                            <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-calendar"></i><?php echo $this->lang->line('To Do List') ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>tools/addtask" data-toggle="dropdown"><?php echo $this->lang->line('yeni_gorev') ?></a>
                                    </li>
                                    <li data-menu=""><a class="dropdown-item" href="<?php echo base_url(); ?>tools/todo" data-toggle="dropdown"><?= $this->lang->line('gorev_listesi'); ?></a>
                                    </li>

                                </ul>
                            </li>

                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>projects/service_product"><i class="icon-list"></i><?php echo $this->lang->line('new_service_product'); ?></a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>projects/service_product_list"><i class="icon-list"></i><?php echo $this->lang->line('list_service_product'); ?></a>
                            </li>

                        </ul>
                    </li>
                <?php }

                if ($this->aauth->premission(8)) {
                ?>
                    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('Data & Reports') ?></span></a>
                        <ul class="dropdown-menu">
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>reports/cari_bakiye"><i class="icon-eyeglasses"></i><?php echo $this->lang->line('cari_bakiye_raporu'); ?>
                                </a>
                            </li>
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>reports/kdv_raporu"><i class="icon-eyeglasses"></i><?php echo $this->lang->line('kdv_raporu'); ?>
                                </a>
                            </li>
                            <!--                        <li data-menu="">-->
                            <!--                            <a class="dropdown-item" href="--><?php //echo base_url(); 
                                                                                                ?>
                            <!--reports/envanter_raporu"><i-->
                            <!--                                        class="icon-eyeglasses"></i>--><?php //echo $this->lang->line('envanter'); 
                                                                                                        ?>
                            <!--                            </a>-->
                            <!--                        </li>-->
                            <li data-menu="">
                                <a class="dropdown-item" href="<?php echo base_url(); ?>reports/product_report"><i class="icon-eyeglasses"></i><?php echo $this->lang->line('product_report'); ?>
                                </a>
                            </li>
                            <!--                        <li data-menu="">-->
                            <!--                            <a class="dropdown-item" href="--><?php //echo base_url(); 
                                                                                                ?>
                            <!--reports/personel_kesintisi"><i-->
                            <!--                                        class="icon-eyeglasses"></i>--><?php //echo $this->lang->line('personel_kesintisi'); 
                                                                                                        ?>
                            <!--                            </a>-->
                            <!--                        </li>-->

                    </li>
                    <?php if ($this->aauth->get_user()->id == 21 || $this->aauth->get_user()->id == 39 || $this->aauth->get_user()->id == 61 || $this->aauth->get_user()->id == 750 || $this->aauth->get_user()->id == 62) {
                    ?>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>raporlar/razi_report"><i class="icon-eyeglasses"></i>Personel Razı Raporu
                            </a>
                        </li>
                        <li data-menu="">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>raporlar/avans_report"><i class="icon-eyeglasses"></i>Personel Avans Raporu
                            </a>
                        </li>
                    <?php } ?>

                    <li data-menu="">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>logistics/lojistikhizmetlist"><i class="icon-eyeglasses"></i>Lojistik Araç Raporu
                        </a>
                    </li>

            </ul>
            </li>

        <?php }
                if ($this->aauth->premission(12)) {
        ?>

            <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="icon-note"></i><span><?php echo $this->lang->line('Miscellaneous') ?></span></a>
                <ul class="dropdown-menu">
                    <!-- Formlar -->
                    <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon-basket"></i><?php echo $this->lang->line('formlar') ?></a>
                        <ul class="dropdown-menu">

                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/malzeme_talep_list" data-toggle="dropdown"><?php echo $this->lang->line('malzeme_talep_formu'); ?></a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>malzemetalep" data-toggle="dropdown">Yeni Malzeme Talep Formu</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/satinalma_formu_list" data-toggle="dropdown"><?php echo $this->lang->line('satinalma_formu'); ?></a>
                            </li>
                            <!--li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/satinalma_emri_list"
                                                    data-toggle="dropdown">Satın Alma Emri</a>
                                </li-->

                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/gider_talebi_list" data-toggle="dropdown">Gider Talebi</a>
                            </li>

                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/avans_talebi_list" data-toggle="dropdown">Ödeme / Avans Talebi</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>lojistik/index" data-toggle="dropdown">Lojistik Talebi</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>logistics/index" data-toggle="dropdown">Lojistik Satınalma Formu</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>aracform/index" data-toggle="dropdown">Araç Talep Formu</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>aracform/podradci_index" data-toggle="dropdown">Podradçı Araç Talep Formu</a>
                            </li>
                            <li data-menu=""><a class="dropdown-item" download href="<?= base_url(); ?>userfiles/teslim_tutanak.pdf" data-toggle="dropdown">Araç Teslim Tutanağı</a>
                            </li>

                            <!--
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/ofis_depo_form"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('ofis_depo_form'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/santiye_form"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('santiye_form'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/ise_gec_gelme_ihtar_form"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('ise_gec_gelme_ihtar_form'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/ise_gec_gelme_tutanak_form"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('ise_gec_gelme_tutanak_form'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/mal_cikis_fisi"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('mal_cikis_fisi'); ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/ofis_gider_talebi"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('ofis_gider_talebi'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/personel_avans_tediye_makbuzu"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('personel_avans_tediye_makbuzu'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/proje_tutanak_formu"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('proje_tutanak_formu'); ?></a>
                                </li>

                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/tahislat_makbuzu"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('tahislat_makbuzu'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/tediye_makbuzu"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('tediye_makbuzu'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/teslim_tutanagi"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('teslim_tutanagi'); ?></a>
                                </li>
                                <li data-menu=""><a class="dropdown-item" href="<?= base_url(); ?>form/tutanak_formu"
                                                    data-toggle="dropdown"><?php echo $this->lang->line('tutanak_formu'); ?></a>
                                </li>

                                -->

                        </ul>
                    </li>
                    <!-- Formlar -->
                    <li data-menu="">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>tools/notes"><i class="icon-note"></i><?php echo $this->lang->line('Notes'); ?></a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>events/list_randevu"><i class="icon-note"></i>Randevuler</a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>events"><i class="icon-calendar"></i><?php echo $this->lang->line('Calendar'); ?></a>
                    </li>
                    <li data-menu="">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>tools/documents"><i class="icon-doc"></i><?php echo $this->lang->line('Documents'); ?></a>
                    </li>


                </ul>
            </li>
        <?php }


        ?>
        <li class="nav-item"><a style="padding: 28px 0px 0px 0px !important;" id="gunluk_gorusme" class=" nav-link" href="#pop_model_gunluk" data-toggle="modal" data-remote="false"><i class="icon-note"></i><span>Günlük Görüşmelerim</span></a></li>

        <?php

        if ($this->aauth->premission(94)) {
        ?>


            <li class="nav-item"><a style="padding: 28px 0px 0px 10px !important" class=" nav-link" href="<?php echo base_url(); ?>controller/index" data-remote="false"><i class="icon-note"></i><span>Kontroller</span></a></li>
            <li class="nav-item"><a style="padding: 28px 0px 0px 10px !important" class=" nav-link" href="<?php echo base_url(); ?>controller/envanter" data-remote="false"><i class="icon-note"></i><span>Envanter</span></a></li>
        <?php }

        ?>

        <li class="nav-item"><a style="padding: 28px 0px 0px 10px !important" class=" nav-link" href="<?php echo base_url(); ?>controller/personel_takip" data-remote="false"><i class="icon-note"></i><span>Personel Takip</span></a></li>
        <li class="nav-item"><a style="padding: 28px 0px 0px 10px !important" class=" nav-link" href="<?php echo base_url(); ?>roleapproval" data-remote="false"><i class="icon-note"></i><span>Roleapproval</span></a></li>
        <?php

        if ($this->aauth->premission(13)) {
        ?>
            <!--li class="dropdown mega-dropdown nav-item" data-menu="megamenu"><a class="dropdown-toggle nav-link"
                                                                                    href="#" data-toggle="dropdown"><i
                                class="ft-bar-chart-2"></i><span><?php echo $this->lang->line('back_yed'); ?></span></a>
                    <ul class="mega-dropdown-menu dropdown-menu row">
                        <li class="col-md-4" data-mega-col="col-md-3">
                            <ul class="drilldown-menu">
                                <li class="menu-list">
                                    <ul class="mega-menu-sub">
                                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>export/crm"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('Export People Data'); ?>
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item"
                                               href="<?php echo base_url(); ?>export/transactions"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('Export Transactions'); ?>
                                            </a></li>
                                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>export/products"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('Export Products'); ?>
                                            </a></li>

                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="col-md-4" data-mega-col="col-md-3">
                            <ul class="drilldown-menu">
                                <li class="menu-list">
                                    <ul class="mega-menu-sub">
                                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>export/account"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('Account Statements'); ?>
                                            </a></li>
                                        <li><a class="dropdown-item"
                                               href="<?php echo base_url(); ?>export/taxstatement"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Backup & Export'); ?>
                                            </a></li>
                                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>export/dbexport"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('Database Backup'); ?>
                                            </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="col-md-4" data-mega-col="col-md-3">
                            <ul class="drilldown-menu">
                                <li class="menu-list">
                                    <ul class="mega-menu-sub">
                                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>import/products"><i
                                                        class="fa fa-caret-right"></i></i><?php echo $this->lang->line('Import Products'); ?>
                                            </a></li>
                                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>import/customers"><i
                                                        class="fa fa-caret-right"></i><?php echo $this->lang->line('Import Customers'); ?>
                                            </a></li>
                                        <li><a  class="dropdown-item" href="<?php echo base_url(); ?>export/people_products"><i
                                                        class="fa fa-caret-right"></i> <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Account Statements'); ?>
                                            </a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li-->
        <?php }
        ?>

        </ul>
        </div>
        <!-- /horizontal menu content-->
    </div>


    <script>
        $(document).on('click', "#gunluk_gorusme", function(e) {
            e.preventDefault();

            $('#pop_model_gunluk').modal({
                backdrop: 'static',
                keyboard: false
            });
            var actionurl = 'invoices/randevu_bilgileri_gunluk';
            $.ajax({
                url: baseurl + actionurl,
                data: crsf_token + '=' + crsf_hash,
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    $('#view_object_gunluk').html(data);

                }

            });

        });
    </script>

    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        }
    </style>

    <script>
        $(function() {
            $('.select-box').select2();

            jQuery.ajax({
                url: baseurl + 'notification/all_count',
                type: 'POST',
                data: crsf_token + '=' + crsf_hash,
                dataType: 'json',
                success: function(data) {
                    if (data.status == "Success") {
                        $('#notification_').empty().html(data.count)
                    }
                },
                error: function(data) {

                }
            });
        })
    </script>

    <!-- Horizontal navigation-->
    <div id="c_body"></div>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">