<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Mi Tienda</h2>
<br>
<div class="row">
	<div class="small-18 medium-18 large-24 xlarge-24 columns">
		<div class="row">
			<div class="small-18 columns">
				<form method="post" action="<?php echo site_url('mi-cuenta/tienda/actualizar'); ?>" class="form-cuenta" enctype="multipart/form-data" data-abide style="border: none">

					<?php if($this->session->flashdata('update_datos') == 'ok'): ?>
					<div class="small success callout">
						<p><i class="fa fa-check"></i> Cambios guardados</p>
					</div>
					<?php endif; ?>
                    <div class="row">
                        <div class="columns small-24 medium-24 large-24 xlarge-24 text-center">
                                <div class="small-24 columns">
                                    <label  class="titulo-tienda">Información general
                                    </label>
                                </div>
                                <div class="columns small-24 medium-24 large-18 xlarge-18 ">
                                    <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">URL Tienda (solo lectura)
                                        <code style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" id="urlti">
                                            <a href="<?php echo site_url('tienda/1/'.$this->tienda->nombre_tienda_slug); ?>" target="_blank"><?php echo site_url('tienda/1/'.$this->tienda->nombre_tienda_slug); ?></a>
                                        </code>
                                    </label>
                                </div>
                                <div class="columns small-18 medium-18 large-9 xlarge-9">
                                    <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Nombre de la tienda
                                        <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="nombre_tienda" value="<?php echo $this->tienda->nombre_tienda; ?>" required>
                                        <small class="form-error">Campo obligatorio.</small>
                                    </label>
                                </div>
                                <div class="columns small-18 medium-18 large-9 xlarge-9 ">
                                    <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Descripción breve
                                        <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="descripcion_tienda" value="<?php echo $this->tienda->descripcion_tienda; ?>" required>
                                        <small class="form-error">Campo obligatorio.</small>
                                    </label>
                                </div>
                                <div class="columns small-18 medium-18 large-9 xlarge-9 slide-img">

                                    <div class="row">
                                        <div class="small-18 columns ">
                                            <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Logotipo actual</label>
                                            <div class="cont-img">
                                                <?php if($this->tienda->logotipo_chico != ''): ?>
                                                    <img  src="<?php echo site_url('assets/images/logos/'.$this->tienda->logotipo_chico); ?>" alt="" />
                                                <?php else: ?>
                                                    <img  src="<?php echo site_url('assets/images/sin-imagen.jpg'); ?>" alt="" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="small-18 columns">
                                            <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">
                                                <input style="box-shadow: none;border: 2px solid #94D50A;border-radius: 10px; text-align: center; padding: 0.5rem; color: #94D50A" type="file" name="logo" id="logo_file" >
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="columns small-18 medium-18 large-9 xlarge-9 slide-img">

                                    <div class="row">
                                        <div class="small-18 columns ">
                                            <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Acerca de</label>
                                            <div class="cont-img">
                                                <?php if($this->tienda->imagen_acercade != ''): ?>
                                                    <img  src="<?php echo site_url('assets/images/acercade/'.$this->tienda->imagen_acercade); ?>" alt="" />
                                                <?php else: ?>
                                                    <img  src="<?php echo site_url('assets/images/sin-imagen.jpg'); ?>" alt="" />
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="small-18 columns">
                                            <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">
                                                <input style="box-shadow: none;border: 2px solid #94D50A;border-radius: 10px; text-align: center; padding: 0.5rem; color: #94D50A" type="file" name="acercade" id="acercade_file" >
                                            </label>
                                        </div>

                                    </div>
                                </div>


                        </div>

                        <div class="columns small-24 text-center" id="tiendaRedes">
                            <div class="small-24 columns">
                                <label  class="titulo-tienda">Redes sociales
                                </label>
                            </div>
                            <div class="small-24 medium-9 large-9 xlarge-9 slide-img columns">
                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Facebook <i class="fa fa-facebook"></i>
                                    <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="facebook_tienda" value="<?php echo $this->tienda->facebook; ?>" >

                                </label>
                            </div>
                            <div class="small-24 medium-9 large-9 xlarge-9 slide-img columns">
                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Twitter <i class="fa fa-twitter"></i>
                                    <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="twitter_tienda" value="<?php echo $this->tienda->twitter; ?>" >

                                </label>
                            </div>
                            <div class="small-24 medium-9 large-9 xlarge-9 slide-img columns">
                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Instagram <i class="fa fa-instagram"></i>
                                    <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="instagram_tienda" value="<?php echo $this->tienda->instagram; ?>" >

                                </label>
                            </div>
                            <div class="small-24 medium-9 large-9 xlarge-9 slide-img columns">
                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Youtube <i class="fa fa-youtube"></i>
                                    <input style="box-shadow: none;border: 2px solid #025573;border-radius: 10px; text-align: center" type="text" name="youtube_tienda" value="<?php echo $this->tienda->youtube; ?>" >

                                </label>
                            </div>
                        </div>
                        <div class="columns small-24 text-center" id="tiendaSlider">
                            <div class="small-24 columns">
                                <label class="titulo-tienda">Sliders
                                </label>
                            </div>
                            <div class="small-24 medium-6 large-6 xlarge-6 slide-img columns">

                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Slider 1</label>
                                <?php if($this->tienda->slider_uno_chico != ''): ?>
                                    <div class="cont-btn columns">
                                        <a  class="eliminar-btn button" data-slideval="1" id="eliminar-slideruno"><i class="fa fa-times"></i></a>
                                        <input  type="hidden" name="id_slideuno" id="id_slide_uno"  value="0">

                                    </div>
                                    <div class="cont-img" id="img-uno">
                                        <img  src="<?php echo site_url('assets/images/slider_clientes/'.$this->tienda->slider_uno_chico); ?>" alt="" />
                                    </div>
                                <?php else: ?>
                                    <div class="cont-img sin-img" id="img-uno">

                                    </div>

                                <?php endif; ?>

                                    <input style="box-shadow: none;border: 2px solid #94D50A;border-radius: 10px; text-align: center; padding: 0.5rem; color: #94D50A" type="file" name="slideruno" id="slider_uno" >

                            </div>
                            <div class="small-6 slide-img columns">
                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Slider 2</label>
                                <?php if($this->tienda->slider_dos_chico != ''): ?>
                                    <div class="cont-btn columns">
                                        <a  class="eliminar-btn button" data-slideval="2" id="eliminar-sliderdos"><i class="fa fa-times"></i></a>
                                        <input  type="hidden" name="id_slidedos" id="id_slide_dos"  value="0">
                                    </div>
                                    <div class="cont-img" id="img-dos">
                                        <img src="<?php echo site_url('assets/images/slider_clientes/'.$this->tienda->slider_dos_chico); ?>" alt="" />
                                    </div>
                                <?php else: ?>
                                    <div class="cont-img sin-img" id="img-dos">

                                    </div>
                                <?php endif; ?>

                                    <input style="box-shadow: none;border: 2px solid #94D50A;border-radius: 10px; text-align: center; padding: 0.5rem; color: #94D50A" type="file" name="sliderdos" id="slider_dos" >

                            </div>
                            <div class="small-6 slide-img columns">
                                <label style="color: #FF4D00; font-weight: bold; font-size: 1rem">Slider 3</label>
                                <?php if($this->tienda->slider_tres_chico != ''): ?>
                                    <div class="cont-btn columns">
                                        <a  class="eliminar-btn button" data-slideval="3" id="eliminar-slidertres"><i class="fa fa-times"></i></a>
                                        <input  type="hidden" name="id_slidetres" id="id_slide_tres"  value="0">
                                    </div>
                                    <div class="cont-img" id="img-tres">

                                        <img  src="<?php echo site_url('assets/images/slider_clientes/'.$this->tienda->slider_tres_chico); ?>" alt="" />
                                    </div>
                                <?php else: ?>
                                    <div class="cont-img sin-img" id="img-tres">

                                    </div>

                                <?php endif; ?>

                                    <input style="box-shadow: none;border: 2px solid #94D50A;border-radius: 10px; text-align: center; padding: 0.5rem; color: #94D50A" type="file" name="slidertres" id="slider_tres" >

                            </div>
                        </div>
                        <div class="columns small-24 botones-cuenta">
                            <div class="small-24 columns text-center">
                                <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $this->session->login['id_cliente']; ?>">
                                <button style="background: #F2560D; padding: 1rem 2rem; border-radius: 10px " type="submit" class="guardar button"><i class="fa fa-save"></i> Guardar Cambios</button>
                            </div>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
