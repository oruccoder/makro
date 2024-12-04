<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">


                    <div class="message"></div>
                </div>
                <div class="card-body">
                <form id="data_form">

                        <input type="text" class="form-control" name="purchase" id="purchase"
                               placeholder="Sipariş Kodunu Giriniz!"
                               autocomplete="off"/>
                    <div id="purchase-box-result"></div>



                </form>
                </div>
            </div>

        </div>
    </div>
</div>


<script>


    $(document).ready(function () {


        $("#purchase").keyup(function () {
            $.ajax({
                type: "GET",
                url: baseurl + 'search_products/purchase_search',
                data: 'keyword='+ $(this).val()+'&'+d_csrf,
                beforeSend: function () {
                    $("#purchase-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#purchase-box-result").show();
                    $("#purchase-box-result").html(data);
                    $("#purchase-box").css("background", "none");

                }
            });
        });



    });

    function select_sayim(id) {
        location.href = '/sayim/create?purchase_id='+id;


    }




</script>