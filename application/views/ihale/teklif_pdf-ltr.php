<div class="content-body">

   <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="thermal_a" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>

            <div class="content-body">
                <div id="invoice-template" class="card-body" style="    text-align: center;">


                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <img src="<?php  $loc=location($invoice['loc']);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                                 class="" style="max-height: 70px;"><br><br>
                            <p class="font_11"> <?php echo 'Talep Eden : ' . personel_details($invoice['emp_id']) . '</p>';?>
                            <p class="font_11">Teklif Talep Formu</p>
                            <p class="font_11"> <?php echo 'Talep No : '. $invoice['dosya_no'] . '</p>'; ?>

                        </div>

                    </div>
                    <!--/ Invoice Company Details -->


                    <!-- Invoice Items Details -->
                    <div id="invoice-items-details" class="pt-2">
                        <div class="row">
                            <div>
                                    <table class="table table-striped">
                                        <thead style="font-size: 9px;">

                                        <tr>
                                            <th>#</th>
                                            <th>Məhsulun Adı</th>
                                            <th class="text-center">Miqdarı</th>

                                            <?php if($_GET['oturum']!=1)
                                            {

                                                $old_q=intval($_GET['oturum'])-1;
                                                echo " <th class='text-center'>Əvvəlki Qiymət</th>";
                                                echo " <th class='text-center'>Yeni Qiymət</th>";
                                            }
                                            else
                                            {
                                                echo " <th class='text-center'>Qiymət</th>";
                                            }
                                            ?>
                                            <th>Göndərmə</th>
                                            <th>Ödəniş Tarixi</th>

                                        </tr>
                                        </thead>


                                        <tbody style="font-size: 11px;">

                                        <?php
                                        $c = 1;
                                        $i = 0;
                                        $sub_t = 0;
                                        $talep_id=$invoice['id'];


                                        foreach ($products as $row) {

                                       
                                            echo '<tr>
                                                    <td scope="row">' . $c . '</td>
                                                    <td>'. $row->product_name. '</td>             
                                                    <td>' . intval($row->product_qty) .' '. $row->unit . '</td>       
                                                    ';
                                            if($_GET['oturum']!=1)
                                            {
                                                $old_q=intval($_GET['oturum'])-1;
                                                $old_price = amountFormat(ihale_fiyat_bul($firma_id,$row->item_id,$old_q,$tid));
                                                echo "<td>$old_price</td>";
                                                echo "<td>-</td>";
                                            }
                                            else
                                            {
                                                echo '<td>-</td>';
                                            }
                                            echo '           
           
                                                    <td>Dahil-Hariç</td>
                                                     <td>-</td>                 
                                                    <input type="hidden" class="item_id" name="item_id[]" value="'.$row->id.'">
                                                    <input type="hidden" class="oturum" name="oturum[]" value="'.$oturum.'">
                                                    <input type="hidden" class="talep_id" name="talep_id[]" value="'.$talep_id.'">
                                                    <input type="hidden" class="pers_id" name="pers_id[]" value="'.$_GET['pers_id'].'">
                                                </tr>';


                                            $c++;
                                                $i++;

                                        }
                                        ?>



                                        </tbody>

                                    </table>
                            </div>
                        </div>
                        <style>
                            .table th, .table td
                            {
                                padding: 7px !important;
                            }
                            .mt-2, .my-2
                            {
                                margin-top: 0 !important;
                            }
                            .font_11
                            {
                                font-size: 11px;
                            }
                        </style>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>





