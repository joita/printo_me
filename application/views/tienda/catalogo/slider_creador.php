<!-- slider_area -->
<div class="slider_areav2">
    <div class="slider_active2 owl-carousel owl-theme">
        <?php if($slider[0]->slider_uno !== '' && $slider[0]->slider_uno !== null ): ?>
            <div class="single_slider  d-flex align-items-center  " style="background-image: url(<?php echo site_url('assets/images/slider_clientes/'.$slider[0]->slider_uno); ?>) "></div>

        <?php endif ?>
        <?php if($slider[0]->slider_dos !== '' && $slider[0]->slider_dos !== null ): ?>
            <div class="single_slider  d-flex align-items-center  " style="background-image: url(<?php echo site_url('assets/images/slider_clientes/'.$slider[0]->slider_dos); ?>) "></div>

        <?php endif ?>
        <?php if($slider[0]->slider_tres !== '' && $slider[0]->slider_tres !== null): ?>
            <div class="single_slider  d-flex align-items-center  " style="background-image: url(<?php echo site_url('assets/images/slider_clientes/'.$slider[0]->slider_tres); ?>) "></div>
        <?php endif ?>

    </div>
</div>