<?php get_header(); ?>	

<header id="header">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>

		<div class="header_container">

				<div class="header_bread">
				<a href="/художники/">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.9502 8.4834L1.45215 7.98535L1.9502 7.4873L6.43262 3.00488L6.93066 2.50684L7.92676 3.50293L7.42871 4.00098L4.14746 7.28223H13.8447H14.5479V8.68848H13.8447H4.14746L7.42871 11.999L7.92676 12.4971L6.93066 13.4932L6.43262 12.9951L1.9502 8.4834Z" />
					</svg>
					Все художники
				</a>
				<button class="share-button artists_share-btn" onclick="sharePage()">
					<svg class="artists_share" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M14.5625 4.25C14.5625 5.80273 13.3027 7.0625 11.75 7.0625C10.9004 7.0625 10.1387 6.71094 9.61133 6.0957L6.97461 7.41406C7.0332 7.61914 7.0625 7.82422 7.0625 8C7.0625 8.20508 7.0332 8.41016 6.97461 8.61523L9.61133 9.9043C10.1387 9.31836 10.9004 8.9375 11.75 8.9375C13.3027 8.9375 14.5625 10.1973 14.5625 11.75C14.5625 13.3027 13.3027 14.5625 11.75 14.5625C10.1973 14.5625 8.9375 13.3027 8.9375 11.75C8.9375 11.5742 8.9375 11.3691 8.99609 11.1641L6.35938 9.8457C5.83203 10.4609 5.07031 10.8125 4.25 10.8125C2.69727 10.8125 1.4375 9.55273 1.4375 8C1.4375 6.44727 2.69727 5.1875 4.25 5.1875C5.07031 5.1875 5.83203 5.56836 6.35938 6.1543L8.99609 4.86523C8.9375 4.66016 8.9375 4.45508 8.9375 4.25C8.9375 2.69727 10.1973 1.4375 11.75 1.4375C13.3027 1.4375 14.5625 2.69727 14.5625 4.25ZM4.25 9.40625C4.74805 9.40625 5.1875 9.14258 5.45117 8.70312C5.71484 8.29297 5.71484 7.73633 5.45117 7.29688C5.1875 6.88672 4.74805 6.59375 4.25 6.59375C3.72266 6.59375 3.2832 6.88672 3.01953 7.29688C2.75586 7.73633 2.75586 8.29297 3.01953 8.70312C3.2832 9.14258 3.72266 9.40625 4.25 9.40625ZM13.1562 4.25C13.1562 3.75195 12.8633 3.3125 12.4531 3.04883C12.0137 2.78516 11.457 2.78516 11.0469 3.04883C10.6074 3.3125 10.3438 3.75195 10.3438 4.25C10.3438 4.77734 10.6074 5.2168 11.0469 5.48047C11.457 5.74414 12.0137 5.74414 12.4531 5.48047C12.8633 5.2168 13.1562 4.77734 13.1562 4.25ZM11.75 13.1562C12.248 13.1562 12.6875 12.8926 12.9512 12.4531C13.2148 12.043 13.2148 11.4863 12.9512 11.0469C12.6875 10.6367 12.248 10.3438 11.75 10.3438C11.2227 10.3438 10.7832 10.6367 10.5195 11.0469C10.2559 11.4863 10.2559 12.043 10.5195 12.4531C10.7832 12.8926 11.2227 13.1562 11.75 13.1562Z" />
					</svg>
					Поделиться
				</button>
				<script>
				function sharePage() {
					if (navigator.share) {
						navigator.share({
							title: document.title,
							text: 'Смотри страницу:',
							url: window.location.href,
						}).then(() => {
							console.log('Успешно поделились!');
						}).catch((error) => {
							console.log('Ошибка при попытке поделиться:', error);
						});
					} else {
						alert('Функция "Поделиться" не поддерживается в вашем браузере');
					}
				}
				</script>
			</div>
				<div class="artists_header">
					<div class="informer_aside artists_header_photo">
					</div>
					<div class="informer_content">
						<h1 class="page_title artists_title">
							
								<?php if (get_field('дополнительное_наименование_автора') != ""): ?>
								<span class="artists_page_mintitle">
								<?php echo get_field('дополнительное_наименование_автора') ?>
								</span>
								<?php endif; ?>

								<?php	the_title(); ?>

						</h1>
					</div>
				</div>

		</div>

	</div>
</header>

<main id="page">
	<div class="wrapper">

		<div class="page_maininfo page_artists">
				<div class="informer_aside artists_header_photo">
						<div class="artists_main_img">
								<?php if (has_post_thumbnail()): ?>
									<img src="<?php echo the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
								<?php else: ?>
								<div class="non-photo">
									<span>Фото художника нет</span>
								</div>
								<?php endif; ?>
								<span class="artists_date"><?php echo get_field('годы_жизни'); ?></span>
						</div>					
				</div>
				<div class="informer_content">
						<?php the_content(); ?>
				</div>
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

		<?php 
			$images = get_field('работы_художника');
			$images_artist = get_field('фото_художника'); 
		?>

		<?php if ($images): ?>
			<div class="informer gallery">
				<div class="informer_aside">
					<h3 class="informer_title">Работы художника</h3>
				</div>
				<div class="artists_gallery">
					<?php foreach ($images as $image): ?>
						<a href="<?php echo esc_url($image['url']); ?> " target="_blank">
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
							<?php if (!empty($image['caption'])): ?>
								<div class="informer_gallery-caption"><?php echo esc_html($image['caption']); ?></div>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ($images_artist): ?>
			<div class="informer gallery">
				<div class="informer_aside">
					<h3 class="informer_title">В фотографиях</h3>
				</div>
				<div class="artists_gallery">
					<?php foreach ($images_artist as $image): ?>
						<a href="<?php echo esc_url($image['url']); ?> " target="_blank">
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
							<?php if (!empty($image['caption'])): ?>
								<div class="informer_gallery-caption"><?php echo esc_html($image['caption']); ?></div>
							<?php endif; ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		
		<div class="artists_secondinfo">
			<span>Теги художника</span>
			<div class="artists-page-tags">
					<?php
					$categories = get_the_terms(get_the_ID(), 'category');
					if ($categories && !is_wp_error($categories)) :
							foreach ($categories as $cat):
					?>
							<a href="/художники/?category=<?php echo esc_html($cat->name); ?>" class="btn-tag"><?php echo esc_html($cat->name); ?></a>
					<?php
							endforeach;
					endif;
					?>
			</div>
		</div>


	<div class="artists_secondinfo">
    <span>Близкие художники</span>
		<div class="artists_cards single_card">
    <?php
    $current_id = get_the_ID();
    $categories = wp_get_post_categories($current_id);

    if (!empty($categories)) {
        $args = array(
            'category__in' => $categories,
            'post__not_in' => array($current_id),
            'posts_per_page' => 3,
            'post_type' => 'post',
        );
        $related = get_posts($args);
        if ($related) :
            foreach ($related as $post) :
                setup_postdata($post);
                ?>
								
                <a href="<?php the_permalink(); ?>" class="artists_card">
									<div class="artists_card-name">
											<span class="artists_card-surname"><?php the_title(); ?></span>
											<?php
											$extra_name = get_field('дополнительное_наименование_автора');
											if ($extra_name):
													echo '<span>' . esc_html($extra_name) . '</span>';
											endif;
											?>
									</div>
									<div class="artists_card-img">
											<?php if (has_post_thumbnail()): ?>
												<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">

											<?php endif; ?>
									</div>
                </a>

                <?php
            endforeach;
            wp_reset_postdata();
        else:
            echo '<p>Нет похожих художников.</p>';
        endif;
    }
    ?>
		</div>
</div>

	</div>

</main>


<?php get_footer(); ?>
