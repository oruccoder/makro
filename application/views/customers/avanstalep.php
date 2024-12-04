<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4 class="card-title"><?php echo $this->lang->line('Customer Details') ?>
                : <?php echo $details['name'] ?></h4>
        </div>
        </div>
        </div>

        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>



            <div class="content">
                <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 border-right border-right-grey">


                        <div class="ibox-content mt-2">
                            <img alt="image" id="dpic" class="rounded-circle img-border height-150"
                                 src="<?php echo base_url('userfiles/customers/') . $details['picture'] ?>">
                        </div>
                        <hr>

                        <!-- Menü Ekle -->
                        <?php $this->load->view('customers/customer_menu'); ?>


                    </div>
                    <div class="col-md-10">
                        <div id="mybutton" class="mb-1">

                            <div class="">
                                <a href="<?php echo base_url('customers/balance?id=' . $details['id']) ?>"
                                   class="btn btn-success btn-md"><i
                                        class="fa fa-briefcase"></i> <?php echo $this->lang->line('Wallet') ?>
                                </a>
                                <a href="#sendMail" data-toggle="modal" data-remote="false"
                                   class="btn btn-primary btn-md " data-type="reminder"><i
                                        class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Message') ?>
                                </a>


                                <a href="<?php echo base_url('customers/edit?id=' . $details['id']) ?>"
                                   class="btn btn-info btn-md"><i
                                        class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Profile') ?>
                                </a>


                                <a href="<?php echo base_url('customers/changepassword?id=' . $details['id']) ?>"
                                   class="btn btn-danger btn-md"><i
                                        class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                </a>
                            </div>

                        </div>
                        <hr>



                        <table id="invoices" class="table table-striped table-bordered zero-configuration"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>

                                <th>Talep No</th>
                                <th>Oluşturma Tarihi</th>
                                <th class="no-sort">Toplam Fiyat</th>
                                <th class="no-sort">Durum</th>
                                <th class="no-sort">#</th>


                            </tr>
                            </thead>
                            <tbody>

                            <?php if($talepler)

                            {
                                foreach ($talepler as $item){

                                    $html='';
                                    if($item->cari_pers==2){
                                        $inv_id=$item->invoice_id;
                                        if($item->invoice_id){
                                            if($item->talep_or_invoice==1){
                                                $details =   invoice_details($item->invoice_id);
                                                $dec =$details->invoice_type_desc.' '.$details->invoice_no;
                                                if($details->invoice_type_id == 29 || $details->invoice_type_id == 30){
                                                    $href = "/invoices/print_form?id=".$inv_id;
                                                }
                                                else {
                                                    $href = "/invoices/printinvoice?id=".$inv_id;
                                                }
                                            }
                                            elseif($item->talep_or_invoice==3){

                                                $href = "/logistics/view/".$inv_id;
                                                $dec = "Lojistik Satınalma";
                                            }
                                            else {
                                                $details = talep_details($item->invoice_id);
                                                $dec=$details->talep_no;
                                                $href = "/form/satinalma_view?id=".$inv_id;
                                            }

                                           $html=' <a href="'.$href.'" class="btn btn-info">'.$dec.' Önizle</a>';
                                        }

                                        ?>

                                    <?php  }
                                    ?>
                                    <tr>
                                    <td><a class="btn btn-success" target="_blank" href="/form/avans_view?id=<?php echo $item->id?>"><?php echo $item->talep_no ?></a></td>
                                    <td><?php echo $item->olusturma_tarihi ?></td>
                                    <td><?php echo amountFormat($item->total) ?></td>
                                    <td><?php echo purchase_status($item->status)  ?></td>
                                    <td><?php echo  $html ?></td>
                                    </tr>
                                    <?php
                                }
                            }?>


                            </tbody>
                        </table>


                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>


