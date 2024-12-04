<!--<p style="font-size: 10px">* Malzeme talep edildikten  3 gün sonra teslim edilecektir.<br>-->
<!--    **Yanlış ürün gelmemesi için istenilen ürünü detaylı olarak belirtmeyi unutmayınız.<br>-->
<!--    ***İsim, soyadı ve imza olarak onaylayınız lütfen .    </p>-->
<footer style="padding-bottom: 50px">
    <table class="table" style="font-size: 12px;text-align: center">

        <tr>
            <td style="text-align: center"><b>Talep Eden Personel</b></td>
            <td style="text-align: center"><b>Bölüm Müdürü</b></td>
            <td style="text-align: center"><b>Ofis Menejeri</b></td>
        </tr>
        <tr>
            <td style="text-align: center"><?php echo personel_details($details->user_id) ?></td>
            <td style="text-align: center"> <?php echo personel_details(personel_details_full($details->user_id)['sorumlu_pers_id']);?></td>
            <td style="text-align: center">ABDULLAYEVA LAMIYYƏ SAKIT QIZI</td>
        </tr>

    </table>
</footer>

</body>
</html>

<div style="text-align: center;font-family: serif; font-size: 6pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">
    MAKRO2000 GROUP COMPANIES<br/> www.makro2000.com.tr <br/> +994 12 597 48 18 <br/>WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan
</div>


<?php

