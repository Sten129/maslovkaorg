<?php get_header(); ?>	

<header id="header" class="single_page">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>

		<div class="header_container">
			<h1 class="page_title">
				<?php the_title();?>
			</h1>
		</div>

	</div>
</header>

<main id="page" class="infopage">
	<div class="wrapper">
		<div class="page_maininfo page_minblocks">
			<?php the_content(); ?>
		</div>

		<!-- Блок повторителя -->
		<?php if( have_rows('content_block') ): ?>
			<?php while( have_rows('content_block') ): the_row(); 
				$title = get_sub_field('титул_блока');
				$content = get_sub_field('описание');
			?>
			<div class="informer">
				<div class="informer_aside">
					<h3 class="informer_title"><?php echo esc_html($title); ?></h3>
				</div>
				<div class="informer_content">
					<?php if ($content): ?>
						<?php echo $content; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php endwhile; ?>
		<?php endif; ?>

	</div>
</main>


<?php get_footer(); ?>
