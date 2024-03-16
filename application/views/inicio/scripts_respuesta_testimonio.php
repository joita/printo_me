<script type="text/javascript">
    $('#check-cambiar').change(function () {
        if($('#check-cambiar').is(":checked")){
            $('#cambiar-calif').show(250).slideDown();
        }else {
            $('#cambiar-calif').hide(250).slideUp();
        }
    });
</script>