<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>İtalic Soft</title >";
    }
    ?>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url(); ?>assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/bootstrap.css'); ?>">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/icomoon.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/bootstrap-extended.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/app.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/colors.css'); ?>">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/core/menu/menu-types/vertical-overlay-menu.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url('assets/' . LTR . '/core/colors/palette-gradient.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/jquery.dataTables.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/summernote-bs4.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/select2.min.css') . APPVER; ?>">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" href="<?php echo base_url('assets/tooltipster/css/tooltipster.bundle.min.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/style.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/' . LTR . '/custom.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/custom/style.css') . APPVER; ?>">
    <!-- END Custom CSS-->

    <script src="<?php echo base_url(); ?>assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url(); ?>assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url(); ?>assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/portjs/morris.min.js" type="text/javascript"></script>


    <script src="<?php echo base_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>
    <script src="<?php echo base_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>


    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var  crsf_token='<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash='<?=$this->security->get_csrf_hash(); ?>';
    </script>
    <script src="<?php echo base_url('assets/tooltipster/js/tooltipster.bundle.min.js') . APPVER; ?>"></script>
    <script>
        $(document).ready(function () {
            $('.t_tooltip').tooltipster();

        });
    </script>
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns"
      class="vertical-layout vertical-menu 2-columns  fixed-navbar"><span id="hdata"
                                                                          data-df="<?php echo $this->config->item('dformat2'); ?>"
                                                                          data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>

<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a
                        class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a>
                </li>
                <li class="nav-item"><a href="<?php echo base_url() ?>dashboard/" class="navbar-brand nav-link"><img
                            alt="branding logo" src="<?php echo base_url(); ?>userfiles/theme/logo-header.png"
                            data-expand="<?php echo base_url(); ?>userfiles/theme/logo-header.png"
                            data-collapse="<?php echo base_url(); ?>assets/images/logo/logo-80x80.png"
                            class="brand-logo height-50"></a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile"
                                                                    class="nav-link open-navbar-container"><i
                            class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                    <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                class="icon-menu5"> </i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i
                                class="icon icon-expand2"></i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="<?= base_url() ?>pos_invoices/create"
                                                           class="btn btn-success upgrade-to-pro t_tooltip"
                                                           title="Access POS"><i
                                class="icon icon-bag"></i><?php echo $this->lang->line('POS') ?> </a> &nbsp; &nbsp;
                    </li>
                    <li class="nav-item hidden-sm-down"><input type="text"
                                                               placeholder="<?php echo $this->lang->line('Search Customer') ?>"
                                                               id="head-customerbox"
                                                               class="nav-link menu-search form-control round"/></li>
                </ul>
                <div id="head-customerbox-result" class="dropdown dropdown-notification"></div>
                <ul class="nav navbar-nav float-xs-right">

                    <li class="dropdown dropdown-language nav-item"><a class="nav-link t_tooltip"
                                                                       title="Şirketiniz"><i
                                class="icon-location22"></i><span
                                class="selected-language"><?php $loc = location($this->aauth->get_user()->loc);
                                echo $loc['cname']; ?></span></a>

                    </li>

                    <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown"
                                                                           class="nav-link nav-link-label"><i
                                class="ficon icon-bell4"></i><span
                                class="tag tag-pill tag-default tag-danger tag-default tag-up"
                                id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                        class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span>
                                </h6>
                            </li>
                            <li class="list-group scrollable-container" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a href="<?php echo base_url('manager/todo') ?>"
                                                                class="dropdown-item text-muted text-xs-center"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown"
                                                                           class="nav-link nav-link-label"><i
                                class="ficon icon-mail6"></i><span
                                class="tag tag-pill tag-default tag-info tag-default tag-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                        class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span>
                                </h6>
                            </li>
                            <li class="list-group scrollable-container">


                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>

                            </li>
                            <li class="dropdown-menu-footer"><a href="<?php echo base_url('messages') ?>"
                                                                class="dropdown-item text-muted text-xs-center"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown"
                                                                   class="dropdown-toggle nav-link dropdown-user-link"><span
                                class="avatar avatar-online"><img
                                    src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                    alt="avatar"><i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a href="<?php echo base_url(); ?>user/profile"
                                                                          class="dropdown-item"><i
                                    class="icon-head"></i><?php echo $this->lang->line('Profile') ?></a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>user/attendance"
                               class="dropdown-item"><i
                                    class="icon-timeline"></i><?php echo $this->lang->line('Attendance') ?></a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url(); ?>user/holidays"
                               class="dropdown-item"><i
                                    class="icon-house"></i><?php echo $this->lang->line('Holidays') ?></a>
                            <div class="dropdown-divider"></div>

                            <a href="<?php echo base_url('user/logout'); ?>" class="dropdown-item"><i
                                    class="icon-power3"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-static menu-dark menu-accordion menu-shadow" id="side">
    <!-- main menu header-->
    <div class="main-menu-header">
        <div>
            <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle "
                                 src="<?php echo base_url('userfiles/employee/' . $this->aauth->get_user()->picture) ?>">
                             </span>
                <a data-toggle="dropdown" class="dropdown-toggle block" href="#" aria-expanded="false">
                    <span class="clear white">  <span
                            class="text-xs"><?php echo user_role($this->aauth->get_user()->roleid); ?><b
                                class="caret"></b></span> </span> </a>
                <ul class="dropdown-menu animated m-t-xs">
                    <li>
                        <a href="<?php echo base_url() . 'user/profile">&nbsp;(' . $this->aauth->get_user()->username; ?>)</a></li>

                      <li class=" divider">
                    </li>
                    <li>
                        <a href="<?php echo base_url('user/logout'); ?>">&nbsp;<?php echo $this->lang->line('Logout'); ?></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">

            <li class="nav-item <?php if ($this->uri->segment(1) == "dashboard") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>dashboard/"> <i class="icon-dashboard"></i><span
                        class="menu-title"> <?php echo $this->lang->line('Dashboard') ?></span></a>
            </li>
            <?php


            if ($this->aauth->premission(1)) { ?>
                <li class="navigation-header"><span
                        data-i18n="nav.category.support"> <?php echo $this->lang->line('sales') ?></span><i
                        data-toggle="tooltip"
                        data-placement="right"
                        data-original-title="Sales"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "pos_invoices") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-rocket"></i> <span
                            class="menu-title"><?php echo $this->lang->line('pos sales') ?>
                            <i
                                class="icon-arrow"></i></span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>pos_invoices/create"><?php echo $this->lang->line('New Invoice'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>pos_invoices/create?v2=true"><?php echo $this->lang->line('New Invoice'); ?> v2</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>pos_invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "invoices" OR $this->uri->segment(1) == "quote") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-plus"></i> <span
                            class="menu-title"><?php echo $this->lang->line('sales') ?>
                            <i
                                class="icon-arrow"></i></span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>invoices/create"><?php echo $this->lang->line('New Invoice'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>quote/create"><?php echo $this->lang->line('New Quote'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>quote"><?php echo $this->lang->line('Manage Quotes'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>stockreturn/creditnotes"><?php echo $this->lang->line('Credit Notes'); ?></a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "subscriptions") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-android-calendar"></i> <span
                            class="menu-title"><?php echo $this->lang->line('Subscriptions') ?>
                            <i
                                class="icon-arrow"></i></span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>subscriptions/create"><?php echo $this->lang->line('New Subscription'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>subscriptions"><?php echo $this->lang->line('Subscriptions'); ?></a>
                        </li>

                    </ul>
                </li>


            <?php }
            if ($this->aauth->premission(2)) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('Stock') ?></span><i
                        data-toggle="tooltip" data-placement="right"
                        data-original-title="Stock"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "products") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-truck2"></i><span
                            class="menu-title"><?php echo $this->lang->line('Items Manager') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>products/add"><?php echo $this->lang->line('New Product') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>products"><?php echo $this->lang->line('Manage Products') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>productcategory"><?php echo $this->lang->line('Product Categories') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>productcategory/warehouse"><?php echo $this->lang->line('Warehouses') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>products/stock_transfer"><?php echo $this->lang->line('Stock Transfer') ?></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "purchase") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Purchase Order') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>purchase/create"><?php echo $this->lang->line('New Order') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>purchase"><?php echo $this->lang->line('Manage Orders') ?></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "stockreturn") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-share-square-o"></i> <span
                            class="menu-title"><?php echo $this->lang->line('Stock Return') ?>
                            <i
                                class="icon-arrow"></i></span></a>
                    <ul class="menu-content">

                        <li>
                            <a href="<?php echo base_url(); ?>stockreturn"><?php echo $this->lang->line('Suppliers') . ' ' . $this->lang->line('Records'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>stockreturn/customer"><?php echo $this->lang->line('Customers') . ' ' . $this->lang->line('Records'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>stockreturn/creditnotes"><?php echo $this->lang->line('Credit Notes'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(3)) {
                ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('CRM') ?></span><i
                        data-toggle="tooltip" data-placement="right"
                        data-original-title="CRM"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "customers") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-group"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Clients') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>customers/create"><?php echo $this->lang->line('New Client') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>customers"><?php echo $this->lang->line('Manage Clients') ?></a>
                        <li>
                            <a href="<?php echo base_url(); ?>clientgroup"><?php echo $this->lang->line('Manage Groups') ?></a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "tickets") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-ticket"></i><span
                            class="menu-title"><?php echo $this->lang->line('Support Tickets') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>tickets/?filter=unsolved"><?php echo $this->lang->line('UnSolved') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>tickets"><?php echo $this->lang->line('Manage Tickets') ?></a>
                        </li>


                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(2)) { ?>

                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "supplier") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-ios-people"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Suppliers') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>supplier/create"><?php echo $this->lang->line('New Supplier') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>supplier"><?php echo $this->lang->line('Manage Suppliers') ?></a>
                        </li>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(4)) { ?>
                <!---------------- Start Project ----------------->
                <li class="navigation-header"><span><?php echo $this->lang->line('Project') ?></span><i
                        data-toggle="tooltip" data-placement="right"
                        data-original-title="Balance"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "projects") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Project Management') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>projects/addproject"><?php echo $this->lang->line('New Project') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>projects"><?php echo $this->lang->line('Manage Projects') ?></a>
                        </li>
                    </ul>
                </li>
                <li><a href="<?php echo base_url(); ?>tools/todo"><i class="icon-android-done-all"></i><span
                            class="menu-title"> <?php echo $this->lang->line('To Do List') ?></span></a></li>

            <?php }
            if (!$this->aauth->premission(4) && $this->aauth->premission(7)) {

                echo '     <li class="navigation-header"><span>'.$this->lang->line('Project').'</span><i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Balance"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li> <li><a href="'.base_url().'manager/projects"><i class="icon-presentation"></i><span
                                class="menu-title"> '.$this->lang->line('Manage Projects').'</span></a></li>   <li><a href="'.base_url().'manager/todo"><i class="icon-android-done-all"></i><span
                                class="menu-title"> '.$this->lang->line('To Do List').'</span></a></li>';
            }
            if ($this->aauth->premission(5)) { ?>
                <!---------------- end project ----------------->
                <li class="navigation-header"><span><?php echo $this->lang->line('Balance') ?></span><i
                        data-toggle="tooltip" data-placement="right"
                        data-original-title="Balance"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "accounts") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-bank"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Accounts') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>accounts"><?php echo $this->lang->line('Manage Accounts') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>accounts/balancesheet"><?php echo $this->lang->line('BalanceSheet') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/accountstatement"><?php echo $this->lang->line('Account Statements') ?></a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "transactions") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-exchange"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Transactions') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>transactions"><?php echo $this->lang->line('View Transactions') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/add"><?php echo $this->lang->line('New Transaction') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/transfer"><?php echo $this->lang->line('New Transfer') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/income"><?php echo $this->lang->line('Income'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>transactions/expense"><?php echo $this->lang->line('Expense') ?></a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "promo") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-diamond2"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Promo Codes') ?>
                            /<?php echo $this->lang->line('Coupons') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>promo/create"><?php echo $this->lang->line('New Promo') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>promo"><?php echo $this->lang->line('Manage Promo') ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(6)) { ?>
                <li class="navigation-header"><span><?php echo $this->lang->line('Miscellaneous') ?></span><i
                        data-toggle="tooltip" data-placement="right"
                        data-original-title="Miscellaneous"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>


                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "reports") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-file-archive-o"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Data & Reports') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>reports/statistics"><?php echo $this->lang->line('Statistics') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/profitstatement"><?php echo $this->lang->line('Profit') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>reports/accountstatement"><?php echo $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/customerstatement"><?php echo $this->lang->line('Customer') . ' ' . $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/supplierstatement"><?php echo $this->lang->line('Supplier') . ' ' . $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/incomestatement"><?php echo $this->lang->line('Calculate Income'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/expensestatement"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>customers"><?php echo $this->lang->line('Clients Transactions') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/taxstatement"><?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Statements'); ?> </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>reports/sales"><?php echo $this->lang->line('Sales') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>reports/products"><?php echo $this->lang->line('Products') ?></a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "chart") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-pie-chart2"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Graphical Reports') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>chart/product_cat"><?php echo $this->lang->line('Product Categories') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>chart/trending_products"><?php echo $this->lang->line('Trending Products') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>chart/profit"><?php echo $this->lang->line('Profit') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>chart/topcustomers"><?php echo $this->lang->line('Top') . ' ' . $this->lang->line('Customers') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>chart/incvsexp"><?php echo $this->lang->line('Income') . ' vs ' . $this->lang->line('Expenses') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>chart/income"><?php echo $this->lang->line('Income') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>chart/expenses"><?php echo $this->lang->line('Expenses') ?></a>
                        </li>

                    </ul>
                </li>


                <li><a href="<?php echo base_url(); ?>tools/notes"><i class="icon-android-clipboard"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Notes') ?></span></a></li>


                <li><a href="<?php echo base_url(); ?>events"><i class="icon-calendar2"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Calendar') ?></span></a></li>
                <li><a href="<?php echo base_url(); ?>tools/documents"><i class="icon-android-download"></i><span
                            class="menu-title"><?php echo $this->lang->line('Documents') ?></span></a></li>

            <?php }   if ($this->aauth->premission(9)) { ?>

                <li class="navigation-header"><span><?php echo $this->lang->line('HRM') ?></span><i
                        data-toggle="tooltip" data-placement="right"
                        data-original-title="Miscellaneous"
                        class="icon-ellipsis icon-ellipsis"></i>
                </li>

                <li class="nav-item has-sub  <?php if ($this->li_a == "emp") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-users"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Employees') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>employee"><?php echo $this->lang->line('Employees') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>employee/permissions"><?php echo $this->lang->line('Permissions') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>employee/salaries"><?php echo $this->lang->line('Salaries') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>employee/attendances"><?php echo $this->lang->line('Attendance') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>employee/holidays"><?php echo $this->lang->line('Holidays') ?></a>
                        </li>


                    </ul>
                </li>

                <li><a href="<?php echo base_url(); ?>employee/departments"><i class="icon-office"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Departments') ?></span></a></li>

                <!--<li><a href="<?php echo base_url(); ?>events"><i class="icon-box"></i><span
                                class="menu-title"> <?php echo $this->lang->line('Designations') ?></span></a></li>-->

                <li><a href="<?php echo base_url(); ?>employee/payroll"><i class="icon-money"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Payroll') ?></span></a></li>

            <?php  } if ($this->aauth->get_user()->roleid > 4) { ?>
                <li class="navigation-header"><span>Configure</span><i data-toggle="tooltip" data-placement="right"
                                                                       data-original-title="Configure"
                                                                       class="icon-ellipsis icon-ellipsis"></i>
                </li>
                <li class="nav-item has-sub <?php if ($this->li_a == "settings") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-cog"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Settings') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>settings/company"><?php echo $this->lang->line('Company'); ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>settings/language">Languages</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>settings/dtformat"><?php echo $this->lang->line('Date & Time Format') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>transactions/categories"><?php echo $this->lang->line('Transaction Categories') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>tools/setgoals"><?php echo $this->lang->line('Set Goals') ?></a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>restapi"><?php echo $this->lang->line('REST API') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/email"><?php echo $this->lang->line('Email Config') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>cronjob"><?php echo $this->lang->line('Automatic Corn Job') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/recaptcha"><?php echo $this->lang->line('Security') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/theme"><?php echo $this->lang->line('Theme') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/tickets"><?php echo $this->lang->line('Support Tickets') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/about"><?php echo $this->lang->line('About') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>webupdate">Update</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/logdata">Log</a>
                        </li>
                        <!--slbs-->


                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->li_a == "billing") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-book"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Billing') . ' ' . $this->lang->line('Settings') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">

                        <li>
                            <a href="<?php echo base_url(); ?>settings/currency"><?php echo $this->lang->line('Currency') ?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>settings/discship"><?php echo $this->lang->line('Discount').' & '.$this->lang->line('Shipping')?></a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>settings/prefix"><?php echo $this->lang->line('Prefix') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/billing_terms"><?php echo $this->lang->line('Billing Terms') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/automail"><?php echo $this->lang->line('Auto Email SMS') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/warehouse"><?php echo $this->lang->line('Default').' '.$this->lang->line('Warehouse') ?></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->li_a == "tax") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-android-bulb"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>settings/tax"><?php echo $this->lang->line('Tax') ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>settings/taxslabs"><?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?></a>
                        </li>


                    </ul>
                </li>

                <li class="nav-item has-sub  <?php if ($this->uri->segment(1) == "units") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-product-hunt"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Settings') ?></span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>units"><?php echo $this->lang->line('Measurement Unit') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>units/variations"><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>units/variables"><?php echo $this->lang->line('Variations') . ' ' . $this->lang->line('Variables') ?></a>
                        </li>

                    </ul>
                </li>





                <li><a href="<?php echo base_url(); ?>locations"><i class="icon-location22"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Business Locations') ?></span></a>
                </li>
                <li><a href="<?php echo base_url(); ?>register"><i class="icon-books"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Business Registers') ?></span></a>
                </li>

                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "paymentgateways") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-cc"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Payment Settings') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/settings"><?php echo $this->lang->line('Payment Settings') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways"><?php echo $this->lang->line('Payment Gateways') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/currencies"><?php echo $this->lang->line('Payment Currencies') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/exchange"><?php echo $this->lang->line('Currency Exchange') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/bank_accounts"><?php echo $this->lang->line('Bank Accounts') ?></a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "plugins") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-anchor"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Plugins') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/recaptcha">reCaptcha Security</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/shortner">URL Shortener</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>plugins/twilio">Twilio SMS</a>
                        </li>

                        <li>
                            <a href="<?php echo base_url(); ?>paymentgateways/exchange">Currency Exchange API</a>
                        </li>
                        <?php plugins_checker(); ?>



                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "templates") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-table3"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Templates') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>templates/email"><?php echo $this->lang->line('Email') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>templates/sms">SMS</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>settings/theme"><?php echo $this->lang->line('Theme') ?></a>
                        </li>


                    </ul>
                </li>
                <li class="navigation-header"><span><?php echo $this->lang->line('Backup & Export') . '-' . $this->lang->line('Import'); ?>
                        <i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Export"
                            class="icon-ellipsis icon-ellipsis"></i>
                </li>


                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "export") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-database"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Export Data') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>export/crm"><?php echo $this->lang->line('Export People Data'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/transactions"><?php echo $this->lang->line('Export Transactions'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/products"><?php echo $this->lang->line('Export Products'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/account"><?php echo $this->lang->line('Account Statements') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/dbexport"><?php echo $this->lang->line('Database Backup'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>export/taxstatement"><?php echo $this->lang->line('TAX'); ?>
                                Statements</a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "import") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-road2"></i><span
                            class="menu-title"> <?php echo $this->lang->line('Import') ?> </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>import/products"><?php echo $this->lang->line('Import Products'); ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>import/customers"><?php echo $this->lang->line('Import Customers'); ?></a>
                        </li>


                    </ul>
                </li>
                <li class="navigation-header"><span>Printer Config
                        <i
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="Printer"
                            class="icon-ellipsis "></i>
                <li class="nav-item has-sub <?php if ($this->uri->segment(1) == "printer") {
                    echo ' open';
                } ?>">
                    <a href=""> <i class="icon-printer2"></i><span
                            class="menu-title"> Printers </span><i
                            class="fa arrow"></i> </a>
                    <ul class="menu-content">
                        <li>
                            <a href="<?php echo base_url(); ?>printer/add">Add Printer</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>printer/">List Printers</a>
                        </li>


                    </ul>
                </li>
                </li>
            <?php } ?>


        </ul>
    </div>
    <!-- /main menu content-->
    <!-- main menu footer-->
    <!-- include includes/menu-footer-->
    <!-- main menu footer-->
    <div id="rough"></div>
</div>
<!-- / main menu-->