
<div class="container">
    <div class="row" style="
    background-color: #dfdfdf5e;
       margin: 30px;
    padding: 30px;
    display: flex;
    flex-wrap: nowrap;
    flex-direction: row;
    justify-content: space-between;
">
        <div class="" style="
    padding-right: 15px;
">
            <div class="title-field text-muted"><i class="fa fa-map-marker"></i> Kategori</div>
            <select class="form-control">
                <option>-Seçiniz-</option>
                <option>Morocco</option>
                <option>Tanzania</option>
                <option>Japan</option>
            </select>
        </div>
        <div class="" style="
    padding-right: 15px;
">
            <div class="title-field text-muted"><i class="fa fa-star-o"></i> Ürün</div>
            <input class="form-control" placeholder="Ürün hakkında bilgi yazabilirsiniz">
        </div>
        <div class="">
            <div class="title-field-non text-muted" style="font-size:11px;">a</div>
            <button type="button" class="btn btn-read-more" style="
    font-size: 18px;
"><i class="fa fa-search"></i> Search</button>
        </div>
    </div>
</div>

<style>
    input,
    textarea {
        border: 1px solid #eeeeee;
        box-sizing: border-box;
        margin: 0;
        outline: none;
        padding: 10px;
    }
    .title-field {
        font-size: 11px;
        display: block;
        width: 100%;
        color: white !important;
        padding: 0 !important;
    }

    input[type="button"] {
        -webkit-appearance: button;
        cursor: pointer;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
    }

    .input-group {
        clear: both;
        position: relative;
    }

    .input-group input[type='button'] {
        background-color: #eeeeee;
        min-width: 38px;
        width: auto;
        transition: all 300ms ease;
    }

    .input-group .button-minus,
    .input-group .button-plus {
        font-weight: bold;
        height: 38px;
        padding: 0;
        width: 38px;
        position: relative;
    }

    .input-group .quantity-field {
        position: relative;
        height: 38px;
        left: -6px;
        text-align: center;
        width: 62px;
        display: inline-block;
        font-size: 13px;
        resize: vertical;
    }

    .button-plus {
        left: -13px;
    }

    input[type="number"] {
        -moz-appearance: textfield;
        -webkit-appearance: none;
    }
    .module.module-blocks.module-blocks-299.blocks-grid{
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
    }

</style>

<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    $('.input-group').on('click', '.button-plus', function(e) {
        incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
    });

</script>