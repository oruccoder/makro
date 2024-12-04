<p style="font-size: 10px">* Malzeme talep edildikten  3 gün sonra teslim edilecektir.<br>
    **Yanlış ürün gelmemesi için istenilen ürünü detaylı olarak belirtmeyi unutmayınız.<br>
    ***İsim, soyadı ve imza olarak onaylayınız lütfen.
    <footer style="padding-bottom: 50px">
    </p>
    <table  style="font-size: 12px">

        <tr>
            <td style="text-align: center"><b>Talep Eden</b></td>
            <td style="text-align: center"><b>Proje Sorumlusu </b></td>
            <td style="text-align: center"><b>Proje Müdürü</b></td>
            <td style="text-align: center"><b>Bölüm Müdürü</b></td>
            <td style="text-align: center"><b>GENEL  MÜDÜR</b></td>
        </tr>
        <tr>
            <td style="text-align: center">
                <?php echo personel_details($invoice['talep_eden_pers_id']) ?>


            </td>
            <td style="text-align: center">
                <?php echo personel_details($invoice['proje_sorumlusu_id']) ?>


            </td>
            <td style="text-align: center">
                <?php echo personel_details($invoice['proje_muduru_id']) ?>

            </td>
            <td style="text-align: center">
                <?php echo personel_details($invoice['proje_muduru_id']) ?>


            </td>
            <td style="text-align: center">
                LOKMAN BİTER<br/>

            </td>
        </tr>

    </table>
</footer>

</body>
</html>

<div style="text-align: center;font-family: serif; font-size: 6pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">
    MAKRO2000 GROUP COMPANIES<br/> www.makro2000.com.tr <br/> +994 12 597 48 18 <br/>WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan
</div>
