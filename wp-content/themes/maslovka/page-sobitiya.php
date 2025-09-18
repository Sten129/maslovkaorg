<?php 
/* Template Name: События (активные) */
?>
<?php get_header(); ?>

<?php
setlocale(LC_TIME, 'ru_RU.UTF-8');

// Функция для форматирования даты
function format_date_russian($dateYmd) {
	$months = [
		'01' => 'янв', '02' => 'фев', '03' => 'мар',
		'04' => 'апр', '05' => 'мая', '06' => 'июн',
		'07' => 'июл', '08' => 'авг', '09' => 'сент',
		'10' => 'окт', '11' => 'нояб', '12' => 'дек'
	];

	$dt = DateTime::createFromFormat('Ymd', $dateYmd);
	if (!$dt) return '';

	$day = $dt->format('d');
	$month = $months[$dt->format('m')];
	$year = $dt->format('Y');

	return "$day ";
}

// Функция для названия месяца
function get_month_russian($dateYmd) {
	$months = [
		'01' => 'январь', '02' => 'февраль', '03' => 'март',
		'04' => 'апрель', '05' => 'май', '06' => 'июнь',
		'07' => 'июль', '08' => 'август', '09' => 'сентябрь',
		'10' => 'октябрь', '11' => 'ноябрь', '12' => 'декабрь'
	];

	$dt = DateTime::createFromFormat('Ymd', $dateYmd);
	return $months[$dt->format('m')] ?? '';
}
?>

<header id="header">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>
		<h1 class="page_title page_title_bg">
			<?php
			remove_filter('the_content', 'wpautop');
			the_content();
			?>
		</h1>
	</div>
</header>

<main id="page">
	<div class="wrapper">
		<div id="filter-toggle">
			<a href="#" class="btn-primary_white">Предстоящие</a>
			<a href="/события-прошедшие" class="btn-ghost">Прошедшие</a>
		</div>

		<?php
		$today = date('Ymd');

		$events = new WP_Query([
			'post_type' => 'sobitiya',
			'posts_per_page' => -1,
			'meta_key' => 'дата',
			'orderby' => 'meta_value',
			'order' => 'ASC',
			'meta_query' => [
				[
					'key' => 'дата',
					'value' => $today,
					'compare' => '>=',
					'type' => 'DATE'
				]
			]
		]);

		$months = [];

		if ($events->have_posts()) :
			while ($events->have_posts()) : $events->the_post();
				$event_date_raw = get_field('дата'); // Ymd
				$event_date = DateTime::createFromFormat('Ymd', $event_date_raw);
				if (!$event_date) continue;

				$month_key = get_month_russian($event_date_raw);
				$months[$month_key][] = [
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'excerpt' => get_the_excerpt(),
					'id' => get_the_ID(),
					// 'category' => get_the_terms(get_the_ID(), 'category')[0]->name ?? '',
					'date_display' => format_date_russian($event_date_raw),
					'btn_url' => get_field('ссылка_для_кнопки'),
					'btn_text' => get_field('текст_в_кнопке', get_the_ID()) ?: 'Выбрать время',
					'bg_color' => get_field('цвет_блока') ?: '#2b3026',
					'thumb' => get_the_post_thumbnail(get_the_ID(), 'large'),
					'color_black' => get_field('цвет_текста_события') === true ? 'black' : '',
					'disable_description' => get_field('выключатель_описания')
				];
			endwhile;
			wp_reset_postdata();
		endif;
		if (empty($months)) {
			echo '
			<div class="non-archive">
			<img src="' . get_template_directory_uri() . '/assets/img/icons/nfc-slash.svg">
			<p>Ничего не найдено!</p>
			</div>
			';
		}
		foreach ($months as $month => $events_list) :
		?>
			<div class="news_month">
				<span><?php echo esc_html($month); ?></span>
				<div class="news_blocks">
					<?php foreach ($events_list as $event) : ?>
						<div class="news_item_block <?php echo esc_attr($event['color_black']); ?>" style="background-color: <?php echo esc_attr($event['bg_color']); ?>;">
							<div class="news__block-informer">
								<div class="news__block-top">
									<span class="news__block-date"><?php echo esc_html($event['date_display']); ?></span>
									<span class="news__block-category">
										
									<?php 
										$terms = get_the_terms($event['id'], 'events');
										if ($terms && !is_wp_error($terms)) {
											foreach ($terms as $term) {
												echo esc_html($term->name). " ";
											}
										}																
									?>

									</span>
								</div>
								<h2 class="news__block-name"><?php echo esc_html($event['title']); ?></h2>
								<p class="news__block-descript"><?php echo esc_html($event['excerpt']); ?></p>
									<div class="news_buttons">

									<?php if ($event['btn_url']) : ?>
										<div class="news_buttons_main" data-btn-text="<?php echo esc_html($event['btn_text']); ?>">
											<?php echo $event['btn_url']; ?>
										</div>
									<?php endif; ?>
									
									<?php if (!$event['disable_description']): ?>
									<a href="<?php echo esc_html($event['permalink']); ?>" class="btn-primary_white news_button_min">
										Подробнее
									</a>
									<?php endif; ?>
									</div>
								
							</div>
							<div class="news__block-img">
								<?php echo $event['thumb']; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</main>

<?php get_footer(); ?>
