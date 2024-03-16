<script type="text/javascript" src="<?php echo site_url('tests/core.js')?>"></script>
<script src="<?php echo site_url('tests/fabric.min.js')?>"></script>
<script src="<?php echo site_url('tests/customiseControls.min.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/i18n/jquery.spectrum-es.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css" />
<script>
    /*******************************************************************************************************************
    * Inicializacion de variables
    * base_url = url base del sitio web
    * canvas = el canvas unico por el momento para la edicion.
    *******************************************************************************************************************/
    base_url = '<?php echo base_url();?>';
    const canvas = new fabric.Canvas('c');
    /*******************************************************************************************************************
    * funciones de inicializacion y descarga de pagina
    * cargar_pagina: se obtienen las fuentes se cargan con webfontloader, al terminar la carga de fuentes se verifican
    *                diseños en localStorage si existe se carga en el canvas.
    * custom_icons: iconos personalizados para la edicion de los elementos del canvas.
    * custom_actions: acciones personalizadas para la edicion de los elementos del canvas.
    * descargar_ventana: se guarda el diseño actual en canvas en localStorage al descargar la pagina.
    *******************************************************************************************************************/
    const cargar_pagina = $(document).ready(function () {
        $.ajax({
            method: 'GET',
            url: "<?php echo base_url('tests-diseno/obtener-fuentes');?>",
            beforeSend: function(){
                $("#loader").show(10);
            },
            success: function (data) {
                const info = JSON.parse(data);
                let fonts = [];
                _.forEach(info, function(font){
                    fonts.push(font.title);
                });
                WebFont.load({
                    google: {
                        families: fonts
                    },
                    active: function() {
                        sessionStorage.fonts = true;
                        if (localStorage.getItem("design") !== null) {
                            const json = localStorage.getItem("design");
                            canvas.loadFromJSON($.parseJSON(json), canvas.renderAll.bind(canvas));
                            $("#loader").hide(10);
                        }
                    }
                });
            }
        });
    });

    const custom_icons = fabric.Object.prototype.customiseCornerIcons({
        settings: {
            borderColor: '#95D600',
            cornerSize: 10,
            cornerShape: 'rect',
            cornerBackgroundColor: '#EE4500',
            cornerPadding: 3
        },
        tl: {
            icon: 'tests/trash.svg',
            settings: {
                cornerSize: 25,
                cornerShape: 'rect',
                cornerBackgroundColor: 'transparent',
                cornerPadding: 3
            }
        },
        mt:{
            icon: 'tests/Up.png',
            settings: {
                cornerSize: 25,
                cornerShape: 'rect',
                cornerBackgroundColor: 'transparent',
                cornerPadding: 3
            }
        },
        mb:{
            icon: 'tests/Down.png',
            settings: {
                cornerSize: 25,
                cornerShape: 'rect',
                cornerBackgroundColor: 'transparent',
                cornerPadding: 3
            }
        },
        mtr: {
            icon: 'tests/rotate.svg',
            settings: {
                cornerSize: 25,
                cornerShape: 'rect',
                cornerBackgroundColor: 'transparent',
                cornerPadding: 3
            }
        },
    }, function(){
        canvas.renderAll();
    });

    const custom_actions = fabric.Canvas.prototype.customiseControls({
        tl: {
            action : 'remove',
            cursor: 'pointer'
        },
        mt:{
            action: 'moveUp',
            cursor: 'pointer'
        },
        mb:{
            action: 'moveDown',
            cursor: 'pointer'
        }
    });

    const descargar_ventana = $( window ).bind('beforeunload', function() {
        const json = canvas.toJSON(['colores', 'tipo', 'group_fills', 'colores', 'image_name']);
        localStorage.setItem('design', JSON.stringify(json));
    });
    /*******************************************************************************************************************
     * funciones para nuevos elementos en canvas
     * nuevo_texto: genera un nuevo elemento de IText de FabricJS en canvas.
     * nueva_imagen: genera un nuevo elemento fabric.image de FabricJS en canvas.
     * nuevo_svg: genera un elemento group de FabriJS en canvas.
     ******************************************************************************************************************/
    const nuevo_texto = $("a#new-txt").click(function () {
        const text = 'editar';
        var textSample = new fabric.IText(text, {
            fill: getRandomColor(),
            left: 200,
            top: 200,
            lockScalingFlip: true,
            tipo: "txt",
            fontFamily: 'Arimo'
        });
        canvas.add(textSample);
    });

    const nueva_imagen = $('#imgLoader').change(function (evento) {
        evento.preventDefault();
        const fd = new FormData();
        const files = $('#imgLoader').prop('files')[0];
        const fileName = evento.target.files[0].name;
        fd.append('file',files);
        let colores = [];
        $.ajax({
            url: "<?php echo base_url('tests-diseno/obtener-colores-imagen');?>",
            data: fd,
            method: "POST",
            contentType: false,
            cache: false,
            processData:false,
            success: function (respuesta) {
                colores = JSON.parse(respuesta);
                const reader = new FileReader();
                reader.onload = function (event){
                    const imgObj = new Image();
                    imgObj.onload = function () {
                        const imagen = new fabric.Image(imgObj, {
                            left: 200,
                            top: 200,
                            scaleX: 0.3,
                            scaleY: 0.3,
                            lockScalingFlip: true,
                            tipo: "img",
                            colores: colores,
                            image_name : fileName
                        });
                        canvas.centerObject(imagen);
                        canvas.add(imagen);
                        canvas.renderAll();
                    };
                    imgObj.src = event.target.result;
                };
                reader.readAsDataURL(evento.target.files[0]);
            }
        });
    });

    const nuevo_svg = $('a#new-svg').click(function (e) {
        const url = $("input#svgLoader").val();
        fabric.loadSVGFromURL((base_url + url),function(objects) {
            var group = new fabric.Group(objects, {
                left: 200,
                top: 200,
                lockScalingFlip: true,
                tipo: "svg",
                dirty: true,
                group_fills : obtener_colores_svg(objects)
            });
            canvas.add(group);
            canvas.renderAll();
        });
    });
    /*******************************************************************************************************************
     * funciones miscelaneas
     * getRandomColor: obtiene un color random
     * rgbToHex: de un color r, g, b transforma a hex
     * fullcolorhex: de un color rgb en 3 partes lo convierte a hex utiliza rgbtohex
     * obtener_colores_svg: extrae los colores de elementos tipo svg
     ******************************************************************************************************************/
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    const rgbToHex = function (rgb) {
        let hex = Number(rgb).toString(16);
        if (hex.length < 2) {
            hex = "0" + hex;
        }
        return hex;
    };

    const fullColorHex = function(r,g,b) {
        const red = rgbToHex(r);
        const  green = rgbToHex(g);
        const blue = rgbToHex(b);
        return "#"+red+green+blue;
    };

    function obtener_colores_svg(obj) {
        let arr = [];
        _.forEach(obj, function (elem) {
            arr.push(elem.fill);
        });
        const unique_arr = new Set(arr);
        let color_arr = Array.from(unique_arr);
        const index = _.indexOf(color_arr, "");
        if(index !== -1){
            color_arr[index] = "#000000";
        }
        return color_arr;
    }

    const seleccionar_elemento = function (evt) {
        const obj = evt.target;
        let color_html = "";
        console.log(obj);
        if(obj.tipo === 'svg'){
            for (let i = 0; i < obj.group_fills.length; i++){
                color_html = color_html.concat("<input type='text' id='"+i+"' class='basic color_switch' value='"+obj.group_fills[i]+"' />");
            }
            $("#colores").html(color_html);
            let prevColor;
            $(".basic").spectrum({
                preferredFormat: "hex",
                showInput: true,
                showPalette: true,
                palette: [canvas.colores],
                showSelectionPalette: false,
                hideAfterPaletteSelect:true,
                show: function(color) {
                    prevColor = color.toHexString();
                },
                change: function (color) {
                    const newColor = color.toHexString();
                    for(let i = 0; i < obj.getObjects().length; i++){
                        if(obj.getObjects()[i].get("fill").toUpperCase() === prevColor.toUpperCase()){
                            obj.getObjects()[i].set("fill", newColor);
                            obj.set("group_fills", obtener_colores_svg(obj.getObjects()));
                        }
                    }
                    canvas.renderAll();
                    recalcular_num_colores();
                },
                hide: function() {
                    recalcular_num_colores();
                }
            });
        }else if(obj.tipo === 'txt'){
            $("#container_fonts").show(10);
            $("#fonts").val(obj.fontFamily);
            color_html = color_html.concat("<input type='text' id='text_color' class='basic color_switch' value='"+obj.fill+"' />");
            $("#colores").html(color_html);
            $(".basic").spectrum({
                preferredFormat: "hex",
                showInput: true,
                showPalette: true,
                palette: [canvas.colores],
                showSelectionPalette: false,
                hideAfterPaletteSelect:true,
                change: function (color) {
                    const newColor = color.toHexString();
                    obj.set('fill', newColor);
                    canvas.renderAll();
                    recalcular_num_colores();
                },
                hide: function() {
                    recalcular_num_colores();
                }
            });
        }
    };

    canvas.on("selection:updated", function(evt){
        seleccionar_elemento(evt)
    });

    canvas.on("selection:created", function(evt){
        seleccionar_elemento(evt)
    });

    $("select#fonts").on('change', function () {
        const font = $(this).children("option:selected").val();
        canvas.getActiveObject().set("fontFamily", font);
        canvas.requestRenderAll();
    });

    canvas.on("object:added", function(){
        recalcular_num_colores();
    });

    canvas.on("object:removed", function(){
        recalcular_num_colores();
    });

    canvas.on("selection:cleared", function (evt) {
        $("#colores").html("NO hay selección");
        $("#container_fonts").hide(10);
    });

    $("#to-img").click(function () {
        const png = canvas.toDataURL('png');
        $.ajax({
            url: base_url+"tests-diseno/generar-imagen",
            data: {
                svgString: png
            },
            method: "post",
            success: function(respuesta) {
                $("#display_result").html("<img alt='imagen' src='"+respuesta+"'/>");
            }
        });
    });

    $("#to-json").click(function () {
        const json = canvas.toJSON(['colores', 'tipo', 'group_fills', 'colores', 'image_name']);
        JSONC.
        console.log("Accurate for non ascii chars: "+ lengthInUtf8Bytes(JSON.stringify(json)));
    });

    function lengthInUtf8Bytes(str) {
        var m = encodeURIComponent(str).match(/%[89ABab]/g);
        return str.length + (m ? m.length : 0);
    }

    $("#guardar").click(function () {
        const json = canvas.toJSON(['colores', 'tipo', 'group_fills', 'colores', 'image_name']);
        const images = [];
        $.each(canvas.getObjects(), function (index, obj) {
            if(obj.tipo === 'img'){
                images.push(obj.src);
            }
        });
        $.ajax({
           method: 'POST',
           url: base_url+'tests-diseno/guardar',
           data: {
               json : JSON.stringify(json),
               images : JSON.stringify(images)
           },
           success: function (response) {
               const json = JSON.parse(response);
               canvas.clear();
               canvas.loadFromJSON(json, canvas.renderAll.bind(canvas));
               console.log(canvas);
           }
        });
    });

    $(".sides").click(function () {
       const side = $(this).attr('id');
    });

    function recalcular_num_colores(){
        let color_arr = [];
        canvas.forEachObject(function(obj){
            if(obj.fill !== 'transparent' && obj.tipo !== "svg") {
                if(obj.tipo !== "img"){
                    color_arr.push(obj.fill);
                }else{
                    color_arr = color_arr.concat(obj.colores);
                }
            }else if(obj.tipo === "svg"){
                color_arr = color_arr.concat(obj.group_fills);
            }
        });
        const pre_set = new Set(color_arr);
        let pre_arr = [];
        $.each(Array.from(pre_set), function (index, item) {
            pre_arr.push(item.toUpperCase());
        });
        const unique_set = new Set(pre_arr);
        const unique_arr = Array.from(unique_set);
        canvas.set('colores', Array.from(unique_arr));
        $("#num_colores").html(unique_arr.length);
        color_arr = [];
    }

</script>