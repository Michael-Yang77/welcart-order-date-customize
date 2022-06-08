<?php

/* = welcart商品詳細画面　single
------------------------------- */

get_header(); ?>
<?php
$category = get_the_category();
$cat_id   = $category[0]->cat_ID;
$cat_name = $category[0]->cat_name;
$cat_slug = $category[0]->category_nicename;
?>

<?php

// オプション部に割り当てるclass/idのためのマスター（日本語->英語）
$arr_options = [
	'ケーキお祝いメッセージ(25文字まで)' => 'cake_message',
	'ケーキお祝いメッセージネームプレート' => 'cake_nameplate',
	'ケーキお祝いメッセージネームプレート（ベアー）' => 'cake_nameplate_b',
	'ケーキお祝いメッセージネームプレート（うさぎ）' => 'cake_nameplate_bn',	

	'ケーキ ろうそく' => 'cake_candle',

	'ケーキ ろうそく 通常（大）' => 'cake_candle_l',
	'ケーキ ろうそく 通常（小）' => 'cake_candle_s',

	'ケーキ ナンバーズキャンドル(1本目)' => 'cake_numberscandle',
	'ケーキ ナンバーズキャンドル(2本目)' => 'cake_numberscandle',
	'ケーキ ナンバーズキャンドル(3本目)' => 'cake_numberscandle',
	'ケーキ ナンバーズキャンドル(4本目)' => 'cake_numberscandle',
	'ケーキ ナンバーズキャンドル(5本目)' => 'cake_numberscandle',

	'ケーキ受取希望店舗' => 'cake_shop',

	'のし種類' => 'noshi_shurui',
	'のし書き' => 'noshi_gaki',

	'箱(分け方を記入してください)' => 'marup_box',

	'バースデイプレート' => 'birthday_plate',
];
?>
<!-- wc_item_single myscript -->
<script>

jQuery(function($) {

/* = 商品詳細：フォームのカスタマイズ
--------------------------------------- */

// 入力フォームのタイプを操作する
$('#usces_item .post .skuquantity').attr('type', 'number');

// 各オプションフォームの表記をカスタマイズする
// お祝いメッセージ
$('.dt_cake_message').html('お祝いメッセージ(20〜25文字)');
$('.dd_cake_message').append('<div class="comment" style="font-size:13px; padding:5px 0px;">※ひらがなまたはカタカナで入力してください</div>');

// ネームプレート
$('.dt_cake_nameplate').html('メッセージネームプレート');
$('.dt_cake_nameplate_b').html('メッセージネームプレート（ベアー）');
$('.dt_cake_nameplate_bn').html('メッセージネームプレート（うさぎ）');

// ろうそく
$('.dt_cake_candle').html('ろうそく');
//$('.dd_cake_candle').append('<div class="comment" style="font-size:13px; padding:5px 0px;">※通常(0円)のろうそくの数は店頭にて承ります</div>');
var candle_comment_normal = '下から大・小の必要本数を選択してください。<br>14才なら…大「1本」小「4本」';
var candle_comment_numbers = '下から必要な数字のキャンドルを選択してください。<br>14才なら…1本目「1のキャンドル」2本目「4のキャンドル」';
$('.dd_cake_candle').append('<div class="comment" style="font-size:13px; padding:5px 0px;">'+ candle_comment_normal +'</div>');

// ナンバーズキャンドル
$('.dt_cake_candle_l, .dt_cake_candle_s').each(function(index, elm) {
	dt_cake_numberscandle = $(elm).html();
	dt_cake_numberscandle = dt_cake_numberscandle.replace('ケーキ ','');
	$(elm).html(dt_cake_numberscandle);
});

// ナンバーズキャンドル
$('.dt_cake_numberscandle').each(function(index, elm) { 
	dt_cake_numberscandle = $(elm).html();
	dt_cake_numberscandle = dt_cake_numberscandle.replace('ケーキ ','');
	$(elm).html(dt_cake_numberscandle);
});

// ナンバーズキャンドル
$('.dt_cake_shop').html('受取希望店舗');

/* = 商品詳細：オプションのカスタマイズ
--------------------------------------- */
// ナンバーズキャンドル枠を非表示（初期化）
$('.dt_cake_numberscandle').hide();
$('.dd_cake_numberscandle').hide();

// ろうそくの種類が選択(変更)されたら（通常 or ナンバーズ）
$('.dd_cake_candle select').change(function() {
	//$('.dd_cake_candle .comment').toggle();

	// 通常のろうそく
	$(this).parents('dl').find('.dt_cake_candle_l, .dt_cake_candle_s, .dd_cake_candle_l, .dd_cake_candle_s').slideToggle();
	$(this).parents('dl').find('.dt_cake_candle_l, .dt_cake_candle_s, .dd_cake_candle_l, .dd_cake_candle_s').val('--- 不要 ---');

	// ナンバーズキャンドル
	$(this).parents('dl').find('.dt_cake_numberscandle').slideToggle();
	$(this).parents('dl').find('.dd_cake_numberscandle').slideToggle(function () {
		if ($(this).is(':visible')) {
			$(this).parents('dl').find('.dd_cake_candle .comment').html(candle_comment_numbers);
		} 
		else {
			// リセット
			$(this).parents('dl').find('.dd_cake_candle .comment').html(candle_comment_normal);
			$(this).parent().find('.dd_cake_numberscandle select').val('--- 不要 ---');
		}
	});
});

// ネームプレートの選択肢に金額表示を反映する（初期化）
var nameplates = $('.dd_cake_nameplate select, .dd_cake_nameplate_b select').children();
for (var i=0; i<nameplates.length; i++) {

	var sel_text = nameplates.eq(i).text();
	if(sel_text==='1. ハート（大）'){
		sel_text = sel_text + '(216円 税込)';

		<?php if($post->ID==218): //ID:218 ミニーメイの場合 ?>
			sel_text = sel_text + '　※６号はこちら';
		<?php elseif($post->ID==496): //ID:496 ハート生クリームいちごの場合 ?>
			sel_text = sel_text + '　※６号はこちら';	
		<?php elseif($post->ID==200 || $post->ID==688): //ID:200/688夏季 ハート生クリーム（フルーツ）の場合 ?>
			sel_text = sel_text + '　※６号はこちら';		
		<?php endif; ?>	

	}
	else if(sel_text==='2. ハート（小）'){
		sel_text = sel_text + '(108円 税込)';

		<?php if($post->ID==218): //ID:218 ミニーメイの場合 ?>
			sel_text = sel_text + '　※４号・５号はこちら';
		<?php elseif($post->ID==496): //ID:496 ハート生クリームいちごの場合 ?>
			sel_text = sel_text + '　※４号・５号はこちら';
		<?php elseif($post->ID==200 || $post->ID==688): //ID:200/688夏季 ハート生クリーム（フルーツ）の場合 ?>
			sel_text = sel_text + '　※５号はこちら';		
		<?php endif; ?>	

	}
	else if(sel_text==='3. スクエア'){
		sel_text = sel_text + '(0円)';
	}
	else if(sel_text==='ネームプレート（ベアー）'){
		sel_text = sel_text + '(0円)';
	}
	else if(sel_text==='ネームプレート（うさぎ）'){
		sel_text = sel_text + '(0円)';
	}	

	nameplates.eq(i).text(sel_text);
}

var nameplate_comment = '';
<?php if($post->ID==218): //ID:218 ミニーメイの場合 ?>
nameplate_comment = '※６号は「1. ハート（大）」をお選びください<br>※４号・５号は「2. ハート（小）」をお選びください';
<?php elseif($post->ID==496): //ID:496 ハート生クリームいちごの場合 ?>
nameplate_comment = '※６号は「1. ハート（大）」をお選びください<br>※４号・５号は「2. ハート（小）」をお選びください';
<?php elseif($post->ID==200 || $post->ID==688): //ID:200/688夏季 ハート生クリーム（フルーツ）の場合 ?>
nameplate_comment = '※６号は「1. ハート（大）」をお選びください<br>※５号は「2. ハート（小）」をお選びください';
<?php endif; ?>
$('.dd_cake_nameplate').append('<div class="comment" style="font-size:13px; padding:5px 0px; color:red">'+ nameplate_comment +'</div>');

// ろうそくの選択肢に金額表示を反映する（初期化）
var cakecandles = $('.dd_cake_candle select').children();
for (var i=0; i<cakecandles.length; i++) {

	var sel_text = cakecandles.eq(i).text();
	if(sel_text==='通常'){
		sel_text = sel_text + '(0円)';
	}
	else if(sel_text==='ナンバーズキャンドル'){
		sel_text = sel_text + '(1本121円 税込)';
	}
	cakecandles.eq(i).text(sel_text);
}

// 通常のろうそくの選択肢に単位を反映する（初期化）
var candles = $('.dd_cake_candle_l select, .dd_cake_candle_s select').children();
for (var i=0; i<candles.length; i++) {

	var sel_text = candles.eq(i).text();
	if(sel_text!=='--- 不要 ---'){
		sel_text = sel_text + '本';
	}
	
	candles.eq(i).text(sel_text);
}

// ナンバーズキャンドルの選択肢に金額表示を反映する（初期化）
var numberscandles = $('.dd_cake_numberscandle select').children();
for (var i=0; i<numberscandles.length; i++) {

	var sel_text = numberscandles.eq(i).text();
	if(sel_text!=='--- 不要 ---'){
		sel_text = sel_text + ' のキャンドル(121円 税込)';
	}
	
	numberscandles.eq(i).text(sel_text);
}

// ケーキメッセージ欄の文字数制限を設定する（初期化）
$('.dt_cake_message').append('<span class="txtlmt"></span>');
$('.dd_cake_message textarea').attr('maxlength','25');
$('.dd_cake_message textarea').keyup(function(){
	var txtcount = $(this).val().length;
	$(this).parents('dl').find('.dt_cake_message .txtlmt').text('【' + txtcount + '文字】');
	if(txtcount == 0){
		$(this).parents('dl').find('.dt_cake_message .txtlmt').text("【0文字】");
	} 
	if(txtcount > 25){
		$(this).css("color","#ff0000");
	} else {
		$(this).css("color","#333");
	}
});

/* = ギフト商品の場合
------------------------- */
var noshi_comment = 'その他の表記をご希望の場合、カート内「発送・支払方法」画面の「備考欄」にご希望の表記をお知らせください。';
$('.dd_noshi_shurui, .dd_noshi_gaki').append('<div class="comment" style="font-size:13px; padding:5px 0px;">'+ noshi_comment +'</div>');

//
// 入力フォームのタイプを操作する
$('.dd_marup_box textarea').attr('placeholder', '例：10個購入　３個と７個に分ける\r\n※お任せの方は記入しないでください');

// クリスマスケーキ
$('.dd_birthday_plate').append('<div class="comment" style="font-size:13px; padding:5px 0px; color:red">※バースデーの文字は「Happy birthday」となります。</div>');


});

</script>

<!-- page_head -->
<div class="page_head">
	<h1><?php echo $cat_name; ?><div class="en cat_<?php echo $cat_slug; ?>"><?php echo strtoupper($cat_slug); ?></div>
	</h1>
	<!-- sns -->
	<?php get_template_part('template-parts/sns'); ?>
	<!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

	<?php if (have_posts()) : the_post(); ?>

		<!-- post -->
		<article id="post_<?php the_ID(); ?>" <?php post_class() ?>>

			<?php usces_remove_filter(); ?>
			<?php usces_the_item(); ?>

			<!-- item images(left) -->
			<div class="image">

				<!-- item image (large / slick) -->
				<div class="slides">
					<?php $imageid = usces_get_itemSubImageNums(); ?>
					<?php if ($imageid) : foreach ($imageid as $id) : ?>
							<div class="slide"><?php usces_the_itemImage2($id, 1000, 1000, $post); ?></div>
						<?php endforeach;
					else : //default.png 
						?>
						<div class="slide"><?php usces_the_itemImage2($id, 1000, 1000, $post); ?></div>
					<?php endif; ?>
				</div>
				<!-- / item image (large / slick) -->

				<div class="itemsubimg">
					<?php $imageid = usces_get_itemSubImageNums(); ?>
					<?php foreach ($imageid as $id) : ?>
						<div class="thumb"><?php usces_the_itemImage2($id, 135, 135, $post); ?></div>
					<?php endforeach; ?>
				</div><!-- end of itemsubimg -->

				<div class="info_l">

					<?php if (usces_sku_num() === 1) : //バリエーションがない場合は代表商品コードを表示 ?>
					<div class="item_code">商品コード：<?php usces_the_itemCode(); ?></div>
					<?php endif; ?>

					<h1 class="item_name"><?php usces_the_itemName(); ?></h1>

					<!-- view and rating -->
					<ul class="view_rating">
						<li class="view">
							<?php if (function_exists('the_views')) {
								the_views();
							} ?>
						</li>
						<li class="rating">
							<?php if (function_exists('the_ratings')) {
								the_ratings();
							} ?>
						</li>
					</ul>
					<!-- / view and rating -->

					<div class="excerpt">
						<?php the_content(); ?>
					</div>

				</div><!-- / info_l -->

				<?php if ($cat_slug === 'cakes') : // バースデーケーキの場合 ////////////////////////////////////////////// ?>

					<div class="notice">
						<h3>●商品のお受け取りについて</h3>
						<p>
							バースデーケーキのお受け取りは店頭のみとなっております。<br>地方発送は承っておりませんので、ご了承ください。
						</p>
					</div>
					<?PHP if(strpos( usces_the_itemCode('return' ), 'lt' ) === false): //限定でない場合 ?>
					<div class="notice">
					<h3>●商品のご予約とキャンセルについて</h3>
					<p>
					・商品のご予約…受取希望日の<strong style="color: #dd0000">３営業日前</strong>まで<br>・キャンセル…受取希望日の<strong style="color: #dd0000">２営業日前</strong>まで（※店頭にて承ります。最寄りの店舗までご来店の上、お手続きください）
					</p>
					</div>
					<?php endif; //if(strpos( usces_the_itemCode('return' ), 'lt' ) === false): ?>
					<div class="notice">
						<h3>●アレルギーをお持ちの方へ</h3>
						<p>
							アンシャーリーでは、アレルギー対応ケーキもご用意しております。お電話にてご相談ください。
						</p>
						<p>
							アン・シャーリー下関清末店<br>
							TEL.083-250-6515
						</p>
						<p>
							アン・シャーリー 下関一の宮店<br>
							TEL.083-250-9355
						</p>
					</div>

					<!-- name plate -->
					<div class="notice">
						<h3>●ネームプレートについて</h3>

						
						<?php
						// ネームプレートの種類で表示する写真類を条件分岐する
						$which_name_plate = '';
						if(usces_is_options() && usces_have_zaiko()){
							while (usces_have_options()){
								if(strpos(usces_the_itemOptName('return'), 'ネームプレート') !== false){
									$get_opt_str = usces_the_itemOption(usces_getItemOptName(), '', 'return');
									if(strpos($get_opt_str, 'うさぎ') !== false || strpos($get_opt_str, 'ベアー') !== false){
										?>
										<p>別添えで円形のネームプレートが付属します。</p>	
										<p>
											<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/nameplate3.jpg" alt="ネームプレート イメージ">
											<br>ネームプレートイメージ
										</p>
										<?php
									}
									else{
										?>
											<p>メッセージを書き入れるネームプレートをお選びいただけます。（「ハート」は有料となります）</p>
											<p>
										<?php	
										if(strpos($get_opt_str, 'ハート') !== false){
											?>
												<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/nameplate1.jpg" alt="ネームプレート(ハート) イメージ">
											<?php										
										}
										if(strpos($get_opt_str, 'スクエア') !== false){
											?>
											<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/nameplate2.jpg" alt="ネームプレート(スクエア) イメージ">
											<?php
										}
										?>
										<?php	
										if(strpos($get_opt_str, 'ハート') !== false){
											?>
												<br>ネームプレート（ハート）
											<?php										
										}
										if(strpos($get_opt_str, 'スクエア') !== false){
											?>
											／ネームプレート（スクエア）
											<?php
										}
										?>
											</p>
										<?php	
									}
								}
							}
						}
						?>
									
<!--
						<?php
							// もふもふベアーの場合（商品コードb12）またはうさぎ
							if(usces_the_itemCode(0)==='b12' || usces_the_itemCode(0)==='b11' || usces_the_itemCode(0)==='b11_a'): 
						?>
						<p>別添えで円形のネームプレートが付属します。</p>	
						<p>
							<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/nameplate3.jpg" alt="ネームプレート イメージ">
							<br>ネームプレートイメージ
						</p>
						<?php else: ?>
						<p>メッセージを書き入れるネームプレートをお選びいただけます。（「ハート」は有料となります）</p>	
						<p>
							<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/nameplate1.jpg" alt="ネームプレート イメージ">
							<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/nameplate2.jpg" alt="ネームプレート イメージ">
							<br>ネームプレート（ハート）／ネームプレート（スクエア）
						</p>
						<?php endif; ?>
						-->
							
					</div>
					
					<!-- / name plate -->

					<!-- candles -->
					<div class="notice">
						<h3>●ケーキろうそくについて</h3>
						<p>
							ケーキには無料でろうそくが付属します。<br>ナンバーズキャンドル（有料）に変更することも可能ですので、ご希望の際は、「ケーキ ろうそく」欄から「ナンバーズキャンドル」を選択してください。
						</p>
						<p>
							<img src="<?php echo esc_url(home_url('/')); ?>assets/img/item/img_numbers_candle.png" alt="ナンバーズキャンドル イメージ"><br>ナンバーズキャンドル（イメージ）
						</p>
					</div>
					<!-- / candles -->

				<?php endif; ?>

				<?php if ($cat_slug === 'gift') : // ギフト商品の場合 ////////////////////////////////////////////// ?>
				<div class="notice">
					<h3>●商品のご予約とキャンセルについて</h3>
					<p>
					・商品のご注文…配送希望日の<strong style="color: #dd0000">５営業日前</strong>まで<br>・キャンセル…配送希望日の<strong style="color: #dd0000">４営業日前</strong>まで（※店頭にて承ります。最寄りの店舗までご来店の上、お手続きください）
					</p>
				</div>
				<?php endif; ?>	

				<?php 
				// まるピーの場合 //////////////////////////////////////////////
				if ($cat_slug === 'marup' || $cat_slug === 'marup2') : ?>

				<!-- <h3>お持ち帰り用袋（別売り）</h3>
				<p>商品お持ち帰り用の袋は、こちらから別途お買い求めください。</p>
				<a class="btn_to" href="https://sizen-anne.com/item/etc/956" target="_blank" style="margin:0 0 15px">袋購入ページへ</a> -->
				<!-- 
				<div class="notice" >
							<a style="display:block; border:2px #aaa solid; padding:0px 20px; box-sizing:border-box; background:#eee" href="https://sizen-anne.com/item/etc/956" target="_blank" style="text-decoration: underline;">
							<p><span style="font-weight: bold;">お持ち帰り用袋（別売り）</span><br>こちらから別途お買い求めください。</p>
							</a>
						</div>
				-->

				<?php endif; ?>	

				<?php 
				// クリスマスケーキ場合 //////////////////////////////////////////////
				if ($cat_slug === 'xmas' || $cat_slug === 'xmas2') : ?>

					<div class="notice">
						<h3>●商品のお受け取りについて</h3>
						<p>
						クリスマスケーキの受け取りは、店頭のみとなっております。
発送は承っておりませんので、ご了承ください。
						</p>
					</div>
					<div class="notice">
						<h3>●キャンセルについて</h3>
						<p>
						12月17日以降のキャンセルは受付ておりません。
必ず受取日をご確認の上ご注文してください。<br><br>キャンセルの際はご予約していただきました店舗に電話にてお問い合わせください。
						</p>
					</div>

				<?php endif; ?>	

			</div>
			<!-- / item images -->

			<!-- item info(right) -->
			<div class="info">
				
				<?php if (usces_sku_num() === 1) : usces_have_skus(); ?>

					<!-- cart_box -->
					<div class="cart_box">

						<div class="item_code">商品コード：<?php usces_the_itemSku(); ?></div>
						<h2 class="item_name"><?php echo str_replace('?','〜', usces_the_itemSkuDisp('return')); //CSV一括登録すると化ける〜→?を元に戻す ?></h2>
						

						<dl class="price">
							<?php if(usces_the_itemCprice(0)): ?>
							<dt class="cprice">店頭価格　¥<?php echo number_format(usces_the_itemCprice(0)); ?>（税込）</dt>
							<?php endif; ?>
							<dt>ネット価格</dt>
							<dd><?php echo str_replace('¥', '', usces_the_itemPriceCr(0)); ?></dd>
						</dl>
						
						<!--1SKU-->
						<?php
						// まるピーの場合 //////////////////////////////////////////////
						// 在庫を表示する
						global $usces;
						$itemRestriction = $usces->getItemRestriction( $post->ID );
						if ($cat_slug === 'marup' || $cat_slug === 'marup2') :
						?>
						<div class="notice" style="font-weight: bold;">のこり<?php usces_the_itemZaikoNum(); ?>個（お一人様<?php echo $itemRestriction; ?>個までご購入可）</div>
						<div class="notice" style="display:block; border:2px #aaa solid; padding:0px 20px; box-sizing:border-box; background:#fff">
					<p style="font-weight: bold;">7/1からお持ち帰り用のレジ袋が有料化となります。(1枚10円)ご来店の際はマイバックなどをご持参ください。</p>
				</div>
					
						<?php endif; // まるピーの場合 ////////////////////////////////////////////// ?>
						<?php if ($item_custom = usces_get_item_custom($post->ID, 'list', 'return')) : ?>
							<div class="field"><?php echo $item_custom; ?></div>
						<?php endif; ?>
						<input type="hidden" id="price_moto_<?php echo $post->ID; ?>_<?php usces_the_itemSku(); ?>" value="<?php echo str_replace(',', '', str_replace('¥', '', usces_the_itemPriceCr(0))); ?>">
						<form action="<?php echo USCES_CART_URL; ?>" method="post">
							<?php usces_the_itemGpExp(); ?>
							<div class="skuform">
								<?php if (usces_is_options() && usces_have_zaiko()) : ?>
									<dl class='item_option'>
										<!-- <caption><?php _e('Please appoint an option.', 'usces'); ?></caption> -->
										<?php while (usces_have_options()) : ?>
											<dt class="dt_<?php echo $arr_options[usces_getItemOptName()]; ?>"><?php usces_the_itemOptName(); ?></dt>
											<dd class="dd_<?php echo $arr_options[usces_getItemOptName()]; ?>">
												<?php usces_the_itemOption(usces_getItemOptName(), ''); ?>
												<input type="hidden" class="tiia" value="<?php usces_the_itemSku(); ?>">
											</dd>
										<?php endwhile; ?>
									</dl>
								<?php endif; ?>

								<!-- <?php _e('stock status', 'usces'); ?> : <?php usces_the_itemZaiko(); ?>（在庫数：<?php usces_the_itemZaikoNum(); ?>）-->

								<?php if (!usces_have_zaiko()) : ?>
									<div class="zaiko_status btn_disabled"><?php echo apply_filters('usces_filters_single_sku_zaiko_message', esc_html(usces_get_itemZaiko('name'))); ?></div>
								<?php else : ?>
									<div class="quantity_cart">
										<!-- quantity -->
										<dl class="quantity">
											<dt><?php _e('Quantity', 'usces'); ?></dt>
											<dd>
												<?php usces_the_itemQuant(); ?>
												<?php usces_the_itemSkuUnit(); ?></dd>
										</dl>
										<!-- btn add to cart -->
										<?php usces_the_itemSkuButton(__('Add to Shopping Cart', 'usces'), 0); ?>
										
									</div>
									<div class="error_message"><?php usces_singleitem_error_message($post->ID, usces_the_itemSku('return')); ?></div>

									<?php if ($cat_slug === 'marup' || $cat_slug === 'marup2') : // まるピーの場合 ////////////////////////////////////////////// ?>
										<div class="error_message">

										こちらの商品は、<strong>別日のまるごとピーチの商品、その他の商品と同時に購入できません</strong>。一度ご注文を完了いただいた上で、商品をお買い求め下さい。
										</div>
									<?php endif; ?>

								<?php endif; ?>
							</div><!-- end of skuform -->
							<?php echo apply_filters('single_item_single_sku_after_field', NULL); ?>
							<?php do_action('usces_action_single_item_inform'); ?>
						</form>
						<?php do_action('usces_action_single_item_outform'); ?>

					</div>

					<?php
						// まるピーの場合 //////////////////////////////////////////////
						if ($cat_slug === 'marup' || $cat_slug === 'marup2') :
						?>

					<?php endif; // まるピーの場合 ////////////////////////////////////////////// ?>

				<?php elseif (usces_sku_num() > 1) : usces_have_skus(); ?>

					<!-- cart_box_ex -->
					<div class="cart_box">

						<!--some SKU-->
						<div class="exp clearfix">
							<?php if ($item_custom = usces_get_item_custom($post->ID, 'list', 'return')) : ?>
								<div class="field">
									<?php echo $item_custom; ?>
								</div>
							<?php endif; ?>
						</div><!-- end of exp -->

						<input type="hidden" id="price_moto_<?php echo $post->ID; ?>_<?php usces_the_itemSku(); ?>" value="<?php echo str_replace(',', '', str_replace('¥', '', usces_the_itemPriceCr(0))); ?>">

						<form action="<?php echo USCES_CART_URL; ?>" method="post">
							<div class="skuform">

								<?php do { ?>

									<div class="inner">

										<div class="item_code">商品コード：<?php usces_the_itemSku(); ?></div>
										<h2 class="item_name"><?php echo str_replace('?','〜', usces_the_itemSkuDisp('return')); //CSV一括登録すると化ける〜→?を元に戻す ?></h2>

										<dl class="price">
											<?php if(usces_the_itemCprice(0)): ?>
											<dt class="cprice">店頭価格　¥<?php echo number_format(usces_the_itemCprice(0)); ?>（税込）</dt>
											<?php endif; ?>
											<dt>ネット価格</dt>
											<dd><?php echo str_replace('¥', '', usces_the_itemPriceCr(0)); ?></dd>
										</dl>

										<?php if (usces_is_options() && usces_have_zaiko()) : ?>
											<?php //_e('Please appoint an option.', 'usces'); 
											?>
											<dl class='item_option'>
												<?php while (usces_have_options()) : ?>
													<dt class="dt_<?php echo $arr_options[usces_getItemOptName()]; ?>"><?php usces_the_itemOptName(); ?></dt>
													<dd class="dd_<?php echo $arr_options[usces_getItemOptName()]; ?>"><?php usces_the_itemOption(usces_getItemOptName(), ''); ?>
														<input type="hidden" class="tiia" value="<?php usces_the_itemSku(); ?>">
													</dd>
												<?php endwhile; ?>
											</dl>
										<?php endif; ?>

										<div class="quantity_cart">
											<!-- quantity -->
											<dl class="quantity">
												<dt><?php _e('Quantity', 'usces'); ?></dt>
												<dd>
													<?php usces_the_itemQuant(); ?>
													<?php usces_the_itemSkuUnit(); ?></dd>
											</dl>
											<!-- btn add to cart -->
											<?php if (!usces_have_zaiko()) : ?>
												<div class="btn_disabled">完売しました</div>
											<?php else : ?>
												<?php usces_the_itemSkuButton(__('Add to Shopping Cart', 'usces'), 0); ?>
											<?php endif; ?>
										</div>

										<div class="error_message"><?php usces_singleitem_error_message($post->ID, usces_the_itemSku('return')); ?></div>

									</div>
								<?php } while (usces_have_skus()); ?>


							</div><!-- end of skuform -->
							<?php echo apply_filters('single_item_multi_sku_after_field', NULL); ?>
							<?php do_action('usces_action_single_item_inform'); ?>
						</form>
						<?php do_action('usces_action_single_item_outform'); ?>
					</div>
					<!-- / cart_box -->

				<?php endif; ?>

				<div class="notice">
									<!-- 関連商品 -->
									<?php usces_assistance_item($post->ID, __('An article concerned', 'usces')); ?>
							</div>		


				

			</div>
			<!-- / item info -->

		</article>
		<!-- / post -->

	<?php else : ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'usces'); ?></p>
	<?php endif; ?>

</main>
<!-- / main -->


<?php get_footer(); ?>