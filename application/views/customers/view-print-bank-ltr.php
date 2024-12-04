

<?php
/**
 * Created by PhpStorm.
 * User: ceobus
 * Date: 22.01.2020
 * Time: 15:22
 */
?>
<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BANKA REKVİZİT FORMU #<?php echo $invoice['banka'] ?></title>
    <style>

        body {
            color: #2B2000;
            font-family: 'Helvetica';
            width: 210mm;
            height: 90mm !important;

        }


        .invoice-box {

            margin: auto;
            border: 0;
            font-size: 12pt;
            line-height: 14pt;
            color: #000;

        }
        .plist
        {
            width: 210mm;
            max-height: 90mm !important;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }


        .plist tr td {
            line-height: 0pt;
            font-size: 10px;
            border-bottom: 1px solid gray;
            border-left: 1px solid gray;
            border-right: 1px solid gray;
        }

        .mycooo1 tr td {
            border-top: 1px solid gray;
            border-bottom: 1px solid gray;
            border-left: 1px solid gray;
            border-right: 1px solid gray;
        }
        .subtotal {
            page-break-inside:avoid;
            font-size:14px;
            font-weight:bold ;
        }

        .subtotal tr td {
            line-height: 5pt;
            padding: 2pt;
        }

        .subtotal tr td {
            border: 2px solid #494949;
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
            padding: 2px;
            vertical-align: top;

        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: left;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 0pt;

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
            padding: 6pt;

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
            width: 100%;

        }



        .myco2 {
            width: 200pt;
        }

        .myw {
            width: 300pt;
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


    </style>
</head>

<body>

<div class="invoice-box">
    <table class="plist" cellpadding="0" cellspacing="0">


        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Firma</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['firma_adi']?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Director</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['director']?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">VÖEN</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo customer_details($invoice['customer_id'])['taxid'] ?></td>
        </tr>

        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Hesab Nömresi</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['hesap_numarasi'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">İdentifikasiya Nömresi</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['iden_numarasi'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Banka</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['banka'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Banka Ünvan</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['banka_unvan'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Banka Telefon</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['banka_tel'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Banka Fax</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['banka_fax'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">KOD</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['kod'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Banka VÖEN</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['bank_voen'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">S.W.I.F.T BİK</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['swift_kodu'] ?></td>
        </tr>
        <tr>
            <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Muxbir Hesab</td>
            <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo $invoice['muhbir_hesab'] ?></td>
        </tr>



    </table>
</div>
</br>
</br>
</br>


</body>

