<div class="row">
	<div class="small-24 columns">
		<h2 class="section-title">Testimonios</h2>
	</div>
</div>
<div class="row">
	<div class="small-24 columns">
        <table id="campanas" class="hover stripe cell-border order-column">
            <thead>
                <tr>
                    <th width="5"></th>
                    <th width="20">ID</th>
                    <th width="500">Testimonio</th>
                    <th width="50">Rating</th>
                    <th width="60">Fecha</th>
                    <th width="60">Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($testimonios as $testimonio): ?>
                <tr>
                    <td class="text-center">
                    <?php if($testimonio->estatus == 0): ?>
                        <i class="fa fa-circle-o-notch fa-spin fa-fw" style="color:orange;"></i>
                    <?php elseif($testimonio->estatus == 1): ?>
                        <i class="fa fa-circle" style="color:green"></i></td>
                    <?php endif; ?>
                    <td class="text-center">
                        <?php echo $testimonio->id_calificacion; ?>
                    </td>
                    <td>
                        <p style="font-size:0.9rem;margin-bottom:0.4rem;"><b>Comentario:</b> <?php echo $testimonio->comentario; ?></p>
                        <p style="font-size:0.9rem;margin-bottom:0.4rem;"><b>Nombre:</b> <?php echo $testimonio->nombre; ?></p>
                        <p style="font-size:0.9rem;margin-bottom:0;"><b>Correo:</b> <?php echo $testimonio->email; ?></p>
                    </td>
                    <td class="text-center"><strong><?php echo $testimonio->monto_calificacion; ?></strong></td>
                    <td><?php echo date("Y-m-d", strtotime($testimonio->fecha_calificacion)); ?></td>
                    <td><?php echo ($testimonio->estatus == 0 ? 'Pendiente' : 'Activo'); ?></td>
                    <td>
                        <?php if($testimonio->estatus == 0): ?>
                            <a href="<?php echo site_url('administracion/testimonios/aprobar/'.$testimonio->id_calificacion); ?>" class="success action button">Aprobar</a>
                        <?php else: ?>
                            <a href="<?php echo site_url('administracion/testimonios/desaprobar/'.$testimonio->id_calificacion); ?>" class="alert action button">Desaprobar</a>
                        <?php endif; ?>
                        <a href="<?php echo site_url('administracion/testimonios/borrar/'.$testimonio->id_calificacion); ?>" class="warning action button">Borrar</a>
                        <a href="<?php echo site_url('administracion/testimonios/responder/'.$testimonio->id_calificacion); ?>" class="primary action button">Responder</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
	</div>
</div>
