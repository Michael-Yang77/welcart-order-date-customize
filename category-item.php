<?php get_header(); ?>

<!-- page_head -->
<div class="page_head">
  <h1>バースデーケーキ<div class="en">BIRTHDAY CAKES</div>
  </h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

  <!-- page tab menu 
  <ul class="tabs">
    <li><a <?php if(is_category('item')): ?>class="active"<?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>item">全て</a></li>
    <!--<li><a <?php if(is_category('gift')): ?>class="active"<?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>item/gift">ギフト</a></li>-
    <li><a <?php if(is_category('cakes')): ?>class="active"<?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>item/cakes">バースデーケーキ</a></li>

    <!-- limited marup 
    <!-- <li><a <?php if(is_category('marup')||is_category('marup2')): ?>class="active"<?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>item/limited/marup/">期間限定</a></li> 
  </ul>-->
  <!-- / page tab menu -->

  <!-- cakes_list -->
  <div class="cakes_list">

    <?php if (have_posts()) : ?>
      <ul>
        <?php while (have_posts()) : the_post(); ?>
          <?php
          usces_remove_filter();
          usces_the_item();

          $cat = get_the_category($post->ID);
					$cat_slug = $cat[0]->slug;
          ?>
          <!-- 1set -->
          <li <?php if (is_new_post(get_the_time('U'))) : ?>class="new" <?php endif; ?>>
            <a href="<?php the_permalink(); ?>">
              <figure class="image">
                <div class="category">
                  <div class="label"><?php echo strtoupper($cat_slug); ?></div>
                </div>
                <?php usces_the_itemImage2(0, 300, 300, $post); ?>
              </figure>
              <?php usces_have_skus(); ?>
							<div class="info">
								
								<h3 class="name"><?php the_title(); ?></h3>
								<div class="price"><?php echo str_replace('¥','',usces_the_itemPriceCr(0)); ?></div><?php if (usces_sku_num() > 1): ?><div class="price_from">〜</div><?php endif; ?>
									<div class="like"><?php echo the_ratings_results( get_the_ID() ); ?></div>
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
			<div class="btn_to btn_to_prev"><?php previous_posts_link('&lt; 前のページ'); ?></div>
			<?php else: ?>
			<div class="btn_to btn_to_prev disabled">&lt; 前のページ</div>
			<?php endif; ?>	

			<?php if(get_next_posts_link()): ?>
			<div class="btn_to"><?php next_posts_link('次のページ &gt;'); ?></div>
			<?php else: ?>
			<div class="btn_to disabled">次のページ &gt;</div>
			<?php endif; ?>	
		</div>
		<!-- / page navigation -->
		<?php endif; ?>

</main>

<?php get_footer(); ?>