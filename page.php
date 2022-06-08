<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
	<!-- page_head -->
	<div class="page_head">
		<?php
			$body_id = $post->post_name;
			if(is_parent_slug('shop')){
				$body_id = 'shop';
			}
		?>
		<h1><?php the_title(); ?><div class="en"><?php echo strtoupper($body_id); ?></div>
		</h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
	</div>
	<!-- / page_head -->

	<!-- main -->
	<main id="main">

		<?php the_content(); ?>

	</main>
	<!-- / main -->

<?php endwhile; // End of the loop. 
?>

<?php get_footer(); ?>