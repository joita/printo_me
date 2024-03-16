<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        <?php $this->load->view('carrito/estilos_pdf.css'); ?>
    </style>
</head>
<body>

<div id="header">
    <table>
        <tr>
            <td><img src="<?php echo APPPATH. '../public/assets/images/header-logo-retina.png'; ?>" alt="" height="70"></td>
            <td style="text-align: right;">
                <table id="info">
                    <tr>
                        <td>Reporte:</td>
                        <th>Pagos a Diseñadores</th>
                    </tr>
                    <tr>
                        <td>Fecha del reporte:</td>
                        <th><?php echo date("d/m/Y H:i:s"); ?></th>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>


<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
    <tr>
        <th width="36.2%" rowspan="2" style="vertical-align:bottom;">Datos del reporte</th>
        <th width="13%" class="text-center">Fecha inicio</th>
        <th width="12%" class="text-center">Fecha final</th>
        <th width="10%" class="text-center">Métodos de pago</th>
        <th width="10%" class="text-center">Tipo de campaña</th>
    </tr>
    <tr>
        <td width="13%" style="text-align:center;"><?php echo $fecha_inicio; ?></td>
        <td width="12%" style="text-align:center;"><?php echo $fecha_final; ?></td>
        <td width="10%" style="text-align:center;">
            <?php if($metodo_de_pago == 'todos') { echo 'Todos'; }
            else if($metodo_de_pago == 'paypal') { echo 'PayPal'; }
            else if($metodo_de_pago == 'banco') { echo 'Transferencia'; }
            ?>
        </td>
        <td width="10%" style="text-align:center;">
            <?php if($tipo_campana == 'todos') { echo 'Todos'; }
            else if($tipo_campana == 'fijo') { echo 'Venta Inmediata'; }
            else if($tipo_campana == 'limitado') { echo 'Plazo Definido'; }
            ?>
        </td>
    </tr>
</table>

<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
    <tr>
        <th width="31.4%" rowspan="2" style="vertical-align:bottom;">Información Pagos a Diseñadores</th>
        <th width="20%" class="text-center">No. Pagos</td>
        <th width="20%" class="text-center">Total Pagado</td>
        <th width="20%" class="text-center">Promedio de Pagos</td>
    </tr>
    <tr>
        <td width="20%" style="text-align:center;" class="text-center"><?php echo $reporte->numero_pagos; ?></td>
        <td width="20%" style="text-align:center;" class="text-center">$<?php echo number_format($reporte->total_pagos, 2, '.',','); ?></td>
        <td width="20%" style="text-align:center;" class="text-center">$<?php echo number_format($reporte->promedio_pagos, 2, '.', ','); ?></td>
    </tr>
</table>

<table cellpadding="0" cellspacing="0" class="tabla-pedidos" id="carrito" style="width:100%;">
    <thead>
    <tr>
        <th width="25%" class="text-center">Email Diseñador</th>
        <th width="25%" class="text-center">Fecha Pago</td>
        <th width="25%" class="text-center">Monto</td>
        <th width="25%" class="text-center">Metodo</td>
    </tr>
    </thead>
    <?php foreach ($reporte->pagos as $pago):?>
        <tr>
            <td width='25%' class='text-center'><?php echo $pago->email?></td>
            <td width='25%' style="text-align:center;" class='text-center'><?php echo $pago->fecha_pago?></td>
            <td width='25%' style="text-align:center;" class='text-center'>$<?php echo $pago->monto_corte?></td>
            <td width='25%' style="text-align:center;" class='text-center'>
            <?php if($pago->tipo_pago == 'paypal'): ?>
                PayPal
            <?php else: ?>
                Banco
            <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
</table>


</body>
</html>
