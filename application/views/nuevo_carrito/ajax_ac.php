<script>
    $(document).ready(function () {
       $.ajax({
           url: 'carrito/post-total-ac',
           method: 'post'
       });
       console.log("hola");
    });
</script>