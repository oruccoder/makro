<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Excel Tender  İmport</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="content-body">
        <div class="card">
            <div class="card-body">
                <a href="/userfiles/excel2/import_example_tender.xlsx" class="btn btn-info"> <i class="fa fa-file"></i> Örnek Dosya İndir</a>

            </div>

        </div>
    </div>
        <div class="card">
            <div class="card-body">


                <form id="ajaxForm" method="POST">
                    <input type="file" class="form-control upload_excel" name="userfile"  required /> <br>
                    <input type="submit" class="btn btn-success" name="submit" value="Yükle">
                </form>

            </div>

        </div>
    </div>
</div>

<script>
    $("#ajaxForm").submit(function(e){

        e.preventDefault();
        $.ajax({
            type: "POST",
            url: baseurl + 'excel/upload_tender_post',
            data: new FormData(this),
            dataType: "json",
            processData: false,
            contentType: false,
            success: function(responses){

                if (responses.status == 200) {
                        $.alert({
                            theme: 'material',
                            icon: 'fa fa-check',
                            type: 'green',
                            animation: 'scale',
                            useBootstrap: true,
                            columnClass: "small",
                            title: 'Dikkat!',
                            content: responses.message,
                            buttons: {
                                prev: {
                                    text: 'Tamam',
                                    btnClass: "btn btn-link text-dark",
                                }
                            }
                        });
                }
                else {
                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "small",
                        title: 'Dikkat!',
                        content: responses.message,
                        buttons: {
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }
            }
        });

        // $.post(baseurl + 'excel/upload_test', data_update, (response) => {
        //     // let responses = jQuery.parseJSON(response);
        //     console.log(response);
        //     // if (responses.status == 200) {
        //     //
        //     //
        //     // } else {
        //     //     $('#loading-box').addClass('d-none');
        //     //     $.alert({
        //     //         theme: 'material',
        //     //         icon: 'fa fa-exclamation',
        //     //         type: 'red',
        //     //         animation: 'scale',
        //     //         useBootstrap: true,
        //     //         columnClass: "col-md-4 mx-auto",
        //     //         title: 'Dikkat!',
        //     //         content: responses.message,
        //     //         buttons: {
        //     //             prev: {
        //     //                 text: 'Tamam',
        //     //                 btnClass: "btn btn-link text-dark",
        //     //             }
        //     //         }
        //     //     });
        //     // }
        //
        // });
    })
</script>