<!DOCTYPE html>
<html>
<head>
    <style>
        h2 {
            text-align: center;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <title>
       Transfer : <?php echo $details->code; ?>
    </title>
</head>
<body>

<h2>Stok transfer Bilgileri</h2>
<h4> Fish Numarasi : <?php echo $details->code; ?></h4>
<h4> Olusturma Tarihi : <?php echo dateformat($details->created_at); ?></h4>
<h4> Fisi Olusturan Personel : <?php echo personel_detailsa($details->aauth_id)['name']; ?></h4>
<h4> Cikis Deposu : <?php echo $in_warehouse_name; ?></h4>
<h4> Giris Deposu : <?php echo $out_warehouse_name; ?></h4>
<br/><br/>
<table>
<tr>
    <th>No</th>
    <th>Product Name</th>
    <th>Miktar</th>
    <th>Cikis Durumu</th>
    <th>Cikis Personeli</th>
    <th>Giris Durumu</th>
    <th>Giris Personeli</th>
    <th>Açıklama</th>


</tr>


<?php
$i = 1;
foreach ($items as $row)
{

  ?>

    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo product_details_($row->product_id)->product_name; ?></td>
        <td><?php echo floatval($row->qty).' '.units_($row->unit_id)['name']; ?></td>
        <td><?php echo (stock_notification_status($row->id, 1))?stock_notification_status($row->id, 1)['status']:'-' ?></td>
        <td><?php echo (stock_notification_status($row->id, 1))?stock_notification_status($row->id, 1)['personelname']:'-' ?></td>
        <td><?php echo (stock_notification_status($row->id, 2))?stock_notification_status($row->id, 2)['status']:'-' ?></td>
        <td><?php echo (stock_notification_status($row->id, 2))?stock_notification_status($row->id, 2)['personelname']:'-' ?></td>
        <td><?php echo $row->desc?></td>

    </tr>

<?php $i++; } ?>



</table>

</body>
</html>