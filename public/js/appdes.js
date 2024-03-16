jQuery(document).foundation();

WebFontConfig = {
	google: {
		families: ['Lato:300,400,700']
	}
};

(function(d) {
  var wf = d.createElement('script'), s = d.scripts[0];
  wf.src = base_url+'bower_components/webfontloader/webfontloader.js';
  wf.async = true;
  s.parentNode.insertBefore(wf, s);
})(document);

new Clipboard(".copier");

jQuery("input[type=file]").on('change',function(){
	if(typeof this.files != 'undefined') {
		if(typeof this.files[0] != 'undefined') {
			if(this.files[0].name != '') {
				jQuery("#action-upload").click();
			}
		} else {

		}
	} else {
	}
});

jQuery(document).on("click", ".no_quiero_tutorial", function() {
	var razon = jQuery(this).data("mostrar");
	if(razon == 'no') {
		jQuery(this).children("i").removeClass("fa-square-o").addClass("fa-check-square-o");
	} else if(razon == 'si') {
		jQuery(this).children("i").addClass("fa-square-o").removeClass("fa-check-square-o");
	}
	jQuery.ajax({
		type: "POST",
		url: baseURL + "designer/ocultar_tutorial/"+razon
	}).done(function(html) {
		jQuery('body').pagewalkthrough('close');
	});
});

jQuery(document).on("click", "#tutorial-link", function() {
	/*jQuery("#video-como").foundation("open");*/
	if (window.matchMedia("(min-width: 400px)").matches) {
		// arriba de 400px
		jQuery('body').pagewalkthrough({
			name: 'introduction',
			steps: [{
				popup: {
					content: '#paso-1',
					type: 'modal',
				}
			}, {
				wrapper: '#cambiar-de-producto',
				popup: {
					content: '#paso-2',
					type: 'tooltip',
					position: 'right'
				}
			}, {
				wrapper: '#cambiar-de-color-de-producto',
				popup: {
					content: '#paso-3',
					type: 'tooltip',
					position: 'right'
				}
			}, {
				wrapper: '#agrega-cosas',
				popup: {
					content: '#paso-4',
					type: 'tooltip',
					position: 'right'
				}
			}, {
				wrapper: '#cont-in-tut',
				popup: {
					content: '#paso-5',
					type: 'tooltip',
					position: 'left'
				}
			}, {
				wrapper: '#finish-btn',
				popup: {
					content: '#paso-6',
					type: 'tooltip',
					position: 'left'
				}
			}]
		});
	}else{
		jQuery('body').pagewalkthrough({
			name: 'introduction',
			steps: [{
				popup: {
					content: '#paso-1',
					type: 'modal'
				}
			}, {
				wrapper: '#cambiar-de-producto',
				popup: {
					content: '#paso-2',
					type: 'tooltip'
				}
			}, {
				wrapper: '#cambiar-de-color-de-producto',
				popup: {
					content: '#paso-3',
					type: 'tooltip'
				}
			}, {
				wrapper: '#agrega-cosas',
				popup: {
					content: '#paso-4',
					type: 'tooltip'
				}
			}, {
				wrapper: '#cont-in-tut',
				popup: {
					content: '#paso-5',
					type: 'tooltip',
					position: 'top'
				}
			}, {
				wrapper: '#finish-btn',
				popup: {
					content: '#paso-6',
					type: 'tooltip'
				}
			}]
		});
	};
	jQuery('body').pagewalkthrough('show');
});

jQuery(document).ready(function(){
	if(id_color != 0 && productColor && !diseno_sesion) {
		design.imports.productColor(id_color.toString());
		design.id_color = id_color.toString();
	}

	if(id_unico != '' && cargarDiseno) {
		design.imports.loadDesign(id_unico.toString());
	}

	if(diseno_sesion && !cargarDiseno) {
		//design.imports.productColor(sesion.id_color.toString());
		//design.id_color = sesion.id_color.toString();
		design.imports.loadSession();
		//design.guardar_sesion();
	}
	/*if (window.matchMedia("(min-width: 400px)").matches) {
		// arriba de 400px
		jQuery('body').pagewalkthrough({
			name: 'introduction',
			steps: [{
				popup: {
					content: '#paso-1',
					type: 'modal',
				}
			}, {
				wrapper: '#cambiar-de-producto',
				popup: {
					content: '#paso-2',
					type: 'tooltip',
					position: 'right'
				}
			}, {
				wrapper: '#cambiar-de-color-de-producto',
				popup: {
					content: '#paso-3',
					type: 'tooltip',
					position: 'right'
				}
			}, {
				wrapper: '#agrega-cosas',
				popup: {
					content: '#paso-4',
					type: 'tooltip',
					position: 'right'
				}
			}, {
				wrapper: '#cont-in-tut',
				popup: {
					content: '#paso-5',
					type: 'tooltip',
					position: 'top'
				}
			}, {
				wrapper: '#finish-btn',
				popup: {
					content: '#paso-6',
					type: 'tooltip',
					position: 'left'
				}
			}]
		});
	}else{
		jQuery('body').pagewalkthrough({
			name: 'introduction',
			steps: [{
				popup: {
					content: '#paso-1',
					type: 'modal'
				}
			}, {
				wrapper: '#cambiar-de-producto',
				popup: {
					content: '#paso-2',
					type: 'tooltip'
				}
			}, {
				wrapper: '#cambiar-de-color-de-producto',
				popup: {
					content: '#paso-3',
					type: 'tooltip'
				}
			}, {
				wrapper: '#agrega-cosas',
				popup: {
					content: '#paso-4',
					type: 'tooltip'
				}
			}, {
				wrapper: '#cont-in-tut',
				popup: {
					content: '#paso-5',
					type: 'tooltip',
					position: 'top'
				}
			}, {
				wrapper: '#finish-btn',
				popup: {
					content: '#paso-6',
					type: 'tooltip'
				}
			}]
		});
	}*/

	if(mostrar_tutorial) {
		if (Foundation.MediaQuery.atLeast('medium')) {
			jQuery('body').pagewalkthrough('show');
		}
	}
});

jQuery(window).load(function() {
	jQuery("[data-color-id='"+id_color+"']").click();
	jQuery('[data-cantidad-talla]').payment('restrictNumeric');

});
