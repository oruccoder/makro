



$(document).on('click', '.group_button', function () {
    let product_id = $(this).attr('product_id');
    $.confirm({
        theme: 'modern',
        icon: 'fa fa-filter',
        type: 'green',
        animation: 'scale',
        useBootstrap: true,
        columnClass: "large",
        title: 'Seçenekler',
        content: function () {
            let self = this;
            let html = `<div class="form-group">
                                            <button class="btn btn-success" id="new_add_line"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <table class="table" id="option_value_list">
                                            <thead>
                                                <tr>
                                                    <th>Seçenek</th>
                                                    <th>işlem</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <td><select class="form-control select-box option"></select></td>
</tr>
                                            </tbody>
                                        </table>


                                </div>
                `;

            let data = {
                crsf_token: crsf_hash,
                product_id: product_id
            }

            let table_report = '';
            $.post(baseurl + 'productoption/info_options', data, (response) => {
                self.$content.find('#person-list').empty().append(html);
                let responses = jQuery.parseJSON(response);
                if (responses.product_options) {
                    $('#option_value_list tbody tr').eq(0).remove()
                    $.each(responses.product_options, function (index, item_) {
                        $('#option_value_list tbody').append(`<tr>
                                <td><select class="form-control select-box option"></select></td>
                                <td><button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button></td>
                        </tr>`);

                        $.each(responses.details, function (index_, item_value) {
                            $('.option').eq(index).append(new Option(item_value.name, item_value.id, false, false));
                        });

                        $('.option').eq(index).val(item_.option_id).trigger('change')


                    });




                }
                else {
                    $('.option').append(new Option('Seçiniz', '', false, false));
                    $.each(responses.details, function (index, item_) {
                        $('.option').append(new Option(item_.name, item_.id, false, false));
                    });
                }


            });
            self.$content.find('#person-list').empty().append(html);
            return $('#person-container').html();
        },
        onContentReady: function () {
            $('.select-box').select2({
                dropdownParent: $(".jconfirm-box-container")
            })
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        },
        buttons: {
            formSubmit: {
                text: 'Gondər',
                btnClass: 'btn-blue',
                action: function () {
                    $('#loading-box').removeClass('d-none');
                    let option_details = [];
                    let count = $('.option').length;
                    for (let i = 0; i < count; i++) {
                        option_details.push({
                            'option_id': $('.option').eq(i).val(),
                        });
                    }

                    let data_post = {
                        crsf_token: crsf_hash,
                        product_id: product_id,
                        option_details: option_details,
                    }

                    $.post(baseurl + 'newproductcategory/product_to_option_create', data_post, (response) => {
                        $('#loading-box').addClass('d-none');
                        let data = jQuery.parseJSON(response);
                        if (data.code == 200) {
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
                                        action: function () {
                                            table_product_id_ar = [];
                                            $('#product_table').DataTable().destroy();
                                            draw_data();
                                        }
                                    }
                                }
                            });

                        } else if (data.code == 410) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-4 mx-auto",
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
                    })
                }
            },
            cancel: {
                text: 'İmtina et',
                btnClass: "btn btn-danger btn-sm",
                action: function () {
                    table_product_id_ar = [];
                }
            }
        }
    });
})


$(document).on('click', '#new_add_line', function () {
    let eq = $('#option_value_list tbody tr').length
    $('#option_value_list tbody').append(`<tr>
        <td><select class="form-control select-box option"></select></td>
        <td><button class="btn btn-danger delete_line"><i class="fa fa-trash"></i></button></td>
</tr>`);

    let data = {
        crsf_token: crsf_hash
    }
    $.post(baseurl + 'productoption/info_options', data, (response) => {
        let responses = jQuery.parseJSON(response);
        $('.option').eq(eq).append(new Option('Seçiniz', '', false, false));
        $.each(responses.details, function (index, item_) {
            $('.option').eq(eq).append(new Option(item_.name, item_.id, false, false));
        });
    });
    $('.select-box').select2({
        dropdownParent: $(".jconfirm-box-container")
    })

})


$(document).on('click', '.delete_line', function () {
    $(this).parent().parent().remove();
})