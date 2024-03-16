<div class="row" style="position: relative">
    <div class="small-5 columns" id="tool-test" style="height: auto; padding: 1rem;">
        <div style=" border-radius: 5%; background: #F0F0F0; padding: 1rem;">
            <form enctype="multipart/form-data">
                <input id="imgLoader" type="file" name="file" accept="image/*" data-i="0"/>

            </form>
            <br>
            <label for="svgLoader">SVG Loader</label>
            <input id="svgLoader" type="text" placeholder="svg" value="media/cliparts/1/print/horse.svg"/>
            <a class="button" id="new-svg">Subir SVG</a>
            <br>
            <a class="button" id="new-txt">Nuevo Texto</a>
            <br>
            <a class="button" id="to-json">JSON</a>
            <br>
            <a class="button" id="to-img">Preview</a>
            <br>
            <a class="button" id="guardar">Guardar</a>
            <br>
            <label for="estilo">Estilos: </label>
            <select id="estilo">
                <?php foreach ($estilos as $estilo):?>
                    <option value="<?php echo $estilo->id_diseno?>" <?php if($estilo->id_diseno == $estilo_actual->id_diseno){ echo 'selected';}?>><?php echo $estilo->id_diseno?></option>
                <?php endforeach;?>
            </select>
            <br>
            <div id="container_fonts" style="display: none;">
                <label for="fonts">Fuentes: </label>
                <select id="fonts">
                    <?php foreach ($fonts as $font){
                        echo "<option class='font' style='font-family: $font->title' value='$font->title'>$font->title</option>";
                    }
                    ?>
                </select>
            </div>
            <br>
            <div id='sides' style="position: relative;">
                <a class="button sides" id="front">Front</a>
                <a class="button sides" id="left">Left</a>
                <a class="button sides" id="right">Right</a>
                <a class="button sides" id="back">Back</a>
            </div>
            <br>
            <label for="num_colores">colores:</label>
            <p id="num_colores"></p>
            <div id="colores" style="background: #9A9BA0; padding: 1rem; border-radius: 5% ">
                <!--Contenedor de edicion de colores svg-->
            </div>
        </div>
    </div>
    <div id="loader" style="position: absolute; background: #0a0a0a; opacity: 0.5; width: 100%; height: 100%; z-index: 99999; display: none"></div>
    <div id="editor">
        <img src="assets/images/productos/producto1/900_playera-blanca_pp01_blanca.jpg" alt="camiseta" id="imagen_fondo" style="position: relative;"/>
        <div class="small-13 columns" id="canvas-test" style="position: absolute; top: 100px; left: 500px">
            <canvas id="c" width="220" height="350" style="border: 1px dashed red; left: 100px; top: 100px; touch-action: none; user-select: none;"></canvas>
        </div>
    </div>
    <div id="display_result">

    </div>
</div>