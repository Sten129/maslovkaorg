<?php get_header(); ?>	

<header id="header" >
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>
		
		<div class="header_container">
			<div class="header_bread">
				<a href="/выставки-активные/">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.9502 8.4834L1.45215 7.98535L1.9502 7.4873L6.43262 3.00488L6.93066 2.50684L7.92676 3.50293L7.42871 4.00098L4.14746 7.28223H13.8447H14.5479V8.68848H13.8447H4.14746L7.42871 11.999L7.92676 12.4971L6.93066 13.4932L6.43262 12.9951L1.9502 8.4834Z" />
					</svg>
					Все выставки
				</a>
				<a href="/выставки-прошедшие/">
					Прошедшие выставки
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14.0352 8.4834L9.55273 12.9951L9.05469 13.4932L8.05859 12.4971L8.55664 11.999L11.8379 8.68848H2.16992H1.4668V7.28223H2.16992H11.8379L8.55664 4.00098L8.05859 3.50293L9.05469 2.50684L9.55273 3.00488L14.0352 7.4873L14.5332 7.98535L14.0352 8.4834Z"/>
					</svg>
				</a>
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
			<!-- Блок повторителя -->
			<?php if( have_rows('content_block') ): ?>
				<?php while( have_rows('content_block') ): the_row(); 
					$title = get_sub_field('титул_блока');
					$content = get_sub_field('описание');
				?>
				<div class="informer">
					<div class="informer_aside">
						<h3 class="informer_title"><?php echo esc_html($title); ?></h3>
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
			<?php $images = get_field('фото_выставки'); ?>
			<?php if ($images != ""): ?>
			<div class="informer gallery">
				<div class="informer_aside">
					<h3 class="informer_title">Фотографии</h3>
				</div>
			<?php endif; ?>	
				<?php if ($images): ?>
					<div class="informer_gallery">
						<?php foreach ($images as $image): ?>
							<a href="<?php echo esc_url($image['url']); ?> " target="_blank">
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
								<?php if (!empty($image['caption'])): ?>
									<div class="informer_gallery-caption"><?php echo esc_html($image['caption']); ?></div>
								<?php endif; ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
</main>

<?php get_footer(); ?>
