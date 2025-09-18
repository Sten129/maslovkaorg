<div class="menu_mobile burger-menu">
	<svg width="24" height="24" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M14 5V6H2V5H14Z" fill="black" />
		<path d="M14 10V11H2V10H14Z" fill="black" />
	</svg>
</div>
<nav class="menu">
	<?php
	wp_nav_menu(array(
		'theme_location' => 'main-menu',
		'container' => false,
		'items_wrap' => '%3$s',
		'walker' => new Walker_Nav_A_Only()
	));
	?>
	<span class="menu_desctiption_mob">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt="логотип городок художников">
		Городок художников<br>
		на Масловке
	</span>
</nav>
