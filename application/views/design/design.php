<?php echo doctype('html5'); ?> 
<html class="no-js" lang="es">
	<head>
		<?php echo meta('charset', 'utf-8'); ?>
		<?php echo meta('viewport', 'width=device-width, initial-scale=1.0, user-scalable=no'); ?>
		<?php echo link_tag('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>
		<?php echo link_tag('assets/plugins/jquery-ui/jquery-ui.min.css'); ?>
		<?php echo link_tag('css/app.css'); ?>
		
		<?php echo link_tag(array('href' => 'assets/images/icon.png', 'rel' => 'shortcut icon')); ?>
		
		<script src="<?php echo base_url('bower_components/jquery/dist/jquery.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
		<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>		
		<script src="https://rawgit.com/lokesh/color-thief/master/dist/color-thief.min.js"></script>
	</head>
	<body> 

		<script type="text/javascript">
			var baseURL = '<?php echo base_url(); ?>';  
			var urlCase = '<?php echo site_url('image-tool/thumbs.php'); ?>';
			var edit_text_title = 'Editar Texto';
			var team_number_title = 'team_number';
			var confirm_reset_msg = '¿Deseas empezar tu diseño en limpio?';
			var add_qty_or_size_msg = 'No olvides agregar la cantidad de playeras que necesitas.';
			var minimum_qty_msg = 'Al menos debes ordenar: ';
			var please_add_qty_or_size_msg = 'Por favor agrega una cantidad de playeras.';
			var please_try_again_msg = 'Por favor vuelve a intentar.';
			var select_a_color_msg = 'Selecciona un color.';
			var tick_the_checkbox_msg = 'Es necesario aceptar los términos y condiciones.';
			var choose_a_file_upload_msg = 'Selecciona un archivo.';
			var myAccount = '';
			var logOut = '';
			var print_type = 'screen';

			<?php if ( isset($user['id']) ) { ?>
				var user_id = <?php echo $user['id']; ?>;
			<?php }else{ ?>
				var user_id = 0;
			<?php } ?>
		</script>
		
		<form method="POST" id="tool_cart" name="tool_cart" action="">
			<div class="product-info" id="product-attributes">
				<input type="hidden" value="0" name="quantity" id="quantity">         
			</div>
		</form> 

		<div id="design-menu" class="col-left">
			<div id="dg-left" class="width-100">
				<h4 id="options-header" class="text-center hidden-xs">Puedes añadir:</h4>
				<div class="dg-box width-100">
					<ul class="menu-left">
						<li>
							<a class="add_item_text" title="Agregar texto"><i class="fa fa-paragraph"></i> Agregar texto</a>
						</li>
						<li>
							<a title="Agregar imágenes" data-toggle="modal" data-target="#dg-myclipart"><i class="fa fa-file-image-o"></i> Agregar imágenes</a>
						</li>
						<li class="last">
							<a class="add_item_clipart" title="" data-toggle="modal" data-target="#dg-cliparts"><i class="fa fa-star"></i> Agregar clipart</a>
						</li>
					</ul>
				</div>

				<div class="dg-box width-100 div-layers no-active">
					<div class="layers-toolbar">
						<button type="button" class="btn btn-default">
							<i class="fa fa-long-arrow-down"></i>
							<i class="fa fa-long-arrow-up"></i>
						</button>
						<button type="button" class="btn btn-default btn-sm">
							<i class="fa fa-angle-right"></i>           
						</button>
					</div>
			
					<div class="accordion">
						<h3>Capas</h3>
						<div id="dg-layers">
							<ul id="layers">                  
							</ul>
						</div>
					</div>
				</div>

				<div class="dg-box width-100">
					<div class="accordion">
						<h3>Color de tu playera</h3>
						<div class="product-options contentHolder" id="product-details">
						<?php if ($product != false) : ?>
							<div class="content-y">                 
							<?php if (isset($product->design) && $product->design != false) : ?>
								<div class="product-info">
									<div class="form-group product-fields">
										<div class="list-colors clearfix" id="product-list-colors">
										<?php for ($i=0; $i<count($product->design->color_hex); $i++) : ?>
											<span class="bg-colors <?php if ($i==0) echo 'active'; ?>" onclick="design.products.changeColor(this, <?php echo $i; ?>)" data-color-id="<?php echo $product->design->color_id[$i]; ?>" data-color="<?php echo $product->design->color_hex[$i]; ?>" style="background-color:#<?php echo $product->design->color_hex[$i]; ?>" data-placement="top" data-original-title="<?php echo $product->design->color_title[$i]; ?>"></span>
										<?php endfor; ?>
										</div>
									</div>                    
								</div>
							<?php endif; ?>
							</div>
						<?php endif; ?>
						</div>  
					</div>
				</div>

				<div class="dg-box width-100">
					<div class="accordion">
						<h3>Tintas de la impresión</h3>
						<div class="color-used active"></div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="dg-wapper"  style="padding:0 15px;">
        <div id="dg-mask" class="loading"></div>

        <!-- Begin main -->
        <div id="dg-designer">
          <div id="design-column" class="col-xs-12 col-sm-offset-3 col-sm-9">

            <!-- design area -->
            <div id="design-area" class="div-design-area">
              <div id="tools" class="text-right">
                <ul class="dg-tools clearfix">
                  <li class="text-center">
                    <a data-target="#dg-help" id="tools-help" data-toggle="modal" href="javascript:void(0)" title="help">
                      <i class="fa fa-info-circle"></i>
                      <span>Ayuda</span>
                    </a>
                  </li>       
                  <li class="text-center">
                    <a href="javascript:void(0)" data-type="preview" title="preview" class="dg-tool">
                      <i class="fa fa-eye"></i>
                      <span>Vista Previa</span>
                    </a>
                  </li>
                  <li class="hide">
                    <a href="javascript:void(0)" data-type="zoom" title="zoom" class="dg-tool">
                      <i class="glyphicons search"></i>
                      <span>Zoom</span>
                    </a>
                  </li>
                  <li class="text-center">
                    <a href="javascript:void(0)" data-type="reset" title="reset" class="dg-tool">
                      <i class="fa fa-recycle"></i>
                      <span>Limpiar</span>
                    </a>
                  </li>  
                  <li class="text-center float-right" id="finish-btn">
                    <a href="#" onclick="design.ajax.addJs(this)">
                      Siguiente <i class="fa fa-arrow-right"></i>
                    </a>
                  </li>        
                </ul>
              </div>
              <div id="app-wrap" class="div-design-area">
			  
                <?php if ($product == false || (isset($product->design) && $product->design == false)) : ?>
                  <div id="view-front" class="labView active">
                    <div class="product-design">
                      <strong>El producto no fue encontrado.</strong>
                    </div>
                  </div>
                <?php else: ?>

                  <!-- begin front design -->           
                  <div id="view-front" class="labView active">
                    <div class="product-design"></div>
                    <div class="design-area"><div class="content-inner"></div></div>
                  </div>            
                  <!-- end front design -->

                  <!-- begin back design -->
                  <div id="view-back" class="labView">
                    <div class="product-design"></div>
                    <div class="design-area"><div class="content-inner"></div></div>
                  </div>
                  <!-- end back design -->

                  <!-- begin left design -->
                  <div id="view-left" class="labView">
                    <div class="product-design"></div>
                    <div class="design-area"><div class="content-inner"></div></div>
                  </div>
                  <!-- end left design -->

                  <!-- begin right design -->
                  <div id="view-right" class="labView">
                    <div class="product-design"></div>
                    <div class="design-area"><div class="content-inner"></div></div>
                  </div>
                  <!-- end right design -->

                <?php endif; ?>
              </div>
            </div>

            <div class="" id="product-thumbs"></div>
          </div>            
        </div>
        <!-- End main -->     
      </div>

      <div id="screen_colors_body" style="display:none;">
        <div id="screen_colors">
          <div class="screen_colors_top">
            <div class="col-xs-5 col-md-5 text-left" id="screen_colors_images">
            </div>
            <div class="col-xs-7 col-md-7 text-left">
              <h4>Selecciona las tintas de tu imagen</h4>
              <span class="help-block">Selecciona las tintas que tiene tu imagen</span>
              <span class="help-block">Esto nos ayuda a determinar tu precio</span>
              <p><strong> Si no coinciden, sera rechazado tu diseño.</strong></p>
              <span id="screen_colors_error"></span>
              <div id="screen_colors_list" class="list-colors"></div>
            </div>
          </div>
          <div class="screen_colors_botton">
            <button type="button" class="btn btn-naranja" onclick="design.item.setColor()">Continuar</button>
          </div>
        </div>
      </div>


        <!-- Begin clipart -->
        <div class="modal fade" id="dg-cliparts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Selecciona alguno de los cliparts</h4>
					</div>
					<div class="modal-body" id="clipart-area">
						<div id="dag-list-arts" class="row small-up-2 medium-up-3 large-up-6"></div>
					</div>

					<div class="modal-footer">
						<div class="align-right" id="arts-pagination" style="display:none">
							<ul class="pagination">
								<li><a href="javascript:void(0)">&laquo;</a></li>
								<li class="active"><a href="javascript:void(0)">1</a></li>
								<li><a href="javascript:void(0)">2</a></li>
								<li><a href="javascript:void(0)">3</a></li>
								<li><a href="javascript:void(0)">4</a></li>
								<li><a href="javascript:void(0)">5</a></li>
								<li><a href="javascript:void(0)">&raquo;</a></li>
							</ul>
							<input type="hidden" value="0" autocomplete="off" id="art-number-page">
						</div>
						<div class="align-right" id="arts-add" style="display:none">
							<div class="art-detail-price"></div>
							<button type="button" class="btn btn-naranja">Agregar a diseño</button>
						</div>
					</div>
				</div>
			</div>
        </div>
        <!-- End clipart -->

        <!-- Begin Upload -->
        <div class="modal fade" id="dg-myclipart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="border-color:#CACACA;">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<ul role="tablist" id="upload-tabs">
							<li class="active"><a href="#upload-computer" role="tab" data-toggle="tab"><i class="fa fa-upload"></i> Subir imagen</a></li>
							<li><a href="#uploaded-art" role="tab" data-toggle="tab"><i class="fa fa-folder-open-o"></i> Usar imágenes subidas</a></li>
						</ul>
					</div>
					<div class="modal-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="upload-computer">
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="files-upload" id="big-file-dude" class="expanded button info"><i class="fa fa-file-image-o"></i> Seleccionar archivo</label>
											<input type="file" id="files-upload" class="show-for-sr" autocomplete="off" />
										</div>

										<div class="checkbox" style="display:none;">
											<label>
												<input type="checkbox" autocomplete="off" id="remove-bg"> <span class="help-block">Mi imagen no cuenta con fondo en blanco</span>
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<p class="aceptamos">Tipos de archivos que aceptamos (Máximo 10 MB por archivo)</p>
										<ul class="requerimientos">
											<li><i class="fa fa-check"></i> Imágenes JPG (.jpg, .jpeg)</li>
											<li><i class="fa fa-check"></i> Imágenes PNG (.png)</li>
											<li><i class="fa fa-check"></i> Imágenes GIF no animadas (.gif)</li>
										</ul>
										<p class="aceptamos text-justify">Si tu imagen no cumple con los <a href="<?php echo site_url('terminos-y-condiciones'); ?>">términos y condiciones</a> de printome.mx, tu diseño será rechazado.</p>
										<div class="checkbox">
											<label>
												<input type="checkbox" autocomplete="off" id="upload-copyright"><span class="aceptamos" style="color:#555;">He leído y acepto los <a href="<?php echo site_url('terminos-y-condiciones'); ?>" target="_blank">términos y condiciones</a>.</span>
											</label>
										</div>
										<div class="form-group text-center" style="border-top: dotted 1px #CCC;padding-top: 1.1rem;margin:0;">
											<button type="button" class="button success" id="action-upload"><i class="fa fa-upload"></i> Subir imagen</button>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="uploaded-art">
								<div class="row">
									<div class="small-18 columns">
										<p class="aceptamos">En esta sección te aparecerán todas las imágenes que hayas subido. Para insertar alguna de las imágenes a tu diseño, simplemente haz clic sobre la imagen específica.</p>
									</div>
								</div>
								<div class="row small-up-3" id="dag-files-images">
								</div>
								<div id="drop-area"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
<!-- End Upload -->

<!-- Begin Note -->
<div class="modal fade" id="dg-note" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">designer_note_add_note</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
<!-- End Note -->

<!-- Begin Help -->
<div class="modal fade" id="dg-help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Cómo hacer tu playera</h4>
      </div>
      <div class="modal-body">
       
      </div>
    </div>
  </div>
</div>
<!-- End Help -->

<!-- Begin My design -->
<div class="modal fade" id="dg-mydesign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Mi Diseño</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
<!-- End my design -->

<!-- Begin design ideas -->
<div class="modal fade" id="dg-designidea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Ideas de diseño</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
<!-- End design ideas --> 

<!-- Begin fonts -->
<div class="modal fade" id="dg-fonts" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>            
        <h4 class="modal-title" id="myModalLabel">Elige una fuente</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 list-fonts"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End fonts -->

<!-- Begin preview -->
<div class="modal fade" id="dg-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>            
      </div>
      <div class="modal-body" id="dg-main-slider">          
      </div>
    </div>
  </div>
</div>
<!-- End preview -->

<!-- Begin Share -->
<div class="modal fade" id="dg-share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>            
        <h4>designer_share_save_completed</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="exampleInputEmail1">designer_share_your_design_link:</label>
          <input type="text" class="form-control" id="link-design-saved" value="" readonly>
        </div>

        <div class="form-group row">
          <label class="col-md-1" style="line-height: 24px;">designer_share: </label>
          <div class="col-md-1">
            <a href="javascript:void(0)" onclick="design.share.email()" class="icon-25 share-email" title="Email"></a>
          </div>
          <div class="col-md-1">
            <a href="javascript:void(0)" onclick="design.share.facebook()" class="icon-25 share-facebook" title="Facebook"></a> 
          </div>
          <div class="col-md-1">
            <a href="javascript:void(0)" onclick="design.share.twitter()" class="icon-25 share-twitter" title="Twitter"></a>
          </div>
          <div class="col-md-1">
            <a href="javascript:void(0)" onclick="design.share.pinterest()" class="icon-25 share-pinterest" title="Pinterest"></a> 
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Share -->
<style>
  .option-modal{
    margin-left: 25px;
    margin-right: 25px;
    width: 40%;
    cursor: pointer;
  }
  .option-modal:hover {
    box-shadow: 0px 0px 28px -2px rgba(71,71,71,0.48);
  }
</style>

<div class="modal fade" id="dg-sizes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">      
				<div class="row">
					<div class="col-sm-6 option-modal" data-open-window="#paynow_modal" data-dismiss="modal">
						<div class="row">
							<div class="col-sm-12 text-center">
								<h4 style="color:#fa4c06">COMPRAR AHORA</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 text-center">
								<div style="margin-bottom:36px;">
									<img src="<?php echo site_url('assets/images/cart.png'); ?>" alt="">
									<div style="margin-bottom:36px;">
										<p>
										1. Selecciona talla y numero de playeras <br>
										2. Cotiza <br>
										3. Haz tu pedido 
										</p>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center">
										<a data-dismiss="modal" data-toggle="modal" href="#paynow_modal" class="btn btn-verde">Comprar</a>
									</div>
								</div>
							</div>
							<div class="col-sm-6 option-modal" style='padding-top: 3em;padding-bottom: 3em;'  data-open-window="#enhance_modal" data-dismiss="modal">
								<div class="row">
									<div class="col-sm-12 text-center">
										<h4 style="color:#fa4c06">ENHANCE</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center">
										<div style="margin-bottom:36px;">
											<img src="<?php echo site_url('assets/images/shirt.png'); ?>" alt="">
											<div style="margin-bottom:36px;">
												<p>
												1. Comparte tu campaña <br>
												2. Vende tu propio diseño 
												</p>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12 text-center">
										<a data-dismiss="modal" data-toggle="modal" href="#enhance_modal" class="btn btn-verde">Crear Campaña</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
	</div>
</div>

<div class="modal fade" id="paynow_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Selecciona tus tallas</h4>
			</div>
			<div class="modal-body">
				<p>Selecciona el número de playeras por talla que quieras para cotizar tu pedido.</p>
				<div class="row">
					<div class="col-xs-4 text-center" style="border-right:1px solid white;">
						<h4 >Tallas</h4>
						<div class="row">
							<?php foreach($this->catalogo_modelo->obtener_tallas_por_producto($product->id_producto) as $key=>$color): ?>
							<div id="color_<?php echo $color->nombre_color; ?>" class="col-sm-6" style="display:none;">
								<div class="form-group text-center">
									<label for="input_<?php echo $color->id_sku; ?>"><?php echo $color->caracteristicas->talla; ?></label>
									<input type="number" min="0" data-cantidad-talla class="form-control text-center" name="sku[<?php echo $color->id_sku; ?>]" id="input_<?php echo $color->id_sku; ?>"  placeholder="0">
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					
					<div class="col-xs-8" style="border-left:1px solid white;">
						<p id="cotizacion" class="text-center"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Continuar diseñando</button>
				<button id="cotizar" type="button" class="btn btn-verde" >Cotizar</button>
				<button id="pay_now" type="button" class="btn btn-naranja" style="padding:6px 12px">Pagar</button>
			</div>
      </div>
      
    </div>
</div>

<div class="modal fade" id="enhance_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <h3 class="text-center">
          Enhance! <br>
          <small style="font-size:17px;">
            Una nueva manera de hacer dinero online
          </small>
          
        </h3>
        <p class="text-center">
          Vende playeras con tus propios diseños para apoyar tu pasión o proyecto. <br> Selecciona a continuación los detalles de tu producto. 
        </p>
        <div class="text-center">
          <button id="enhance_now" type="button" class="btn btn-verde btn-large">Generar Campaña</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Continuar diseñando</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
</div>

<div class="popover right" id="dg-popover">
  
	<h3 class="popover-title"><span>Editar imagen</span> <a href="javascript:void(0)" class="popover-close"><i class="fa fa-times"></i></a></h3>
	<div class="popover-content">

    <!-- BEGIN clipart edit options -->
    <div id="options-add_item_clipart" class="dg-options">
      <div class="dg-options-toolbar">
        <div aria-label="First group" role="group" class="btn-group btn-group-lg">            
          <button class="btn btn-default btn-action-edit" type="button" data-type="edit">
            <i class="glyphicon glyphicon-tint"></i> <small class="clearfix">Edit</small>
          </button>
          <button class="btn btn-default btn-action-colors" type="button" data-type="colors">
            <i class="glyphicon glyphicon-tint"></i> <small class="clearfix">Colores</small>
          </button>
          <button class="btn btn-default" type="button" data-type="size">
            <i class="fa fa-text-height"></i> <small class="clearfix">Tamaño</small>
          </button>
          <button class="btn btn-default" type="button" data-type="rotate">
            <i class="fa fa-rotate-right"></i> <small class="clearfix">Rotar</small>
          </button>
          <button class="btn btn-default" type="button" data-type="functions">
            <i class="fa fa-cogs"></i> <small class="clearfix">designer_functions</small>
          </button>
        </div>
      </div>

			<div class="dg-options-content" id="area-editar-imagen">
				<div class="arrow"></div>
				<div class="row toolbar-action-edit">         
					<div id="item-print-colors">
					</div>
				</div>
				<div class="row toolbar-action-size hide">
					<div class="col-xs-6 col-lg-6 align-center">
						<div class="form-group">
							<small>Ancho</small>
							<input type="text" size="2" id="clipart-width" readonly disabled>
						</div>
					</div>
					<div class="col-xs-6 col-lg-6 align-center">
						<div class="form-group">
							<small>Altura</small>
							<input type="text" size="2" id="clipart-height" readonly disabled>
						</div>
					</div>
				</div>
				
				<div class="row toolbar-action-size">
				  <div class="col-xs-12 col-lg-12 align-center no-padding">
					<div class="form-group">
						<label for="clipart-lock">
							<input type="checkbox" class="ui-lock" id="clipart-lock" /> Desbloquear proporciones
						</label>              
					</div>
				  </div>
				</div>
				
				<div class="row toolbar-action-rotate">         
					<div class="form-group col-lg-12">
						<div class="row">
							<div class="col-xs-12 align-center">
								<small style="margin-bottom: 0.4rem;">Rotar elemento</small>
							</div>
							<div class="col-xs-12 align-center">
								<span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="clipart-rotate-value" />&deg;</span>
								<span class="btn btn-default btn-xs undo glyphicons refresh hide"></span>
							</div>
						</div>            
					</div>
				</div>

				<div class="row toolbar-action-colors">
					<div id="clipart-colors">
						<div class="form-group col-lg-12 text-left position-static no-padding">
							<small>Elegir colores</small>
							<div id="list-clipart-colors" class="list-colors row small-up-3"></div>
						</div>
					</div>
				</div>

				<div class="row toolbar-action-functions">  
					<div class="col-lg-12 form-group text-center">
						<span class="btn btn-default btn-xs" onclick="design.item.flip('x')">
							<i class="glyphicons transfer glyphicons-12"></i> Invertir
						</span>             
						<span class="btn btn-default btn-xs" onclick="design.item.center()">
							<i class="glyphicons align_center glyphicons-12"></i> Centrar
						</span>
					</div>
				</div>
			</div>
	</div>
    <!-- END clipart edit options -->

    <!-- BEGIN Text edit options -->
    <div id="options-add_item_text" class="dg-options">
      <div class="dg-options-toolbar">
        <div aria-label="First group" role="group" class="btn-group btn-group-lg">
          <button class="btn btn-default" type="button" data-type="text">
            <i class="fa fa-pencil"></i> <small class="clearfix">Texto</small>
          </button>
          <button class="btn btn-default" type="button" data-type="fonts">
            <i class="fa fa-font"></i> <small class="clearfix">Fuentes</small>
          </button>
          <button class="btn btn-default" type="button" data-type="style">
            <i class="fa fa-align-justify"></i> <small class="clearfix">Estilo</small>
          </button>
          <button class="btn btn-default" type="button" data-type="outline">
            <i class="fa fa-crop"></i> <small class="clearfix">Borde</small>
          </button>
          <button class="btn btn-default" type="button" data-type="size">
            <i class="fa fa-text-height"></i> <small class="clearfix">Tamaño</small>
          </button>
          <button class="btn btn-default" type="button" data-type="rotate">
            <i class="fa fa-rotate-right"></i> <small class="clearfix">Rotar</small>
          </button>
          <button class="btn btn-default" type="button" data-type="functions">
            <i class="fa fa-cogs"></i> <small class="clearfix">Diseñador</small>
          </button>
        </div>
      </div>

		<div class="dg-options-content" id="area-editar-texto">
			<div class="arrow"></div>
			<!-- edit text normal -->
			<div class="row toolbar-action-text">
				<div class="col-xs-12 no-padding">
					<textarea class="text-update" data-event="keyup" data-label="text" id="enter-text"></textarea>
				</div>
			</div>

			<div class="row toolbar-action-fonts">
				<div class="col-xs-12 no-padding">
					<div class="form-group">
						<small>Elige una fuente</small>
						<div class="dropdown" data-target="#dg-fonts" data-toggle="modal">
							<a id="txt-fontfamily" class="pull-left" href="javascript:void(0)">
								Cambiar fuente
							</a>
							<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s pull-right"></span>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row toolbar-action-style">
				<div class="col-xs-6 no-padding-left">
					<small class="bluesmall">Tipo de fuente</small>
					<div id="text-style">
						<span id="text-style-b" class="text-update btn btn-default btn-xs glyphicons bold glyphicons-12" data-event="click" data-label="styleB"></span>
						<span id="text-style-i" class="text-update btn btn-default btn-xs glyphicons italic glyphicons-12" data-event="click" data-label="styleI"></span>
						<span id="text-style-u" class="text-update btn btn-default btn-xs glyphicons text_underline glyphicons-12" data-event="click" data-label="styleU"></span>
					</div>
				</div>
				<div class="col-xs-6 no-padding-right">
					<small class="bluesmall">Alineación</small>
					<div id="text-align">
						<span id="text-align-left" class="text-update btn btn-default btn-xs glyphicons align_left glyphicons-12" data-event="click" data-label="alignL"></span>
						<span id="text-align-center" class="text-update btn btn-default btn-xs glyphicons align_center glyphicons-12" data-event="click" data-label="alignC"></span>
						<span id="text-align-right" class="text-update btn btn-default btn-xs glyphicons align_right glyphicons-12" data-event="click" data-label="alignR"></span>
					</div>
				</div>
			</div>

        <div class="clear"></div>

        <div class="row toolbar-action-outline">
			<div class="col-xs-6 no-padding-left">
				<div class="form-group">
					<small>Color</small>
					<div class="list-colors">
						<a class="dropdown-color" id="txt-color" title="Color del texto" href="javascript:void(0)" data-color="black" data-label="color" style="background-color:black">
							<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s" style="right: 17px;"></span>
						</a>
					</div>
				</div>
			</div>
			<div class="col-xs-6 no-padding-right">
				<small class="bluesmall">Borde</small>
					<div class="option-outline">              
						<div class="list-colors">
							<a class="dropdown-color bg-none" data-label="outline" data-placement="top" data-original-title="Color del borde" href="javascript:void(0)" data-color="none">
								<span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
        <div class="row toolbar-action-outline">
			<small class="bluesmall" style="margin-bottom: 0.4rem;">Grosor del borde</small>
			<div class="col-xs-10 no-padding-left" style="padding-left: 0.4rem;">
				<div id="dg-outline-width"></div>
			</div>
			<div class="col-xs-2">
				<a class="dg-outline-value"><span class="outline-value pull-left">0</span></a>
			</div>
		</div>

        <div class="row hide">
          <div class="col-lg-12">
            <small>designer_clipart_edit_adjust_shape</small>
            <div id="dg-shape-width"></div>
          </div>
        </div>

        <div class="clear"></div>

        <div class="row toolbar-action-size hide">
          <div class="col-xs-6 col-lg-6 align-center">
            <div class="form-group">
              <small>Ancho</small><br>
              <input type="text" size="2" id="text-width" readonly disabled>
            </div>
          </div>
          <div class="col-xs-6 col-lg-6 align-center">
            <div class="form-group">
              <small>Alto</small><br>
              <input type="text" size="2" id="text-height" readonly disabled>
            </div>
          </div>
        </div>
        <div class="row toolbar-action-size">
          <div class="col-xs-12 col-lg-12 align-center no-padding">
            <div class="form-group">
				<label for="text-lock">
					<input type="checkbox" class="ui-lock" id="text-lock" /> Desbloquear proporciones
				</label>              
            </div>
          </div>
        </div>

        <div class="row toolbar-action-rotate">         
          <div class="form-group col-lg-12">
            <div class="row">
              <div class="col-xs-12 align-center">
                <small style="margin-bottom: 0.4rem;">Rotar elemento</small>
              </div>
              <div class="col-xs-12 align-center">
                <span class="rotate-values"><input type="text" value="0" class="input-small rotate-value" id="text-rotate-value" />&deg;</span>
				<span class="btn btn-default btn-xs undo glyphicons refresh hide"></span>
              </div>
            </div>            
          </div>
        </div>

        <div class="row toolbar-action-functions">  
          <div class="col-lg-12 text-center">
            <span class="btn btn-default btn-xs" onclick="design.item.flip('x')">
              <i class="glyphicons transfer glyphicons-12"></i>
              Invertir
            </span>
            <span class="btn btn-default btn-xs" onclick="design.item.center()">
              <i class="glyphicons align_center glyphicons-12"></i>
              Centrar
            </span>
          </div>
        </div>
      </div>
    </div>
    <!-- END clipart edit options -->

    <!-- END team edit options -->
</div>
  
  <!-- BEGIN colors system -->
  <div class="o-colors" style="display:none;">    
    <div class="other-colors"></div>
  </div>
  <!-- END colors system -->
  
  
  <div id="cacheText"></div>

  
  <?php if (isset($product->design)) {?>
  <script type="text/javascript">
    //var min_order = '<?php //echo $product->min_order; ?>';
    var min_order = '1';
    var product_id = '<?php echo $product->id_producto; ?>';
    //var print_type = '<?php //echo $product->print_type; ?>';
    var uploadSize = [];
    uploadSize['max']  = '10';
    uploadSize['min']  = '0.5';
    var items = {};
    items['design'] = {};
    <?php 
    $js = '';
    $elment = count($product->design->color_hex);
    for($i=0; $i<$elment; $i++)
    {     
      $js .= "items['design'][$i] = {};";
      $js .= "items['design'][$i]['color'] = \"".$product->design->color_hex[$i]."\";";
      $js .= "items['design'][$i]['title'] = \"".$product->design->color_title[$i]."\";";
      $postions = array('front', 'back', 'left', 'right');
      foreach ($postions as $v)
      {
        $view = $product->design->$v;       
        if (count($view) > 0) 
        {
          if (isset($view[$i]) == true)
          {
            $item = (string) $view[$i];           
            $js .= "items['design'][".$i."]['".$v."']=\"".$item."\";";            
          }
          else
          {
            $js .= "items['design'][$i]['$v'] = '';";
          }
        }
        else
        {
          $js .= "items['design'][$i]['$v'] = '';";
        }       
      }
    }
    echo $js;
    ?>
    items['area'] = {};
    items['area']['front']  = "<?php echo $product->design->area->front; ?>";
    items['area']['back']   = "<?php echo $product->design->area->back; ?>";
    items['area']['left']   = "<?php echo $product->design->area->left; ?>";
    items['area']['right']  = "<?php echo $product->design->area->right; ?>";   
    items['params'] = [];   
    items['params']['front']  = "<?php echo $product->design->params->front; ?>";   
    items['params']['back'] = "<?php echo $product->design->params->back; ?>";    
    items['params']['left'] = "<?php echo $product->design->params->left; ?>";    
    items['params']['right']  = "<?php echo $product->design->params->right; ?>";   
  </script>
  <?php } ?>
  
  <!-- BEGIN: popup cart -->
  <div class="modal fade" id="cart_notice" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">close_btn</span></button>
        </div>
        <div class="modal-body">        
          <h5><strong>cart_mgs</strong></h5>
          <div class="row">
            <div class="col-md-5 cart-added-img"></div>
            <div class="col-md-7 cart-added-info"></div>
          </div>
          <div class="row cart-button">
            <div class="col-md-6 pull-left text-left">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">continue_design</button>
            </div>
            <div class="col-md-6 pull-right text-right">
              <a href="<?php echo site_url('cart'); ?>" class="btn btn-naranja btn-sm">checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>  
  <!--end-->
  
  <div id="save-confirm" title="Save Your Design" style="display:none;">
    <p>designer_saved_design_confirm</p>
  </div>

  <!--end-->
		<script type="text/javascript" src="<?php echo site_url('assets/js/design_upload.js'); ?>"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
			<?php if( $id_color  !== 0 ){ ?>
				design.imports.productColor('<?php echo $id_color; ?>');				
			<?php } ?>

			<?php if( $design_id  != '' ){ ?>
				design.imports.loadDesign('<?php echo $design_id; ?>');
			<?php } ?>
			});

			<?php if(isset($this->session->userdata('user')->status) && $this->session->userdata('user')->status == 1){ ?>
			jQuery('document').ready(function(){
				login('logged');
			});
			<?php }else{ ?>
			jQuery('.menu-top').children('ul').show();
			<?php } ?>

			<?php if($this->session->flashdata('msg') != ''){?>
			alert('<?php echo $this->session->flashdata('msg');?>');
			<?php } ?>
			
			jQuery(window).load(function() {
				jQuery("[data-color-id='<?php echo $id_color; ?>']").click();
			});
        </script>

        <script src="<?php echo base_url('assets/js/add-ons.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.ui.rotatable.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/language.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js/design.js'); ?>"></script>  
        <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/canvg.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/validate.js'); ?>"></script>  

      </body>
      </html>