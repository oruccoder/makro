<div class="page-header-content header-elements-lg-inline card">
    <input type="hidden" id="talep_id" value="<?php echo $details->id ?>">
    <input type="hidden" id="talep_code" value="<?php echo $details->code ?>">
    <div class="page-title d-flex">
        <h4><span class="font-weight-semibold">Malzeme Talep Görüntüle - <?php echo $details->code ?></span></h4>
        <a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
    </div>
    <div class="widget-body" style="padding: 15px;">
        <a href="/malzemetalepform" class="hover_effect btn btn-secondary" data-original-title="Bilgilendirme"   data-popup="popover" data-trigger="hover" data-placement="top" data-content="İstek Siyahısı"><i class="fa fa-arrow-left"></i></a>
        <button type="button" class="hover_effect btn btn-secondary talep_notes" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep Hakkında Notlar" talep_id="<?php echo $details->id ?>"><i class="fa fa-list"></i></button>
        <?php if($details->status==10){
            ?>
            <button type="button" class="hover_effect btn btn-secondary talep_reverse" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="İptal İşlemini Geri Al" talep_id="<?php echo $details->id ?>" ><i class="fa fa-reply"></i></button>

            <?php

        } else {

            ?>

            <?php  if($this->aauth->get_user()->id==741 || $this->aauth->get_user()->id==21 ||  $this->aauth->get_user()->id==39 || $this->aauth->get_user()->id==735) { ?>
                <button type="button" class="hover_effect btn btn-danger talep_sil" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talep İptal Et" ><i class="fa fa-ban"></i></button>

            <?php  }?>
            <?php
        } ?>


        <!--                                                                    <button type="button" class="btn btn-success cari_update" talep_id="--><?php //echo $details->id ?><!--"><i class="fa fa-pen"></i> Cari Değiştir</button>-->
        <button type="button" class="hover_effect btn btn-secondary talep_donustur"  talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Talebi Bir Önceki Adıma Al"><i class="fa fa-reply"></i></button>
        <button type="button" class="hover_effect btn btn-secondary talep_pay" talep_id="<?php echo $details->id ?>" data-original-title="Bilgilendirme"  data-popup="popover" data-trigger="hover" data-placement="top" data-content="Ödeme Ekle"><i class="fa fa-money-bill"></i></button>
        <button  islem_tipi="7" islem_id="<?php echo $details->id ?>" type="button" class="hover_effect btn btn-secondary add_not_new" data-popup="popover" data-trigger="hover" data-original-title="Bilgilendirme"  data-placement="top" data-content="Not Ekle"><i class="fa fa-notes-medical"></i></button>
        <button  onclick="details_notes()" type="button" class="hover_effect btn btn-secondary button_view_notes" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Notları Görüntüle"><i class="fa fa-list-alt"></i></button>
        <button  type="button" class="hover_effect btn btn-secondary button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="1" tip="create" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandır"><i class="fa fa-credit-card"></i></button>
        <button  type="button" class="hover_effect btn btn-secondary button_podradci_borclandirma" islem_id="<?php echo $details->id ?>" islem_tipi="1" tip="talep" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Podradçi / Personel Borçlandırma Talep Et"><i class="fa fa-money-bill-wave-alt"></i></button>

        <button <?php echo ($details->status != 1) ? 'disabled="disabled"' : ''; ?>
                type="button" class="hover_effect btn btn-secondary bildirim_baslat" data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Stok Kontrol Onayı Başlat"><i class="fa fa-bell"></i></button>

        <button  type="button" class="hover_effect btn btn-secondary history_view"  data-popup="popover" data-trigger="hover" data-placement="top" data-original-title="Bilgilendirme"  data-content="Talep Hareketlerini Görüntüle"><i class="fa fa-list"></i></button>

<!--        --><?php //if(mt_nakliye($details->id)){ ?>
<!--            <button type="button" id="ljt_view"  mt_id="--><?php //echo $details->id ?><!--" class="btn btn-secondary flash-button">-->
<!--                <i class="fa fa-truck fa-2x"></i>&nbsp; Lojistik Hareketleri-->
<!--            </button>-->
<!--        --><?php //  }  ?>


    </div>

</div>


<style>


    .hover_effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .timeline {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0 15px 0;
        white-space: nowrap;
    }

    .timeline-step {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        margin-right: 5px;
        background: #6c757d;
        color: white;
        font-size: 14px;
        font-weight: bold;
        border-radius: 0;
        text-transform: uppercase;
        white-space: nowrap;
        cursor: pointer;
    }
    .timeline-step.highlight {
        background-color: #048fdc;
        color: #ffffff;
    }
    .timeline-step.highlight::after {
        content: "";
        position: absolute;
        top: 50%;
        right: -10px;
        transform: translateY(-50%);
        border-left: 10px solid #048fdc;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
    }

    .timeline-step.completed {
        background: #596782;
    }

    .timeline-step.active {
        background: #ffc107;
    }
    .timeline-container:before{
        background-color:transparent !important;
    }

    .timeline-step.disabled {
        background: #ddd;
        color: #9d9b9b;
        cursor: not-allowed;
    }

    .timeline-step::after {
        content: "";
        position: absolute;
        top: 50%;
        right: -10px;
        transform: translateY(-50%);
        border-left: 10px solid #6c757d;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
    }

    .timeline-step.completed::after {
        border-left-color: #596782;
    }

    .timeline-step.active::after {
        border-left-color: #ffc107;
    }

    .timeline-step.disabled::after {
        border-left-color: #ddd;
    }

    .timeline-step:last-child::after {
        content: none;
    }

    .timeline-container {
        overflow-x: auto;
        padding: 10px;
    }
</style>
<script>
    $(document).ready(function () {
        $('.history_view').on('click', function () {
            const card = $('#history_card');

            if (card.css('visibility') === 'hidden') {
                card.css('visibility', 'visible').slideDown('slow'); // Açılma efekti
            } else {
                card.slideUp('slow', function () {
                    card.css('visibility', 'hidden'); // Kapanma efekti

                });
            }
        });
    });

</script>