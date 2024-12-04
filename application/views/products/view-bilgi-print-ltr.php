<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <style>
 
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }
        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right:20pt;
        }

        .invoice-box table td {
            padding: 6pt 4pt 2pt 4pt;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;

        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;

        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {

            background: #515151;
            color: #FFF;
            padding: 10pt;
            border:none;

        }

        table tr.details td {
            padding-bottom: 20pt;
        }

        .invoice-box table tr.item td{
            border: 1px solid #ddd;

        }

        table tr.b_class td{
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td{
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 400pt;
        }

        .myco2 {
            width: 300pt;
        }

        .myw {
            width: 340pt;
            font-size: 14pt;
            line-height: 14pt;

        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;

        }
        .party {
            border: #ccc 1px solid;


        }
        label{
            text-align:justify;
        }


    </style>
</head>

<body>

    <div class="invoice-box">
 

        <br>
        <table  style="font-size: 12px;" class="party">
            <thead>
            <tr class="heading" >
                <td style=""> <?php echo $this->lang->line('Our Info') ?>:</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
            </thead>
            <tbody>
     <tr>
                <td>
 <label style="width: 50%; bottom: 9px;" class="col-sm-6 col-form-label" for="product_name"><?= $this->lang->line('Product Name') ?></label>
                    
                </td>
                <td> <?= $product['product_name'] ?> </td>
                <td> <label style="width: 50%; bottom: 9px;" class="col-sm-6 col-form-label" for="product_cat"><?= $this->lang->line('Product Category') ?></label></td>
                <td><?=$product['category'] ?></td>
     </tr>
      <tr >

                    <td><label style=" width: 50%; " class="col-sm-6 col-form-label" for="product_cat"><?= $this->lang->line('Warehouse') ?></label></td>
                    <td>  <?=$product['warehouse'] ?></td>
         <td  style=" right:10%;"> <label  class="col-sm-6 col-form-label" for="product_code"><?= $this->lang->line('Product Code') ?></label></td>
                         <td><?=$product['product_code'] ?></td>
      </tr>
         <tr>
                 <td> <label style="width: 50%; bottom: 9px;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Product Retail Price') ?></td>
                    <td><?=$product['product_price'] ?> AZN</td>
                    <td><label style="width: 50%;"  class="col-sm-6 control-label" for="product_price"><?=$this->lang->line('kalite') ?></label></td>
                    <td><?=$product['kalite'] ?></td>

            </tr>
        <tr>
                    <td><label style="width: 50%;"  class="col-sm-6 control-label" for="product_price"><?=$this->lang->line('uretim_yeri') ?></label></td>
                    <td><?=$product['uretim_yeri'] ?></td>

                <td><label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Default TAX Rate') ?></label></td>
                    <td><?php echo $product['taxrate'] ?></td>
             </tr>

        <tr>
               <td> <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Measurement Unit') ?></label></td> 
               <td><?php echo $product['units'] ?></td>
               <td><label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Measurement Unit Weight') ?></label></td>
               <td><?php echo $product['metrekare_agirligi'] ?></td>
             </tr>
            <tr>
                <td> <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('total_m2') ?></label>
                    <td><?php echo $product['qty'] ?></td>
                    <?php if ($product['product_des']==!null) {
                    
                  ?>
                  <td> <label style="width: 50%;" class="col-sm-6 control-label" for="product_price"><?= $this->lang->line('Description') ?></label></td></td>
                  <td><?php echo $product['product_des'] ?></td>
              <?php } ?>
            </tr>


            </tbody>
        </table>
        <br/>
        <?php foreach($children as $child): ?>
        <table  style="font-size: 12px" class="plist" cellpadding="0" cellspacing="0"> 
    <tr class="heading">
                <td> Ürün Adı </td> 
                <td>Ürün Kodu </td>
                <td>Paketleme Miktarı</td>
                <td> Miktar </td>
        </tr>
                <tr>
              <td><?= $child->product_name ?></td>
              <td><?= $child->product_code ?></td>
             <td><?= $child->paketleme_miktari ?></td>
             <td><?= $child->qty ?></td>
         </tr>
  
        </table>
         <?php endforeach; ?>
  
</div>
</body>
</html>