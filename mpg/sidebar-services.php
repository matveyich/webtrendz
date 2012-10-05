<?php
	if ( is_active_sidebar( 'services-widget-area' ) ) : ?>
<script>
$(document).ready(function() {

	$("div.col:eq(0)").addClass("colA");
	$("div.col:eq(1)").addClass("colB");
	$("div.col:eq(2)").addClass("colC");

});
</script>
		<div class="servicesContainer">
			<h2>What we do?</h2>
				<?php dynamic_sidebar( 'services-widget-area' ); ?>

		</div>

<?php endif; ?>
