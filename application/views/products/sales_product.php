<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 5.12.2019
 * Time: 19:35
 */
?>

<div class="content-body">

    <div class="card">
        <div class="card-header">
            <h5><?php echo $title; ?></h5>


            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>


        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="card-body">
                <table id="productstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                        <tr>
                            <th>Ürün Adı</th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th>Cari</th>
                            <th>Ft. No</th>
                            <th>Tip</th>
                            <th>Alış Miktarı</th>
                            <th>Alış Birim Fiyatı</th>
                            <th>Alış Tutarı</th>
                            <th>Çıkan Tutar</th>
                            <th>Satış Birim Fiyatı</th>
                            <th>Satış Tutarı</th>
                            <th>Mevcut Stok</th>
                        </tr>
                    <?php
                    $total=0;
                    $urunler=satis_hesapla($product_id);
                    if(isset($urunler))
                    {
                    foreach (satis_hesapla($product_id) as $prd_stss) {
                        foreach ($prd_stss as $prd_sts) { ?>

                        <tr>
                            <td><?php echo $prd_sts['product_name'] ?></td>
                            <td><?php echo dateformat($prd_sts['invoicedate']) ?></td>
                            <td><?php echo $prd_sts['company'] ?></td>
                            <td><?php echo $prd_sts['tid'] ?></td>
                            <td><?php echo $prd_sts['invoice_type_desc'] ?></td>
                            <?php if($prd_sts['invoice_type_desc']=='Alış Faturası'
                                || $prd_sts['invoice_type_desc']=='Giriş Fişi') { ?>

                            <td><?php echo floatval($prd_sts['qty']).' '.product_unit($prd_sts['pid']) ?></td>
                                <td><?php echo amountFormat($prd_sts['price']) ?></td>
                                <td><?php echo amountFormat($prd_sts['subtotal']) ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php }

                            else { ?>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><?php echo floatval($prd_sts['qty']).' '.product_unit($prd_sts['pid'])  ?></td>
                                <td><?php echo amountFormat($prd_sts['price']) ?></td>
                                <td><?php echo amountFormat($prd_sts['subtotal']) ?></td>
                            <?php } ?>

                            <?php if($prd_sts['invoice_type_desc']=='Alış Faturası' ||
                                $prd_sts['invoice_type_desc']=='Giriş Fişi'){
                            $total+=$prd_sts['qty'];
                             }
                            else {
                                $total-=$prd_sts['qty'];
                             } ?>
                            <td><?php echo floatval($total).' '.product_unit($prd_sts['pid']) ; ?></td>
                        </tr>
                    <?php  } ?>
                    <?php }  }?>
                    </thead>
                    <tbody>
                    </tbody>

                </table>
            </div>
            <input type="hidden" id="dashurl" value="products/prd_stats">
        </div>
    </div>

    <style>
        @media (min-width: 992px)
        {
            .modal-lg {
                max-width: 80% !important;
            }
        }

    </style>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this product') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="products/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>

    <div id="view_model" class="modal  fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
                </div>
                <div class="modal-body" id="view_object">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="view-object-id" value="">
                    <input type="hidden" id="view-action-url" value="products/view_over">

                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Close') ?></button>
                </div>
            </div>
        </div>
    </div>

