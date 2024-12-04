<form method="post" id="form_invoice_details">

    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('unvan') ?></label>
            <input class="form-control" name="unvan_invoice" value="<?php echo $details['unvan_invoice'] ?>"  placeholder="Ev,İş vs.">

        </div>
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Country') ?></label>
            <input class="form-control" name="country_invoice" value="<?php echo $details['country_invoice'] ?>">

        </div>
    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Region') ?></label>
            <input class="form-control" name="sehir_invoice" value="<?php echo $details['sehir_invoice'] ?>">

        </div>

        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('City') ?></label>
            <input class="form-control" name="city_invoice" value="<?php echo $details['city_invoice'] ?>">

        </div>

    </div>
    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('PostBox') ?></label>
            <input class="form-control" name="post_invoice" value="<?php echo $details['post_invoice'] ?>">

        </div>

        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Address') ?></label>
            <input class="form-control" name="adres_invoice" value="<?php echo $details['adres_invoice'] ?>">

        </div>

    </div>

    <div class="row">
        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('Phone') ?></label>
            <input class="form-control" name="phone_invoice" value="<?php echo $details['phone_invoice'] ?>">

        </div>

        <div class="col mb-1"><label for="pmethod"><?php echo $this->lang->line('email_') ?></label>
            <input class="form-control" name="email_invoice" value="<?php echo $details['email_invoice'] ?>">

        </div>

    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-default"
                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
        <input type="hidden"  id="action-url-invoice" value="customers/customer_invoice_edit">
        <input type="hidden"  id="id_invoice_edit"  name="id_invoice_edit" value="<?php echo $details['id']?>">
        <button type="button" class="btn btn-primary"
                id="customer_invoice_edit">Düzenle</button>
    </div>
</form>