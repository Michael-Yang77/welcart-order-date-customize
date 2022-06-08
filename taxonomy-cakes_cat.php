<?php get_header(); ?>

<!-- page_head -->
<div class="page_head">
	<h1>ケーキメニュー<div class="en">CAKES</div></h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

	<!-- page tab menu -->
	<ul class="tabs">

		<li><a <?php if(is_post_type_archive( 'cakes' ) ): ?>class="active"<?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>cakes">全て</a></li>
		<?php
      // ケーキメニューのカテゴリー一覧を自動取得
      $terms = get_terms( 'cakes_cat' );
      foreach($terms as $term):
    ?>
    <li><a <?php if(is_tax( 'cakes_cat', $term->slug)): ?>class="active"<?php endif; ?> href="<?php echo get_category_link($term->term_id); ?>"><?php echo esc_html($term->name);?></a></li>
		<?php endforeach; ?>
	</ul>
	<!-- / page tab menu -->

	<!-- cakes_list -->
	<div class="cakes_list">

		<?php if (have_posts()) : ?>
		<ul>
			<?php while (have_posts()) : the_post(); ?>
			<!-- 1set -->
			<li>
				<?php if (has_post_thumbnail()) : ?>
				<a href="<?php echo wp_get_attachment_image_src (get_post_thumbnail_id (), 'img600' , true )[0]; ?>">
				<?php else : ?>
				<a href="<?php echo catch_that_image(); ?>">
				<?php endif ; ?>
					<figure class="image">
						<?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('', array( 'title' => '<strong>'.get_the_title().'</strong><br>'.get_field('コメント') )); ?>
            <?php else : ?>
              <img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>" />
          	<?php endif ; ?>
					</figure>
					<div class="info">

						<h3 class="name"><?php the_title(); ?></h3>
						<div class="price"><?php the_field('価格'); ?></div>
					</div>
				</a>
			</li>
			<!-- / 1set -->
			<?php endwhile; ?>
		</ul>
		<?php endif; ?>
	</div>
	<!-- / cakes_list -->

	<?php if(get_next_posts_link() || get_previous_posts_link()): ?>
		<!-- page navigation -->	
		<div class="btn_area">
			<?php if(get_previous_posts_link()): ?>
			<div class="btn_to btn_to_prev"><?php previous_posts_link('前のページ'); ?></div>
			<?php else: ?>
			<div class="btn_to btn_to_prev disabled">前のページ</div>
			<?php endif; ?>	

			<?php if(is_category()): ?>
			<div class="btn_to btn_to_list"><a href="<?php echo esc_url(home_url('/')); ?>blog/">一覧に戻る</a></div>
			<?php endif; ?>	

			<?php if(get_next_posts_link()): ?>
			<div class="btn_to"><?php next_posts_link('次のページ'); ?></div>
			<?php else: ?>
			<div class="btn_to disabled">次のページ</div>
			<?php endif; ?>	
		</div>
		<!-- / page navigation -->
		<?php endif; ?>

</main>

<?php get_footer(); ?>