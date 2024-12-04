
<footer style="padding-bottom: 90px">

    <div class="invoice-box">
        <table  class="plist" cellpadding="0" cellspacing="0">
            <tr>
                <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Office Adress</td>
                <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo customer_details($invoice['customer_id'])['address'] ?></td>
            </tr>
            <tr>
                <td width="40%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left">Tel Mobile</td>
                <td width="60%" style="font-size:14px;padding: 8px;border: 1px solid gray;text-align: left"><?php echo  customer_details($invoice['customer_id'])['phone'] ?></td>
            </tr>
        </table>
    </div>
</footer>

</html>

<div style="text-align: center;font-family: serif; font-size: 6pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">
    MAKRO2000 GROUP COMPANIES<br/> www.makro2000.com.tr <br/> +994 12 597 48 18 <br/>WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan
</div>