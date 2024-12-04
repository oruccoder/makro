<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Hesaplar</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-lg-0">
            <a href="<?php echo base_url('accounts/add') ?>" class="btn btn-primary btn-sm rounded">
                <i class="fa fa-plus" aria-hidden="true" title="Yeni Ekle"></i></a>
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
                                    <div class="col-12 mb-4">
                                        <table id="invoices" class="table datatable-show-all" cellspacing="0"
                                               width="100%">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>Hesap Tipi</th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1;
                                            foreach (account_type() as $ac_type) {

                                                $name=$ac_type['name'];
                                                echo "<tr data-toggle='collapse' data-target='#demo-$i' class='accordion-toggle'>
                                                <td><button class='btn btn-default btn-xs'><span class='fa fa-eye'></span></button></td>
                                                <td>$i</td>
                                                <td>$name</td>
                                                </tr>

                            <tr>
                                <td colspan='12' class='hiddenRow'>
                                    <div class='accordian-body collapse' id='demo-$i'>
                                        <table  class='table table-striped table-bordered zero-configuration' cellspacing='0' width='100%'>
                                              <thead>
                                                <tr>
                                                    <th width='20%' >#</th>
                                                    <th width='20%'>".$this->lang->line('Account No')."</th>
                                                    <th width='20%'>".$this->lang->line('Name')."</th>
                                                    <th width='20%'>".$this->lang->line('Balance')."</th>
                                                    <th width='20%'>".$this->lang->line('Actions')."</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                            ";

                                                foreach ($accounts as $row) {
                                                    $aid = $row['id'];
                                                    $acn = $row['acn'];
                                                    $holder = $row['holder'];
                                                    $account_type_id = $row['account_type'];
                                                    $balance = amountFormat(new_balace($aid)['bakiye'],$row['para_birimi']);
                                                    //$balance = amountFormat(new_balace($aid),$row['para_birimi']); //amountFormat($row['lastbal']);
                                                    $qty = $row['adate'];
                                                    $style=new_balace($aid)['style'];

                                                    if($account_type_id==$ac_type['id'])
                                                    {
                                                        //$kasa_id=array(46,45,44,36,37);
														$kasa_id=array(84,85,86,91);
						
                                                        if(in_array($aid,$kasa_id))
                                                        {
                                                            //$typee=array(21,39,61,62);
															$typee=array(21,61,62);
                                                            $kullanici=$this->aauth->get_user()->id;
                                                            if (in_array($kullanici, $typee)) {

                                                                echo "

                                                <tr>
                                                    <td width='20%'>$i</td>
                                                    <td width='20%'>$acn</td>
                                                    <td width='20%'>$holder</td>
                                                    <td width='20%'style='".$style."'>$balance</td>
                                                    <td width='20%'><a href='" . base_url("accounts/view?id=$aid") . "' class='btn btn-success btn-xs'><i class='icon-file-text'></i>  ".$this->lang->line('View')."</a>&nbsp;<a href='" . base_url("accounts/edit?id=$aid") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i>  ".$this->lang->line('Edit')."</a></td>
                                                </tr>

                            ";
                                                            }
                                                            else
                                                            {
                                                                continue;
                                                            }

                                                        }
                                                        else
                                                        {
                                                            echo "

                                                <tr>
                                                    <td width='20%'>$i</td>
                                                    <td width='20%'>$acn</td>
                                                    <td width='20%'>$holder</td>
                                                      <td width='20%'style='".$style."'>$balance</td>
                                                    <td width='20%'><a href='" . base_url("accounts/view?id=$aid") . "' class='btn btn-success btn-xs'><i class='icon-file-text'></i>  ".$this->lang->line('View')."</a>&nbsp;<a href='" . base_url("accounts/edit?id=$aid") . "' class='btn btn-warning btn-xs'><i class='icon-pencil'></i>  ".$this->lang->line('Edit')."</a>&nbsp;</td>
                                                </tr>

                            ";
                                                        }





                                                    }
                                                }
                                                $i++;
                                                echo " </tbody>
                                        </table>

                                      </div>
                                  </td>
                            </tr>";
                                            }

                                            ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>Hesap Tipi</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<input type="hidden" id="dashurl" value="accounts/account_stats">
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#acctable').DataTable({});
        miniDash();

    });
</script>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Account') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('Delete account message') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="accounts/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
