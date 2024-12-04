<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>İşlem Yazdır #<?php echo $trans['id'] ?></title>

    <style>

        @page { sheet-size: 220mm 110mm; }

        h1.bigsection {
            page-break-before: always;
            page: bigger;
        }

        table td {
            padding:  7pt;
            font-size: 12px;
        }


    </style>

</head>
<body style="font-family: Helvetica;">

<table>
    <?php echo'<tr><td>' . $this->lang->line('Date') . ' : ' . dateformat($trans['invoicedate']) . '</td><td>İşlem ID : '  .prefix(5) . $trans['id'] . '</td></tr>'; ?>
</table>

    <hr>
<table>
    <tr>
        <td>
         <?php $loc=location($trans['loc']); echo '<strong>' . $loc['cname'] . '</strong><br>' .
                                 $loc['address']. '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country']. ' -  ' . $loc['postbox'] . '<br> '.$this->lang->line('Phone').': ' . $loc['phone'] . '<br>  '.$this->lang->line('Email').': ' . $loc['email'] ;
                            ?>
        </td>

        <td> <?php echo '<strong>' . $trans['payer'] . '</strong><br>' .
                $cdata['address'] . '<br>' . $cdata['city'] . '<br>' . $this->lang->line('Phone') . ': ' . $cdata['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $cdata['email']; ?>
        </td>

    </tr>
</table>
<table><tr>
<?php echo '
                    <td>' . $this->lang->line('Debit') . ' : ' . amountFormat($trans['debit'],$trans['para_birimi']) . ' </td>
                    <td>' . $this->lang->line('Credit') . ' : ' . amountFormat($trans['credit'],$trans['para_birimi']) . '  </td>
                   <td>' . $this->lang->line('Type') . ' : ' . $trans['invoice_type_desc'] . ' </td></p>'; ?>
        </tr></table>

<table><tr>
        <?php echo '
                  
                   <td>' .  $this->lang->line('Note') . ' : ' . $trans['notes'] . ' </td></p>'; ?>
    </tr></table>
</body>