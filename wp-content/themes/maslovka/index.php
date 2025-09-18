<?php 
/* Template Name: Maslovka Main */
?>
<!-- Web developed in std. www.rubic-on.com -->

	<?php get_header(); ?>	
	<?php get_template_part( 'components/topmenu' ); ?>

	<?php
	// Для вывода ACF полей
	$frontpage_id = get_option(14);
	$frontpage = get_post($frontpage_id);
	setup_postdata($frontpage);
	?>
	<main id="main">
		<?php get_template_part( 'components/home-diamond' ); ?>
		<h1 class="main_title"><?php the_title(); ?></h1>
		<div class="main_adress">Музейный центр<br>на Верхней Масловке, 3</div>
	</main>
	<?php get_template_part( 'components/home-sobitiya' ); ?>

	<?php get_template_part( 'components/home-vistavki' ); ?>

	<section id="promovideo">
		<div class="wrapper">
			<div class="promovideo_block">
				<video autoplay loop muted playsinline>
					<source src="<?php the_field('видео_для_главной'); ?>" type="video/mp4">
					Ваш браузер не поддерживает воспроизведение видео.
				</video>
			</div>
		</div>
	</section>
	<section id="maininformer">
		<div class="wrapper">
			<div class="maininformer_block">
				<div class="maininformer_text">
					«История Городка открывается для каждого ценителя искусства. Это место куда хочется возвращаться за
					вдохновением и&nbsp;общением: без спешки, в разное время и c разным настроением».
				</div>
				<div class="maininformer_author">
					<span class="maininformer_author-name">
						<?php the_field('автор'); ?>
					</span>
					<span class="maininformer_author-desc">
						<?php the_field('должность_автора'); ?>
					</span>
				</div>
			</div>
		</div>
	</section>
	<section id="cards">
		<div class="wrapper">
			<div class="cards_list">

				<a href="/коллекция" class="cards_item" style="background-color: #8A5E3B;">
					<div class="cards_content">
						<span class="cards_header">Коллекция</span>
						<span class="cards_descript">
							Артефакты, документальные и фото архивы, живопись, графика, скульптура.
						</span>
					</div>
					<div class="cards_bg">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/collection_img.png" alt="">
					</div>
					<div class="cards_arrow">
						<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M14.2109 8.33691L9.28906 13.2588L8.9668 13.5811L8.29297 12.9072L8.61523 12.585L12.7461 8.4541H1.93555H1.4668V7.5166H1.93555H12.7461L8.61523 3.41504L8.29297 3.06348L8.9668 2.41895L9.28906 2.74121L14.2109 7.66309L14.5332 7.98535L14.2109 8.33691Z"
								fill="black" />
						</svg>
					</div>
				</a>
				<a href="/художники/" class="cards_item" style="background-color: #26272B;">
					<div class="cards_content">
						<span class="cards_header">Художники</span>
						<span class="cards_descript">
							Они остались в памяти, в работах и атмосфере, которую мы бережно сохраняем.
						</span>
					</div>
					<div class="cards_bg">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/hudozniki_img.png" alt="">
					</div>
					<div class="cards_arrow">
						<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M14.2109 8.33691L9.28906 13.2588L8.9668 13.5811L8.29297 12.9072L8.61523 12.585L12.7461 8.4541H1.93555H1.4668V7.5166H1.93555H12.7461L8.61523 3.41504L8.29297 3.06348L8.9668 2.41895L9.28906 2.74121L14.2109 7.66309L14.5332 7.98535L14.2109 8.33691Z"
								fill="black" />
						</svg>
					</div>
				</a>
				<a href="https://t.me/gorodokMaslovka" class="cards_item card_tg" style="background-color: #D8EAEE;">
					<div class="cards_content">
						<span class="cards_header">Телеграм-канал</span>
						<span class="cards_descript">
							Анонсы событий и выставок, редкие кадры и открытые комментарии.
						</span>
					</div>
					<div class="cards_bg">
						<img class="cards_bg_desktop" src="<?php echo get_template_directory_uri(); ?>/assets/img/mosaic_img.png" alt="">
						<img class="cards_bg_mobile" src="<?php echo get_template_directory_uri(); ?>/assets/img/telegram-channel_mob.png" alt="">
					</div>
					<div class="cards_arrow">
						<svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M14.2109 8.33691L9.28906 13.2588L8.9668 13.5811L8.29297 12.9072L8.61523 12.585L12.7461 8.4541H1.93555H1.4668V7.5166H1.93555H12.7461L8.61523 3.41504L8.29297 3.06348L8.9668 2.41895L9.28906 2.74121L14.2109 7.66309L14.5332 7.98535L14.2109 8.33691Z"
								fill="black" />
						</svg>
					</div>
				</a>
			</div>
		</div>
	</section>
	<?php wp_reset_postdata(); ?>
	<script>
		const zonesConfig = [
		{ left: '<?php the_field('left_1'); ?>', right: '<?php the_field('правое_3'); ?>' },
		{ left: '<?php the_field('left_1'); ?>', right: '<?php the_field('правое_1'); ?>' },
		{ left: '<?php the_field('left_2'); ?>', right: '<?php the_field('правое_1'); ?>' },
		{ left: '<?php the_field('left_2'); ?>', right: '<?php the_field('правое_2'); ?>' },
		{ left: '<?php the_field('left_3'); ?>', right: '<?php the_field('правое_2'); ?>' },
		{ left: '<?php the_field('left_3'); ?>', right: '<?php the_field('правое_3'); ?>' },
		{ left: '<?php the_field('left_4'); ?>', right: '<?php the_field('правое_3'); ?>' },
		{ left: '<?php the_field('left_4'); ?>', right: '<?php the_field('правое_4'); ?>' }
	];
	</script>
	<?php get_footer(); ?>
