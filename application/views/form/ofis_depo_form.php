<!doctype html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ofis ve Depo İşbaşvuru Formu</title>

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
            <td style="border: 2px solid gray;border-style: dotted;width: 150px;">

            </td>

        </tr>
        <tr>
            <td colspan="2">
                <h4 style="font-weight: 600;color: #888888;">ƏMƏKDAŞLARİN MƏLUMAT ANKETİ</h4>
            </td>
            <td style="padding-top: 10px;font-size: 13px">
                TARİH : 	….. / ….. / 2020<br>
                iŞÇİ NO:
            </td>
        </tr>
    </table>
    <table style="border: 2px solid #4a4a4a;font-size: 14px">
        <tr>
            <td style="border: 1px solid;width: 200px;">SOYADI</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">ADI</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;" colspan="2">VƏTƏNDAŞLIĞI</td>
            <td style="border: 1px solid;width: 275px;">□ AZERBAYCAN </td>
            <td style="border: 1px solid;width: 275px;">□ DİĞER  .............................</td>
        </tr>
        <tr>
            <td style="border: 1px solid;" colspan="2">CİNSİ</td>
            <td style="border: 1px solid;width: 275px;">□ QADIN </td>
            <td style="border: 1px solid;width: 275px;">□ KİŞİ</td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">DOĞULDUĞU TARİX</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">DOĞULDUĞU YER</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">FİN NO (AZE)</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">ETİBARLIDIR</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">SÜRÜCÜLÜK VƏSİGƏSİ</td>
            <td style="border: 1px solid;width: 275px;">□ YOX   □ VAR  VƏSİGƏ NO: ……… </td>
            <td style="border: 1px solid;width: 100px;">ETİBARLIDIR</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="color: gray;border: 1px solid;width: 200px;">XARİCİ vətəndaş isəniz:</td>
            <td style="border: 1px solid;color: gray;" colspan="3"></td>
        </tr>
        <tr>
            <td style="color: gray;border: 1px solid;width: 200px;">PASPORT NO</td>
            <td style="border: 1px solid;width: 275px;">&nbsp; </td>
            <td style="color: gray;border: 1px solid;width: 100px;">ETİBARLIDIR</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="color: gray;border: 1px solid;width: 200px;">XARICI VƏSİGƏ NO</td>
            <td style="border: 1px solid;width: 275px;">&nbsp; </td>
            <td style="color: gray;border: 1px solid;width: 100px;">ETİBARLIDIR</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="color: gray;border: 1px solid;width: 200px;">AZE FİN NO</td>
            <td style="border: 1px solid;width: 275px;">&nbsp; </td>
            <td style="color: gray;border: 1px solid;width: 100px;">ETİBARLIDIR</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>

        <tr>
            <td rowspan="2" style="border: 1px solid;width: 200px;">ADRES 1</td>
            <td style="border: 1px solid;width: 200px;">YAŞAYIŞ YERİ</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">Rayon</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>

        <tr>
            <td rowspan="2" style="border: 1px solid;width: 200px;">ADRES 2</td>
            <td style="border: 1px solid;width: 200px;">YAŞAYIŞ YERİ</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">Rayon</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>

        <tr>
            <td rowspan="2" style="border: 1px solid;width: 200px;"><p style="color: gray;">Xarici Vətəndaş isəniz:</p>
                Ölkenizdəki Adres</td>
            <td style="border: 1px solid;width: 200px;">YAŞAYIŞ YERİ</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">Şəhər / Ülke</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>

        <tr>
            <td rowspan="2" style="border: 1px solid;width: 200px;"><p style="color: gray;">Xarici Vətəndaş isəniz:</p>
                Ailə Telefon No</td>
            <td style="border: 1px solid;width: 200px;">Telefon 1</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">Telefon 2</td>
            <td style="border: 1px solid;" colspan="2"> &nbsp; </td>
        </tr>

        <tr>
            <td style="border: 1px solid;width: 200px;">AİLƏ VƏZİYƏTİ</td>
            <td style="border: 1px solid;width: 275px;">□ EVLİ </td>
            <td style="border: 1px solid;" colspan="2">□ SUBAY</td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">UŞAG</td>
            <td style="border: 1px solid;width: 275px;">□ YOX </td>
            <td style="border: 1px solid;" colspan="2">□ VAR &nbsp; &nbsp;NƏFƏR: ……..</td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">TELEFON 1</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">TELEFON 2 </td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">e-mail</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">e-mail 2 </td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">GAN GRUPU</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">YAXIN BİRİNİN NO </td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">XARİCİ DİL</td>
            <td style="border: 1px solid;width: 275px;">□ YOX </td>
            <td style="border: 1px solid;" colspan="2">□ VAR &nbsp;&nbsp;……………..</td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">DİPLOM</td>
            <td style="border: 1px solid;" colspan="3"> &nbsp;</td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">SERTİFİKAT</td>
            <td style="border: 1px solid;" colspan="3"> &nbsp;</td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">İŞLƏYƏCƏYİ  FİRMA</td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
            <td style="border: 1px solid;width: 100px;">BÖLÜM </td>
            <td style="border: 1px solid;width: 275px;"> &nbsp; </td>
        </tr>
        <tr>
            <td style="border: 1px solid;width: 200px;">VƏZİFƏ</td>
            <td style="border: 1px solid;" colspan="3"> &nbsp;</td>
        </tr>

    </table>
    <br>
    <p>Yuxarida geyd etdiyim məlumatların doğru ve tam olduğunu bəyan edirəm</p>
    <br>
    <p>ƏMƏKDAŞ İMZA</p>

</div>
<div class="page">
    <table >
        <tr>
            <td class="myco">
                <img src="<?php  $loc=location($this->aauth->get_user()->loc);  echo base_url('userfiles/company/' . $loc['logo']) ?>"
                     style="padding-left:18px;max-height:180px;max-width:250px;">
            </td>
            <td  style="padding: 10px;width: 700px;">
                Makro 2000 Eğİtim Teknolojileri İnşaat Taahhüt  İç ve Dıs.<br>
                Ticaret Anonim“ Şirketinin  Azərbaycan Respublikasındakı Filialı<br>
                VÖEN: 1800732691 Baku / Azerbaycan<br>
                Phone : +994 12 597 48 18   Mail : info@makro2000.com.tr<br>
            </td>


        </tr>
        <tr>
            <td colspan="2">
                <p style="font-weight: 600;color: #888888;">Aşağıda geyd olun bölüm Proje Müdürü / Personel Müdürü veya Podratçı  tərəfindən doldurilacaxtir</p>
            </td>

        </tr>
    </table>
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

    <table style="text-align: center;width: 100%;">
        <tr>
            <td colspan="2">BÖLÜM MÜDÜRÜ</td>
            <td colspan="2">PERSONEL MÜDÜRÜ</td>
            <td colspan="2">MUHASİBƏ  Departmanı</td>
        </tr>
    </table>
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
