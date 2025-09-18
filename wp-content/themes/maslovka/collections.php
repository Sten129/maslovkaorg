<?php 
/* Template Name: Коллекция */
?>

<?php get_header(); ?>	

<header id="header">
	<div class="wrapper">
		<div class="page_logo">
			<a href="/"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo_black.png" alt=""></a>
		</div>
		<?php get_template_part( 'components/topmenu' ); ?>

		<div class="header_container">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logomuseim.png" alt="" class="header_image">
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

		<div class="collection_items">
			<?php
			$collections_query = new WP_Query([
				'post_type' => 'collections',
				'posts_per_page' => -1, //
			]);

			if ($collections_query->have_posts()) :
				while ($collections_query->have_posts()) : $collections_query->the_post();
					$thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
			?>
					<a href="<?php the_permalink(); ?>" class="collection_item">
						<div class="collection_img">
							<?php if ($thumb): ?>
								<img src="<?php echo esc_url($thumb); ?>" alt="<?php the_title(); ?>">
							<?php endif; ?>
						</div>
						<span><?php the_title(); ?></span>
					</a>
			<?php
				endwhile;
				wp_reset_postdata();
			else :
				echo '<p>Коллекции не найдены.</p>';
			endif;
			?>
		</div>

	</div>
</main>


<?php get_footer(); ?>
