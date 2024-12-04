<!--<p style="font-size: 10px">* Malzeme talep edildikten  3 gün sonra teslim edilecektir.<br>-->
<!--    **Yanlış ürün gelmemesi için istenilen ürünü detaylı olarak belirtmeyi unutmayınız.<br>-->
<!--    ***İsim, soyadı ve imza olarak onaylayınız lütfen .    </p>-->
<footer style="padding-bottom: 50px">

    <table  style="font-size: 12px">

        <tr>
            <td style="text-align: center"><b>Proje Müdürü</b></td>
            <td style="text-align: center"><b>Genel Müdür </b></td>
            <td style="text-align: center"><b>Teknixa Sorumlusu</b></td>
        </tr>
        <tr>

                    <th><?php echo personel_details($users[0]->user_id)?><?php echo arac_form_step_durum($users[0]->user_id,$details->id) ?></th>
                    <th><?php echo personel_details($users[1]->user_id)?><?php echo arac_form_step_durum($users[1]->user_id,$details->id) ?></th>
                    <th><?php echo personel_details($users[2]->user_id)?><?php echo arac_form_step_durum($users[2]->user_id,$details->id) ?></th>
        </tr>

    </table>
</footer>

</body>
</html>

<div style="text-align: center;font-family: serif; font-size: 6pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">
    MAKRO2000 GROUP COMPANIES<br/> www.makro2000.com.tr <br/> +994 12 597 48 18 <br/>WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan
</div>
