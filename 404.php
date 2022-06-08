<?php get_header(); ?>


	<!-- page_head -->
	<div class="page_head">
		<?php
			$body_id = $post->post_name;
			if(is_parent_slug('shop')){
				$body_id = 'shop';
			}
		?>
		<h1>ページが見つかりませんでした<div class="en">NOT FOUND</div></h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
	</div>
	<!-- / page_head -->

	<!-- main -->
	<main id="main">

		<p style="text-align:center; margin-bottom:80px">あなたがアクセスしようとしたページは削除されたかURLが変更されているため、見つけることができません。</p>
		<a class="btn_to" href="/">トップページへ戻る</a>

	</main>
	<!-- / main -->

<?php get_footer(); ?>