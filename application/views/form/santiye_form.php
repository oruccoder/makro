<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Şantiye İşbaşvuru Formu</title>

    <style>
        body {
            color: #2B2000;
        }

        .page {
            width: 210mm;
            height: 297mm;


        }


    </style>
</head>



<body style="font-family: Helvetica;">
<div class="page">
    <table>
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location($this->aauth->get_user()->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                     style="padding-left:18px;max-height:180px;max-width:250px;">
            </td>
            <td style="padding: 10px;width: 700px;">
                Makro 2000 Eğİtim Teknolojileri İnşaat Taahhüt  İç ve Dıs.<br>
                Ticaret Anonim“ Şirketinin  Azərbaycan Respublikasındakı Filialı<br>
                VÖEN: 1800732691 Baku / Azerbaycan<br>
                Phone : +994 12 597 48 18   Mail : info@makro2000.com.tr<br>
            </td>


        </tr>

    </table>
    <br>
    <p style="color: gray">Aşağıda geyd olun bölüm Proje Müdürü / Personel Müdürü veya Podratçı  tərəfindən doldurilacaxtir</p>
    <table style="border: 2px solid #4a4a4a;width: 100%;font-size: 11px">
        <tr>
            <td style="border: 1px solid;">İŞLƏMƏ METODU</td>
            <td style="border: 1px solid;">□ TAM VAXTLI </td>
            <td style="border: 1px solid;">□ YARIM GÜN</td>
            <td style="border: 1px solid;">□ LAHİYE  </td>
            <td style="border: 1px solid;">□ DİGƏR  </td>
        </tr>
        <tr>
            <td style="border: 1px solid;" colspan="3">MAAŞ</td>
            <td style="border: 1px solid;" colspan="2">DİGƏR</td>

        </tr>

        <tr>
            <td style="border: 1px solid;" rowspan="2" colspan="1">İŞÇİ PULLARIN VERƏCƏK ŞƏXS </td>
            <td style="border: 1px solid;" colspan="4">□ Podratçı </td>
        </tr>
        <tr>

            <td style="border: 1px solid;" colspan="4">□ Sifarişçi </td>




        </tr>


        <tr>
            <td style="border: 1px solid;" colspan="3">İŞLƏDİYİ YER 1 </td>
            <td style="border: 1px solid;" colspan="2">BAŞLANĞIÇ -BİTİŞ TARİXİ</td>

        </tr>
        <tr>
            <td style="border: 1px solid;" colspan="3">İŞLƏDİYİ YER 2 </td>
            <td style="border: 1px solid;" colspan="2">BAŞLANĞIÇ -BİTİŞ TARİXİ</td>

        </tr>
        <tr>
            <td style="border: 1px solid;" colspan="3">REFERANS </td>
            <td style="border: 1px solid;" colspan="2">REFERANS TELEFON NO</td>

        </tr>
        <tr>
            <td style="border: 1px solid;" colspan="1" rowspan="2">DİGƏR DETAY </td>
            <td  colspan="4"> &nbsp;</td>

        </tr>
        <tr>
            <td colspan="4"> &nbsp;</td>
        </tr>


    </table>
    <br>
    <p style="text-align: center;color: gray">varsa</p>

    <table style="text-align: center;width: 100%;font-size: 13px">
        <tr>
            <td colspan="1">PROJE SORUMLUSU</td>
            <td colspan="1">PROJE MÜDÜRÜ</td>
            <td colspan="1">PODRATCI Müdürü</td>
            <td colspan="1">PERSONEL MÜDÜRÜ</td>
            <td colspan="1">MUHASİBƏ  Departmanı</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <table style="text-align: center;width: 100%;">
        <tr>
            <td colspan="2">□ Gözdəmə</td>
            <td colspan="2">□ İşə gəbul </td>
            <td colspan="2">□  Mənfi</td>
            <td colspan="2">GENEL MÜDÜR <br>LOKMAN BİTER</td>
        </tr>
    </table>


</div>

</body>
</html>
