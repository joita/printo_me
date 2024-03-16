<style type="text/css">
	.v-success p{
		margin-bottom: 0px; 
		color: green;
		    margin-left: 20px;
    margin-top: 15px;

	}
</style>

<div class="row">
	<div class="small-24 columns">
		<p class="section-title">Proveedores Ventas</p>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li><a class="active"><i class="fa fa-building-o"></i> Listado</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div class="v-success">
			 <p><?php echo $this->session->flashdata('message'); ?></p> 
		</div>
	</div>
</div>
<div class="row">
	
	<div class="small-24 columns">
		<div id="main-container">
			<div class="row" data-equalizer style="padding:0 1rem">
                <div class="small-24 end columns navholder" data-equalizer-watch>
                    <a href="<?php echo site_url('administracion/proveedores');?>"  class="coollink">Proveedores</a>

                </div>
            </div>
			<div class="row">
				<div class="small-24 columns">
					<table id="campanas" class="listis hover stripe cell-border order-column">
						<thead>
							<tr>
								<th style="width:5%">Nombre</th>
								<th style="width:5%">Dominio</th>
								<th style="width:5%">Órdenes totales</th>
								<th style="width:5%">Pago total</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($proveedores as $key => $proveedore) {
								?>
								<tr>
									
									<td><?php echo $proveedore->code; ?></td>
									<td><?php echo $proveedore->store_url; ?></td>
									<td><?php
									
									 echo $class_product->getTotalOrdersShopify($proveedore->store_url); ?></td>
									<td><?php echo $class_product->getTotalPaymentShopify($proveedore->store_url); ?></td>
								</tr>
								<?php 
							}

							 ?>
						<!--Generado por serverside Data Tables-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
