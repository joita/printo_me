<h2 class="seccionador show-for-medium text-left" style="color: #025573;font-weight: bold">Puntos Printome</h2>

<div class="row small-collapse medium-uncollapse">
    <!--contenedor de barra e imagen tamaños grande y mediano-->
    <div class="small-18 columns hide-for-small-only">
        <div class="row collapse" id="contenedor_niveles" data-equalizer="niveles" data-equalize-by-row="true">
            <div class="large-2 medium-3 columns hide-for-small-only" id="logo_nivel" data-equalizer-watch="niveles">
                <img style="height: auto;" src="<?php echo $imagen;?>"/>
            </div>
            <div class="large-16 medium-15 small-18 columns large-push-2 medium-push-3" id="barra_experiencia" data-equalizer-watch="niveles">
                <div class="row collapse" id="texto-puntos">
                    <div class="large-8 medium-7 small-9 columns">
                        <i class="fa fa-bar-chart-o"></i>: <b><?php echo $experiencia_actual?> / <?php echo $experiencia_meta?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trophy"></i>:&nbsp;<b><?php echo$puntos?></b>
                    </div>
                    <div class="large-8 medium-7 small-9 columns" style="text-align: right;">
                        <b><?php echo $experiencia_faltante;?></b> para el siguiente nivel.
                    </div>
                </div>
                <div class="row">
                    <div class="progress [radius round]" role="progressbar" tabindex="0" aria-valuenow="50" aria-valuemin="0" aria-valuetext="50 percent" aria-valuemax="100">
                        <div class="progress-meter" style="width: <?php echo $porcentaje_experiencia?>%"></div>
                        <p class="progress-meter-text"><i class="fa fa-arrow-up"></i></p>
                    </div>
                </div>
                <div class="row collapse" id="texto-niveles">
                    <div class="large-8 medium-7 small-9 columns">Nivel Actual: <b><?php echo $nombre_nivel?></b></div>
                    <?php if($siguiente_nivel != 'max'):?>
                        <div class="large-8 medium-7 small-9 columns" style="text-align: right;">Siguiente Nivel: <b><?php echo $siguiente_nivel->nombre_nivel;?></b></div>
                    <?php else:?>
                        <div class="large-10 medium-8 small-10 columns" style="text-align: right;">Has llegado al nivel máximo!</div>
                    <br>
                        <div class="text-center callout secondary">
                            Comparte tu cúpon para seguir manteniendo el nivel máximo.
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <hr class="dashed" style="border: 1px solid #025573"/>
    </div>
    <!--contenedor de barra e imagen tamaño chico-->
    <div class="small-18 show-for-small-only columns">
        <div class="row collapse" id="contenedor_niveles">
            <div class="row">
                <div class="small-6 small-push-6 columns" id="logo_nivel">
                    <img style="height: auto;" src="<?php echo $imagen;?>"/>
                </div>
            </div>
            <div class="row" data-equalizer="barra-chico">
                <div class="small-18 columns" id="barra_experiencia_chica" data-equalizer-watch="barra-chico">
                    <div class="row collapse" id="texto-puntos">
                        <div class="small-9 columns">
                            <i class="fa fa-bar-chart-o"></i>: <b><?php echo $experiencia_actual?> / <?php echo $experiencia_meta?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trophy"></i>:&nbsp;<b><?php echo$puntos?></b>
                        </div>
                        <div class="small-9 columns" style="text-align: right;">
                            <b><?php echo $experiencia_faltante;?></b> para el siguiente nivel.
                        </div>
                    </div>
                    <div class="row">
                        <div class="progress [radius round]" role="progressbar" tabindex="0" aria-valuenow="50" aria-valuemin="0" aria-valuetext="50 percent" aria-valuemax="100">
                            <div class="progress-meter" style="width: <?php echo $porcentaje_experiencia?>%"></div>
                            <p class="progress-meter-text"><i class="fa fa-arrow-up"></i></p>
                        </div>
                    </div>
                    <div class="row collapse" id="texto-niveles">
                        <div class="small-10 columns">Nivel Actual: <b><?php echo $nombre_nivel?></b></div>
                        <?php if($siguiente_nivel != 'max'):?>
                            <div class="small-8 columns" style="text-align: right;">Siguiente Nivel: <b><?php echo $siguiente_nivel->nombre_nivel;?></b></div>
                        <?php else:?>
                            <div class="small-8 columns" style="text-align: right;">Nivel máximo!</div>
                        <br>
                            <div class="callout secondary">
                                Comparte tu cúpon para seguir manteniendo el nivel máximo.
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
        <hr class="dashed" />
    </div>
    <!--contenedor callout cupon-->
    <div id="contenedor_cupon" class="small-18 columns">

        <div class="callout success">
            Recuerda compartir tu cúpon <b><?php echo $cupon?></b> para poder subir de nivel y obtener más recompensas. Este cupón es de uso exclusivo para tus clientes.
        </div>
        <hr class="dashed" style="border: 1px solid #025573"/>
    </div>
    <!--contenedor tabla referencias-->
    <div class="small-18 columns">
        <div class="row">
            <div id="contenedor_referencias">
                <?php if(sizeof($referencias) > 0): ?>
                    <table id="referencias" class="referencias-cuenta nowrap" style="width:100%;">
                        <thead>
                        <tr>
                            <th class="text-center" id="fecha">Fecha</th>
                            <th class="text-center" id="experiencia">Experiencia</th>
                            <th class="text-center" id="puntos">Puntos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!--GENERADO POR SERVERSIDE DATATABLES-->
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="form-cuenta text-center">
                        <p>No has recibido referencias.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>