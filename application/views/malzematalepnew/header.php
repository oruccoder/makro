<?php
$one_class='';
$two_class='';
$talep_sureci_class='';
$disable='';
$mobile_none='mobile_none';




if($status_head==21){
    $one_class='active';

}
if($status_head==17){
    $two_class='active';

}
if($status_head==1){
    $talep_sureci_class='active';

}

?>
<ul class="nav nav-pills">
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $one_class ?> <?php if($status_head!=21) echo $mobile_none?> " onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>?status=21'">Mahsul Ekleme Süreci</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border  <?php if($status_head!=17) echo $mobile_none?>  <?php echo $two_class ?>" <?php echo $disable?> onclick="location.href='/malzemetalepnew/stok_kontrol_view/<?php echo $details->id?>?status=17';" >Stok Kontrol Süreci</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php if($status_head!=1) echo $mobile_none?> <?php echo $talep_sureci_class?> "  <?php echo $disable?> onclick="location.href='/malzemetalepnew/talep_sureci/<?php echo $details->id?>?status=1';" >Talep Süreci</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>" <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Cari Süreci</button>
    </li>

    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>"  <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Teklif Süreci</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>"  <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Muqayese Süreci</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>"  <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Teklif Son Durum</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>" <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Nakliye</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>"  <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Ön Ödeme</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>" <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Senetler</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>" <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Çatdırılma Süreci</button>
    </li>
    <li class="nav-item">
        <button class="nav-link no-border <?php echo $mobile_none ?>" <?php echo $disable?> onclick="location.href='/malzemetalepnew/view/<?php echo $details->id?>';" >Qaime</button>
    </li>
</ul>