
<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.5.0/js/conekta.js"></script>
<script>
	var info_sesion;
	var sesion_fiscal;
	
	function complete_address()
	{
		if(info_sesion.situacion == 'no_registrado') {
			
			if(info_sesion.nombre != '' && info_sesion.apellidos != '' && info_sesion.email != '' && info_sesion.identificador_direccion != '' && info_sesion.telefono != '' && info_sesion.linea1 != '' && info_sesion.ciudad != '' && info_sesion.codigo_postal != '' && info_sesion.estado != '') {
				
				$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").hide();
				$("#area_paypal, #paypal_loading, .p_t_b").show();
				var direccion = info_sesion;
				
				$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion: direccion })
				.done(function( data ) {
					$("#pagar_paypal_btn").attr("href", data);
					$("#paypal_loading").hide();
				});
				
				if(info_sesion.estado == 'Yucatán') {
					//$("#tr_envio_gratis").show();
					//$("#tr_explicacion_envio_gratis").hide();
					//$("#recoger_paquete").prop("checked", false).trigger("change");
				} else {
					//$("#tr_envio_gratis").hide();
					//$("#tr_explicacion_envio_gratis").hide();
					//$("#recoger_paquete").prop("checked", false).trigger("change");
				}
				
			} else {
				
				$("#direccion_envio_seleccionada").html('<span class="text-center">Por favor selecciona una dirección de envío.</span>');
				$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").show();
				$("#area_paypal, #paypal_loading, .p_t_b").hide();
				
			}
			
		} else if(info_sesion.situacion == 'sin_direcciones') {
			
			if(info_sesion.identificador_direccion != '' && info_sesion.telefono != '' && info_sesion.linea1 != '' && info_sesion.ciudad != '' && info_sesion.codigo_postal != '' && info_sesion.estado != '') {
				$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").hide();
				$("#area_paypal, #paypal_loading, .p_t_b").show();
				var direccion = info_sesion;
				
				$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion: direccion })
				.done(function( data ) {
					$("#pagar_paypal_btn").attr("href", data);
					$("#paypal_loading").hide();
				});
				
				if(info_sesion.estado == 'Yucatán') {
					//$("#tr_envio_gratis").show();
					//$("#tr_explicacion_envio_gratis").hide();
					//$("#recoger_paquete").prop("checked", false).trigger("change");
				} else {
					//$("#tr_envio_gratis").hide();
					//$("#tr_explicacion_envio_gratis").hide();
					//$("#recoger_paquete").prop("checked", false).trigger("change");
				}
				
			} else {
				$("#direccion_envio_seleccionada").html('<span class="text-center">Por favor selecciona una dirección de envío.</span>');
				$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").show();
				$("#area_paypal, #paypal_loading, .p_t_b").hide();
			}
			
		}
	}
	
	function complete_address_fiscal()
	{
		if(sesion_fiscal.situacion == 'no_registrado') {
			
			if(sesion_fiscal.razon_social != '' && sesion_fiscal.rfc != '' && sesion_fiscal.correo_electronico_facturacion != '' && sesion_fiscal.telefono != '' && sesion_fiscal.linea1 != '' && sesion_fiscal.ciudad != '' && sesion_fiscal.codigo_postal != '' && sesion_fiscal.estado != '') {
				
				var direccion_fiscal = sesion_fiscal;
				
				$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion_fiscal: direccion_fiscal });
				
			} else {
				
				$("#direccion_fiscal_seleccionada").html('<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>');
				
			}
			
		} else if(sesion_fiscal.situacion == 'sin_direcciones') {
			
			if(sesion_fiscal.razon_social != '' && sesion_fiscal.rfc != '' && sesion_fiscal.correo_electronico_facturacion != '' && sesion_fiscal.telefono != '' && sesion_fiscal.linea1 != '' && sesion_fiscal.ciudad != '' && sesion_fiscal.codigo_postal != '' && sesion_fiscal.estado != '') {
				
				var direccion_fiscal = sesion_fiscal;
				
				$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion_fiscal: direccion_fiscal });
				
			} else {
				$("#direccion_fiscal_seleccionada").html('<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>');
			}
			
		}
	}

	$(document).ready(function() {
		
		info_sesion = {
			"situacion": "",
			"nombre" : "<?php echo (isset($this->session->direccion_temporal['nombre']) ? $this->session->direccion_temporal['nombre'] : ''); ?>",
			"apellidos": "<?php echo (isset($this->session->direccion_temporal['apellidos']) ? $this->session->direccion_temporal['apellidos'] : ''); ?>",
			"email": "<?php echo (isset($this->session->direccion_temporal['email']) ? $this->session->direccion_temporal['email'] : ''); ?>",
			"identificador_direccion" : "<?php echo (isset($this->session->direccion_temporal['identificador_direccion']) ? $this->session->direccion_temporal['identificador_direccion'] : ''); ?>",
			"id_direccion": "<?php echo (isset($this->session->direccion_temporal['id_direccion']) ? $this->session->direccion_temporal['id_direccion'] : ''); ?>",
			"telefono" : "<?php echo (isset($this->session->direccion_temporal['telefono']) ? $this->session->direccion_temporal['telefono'] : ''); ?>",
			"linea1" : "<?php echo (isset($this->session->direccion_temporal['linea1']) ? $this->session->direccion_temporal['linea1'] : ''); ?>",
			"linea2" : "<?php echo (isset($this->session->direccion_temporal['linea2']) ? $this->session->direccion_temporal['linea2'] : ''); ?>",
			"ciudad" : "<?php echo (isset($this->session->direccion_temporal['ciudad']) ? $this->session->direccion_temporal['ciudad'] : ''); ?>",
			"codigo_postal" : "<?php echo (isset($this->session->direccion_temporal['codigo_postal']) ? $this->session->direccion_temporal['codigo_postal'] : ''); ?>",
			"estado" : "<?php echo (isset($this->session->direccion_temporal['estado']) ? $this->session->direccion_temporal['estado'] : ''); ?>",
			"valido" : false
		};
		
		sesion_fiscal = {
			"situacion" : "",
			"razon_social" : "<?php echo (isset($this->session->direccion_fiscal_temporal['razon_social']) ? $this->session->direccion_fiscal_temporal['razon_social'] : ''); ?>",
			"rfc" : "<?php echo (isset($this->session->direccion_fiscal_temporal['rfc']) ? $this->session->direccion_fiscal_temporal['rfc'] : ''); ?>",
			"id_direccion_fiscal": "<?php echo (isset($this->session->direccion_fiscal_temporal['id_direccion_fiscal']) ? $this->session->direccion_fiscal_temporal['id_direccion_fiscal'] : ''); ?>",
			"telefono" : "<?php echo (isset($this->session->direccion_fiscal_temporal['telefono']) ? $this->session->direccion_fiscal_temporal['telefono'] : ''); ?>",
			"correo_electronico_facturacion" : "<?php echo (isset($this->session->direccion_fiscal_temporal['correo_electronico_facturacion']) ? $this->session->direccion_fiscal_temporal['correo_electronico_facturacion'] : ''); ?>",
			"linea1" : "<?php echo (isset($this->session->direccion_fiscal_temporal['linea1']) ? $this->session->direccion_fiscal_temporal['linea1'] : ''); ?>",
			"linea2" : "<?php echo (isset($this->session->direccion_fiscal_temporal['linea2']) ? $this->session->direccion_fiscal_temporal['linea2'] : ''); ?>",
			"ciudad" : "<?php echo (isset($this->session->direccion_fiscal_temporal['ciudad']) ? $this->session->direccion_fiscal_temporal['ciudad'] : ''); ?>",
			"codigo_postal" : "<?php echo (isset($this->session->direccion_fiscal_temporal['codigo_postal']) ? $this->session->direccion_fiscal_temporal['codigo_postal'] : ''); ?>",
			"estado" : "<?php echo (isset($this->session->direccion_fiscal_temporal['estado']) ? $this->session->direccion_fiscal_temporal['estado'] : ''); ?>"
		};
		
		<?php $direcciones = $this->cuenta_modelo->obtener_direcciones($this->session->login['id_cliente']); ?>
		<?php $direcciones_fiscales = $this->cuenta_modelo->obtener_direcciones_fiscales($this->session->login['id_cliente']); ?>
		
		<?php $is_client = !is_null($this->session->login['id_cliente']);  ?>
		<?php if(!$is_client): ?>
		info_sesion.situacion = 'no_registrado';
		sesion_fiscal.situacion = 'no_registrado';
		info_sesion.identificador_direccion = 'Principal';
		<?php else: ?>
			<?php if(sizeof($direcciones) == 0): ?>
			info_sesion.situacion = 'sin_direcciones';
			info_sesion.identificador_direccion = 'Principal';
			<?php else: ?>
			info_sesion.situacion = 'con_direcciones';
			<?php endif; ?>
			
			<?php if(sizeof($direcciones_fiscales) == 0): ?>
			sesion_fiscal.situacion = 'sin_direcciones';
			<?php else: ?>
			sesion_fiscal.situacion = 'con_direcciones';
			<?php endif; ?>
		<?php endif; ?>
		
		
		$("[data-dircompleta]").click(function() {
			var direccion = $(this).data('dircompleta');
			$("[name='address1']").val(direccion.linea1);
			$("[name='address2']").val(direccion.linea2);
			$("[name='city']").val(direccion.ciudad);
			$("[name='state']").val(direccion.estado);
			$("[name='zip']").val(direccion.codigo_postal);
			
			
			info_sesion.id_direccion = direccion.id_direccion;
		});
		
		$("[name='direccion[nombre]']").on("change input keyup paste",function() {
			info_sesion.nombre = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[apellidos]']").on("change input keyup paste",function() {
			info_sesion.apellidos = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[email]']").on("change input keyup paste",function() {
			info_sesion.email = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[identificador_direccion]']").on("change input keyup paste",function() {
			info_sesion.identificador_direccion = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[telefono]']").on("change input keyup paste",function() {
			info_sesion.telefono = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[linea1]']").on("change input keyup paste",function() {
			info_sesion.linea1 = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[linea2]']").on("change input keyup paste",function() {
			info_sesion.linea2 = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[ciudad]']").on("change input keyup paste",function() {
			info_sesion.ciudad = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[codigo_postal]']").on("change input keyup paste",function() {
			info_sesion.codigo_postal = $(this).val();
			complete_address();
		});
		
		$("[name='direccion[estado]']").on("change input keyup paste",function() {
			info_sesion.estado = $(this).val();
			complete_address();
		});
		
		// Modificacion direccion_fiscal
		$("[name='direccion_fiscal[razon_social]']").on("change input keyup paste",function() {
			sesion_fiscal.razon_social = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[rfc]']").on("change input keyup paste",function() {
			sesion_fiscal.rfc = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[telefono]']").on("change input keyup paste",function() {
			sesion_fiscal.telefono = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[correo_electronico_facturacion]']").on("change input keyup paste",function() {
			sesion_fiscal.correo_electronico_facturacion = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[linea1]']").on("change input keyup paste",function() {
			sesion_fiscal.linea1 = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[linea2]']").on("change input keyup paste",function() {
			sesion_fiscal.linea2 = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[ciudad]']").on("change input keyup paste",function() {
			sesion_fiscal.ciudad = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[codigo_postal]']").on("change input keyup paste",function() {
			sesion_fiscal.codigo_postal = $(this).val();
			complete_address_fiscal();
		});
		$("[name='direccion_fiscal[estado]']").on("change input keyup paste",function() {
			sesion_fiscal.estado = $(this).val();
			complete_address_fiscal();
		});
		
		
		// Activacion de botones en relacion a direcciones
		$("#id_direccion").change(function() {
			if($("#id_direccion option:selected").attr("id") == "agregar_dinamico") {
				$("#nueva_direccion").foundation("open");
				$("#id_direccion option:eq(0)").prop("selected", true);
			}
			
			if($(this).val() != "") {
				$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").hide();
				$("#area_paypal, #paypal_loading, .p_t_b").show();
				var direccion = $("#id_direccion option:selected").data("dircompleta");
				
				var html = '<span><strong>'+direccion.identificador_direccion+'</strong>';
				html += direccion.linea1+'<br />';
				if(direccion.linea2 != '') {
					html += direccion.linea2+', CP: '+direccion.codigo_postal+'<br />';
				}
				html += 'Teléfono: '+direccion.telefono+'<br />';
				html += direccion.ciudad+', '+direccion.estado+', '+direccion.pais;
				
				$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion: direccion })
				.done(function( data ) {
					$("#pagar_paypal_btn").attr("href", data);
					$("#paypal_loading").hide();
				});
				
				if(direccion.estado == 'Yucatán') {
					//$("#tr_envio_gratis").show();
					//$("#tr_explicacion_envio_gratis").hide();
					//$("#recoger_paquete").prop("checked", false).trigger("change");
				} else {
					//$("#tr_envio_gratis").hide();
					//$("#tr_explicacion_envio_gratis").hide();
					//$("#recoger_paquete").prop("checked", false).trigger("change");
				}
				
				$("#direccion_envio_seleccionada").html(html);
			} else {
				$("#direccion_envio_seleccionada").html('<span class="text-center">Por favor selecciona una dirección de envío.</span>');
				$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").show();
				$("#area_paypal, #paypal_loading, .p_t_b").hide();
				$("#tr_envio_gratis, #tr_explicacion_envio_gratis").hide();
				
			}
		});
		
		// Activacion de botones en relacion a direcciones de facturacion
		$("#id_direccion_fiscal").change(function() {
			if($("#id_direccion_fiscal option:selected").attr("id") == "agregar_dinamico") {
				$("#nueva_facturacion").foundation("open");
				$("#id_direccion_fiscal option:eq(0)").prop("selected", true);
			}
			
			if($(this).val() != "") {
				var direccion_fiscal = $("#id_direccion_fiscal option:selected").data("dircompleta");
				
				var html = '<span><strong>'+direccion_fiscal.razon_social+'</strong>';
				html += direccion_fiscal.rfc+'<br />';
				html += direccion_fiscal.linea1+'<br />';
				if(direccion_fiscal.linea2 != '') {
					html += direccion_fiscal.linea2+', CP: '+direccion_fiscal.codigo_postal+'<br />';
				}
				html += 'Correo facturación: '+direccion_fiscal.correo_electronico_facturacion+'<br />';
				html += 'Teléfono: '+direccion_fiscal.telefono+'<br />';
				html += direccion_fiscal.ciudad+', '+direccion_fiscal.estado+', '+direccion_fiscal.pais;
				
				$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion_fiscal: direccion_fiscal })
				.done(function( data ) {
					
				});
				
				$("#direccion_fiscal_seleccionada").html(html);
			} else {
				$("#direccion_fiscal_seleccionada").html('<span class="text-center">Por favor selecciona los datos de facturación para la factura.</span>');				
			}
		});
		
<?php if($this->session->direccion_temporal): ?>
	<?php if($this->session->direccion_temporal['id_direccion'] != ''): ?>
	$("#id_direccion").val(<?php echo $this->session->direccion_temporal['id_direccion']; ?>);
	
	var direccion = $("#id_direccion option:selected").data("dircompleta");
			
	var html = '<span><strong>'+direccion.identificador_direccion+'</strong>';
	html += direccion.linea1+'<br />';
	if(direccion.linea2 != '') {
		html += direccion.linea2+', CP: '+direccion.codigo_postal+'<br />';
	}
	html += 'Teléfono: '+direccion.telefono+'<br />';
	html += direccion.ciudad+', '+direccion.estado+', '+direccion.pais;
	
	$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion: direccion })
	.done(function( data ) {
		$("#pagar_paypal_btn").attr("href", data);
		$("#paypal_loading").hide();
	});
	
	if(direccion.estado == 'Yucatán') {
		$("#tr_envio_gratis").show();
		$("#tr_explicacion_envio_gratis").hide();
	} else {
		$("#tr_envio_gratis").hide();
		$("#tr_explicacion_envio_gratis").hide();
	}
	
	$("#direccion_envio_seleccionada").html(html);
	<?php endif; ?>
	$("#estado").val('<?php echo $this->session->direccion_temporal['estado']; ?>');

		
	$("#paypal_selecciona_direccion, #oxxo_selecciona_direccion, #tarjeta_selecciona_direccion").hide();
	$("#area_paypal, #paypal_loading, .p_t_b").show();
	
	$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion: <?php echo json_encode($this->session->direccion_temporal); ?> })
	.done(function( data ) {
		$("#pagar_paypal_btn").attr("href", data);
		$("#paypal_loading").hide();
	});
<?php endif; ?>
		
<?php if($this->session->direccion_fiscal_temporal): ?>
	<?php if($this->session->direccion_fiscal_temporal['id_direccion_fiscal'] != ''): ?>
	$("#id_direccion_fiscal").val(<?php echo $this->session->direccion_fiscal_temporal['id_direccion_fiscal']; ?>);
			
	var direccion_fiscal = $("#id_direccion_fiscal option:selected").data("dircompleta");
				
	var html = '<span><strong>'+direccion_fiscal.razon_social+'</strong>';
	html += direccion_fiscal.rfc+'<br />';
	html += direccion_fiscal.linea1+'<br />';
	if(direccion_fiscal.linea2 != '') {
		html += direccion_fiscal.linea2+', CP: '+direccion_fiscal.codigo_postal+'<br />';
	}
	html += 'Correo facturación: '+direccion_fiscal.correo_electronico_facturacion+'<br />';
	html += 'Teléfono: '+direccion_fiscal.telefono+'<br />';
	html += direccion_fiscal.ciudad+', '+direccion_fiscal.estado+', '+direccion_fiscal.pais;
	
	$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion_fiscal: direccion_fiscal })
	.done(function( data ) {
	});
	
	$("#direccion_fiscal_seleccionada").html(html);
	<?php endif; ?>
	$("#estado_limpia").val('<?php echo $this->session->direccion_fiscal_temporal['estado']; ?>');
	
	$.post( "<?php echo site_url('tienda/'.$nombre_tienda_slug.'/carrito/generar_link_paypal'); ?>", { direccion_fiscal: <?php echo json_encode($this->session->direccion_fiscal_temporal); ?> })
	.done(function( data ) {
		
	});
<?php endif; ?>
		
		Conekta.setPublicKey('<?php echo $_ENV['CONEKTA_PUBLIC_KEY'] ?>');
		Conekta.setLanguage("es");

		$('#card_number').payment('formatCardNumber');
		$('#card_expiry_date').payment('formatCardExpiry');
		$('#card_verification').payment('formatCardCVC');

		$("#card_expiry_date").on("change input keyup paste",function() {
			var month = $(this).val().substring(0,2);
			var year = $(this).val().substring(5,9);
			$("#card_expiry_month").val(month);
			$("#card_expiry_year").val(year);
		});
		
		var forma_pago = 'tdc';
		var busy = false;
		
		$('#tab_pago').on('change.zf.tabs', function (event, accordion) {
			var id = $(".tabs-title.is-active a").attr("href").replace("#","");
			
			if(id == 'pago_tarjeta') {
				$("#pago_tarjeta input").prop({ "disabled": false, "required": true });
				$("#pago_paypal input").prop("disabled", true);		
				$("#pago_oxxo input").prop("disabled", true);		
				$("#tipo_pago").val("tdc");
				forma_pago = "tdc";
			} else if(id == 'pago_paypal') {
				$("#pago_paypal input").prop("disabled", false);
				$("#pago_tarjeta input").prop({ "disabled": true, "required": false });
				$("#pago_oxxo input").prop("disabled", true);		
				$("#tipo_pago").val("paypal");
				forma_pago = "paypal";
			} else if(id == 'pago_oxxo') {
				$("#pago_tarjeta input").prop("disabled", true).removeAttr("required");
				$("#pago_paypal input").prop("disabled", true);		
				$("#pago_oxxo input").prop("disabled", false);		
				$("#tipo_pago").val("oxxo");
				forma_pago = "oxxo";
			}
			console.log(forma_pago);
		});
		
		/* $("#terminar_pago")
		}); */
		
		//Cambiar el data abide a abide ajax
		//$("#terminar_pago").on('formvalid.zf.abide', function(event) {
			
		$("#terminar_pago").submit(function(event) {
			
			if (!busy) {
				busy = true;
				if(forma_pago == "tdc") {
					var $form;
					$form = $(this);
					
					var conektaSuccessResponseHandler;
					var conektaErrorResponseHandler;
					
					conektaErrorResponseHandler = function(response) {
						var $form;
						$form = $("#terminar_pago");

						$form.find("#card_errors").text(response.message);
						$form.find("button").prop("disabled", false);
						busy = false;
						return false;
					};
					
					conektaSuccessResponseHandler = function(token) {
						var $form;
						$form = $("#terminar_pago");
						$form.append($("<input type=\"hidden\" name=\"conektaTokenId\" />").val(token.id));
						$form.get(0).submit();
						busy = false;
						return true;
					};
					
					$form.find("button").prop("disabled", true);
					Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);

					return false;
				}else{
					var $form;
					$form = $(this);
					$form.find("button").prop("disabled", true);
					$form.get(0).submit();
					busy = false;
				}
			};
		});
		
		$("#requiero_facturar").click(function() {
			if($(this).is(":checked")) {
				$("#hidden_fact").show();
				
				if($("#id_direccion_fiscal").length > 0) {
					$("#id_direccion_fiscal").prop("required", true);
				}
			} else {
				$("#hidden_fact").hide();
				
				if($("#id_direccion_fiscal").length > 0) {
					$("#id_direccion_fiscal").prop("required", false);
					$("#id_direccion_fiscal option:eq(0)").prop("selected", true);
					
					$.post( "<?php echo site_url('carrito/generar_link_paypal'); ?>", { cancelar_direccion_fiscal: 1 });
				}
			}
		});
		
		/* $(document).on("change click", "#recoger_paquete", function() {
			var recoger = 0;
			if($(this).is(":checked")) {
				$("#tr_explicacion_envio_gratis").show();
				recoger = 1;
			} else {
				$("#tr_explicacion_envio_gratis").hide();
				recoger = 0;
			}
			
			$.post("<?php echo site_url('carrito/actualizar_envio'); ?>", { recoger: recoger } )
			.done(function(result) {
				var resultado = $.parseJSON(result);
				$("#tr_costo_envio span").html(resultado.envio);
				$("#tr_costo_total span").html(resultado.total);
				$("#paypal_loading").show();
				$.post( "<?php echo site_url('carrito/generar_link_paypal'); ?>", { direccion: direccion })
				.done(function( data ) {
					$("#pagar_paypal_btn").attr("href", data);
					$("#paypal_loading").hide();
				});
			});
		}); */
		
	});
</script> 