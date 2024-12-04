    <article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 animated fadeInRight">
            <h5><?php echo $this->lang->line('Products') ?> <a
                        href="<?php echo base_url('products/add') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>

                </a></h5>

            <div class="row">

                <div class="col-xl-4 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="green"><span id="dash_0"></span></h3>
                                        <span><?php echo $this->lang->line('In Stock') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-rocket green font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="red"><span id="dash_1"></span></h3>
                                        <span><?php echo $this->lang->line('Stock out') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-blocked red font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-xs-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <div class="media">
                                    <div class="media-body text-xs-left">
                                        <h3 class="cyan" id="dash_2"></h3>
                                        <span><?php echo $this->lang->line('Total') ?></span>
                                    </div>
                                    <div class="media-right media-middle">
                                        <i class="icon-stats-bars22 cyan font-large-2 float-xs-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a target="_blank" onclick="print_function()" style="float: right;background-color: #b3e2ec;padding: 10px;border-radius: 50px;margin-bottom: 9px;"><i class="icon-print"></i></a>

        <div class="table-responsive">
            <table id="productstable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Qty') ?></th>
                    <th><?php echo $this->lang->line('RezerQty') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('kalite') ?></th>
                    <th><?php echo $this->lang->line('uretim_yeri') ?></th>
                    <th><?php echo $this->lang->line('Warehouse') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </thead>
                <tbody>
                </tbody>

                <tfoot>
                <tr>
                    <th>#</th>
                    <th><?php echo $this->lang->line('Name') ?></th>
                    <th><?php echo $this->lang->line('Qty') ?></th>
                    <th><?php echo $this->lang->line('RezerQty') ?></th>
                    <th><?php echo $this->lang->line('Code') ?></th>
                    <th><?php echo $this->lang->line('kalite') ?></th>
                    <th><?php echo $this->lang->line('uretim_yeri') ?></th>
                    <th><?php echo $this->lang->line('Warehouse') ?></th>
                    <th><?php echo $this->lang->line('Price') ?></th>
                    <th><?php echo $this->lang->line('Settings') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <input type="hidden" id="dashurl" value="products/prd_stats">
</article>
<script type="text/javascript">

    var table;

    $(document).ready(function () {

        //datatables
        table = $('#productstable').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('products/product_list')?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],

        });
        miniDash();


$(document).on('click', ".view-object", function (e) {
    e.preventDefault();
    $('#view-object-id').val($(this).attr('data-object-id'));

    $('#view_model').modal({backdrop: 'static', keyboard: false});

        var actionurl = $('#view-action-url').val();
    $.ajax({
        url: baseurl + actionurl,
        data:'id='+$('#view-object-id').val()+'&'+crsf_token+'='+crsf_hash,
        type: 'POST',
        dataType: 'html',
        success: function (data) {
          $('#view_object').html(data);

            }

    });

});


        $(document).on('click', ".clone-object", function (e) {
            e.preventDefault();
            $('#view-object-id').val($(this).attr('data-object-id'));

            var actionurl = 'products/clone';
            $.ajax({
                url: baseurl + actionurl,
                data:'id='+$('#view-object-id').val()+'&'+crsf_token+'='+crsf_hash,
                type: 'POST',
                dataType: 'html',
                success: function (data) {
                    location.reload();

                }

            });

        });
    });
</script>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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

<!-- The Modal -->
<div id="myModal" class="modals">

    <!-- The Close Button -->
    <span class="close">&times;</span>

    <!-- Modal Content (The Image) -->
    <img class="modal-contents" id="img01">

    <!-- Modal Caption (Image Text) -->
    <div id="caption"></div>
</div>

<style>

    /* The Modal (background) */
    .modals {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-contents {
        margin: auto;
        display: block;
        width: 100%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content, #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {transform:scale(0)}
        to {transform:scale(1)}
    }

    /* The Close Button */
    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px){
        .modal-content {
            width: 100%;
        }
    }</style>
<script>



    $(document).on('click', '.myImg', function () {

       var resim = $(this).attr('resim_yolu');
        $('#myModal').css('display','block');
        $('#img01').attr('src',resim);
    });

    $(document).keydown(function(event) {
        if (event.keyCode == 27) {
            $('#myModal').hide();
        }
    });

    $('html').click(function(evt) {
        $('#myModal').hide();
    });

    function print_function() {
      var deger = $("select[name='productstable_length']" ).val();
      location.href = "/products/print_list?num="+deger;


    }



    $(document).on('click', '#button-cart', function () {
        var product_id = $(this).attr('product_id');
        var p = $(this).closest('tr').index();
        var eqq=parseInt(p);
        var miktar= $('.miktar').eq(eqq).val();
        $.ajax({
            url: baseurl + 'products/add_cart',
            dataType: "json",
            method: 'post',
            data:'product_id='+product_id+'&'+'miktar='+miktar+'&'+crsf_token+'='+crsf_hash,
            success: function (data) {
                if (data.status == "Başarılı") {
                    $('#cart_count').text(data.count);
                    $("#notify1 .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify1").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    setTimeout(function(){
                        $("#notify1").css('display','none');
                        $("#notify1 .message").html('');
                    }, 3000);

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }


            }
        });

    });
</script>