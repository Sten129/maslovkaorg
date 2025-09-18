<?php
$today = date('Ymd');

$args = array(
	'post_type' => 'vistavki',
	'posts_per_page' => 1,
	'meta_key' => 'дата_окончание',
	'meta_query' => array(
		array(
			'key' => 'дата_окончание',
			'value' => $today,
			'compare' => '>=',
		),
	),
	'orderby' => 'meta_value',
	'order' => 'ASC'
);

function format_event_dates($start, $end) {
	$months = array(
		'01' => 'Января',
		'02' => 'Февраля',
		'03' => 'Марта',
		'04' => 'Апреля',
		'05' => 'Мая',
		'06' => 'Июня',
		'07' => 'Июля',
		'08' => 'Августа',
		'09' => 'Сентября',
		'10' => 'Октября',
		'11' => 'Ноября',
		'12' => 'Декабря',
	);

	if ($start && $end) {
		$start_day = date('j', strtotime($start));
		$start_month = $months[date('m', strtotime($start))];

		$end_day = date('j', strtotime($end));
		$end_month = $months[date('m', strtotime($end))];

		return $start_day . ' ' . $start_month . ' – ' . $end_day . ' ' . $end_month;
	}
	return '';
}

$query = new WP_Query($args);
if ($query->have_posts()):
	while ($query->have_posts()): $query->the_post(); 
?>
<section id="expansion">
	<div class="wrapper">
		<div class="expansion_block">
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
					<?php
					$start = get_field('дата_проведения_начало');
					$end = get_field('дата_окончание');
					echo format_event_dates($start, $end);
					?>
				</div>
		</div>
	</div>
</section>
<?php
	endwhile;
	wp_reset_postdata();
endif;
?>
