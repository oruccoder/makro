
    <footer style="padding-bottom: 50px">

<table  style="font-size: 12px">

    <tr>
        <td style="text-align: center"><b>Sorumlu Personel</b></td>
        <td style="text-align: center"><b>Proje Sorumlusu </b></td>
        <td style="text-align: center"><b>Proje Müdürü</b></td>
        <td style="text-align: center"><b>Bölüm Müdürü</b></td>
        <td style="text-align: center"><b>GENEL  MÜDÜR</b></td>
        <td style="text-align: center"><b>Finans Departmanı</b></td>
    </tr>
    <tr>
        <td style="text-align: center">
            <?php echo personel_details($invoice['kullanici_id']) ?>


        </td>
        <td style="text-align: center">
            <?php echo personel_details($invoice['proje_sorumlusu_id']) ?>


        </td>
        <td style="text-align: center">
            <?php echo personel_details($invoice['bolum_mudur_id']) ?>

        </td>
        <td style="text-align: center">
            <?php echo personel_details($invoice['proje_muduru_id']) ?>


        </td>
        <td style="text-align: center">
            LOKMAN BİTER<br/>

        </td>
        <td style="text-align: center">
            <?php echo personel_details($invoice['finans_departman_pers_id']) ?><br/>

        </td>
    </tr>

</table>
</footer>

</body>
</html>

<div style="text-align: center;font-family: serif; font-size: 6pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">
    MAKRO2000 GROUP COMPANIES<br/> www.makro2000.com.tr <br/> +994 12 597 48 18 <br/>WORLD BUSINESS CENTER Səməd Vurgun 43, 3. Mertebe Nesimi Region Baku/Azerbaycan
</div>
