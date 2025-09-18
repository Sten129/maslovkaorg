<?php get_header(); ?>	

<header id="header">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>

		<div class="header_container">
			<div class="news_buttons_main" data-btn-text="<?php echo get_field('текст_в_кнопке'); ?>">
			<?php echo get_field('ссылка_для_кнопки'); ?>
			</div>

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
					<h3 class="informer_title">
						<?php echo esc_html($title); ?>
					</h3>
					<?php if( have_rows('сноска_под_заголовком') ): ?>
						<?php while( have_rows('сноска_под_заголовком') ): the_row(); ?>
							<?php 
							$note_text = get_sub_field('текст_в_сноске');
							$note_author = get_sub_field('автор_сноски');
							?>
							<div class="informer_label">
								<?php if ($note_text): ?><p><?php echo esc_html($note_text); ?></p><?php endif; ?>
								<?php if ($note_author): ?><span><?php echo esc_html($note_author); ?></span><?php endif; ?>
							</div>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<div class="informer_content">
					<?php if ($content): ?>
						<?php echo $content; ?>
					<?php endif; ?>
				</div>
			</div>
			<?php endwhile; ?>
		<?php endif; ?>
		<br><br>
		<div class="news_buttons_main" style="margin: 24px auto;" data-btn-text="<?php echo get_field('текст_в_кнопке'); ?>">
		<?php echo get_field('ссылка_для_кнопки'); ?>
		</div>
	</div>
	
</main>


<?php get_footer(); ?>
