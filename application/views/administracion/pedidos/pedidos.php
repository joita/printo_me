<?php 
	$fecha_inicio = date('Y-m-d');
	$fecha_final = date('Y-m-d');
?>
<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Pedidos de productos custom</h2>
    </div>
</div>
<div class="row" id="descarga_pedidos">
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
        <div class='text-right'><a href='#' class="alert fieldadd button" id="excelDescarga"><i class='fa fa-file-excel-o'></i></a></div>
	</div>
</div>
<div class="row">
    <div class="small-24 columns" id="subnav-productos">
        <table id="campanas" class="hover stripe cell-border order-column">
            <thead>
                <tr>
                    <th>No.</th>
                    <th></th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Items</th>
                    <?php /*
                    <th>Subtotal</th>
                    <th>Envío</th>
                    */ ?>
                    <th>Total</th>
                    <th>Método</th>
                    <th>Pago</th>
                    <th>Envío</th>
                    <th>Factura</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>No.</th>
                    <th></th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Items</th>
                    <?php /*
                    <th>Subtotal</th>
                    <th>Envío</th>
                    */ ?>
                    <th>Total</th>
                    <th>Método</th>
                    <th>Pago</th>
                    <th>Envío</th>
                    <th>Factura</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
            <!--Cosos-->
            </tbody>
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
$("#excelDescarga").click(function() {
	window.location.href = '<?php echo base_url(); ?>administracion/pedidos/crea_excel_pedido/'+$("#fecha_inicio").val()+'/'+$("#fecha_final").val();
});
</script>