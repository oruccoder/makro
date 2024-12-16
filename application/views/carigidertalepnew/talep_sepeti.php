<div class="page-header">
    <div class="page-header-content header-elements-lg-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Oluşturabileceğiniz Gider Kalemleri</span></h4>
            <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
        </div>

    </div>
</div>
<div class="content">
    <div class="content">
        <div class="content-wrapper">
            <div class="content">
                <div class="card">
                    <a href="/carigidertalepnew/index_old" class="btn btn-secondary"><i class="fa fa-list"></i> Gider Listesi</a>
                </div>
                <div class="card" style="padding: 15px;">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" >
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(1)">
                            <div class="card">
                                <img src="/userfiles/yol-taksi.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(2)">
                            <div class="card">
                                <img src="/userfiles/yemek.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(3)">
                            <div class="card">
                                <img src="/userfiles/otel.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(4)">
                            <div class="card">
                                <img src="/userfiles/azersu.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(5)">
                            <div class="card">
                                <img src="/userfiles/isiq.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(6)">
                            <div class="card">
                                <img src="/userfiles/internet.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(7)">
                            <div class="card">
                                <img src="/userfiles/avto.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(8)">
                            <div class="card">
                                <img src="/userfiles/yanacaq.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(9)">
                            <div class="card">
                                <img src="/userfiles/parking.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
<!--                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(10)">-->
<!--                            <div class="card">-->
<!--                                <img src="/userfiles/teker-deg.jpg" class="card-img-top"-->
<!--                                     alt="Makro 2000 Gider" />-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(11)">-->
<!--                            <div class="card">-->
<!--                                <img src="/userfiles/teker-tamiri-2.jpg" class="card-img-top"-->
<!--                                     alt="Makro 2000 Gider" />-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(12)">
                            <div class="card">
                                <img src="/userfiles/avto-cerime.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(13)">
                            <div class="card">
                                <img src="/userfiles/ev-kiraye.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>
                        <div class="col" style="cursor: pointer" onclick="sepete_ekle(14)">
                            <div class="card">
                                <img src="/userfiles/masin.jpg" class="card-img-top"
                                     alt="Makro 2000 Gider" />
                            </div>
                        </div>



                    </div>
                </div>
                <div class="card">
                    <button id="talep_olustur" class="btn btn-outline-secondary col-md-12"><i class="fa fa-check"></i> Talebi Tamamla</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo base_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    var url = '<?php echo base_url() ?>carigidertalepnew/file_handling';
    function sepete_ekle(tip){
        let contents='';
        let demirbas_id=0;
        let firma_demirbas_id=0;
        let cost_id='';
        if(tip==1)
        {
            contents=`<form>
<table class="table">
    <thead>
        <tr>
            <th>Açıklama</th>
            <th>Birim</th>
            <th>Miktar</th>
            <th>Birim Fiyatı</th>
        </tr>
    </thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                                <option value="0">Seçiniz</option>
                                <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                            </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>
<input id="firma_demirbas_id" type='hidden' value="39">
<input  id="cost_id" type='hidden' value='159'>
<input  id="demirbas_id" type='hidden' value='158'>
</table>
</form>`;

//demirbas_id=158; //talep_form_customer_new
//cost_id=159; //talep_form_customer_products_new
        }
        else if(tip==2)
        {
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <option value="0">Seçiniz</option>
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>
<input id="firma_demirbas_id" type='hidden' value="181">
<input  id="cost_id" type='hidden' value='244'>
<input  id="demirbas_id" type='hidden' value='29'>
</table>
</form>`;

        //    demirbas_id=29; //talep_form_customer_new
          //  cost_id=244; //talep_form_customer_products_new
        }
        else if(tip==3) //qonaqlama
        {
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">

                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input id="firma_demirbas_id" type='hidden' value="182">
<input id="demirbas_id" type='hidden' value="29">
<input  id="cost_id" type='hidden' value='1004'>
</form>`;

            firma_demirbas_id=182;//talep_form_customer_new
            demirbas_id=29; //talep_form_customer_new
           // cost_id=1004; //talep_form_customer_products_new
        }
        else if(tip==4) //su faturaları
        {
            //demirbas_id=22; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Fatura No</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
                if(get_firma_demirbas(22)['status']){
                    foreach (get_firma_demirbas(22)['items'] as $row) {
                        $id = $row['id'];
                        $title = $row['name'];
                        echo "<option value='$id'>$title</option>";
                    }
                }
                else {
                    echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
                }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='74'>
<input  id="demirbas_id" type='hidden' value='22'>
</form>`;



           // cost_id=74; //talep_form_customer_products_new
        }
        else if(tip==5) //ışıq
        {
           // demirbas_id=22; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Fatura No</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(22)['status']){
                foreach (get_firma_demirbas(22)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>
<input  id="cost_id" type='hidden' value='73'>
<input  id="demirbas_id" type='hidden' value='22'>
</table>
</form>`;



           // cost_id=73; //talep_form_customer_products_new
        }
        else if(tip==6) //internet
        {
            //demirbas_id=22; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Fatura No</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(22)['status']){
                foreach (get_firma_demirbas(22)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='1005'>
<input  id="demirbas_id" type='hidden' value='22'>
</form>`;



            cost_id=1005; //talep_form_customer_products_new
        }
        else if(tip==7) //araç yıkma
        {
        //    demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='7'>
<input  id="demirbas_id" type='hidden' value='6'>
</form>`;



        //    cost_id=7; //talep_form_customer_products_new
        }
        else if(tip==8) //yanacaq
        {
           // demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='1006'>
<input  id="demirbas_id" type='hidden' value='6'>
</form>`;



          //  cost_id=1006; //talep_form_customer_products_new
        }
        else if(tip==9) //parking
        {
           // demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>
<input  id="cost_id" type='hidden' value='430'>
<input  id="demirbas_id" type='hidden' value='6'>
</table>
</form>`;



          //  cost_id=430; //talep_form_customer_products_new
        }
        else if(tip==10) //teker değişikliği
        {
           // demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='665'>
<input  id="demirbas_id" type='hidden' value='6'>
</form>`;



          //  cost_id=665; //talep_form_customer_products_new
        }
        else if(tip==11) //teker tamiri
        {
            //demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='667'>
<input  id="demirbas_id" type='hidden' value='6'>
</form>`;



       //     cost_id=667; //talep_form_customer_products_new
        }
        else if(tip==12) //cerme
        {
            //demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
</tr>
</tbody>

</table>
<input  id="cost_id" type='hidden' value='277'>
<input  id="demirbas_id" type='hidden' value='6'>
</form>`;



            // cost_id=277; //talep_form_customer_products_new
        }
        else if(tip==13) //Ev Depo Kirayesi
        {
            // demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Depo / Ev</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(1012)['status']){
                foreach (get_firma_demirbas(1012)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
<input  id="demirbas_id" type='hidden' value='1012'>
<input  id="cost_id" type='hidden' value='1013'>
</tr>
</tbody>

</table>
</form>`;
        }
        else if(tip==14) //cerme
        {
           // demirbas_id=6; //talep_form_customer_new
            contents=`<form>
<table class="table">
<thead>
    <tr>
        <th>Açıklama</th>
        <th>Araç</th>
        <th>Gider Kalemi</th>
        <th>Birim</th>
        <th>Miktar</th>
        <th>Birim Fiyatı</th>
    </tr>
</thead>
<tbody>
<tr>
<td><input class="form-control" id="item_desc"></td>
<td>
<select name="firma_demirbas_id" id="firma_demirbas_id" class="form-control select-box">
                            <?php
            if(get_firma_demirbas(6)['status']){
                foreach (get_firma_demirbas(6)['items'] as $row) {
                    $id = $row['id'];
                    $title = $row['name'];
                    echo "<option value='$id'>$title</option>";
                }
            }
            else {
                echo "<option value='0'>Tanımlanmış Fatura Bulunmadı</option>";
            }

            ?>
                        </select>
</td>
<td>
<select class="form-control select-box group_id" types='ones' id="cost_id" name="group_id[]">
                                            <?php
            if(demirbas_group_list_who(2,6)){
            echo "<option value='0'>Seçiniz</option>";
            foreach (demirbas_group_list_who(2,6) as $emp){
            $emp_id=$emp->id;
            $name=$emp->name;
            ?>
                                                <option value="<?php echo $emp_id; ?>"><?php echo $name; ?></option>
                                            <?php }
            }
            else {
            ?>
                                                <option value="0">Grup Bulunamadı</option>
                                                <?php
            }

            ?>
                                        </select>
</td>
<td>
<select name="unit" id="item_unit" class="form-control select-box">
                            <?php
            foreach (units() as $row) {
                $id = $row['id'];
                $cid = $row['code'];
                $title = $row['name'];
                echo "<option value='$id'>$cid</option>";
            }
            ?>
                        </select>
</td>
<td><input class="form-control" id="item_qty" type='number'></td>
<td><input class="form-control" id="item_price" type='number'></td>
<input  id="demirbas_id" type='hidden' value='6'>
</tr>
</tbody>

</table>
</form>`;
        }
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Gider Listesine Ekle',
            icon: 'fa fa-plus',
            type: 'green',
            animation: 'scale',
            columnClass: "col-md-12",
            containerFluid: !0,
            draggable: false,
            content: contents,
            buttons: {
                formSubmit: {
                    text: 'Ekle',
                    btnClass: 'btn-blue',
                    action: function () {
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            firma_demirbas_id:$('#firma_demirbas_id').val(),
                            demirbas_id:$('#demirbas_id').val(),
                            tip:tip,
                            item_qty : $('#item_qty').val(),
                            cost_id : $('#cost_id').val(),
                            item_price : $('#item_price').val(),
                            item_desc : $('#item_desc').val(),
                            item_unit : $('#item_unit').val(),
                            crsf_token: crsf_hash,
                        }
                        $.post(baseurl + 'carigidertalepnew/create_cart',data,(response)=>{
                            let responses = jQuery.parseJSON(response);
                            if(responses.status==200){
                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons:{
                                        formSubmit: {
                                            text: 'Devam',
                                            btnClass: 'btn-blue',
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                            }
                            else if(responses.status==410){

                                $.alert({
                                    theme: 'material',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    animation: 'scale',
                                    useBootstrap: true,
                                    columnClass: "col-md-4 mx-auto",
                                    title: 'Dikkat!',
                                    content: responses.message,
                                    buttons:{
                                        prev: {
                                            text: 'Tamam',
                                            btnClass: "btn btn-link text-dark",
                                        }
                                    }
                                });
                                $('#loading-box').addClass('d-none');
                            }
                        });



                    }
                },
                cancel:{
                    text: 'Kapat',
                    btnClass: "btn btn-danger btn-sm",
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                })
                // bind to events
                var jc = this;
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }


        });
    }

    $(document).on('click','#talep_olustur',function (){
        $.confirm({
            theme: 'modern',
            closeIcon: true,
            title: 'Yeni İstək Əlavə Edin ',
            icon: 'fa fa-plus',
            type: 'dark',
            animation: 'scale',
            useBootstrap: true,
            columnClass: "col-md-8 mx-auto",
            containerFluid: !0,
            smoothContent: true,
            draggable: false,
            content: `
        <form id="requestForm">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="name">Layihə / Proje</label>
                    <select class="form-control select-box proje_id required" id="proje_id">
                        <option value="0">Seçiniz</option>
                        <?php foreach (all_projects() as $emp): ?>
                            <option value="<?php echo $emp->id; ?>"><?php echo $emp->code; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cari_id">Cari</label>
                    <select class="form-control select-box cari_id required" id="cari_id_news">
                        <option value="0">Seçiniz</option>
                        <?php foreach (all_customer() as $emp): ?>
                            <option value="<?php echo $emp->id; ?>"><?php echo $emp->company; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="odeme_turu">Ödeme Türü</label>
                    <select class="form-control select-box odeme_turu required" id="odeme_turu">
                        <option value="0">Seçiniz</option>
                        <option value="1">Naqd</option>
                        <option value="3">Köçürme</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="talep_eden_user_id">Talep Eden</label>
                    <select class="form-control select-box required" id="talep_eden_user_id">
                        <?php foreach (all_personel() as $emp): ?>
                            <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="progress_status_id">Təcili</label>
                    <select class="form-control select-box required" id="progress_status_id">
                        <?php foreach (progress_status() as $emp): ?>
                            <option value="<?php echo $emp->id; ?>"><?php echo $emp->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="desc">Açıqlama / Qeyd</label>
                    <textarea class="form-control required" id="desc"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="resim">Fayl</label>
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <table id="files" class="files"></table><br>
                    <span class="btn btn-success fileinput-button" style="width: 100%">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Seçiniz...</span>
                        <input id="fileupload_" type="file" name="files[]">
                        <input type="hidden" class="image_text" name="image_text" id="image_text">
                    </span>
                </div>
            </div>
        </form>`,
            buttons: {
                formSubmit: {
                    text: 'Sorğunu Açın',
                    btnClass: 'btn-blue',
                    action: function () {
                        // Form validasyonu
                        let isValid = true;
                        $('#requestForm .required').each(function () {
                            if ($(this).val() === "" || $(this).val() === "0") {
                                $(this).addClass('is-invalid'); // Hata stilini uygula
                                isValid = false;
                            } else {
                                $(this).removeClass('is-invalid'); // Hata stilini kaldır
                            }
                        });

                        if (!isValid) {
                            $.alert({
                                theme: 'modern',
                                icon: 'fa fa-exclamation',
                                type: 'red',
                                animation: 'scale',
                                title: 'Hata!',
                                content: 'Lütfen tüm alanları doldurunuz!',
                            });
                            return false; // İşlemi durdur
                        }

                        // Tüm alanlar dolu ise devam et
                        $('#loading-box').removeClass('d-none');
                        let data = {
                            crsf_token: crsf_hash,
                            progress_status_id: $('#progress_status_id').val(),
                            talep_eden_user_id: $('#talep_eden_user_id').val(),
                            proje_id: $('#proje_id').val(),
                            method: $('#odeme_turu').val(),
                            cari_id: $('#cari_id_news').val(),
                            desc: $('#desc').val(),
                            image_text: $('#image_text').val(),
                        };

                        $.post(baseurl + 'carigidertalepnew/create_save_cart', data, (response) => {
                            let responses = jQuery.parseJSON(response);
                            $('#loading-box').addClass('d-none');
                            if (responses.status === 200) {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-check',
                                    type: 'green',
                                    title: 'Başarılı',
                                    content: responses.message,
                                    buttons: {
                                        formSubmit: {
                                            text: 'Tamam',
                                            btnClass: 'btn-blue',
                                            action: function () {
                                                location.href = responses.index;
                                            }
                                        }
                                    }
                                });
                            } else {
                                $.alert({
                                    theme: 'modern',
                                    icon: 'fa fa-exclamation',
                                    type: 'red',
                                    title: 'Hata!',
                                    content: responses.message,
                                });
                            }
                        });
                    }
                },
                cancel: {
                    text: 'Vazgeç',
                    btnClass: 'btn-danger',
                }
            },
            onContentReady: function () {
                $('.select-box').select2({
                    dropdownParent: $(".jconfirm-box-container")
                });
            }
        });

    })
</script>

