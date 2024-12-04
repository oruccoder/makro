<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 19.04.2020
 * Time: 19:41
 */
?>

<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><?php echo $this->lang->line('product_report') ?> </h4>
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

                <div class="row">

                    <div class="col-md-2">Kategoriler</div>
                    <div class="col-md-6">
                        <select class="form-control select-box" id="kat_id"  name="kat_id[]" multiple="multiple">
                            <?php foreach (kategoriler() as $ktg) {
                                echo "<option value='$ktg->id'>$ktg->title</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-sm"/>
                    </div>
                    <div class="col-md-2">
                        <a href="" type="button" name="search" id="search" value="Temizle" class="btn btn-info btn-sm">Temizle</a>
                    </div>

                </div>
                <hr>

                <hr>
                <table id="extres" class="table table-striped table-bordered zero-configuration"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Item Name') ?></th>
                        <th><?php echo $this->lang->line('Product Code') ?></th>
                        <th><?php echo $this->lang->line('unit') ?></th>
                        <th><?php echo $this->lang->line('Quantity') ?></th>
                        <th><?php echo $this->lang->line('cat_name') ?></th>
                        <th>Firma</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>

                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>

<div id="satinalma_detay" class="modal  fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

                <h4 class="modal-title">Satın Alma Detayları</h4>
            </div>
            <div class="modal-body" id="view_object_urunler">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Close') ?></button>
            </div>
        </div>
    </div>
</div>


<style>
    div.dataTables_wrapper div.dataTables_length select
    {
        width: 50px !important;
    }
</style>

<input type="hidden" id="location_logo" value="<?php  $loc=location($this->aauth->get_user()->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>">
<input type="hidden" id="para_birimi" value="AZN">
<script type="text/javascript">

    $(document).on('click', ".satinalma_detay", function (e) {
        e.preventDefault();
        var product_id = $(this).attr('product_id');
        var product_name = $(this).attr('product_name');

        $('#view_model').modal({backdrop: 'static', keyboard: false});
        var actionurl = 'reports/satinalma_detay';
        $.ajax({
            url: baseurl + actionurl,
            data:'id='+product_id+'&product_name='+product_name,
            type: 'POST',
            dataType: 'html',
            success: function (data) {
                $('#view_object_urunler').html(data);


            }

        });

    });

    $(document).ready(function () {

        var url=$('#location_logo').val();
        var cari='Stok Raporu';
        var para_birimi=$('#para_birimi').val();
        var para_birimi_str='';

        if(para_birimi=='tumu')
        {
            para_birimi_str='AZN';
        }
        else {
            para_birimi_str=para_birimi;
        }


        draw_data();

        function draw_data(kat_id='') {
            $('#extres').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                aLengthMenu: [
                    [10, 50, 100, 200, -1],
                    [10, 50, 100, 200, "Tümü"]
                ],
                responsive: true,
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('reports/ajax_product_reports')?>",
                    'type': 'POST',
                    'data': {
                        'para_birimi':$('#para_birimi').val(),
                        'kat_id':$('#kat_id').val(),
                        '<?php echo $this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                'columnDefs': [
                    {
                        'targets': [0],
                        'orderable': false,
                    },
                ],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3,4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3,4,5]
                        }
                    },
                    {
                        extend: 'csv',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3,4,5]
                        }
                    },

                    {
                        extend: 'copy',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3,4,5]
                        }
                    },
                    {
                        messageTop: "<div style='text-align: center'><img src='http://muhasebe.italicsoft.com/userfiles/company/16058809601269056269.png?t=88' style='max-height:180px;max-width:90px;'>",
                        messageBottom: "<p style='font-size: 10px;text-align: center'>MAKRO2000 GROUP COMPANIES<br/>" +
                            "+994 12 597 48 18<br/>" +
                            "WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan</p></div>",
                        extend: 'print',

                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3,4]
                        }
                    },
                ]
            });
        };

        $('#search').click(function () {
            var kat_id = $('#kat_id').val();
            if (kat_id != '') {
                $('#extres').DataTable().destroy();
                draw_data(kat_id);
            } else {
                alert("Date range is Required");
            }
        });
    });
    function currencyFormat(num,para_birimi_str) {

        var deger=  num.toFixed(2).replace('.',',');
        return  deger.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' '+para_birimi_str;
    }


    $(function () {
        $('.select-box').select2();

        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });
</script>


