<?php get_header(); ?>

<!-- hero -->
<div class="hero">

	<?php
	/* = TOPスライドの取得と表示
				-------------------------------------------------- */
	$args = array(
		'post_type' => 'slide',
		'posts_per_page' => -1,
		'no_found_rows' => true,
	);
	$the_query = new WP_Query($args);
	if ($the_query->have_posts()) :
	?>


		<div class="slider">

			<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

				<?php
				$slide_img = get_field('画像');
				$slide_en = get_field('英字（黄）');
				$slide_category = get_field('英字（黒）');
				$slide_name = get_field('タイトル大');
				$slide_price = get_field('価格');
				$slide_url = get_field('リンク先url');
				?>

				<!-- 1set -->
				<div class="item">
					<?php if ($slide_url) : ?><a href="<?php echo $slide_url; ?>"><?php endif; ?>
					<img src="<? echo $slide_img; ?>" alt="<?php the_title(); ?>">
					<div class="info">
						<?php if ($slide_en) : ?>
							<div class="en"><?php echo $slide_en; ?></div>
						<?php endif; ?>
						<?php if ($slide_category) : ?>
							<div class="category"><?php echo $slide_category; ?></div>
						<?php endif; ?>
						<?php if ($slide_name) : ?>
							<h2 class="name"><?php echo $slide_name; ?></h2>
						<?php endif; ?>
						<?php if ($slide_price) : ?>
							<div class="price"><?php echo number_format($slide_price); ?></div>
						<?php endif; ?>
					</div>
					<?php if ($slide_url) : ?></a><?php endif; ?>
				</div>
				<!-- / 1set -->

			<?php endwhile; ?>


		<?php endif;
	wp_reset_postdata(); ?>

		</div>

		<div class="slide_counter">
			Loading...
		</div>

		<!-- sns -->
		<?php get_template_part('template-parts/sns'); ?>
		<!-- / sns -->

</div>
<!-- / hero -->

<!-- main -->
<main id="main">
	
	<div style="margin: 50px auto 20px; max-width: 960px;">
		<a href="https://sizenanne.thebase.in/" target="_blank"><img src="https://sizen-anne.com/assets/img/gift_bana.jpg" alt=""/></a>
	</div>

	<!-- cakes_list -->
	<div class="cakes_list">

		<?php
		/* = welcart商品の取得と表示
				-------------------------------------------------- */
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 8, // 最大表示数
			'cat' => 2, // welcart商品のみ
			//'category__and' => array( 2 ),
			//'category__in' => array( 2 ),          //(array) - カテゴリーIDを指定する。
			'category__not_in' => array( 20,21,22,24,25 ),      //まるピー,クリスマス,その他は除く
			'no_found_rows' => true,
            'meta_query'	=> array(
                array(
                    'key'		=> 'コメント',
                    'compare'	=> '=',
                    'value'		=> 'recommend',
                )
                )
		);
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) :
		?>

			<ul>

				<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
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
								<div class="price"><?php echo str_replace('¥', '', usces_the_itemPriceCr(0)); ?></div><?php if (usces_sku_num() > 1) : ?><div class="price_from">〜</div><?php endif; ?>
								<div class="like"><?php echo the_ratings_results(get_the_ID()); ?></div>
							</div>
						</a>
					</li>
					<!-- / 1set -->
				<?php endwhile; ?>


			</ul>
			<a class="btn_to" href="./item/">バースデーケーキ一覧を見る</a>

		<?php endif;
		wp_reset_postdata(); ?>

	</div>
	<!-- / cakes_list -->

	<!-- news -->
	<section id="news" class="section">
		<h2 class="title">イベント＆お知らせ</h2>
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

			<a class="btn_to" href="./information/">イベント＆お知らせ一覧を見る</a>

		<?php endif;
		wp_reset_postdata(); ?>

	</section>
	<!-- / news -->


	<!-- instagram -->
	<section id="instagram" class="section">
		<h2 class="title">インスタグラム</h2>

		<div class="insta_box">
			<dl id="insta_ichinomiya" class="insta_box_inner">
				<dt>
					<h3>一の宮店</h3>
				</dt>
				<?php echo do_shortcode('[instagram-feed user="anneshirleyichinomiyaten" num=4 cols=2 showfollow=false showbutton=false]'); ?>
			</dl>
			<dl id="insta_kiyosue" class="insta_box_inner">
				<dt>
					<h3>清末店</h3>
				</dt>
				<?php echo do_shortcode('[instagram-feed user="anneshirleykiyosueten" num=4 cols=2 showfollow=false showbutton=false]'); ?>
			</dl>
		</div>

	</section>
	<!-- / instagram -->

	<!-- login -->
	<section id="login" class="section">
		<div class="container">
			<h2 class="title">ログイン&新規登録</h2>
			<div class="login_entry">

				<!-- login box -->
				<div class="login">
					<h3 class="box_title">ログイン</h3>
					<div class="box_text">会員登録がお済みのお客様</div>

					<?php if (have_posts()) : usces_remove_filter(); ?>

						<?php do_action('usces_action_login_page_header'); ?>

						<?php if (usces_is_login()) : ?>

							<a class="btn btn_mypage" href="<?php echo esc_url(home_url('/')); ?>usces-member">ユーザーマイページ</a>

						<?php else : ?>

							<form name="loginform" id="loginform" action="<?php echo apply_filters('usces_filter_login_form_action', USCES_MEMBER_URL); ?>" method="post">

								<!-- -->
								<div class="form_group">
									<label>Mail</label>
									<input type="email" name="loginmail" id="loginmail" class="loginmail" value="<?php echo esc_attr(usces_remembername('return')); ?>" required>
									<!-- <input name="email" type="email" value="" placeholder="" required> -->
								</div>
								<!-- / -->

								<!-- -->
								<div class="form_group">
									<label>Password</label>
									<input type="password" name="loginpass" id="loginpass" class="loginpass" autocomplete="off">
									<!-- <input name="password" type="password" required> -->
								</div>
								<!-- / -->

								<!-- -->
								<div class="form_rememberme">
									<input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('memorize login information', 'usces'); ?>
								</div>
								<!-- / -->

								<?php //usces_login_button(); 
								?>
								<input class="btn btn_login" name="member_login" type="submit" value="ログイン">

								<?php do_action('usces_action_login_page_inform'); ?>


								<div class="lost_member">
									<a href="<?php usces_url('lostmemberpassword'); ?>" title="<?php _e('Did you forget your password?', 'usces'); ?>"><?php _e('Did you forget your password?', 'usces'); ?></a>
								</div>

							</form>

						<?php endif; ?>

						<?php do_action('usces_action_login_page_footer'); ?>

						<!-- <script type="text/javascript">
							<?php if (usces_is_login()) : ?>
								setTimeout(function() {
									try {
										d = document.getElementById('loginpass');
										d.value = '';
										//d.focus();
									} catch (e) {}
								}, 200);
							<?php else : ?>
								try {
									//document.getElementById('loginmail').focus();
								} catch (e) {}
							<?php endif; ?>
						</script> -->


					<?php else : ?>
						<p><?php _e('Sorry, no posts matched your criteria.', 'usces'); ?></p>
					<?php endif; ?>


				</div>
				<!-- / login box -->

				<!-- entry box -->
				<div class="entry">
					<h3 class="box_title">新規登録</h3>
					<div class="box_text">まだ会員登録されていないお客様</div>

					<a class="btn btn_entry" href="<?php echo esc_url(home_url('/')); ?>usces-member?page=newmember">新規会員登録</a>
				</div>
				<!-- / entry box -->

				<!-- line box sp 
				<div class="line_box_sp">
					<h3 class="box_title">LINEお友達登録</h3>
					<div class="box_text">アンシャーリーの特典がいっぱい</div>

					<a href="#"><img src="<?php echo esc_url(home_url('/')); ?>assets/img/btn_line_sp.png" alt="LINEお友達登録"></a>

					<p>LINEお友達登録していただいた方に<br>
						アンシャーリーのお店で使える500円OFFコードをプレゼントしております。</p>

				</div>
				<!-- / entry box -->

			</div>
		</div>
	</section>
	<!-- / login -->




</main>
<!-- / main -->

<!--
<div id="bnr_line">
	<div class="btn_close">×</div>
	<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo esc_url(home_url('/')); ?>assets/img/bnr_line.svg" alt="LINE友達になる"></a>
</div>
-->

<?php get_footer(); ?>