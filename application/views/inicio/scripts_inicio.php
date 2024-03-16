<script>
$(".timer-corto").each(function() {
	var tiempo = $(this).data("countdown");
	var fecha = moment.tz(tiempo, 'America/Merida');
	
	$(this).countdown(fecha.toDate(), function(event) {
		$(this).html(event.strftime('<span class="quedan">Quedan</span> <span class="f">%-D</span> <span class="quedan">días</span>'));
	});
});
</script>