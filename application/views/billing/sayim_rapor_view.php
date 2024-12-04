<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">


                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-0">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="img-responsive " style="max-height: 80px;">


                            <ul class="px-0 list-unstyled">
                                <?php

                                echo '<li class="text-bold-800">' . $loc['cname'] . '</li><li>' . $loc['address'] . '</li><li>' . $loc['city'] . ',</li><li>' . $loc['region'] . ',' . $loc['country'] . ' -  ' . $loc['postbox'] . '</li><li>'.$this->lang->line('Phone').' : ' . $loc['phone'] . '</li><li> '.$this->lang->line('Email').' : ' . $loc['email']  ?>
                                </li>
                                <?php $date_text=$this->lang->line('Due Date');
                                echo '<p><span class="text-muted">Sayım Tarihi :</span> ' . dateformat($invoice['invoicedate']) . '</p> ';

                                ?>

                                <?php $validtoken = hash_hmac('ripemd160', 'p' .  $_GET['id'], $this->config->item('encryption_key')); ?>
                                <p><a href="/billing/onay?sayim_id=<?php echo $_GET['id']?>&token=<?php echo $validtoken; ?>" class="btn btn-success">Onayla</a></p>
                                <p><a href="/billing/onay_red?sayim_id=<?php echo $_GET['id']?>&token=<?php echo $validtoken; ?>" class="btn btn-warning">Onaylama</a></p>
                            </ul>
                        </div>

                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right mt-2">

                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800"><strong
                                        class="invoice_a"><?php echo $invoice['name'] . '</strong></li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ', ' . $invoice['region'] . '</li><li>' . $invoice['country'] . ', ' . $invoice['postbox'] . '</li><li>'.$this->lang->line('Phone').' : ' . $invoice['phone'] . '</li><li>'.$this->lang->line('Email').' : ' . $invoice['email']; ?>
                                </li>
                            </ul>

                        </div>

                    </div>

                    <!--/ Invoice Company Details -->



                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div class="table-responsive col-sm-12">
                                <table class="table table-striped">
                                    <thead>

                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Item Name') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Sayim_Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Sip_Qty') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;

                                    foreach ($products as $row) {

                                        echo '<tr>
                            <th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td> 
                             <td>' . +$row['qty'].$row['unit'] . '</td>
                             <td>' . +$row['siparis_qty'].$row['unit'] . '</td>
                              
                        </tr>';


                                        $c++;
                                    } ?>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <p></p>

                    </div>

                    <!-- Invoice Footer -->

                    <div id="invoice-footer">





                    </div>
                    <!--/ Invoice Footer -->

                </div>
            </section>
        </div>
    </div>
</div>

