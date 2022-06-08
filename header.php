<!doctype html>
<html <?php language_attributes(); ?>>

<head>

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-TXWTM85');</script>
  <!-- End Google Tag Manager -->

  <meta charset="<?php bloginfo('charset'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="誕生日・記念日には下関の自然派菓子工房アン・シャーリーのバースデーケーキやドーナツ、焼き菓子をどうぞ。日本で一番愛されるケーキ屋を目指して、愛情を込めて作ったスイーツをお届けします。">

  <link href="<?php echo esc_url(home_url('/')); ?>assets/img/favicon.ico" rel="icon">
  <link href="<?php echo esc_url(home_url('/')); ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon" size="180x180">
  <link href="<?php echo esc_url(home_url('/')); ?>assets/css/normalize.css" rel="stylesheet" type="text/css">
  <link href="<?php echo esc_url(home_url('/')); ?>assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

  <!-- slick -->
  <link rel="stylesheet" type="text/css" href="<?php echo esc_url(home_url('/')); ?>assets/vendor/slick/slick.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo esc_url(home_url('/')); ?>assets/vendor/slick/slick-theme.css" />
  <script src="<?php echo esc_url(home_url('/')); ?>assets/vendor/slick/slick.min.js"></script>

  <!-- magnific-popup -->
  <link rel="stylesheet" type="text/css" href="<?php echo esc_url(home_url('/')); ?>assets/vendor/magnific-popup/magnific-popup.css">
  <script src="<?php echo esc_url(home_url('/')); ?>assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

  <!-- instafeed -->
  <script src="<?php echo esc_url(home_url('/')); ?>assets/vendor/instafeed/instafeed.min.js"></script>

  <!-- myscript -->
  <script src="<?php echo esc_url(home_url('/')); ?>assets/js/script.js?v=<?php echo time(); ?>"></script>

  <?php wp_head(); ?>

</head>

<?php
// 固定ページのslugを取得する
if (is_home()) {
  $body_id = 'home';
} else if (is_page()) {
  $body_id = get_post(get_the_ID())->post_name;
  if (is_parent_slug('shop')) {
    $body_id = 'shop';
  }
} elseif (is_archive()) {
  $body_id = 'news';

  if (is_post_type_archive('cakes') || is_tax('cakes_cat')) {
    $body_id = 'cakes';
  }

  //現カテゴリの配列を取得する
  $cat = get_the_category();
  $cat = $cat[0];
  //親カテゴリがあるか
  if ($cat->category_parent) { //category_parentは親カテゴリの「ID」
    //親カテゴリの配列を取得する
    $parent_cat = get_category($cat->category_parent);
    /*ここでget_the_category()を使わないのは、get_the_categoryは引数を取らないから。任意のIDのカテゴリ情報を配列で取得するにはget_category()を使用する。 */
    $parent_slug = $parent_cat->slug; //スラッグ取得
    $parent_name = $parent_cat->name; //名前取得
  }

  if (is_category('item') || $parent_slug === 'item') {
    $body_id = 'usces_item_archive';
  }
  if (is_category('marup') || is_category('marup2')) {
    $body_id = 'marup';
  }
  if (is_category('xmas') || is_category('xmas2')) {
    $body_id = 'xmas';
  }
  if (is_category('limited')) {
    $body_id = 'usces_item_archive';
  }  


} elseif (is_single()) {
  $body_id = 'news_detail';

  if (usces_is_item()) {
    $body_id = 'usces_item';
  }
}

?>

<body id="<?php echo $body_id; ?>" <?php if (!is_home()) : ?>class="pages" <?php endif; ?>>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TXWTM85"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <!-- wrapper -->
  <div id="wrapper">

    <!-- header -->
    <header id="header">
      <div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>">アン・シャーリー</a></div>
      <nav class="hnav">
        <ul>
          <li><a class="btn_mypage" href="<?php echo esc_url(home_url('/')); ?>usces-member">ユーザーマイページ</a></li>
          <li><a class="btn_cart" href="<?php echo esc_url(home_url('/')); ?>usces-cart">カートの中</a></li>
        </ul>
      </nav>
      <nav class="gnav">
        <ul>
          <li><a <?php if ($body_id === 'home') : ?>class="active" <?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>">HOME</a></li>
          <li><a <?php if ($body_id === 'news' || $body_id === 'news_detail') : ?>class="active" <?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>information">NEWS</a></li>
          <li class="dropdown"><a <?php if ($body_id === 'cakes') : ?>class="active" <?php endif; ?> href="javascript:void(0);">CAKES</a>
            
            <ul>
              <li><a href="<?php echo esc_url(home_url('/')); ?>cakes">ケーキメニュー一覧</a></li>
              <?php
                // ケーキメニューのカテゴリー一覧を自動取得
                $terms = get_terms( 'cakes_cat' );
                foreach($terms as $term):
              ?>
              <li><a href="<?php echo get_category_link($term->term_id); ?>">　- <?php echo esc_html($term->name);?></a></li>
              <?php endforeach; ?>
              <!--<li><a href="<?php echo esc_url(home_url('/')); ?>item/">お取り寄せメニュー一覧</a></li>-->
              <li><a href="https://sizenanne.thebase.in/" target="_blank">ギフトショップ</a></li>
              <li><a href="<?php echo esc_url(home_url('/')); ?>item/cakes">バースデーケーキ</a></li>

              <!--<li><a href="<?php echo esc_url(home_url('/')); ?>item/limited/xmas">　- クリスマスケーキ</a></li>-->

            </ul>
          </li>
          <li class="dropdown"><a <?php if ($body_id === 'shop') : ?>class="active" <?php endif; ?> href="javascript:void(0);">SHOP</a>
            <ul>
              <li><a href="<?php echo esc_url(home_url('/')); ?>shop/kiyosue">下関清末店</a></li>
              <li><a href="<?php echo esc_url(home_url('/')); ?>shop/ichinomiya">下関一の宮店</a></li>
            </ul>
          </li>
          <li><a <?php if ($body_id === 'about') : ?>class="active" <?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>about">ABOUT</a></li>
          <li><a <?php if ($body_id === 'recruit') : ?>class="active" <?php endif; ?> href="<?php echo esc_url(home_url('/')); ?>recruit">RECRUIT</a></li>

          <!-- only mobile -->
          <li class="gnav_extra">
            <div class="fnav">
              <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>guide">ショッピングガイド</a></li>
                <li><a href="<?php echo esc_url(home_url('/')); ?>privacy">プライバシーポリシー</a></li>
                <li><a href="<?php echo esc_url(home_url('/')); ?>law">特定商取引法に関する表記</a></li>
              </ul>
            </div>
            <div class="sns">
              <ul>
                <li><a class="btn_facebook" href="https://www.facebook.com/sizenanne/" target="_blank">facebook</a></li>
                <li><a class="btn_twitter" href="https://twitter.com/ANNESHIRLEY1993" target="_blank">twitter</a></li>
                <li><a class="btn_instagram" href="https://www.instagram.com/anneshirleykiyosueten/" target="_blank">Instagram</a></li>
              </ul>　　 　　　
            </div>
          </li>
          <!-- / only mobile -->

        </ul>
      </nav>
      <a class="btn_entry" href="<?php echo esc_url(home_url('/')); ?>usces-member?page=newmember">
        新規登録
      </a>
    </header>
    <!-- / header -->