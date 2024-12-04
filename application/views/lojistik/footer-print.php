<!--<p style="font-size: 10px">* Malzeme talep edildikten  3 gün sonra teslim edilecektir.<br>-->
<!--    **Yanlış ürün gelmemesi için istenilen ürünü detaylı olarak belirtmeyi unutmayınız.<br>-->
<!--    ***İsim, soyadı ve imza olarak onaylayınız lütfen .    </p>-->
<footer style="padding-bottom: 50px">

    <table  style="font-size: 12px">

        <tr>
            <td style="text-align: center"><b>Lojistik Müdürü</b></td>
            <td style="text-align: center"><b>Proje Müdürü </b></td>
            <td style="text-align: center"><b>GENEL  MÜDÜR</b></td>
        </tr>
        <tr>

            <th><?php echo personel_details($details->lojistik_muduru) ?><?php echo lojistik_durum_kontrol($details->lojistik_muduru,$details->id)?></th>
            <th><?php echo personel_details($details->proje_muduru) ?><?php echo lojistik_durum_kontrol($details->proje_muduru,$details->id) ?></th>
            <th><?php echo personel_details($details->genel_mudur) ?><?php echo lojistik_durum_kontrol($details->genel_mudur,$details->id) ?></th>
        </tr>

    </table>
</footer>

</body>
</html>

<div style="text-align: center;font-family: serif; font-size: 6pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">
    MAKRO2000 GROUP COMPANIES<br/> www.makro2000.com.tr <br/> +994 12 597 48 18 <br/>WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan
</div>
