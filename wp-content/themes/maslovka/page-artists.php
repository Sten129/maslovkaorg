<?php 
/* Template Name: Художники */
?>
<?php get_header(); ?>



<header id="header">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>
		<h1 class="page_title page_title_bg">
			<?php the_title(); ?>
		</h1>
	</div>
</header>

<?php
// фильтрация по букве.
$letter = isset($_GET['letter']) ? mb_strtoupper($_GET['letter']) : '';
$category = isset($_GET['category']) ? sanitize_title($_GET['category']) : '';

$search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

$args = [
	'post_type' => 'post',
	'posts_per_page' => -1,
	'meta_key' => 'artist_letter',
	'orderby' => ['meta_value' => 'ASC', 'title' => 'ASC'],
	'order' => 'ASC'
];

if ($letter) {
	$args['meta_query'][] = [
		'key' => 'artist_letter',
		'value' => $letter,
		'compare' => '='
	];
}

if ($category) {
	$args['category_name'] = $category;
}

if (!empty($search)) {
	$args['s'] = $search;
}

$query = new WP_Query($args);
?>

<main id="page">
		<div class="wrapper">

			<form id="form-search" method="get" action="">
				<div class="form-input">
					<input id="search-in" type="text" name="search" placeholder="Найти по ФИО..." value="<?php echo esc_attr($_GET['search'] ?? ''); ?>">
					<button class="form-input_btn" id="search-button"></button>
				</div>
			</form>

			<div id="filter-cats">
				<?php foreach (['А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'] as $char): ?>
					<a href="?letter=<?php echo $char; ?>"><?php echo $char; ?></a>
				<?php endforeach; ?>
			</div>

			<div id="filter-tags">
				<?php
				$categories = get_categories(['hide_empty' => false]);
				foreach ($categories as $cat):
				?>
					<a href="?category=<?php echo esc_attr($cat->slug); ?>" class="btn-tag btn-letter"><?php echo esc_html($cat->name); ?></a>
				<?php endforeach; ?>
			</div>

			<div class="artists_block">
				<?php
				$current_letter = '';

				if ($query->have_posts()):
					while ($query->have_posts()): $query->the_post();
						$letter = get_post_meta(get_the_ID(), 'artist_letter', true);

						if ($letter !== $current_letter):
							// Закрытие предыдущего блока, если был
							if ($current_letter !== ''): ?>
								</div>
							</div>
							<?php endif;
							$current_letter = $letter;
							?>

							<div class="artists_block">
								<div class="artists_cat" id="cat-<?php echo esc_attr($letter); ?>">
									<?php echo esc_html($letter); ?>
								</div>
								<div class="artists_cards">
						<?php endif; ?>

						<a href="<?php the_permalink(); ?>" class="artists_card">
							<div class="artists_card-name">
								<span class="artists_card-surname"><?php the_title(); ?></span>
								<?php 
								if (get_field('дополнительное_наименование_автора') != ""):
								?>
								<?php echo get_field('дополнительное_наименование_автора') ?>
								<?php endif; ?>
							</div>
							<div class="artists_card-img">
								<?php if (has_post_thumbnail()): ?>
									<img src="<?php echo the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
								<?php endif; ?>
							</div>
						</a>

					<?php endwhile; ?>

					</div>
				</div>

				<?php
					wp_reset_postdata();
				else:
					echo '
					<div class="non-archive">
					<img src="' . get_template_directory_uri() . '/assets/img/icons/user-large-slash.svg">
					<p>Художники не найдены!</p>
					</div>
					';
				endif;
				?>

			</div>
		</div>

	</main>
	<script>
		document.addEventListener('DOMContentLoaded', function () {

			const params = new URLSearchParams(window.location.search);
			const currentCategory = params.get('category');

			if (currentCategory) {
				const currentCategoryLower = currentCategory.toLowerCase();
				const links = document.querySelectorAll('.btn-tag');

				links.forEach(link => {
					const url = new URL(link.href, window.location.origin);
					const linkCategory = url.searchParams.get('category');

					if (linkCategory && linkCategory.toLowerCase() === currentCategoryLower) {
						link.classList.add('active');
					}
				});
			}

			const searchButton = document.getElementById('search-button');
			const searchForm = document.getElementById('form-search');

			if (searchButton && searchForm) {
				searchButton.addEventListener('click', function () {
				searchForm.submit();
			});
			}
		});
	</script>
<?php get_footer(); ?>
