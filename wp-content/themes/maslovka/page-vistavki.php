<?php 
/* Template Name: Выставки (активные) */
get_header(); 

// Функция форматирования даты на русском
function format_event_dates($start, $end) {
	$months = array(
		'01' => 'Января', '02' => 'Февраля', '03' => 'Марта',
		'04' => 'Апреля', '05' => 'Мая', '06' => 'Июня',
		'07' => 'Июля', '08' => 'Августа', '09' => 'Сентября',
		'10' => 'Октября', '11' => 'Ноября', '12' => 'Декабря',
	);

	if ($start && $end) {
		$start_day = date('j', strtotime($start));
		$start_month = $months[date('m', strtotime($start))];
		$start_year = date('Y', strtotime($start));

		$end_day = date('j', strtotime($end));
		$end_month = $months[date('m', strtotime($end))];
		$end_year = date('Y', strtotime($end));

		if ($start_year === $end_year) {
			// Если год одинаковый, выводим один раз
			return $start_day . ' ' . $start_month . ' – ' . $end_day . ' ' . $end_month . ' ' . $end_year;
		} else {
			// Если разные — выводим оба года
			return $start_day . ' ' . $start_month . ' ' . $start_year . ' – ' . $end_day . ' ' . $end_month . ' ' . $end_year;
		}
	}
	return '';
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
			<a href="#" class="btn-primary_white">Текущие</a>
			<a href="/выставки-прошедшие" class="btn-ghost">Прошедшие</a>
		</div>

		<div class="expansions">
			<?php
			$today = date('Ymd');
			$args = array(
				'post_type' => 'vistavki',
				'posts_per_page' => -1,
				'meta_query' => array(
					array(
						'key' => 'дата_окончание',
						'value' => $today,
						'compare' => '>=',
					),
				),
				'meta_key' => 'дата_проведения_начало',
				'orderby' => 'meta_value',
				'order' => 'ASC',
			);

			$query = new WP_Query($args);

		if ($query->have_posts()):
			while ($query->have_posts()): $query->the_post();
				$start = get_field('дата_проведения_начало');
				$end = get_field('дата_окончание');
			?>
			<div class="expansion_block expansion_item">
				<div class="expansion_img">
					<img src="<?php the_field('Картинка_выставки'); ?>" alt="">
				</div>
				<div class="expansion_content">
					<h2 class="expansion_title"><?php the_title(); ?></h2>
					<div class="expansion_descript">
						<p><?php the_field('описание_мероприятия'); ?></p>
					</div>
					<div class="expansion_btns">
						<?php if (get_field('ссылка_купить') != "/") : ?>
							<div class="news_buttons_main" data-btn-text="<?php echo get_field('текст_в_кнопке'); ?>">
								<?php echo get_field('ссылка_купить'); ?>
							</div>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="btn-ghost">Узнать больше</a>
					</div>
				</div>
				<div class="expansion_label">
					<span class="expansion_label_icon"></span>
					<?php echo format_event_dates($start, $end); ?>
				</div>
			</div>
			<?php
			endwhile;
			else: ?>
				<div class="non-archive">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/nfc-slash.svg">
				<p>Сейчас ничего не выставляется</p>
				</div>
			<?php
			endif;
			wp_reset_postdata();
			?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
