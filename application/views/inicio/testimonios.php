<div class="fgc ps so_ab">
	<div class="row">
        <div class="small-16 medium-17 large-17 small-centered columns">

            <h1 class="azul text-center divisor">Testimonios</h1>

            <div class="row small-up-1 medium-up-2 large-up-4" id="testimonios" data-equalizer data-equalize-by-row="true" data-equalize-on="medium">
            	<?php for($i=0;$i<sizeof($posiciones_testimonios);$i++): ?>
            	<div class="column testimonio-holder">
            		<div class="testimonio">
            			<div class="testimonio-contenedor">
            				<p data-equalizer-watch><?php echo $testimonios[$posiciones_testimonios[$i]]['testimonio']; ?></p>
            			</div>
            			<span class="testimonio-nombre"><?php echo $testimonios[$posiciones_testimonios[$i]]['nombre']; ?></span>
            		</div>
            	</div>
            	<?php endfor; ?>
            </div>
        </div>
    </div>
</div>
