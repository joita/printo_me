<script src="<?php echo site_url('assets/js/autoComplete/jquery.autocomplete.min.js'); ?>"></script>
<script>

$(document).on("click", ".enabled", function() {
	var nuevo_estatus = 0;
	var id_producto = $(this).parent().data("id_producto");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/productos/estatus'); ?>', { id_producto: id_producto, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function() {
	var nuevo_estatus = 1;
	var id_producto = $(this).parent().data("id_producto");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/productos/estatus'); ?>', { id_producto: id_producto, estatus: nuevo_estatus });
});

$(".delete-sub-cat").click(function() {
	var id_producto = $(this).parent().data("id_producto");
	$("#id_producto_bor").val(id_producto);
});

<?php if(sizeof($productos) > 0): ?>
var productos = [<?php foreach($productos as $producto): ?>
{ value: '<?php echo $producto->modelo_producto.' - '.$producto->nombre_producto; ?>', data: '<?php echo site_url(uri_string().'/modificar-producto/'.$producto->id_producto); ?>' },
<?php endforeach; ?>];
<?php else: ?>
var productos = [];
<?php endif; ?>

$('#prod_s').autocomplete({
    lookup: productos,
    onSelect: function (suggestion) {
        window.location.href = suggestion.data;
    }
});

</script>