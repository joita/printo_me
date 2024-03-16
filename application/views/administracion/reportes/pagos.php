<legend>Reporte de pagos a diseñadores</legend>
<a href="<?php echo site_url('administracion/reportes/pagos_pdf/'.$fecha_inicio.'/'.$fecha_final.'/'.$metodo_pago.'/'.$tipo_campana); ?>" target="_blank" class="alert fieldadd button"><i class="fa fa-file-pdf-o"></i> Generar PDF</a>
<div class="small-24 columns">
    <div class="row">
        <div class="small-6 columns">
            <label>Fecha inicial
                <input type="date" id="fecha_inicio" value="<?php echo $fecha_inicio; ?>" />
            </label>
        </div>
        <div class="small-6 end columns">
            <label>Fecha final
                <input type="date" id="fecha_final" value="<?php echo $fecha_final; ?>" />
            </label>
        </div>
        <div class="small-6 columns">
            <label>Metodo de pago
                <select id="metodo_de_pago" style="height:2.15rem;">
                    <option value="todos" <?php echo ($metodo_pago == 'todos' ? 'selected': '');?>>Todos</option>
                    <option value="paypal" <?php echo ($metodo_pago == 'paypal' ? 'selected': '');?>>PayPal</option>
                    <option value="banco" <?php echo ($metodo_pago == 'banco' ? 'selected': '');?>>Transferencia</option>
                </select>
            </label>
        </div>
        <div class="small-6 columns">
            <label>Tipo Campaña
                <select id="tipo_campana" style="height:2.15rem;">
                    <option value="todos" <?php echo ($tipo_campana == 'todos' ? 'selected': '');?>>Todos</option>
                    <option value="fijo" <?php echo ($tipo_campana == 'fijo' ? 'selected': '');?>>Venta Inmediata</option>
                    <option value="limitado" <?php echo ($tipo_campana == 'limitado' ? 'selected': '');?>>Plazo Definido</option>
                </select>
            </label>
        </div>
    </div>
</div>

<div class="row resumen-pedido">
	<div class="small-24 columns">
        <table class="campana_info">
            <tr>
                <th width="31.4%" rowspan="2" style="vertical-align:bottom;">Información Pagos a Diseñadores</th>
                <th width="20%" class="text-center">No. Pagos</td>
                <th width="20%" class="text-center">Total Pagado</td>
                <th width="20%" class="text-center">Promedio de Pagos</td>
            </tr>
            <tr>
                <td width="20%" class="text-center"><?php echo $reporte->numero_pagos; ?></td>
                <td width="20%" class="text-center">$<?php echo number_format($reporte->total_pagos, 2, '.',','); ?></td>
                <td width="20%" class="text-center">$<?php echo number_format($reporte->promedio_pagos, 2, '.', ','); ?></td>
            </tr>
        </table>
        <table class="campana_info" id="tabla_pagos">
            <thead>
                <tr>
                    <th width="20%" class="text-center">Email Diseñador</th>
                    <th width="20%" class="text-center">Fecha Pago</td>
                    <th width="20%" class="text-center">Monto</td>
                    <th width="20%" class="text-center">Metodo</td>
                    <th width="20%" class="text-center">Comprobante</th>
                </tr>
            </thead>
            <!--Generado por DataTables ServerSide-->
        </table>
    </div>
    <input type="hidden" id="max_year" value="<?php echo $reporte->max_fecha->year;?>"/>
    <input type="hidden" id="max_month" value="<?php echo $reporte->max_fecha->month;?>"/>
    <input type="hidden" id="max_day" value="<?php echo $reporte->max_fecha->day;?>"/>

    <input type="hidden" id="min_year" value="<?php echo $reporte->min_fecha->year;?>"/>
    <input type="hidden" id="min_month" value="<?php echo $reporte->min_fecha->month;?>"/>
    <input type="hidden" id="min_day" value="<?php echo $reporte->min_fecha->day;?>"/>
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
	selectYears: 100,
    min: [$("#min_year").val(),$("#min_month").val(),$("#min_day").val()],
    max: [$("#max_year").val(),$("#max_month").val(),$("#max_day").val()]
});

$("#refresh_report").click(function() {
	window.location.href = '<?php echo base_url(); ?>administracion/reportes/pagos/'+$("#fecha_inicio").val()+'/'+$("#fecha_final").val();
});

$("#fecha_inicio, #fecha_final, #metodo_de_pago, #tipo_campana").change(function() {
	window.location.href = '<?php echo base_url(); ?>administracion/reportes/pagos/'+$("#fecha_inicio").val()+'/'+$("#fecha_final").val()+'/'+$("#metodo_de_pago").val()+'/'+$("#tipo_campana").val();
});

</script>
