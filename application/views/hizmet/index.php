<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Malzema Talep Listesi</span></h4>
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
                        <fieldset class="mb-3">
                            <div class="form-group row">
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="1">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Talep Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(1,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Onaylanmamış Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="2">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Cari Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(2,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Müşteri Ataması Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="3">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">İhale Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(3,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">İhale Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="4">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Muqayese Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(4,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">İhalesi Oluşmuş Onay Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="5">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Sipariş Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(5,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">İhalesi Onaylanmış Sipariş Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="6">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Sened Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(6,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Sipariş Oluşmuş Senedleri Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="7">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Teslim Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"> <?php echo talep_status_count(7,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Teslimat Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="8">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Tehvil Alınmışlar</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(8,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Tehvil Alınmış Qaime Bekleyen Açık Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="9">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Tamamlanan Talepler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(9,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Tamamlanan Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="10">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">İptal Durumundakiler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(10,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">iptal Edilen Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="11">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Ödeme Bekleyenler</h5>
                                                        <span class="h2_ font-weight-bold mb-0"><?php echo talep_status_count(11,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Avans Ödemesi Bekleyen Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-lg-2">
                                    <a  class="status_filer_button" status_id="0">
                                        <div class="card card-stats mb-4 mb-xl-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">Tümü</h5>
                                                        <span class="h2_ font-weight-bold mb-0"> <?php echo talep_status_count(-1,2)?></span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                                            <i class="fa fa-question"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-muted font-weight-bold text-sm">
                                                    <span class="text-danger mr-2">Tüm Talepler</span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="#">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <select class="select-box form-control" id="status" name="status" >
                                        <option value="-1">Talep Durumu</option>
                                        <?php foreach(talep_form_status_list() as $items_status){
                                            echo "<option value='$items_status->id'>$items_status->name</option>";
                                        } ?>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <input type="button" name="search" id="search" value="Filtrele" class="btn btn-info btn-md"/>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card">
                    <table id="invoices" class="table datatable-show-all"
                           cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Tələn Nomresi</th>
                            <th>Təcili</th>
                            <th>İstək Tarixi</th>
                            <th>Tələb Açan</th>
                            <th>Layihə</th>
                            <th>Vəziyyət</th>
                            <th>Transfer Durum</th>
                            <th>Onay Kimde</th>
                            <th>Gecikme Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


    <style>

        :root {
            --blue: #5e72e4;
            --indigo: #5603ad;
            --purple: #8965e0;
            --pink: #f3a4b5;
            --red: #f5365c;
            --orange: #fb6340;
            --yellow: #ffd600;
            --green: #2dce89;
            --teal: #11cdef;
            --cyan: #2bffc6;
            --white: #fff;
            --gray: #8898aa;
            --gray-dark: #32325d;
            --light: #ced4da;
            --lighter: #e9ecef;
            --primary: #5e72e4;
            --secondary: #f7fafc;
            --success: #2dce89;
            --info: #11cdef;
            --warning: #fb6340;
            --danger: #f5365c;
            --light: #adb5bd;
            --dark: #212529;
            --default: #172b4d;
            --white: #fff;
            --neutral: #fff;
            --darker: black;
            --breakpoint-xs: 0;
            --breakpoint-sm: 576px;
            --breakpoint-md: 768px;
            --breakpoint-lg: 992px;
            --breakpoint-xl: 1200px;
            --font-family-sans-serif: Open Sans, sans-serif;
            --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        @-ms-viewport {
            width: device-width;
        }

        figcaption,
        footer,
        header,
        main,
        nav,
        section {
            display: block;
        }



        [tabindex='-1']:focus {
            outline: 0 !important;
        }

        h2,
        h5 {
            margin-top: 0;
            margin-bottom: .5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        dfn {
            font-style: italic;
        }

        strong {
            font-weight: bolder;
        }

        a {
            text-decoration: none;
            color: #5e72e4;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }

        a:hover {
            text-decoration: none;
            color: #233dd2;
        }

        a:not([href]):not([tabindex]) {
            text-decoration: none;
            color: inherit;
        }

        a:not([href]):not([tabindex]):hover,
        a:not([href]):not([tabindex]):focus {
            text-decoration: none;
            color: inherit;
        }

        a:not([href]):not([tabindex]):focus {
            outline: 0;
        }

        caption {
            padding-top: 1rem;
            padding-bottom: 1rem;
            caption-side: bottom;
            text-align: left;
            color: #8898aa;
        }

        button {
            border-radius: 0;
        }

        button:focus {
            outline: 1px dotted;
            outline: 5px auto -webkit-focus-ring-color;
        }

        input,
        button {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit;
            margin: 0;
        }

        button,
        input {
            overflow: visible;
        }

        button {
            text-transform: none;
        }

        button,
        [type='reset'],
        [type='submit'] {
            -webkit-appearance: button;
        }

        button::-moz-focus-inner,
        [type='button']::-moz-focus-inner,
        [type='reset']::-moz-focus-inner,
        [type='submit']::-moz-focus-inner {
            padding: 0;
            border-style: none;
        }

        input[type='radio'],
        input[type='checkbox'] {
            box-sizing: border-box;
            padding: 0;
        }

        input[type='date'],
        input[type='time'],
        input[type='datetime-local'],
        input[type='month'] {
            -webkit-appearance: listbox;
        }

        legend {
            font-size: 1.5rem;
            line-height: inherit;
            display: block;
            width: 100%;
            max-width: 100%;
            margin-bottom: .5rem;
            padding: 0;
            white-space: normal;
            color: inherit;
        }

        [type='number']::-webkit-inner-spin-button,
        [type='number']::-webkit-outer-spin-button {
            height: auto;
        }

        [type='search'] {
            outline-offset: -2px;
            -webkit-appearance: none;
        }

        [type='search']::-webkit-search-cancel-button,
        [type='search']::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        ::-webkit-file-upload-button {
            font: inherit;
            -webkit-appearance: button;
        }

        [hidden] {
            display: none !important;
        }

        h2,
        h5,
        .h2,
        .h5 {
            font-family: inherit;
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: .5rem;
            color: #32325d;
        }

        h2,
        .h2 {
            font-size: 1.25rem;
        }
        .h2_ {
            font-size: 2.25rem;
            font-family: inherit;
            font-weight: 600;
            line-height: 1.5;
            margin-bottom: .5rem;
            color: #32325d;
        }

        h5,
        .h5 {
            font-size: .8125rem;
        }

        .container-fluid {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 15px;
            padding-left: 15px;
        }

        .row {
            display: flex;
            margin-right: -15px;
            margin-left: -15px;
            flex-wrap: wrap;
        }

        .col,
        .col-auto,
        .col-lg-6,
        .col-xl-3,
        .col-xl-6 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .col {
            max-width: 100%;
            flex-basis: 0;
            flex-grow: 1;
        }

        .col-auto {
            width: auto;
            max-width: none;
            flex: 0 0 auto;
        }

        @media (min-width: 992px) {
            .col-lg-6 {
                max-width: 50%;
                flex: 0 0 50%;
            }
        }

        @media (min-width: 1200px) {
            .col-xl-3 {
                max-width: 25%;
                flex: 0 0 25%;
            }
            .col-xl-6 {
                max-width: 50%;
                flex: 0 0 50%;
            }
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            border: 1px solid rgba(0, 0, 0, 0.14);
            border-radius: .375rem;
            background-color: #fff;
            background-clip: border-box;
        }

        .card-body {
            padding: 1.5rem;
            flex: 1 1 auto;
        }

        .card-title {
            margin-bottom: 1.25rem;
        }

        @keyframes progress-bar-stripes {
            from {
                background-position: 1rem 0;
            }
            to {
                background-position: 0 0;
            }
        }

        .bg-info {
            background-color: #11cdef !important;
        }

        a.bg-info:hover,
        a.bg-info:focus,
        button.bg-info:hover,
        button.bg-info:focus {
            background-color: #0da5c0 !important;
        }

        .bg-warning {
            background-color: #fb6340 !important;
        }

        a.bg-warning:hover,
        a.bg-warning:focus,
        button.bg-warning:hover,
        button.bg-warning:focus {
            background-color: #fa3a0e !important;
        }

        .bg-danger {
            background-color: #f5365c !important;
        }

        a.bg-danger:hover,
        a.bg-danger:focus,
        button.bg-danger:hover,
        button.bg-danger:focus {
            background-color: #ec0c38 !important;
        }

        .bg-default {
            background-color: #172b4d !important;
        }

        a.bg-default:hover,
        a.bg-default:focus,
        button.bg-default:hover,
        button.bg-default:focus {
            background-color: #0b1526 !important;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        @media (min-width: 1200px) {
            .justify-content-xl-between {
                justify-content: space-between !important;
            }
        }

        .shadow {
            box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .mr-2 {
            margin-right: .5rem !important;
        }

        .mt-3 {
            margin-top: 1rem !important;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .mb-5 {
            margin-bottom: 3rem !important;
        }

        .pt-5 {
            padding-top: 3rem !important;
        }

        .pb-8 {
            padding-bottom: 8rem !important;
        }

        .m-auto {
            margin: auto !important;
        }

        @media (min-width: 768px) {
            .pt-md-8 {
                padding-top: 8rem !important;
            }
        }

        @media (min-width: 1200px) {
            .mb-xl-0 {
                margin-bottom: 0 !important;
            }
        }

        .text-nowrap {
            white-space: nowrap !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        .font-weight-bold {
            font-weight: 600 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .text-success {
            color: #2dce89 !important;
        }

        a.text-success:hover,
        a.text-success:focus {
            color: #24a46d !important;
        }

        .text-warning {
            color: #fb6340 !important;
        }

        a.text-warning:hover,
        a.text-warning:focus {
            color: #fa3a0e !important;
        }

        .text-danger {
            color: #f5365c !important;
        }

        a.text-danger:hover,
        a.text-danger:focus {
            color: #ec0c38 !important;
        }

        .text-white {
            color: #fff !important;
        }

        a.text-white:hover,
        a.text-white:focus {
            color: #e6e6e6 !important;
        }

        .text-muted {
            color: #8898aa !important;
        }

        @media print {
            *,
            *::before,
            *::after {
                box-shadow: none !important;
                text-shadow: none !important;
            }
            a:not(.btn) {
                text-decoration: underline;
            }
            p,
            h2 {
                orphans: 3;
                widows: 3;
            }
            h2 {
                page-break-after: avoid;
            }
        @ page {
              size: a3;
          }
            body {
                min-width: 992px !important;
            }
        }

        figcaption,
        main {
            display: block;
        }

        main {
            overflow: hidden;
        }

        .bg-yellow {
            background-color: #ffd600 !important;
        }

        a.bg-yellow:hover,
        a.bg-yellow:focus,
        button.bg-yellow:hover,
        button.bg-yellow:focus {
            background-color: #ccab00 !important;
        }


        @keyframes floating-lg {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(15px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(10px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        @keyframes floating-sm {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(5px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        [class*='shadow'] {
            transition: all .15s ease;
        }

        .text-sm {
            font-size: .875rem !important;
        }

        .text-white {
            color: #fff !important;
        }

        a.text-white:hover,
        a.text-white:focus {
            color: #e6e6e6 !important;
        }

        [class*='btn-outline-'] {
            border-width: 1px;
        }

        .card-stats .card-body {
            padding: 1rem 1.5rem;
        }

        .main-content {
            position: relative;
        }

        @media (min-width: 768px) {
            .main-content .container-fluid {
                padding-right: 39px !important;
                padding-left: 39px !important;
            }
        }

        .footer {
            padding: 2.5rem 0;
            background: #f7fafc;
        }

        .footer .copyright {
            font-size: .875rem;
        }

        .header {
            position: relative;
        }

        .icon {
            width: 3rem;
            height: 3rem;
        }

        .icon i {
            font-size: 2.25rem;
        }

        .icon-shape {
            display: inline-flex;
            padding: 12px;
            text-align: center;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
        }

        .icon-shape i {
            font-size: 1.25rem;
        }

        @media (min-width: 768px) {
        @ keyframes show-navbar-dropdown {
        0% {
            transition: visibility .25s, opacity .25s, transform .25s;
            transform: translate(0, 10px) perspective(200px) rotateX(-2deg);
            opacity: 0;
        }
        100% {
            transform: translate(0, 0);
            opacity: 1;
        }
        }
        @keyframes hide-navbar-dropdown {
            from {
                opacity: 1;
            }
            to {
                transform: translate(0, 10px);
                opacity: 0;
            }
        }
        }

        @keyframes show-navbar-collapse {
            0% {
                transform: scale(.95);
                transform-origin: 100% 0;
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes hide-navbar-collapse {
            from {
                transform: scale(1);
                transform-origin: 100% 0;
                opacity: 1;
            }
            to {
                transform: scale(.95);
                opacity: 0;
            }
        }

        p {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.7;
        }

        }


    </style>
    <script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
    <script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
    <script type="text/javascript">

        $('#search').click(function () {
            var tansfer_status = $('#tansfer_status').val();
            var status = $('#status').val();
            $('#invoices').DataTable().destroy();
            draw_data(status,tansfer_status);

        });

        var url = '<?php echo base_url() ?>arac/file_handling';

        $(document).ready(function () {
            draw_data()
        });
        function draw_data(status_id=0,transfer_status=-1) {
            $('#invoices').DataTable({
                'processing': true,
                'serverSide': true,
                'stateSave': true,
                responsive: true,
                <?php datatable_lang();?>
                'order': [],
                'ajax': {
                    'url': "<?php echo site_url('hizmet/ajax_list')?>",
                    'type': 'POST',
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash,'status_id':status_id,'transfer_status':transfer_status}
                },
                'createdRow': function (row, data, dataIndex) {

                    $(row).attr('style',data[10]);

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
                        text: '<i class="fa fa-plus"></i> Yeni Talep Oluştur',
                        action: function ( e, dt, node, config ) {
                            $.confirm({
                                theme: 'modern',
                                closeIcon: true,
                                title: 'Yeni İstək Əlavə Edin ',
                                icon: 'fa fa-plus',
                                type: 'dark',
                                animation: 'scale',
                                useBootstrap: true,
                                columnClass: "col-md-8 mx-auto",
                                containerFluid: !0,
                                smoothContent: true,
                                draggable: false,
                                content:`<form>


  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="name">Layihə / Proje</label>
      <select class="form-control select-box proje_id proje_id_new required" id="proje_id">
                <option value="0">Seçiniz</option>
                <?php foreach (all_projects() as $emp){
        $emp_id=$emp->id;
        $name=$emp->code;
        ?>
                    <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
    </div>
</div>
<div class="form-row">
 <div class="form-group col-md-6">
      <label for="bolum_id">Proje Bölümü</label>
      <select class="form-control select-box bolum_id_new" id="bolum_id">
            <option value="0">Seçiniz</option>
    </select>
    </div>
    <div class="form-group col-md-6">
      <label for="asama_id">Proje Aşaması</label>
        <select class="form-control select-box asama_id_new" id="asama_id">
           <option value="0">Seçiniz</option>
        </select>

    </div>
</div>
<div class="form-row">

 <div class="form-group col-md-6">
      <label for="talep_eden_user_id">Talep Eden</label>
      <select class="form-control select-box required" id="talep_eden_user_id">
            <?php foreach (all_personel() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
    </select>
    </div>
    <div class="form-group col-md-6">
      <label for="firma_id">Təcili</label>
        <select class="form-control select-box" id="progress_status_id">
        
            <?php foreach (progress_status() as $emp){
                $emp_id=$emp->id;
                $name=$emp->name;
                ?>
                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
            <?php } ?>
        </select>

    </div>


</div>
 <div class="form-row proje_gider_talebi_visable">
         <div class="form-group col-md-6" style='display: inline-grid;'>
              <label for="talep_eden_user_id">Grup</label>
                  <select class="form-control select-box required" id="demirbas_id">

                            <option value="0">Group Seçiniz</option>
                        <?php foreach (demirbas_group_list() as $emp){
                                            $emp_id=$emp->id;
                                            $name=$emp->name;
                                            ?>
                            <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                        <?php } ?>
                </select>
            </div>
        <div class="form-group col-md-6" style='display: inline-grid;'>
          <label for="firma_id">Gider Yapılacak İtem</label>
            <select class="form-control select-box" id="firma_demirbas_id">
            <option value="0">Group Seçiniz</option>
            </select>
        </div>
</div>
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="marka">Açıqlama / Qeyd</label>
      <textarea class="form-control" id="desc"></textarea>
    </div>
</div>
    <div class="form-row">
      <div class="form-group col-md-12">
         <label for="resim">Fayl</label>
           <div id="progress" class="progress">
                <div class="progress-bar progress-bar-success"></div>
           </div>
            <table id="files" class="files"></table><br>
            <span class="btn btn-success fileinput-button" style="width: 100%">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Seçiniz...</span>
            <input id="fileupload_" type="file" name="files[]">
            <input type="hidden" class="image_text" name="image_text" id="image_text">
      </div>
       </div>
</form>`,
                                buttons: {
                                    formSubmit: {
                                        text: 'Sorğunu Açın',
                                        btnClass: 'btn-blue',
                                        action: function () {


                                            $('#loading-box').removeClass('d-none');

                                            let data = {
                                                crsf_token: crsf_hash,
                                                progress_status_id:  $('#progress_status_id').val(),
                                                talep_eden_user_id:  $('#talep_eden_user_id').val(),
                                                proje_id:  $('#proje_id').val(),
                                                bolum_id:  $('#bolum_id').val(),
                                                asama_id:  $('#asama_id').val(),
                                                desc:  $('#desc').val(),
                                                transfer_status:  0,
                                                image_text:  $('#image_text').val(),
                                                talep_type:  2,
                                                gider_durumu:  0,
                                                demirbas_id:  $('#demirbas_id').val(),
                                                firma_demirbas_id:  $('#firma_demirbas_id').val(),
                                            }
                                            $.post(baseurl + 'hizmet/create_save',data,(response) => {
                                                let responses = jQuery.parseJSON(response);
                                                $('#loading-box').addClass('d-none');
                                                if(responses.status==200){
                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-check',
                                                        type: 'green',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "small",
                                                        title: 'Başarılı',
                                                        content: responses.message,
                                                        buttons:{
                                                            formSubmit: {
                                                                text: 'Tamam',
                                                                btnClass: 'btn-blue',
                                                                action: function () {
                                                                    location.href = responses.index
                                                                }
                                                            }
                                                        }
                                                    });

                                                }
                                                else if(responses.status==410){

                                                    $.alert({
                                                        theme: 'modern',
                                                        icon: 'fa fa-exclamation',
                                                        type: 'red',
                                                        animation: 'scale',
                                                        useBootstrap: true,
                                                        columnClass: "col-md-4 mx-auto",
                                                        title: 'Dikkat!',
                                                        content: responses.message,
                                                        buttons:{
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
                                },
                                onContentReady: function () {
                                    $('.select-box').select2({
                                        dropdownParent: $(".jconfirm-box-container")
                                    })

                                    $('#fileupload_').fileupload({
                                        url: url,
                                        dataType: 'json',
                                        formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
                                        done: function (e, data) {
                                            var img='default.png';
                                            $.each(data.result.files, function (index, file) {
                                                img=file.name;
                                            });

                                            $('#image_text').val(img);
                                        },
                                        progressall: function (e, data) {
                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                            $('#progress .progress-bar').css(
                                                'width',
                                                progress + '%'
                                            );
                                        }
                                    }).prop('disabled', !$.support.fileInput)
                                        .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                    // bind to events
                                    var jc = this;
                                    this.$content.find('form').on('submit', function (e) {
                                        // if the user submits the form by pressing enter in the field.
                                        e.preventDefault();
                                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                                    });
                                }
                            });
                        }
                    }
                ]
            });
        }

        $(document).on('click', ".talep_sil", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-exclamation',
                type: 'red',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Talep İptal Etmek Üzeresiniz?<p/>' +
                    '<p><b>Bu İşleme Ait Qaime ve Stok Hareketleri Var İse İptal Olacaktır</b><p/>' +
                    '<input type="text" id="desc" class="form-control desc" placeholder="İptal Sebebi Zorunludur">' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'İptal Et',
                        btnClass: 'btn-blue',
                        action: function () {

                            let name = $('.desc').val()
                            if(!name){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: 'İptal Sebebi Zorunludur',
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                return false;
                            }

                            $('#loading-box').removeClass('d-none');

                            let data = {
                                crsf_token: crsf_hash,
                                file_id:  talep_id,
                                desc:  $('.desc').val(),
                                status:  10
                            }
                            $.post(baseurl + 'hizmet/status_upda',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.status==200){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status==410){

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: responses.message,
                                        buttons:{
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
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });

        })

        $(document).on('click', ".transfer_bildirim", function (e) {
            let talep_id = $(this).attr('talep_id');
            $.confirm({
                theme: 'modern',
                closeIcon: true,
                title: 'Dikkat',
                icon: 'fa fa-bell',
                type: 'orange',
                animation: 'scale',
                useBootstrap: true,
                columnClass: "small",
                containerFluid: !0,
                smoothContent: true,
                draggable: false,
                content:'<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<p>Transfer Bildirimi Başlatmak Üzeresiniz Emin Misiniz?<p/>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Oluştur',
                        btnClass: 'btn-blue',
                        action: function () {
                            $('#loading-box').removeClass('d-none');
                            let data = {
                                crsf_token: crsf_hash,
                                talep_id:  talep_id,
                            }
                            $.post(baseurl + 'hizmet/transfer_bildirimi',data,(response) => {
                                let responses = jQuery.parseJSON(response);
                                $('#loading-box').addClass('d-none');
                                if(responses.status==200){
                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-check',
                                        type: 'green',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "small",
                                        title: 'Başarılı',
                                        content: responses.message,
                                        buttons:{
                                            formSubmit: {
                                                text: 'Tamam',
                                                btnClass: 'btn-blue',
                                                action: function () {
                                                    $('#invoices').DataTable().destroy();
                                                    draw_data();
                                                }
                                            }
                                        }
                                    });

                                }
                                else if(responses.status==410){

                                    $.alert({
                                        theme: 'modern',
                                        icon: 'fa fa-exclamation',
                                        type: 'red',
                                        animation: 'scale',
                                        useBootstrap: true,
                                        columnClass: "col-md-4 mx-auto",
                                        title: 'Dikkat!',
                                        content: responses.message,
                                        buttons:{
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
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });

        })




        $(document).on('click','.status_filer_button',function (){
            let status_id = $(this).attr('status_id');
            $('#invoices').DataTable().destroy();
            draw_data(status_id);
        })


        $(document).on('change','.proje_id_new',function (){
            $(".asama_id_new option").remove();
            $(".bolum_id_new option").remove();
            let proje_id  =$(this).val();
            let data = {
                crsf_token: crsf_hash,
                pid: proje_id,
            }
            $.post(baseurl + 'projects/proje_bolum_ajax',data,(response) => {
                let responses = jQuery.parseJSON(response);
                responses.forEach((item_,index) => {
                    $('.bolum_id_new').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                })
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });

            });

        })

        $(document).on('change','.bolum_id_new',function (){
            $(".asama_id_new option").remove();
            let bolum_id  =$(this).val();
            let proje_id  =$('.proje_id_new').val();
            let data = {
                crsf_token: crsf_hash,
                bolum_id: bolum_id,
                asama_id: 0,
                proje_id: proje_id,
            }
            $.post(baseurl + 'projects/proje_asamalari_ajax',data,(response) => {
                let responses = jQuery.parseJSON(response);
                responses.forEach((item_,index) => {
                    $('.asama_id_new').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                })
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });

            });

        })

        $(document).on('change','#talep_type',function (){
            let id = $(this).val();
            if(id==3){
                $('.proje_gider_talebi_visable').removeClass('d-none');
            }
            else {
                $('.proje_gider_talebi_visable').addClass('d-none');
            }
        })


        $(document).on('change','#demirbas_id',function (){
            let id =  $(this).val();
            let data = {
                group_id: id
            }
            $.post(baseurl + 'demirbas/get_firma_demirbas',data,(response)=>{
                let responses = jQuery.parseJSON(response);
                let eq=$(this).parent().index();
                $("#firma_demirbas_id option").remove();
                if(responses.status==200){
                    $('.select-box').select2({
                        dropdownParent: $(".jconfirm-box-container")
                    });
                    responses.items.forEach((item_,index) => {
                        $('#firma_demirbas_id').append(new Option(item_.name, item_.id, false, false)).trigger('change');
                    })

                }
                else {

                    $.alert({
                        theme: 'material',
                        icon: 'fa fa-exclamation',
                        type: 'red',
                        animation: 'scale',
                        useBootstrap: true,
                        columnClass: "col-md-4 mx-auto",
                        title: 'Dikkat!',
                        content: responses.message,
                        buttons:{
                            prev: {
                                text: 'Tamam',
                                btnClass: "btn btn-link text-dark",
                            }
                        }
                    });
                }


            });
        })



    </script>

<link href="<?php echo  base_url() ?>app-assets/talep.css?v=<?php echo rand(11111,99999) ?>" rel="stylesheet" type="text/css">
