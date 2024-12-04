<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
                <h5><?php echo $this->lang->line('Change Customer Password') ?> (<?php echo $customer['name'] ?>)</h5>
        </div>
    </div>
</div>




<div class="content">
    <div class="card">
        <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="email">Email</label>
                    <div class="col-sm-6">
                        <input type="text" placeholder="email"
                               class="form-control margin-bottom  required" name="email"
                               value="<?php echo $customer['email'] ?>" readonly>
                        <input type="hidden" name="id" value="<?php echo $customer['id'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="password"><?php echo $this->lang->line('Password') ?></label>

                    <div class="col-sm-6">
                        <input type="text"
                               class="form-control margin-bottom  required" name="password" placeholder="Password">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="Update customer" data-loading-text="Updating...">
                        <input type="hidden" value="customers/changepassword" id="action-url">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>

<footer style="margin-bottom: 500px">

</footer>