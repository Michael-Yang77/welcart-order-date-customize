<?php get_header(); ?>

<!-- page_head -->
<div class="page_head">
  <h1>まるごとピーチ<div class="en">MARUP</div>
  </h1>
  <!-- sns -->
  <?php get_template_part('template-parts/sns'); ?>
  <!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

  <h2 class="title_marup">店頭受取り日にてご注文ください</h2>

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
          <!-- <li <?php if (is_new_post(get_the_time('U'))) : ?>class="new" <?php endif; ?>> -->
          <li>
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
                <div class="price"><?php echo str_replace('¥', '', usces_the_itemPriceCr(0)); ?></div><?php if (usces_sku_num() > 1) : ?><div class="price_from">〜</div><?php endif; ?>
                <!-- <div class="like"><?php echo the_ratings_results(get_the_ID()); ?></div> -->
              </div>
            </a>
          </li>
          <!-- / 1set -->
        <?php endwhile; ?>

        <li>
          <a href="javascript:void(0);" style="cursor: default;">
            <figure class="image">
              <img src="/assets/img/item/limited/marup/bnr_marup_hanbai50@2x.png">
            </figure>
          </a>
        </li>

      </ul>
    <?php else: ?>
      <p style="text-align: center; font-weight:bold">6月25日・26日予約販売開始！<br>お待ちください。</p>
    <?php endif; ?>
  </div>
  <!-- / cakes_list -->

  <section class="section">
    <h2 class="title_marup">ネット予約販売について</h2>
    <p>お客様に、良い状態でお届けできるように予約販売いたします。<br>予約日と受取日をご確認のうえご注文ください。</p>

    <div class="date_list">
      <ul>
        <li><img src="/assets/img/item/limited/marup/marup_day_01@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_02@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_03@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_04@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_05@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_06@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_07@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_08@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_09@2x.png"></li>
        <li><img src="/assets/img/item/limited/marup/marup_day_10@2x.png"></li>
      </ul>
    </div>

    <a class="btn_to_line" href="https://line.me/R/ti/p/%40593lcbpr" target="_blank">アンシャーリー公式LINEに、登録していただくとお知らせが届きます。</a> 

  </section>

</main>

<?php get_footer(); ?>