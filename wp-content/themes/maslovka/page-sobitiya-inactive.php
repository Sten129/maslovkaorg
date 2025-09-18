<?php 
/* Template Name: События (Прошедшие) */
?>

<?php get_header(); ?>	

<?php
setlocale(LC_TIME, 'ru_RU.UTF-8');

function format_date_russian($dateYmd) {
	$months = [
		'01' => 'января', '02' => 'февраля', '03' => 'марта',
		'04' => 'апреля', '05' => 'мая', '06' => 'июн',
		'07' => 'июля', '08' => 'августа', '09' => 'сентября',
		'10' => 'октября', '11' => 'ноября', '12' => 'декабря'
	];

	$dt = DateTime::createFromFormat('Ymd', $dateYmd);
	if (!$dt) return '';
	$day = $dt->format('d');
	$month = $months[$dt->format('m')];
	$year = $dt->format('Y');

	return "$day $month $year";
}

function get_month_russian($dateYmd) {
	$months = [
		'01' => '', '02' => '', '03' => '',
		'04' => '', '05' => '', '06' => '',
		'07' => '', '08' => '', '09' => '',
		'10' => '', '11' => '', '12' => ''
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
			<a href="/события-активные" class="btn-ghost" >Предстоящие</a>
			<a href="#" class="btn-primary_white">Прошедшие</a>
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
					'compare' => '<',
					'type' => 'DATE'
				]
			]
		]);

		$months = [];

		if ($events->have_posts()) :
			while ($events->have_posts()) : $events->the_post();
				$event_date_raw = get_field('дата');
				$event_date = DateTime::createFromFormat('Ymd', $event_date_raw);
				if (!$event_date) continue;

				$month_key = $event_date->format('Y-m');
				$months[$month_key]['events'][] = [
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'excerpt' => get_the_excerpt(),
					'id' => get_the_ID(),
					// 'category' => get_the_terms(get_the_ID(), 'category')[0]->name ?? '',
					'date_display' => format_date_russian($event_date_raw),
					'btn_url' => get_field('ссылка_для_кнопки'),
					'bg_color' => get_field('цвет_блока') ?: '#2b3026',
					'thumb' => get_the_post_thumbnail(get_the_ID(), 'large'),
					'color_black' => get_field('цвет_текста_события') === true ? 'black' : ''
				];
				$months[$month_key]['title'] = get_month_russian($event_date_raw);
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
		// Сортируем ключи по убыванию (новее — выше)
		krsort($months);
		?>

		<?php foreach ($months as $month_data): ?>
			<div class="news_month">
				<span><?php echo esc_html($month_data['title']); ?></span>
				<div class="news_blocks">
					<?php foreach ($month_data['events'] as $event): ?>
						<div class="news_item_block inactive">
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
								<span class="news__block-btn">Событие прошло</span>
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
