<script>

    $(document).ready(function () {
        /*Inicio slider tienda*/

        console.log('tienda nuevo');
        $("#eliminar-slideruno").click(function() {
            console.log('click');
            $("#id_slide_uno").val('1');
            $("#img-uno").html('');
            $("#eliminar-slideruno").remove();
        });


        $(document).on("click", "#eliminar-sliderdos", function() {

            $("#id_slide_dos").val('2');
            $("#img-dos").html('');
            $("#eliminar-sliderdos").remove();


        });

        $(document).on("click", "#eliminar-slidertres", function() {

            $("#id_slide_tres").val('3');
            $("#img-tres").html('');
            $("#eliminar-slidertres").remove();

        });

        /*Fin slider tienda*/
    });
</script>