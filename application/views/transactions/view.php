<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Toplantılar</span></h4>
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
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <address>
                                            <?php $loc=location($trans['loc']); echo '<strong>' . $loc['cname'] . '</strong><br>' .
                                                $loc['address']. '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country']. ' -  ' . $loc['postbox'] . '<br> '.$this->lang->line('Phone').': ' . $loc['phone'] . '<br>  '.$this->lang->line('Email').': ' . $loc['email'] ;
                                            ?>


                                        </address>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                                        <address>
                                            <?php echo '<strong>' . $trans['payer'] . '</strong><br>' .
                                                $cdata['address'] . '<br>' . $cdata['city'] . '<br>' . $this->lang->line('Phone') . ': ' . $cdata['phone'] . '<br>  '.$this->lang->line('Email').': ' . $cdata['email']; ?>
                                        </address>
                                    </div>

                                </div>

                                <div class="row">
                                    <hr>

                                    <?php echo '<div class="col-xs-6 col-sm-6 col-md-6">
                    <p>Tutar : ' . amountFormat($trans['total'],$trans['para_birimi']) . ' </p>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>' . $this->lang->line('Date') . ' : ' . dateformat($trans['invoicedate']) . '</p><p>' . $this->lang->line('Transaction') . ' ID : ' .prefix(5) . $trans['id'] . '</p>
            </div><div class="col-xs-12 col-sm-12 col-md-12 ">
                    <p>' . $this->lang->line('Note') . ' : ' . $trans['notes'] . '</p>
            </div></div>'; ?>

                                    <?php if($trans['talep_id_finance']!=0){
                                        echo talep_detail($trans['talep_id_finance']);
                                    } ?>

                                </div>
                            </section>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


