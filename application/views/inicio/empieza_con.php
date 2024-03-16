<?php if(sizeof($mas_vendidos) > 0): ?>
<h1 class="azul text-center divisor">Lo más vendido</h1>

<div class="row small-up-1 medium-up-2 large-up-4 xlarge-up-4" id="contenedor-catalogo">
<?php foreach($mas_vendidos as $producto): ?>
	<?php $this->load->view('campanas/thumb_producto', array('producto' => $producto)); ?>
<?php endforeach; ?>
</div>
<div class="row">
	<div class="small-18 text-center columns boton-more-area">
		<a href="<?php echo site_url('campanas'); ?>" class="primary button"><i class="fa fa-line-chart"></i> Ver más campañas</a>
	</div>
</div>
<?php endif; ?>

<?php if(sizeof($apoya) > 0): ?>
<h1 class="azul text-center divisor">Apoya una causa</h1>

<div class="row small-up-1 medium-up-2 large-up-4 xlarge-up-4" id="contenedor-catalogo">
<?php foreach($apoya as $producto): ?>
	<?php $this->load->view('campanas/thumb_producto', array('producto' => $producto)); ?>
<?php endforeach; ?>
</div>
<div class="row">
	<div class="small-18 text-center columns boton-more-area">
		<a href="<?php echo site_url('campanas'); ?>" class="primary button"><i class="fa fa-line-chart"></i> Ver más campañas</a>
	</div>
</div>
<?php endif; ?>

<?php if(sizeof($acabantes) > 0): ?>
<h1 class="azul text-center divisor">A punto de terminar</h1>

<div class="row small-up-1 medium-up-2 large-up-4 xlarge-up-4" id="contenedor-catalogo">
<?php foreach($acabantes as $producto): ?>
	<?php $this->load->view('campanas/thumb_producto', array('producto' => $producto)); ?>
<?php endforeach; ?>
</div>
<div class="row">
	<div class="small-18 text-center columns boton-more-area">
		<a href="<?php echo site_url('campanas'); ?>" class="primary button"><i class="fa fa-line-chart"></i> Ver más campañas</a>
	</div>
</div>
<?php endif; ?>