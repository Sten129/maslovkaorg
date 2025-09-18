<?php 
/* Template Name: Музей */
?>

<?php get_header(); ?>	



<header id="header">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>

		<div class="header_container">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logomuseim.png" alt="" class="header_image">
			<h1 class="page_title">
				<?php the_title();?>
			</h1>
		</div>

	</div>
</header>

<main id="page">
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

		<!-- Акционный блок -->
		<?php
			$akc_title = get_field('акц_заголовок');
			$akc_info = get_field('акц_информация');
			$akc_top = get_field('акц_верхушка_когда');
			$akc_link = get_field('акц_ссылка');
			$akc_img = get_field('акц_картинка');
		?>
		<?php if ($akc_title || $akc_info || $akc_top): ?>
			<div class="descblock">
				<div class="descblock_informer">
					<?php if ($akc_top): ?>
						<div class="descblock_label">
							<span></span>
							<?php echo esc_html($akc_top); ?>
						</div>
					<?php endif; ?>
					<?php if ($akc_title): ?>
						<h2 class="descblock_title"><?php echo esc_html($akc_title); ?></h2>
					<?php endif; ?>
					<?php if ($akc_info): ?>
						<p><?php echo esc_html($akc_info); ?></p>
					<?php endif; ?>
						<a href="<?php echo esc_url($akc_link); ?>" class="btn-primary descblock_btn">Откликнуться</a>
				</div>
				<?php if ($akc_img): ?>
				<div class="descblock_img">
					<img src="<?php echo esc_html($akc_img); ?>" alt="">
				</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</main>


<?php get_footer(); ?>
