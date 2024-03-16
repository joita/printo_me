<?php 
	

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	<?php $this->load->view('carrito/estilos_pdf.css'); ?>
	</style>
</head>
<body>
	
	<div id="header">
		<table>
			<tr>
				<td><img src="<?php echo APPPATH. '../public/assets/images/header-logo-retina.png'; ?>" alt="" height="70"></td>
				<td style="text-align: right;">
					<table id="info">
						<tr>
							<td>No. del producto:</td>
							<th><?php echo $campana->id_enhance; ?></th>
						</tr>
						<tr>
							<td>Generación de PDF:</td>
							<th><?php echo date("d/m/Y H:i:s"); ?></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	
	<fieldset id="pedido" style="page-break-after: always;">
		<legend>Diseños en venta » Venta Inmediata » <?php echo $campana->name; ?> (Folio: <?php echo $campana->id_enhance; ?>)</legend>
		
		<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
			<tr>
				<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Datos de la campaña</th>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Autor</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%"><?php echo $campana->nombres.' '.$campana->apellidos; ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">E-Mail</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%"><?php echo $campana->email; ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Nombre</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%"><?php echo $campana->name; ?></td>
			</tr>							
		</table>
	
		<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
			<tr>
				<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Reporte final</th>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;">Fecha inicial del corte</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" class="text-right"><?php echo $corte->fecha_inicio_corte; ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;">Fecha final del corte</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" class="text-right"><?php echo $corte->fecha_final_corte; ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;">Número de ventas</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" class="text-right"><?php echo $corte->productos_vendidos; ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Costo de producción unitario</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-right">$<?php echo $this->cart->format_number($campana->costo); ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Precio de venta unitario</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-right">$<?php echo $this->cart->format_number($campana->price); ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Ventas totales</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-right">$<?php echo $this->cart->format_number($campana->price*$corte->productos_vendidos); ?></td>
			</tr>
			<tr>
				<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Costo total de producción</th>
				<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-right">$<?php echo $this->cart->format_number($campana->costo*$corte->productos_vendidos); ?></td>
			</tr>
			<tr style="border-top: solid 2px #000">
				<th style="font-size:1.25rem;line-height:2.4rem;text-align:right;">A depositar</th>
				<td style="font-size:1.25rem;line-height:2.4rem;padding-right:12px;" class="text-right">$<?php echo $this->cart->format_number($corte->monto_corte); ?></strong></td>
			</tr>
			
		</table>
		<hr />
		<?php if(isset($corte->id_corte)): ?>
			<?php if($corte->monto_corte > 0): ?>
				<?php if($corte->fecha_pago == ''): ?>
				<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
					<tr>
						<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Datos de depósito</th>
					</tr>
					<?php if(!isset($info_deposito_actual->id_dato_deposito)): ?>
					<tr>
						<td colspan="2" style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" class="text-center">La persona no ha subido sus datos de depósito.</td>
					</tr>
					<?php else: ?>
						<?php if($info_deposito_actual->tipo_pago == 'paypal'): ?>
						<tr>
							<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Correo asociado a PayPal</th>
							<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->cuenta_paypal; ?></td>
						</tr>
						<?php elseif($info_deposito_actual->tipo_pago == 'banco'): ?>
						<tr>
							<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Nombre de cuentahabiente</th>
							<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->nombre_cuentahabiente; ?></td>
						</tr>
						<tr>
							<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Nombre del banco</th>
							<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->nombre_banco; ?></td>
						</tr>
						<tr>
							<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">Número de cuenta</th>
							<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->cuenta; ?></td>
						</tr>
						<tr>
							<th style="font-size:1.05rem;line-height:1.8rem;" width="45%">CLABE Interbancaria</th>
							<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $info_deposito_actual->datos_json->clabe; ?></td>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
				</table>
				<?php else: ?>
					<?php if($corte->id_dato_deposito != ''): ?>
						<?php if(isset($dato_bancario_corte)): ?>
						<table cellpadding="6" cellspacing="1" width="100%" border="0" id="carrito">
							<tr>
								<th style="font-size:1.25rem;line-height:2.4rem;font-weight:bold;" colspan="2" class="text-center">Datos de depósito usados para este corte</th>
							</tr>
							<?php if($dato_bancario_corte->tipo_pago == 'paypal'): ?>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Correo asociado a PayPal</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->cuenta_paypal; ?></td>
							</tr>
							<?php elseif($dato_bancario_corte->tipo_pago == 'banco'): ?>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Nombre de cuentahabiente</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->nombre_cuentahabiente; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Nombre del banco</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->nombre_banco; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">Número de cuenta</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->cuenta; ?></td>
							</tr>
							<tr>
								<th style="font-size:1.05rem;line-height:1.8rem;text-align:right;" width="45%">CLABE Interbancaria</th>
								<td style="font-size:1.05rem;line-height:1.8rem;padding-right:12px;" width="55%" class="text-left"><?php echo $dato_bancario_corte->datos_json->clabe; ?></td>
							</tr>
							<?php endif; ?>
						</table>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	</fieldset>

</body>
</html>
