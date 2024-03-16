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
		<p class="section-title">Shopify Proveedores</p>
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
                    <a href="<?php echo site_url('administracion/proveedores/add');?>" data-reveal-id="nuevo_banner" class="coollink"><i class="fa fa-plus"></i> Nuevo Proveedor</a>

                    <a href="<?php echo site_url('administracion/proveedore/sale_graph');?>"  class="coollink">Proveedores ventas</a>

                </div>
            </div>
			<div class="row">
				<div class="small-24 columns">
					<table id="campanas" class="listis hover stripe cell-border order-column">
						<thead>
							<tr>
								<th style="width:5%">ID</th>
								<th style="width:8%">Code</th>
								<th>Domain</th>
								<th>Api key</th>
								<th style="width:5%">Api Password</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($proveedores as $key => $proveedore) {
								?>
								<tr>
									<td><?php echo $proveedore->id; ?></td>
									<td><?php echo $proveedore->code; ?></td>
									<td><?php echo $proveedore->store_url; ?></td>
									<td><?php echo substr_replace($proveedore->api_key,'XXXXXXX',6); ?></td>
									<td><?php echo substr_replace($proveedore->api_pass,'XXXXXXX',6); ?></td>
									<td><a href="<?php echo site_url('administracion/proveedores').'/'.$proveedore->id?>">Edit</a> | <a href="<?php echo site_url('administracion/proveedores/delete_data').'/'.$proveedore->id; ?>" onclick="return confirm('Are you sure?')" style="color:#f00;"> Delete</a></td>
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
