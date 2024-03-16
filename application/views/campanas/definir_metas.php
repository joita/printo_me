<div class="pscat fgc">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <?php if($this->session->has_userdata('login')): ?>
            <form action="<?php echo site_url('vende/guardar'); ?>" id="enhance_save" method="post" data-abide novalidate>
                <?php endif; ?>
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="row">
                            <div class="col-md-12 columns text-center medium-text-left">
                                <h4 class="filtrador text-center medium-text-left"><a href="<?php echo site_url('personalizar/'.$this->session->diseno_temp['product_id'].'/'.$this->session->diseno_temp['id_color']); ?>"><i class="fa fa-chevron-left"></i> Regresar a diseño</a></h4>
                            </div>
                        </div>
                        <div class="row  thumbis-definir">
                            <?php foreach ($enhance->diseno->images as $key => $side): ?>
                                <div class="col-md-3">
                                    <div class="lado-container">
                                        <img src="<?php echo site_url($side); ?>" alt="Vista previa de la playera">
                                        <span class="lado"><?php if ($key == "front"): ?>Frente<?php endif ?>
                                            <?php if ($key == "back"): ?>Atrás<?php endif ?>
                                            <?php if ($key == "right"): ?>Manga derecha<?php endif ?>
                                            <?php if ($key == "left"): ?>Manga izquierda<?php endif ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if($enhance->diseno->color != 'FFFFFF' && $enhance->diseno->color != 'A8A4A4' && !$enhance->esBlanca): ?>
                            <div class="row" id="area-otros-colores">
                                <div class="small-18 columns">
                                    <div class="row">
                                        <div class="small-18 columns">
                                            <p class="text-center">¿Quieres vender tu producto en varios colores? Selecciona los colores que combinen con tu diseño:</p>
                                            <div class="row">
                                                <div class="small-18 columns" id="columnas-otros">
                                                    <div id="area-otros-colores-interna">
                                                        <span>Colores disponibles</span>
                                                        <?php foreach($otros_colores as $otro_color): ?>
                                                            <span class="otro-color-interno"><a data-color-adder data-id_color="<?php echo $otro_color->id_color; ?>" data-id_producto="<?php echo $enhance->id_producto; ?>"<?php if($this->session->has_userdata('enhances_adicionales')) { activar_color_adicional($this->session->enhances_adicionales, $otro_color->id_color, 'a'); } ?>><i class="fa fa<?php if($this->session->has_userdata('enhances_adicionales')) { activar_color_adicional($this->session->enhances_adicionales, $otro_color->id_color, 'i'); } ?>-square" style="color:<?php echo $otro_color->codigo_color; ?>"></i></a></span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="loading" style="display:none;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="area-otros-colores-variable">
                                        <?php if($this->session->has_userdata('enhances_adicionales')): ?>
                                            <?php foreach($this->session->enhances_adicionales as $enhance_adicional): ?>
                                                <div class="row small-up-4 medium-up-2 large-up-4 xlarge-up-4 thumbis-definir" data-fila-id_color="<?php echo $enhance_adicional->id_color; ?>">
                                                    <?php foreach ($enhance->diseno->images as $key => $side): ?>
                                                        <?php if($key == 'front') {
                                                            $image = $enhance_adicional->front_image;
                                                            $titulo = 'Frente';
                                                        } else if($key == 'back') {
                                                            $image = $enhance_adicional->back_image;
                                                            $titulo = 'Atrás';
                                                        } else if($key == 'right') {
                                                            $image = $enhance_adicional->right_image;
                                                            $titulo = 'Manga derecha';
                                                        } else if($key == 'left') {
                                                            $image = $enhance_adicional->left_image;
                                                            $titulo = 'Manga izquierda';
                                                        } ?>
                                                        <div class="column">
                                                            <div class="lado-container">
                                                                <img src="<?php echo site_url($image); ?>" alt="Vista previa de la playera">
                                                                <span class="lado"><?php echo $titulo; ?></span>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <div class="fbc" id="area-venta">
                            <?php if (!$this->session->has_userdata('login')): ?>
                                <h4 class="filtrador"><i class="fa fa-sliders"></i> Registra tus datos</h4>
                                <div class="datos-campana-container">

                                    <ul class="tabs" data-tabs id="opciones">
                                        <li class="tabs-title is-active"><a href="#camp_inic_sesion" aria-selected="true">Iniciar sesión</a></li>
                                        <li class="tabs-title"><a href="#camp_registro">Registrarse</a></li>
                                    </ul>

                                    <div class="tabs-content" id="opciones_content" data-tabs-content="opciones">
                                        <div class="tabs-panel is-active" id="camp_inic_sesion">
                                            <form id="campana_login_form" data-abide="ajax" novalidate>
                                                <div class="row fbb">
                                                    <div class="col-md-12 text-center">
                                                        <a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Inicia sesión con Facebook</a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6 class="form-title text-center hsep">o inicia sesión con correo electrónico</h6>
                                                    </div>
                                                </div>

                                                <div class="row ">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-label"><i class="fa fa-user"></i></span><input type="email" name="email_cliente" id="camp_email_cliente_login" required placeholder="Correo electrónico">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row collapse">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-label"><i class="fa fa-lock"></i></span><input type="password"  name="password_cliente" id="camp_password_cliente_login" required pattern="^.{6,}$" placeholder="Contraseña">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="alert radius callout" id="camp_mensaje_inicio_sesion" style="display:none;">
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row  add-buttons">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="primary expanded button" id="camp_login_button">Iniciar sesión</button>
                                                    </div>
                                                </div>

                                                <div class="row  add-buttons olvide">
                                                    <div class="col-md-12 text-center">
                                                        <a href="#" data-open="forgot" class="olvidecontra">Olvidé mi contraseña.</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tabs-panel" id="camp_registro">
                                            <form id="campana_register_form" data-abide="ajax" novalidate>
                                                <div class="row fbb">
                                                    <div class="col-md-12 text-center">
                                                        <a class="expanded button btnlog radius fbbut fbloginbutton"><i class="fa fa-facebook-square"></i> Regístrate con Facebook</a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <h6 class="form-title text-center">o regístrate con tu correo electrónico</h6>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <label>Nombre(s)
                                                            <input type="text" name="nombre_nuevo" id="campana_nombre_nuevo" value="<?php echo $enhance->usuario->nombres; ?>" required>
                                                            <small class="form-error">Campo requerido.</small>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12 ">
                                                        <label>Apellido(s)
                                                            <input type="text" name="apellido_nuevo" id="campana_apellido_nuevo" value="<?php echo $enhance->usuario->apellidos; ?>" required>
                                                            <small class="form-error">Campo requerido.</small>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Correo electrónico
                                                            <input type="email" name="email_nuevo" id="campana_email_nuevo" value="<?php echo $enhance->usuario->email; ?>" required>
                                                            <small class="form-error">Campo requerido.</small>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>Teléfono
                                                            <input type="text" name="telefono_nuevo" id="campana_telefono_nuevo" required>
                                                            <span class="form-error">Campo requerido.</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Fecha de nacimiento
                                                            <input type="date" name="cumple_nuevo" id="campana_cumple_nuevo" value="<?php echo $enhance->usuario->fecha_de_nacimiento; ?>" required>
                                                            <small class="form-error">Campo requerido.</small>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>Genero
                                                            <select name="genero_nuevo" id="campana_genero_nuevo" required>
                                                                <option value=""></option>
                                                                <option value="M"<?php if($enhance->usuario->genero == 'M') { echo ' selected'; } ?>>Masculino</option>
                                                                <option value="F"<?php if($enhance->usuario->genero == 'F') { echo ' selected'; } ?>>Femenino</option>
                                                                <option value="X"<?php if($enhance->usuario->genero == 'X') { echo ' selected'; } ?>>Prefiero no decir</option>
                                                            </select>
                                                            <small class="form-error">Campo requerido.</small>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Contraseña
                                                            <input type="password" name="password_nuevo" id="campana_password_nuevo" required pattern="^.{6,}$">
                                                            <small class="form-error">Campo requerido <br />(mínimo 6 caracteres).</small>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label>Repetir Contraseña
                                                            <input type="password" name="repetir_password_nuevo" id="campana_password_nuevo_repetir" data-equalto="campana_password_nuevo" required>
                                                            <small class="form-error">Campo requerido.</small>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="alert radius callout" id="campana_mensaje_registro" style="display:none;">
                                                            <div></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row add-buttons">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="primary expanded button" id="campana_register_button">Registrarme</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif(!$this->session->has_userdata('info_pago') || $this->session->userdata('info_pago') == false): ?>
                                <h4 class="filtrador"><i class="fa fa-money"></i> Registra tus datos de Depósito</h4>
                                <div class="datos-campana-container">
                                    <div class="tabs-content" id="opciones_content" data-tabs-content="opciones">
                                        <div class="tabs-panel is-active" id="camp_datos_pago">
                                            <form id="campana_pagos_form" data-abide="ajax" novalidate>
                                                <div class="row ">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <span class="input-group-label"><i class="fa fa-bank"></i></span><select id="select_pagos">
                                                                <option value="none" selected>Seleccione Tipo de Cuenta</option>
                                                                <option value="PayPal">PayPal</option>
                                                                <option value="Banco">Cuenta de Banco</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="contenedor_paypal" style="display: none;">
                                                    <label>Correo electrónico Asociado a PayPal
                                                        <input type="email" name="email_paypal" id="campana_email_paypal" value="<?php echo $enhance->usuario->email; ?>">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="alert radius callout campana_mensaje_deposito" style="display:none;">
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="alert radius callout mensaje-verificar">
                                                                <div>Verifica que tus datos sean correctos ya que en caso de que tus productos generen ganancias, usaremos esos mismos datos para depositarlas.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row  add-buttons">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="primary expanded button boton_datos_bancarios" id="campana_register_paypal">Registrar PayPal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="contenedor_banco" style="display: none;">
                                                    <label>Nombre del Cuentahabiente
                                                        <input type="text" name="nombre_cuentahabiente" id="nombre_cuentahabiente" value="<?php echo $enhance->usuario->nombre; ?>">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>
                                                    <label>Nombre del Banco
                                                        <input type="text" name="nombre_banco" id="nombre_banco">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>
                                                    <label>CLABE Interbancaria
                                                        <input type="text" name="clabe_interbancaria" id="clabe_interbancaria">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>
                                                    <label>Cuenta de Banco
                                                        <input type="text" name="cuenta_banco" id="cuenta_banco">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>
                                                    <label>Ciudad
                                                        <input type="text" name="ciudad" id="ciudad">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>
                                                    <label>Sucursal
                                                        <input type="text" name="sucursal" id="sucursal">
                                                        <small class="form-error">Campo requerido.</small>
                                                    </label>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="alert radius callout campana_mensaje_deposito" style="display:none;">
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="alert radius callout mensaje-verificar">
                                                                <div>Verifica que tus datos sean correctos ya que en caso de que tus productos generen ganancias, usaremos esos mismos datos para depositarlas.</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row add-buttons">
                                                        <div class="col-md-12">
                                                            <button type="submit" class="primary expanded button boton_datos_bancarios" id="campana_register_banco">Registrar Cuenta Bancaria</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="id_cliente" value="<?php echo $this->session->login['id_cliente'];?>">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                            <h4 class="filtrador" style="color: #EE4500; border-bottom: 2px solid #025573 "><i class="fa fa-sliders"></i> Define tus metas <a id="tut_camp" title="Mostrar tutorial"><i class="fa fa-info-circle"></i></a></h4>
                            <div class="datos-campana-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span id="charNombre"></span>
                                        <div class="input-group" id="wt-grupo-nombre" style="color: #EE4500; border: 2px solid #025573; border-radius: 10px ">
                                            <span style="border-radius: 10px" class="input-group-label"><i class="fa fa-bolt"></i></span><input style="color: #EE4500; border-radius: 10px " type="text" value="<?php echo $enhance->custom->name; ?>" onkeyup="countNombre(this);" name="name" id="design_name" required placeholder="Nombre de tu diseño"<?php if($this->input->get('error')) { echo ' class="is-invalid-input"'; } ?> required>
                                        </div>
                                        <small class="form-error text-center"<?php if($this->input->get('error')) { echo ' style="display:block;"'; } ?>>Campo requerido.</small>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <span id="charTotal"></span>
                                        <div class="input-group" id="wt-grupo-descripcion" style="color: #EE4500; border: 2px solid #025573; border-radius: 10px ">
                                            <span style="border-radius: 10px" class="input-group-label"><i class="fa fa-commenting-o"></i></span>
                                            <textarea style="color: #EE4500; border-radius: 10px " id="descripcion_campana" name="descripcion" rows="4" required pattern="^(.|\s){50,}$" placeholder="Describe tu producto en al menos 50 caracteres." onkeyup="countChar(this);"<?php if($this->input->get('error')) { echo ' class="is-invalid-input"'; } ?>><?php echo $enhance->custom->description; ?></textarea>
                                        </div>
                                        <span id="charNum"<?php if($this->input->get('error')) { echo ' class="moved"'; } ?>><?php $len = strlen($enhance->custom->description); if($len < 50) { echo '<span style="color:red">'.$len.'</span>'; } else { echo '<span style="color:green">'.$len.'</span>'; } ?></span>
                                        <small class="form-error text-center"<?php if($this->input->get('error')) { echo ' style="display:block;"'; } ?>>Campo requerido.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group" id="wt-grupo-etiquetas" style="color: #EE4500; border: 2px solid #025573; border-radius: 10px ">
                                            <span style="border-radius: 10px" class="input-group-label"><i class="fa fa-tags"></i></span><input style="color: #EE4500; border-radius: 10px " type="text" id="etiquetas_campana" name="etiquetas" required placeholder="Etiquetas descriptivas"<?php if($this->input->get('error')) { echo ' class="is-invalid-input"'; } ?> value="<?php echo $enhance->custom->etiquetas; ?>">
                                        </div>
                                        <small class="form-error text-center"<?php if($this->input->get('error')) { echo ' style="display:block;"'; } ?>>Campo requerido.</small>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="input-group" id="wt-grupo-clasificacion" style="color: #EE4500; border: 2px solid #025573; border-radius: 10px ">
                                            <span style="border-radius: 10px" class="input-group-label"><i class="fa fa-star-o"></i></span>
                                            <select style="color: #EE4500; border-radius: 10px " id="id_clasificacion" name="id_clasificacion" title="Clasificación" required<?php if($this->input->get('error') && $enhance->custom->id_clasificacion == '') { echo ' class="is-invalid-input"'; } ?>>
                                                <option value="" selected disabled>Clasificación del producto</option>

                                                <?php foreach($clasificaciones as $clasificacion): ?>
                                                    <optgroup label="<?php echo $clasificacion->nombre_clasificacion; ?>">
                                                        <option value="<?php echo $clasificacion->id_clasificacion; ?>"<?php if(!$enhance->custom->id_subclasificacion) { if($clasificacion->id_clasificacion == $enhance->custom->id_clasificacion) { echo ' selected'; } } ?>>Temática General</option>
                                                        <?php if(sizeof($clasificacion->subclasificaciones) > 0): ?>
                                                            <?php foreach($clasificacion->subclasificaciones as $subclasificacion): ?>
                                                                <option value="<?php echo $clasificacion->id_clasificacion; ?>/<?php echo $subclasificacion->id_clasificacion; ?>"<?php if($enhance->custom->id_subclasificacion) { if($subclasificacion->id_clasificacion == $enhance->custom->id_subclasificacion) { echo ' selected'; } } ?>><?php echo $subclasificacion->nombre_clasificacion; ?></option>
                                                                <?php if(sizeof($subclasificacion->subsubclasificaciones)>0):?>
                                                                    <?php foreach($subclasificacion->subsubclasificaciones as $subsubclas): ?>
                                                                        <option value="<?php echo $clasificacion->id_clasificacion;?>/<?php echo $subclasificacion->id_clasificacion; ?>/<?php echo $subsubclas->id_clasificacion; ?>"<?php if($enhance->custom->id_subsubclasificacion) { if($subsubclas->id_clasificacion == $enhance->custom->id_subsubclasificacion) { echo ' selected'; } } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subsubclas->nombre_clasificacion; ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </optgroup>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <small class="form-error text-center"<?php if($this->input->get('error') && $enhance->custom->id_clasificacion == '') { echo ' style="display:block;"'; } ?>>Campo requerido.</small>
                                    </div>
                                </div>
                                <?php if($enhance->id_producto == 42):?>
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="input-group" style="color: #EE4500; border: 2px solid #025573; border-radius: 10px " >
                                                <span style="border-radius: 10px" class="input-group-label"><i>XS</i></span>
                                                <select style="color: #EE4500; border-radius: 10px " id="xs_stock" name="xs_stock" title="XS">
                                                    <option value="0" selected>0</option>
                                                    <?php for($i = 0; $i < 50; $i++):?>
                                                        <option value="<?php echo $i + 1?>"><?php echo $i + 1?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="input-group" >
                                                <span class="input-group-label"><i>S</i></span>
                                                <select id="s_stock" name="s_stock" title="S">
                                                    <option value="0" selected>0</option>
                                                    <?php for($i = 0; $i < 50; $i++):?>
                                                        <option value="<?php echo $i + 1?>"><?php echo $i + 1?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="input-group" >
                                                <span class="input-group-label"><i>M</i></span>
                                                <select id="m_stock" name="m_stock" title="M">
                                                    <option value="0" selected>0</option>
                                                    <?php for($i = 0; $i < 50; $i++):?>
                                                        <option value="<?php echo $i + 1?>"><?php echo $i + 1?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="input-group" >
                                                <span class="input-group-label"><i>L</i></span>
                                                <select id="l_stock" name="l_stock" title="L">
                                                    <option value="0" selected>0</option>
                                                    <?php for($i = 0; $i < 50; $i++):?>
                                                        <option value="<?php echo $i + 1?>"><?php echo $i + 1?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                            <div class="input-group" >
                                                <span class="input-group-label"><i>XL</i></span>
                                                <select id="xl_stock" name="xl_stock" title="XL">
                                                    <option value="0" selected>0</option>
                                                    <?php for($i = 0; $i < 50; $i++):?>
                                                        <option value="<?php echo $i + 1?>"><?php echo $i + 1?></option>
                                                    <?php endfor;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="input-group" id="wt-grupo-tipo" style="color: #EE4500; border: 2px solid #025573; border-radius: 10px ">
                                            <span style="border-radius: 10px " class="input-group-label"><i class="fa fa-bookmark-o"></i></span>
                                            <select style="color: #EE4500; border-radius: 10px " id="tipo_campana" name="tipo_campana" title="Tipo de producto">
                                                <option value="" selected disabled>Tipo del producto</option>
                                                <option value="limitado"<?php if($enhance->custom->type == 'limitado') { echo ' selected'; } ?>>Plazo definido</option>
                                                <option value="fijo"<?php if($enhance->custom->type == 'fijo') { echo ' selected'; } ?>>Venta</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="info-adicional-venta"<?php if(!$enhance->custom->type) { echo ' style="display:none;"'; } ?>>

                                    <div class="row" id="info-temporal"<?php if($enhance->custom->type == 'fijo') { echo ' style="display:none;"'; } ?>>
                                        <div class="col-md-6">
                                            <div style="color: #EE4500; border: 2px solid #025573; border-radius: 10px " class="input-group">
                                                <span style="border-radius: 10px " class="input-group-label"><i class="fa fa-line-chart"></i></span>
                                                <select style="color: #EE4500; border-radius: 10px " id="quantity" name="quantity" title="¿Cuántos productos vas a vender?">
                                                    <option value="1"<?php if($enhance->custom->quantity == "1") echo " selected" ?>>1</option>
                                                    <option value="5"<?php if($enhance->custom->quantity == "5") echo " selected" ?>>5</option>
                                                    <option value="10"<?php if($enhance->custom->quantity == "10") echo " selected" ?>>10</option>
                                                    <option value="20"<?php if($enhance->custom->quantity == "20") echo " selected" ?>>20</option>
                                                    <option value="50"<?php if($enhance->custom->quantity == "50") echo " selected" ?>>50</option>
                                                    <option value="75"<?php if($enhance->custom->quantity == "75") echo " selected" ?>>75</option>
                                                    <option value="100"<?php if($enhance->custom->quantity == "100") echo " selected" ?>>100</option>
                                                    <option value="150"<?php if($enhance->custom->quantity == "150") echo " selected" ?>>150</option>
                                                    <option value="200"<?php if($enhance->custom->quantity == "200") echo " selected" ?>>200</option>
                                                    <option value="250"<?php if($enhance->custom->quantity == "250") echo " selected" ?>>250</option>
                                                    <option value="500"<?php if($enhance->custom->quantity == "500") echo " selected" ?>>500</option>
                                                    <option value="1000"<?php if($enhance->custom->quantity == "1000") echo " selected" ?>>1,000</option>
                                                    <option value="1500"<?php if($enhance->custom->quantity == "1500") echo " selected" ?>>1,500</option>
                                                    <option value="2000"<?php if($enhance->custom->quantity == "2000") echo " selected" ?>>2,000</option>
                                                    <option value="2500"<?php if($enhance->custom->quantity == "2500") echo " selected" ?>>2,500</option>
                                                    <option value="3000"<?php if($enhance->custom->quantity == "3000") echo " selected" ?>>3,000</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="color: #EE4500; border: 2px solid #025573; border-radius: 10px " class="input-group">
                                                <span style="border-radius: 10px " class="input-group-label"><i class="fa fa-list-ol"></i></span>
                                                <select style="color: #EE4500; border-radius: 10px " id="dias" name="dias" title="¿Cuántos días se va a vender?">
                                                    <option value="7"<?php if($enhance->custom->days == "7") echo " selected" ?>>7 días</option>
                                                    <option value="14"<?php if($enhance->custom->days == "14") echo " selected" ?>>14 días</option>
                                                    <option value="21"<?php if($enhance->custom->days == "21") echo " selected" ?>>21 días</option>
                                                    <option value="28"<?php if($enhance->custom->days == "28") echo " selected" ?>>28 días</option>
                                                    <option value="9999"<?php if($enhance->custom->days == "9999") echo " selected" ?>>Indefinido</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 costcol">
                                            <label>Costo de la playera</label>
                                            <span class="pricey">$ -</span>
                                            <input type="hidden" name="costo" id="costo" value="" />
                                        </div>
                                        <div class="col-md-6  costcol">
                                            <label>Precio recomendado</label>
                                            <span class="pricey g" id="precio-recomendado">$ -</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6  small-centered costcol text-center">
                                            <label>Precio de venta</label>
                                            <div style="color: #EE4500; border: 2px solid #025573; border-radius: 10px " class="input-group">
                                                <span style="border-radius: 10px " class="input-group-label"><i class="fa fa-usd" style="height:2.25rem;line-height: 2.25rem;"></i></span>
                                                <input style="color: #EE4500; border-radius: 10px " type="text" id="costo_playera" class="input-group-field text-right" data-minlength="1" value="<?php echo $enhance->custom->price ?>" oninput="des_but()">
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="dashed" style="border-bottom: 2px solid #025573"/>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="text-center" id="gen">Ganancia estimada total neta</label>
                                            <span id="ganancia_contenedor">
												<span id="ganancia_display" class="text-center">$ -</span>
											</span>
                                            <small class="explicacion" id="exp_ganancia"></small>
                                            <small class="explicacion" style="color: #025573">La ganancia estimada neta está calculada según los lineamientos de printome.mx. Al generar esta venta de producto, confirmas que estás de acuerdo con los <a href="<?php echo site_url('terminos-y-condiciones'); ?>" target="_blank">términos y condiciones</a>.</small>
                                        </div>
                                    </div>
                                    <hr class="dashed" style="border-bottom: 2px solid #025573"/>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <input type="hidden" value="" id="precio_minimo" readonly>
                                            <input type="hidden" value="0" id="ganancia">
                                            <input type="hidden" name="costoplayera" value="<?php echo $enhance->custom->price ?>" id="costo_playera_hidden">
                                            <button type="submit" onClick="window.scrollTo(500,0)" style="transition: .1s"  class="btn btn-success button expanded enhance_now_button"><i class="fa fa-bolt"></i> Vender</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
        </div>
        <?php if($this->session->has_userdata('login')): ?>
            </form>
        <?php endif; ?>
    </div>
</div>
</div>

<div id="definir-metas-walkthrough" class="row hide">
    <div class="col-md-12">
        <div id="paso-2">
            <h1>¡Que tu producto siga hablando de ti!</h1>
            <p>Al concluir con la creación de tu producto, escoge un nombre que continúe reflejando tu originalidad.</p>
            <a class="no_quiero_tutorial_campana" data-mostrar="<?php if(isset($this->session->mostrar_tutorial_campana)) { if(!$this->session->mostrar_tutorial_campana) { ?>si<?php } else { ?>no<?php } } else { ?>no<?php } ?>"><i class="fa fa-<?php if(isset($this->session->mostrar_tutorial_campana)) { if(!$this->session->mostrar_tutorial_campana) { ?>check-<?php } else { ?><?php } } else { ?><?php } ?>square-o"></i> No volver a mostrar</a>
        </div>
        <div id="paso-3">
            <h1>¡Cuéntanos más!</h1>
            <p>Describe tu producto en al menos 50 caracteres para poder continuar con la venta.</p>
        </div>
        <div id="paso-4">
            <h1>¡Clasifícalo!</h1>
            <p>¡Decide el tipo de tu producto!</p>
        </div>
        <div id="paso-5">
            <h1>Plazo Definido</h1>
            <p>Tu diseño se enviará a producción después de cumplir las metas de tiempo y número de playeras que fijaste vender. Toma en cuenta que tus ganancias las obtendrás después de cumplir con tus metas establecidas.</p>
        </div>
        <div id="paso-6">
            <h1>Venta Inmediata</h1>
            <p>El producto estará disponible todo el tiempo, sin plazos y no es necesario que fijes una cantidad mínima de playeras para vender. Recibirás tus ganancias los viernes de cada mes y tus clientes solamente esperarán por el producto 10 días hábiles.</p>
        </div>
    </div>

</div>
