<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
	<!-- page_head -->
	<div class="page_head">
		<h1>お知らせ<div class="en">INFORMATION</div></h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
<?php
// カテゴリー情報を取得する
  $category = get_the_category();
  $cat = $category[0];
  $cat_name = $cat->name;
  $cat_id = $cat->cat_ID;
  $cat_slug = $cat->slug;
?>
	</div>
	<!-- / page_head -->

	<!-- main -->
	<main id="main">

		<!-- post -->
		<article class="post">

			<header class="post_header">
				<time class="time"><?php the_time('Y.m.d'); ?></time>
				<h1 class="post_title"><?php the_title(); ?></h1>

				<div class="category">
					<div class="label"><?php echo strtoupper($cat_slug); ?></div>
				</div>

				<div class="view"><?php the_views(); ?></div>
			</header>

			<main class="post_main">
				<?php the_content(); ?>
			</main>

			<footer class="post_footer">
				<ul>
					<?php if (get_previous_post()) : ?>
					<li><?php previous_post_link('%link', '&lt;&lt; PREV'); ?></li>
					<?php else : ?>
					<li>&lt;&lt; PREV</li>
					<?php endif; ?>
					<li><a href="<?php echo esc_url(home_url('/')); ?>information">一覧へ</a></li>

					<?php if (get_next_post()) : ?>
					<li><?php next_post_link('%link', 'NEXT &gt;&gt;'); ?></li>
					<?php else : ?>
					<li>NEXT &gt;&gt;</li>
					<?php endif; ?>
				</ul>
			</footer>

		</article>
		<!-- / post -->

		<!-- news_list -->
		<section class="news_list">
    <?php
		/* = お知らせ(投稿)の取得と表示
			-------------------------------------------------- */
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 10,
			'cat' => -2, // welcart商品は除く
			'no_found_rows' => true,
		);
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) :
		?>
        <ul>
				<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
					<?php usces_remove_filter(); ?>
					<?php usces_the_item(); ?>
					<?php
					$cat = get_the_category($post->ID);
					$cat_slug = $cat[0]->slug;
					?>
					<!-- 1set -->
					<li <?php if (is_new_post(get_the_time('U'))) : ?>class="new" <?php endif; ?>>
						<a href="<?php the_permalink(); ?>">
							<div class="category">
								<div class="label"><?php echo strtoupper($cat_slug); ?></div>
								<div class="view"><?php the_views(); ?></div>
							</div>
							<figure class="image">
								<?php if (has_post_thumbnail()) : ?>
									<?php the_post_thumbnail(); ?>
								<?php else : ?>
									<img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>" />
								<?php endif; ?>
							</figure>
							<div class="info">
								<time class="time"><?php echo the_time('Y.m.d'); ?></time>
								<h3 class="list_title"><?php the_title(); ?></h3>
							</div>
						</a>
					</li>
					<!-- / 1set -->
				<?php endwhile; ?>

      </ul>
      
      <?php endif;
		wp_reset_postdata(); ?>

      </section>
      <!-- / news_list -->

	</main>
	<!-- / main -->

<?php endwhile; // End of the loop. 
?>

<?php get_footer(); ?>