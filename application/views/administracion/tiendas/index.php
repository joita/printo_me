<div class="row">
    <div class="small-24 columns">
        <h2 class="section-title">Tiendas</h2>
    </div>
</div>
<div class="row">
    <div class="small-24 columns">
        <ul class="tabs tab-menu" data-tab role="tablist">
            <li><a class="tab-title active" role="tab" tabindex="0" aria-selected="true" aria-controls="tiendas" href="#tiendas"><i class="fa fa-building-o"></i> Listado</a></li>
            <li><a class="tab-title " id="tab-vip" role="tab" tabindex="0" aria-selected="true" aria-controls="vip" href="#vip"><i class="fa fa-building-o"></i> Vip</a></li>
        </ul>
    </div>
</div>
<div class="row tabs-content">
    <div class="small-24 columns content active" role="tabpanel" aria-hidden="false" id="tiendas"">
    <div id="table-tienda">
        <div class="row">
            <div class="small-24 columns">
                <table id="campanas" class="listis hover stripe cell-border order-column" style="width:100%">
                    <thead>
                    <tr>
                        <th style="width:5%">ID</th>
                        <th style="width:8%">Logo</th>
                        <th>Datos tienda</th>
                        <th>Propietario</th>
                        <th style="width:5%">Productos</th>
                        <th >VIP</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--Generado por serverside Data Tables-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--Sección vip-->
<div class="small-24 columns content" role="tabpanel" aria-hidden="true" id="vip">

    <div id="tiendas_list" class="list-group">
        <?php foreach($tiendas as $tienda):?>
            <div id="slide_item" class="list-group-item" data-eqalizer data-id_tienda="<?php echo $tienda->id_tienda?>">
                <div class="row collapse" data-equalizer>
                    <div class="small-1 columns list_handle text-center" id="grabber" data-equalizer-watch>
                        <i class="fa fa-arrows "></i>
                    </div>
                    <div class="small-4 columns" id="logotienda" data-equalizer-watch>
                        <img src="<?php echo site_url('assets/images/logos/'.$tienda->logotipo_mediano);?>" >
                    </div>
                    <div class="small-19 columns tienda" id="datos_foto" data-equalizer-watch>
                        <b>Nombre tienda:</b> <?php echo $tienda->nombre_tienda;?><br/>
                        <b>Creador:</b> <?php echo $tienda->cliente;?> </br/>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>

</div>
<!--Fin sección vip-->
</div>