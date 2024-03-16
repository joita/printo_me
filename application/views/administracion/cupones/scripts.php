<script src="<?php echo site_url("assets/js/tiny-autocomplete/tiny-autocomplete.js")?>"></script>
<script>
// Marcas

Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
};

$(document).on("click", ".enabled", function(e) {
	e.preventDefault();
	var nuevo_estatus = 0;
	var id_cupon = $(this).parent().data("id_cupon");
	$(this).removeClass("enabled").addClass("disabled").html('<i class="fa fa-toggle-off"></i>');
	
	$.post('<?php echo site_url('administracion/cupones/estatus'); ?>', { id_cupon: id_cupon, estatus: nuevo_estatus });
});

$(document).on("click", ".disabled", function(e) {
	e.preventDefault();
	var nuevo_estatus = 1;
	var id_cupon = $(this).parent().data("id_cupon");
	$(this).removeClass("disabled").addClass("enabled").html('<i class="fa fa-toggle-on"></i>');
	
	$.post('<?php echo site_url('administracion/cupones/estatus'); ?>', { id_cupon: id_cupon, estatus: nuevo_estatus });
});

$(".edit-main-cat").click(function() {
	var id_cupon = $(this).parent().data("id_cupon");
	var nombre = $(this).parent().data("nombre");
	var cupon = $(this).parent().data("cupon");
	var descuento = $(this).parent().data("descuento");
	var monto_minimo = $(this).parent().data("monto_minimo");
	var cantidad = $(this).parent().data("cantidad");
	var tipo = $(this).parent().data("tipo");
	var expira = new Date($(this).parent().data("expira"));
    var tienda = $(this).parent().data("nombre_tienda");
    var producto = $(this).parent().data("producto");

    if(producto == 1){
        $("#producto_mod").prop( "checked", true );
    }
	$("#nombre_mod").val(nombre);
	$("#cupon_mod").val(cupon);
	$("#descuento_mod").val(descuento);
	$("#monto_minimo_mod").val(monto_minimo);
	$("#cantidad_mod").val(cantidad);
	$("#tipo_mod").val(tipo);
	$("#expira_mod").val(expira.yyyymmdd());
	$("#id_cupon_mod").val(id_cupon);
	$("#tienda_mod").val(tienda);
});

$(".delete-main-cat").click(function() {
	var id_cupon = $(this).parent().data("id_cupon");
	$("#id_cupon_bor").val(id_cupon);
});

$(document).ready(function () {
    $(".tiendas").tinyAutocomplete({
        markAsBold: true,
        showNoResults: true,
        noResultsTemplate: "<li class='autocomplete-item'>No se encontraron tiendas similares.</li>",
        url: "<?php echo site_url('administracion/cupones/obtener_tiendas')?>",
        minChars: 3,
        maxItems: 5,
        itemTemplate: '<li class="autocomplete-item">{{nombre}}</li>',
        onSelect: function(el, val) {
            $(this).val(val.nombre);
            $(".id_cliente").val(val.id_cliente);
        }
    });
});
</script>