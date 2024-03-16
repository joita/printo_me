<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Productos</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
		<?php foreach($categorias as $categoria): ?>
			<li><a href="<?php echo site_url('administracion/productos/'.$categoria->nombre_categoria_slug); ?>"<?php activar($categoria_slug, $categoria->nombre_categoria_slug); ?>><i class="fa fa-tags"></i> <?php echo $categoria->nombre_categoria; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div id="main-container">
			<div class="row">
				<div class="small-24 columns">
					<?php if(isset($tipos->{0})): ?>
					<ul class="horizontal">
					<?php foreach($tipos as $tipo): ?>
						<li><a href="<?php echo site_url('administracion/productos/'.$categoria_slug.'/'.$tipo->tipo->nombre_tipo_slug); ?>"<?php activar($tipo_activo->tipo->nombre_tipo_slug, $tipo->tipo->nombre_tipo_slug); ?>><i class="fa fa-bookmark"></i> <?php echo $tipo->tipo->nombre_tipo; ?></a></li>
					<?php endforeach; ?>
					</ul>
					<?php else: ?>
					<p class="nohay text-center">No existen tipos de productos para esta categoría.</p>
					<?php endif; ?>
				</div>
			</div>
			
			<?php if(isset($tipos->{0})): ?>
				<?php $this->load->view('administracion/productos/'.$accion); ?>
			<?php endif; ?>
		</div>	
	</div>
</div>