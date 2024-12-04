<style>
    .bold_sonuc{
        font-weight: bolder;
        color: chocolate;
    }
</style>
<table class="table-bordered table" style="font-size: 17px;font-weight: bold;">
    <thead>
    <tr>
        <td>No</td>
        <td>Form Tipi</td>
        <td>Toplam</td>
        <td>Ödeme Metodu</td>
        <td>Tutar (KDV Hariç)</td>
    </tr>
    </thead>
    <tbody>

    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Cari Ödemeleri</td>
        <td rowspan="2"><span class="<?php echo ozet_totals(1)['span_t']?>"><?php echo amountFormat(ozet_totals(1)['toplam'])?></span></td>
        <td>Banka</td>
        <td><span class="<?php echo ozet_totals(1)['span_b']?>"><?php echo amountFormat(ozet_totals(1)['banka'])?></span></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><span class="<?php echo ozet_totals(1)['span_n']?>"><?php echo amountFormat(ozet_totals(1)['nakit'])?></span></td>
    </tr>
    <!-- -->
    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Forma 2 Ödemesi</td>
        <td rowspan="2"><span class="<?php echo ozet_totals(1)['span_t']?>"><?php echo amountFormat(ozet_totals(1)['toplam'])?></span></td>
        <td>Banka</td>
        <td><span class="<?php echo ozet_totals(1)['span_b']?>"><?php echo amountFormat(ozet_totals(1)['banka'])?></span></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><span class="<?php echo ozet_totals(1)['span_n']?>"><?php echo amountFormat(ozet_totals(1)['nakit'])?></span></td>
    </tr>
    <tr>
        <td rowspan="2">2</td>
        <td rowspan="2">Fatura Ödeme</td>
        <td rowspan="2">Toplam</td>
        <td>Banka</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>
    <tr>
        <td rowspan="2">3</td>
        <td rowspan="2">Personel Gider</td>
        <td rowspan="2">0</td>
<!--        <td rowspan="2"><span class="--><?php //echo ozet_totals(3)['span_t']?><!--">--><?php //echo amountFormat(ozet_totals(3)['toplam'])?><!--</span></td>-->
        <td>Banka</td>
<!--        <td><span class="--><?php //echo ozet_totals(3)['span_b']?><!--">--><?php //echo amountFormat(ozet_totals(3)['banka'])?><!--</span></td>-->
        <td>0</td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td>0</td>
<!--        <td><span class="--><?php //echo ozet_totals(3)['span_n']?><!--">--><?php //echo amountFormat(ozet_totals(3)['nakit'])?><!--</span></td>-->
    </tr>
    <tr>
        <td rowspan="2">4</td>
        <td rowspan="2">Personel Avans</td>
        <td rowspan="2"><span class="<?php echo ozet_totals(4)['span_t']?>"><?php echo amountFormat(ozet_totals(4)['toplam'])?></span></td>
        <td>Banka</td>
        <td><span class="<?php echo ozet_totals(4)['span_b']?>"><?php echo amountFormat(ozet_totals(4)['banka'])?></span></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><span class="<?php echo ozet_totals(4)['span_n']?>"><?php echo amountFormat(ozet_totals(4)['nakit'])?></span></td>
    </tr>
    <tr>
        <td rowspan="2">5</td>
        <td rowspan="2">Cari Avans</td>
        <td rowspan="2"><span class="<?php echo ozet_totals(5)['span_t']?>"><?php echo amountFormat(ozet_totals(5)['toplam'])?></span></td>
        <td>Banka</td>
        <td><span class="<?php echo ozet_totals(5)['span_b']?>"><?php echo amountFormat(ozet_totals(5)['banka'])?></span></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><span class="<?php echo ozet_totals(5)['span_n']?>"><?php echo amountFormat(ozet_totals(5)['nakit'])?></span></td>
    </tr>
    <tr>
        <td rowspan="2">6</td>
        <td rowspan="2">Cari Gider</td>
        <td rowspan="2"><span class="<?php echo ozet_totals(6)['span_t']?>"><?php echo amountFormat(ozet_totals(6)['toplam'])?></span></td>
        <td>Banka</td>
        <td><span class="<?php echo ozet_totals(6)['span_b']?>"><?php echo amountFormat(ozet_totals(6)['banka'])?></span></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><span class="<?php echo ozet_totals(6)['span_n']?>"><?php echo amountFormat(ozet_totals(6)['nakit'])?></span></td>
    </tr>
    <tr>
        <td rowspan="2">7</td>
        <td rowspan="2">Lojistik</td>
        <td rowspan="2"><span class="<?php echo ozet_totals(7)['span_t']?>"><?php echo amountFormat(ozet_totals(7)['toplam'])?></span></td>
        <td>Banka</td>
        <td><span class="<?php echo ozet_totals(6)['span_b']?>"><?php echo amountFormat(ozet_totals(7)['banka'])?></span></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><span class="<?php echo ozet_totals(6)['span_n']?>"><?php echo amountFormat(ozet_totals(7)['nakit'])?></span></td>
    </tr>
    <tr>
        <td rowspan="2">8</td>
        <td rowspan="2">MT</td>
        <td rowspan="2">Toplam</td>
        <td>Banka</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>
    <tr>
        <td>Nakit</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>

    <tr>
        <td rowspan="1">9</td>
        <td>Nakit Ödenecek</td>
        <td>-</td>
        <td>-</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>

    <tr>
        <td rowspan="1">10</td>
        <td>Banka Ödenecek</td>
        <td>-</td>
        <td>-</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>
    <tr>
        <td rowspan="1">11</td>
        <td>Toplam Ödenecek</td>
        <td>-</td>
        <td>-</td>
        <td><?php echo amountFormat(0)?></td>
    </tr>
    </tbody>
</table>