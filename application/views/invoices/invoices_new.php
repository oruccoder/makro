<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Ürünler</span></h4>
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
                        <form action="#">
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <select class="form-control select2" id="category_id_search">
                                            <option value="0">Ürün Grupları</option>
                                            <?php foreach (all_categories() as $row)
                                            {
                                                echo "<option value='$row->id'>$row->title</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid">
                            <section>
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <table id="product_table" class="table datatable-show-all">
                                            <thead>
                                            <tr>
                                                <td>#</td>
                                                <th width="130">Cari</th>
                                                <th>Forma2 No</th>
                                                <th>FORMA2 NET TOPLAM</th>
                                                <th>KDV Durumu</th>
                                                <th>KDV Oranı</th>
                                                <th>KDV Toplamı</th>
                                                <th>Genel Toplam / Caride Gözüken</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($invoices as $items){
                                                    ?>
                                                    <tr>
                                                        <td><?php  echo  $items->id ?></td>
                                                        <td><?php  echo  $items->payer ?></td>
                                                        <td><?php  echo  $items->invoice_no ?></td>
                                                        <td><?php  echo  amountFormat_s($items->subtotal); ?></td>
                                                        <td><?php  echo  $items->taxstatus; ?></td>
                                                        <td><?php  echo  amountFormat_s($items->tax_oran); ?></td>
                                                        <td><?php  echo  amountFormat_s($items->tax); ?></td>
                                                        <td><?php  echo  amountFormat_s($items->total) ?></td>
                                                        <td><button class="duzenle btn btn-success"
                                                                    total="<?php echo $items->total; ?>"
                                                                    tax="<?php echo $items->tax; ?>"
                                                                    tax_oran="<?php echo $items->tax_oran; ?>"
                                                                    taxstatus="<?php echo $items->taxstatus; ?>"
                                                                    subtotal="<?php echo $items->subtotal; ?>"
                                                                    invoice_id="<?php echo $items->id;?>"

                                                            >Düzenle</button></td>


                                                    </tr>
                                                    <?php
                                                } ?>
                                            </tbody>
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

<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>

    $(document).on('click','.duzenle',function (){
        let total = $(this).attr('total');
        let tax = $(this).attr('tax');
        let tax_oran = $(this).attr('tax_oran');
        let taxstatus = $(this).attr('taxstatus');
        let subtotal = $(this).attr('subtotal');
        let invoice_id = $(this).attr('invoice_id');
        $.confirm({
            theme: 'modern',
            closeIcon: false,
            title: 'Düzenle',
            icon: 'fa fa-plus-square 3x',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-4 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
                            <div class='mb-3'>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                       <label>Forma 2 Net Toplam</label>
                                       <input type="text" class='form-control subtotal' value="`+subtotal+`">
                                    </div>
 <div class="form-group col-md-6">
                                       <label>KDV Durumu</label>
                                      <select class="form-control taxstatus" name="taxstatus">
<option value="0">Varsayılan</option>
<option value="yes">KDV Dahil</option>
<option value="no">KDV Hariç</option>
</select>
                                    </div>
 <div class="form-group col-md-6">
                                       <label>KDV Oranı</label>
                                       <input type="text" class='form-control tax_oran' value="`+tax_oran+`">
                                    </div>
 <div class="form-group col-md-6">
                                       <label>KDV Toplamı</label>
                                       <input type="text" class='form-control tax' value="`+tax+`">
                                    </div>

 <div class="form-group col-md-6">
                                       <label>Genel Toplam</label>
                                       <input type="text" class='form-control total' value="`+total+`">
                                    </div>
                            </div>

 <div class="form-group col-md-6">
                                       <label>Listeden Kaldır</label>
                                       <input type="checkbox" class='form-control visable' name="visable">
                                    </div>
                            </div>

                            `,
            buttons: {
                formSubmit: {
                    text: 'Gondər',
                    btnClass: 'btn-blue',
                    action: function() {

                        let visable =$('.visable').is(':checked')?0:1;

                        let data_post = {
                            visable: visable,
                            invoice_id: invoice_id,
                            total: $('.total').val(),
                            tax: $('.tax').val(),
                            tax_oran: $('.tax_oran').val(),
                            taxstatus: $('.taxstatus').val(),
                            subtotal: $('.subtotal').val(),
                        }

                        $.post(baseurl + 'invoices/short_edit', data_post, (response) => {
                            let data = jQuery.parseJSON(response);
                            if (data.status == 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: data.message,
                                    buttons: {
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                            action: function() {
                                                window.location.reload();
                                            }
                                        }
                                    }
                                });

                            } else if (data.status == 410) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: data.message,
                                    buttons: {
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
                cancel: {
                    text: 'İmtina et',
                    btnClass: "btn btn-danger btn-sm",
                    action: function() {
                        table_product_id_ar = [];
                    }
                }
            },
            onContentReady: function() {

                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function(e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    })
</script>
