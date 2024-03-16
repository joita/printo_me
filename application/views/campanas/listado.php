	<div class="row upper-pag">
		<div class="small-18 show-for-large large-12 columns">
			<div class="text-left"><?php echo $paginacion; ?></div>
		</div>
		<div class="small-18 large-6 columns">
			<form method="get" id="form-buscador-catalogo" enctype="application/x-www-form-urlencoded" data-abide novalidate>
				<input type="text" id="buscador-catalogo" style="font-weight:bold;" placeholder="Buscar por palabra clave..."<?php if(isset($filtros['busqueda'])) { echo ' value="'.$filtros['busqueda'].'"'; } ?> />
				<input type="hidden" id="urstr-busc" value="<?php echo str_replace('/pagina', '', preg_replace('/[0-9]+/', '', uri_string())); ?>" />
				<input type="hidden" id="filtr-busc" value="<?php echo generar_url_filtro($filtros); ?>" />
				<?php if(isset($filtros['busqueda'])): ?>
				<button type="button" id="limpbus"><i class="fa fa-times"></i></button>
				<?php endif; ?>
				<button type="submit" id="buscme"><i class="fa fa-search"></i></button>
			</form>
		</div>
	</div>
<?php if(sizeof($productos) > 0): ?>
	<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-3" id="contenedor-catalogo">
	<?php foreach($productos as $producto): ?>
		<?php $this->load->view('campanas/thumb_producto', array('producto' => $producto)); ?>
	<?php endforeach; ?>
	</div>
	<div class="lower-pag text-center"><?php echo $paginacion; ?></div>
<?php else: ?>
	<div class="row ptop">
		<div class="small-24 medium-23 medium-centered large-22 columns">
			<h3 class="text-center vacio">
				<div class="text-center error-icon"><i class="fa fa-times-circle-o"></i></div>
				No hay productos activos con este criterio de búsqueda.
			</h3>
		</div>
	</div>
<?php endif; ?>
