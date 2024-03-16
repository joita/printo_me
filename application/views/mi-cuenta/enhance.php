<div class="row padded">
	<div class="small-24 columns medium-centered">
		<h3 class="text-center">Mis Diseños</h3>
		<?php $enhances = $this->enhance_modelo->get($this->session->login['id_cliente']); ?>
		<div class="row">
			<div class="small-24 columns">
				<?php if(count($enhances)>0): ?>
				<?php foreach($enhances as $enhance): ?>
					<?php $enhance->solds = 0 //$this->enhances_modelo->solds($enhance->id_enhance) ?>
				<div class="row">
					<div class="small-24 medium-24 large-22 large-centered columns">
						<div class="row bar_menu">
							<div class="small-24 medium-6 large-4 columns">
								<p>Diseño:<br> <strong><?php echo $enhance->id_enhance; ?></strong></p>
							</div>
							<div class="small-24 medium-6 large-4 columns">
								<p>Fecha:<br> <strong><?php echo date("d/m/Y", strtotime($enhance->date)); ?></strong></p>
								<p>Fecha fin:<br> <strong><?php echo date("d/m/Y", strtotime($enhance->end_date)); ?></strong></p>
							</div>
							<div class="small-24 medium-6 large-4 columns">
								<p>Monto:<br>
								Costo por playera: <strong><?php echo '$'.$this->cart->format_number($enhance->price); ?></strong><br>
								Total recaudado: <strong><?php echo '$'.$this->cart->format_number($enhance->price * $enhance->solds); ?></strong>
								</p>
							</div>
							<div class="small-24 medium-6 large-4 columns">
								<div class="enhance_images">
									<?php if($enhance->front_image != ""): ?><img src="<?php echo site_url($enhance->front_image); ?>" alt=""><?php endif; ?>
									<?php if($enhance->back_image != ""): ?><img src="<?php echo site_url($enhance->back_image); ?>" alt=""><?php endif; ?>
									<?php if($enhance->right_image != ""): ?><img src="<?php echo site_url($enhance->right_image); ?>" alt=""><?php endif; ?>
									<?php if($enhance->left_image != ""): ?><img src="<?php echo site_url($enhance->left_image); ?>" alt=""><?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
				<?php else: ?>
				<p class="text-center padded" style="margin-bottom:15rem;">No has realizado diseños en nuestra tienda.</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(".enhance_images").slick();
	})
</script>

