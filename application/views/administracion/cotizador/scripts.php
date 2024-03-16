<script>
$(document).on('change', '.change_data', function() {
	var id = $(this).parent().parent().data('id');
	var data = {
		'cantidad_max' : $('input[name="data['+id+'][cantidad_max]"]').val(),
		'cantidad_min' : $('input[name="data['+id+'][cantidad_min]"]').val(),
		'costo_blanca' : $('input[name="data['+id+'][costo_blanca]"]').val(),
		'costo_color' : $('input[name="data['+id+'][costo_color]"]').val(),
		'tecnica' : $('select[name="data['+id+'][tecnica]"]').val(),
		'multiplicador_1' : $('input[name="data['+id+'][multiplicador_1]"]').val(),
		'multiplicador_2' : $('input[name="data['+id+'][multiplicador_2]"]').val()
	};
	$.post("<?php echo site_url('administracion/'.$class.'/editar');?>", { id: id, data : data });
});
<?php /*$(".edit-cotizador").click(function(e) {
	e.preventDefault();
	var id = $(this).parent().parent().data("id");
	$.post('./cotizador/get_post', { id: id }, function(data) {
		$('.editar select[name="tipo_tinta"] option[value="'+data.tipo_tinta+'"]').prop('selected', true);
		$('.editar select[name="tipo_estampado"] option[value="'+data.tipo_estampado+'"]').prop('selected', true);
		$('.editar input[name="cantidad"]').val(data.cantidad);
		$('.editar input[name="costo_blanca"]').val(data.costo_blanca);
		$('.editar input[name="costo_color"]').val(data.costo_color);
		$('.editar select[name="tecnica"] option[value="'+data.tecnica+'"]').prop('selected', true);
		$('.editar input[name="multiplicador_1"]').val(data.multiplicador_1);
		$('.editar input[name="multiplicador_2"]').val(data.multiplicador_2);
		$('.editar select[name="estatus"] option[value="'+data.estatus+'"]').prop('selected', true);
		$('.editar input[name="id_cotizador"]').val(data.id_cotizador);
	}, "json");
	$('#editar_cotizador').foundation('reveal','open');
});

$('.delete-cotizador').click(function(e) {
	e.preventDefault();
	var id = $(this).parent().parent().data("id");
	$('.eliminar input[name="id"]').val(id);
	$('#borrar').foundation('reveal','open');
});*/?>

$(document).on('click', '.new-item', function(e) {
	e.preventDefault();
	var num = $(this).closest('tbody').find('.tr-new-item').length; 
	var  idtipo_estampado = $(this).closest('table#table_cotizador').data('idtipo_estampado');
	var  idtipo_tinta = $(this).closest('table#table_cotizador').data('idtipo_tinta');
	var item = ''+
	'<tr class="tr-new-item" data-newitem="'+num+'">'+
		'<td><input name="data['+num+'][cantidad_min]" class="new_data text-center" value=""></td>'+
		'<td><input name="data['+num+'][cantidad_max]" class="new_data text-center" value=""></td>'+
		'<td><input name="data['+num+'][costo_blanca]" class="new_data text-center" value=""></td>'+
		'<td><input name="data['+num+'][costo_color]" class="new_data text-center" value=""></td>'+
		'<td>'+
			'<select name="data['+num+'][tecnica]" class="new_data text-center">'+
				'<option value="TDG">TDG</option>'+
				'<option value="SERI">SERI</option>'+
				'<option value="VINIL">VINIL</option>'+
			'</select>'+
		'</td>'+
		'<td><input name="data['+num+'][multiplicador_1]" class="new_data text-center" value=""></td>'+
		'<td>'+
			'<input name="data['+num+'][multiplicador_2]" class="new_data text-center" value="">'+
			'<input name="data['+num+'][tipo_tinta]" type="hidden" value="'+ idtipo_tinta +'">'+
			'<input name="data['+num+'][tipo_estampado]" type="hidden" value="'+ idtipo_estampado +'">'+
		'</td>'+

		'<td>'+
			'<ul class="btn-opcion-list clearfix">'+
				
				'<li><a href="#" class="new-item"><i class="fa fa-plus" aria-hidden="true"></i></a></li>'+
				'<li><a href="#" class="delete-item btn-delete-item"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>'+
			'</ul>'+
		'</td>'+
	'</tr>'+
	'';
	$('table#table_cotizador[data-idtipo_estampado="'+ idtipo_estampado +'"][data-idtipo_tinta="'+ idtipo_tinta +'"] tbody').append(item);
});

$(document).on('click', '.btn-delete-item', function(e) {
	e.preventDefault();
	var num = $(this).closest('tr').data('newitem'); 
	var  idtipo_estampado = $(this).closest('table#table_cotizador').data('idtipo_estampado');
	var  idtipo_tinta = $(this).closest('table#table_cotizador').data('idtipo_tinta');
	$('table#table_cotizador[data-idtipo_estampado="'+ idtipo_estampado +'"][data-idtipo_tinta="'+ idtipo_tinta +'"] tbody tr.tr-new-item[data-newitem="'+ num +'"]').remove();

});

$(document).on('click', '.safe_items', function(e) {
	e.preventDefault();
	var data = new Array();
	var num = $(this).closest('#table_cotizador').find('.tr-new-item').length; 
	var  idtipo_estampado = $(this).closest('table#table_cotizador').data('idtipo_estampado');
	var  idtipo_tinta = $(this).closest('table#table_cotizador').data('idtipo_tinta');
	for (var i=0; i < num; i++) {
		var lugar = 'table#table_cotizador[data-idtipo_estampado="'+ idtipo_estampado +'"][data-idtipo_tinta="'+ idtipo_tinta +'"] tbody tr.tr-new-item[data-newitem="'+ i +'"]';
		data[i] = {
			'cantidad_max' : $(lugar + ' input[name="data['+i+'][cantidad_max]"]').val(),
			'cantidad_min' : $(lugar + ' input[name="data['+i+'][cantidad_min]"]').val(),
			'costo_blanca' : $(lugar + ' input[name="data['+i+'][costo_blanca]"]').val(),
			'costo_color' : $(lugar + ' input[name="data['+i+'][costo_color]"]').val(),
			'tecnica' : $(lugar + ' select[name="data['+i+'][tecnica]"]').val(),
			'multiplicador_1' : $(lugar + ' input[name="data['+i+'][multiplicador_1]"]').val(),
			'multiplicador_2' : $(lugar + ' input[name="data['+i+'][multiplicador_2]"]').val(),
			'tipo_tinta' : $(lugar + ' input[name="data['+i+'][tipo_tinta]"]').val(),
			'tipo_estampado' : $(lugar + ' input[name="data['+i+'][tipo_estampado]"]').val(),
			'estatus' : '1'
		};
	};
	$.post("<?php echo site_url('administracion/'.$class.'/agregar');?>", { data : data }).done(function() {
		recarga_tbody(idtipo_estampado, idtipo_tinta);
	});
});

$(document).on('click', '.delete-item-db', function(){
	var id = $(this).parent().parent().parent().parent().data('id');
	var  idtipo_estampado = $(this).closest('table#table_cotizador').data('idtipo_estampado');
	var  idtipo_tinta = $(this).closest('table#table_cotizador').data('idtipo_tinta');
	$.post("<?php echo site_url('administracion/'.$class.'/eliminar');?>", { id : id }).done(function() {
		recarga_tbody(idtipo_estampado, idtipo_tinta);
	});
});

function recarga_tbody(idtipo_estampado, idtipo_tinta)
{
	$.post("<?php echo site_url('administracion/'.$class.'/recargar_datos');?>", { tipo_tinta : idtipo_tinta, tipo_estampado : idtipo_estampado }, function(data) {
		$('.ajax_items[data-idtipo_estampado="'+ idtipo_estampado +'"][data-idtipo_tinta="'+ idtipo_tinta +'"]').html(data);
	});
}
</script>