<?php get_header(); ?>

<!-- page_head -->
<div class="page_head">
		<h1>お知らせ<div class="en">INFORMATION</div></h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
	</div>
	<!-- / page_head -->

<!-- main -->
<main id="main">

	<!-- page tab menu -->
	<ul class="tabs">
		<li><a <?php if(is_category('information')): ?>class="active"<?php endif; ?> href="<?php echo esc_url( home_url( '/' ) ); ?>/information">全て</a></li>
		<li><a <?php if(is_category('event')): ?>class="active"<?php endif; ?> href="<?php echo esc_url( home_url( '/' ) ); ?>/information/event">イベント</a></li>
		<li><a <?php if(is_category('news')): ?>class="active"<?php endif; ?> href="<?php echo esc_url( home_url( '/' ) ); ?>/information/news">ニュース</a></li>
	</ul>
	<!-- / page tab menu -->

	<!-- news -->
	<section class="section">
		<?php if (have_posts()) : ?>
			<ul>
				<?php while (have_posts()) : the_post(); ?>
					<!-- 1set -->
          <li class="new">
            <a href="<?php the_permalink(); ?>">
              <figure class="image">
                <div class="category">
                  <div class="label">EVENT</div>
                </div>
                <?php if (has_post_thumbnail()) : ?>
									<?php the_post_thumbnail(); ?>
								<?php else : ?>
									<img src="<?php echo catch_that_image(); ?>" alt="<?php the_title(); ?>" />
								<?php endif; ?>
              </figure>
              <div class="info">
                <h3 class="list_title"><?php the_title(); ?></h3>
                <time class="time"><?php the_time('Y.m.d'); ?></time>
                <div class="excerpt"><?php the_excerpt(); ?></div>
                <div class="view"><?php the_views(); ?></div>
                <div class="btn_more">MORE</div>
              </div>
            </a>
          </li>
          <!-- / 1set -->
				<?php endwhile; ?>
			</ul>

		<?php endif; ?>
	</section>

</main>

<?php get_footer(); ?>