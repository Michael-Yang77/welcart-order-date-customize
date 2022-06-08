<?php get_header(); ?>

<!-- page_head -->
<div class="page_head">
  <h1>クリスマスケーキ<div class="en">X'MAS CAKES</div>
  </h1>
  <!-- sns -->
  <?php //get_template_part( 'template-parts/sns' ); 
  ?>
  <!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

  <?php
    date_default_timezone_set('Asia/Tokyo');

    $today = date("Y-m-d H:i:s");
    $target_day = "2021-11-01 10:00:00";
  
    // target_dayが過去なら ========================================================================= 
    if(strtotime($today) < strtotime($target_day)): 
  ?>    
  <p style="text-align: center;"><img src="/assets/img/item/limited/xmas/xmas_dummy2_2021.jpg"></p>
  <style>
  .page_head{
    display: none;
  }
  </style>

  <?php else: //期間突入 ========================================================================= ?>

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
          <li>
            <a href="<?php the_permalink(); ?>">
              <figure class="image">
                <div class="category">
                  <?php
                  $label = [
                    "1566" => "X'MAS",
                    "1574" => "X'MAS",
                    "1577" => "X'MAS",
                    "1578" => "X'MAS",
                    "1579" => "X'MAS",
                    "1581" => "X'MAS",
                    "1599" => "X'MAS",
                    "1600" => "限定45台",
                    "1601" => "X'MAS",
                    "1609" => "X'MAS",
                  ];
                  ?>
                  <div class="label"><?php echo $label[$post->ID]; ?></div>
                </div>
                <?php usces_the_itemImage2(0, 300, 300, $post); ?>
              </figure>
              <?php usces_have_skus(); ?>
              <div class="info">

                <h3 class="name"><?php the_title(); ?></h3>
                <div class="price"><?php echo str_replace('¥', '', usces_the_itemPriceCr(0)); ?></div><?php if (usces_sku_num() > 1) : ?><div class="price_from">〜</div><?php endif; ?>
                <div class="like"><?php echo the_ratings_results(get_the_ID()); ?></div>
              </div>
            </a>
          </li>
          <!-- / 1set -->
          
        <?php endwhile; ?>
      </ul>
    <?php endif; ?>
  </div>
  <!-- / cakes_list -->

  <?php if (get_next_posts_link() || get_previous_posts_link()) : ?>
    <!-- page navigation -->
    <div class="btn_area">
      <?php if (get_previous_posts_link()) : ?>
        <div class="btn_to btn_to_prev"><?php previous_posts_link('&lt; 前のページ'); ?></div>
      <?php else : ?>
        <div class="btn_to btn_to_prev disabled">&lt; 前のページ</div>
      <?php endif; ?>

      <?php if (get_next_posts_link()) : ?>
        <div class="btn_to"><?php next_posts_link('次のページ &gt;'); ?></div>
      <?php else : ?>
        <div class="btn_to disabled">次のページ &gt;</div>
      <?php endif; ?>
    </div>
    <!-- / page navigation -->
  <?php endif; ?>

  <!-- xmas_info -->
  <div class="xmas_info">

    <div class="xmax_info_inner">

      <h3>クリスマスケーキWEB予約ご利用について<br>必ずお読みください。</h3>

      <div class="term_web">
        【WEB受付期間】　<br class="pc_disp_no">11月1日（月）～12月15日（水）<br>※売り切れ次第終了となります。ご了承ください。
      </div>

      <ol class="point">
        <li>
          WEB予約の方は店頭価格より<br>
          <span class="text_off">10%OFF</span>
          <span class="text_etc">※一部対象外の商品がございます。</span>
        </li>
        <li>
          WEB予約をご利用の方はポイントが加算されません。<br>
          また、ポイントのご利用もできません。
        </li>
        <li>
           キャンセル変更の受付は<strong>12月15日（水）</strong>までとなります。<br>
          それ以降のキャンセルは受付できません。ご了承ください。
        </li>
      </ol>

      <div class="how_to_buy">
        <h4>【ご購入方法】</h4>
        <ol>
          <li>①お好きなケーキを選びます。（ご注文するを押す）</li>
          <li>②受取日を選んでください。（購入手続きを押す）</li>
          <li>③購入手続きを済ませて完了です。</li>
        </ol>
      </div>

      <div class="term_shop">
        <h4>【店頭受付期間】</h4>
        <p>11月1日（月）～12月15日（水）</p>


      </div>

    </div>

  </div>
  <!-- / xmas_info -->
  <?php endif; // ========================================================================= ?>

</main>

<?php get_footer(); ?>