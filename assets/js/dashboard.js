$(document).ready(function (){
    $('#invoices_gider').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/cari_gider_ajax_list_yeni',
            'type': 'POST',
            'data': {
                tip:2,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#invoices_cari_talep_onay_report').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/invoices_cari_onay_report',
            'type': 'POST',
            'data': {
                tip:1,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });


    $('#invoices_cari_avans_onay_report').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/invoices_cari_onay_report',
            'type': 'POST',
            'data': {
                tip:2,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#invoices_talep_onay_report').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/invoices_talep_onay_report',
            'type': 'POST',
            'data': {
                tip:1,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#cari_avans').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/cari_avans_ajax_list_dash',
            'type': 'POST',
            'data': {
                tip:1,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#personel_gider_talep').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/personel_gider_ajax_list',
            'type': 'POST',
            'data': {
                tip:1,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#personel_maas_talep').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/onay/personel_avans_ajax_list',
            'type': 'POST',
            'data': {
                tip:1,
                  crsf_token: crsf_hash,
            }
        },
        columnDefs: [{
            orderable: false,
            targets: [ 4 ]
        }],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#invoices_tables').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/invoices/ajax_list',
            'type': 'POST',
            'data': {
                start_date: '',
                end_date: '',
                alt_firma:'',
                status:22,
                  crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#invoices_tables_bank').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/invoices/ajax_list',
            'type': 'POST',
            'data': {
                start_date: '',
                end_date: '',
                alt_firma:'',
                status:13,
                  crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#invoices_tables_bank_').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/invoices/ajax_list',
            'type': 'POST',
            'data': {
                start_date: '',
                end_date: '',
                alt_firma:'',
                status:6,
                  crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#lojistik_talep').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/nakliye/ajax_list_onay_bekleyen',
            'type': 'POST',
            'data': {
                type:1,
                status_id:1,
                  crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });
    $('#lojistik_satinalma_talep').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        'ajax': {
            'url': baseurl+'/nakliye/ajax_list_onay_bekleyen',
            'type': 'POST',
            'data': {
                type:2,
                status_id:3,
                  crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });

    $('#forma2_list').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        aLengthMenu: [
            [ -1,10, 50, 100, 200],
            ["Tümü",10, 50, 100, 200]
        ],
        'ajax': {
            'url': baseurl+'/formainvoices/ajax_list_onay_bekleyen',
            'type': 'POST',
            'data': {
                status:12,
                  crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });
    $('#forma2_list_iptal').DataTable({
        autoWidth: false,
        select: true,
        processing: true,
        serverSide: true,
        aLengthMenu: [
            [ -1,10, 50, 100, 200],
            ["Tümü",10, 50, 100, 200]
        ],
        'ajax': {
            'url': baseurl+'/formainvoices/ajax_list_iptal',
            'type': 'POST',
            'data': {
                status:12,
                crsf_token: crsf_hash,
            }
        },
        'columnDefs': [
            {
                'targets': [0],
                'orderable': false,
            },
        ],
        dom: 'Blfrtip',
        buttons: []
    });
})
