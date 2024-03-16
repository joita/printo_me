<div class="row collapse exp">
	<div class="small-18 columns">
		<div class="owl-carousel owl-theme" id="slider-inicio">
            <?php foreach ($banners as $indice => $banner):?>
                <div class="item" <?php if($indice != 0):?>style="display:none;"<?php endif;?>>
                    <a href="<?php echo $banner->url_slide; ?>">
                        <img src="<?php echo site_url($banner->directorio."/".$banner->imagen_original); ?>" alt="<?php echo $banner->alt?>" />
                    </a>
                </div>
            <?php endforeach;?>
		</div>
        <div class="slider-responsive" style="display:none">
            <?php foreach ($banners as $indice => $banner):?>
                <div class="itemResponsive" >
                    <a href="<?php echo $banner->url_slide; ?>">
                        <img src="<?php echo site_url($banner->directorio."/".$banner->imagen_original); ?>" alt="<?php echo $banner->alt?>" />
                    </a>
                </div>
            <?php endforeach;?>
        </div>
	</div>
</div>
