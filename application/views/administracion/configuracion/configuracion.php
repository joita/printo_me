<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Configuración</h2>
	</div>
</div>
<form action="<?php echo site_url('administracion/configuracion/modificar'); ?>" method="post" data-abide>
<div class="row">
	<div class="small-24 columns">
		<ul class="divisor">
		<?php foreach($this->configuracion_modelo->obtener_configuracion() as $configuracion): ?>
			<li style="margin-top:0.5rem;margin-bottom:1.5rem;">
				<div class="row">
					<div class="small-8 columns">
						<span class="categoria-principal"><i class="fa fa-gear"></i> <?php echo $configuracion->nombre_configuracion; ?></span>
					</div>
					<div class="small-8 columns">
						<span class="categoria-principal"> <input type="text" name="configuracion[<?php echo $configuracion->id_configuracion; ?>]" value="<?php echo $configuracion->valor_configuracion; ?>" pattern="<?php echo $configuracion->tipo_valor; ?>" required></span>
					</div>
					<div class="small-8 columns text-right function-links">
					</div>
				</div>				
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
</div>
<hr>
<div class="row">
	<div class="small-24 columns text-center">
		<button type="submit">Guardar Cambios</button>
	</div>
</div>
</form>