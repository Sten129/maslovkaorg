<section id="news">
	<div class="wrapper">
		<div class="news_container">
			<div class="news_header_name">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt="">
				Ближайшие события
			</div>
			<a href="https://docs.google.com/forms/d/e/1FAIpQLSfKXRFF3W7dKWHfYDQ7TtvSYHCBZVxrPHkvg3gGAO4Zfxu2WA/viewform?usp=dialog" class="news_header_subscribe btn-ghost">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M1.90625 4.54883L8 8.73828L14.0938 4.54883V3.40625H1.90625V4.54883ZM14.0938 6.24805L8 10.4375L1.90625 6.24805V11.8438H14.0938V6.24805ZM0.5 11.8438V5.28125V3.40625V2H1.90625H14.0938H15.5V3.40625V5.28125V11.8438V13.25H14.0938H1.90625H0.5V11.8438Z"
						fill="black" />
				</svg>
				<span class="news_subscribe_txt">Подписаться</span>
			</a>

			<div class="news_list">

			<?php
			$sobitiya_query = new WP_Query([
					'post_type' => 'sobitiya',
					'posts_per_page' => 5,
			]);

			if ($sobitiya_query->have_posts()) :
				$i = 0;
				while ($sobitiya_query->have_posts()) : $sobitiya_query->the_post();
					// ACF
					$btn_url = get_field('ссылка_для_кнопки') ?: '';
					$bg_color = get_field('цвет_блока') ?: '#2b3026';
					$date_raw = get_field('дата');
					$date_info = '';
					$btn_text = get_field('текст_в_кнопке') ?: 'Выбрать время';
					$disable_description = get_field('выключатель_описания');
					if ($date_raw) {
						setlocale(LC_TIME, 'ru_RU.UTF-8');
						$date_obj = DateTime::createFromFormat('Ymd', $date_raw);
						if ($date_obj) {
							$date_info = strftime('%e %B %Y', $date_obj->getTimestamp());
							$date_info = mb_convert_case(trim($date_info), MB_CASE_TITLE, "UTF-8");
						}
					}
					$color_black = get_field('цвет_текста_события') ?: 'false';
					// активный класс первому блоку
					$active_class = $i === 0 ? ' active' : '';
			?>
			<!-- news item -->
			<div class="news_item <?php echo $active_class; ?>">
				<div class="news_item_blank">
					<div class="news__blank-informer">
						<div class="news__blank-top">
							<span class="news__blank-date"><?php echo esc_html($date_info); ?></span>
							<span class="news__blank-category">

								<?php 
									$terms = get_the_terms(get_the_ID(), 'events');
									if ($terms && !is_wp_error($terms)) {
										foreach ($terms as $term) {
											echo esc_html($term->name). " ";
										}
									}																
								?>

							</span>
						</div>
						<div class="news__blank-name"><?php the_title(); ?></div>
					</div>
					<img class="news__blank-icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/plus-light.svg" alt="">
				</div>
				<div class="news_item_block <?php echo $active_class; ?> <?php if($color_black === true){echo esc_html('news_black');} ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
					<div class="news__block-informer no-action">
						<div class="news__block-top">
							<span class="news__block-date"><?php echo esc_html($date_info); ?></span>
							<span class="news__block-category">
								<?php 
									$terms = get_the_terms(get_the_ID(), 'events');
									if ($terms && !is_wp_error($terms)) {
										foreach ($terms as $term) {
											echo esc_html($term->name). " ";
										}
									}																
								?>
							</span>
						</div>
						<h2 class="news__block-name"><?php the_title(); ?></h2>
						<div class="news__block-descript"><?php the_excerpt(); ?></div>
						


						<div class="news_buttons">
							<?php if(!empty($btn_url) && $btn_url != '/'): ?>
								<div class="news_buttons_main" data-btn-text="<?php echo esc_attr($btn_text); ?>">
									<?php echo $btn_url; ?>
								</div>
							<?php endif; ?>

							<?php if (!$disable_description): ?>
							<a href="<?php echo get_the_permalink(); ?>" class="btn-primary_white news_button_min">
								Подробнее
							</a>
							<?php endif; ?>
						</div>

					</div>
					<div class="news__block-img no-action">
						<?php if (has_post_thumbnail()) : ?>
							<?php the_post_thumbnail('large'); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
				$i++; 
				endwhile;
				wp_reset_postdata();
			endif;
			?>

			</div>

		</div>
	</div>

</section>
