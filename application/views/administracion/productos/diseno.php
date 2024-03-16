<div id="product-designer">
  <div class="modal-content">
  
    <div class="modal-body">
      <div class="row">
        <div class="columns medium-8">
          <strong>Lado: <?php echo helperProduct::position($position); ?></strong>
        </div>
        <div class="columns medium-8">
          <ul class="colors">
            <li>              
              <?php echo $title; ?>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="columns medium-16">
          <div class="row">
            <div class="columns medium-24">
              <div class="product-design-view">
                <div id="product-images"></div>
                <div id="area-design"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="design-tools columns medium-24">
              <a href="javascript:void(0)" title="" onclick="dgUI.product.move('up')"><i class="fa fa-arrow-up"></i></a>
              <a href="javascript:void(0)" title="" onclick="dgUI.product.move('down')"><i class="fa fa-arrow-down"></i></a>
              <a href="javascript:void(0)" title="" onclick="dgUI.product.move('left')"><i class="fa fa-arrow-left"></i></a>
              <a href="javascript:void(0)" title="" onclick="dgUI.product.move('right')"><i class="fa fa-arrow-right"></i></a>
              <a href="javascript:void(0)" title="" onclick="dgUI.product.move('center')"><i class="fa fa-arrows"></i></a>
              <a href="javascript:void(0)" title="" onclick="jQuery.fancybox( {href : '<?php echo site_url('/administracion/media/modals/design/2') ?>', type: 'iframe'} );"><i class="fa fa-file-image-o"></i></a>
            </div>
          </div>
          <div class="row">
            <div class="columns medium-24">
              <span class=""> Click images, area design to move, resize object.</span>
            </div>
          </div>
        </div>
        
        <div class="columns medium-8">
          <div class="row">
            <div class="columns medium-24">
              <table  width="100%">
                <thead>
                  <tr>
                    <th width="100%">Dimensiones del Producto</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="row collapse">
                        <label>Ancho</label>
                        <div class="small-10 columns">
                          <input type="text" onkeyup="dgUI.product.area(this);" class="area-width"/>
                        </div>
                        <div class="small-6 columns end ">
                          <span class="postfix" style="height:33px;">cm</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="small-1 columns ">
                        <input type="checkbox" class="area-locked-width" onclick="dgUI.product.lock(this)" id="locked-width" />
                        </div>
                        <div class="small-16 columns end">
                          <label for="locked-width"> Bloquear dimensiones</label>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="row collapse">
                        <label>Alto</label>
                        <div class="small-10 columns">
                          <input type="text" onkeyup="dgUI.product.area(this);"  class="area-height">
                        </div>
                        <div class="small-6 columns end">
                          <span class="postfix" style="height:33px;">cm</span>
                        </div>
                      </div>
                      <div class="row">
                        <div class="small-1 columns ">
                        <input type="checkbox" class="area-locked-height" onclick="dgUI.product.lock(this)" id="locked-height" />
                        </div>
                        <div class="small-16 columns end">
                          <label for="locked-height"> Bloquear dimensiones</label>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="columns medium-24">
              <table  width="100%">
                <thead>
                  <tr>
                    <th colspan="3">Forma de área imprimible</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="shape-tool">
                    <td class="text-center">
                      <a href="javascript:void(0)" title="square" onclick="dgUI.product.shape('square', this)"><i class="fa fa-stop fa-3x"></i></a>
                    </td>
                    <td class="text-center">
                      <a href="javascript:void(0)" title="circle" onclick="dgUI.product.shape('circle', this)"><i class="fa fa-circle fa-3x"></i></a>
                    </td>
                    <td class="text-center">
                      <a href="javascript:void(0)" title="circlesquare" onclick="dgUI.product.shape('circlesquare', this)"><i class="fa fa-square fa-3x"></i></a>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3">
                      <div id="shape-slider"></div>
                      <input type="hidden" value="0" id="shape-slider-value" />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="columns medium-24">
              <table  width="100%">
                <thead>
                  <tr>
                    <th>Capas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <ul id="layers" class="no-bullet"></ul>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="columns medium-24">
              <table  width="100%">
                <thead>
                  <tr>
                    <th>Extras</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="row">
                        <div class="small-1 columns ">
                          <input type="checkbox" class="options-setbgcolor" id="color_background" />
                        </div>
                        <div class="small-16 columns end">
                          <label for="color_background"> Permitir color de fondo</label>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
 
        </div>
      </div>
    </div>
    <input type="hidden" id="design-view-number" value="<?php echo $number; ?>" />
    <div class="text-center">      
      <button type="button" onclick="dgUI.product.save('<?php echo $position; ?>', '<?php echo $title; ?>')">Guardar</button>
      <button type="button" onclick="$('#ajax-modal').foundation('reveal', 'close');">Cancelar</button>           
    </div>
  </div>
</div>
<a class="close-reveal-modal" aria-label="Close">&#215;</a>