<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Wow winners</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tabs" data-tab role="tablist">
            <li class="tab-title active" role="presentation"><a id="panelprincipal" href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1">Campañas</a></li>
            <li class="tab-title" role="presentation"><a id="panelwow" href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2">Seleccionados</a></li>
        </ul>
        <div class="tabs-content">
            <section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
                <div id="table-tienda">
                    <div class="row">
                        <div class="small-24 columns">
                            <table id="wow" class="listis hover stripe cell-border order-column" style="width:100%">
                                <thead>
                                <tr>
                                    <th >Folio</th>
                                    <th >Campaña</th>
                                    <th >Logo</th>
                                    <th >Playera</th>
                                    <th>Tienda</th>
                                    <th>Creador</th>
                                    <th >Winner</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!--Generado por serverside Data Tables-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section role="tabpanel" aria-hidden="true" class="content" id="panel2-2">
                <div id="wow_list" class="list-group">
                    <?php foreach($campanas as $campana):?>
                        <div id="slide_item" class="list-group-item" data-eqalizer data-id_enhance="<?php echo $campana->id_enhance?>">
                            <div class="row collapse" data-equalizer>
                                <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>
                                    <i class="fa fa-arrows "></i>
                                </div>
                                <div class="small-4 columns" data-equalizer-watch>
                                    <img src="<?php echo site_url($campana->front_image);?>" >
                                </div>
                                <div class="small-15 columns tienda" id="datos_foto" data-equalizer-watch>
                                    <b>Nombre tienda:</b> <?php echo $campana->nombre_tienda;?><br/>
                                    <b>Nombre playera:</b> <?php echo $campana->name;?> </br/>
                                    <b>Creador:</b> <?php echo $campana->cliente;?> </br/>
                                    <b>Texto:</b> <?php echo $campana->texto_wow;?> </br/>
                                </div>
                                <div class="small-4 columns " data-equalizer-watch data-texto_wow="<?php echo $campana->texto_wow?>" data-id_enhance ="<?php echo $campana->id_enhance?>">
                                    <a href="#" class="edit-enhance" ><i class="fa fa-edit"></i> Editar</i></a></br>
                                    <?php if($campana->wow_winner == 1): ?>
                                        <a data-id_enhance="<?php echo $campana->id_enhance?>" id="fa" class="seleccionados enabled"><i class="fa fa-toggle-on"></i> Habilitado</a></br/>
                                    <?php else: ?>
                                        <a data-id_enhance="<?php echo $campana->id_enhance?>" id="fa"  class="seleccionados disabled"><i class="fa fa-toggle-off"></i> Deshabilitado</a></br/>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>


                </div>
            </section>
        </div>
    </div>
</div>


<!--formulario para editar wow winner-->
<div class="reveal-modal small" id="editar_wow" data-reveal aria-hidden="true" style="position: fixed">

    <input type="hidden" value="" name="id_enhance" id="id-enhance">
    <div class="row">
        <div class="small-24 columns">
            <label>Texto (Máx 10 carácteres)
                <input type="text" maxlength="10"  name="texto_wow" id="editar-texto_wow" required/>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="small-24 columns text-center">
            <button id="guardar-texto-wow" type="submit">Confirmar</button>
        </div>
    </div>

</div>
