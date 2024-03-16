<style type="text/css">
	.v-errors{
		color: #f00;
		margin-bottom: 10px;
	}
	.row.v-errors p {
    font-size: 12px;
    margin-bottom: 0;
}
</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
        <!-- select2 css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" />

        <!-- select2 script -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous"></script>

<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Shopify Proveedores</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<ul class="tab-menu">
			<li><a class="active"><i class="fa fa-building-o"></i> Editar Proveedor</a></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
		<div id="main-container">
			<div class="row v-errors">
				<div class="small-24 columns">
					<?php echo validation_errors();
					?>
				</div>
			</div>
			<div class="row">
				<div class="small-24 columns">
					<form method="post" name="proveedores_form" action="<?php echo site_url('administracion/proveedores/update_data').'/'.$proveedore->id; ?>">
						
						<div class="form-group" style="margin-bottom: 10px;">
							<label>Creators</label>
							<select name="creator_id" id='selUser' style='width: 170px;'>
					            <option value='0'>- Search user -</option>
					            <option selected value='<?php echo $proveedore->creator_id; ?>'><?php echo $cliente->nombres .' '.$cliente->apellidos ?></option>
					        </select>
						</div>

						<div class="form-group">
							<label>Nombre/Código</label>
							<input type="text" required name="code" value="<?php echo $proveedore->code; ?>" placeholder="Ex: vendorName">
						</div>			
					
						<div class="form-group">
							<label>Dominio</label>
							<input type="text" required name="domain" value="<?php echo $proveedore->store_url; ?>" placeholder="Ex: abc.shopify.com">
						</div>
						<div class="form-group">
							<label>Clave api</label>
							<input type="text" required name="api_key" value="<?php echo $proveedore->api_key; ?>" placeholder="Ex: abcxxxxxxxxxxx">
						</div>
						<div class="form-group">
							<label>Contraseña de api</label>
							<input type="text" required name="api_pass" value="<?php echo $proveedore->api_pass; ?>" placeholder="Ex: abcxxxxxxxxxxx">
						</div>

						<div class="form-group">
							
							<input type="submit" name="add_vendor" value="Actualizar">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
        $(document).ready(function(){

            $("#selUser").select2({
                ajax: {
                    url: "<?php echo site_url('administracion/productos/clientes'); ?>",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {

                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
        });

        </script>