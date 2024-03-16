<legend>Reporte de ventas</legend>
<a href="<?php echo site_url('administracion/reportes/ventas_pdf/'.$fecha_inicio.'/'.$fecha_final.'/'.$metodo_de_pago); ?>" target="_blank" class="alert fieldadd button"><i class="fa fa-file-pdf-o"></i> Generar PDF</a>
<div class="row">
	<div class="small-8 columns">
		<label>Fecha inicial
			<input type="date" id="fecha_inicio" value="<?php echo $fecha_inicio; ?>" />
		</label>
	</div>
	<div class="small-8 columns">
		<label>Fecha final
			<input type="date" id="fecha_final" value="<?php echo $fecha_final; ?>" />
		</label>
	</div>
	<div class="small-8 columns">
		<label>Medio de pago
			<select id="metodo_de_pago" style="height:2.15rem;">
				<option value="todos">Todos</option>
				<option value="card_payment">Tarjeta</option>
                <option value="stripe">Stripe</option>
                <option value="PPP">PayPal Plus</option>
				<option value="cash_payment">OXXO</option>
				<option value="paypal">PayPal</option>
				<option value="spei">SPEI</option>
			</select>
		</label>
	</div>
</div>

<div class="row resumen-pedido">
	<div class="small-24 columns">
		<table class="campana_info">
			<tr>
				<th width="31.4%" rowspan="2" style="vertical-align:bottom;">Número de ventas en período</th>
				<th width="15%" class="text-center">Total</td>
				<th width="15%" class="text-center">Pagadas</td>
				<th width="15%" class="text-center">Pendientes</td>
				<th width="15%" class="text-center">Canceladas</td>
			</tr>
			<tr>
				<td width="15%" class="text-center"><?php echo $reporte->numero_pedidos; ?></td>
				<td width="15%" class="text-center"><?php echo $reporte->numero_pedidos_pagados; ?></td>
				<td width="15%" class="text-center"><?php echo $reporte->numero_pedidos_pendientes; ?></td>
				<td width="15%" class="text-center"><?php echo $reporte->numero_pedidos_cancelados; ?></td>
			</tr>
		</table>

		<?php if($metodo_de_pago == 'todos'): ?>
		<table class="campana_info">
			<tr>
				<th width="36.2%" rowspan="2" style="vertical-align:bottom;">Número de ventas por método de pago</th>
				<th width="8.57%" class="text-center">Tarjeta</td>
                <th width="8.57%" class="text-center">PayPalPlus</td>
				<th width="8.57%" class="text-center">PayPal</td>
				<th width="8.57%" class="text-center">OXXO<br> Pagadas</td>
				<th width="8.57%" class="text-center">OXXO<br> Pendientes</td>
				<th width="8.57%" class="text-center">SPEI<br> Pagadas</td>
				<th width="8.57%" class="text-center">SPEI<br> Pendientes</td>
			</tr>
			<tr>
				<td width="12.85%" class="text-center"><?php echo $reporte->pedidos_tarjeta; ?></td>
                <td width="12.85%" class="text-center"><?php echo $reporte->pedidos_ppp; ?></td>
				<td width="12.85%" class="text-center"><?php echo $reporte->pedidos_paypal; ?></td>
				<td width="12.85%" class="text-center"><?php echo $reporte->pedidos_oxxo_pagados; ?></td>
				<td width="12.85%" class="text-center"><?php echo $reporte->pedidos_oxxo_pendientes; ?></td>
				<td width="12.85%" class="text-center"><?php echo $reporte->pedidos_spei_pagados; ?></td>
				<td width="12.85%" class="text-center"><?php echo $reporte->pedidos_spei_pendientes; ?></td>
			</tr>
		</table>
		<?php endif; ?>

		<table class="campana_info">
			<tr>
				<th width="31.4%" rowspan="2" style="vertical-align:bottom;">Monto de ventas <strong><u>pagadas</u></strong></th>
				<th width="15%" class="text-center">Total</td>
				<th width="15%" class="text-center">Promedio</td>
				<th width="15%" class="text-center">Mínima</td>
				<th width="15%" class="text-center">Máxima</td>
			</tr>
			<tr>
				<td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos->venta_total); ?></td>
				<td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos->promedio); ?></td>
				<td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos->minimo); ?></td>
				<td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos->maximo); ?></td>
			</tr>
		</table>

        <table class="campana_info">
            <tr>
                <th width="31.4%" rowspan="2" style="vertical-align:bottom;">Monto de Pedidos <strong><u>Cancelados</u></strong></th>
                <th width="15%" class="text-center">Total</td>
                <th width="15%" class="text-center">Promedio</td>
                <th width="15%" class="text-center">Mínima</td>
                <th width="15%" class="text-center">Máxima</td>
            </tr>
            <tr>
                <td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos_cancelados->total); ?></td>
                <td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos_cancelados->promedio); ?></td>
                <td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos_cancelados->minimo); ?></td>
                <td width="15%" class="text-center">$<?php echo $this->cart->format_number($reporte->montos_cancelados->maximo); ?></td>
            </tr>
        </table>

        <table class="campana_info">
            <tr>
                <th width="31.4%" rowspan="2" style="vertical-align:bottom;width:0.9%;">Monto de ventas pendientes por pagar OXXO y SPEI</th>
                <th colspan="4" class="text-center">Total</td>
            </tr>
            <tr>
                <td width="15%" class="text-center" style="color:red;">$<?php echo $this->cart->format_number($reporte->venta_total_pendiente); ?></td>
            </tr>
        </table>

		<table class="campana_info">
			<tr>
				<th width="31.4%" rowspan="2" style="vertical-align:bottom;">Clientes nuevos vs. recurrentes</th>
				<th width="27%" class="text-center">Nuevos</td>
				<th width="27%" class="text-center">Recurrentes</td>
			</tr>
			<tr>
				<td width="27%" class="text-center"><?php echo $reporte->nuevos; ?></td>
				<td width="27%" class="text-center"><?php echo $reporte->recurrentes; ?></td>
			</tr>
		</table>

		<table class="campana_info">
            <tr>
                <th width="28.4%" rowspan="2" style="vertical-align:bottom;">Saldo de pagos a diseñadores</th>
				<th width="18%" class="text-center">Total ventas</td>
				<th width="18%" class="text-center">Pagado a diseñadores</td>
				<th width="18%" class="text-center">Saldo</td>
            </tr>
            <tr>
                <td class="text-center">$<?php echo $this->cart->format_number($reporte->montos->venta_total); ?></td>
                <td class="text-center">$<?php echo $this->cart->format_number($reporte->ganancias_total_disenadores); ?></td>
                <td class="text-center">$<?php echo $this->cart->format_number($reporte->montos->venta_total - $reporte->ganancias_total_disenadores); ?></td>
            </tr>
        </table>

        <table class="campana_info">
            <tr>
                <th width="31.4%" rowspan="2" style="vertical-align:bottom;width:0.9%;">Monto pendiente por pagar a diseñadores</th>
                <th colspan="4" class="text-center">Total</td>
            </tr>
            <tr>
                <td width="15%" class="text-center" style="color:red;">$<?php echo $this->cart->format_number($reporte->ganancias_total_disenadores - $reporte->ganancia_disenador); ?></td>
            </tr>
        </table>

		<table class="campana_info">
			<tr>
				<th colspan="2" class="text-center">Los SKUs más vendidos en el período (productos custom)</th>
			<tr>
				<th width="40%" class="text-center">SKU</th>
				<th width="60%" class="text-center">Productos vendidos</th>
			</tr>
			<?php foreach($reporte->cinco_skus as $sku_venta): ?>
			<tr>
				<th class="text-center"><?php echo $sku_venta->sku.' (Talla: '.$sku_venta->caracteristicas->talla.')'; ?></th>
				<td class="text-center"><?php echo $sku_venta->vendidos; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>

		<table class="campana_info">
			<tr>
				<th colspan="2" class="text-center">Los diseños más vendidos en el período (productos fijos)</th>
			<tr>
				<th width="40%" class="text-center">Nombre del producto</th>
				<th width="60%" class="text-center">Productos vendidos</th>
			</tr>
			<?php foreach($reporte->cinco_productos as $producto): ?>
			<tr>
				<th class="text-center"><?php echo $producto->name; ?></th>
				<td class="text-center"><?php echo $this->enhance_modelo->obtener_total_vendidos_por_campana($producto->id_enhance); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>



<script src="<?php echo site_url('bower_components/pickadate/lib/compressed/picker.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/pickadate/lib/compressed/picker.date.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/pickadate/lib/compressed/legacy.js'); ?>"></script>
<script src="<?php echo site_url('bower_components/imagesloaded/imagesloaded.pkgd.min.js'); ?>"></script>
<script>
jQuery.extend(jQuery.fn.pickadate.defaults,{monthsFull:["enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"],monthsShort:["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"],weekdaysFull:["domingo","lunes","martes","miércoles","jueves","viernes","sábado"],weekdaysShort:["dom","lun","mar","mié","jue","vie","sáb"],today:"hoy",clear:"borrar",close:"cerrar",firstDay:1,format:"yyyy-mm-dd",formatSubmit:"yyyy-mm-dd"});

$('#fecha_inicio, #fecha_final').pickadate({
	closeOnSelect: true,
	container: 'body',
	selectYears: true,
	selectMonths: true,
	selectYears: 100
});

$(document).ready(function() {
	$("#metodo_de_pago").val('<?php echo $metodo_de_pago; ?>');
});

$("#refresh_report").click(function() {
	window.location.href = '<?php echo base_url(); ?>administracion/reportes/ventas/'+$("#fecha_inicio").val()+'/'+$("#fecha_final").val()+'/'+$("#metodo_de_pago").val();
});

$("#fecha_inicio, #fecha_final, #metodo_de_pago").change(function() {
	window.location.href = '<?php echo base_url(); ?>administracion/reportes/ventas/'+$("#fecha_inicio").val()+'/'+$("#fecha_final").val()+'/'+$("#metodo_de_pago").val();
});
</script>
