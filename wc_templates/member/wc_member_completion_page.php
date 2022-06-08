<?php
/**
 * <meta content="charset=UTF-8">
 * @package Welcart
 * @subpackage Welcart Default Theme
 */
get_header();
?>

<!-- page_head -->
<div class="page_head">
	<h1>会員マイページ<div class="en">MEMBER PAGE</div>
	</h1>
	<!-- sns -->
	<?php get_template_part( 'template-parts/sns' ); ?>
	<!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

	<!-- content -->
	<div class="content">

<?php if (have_posts()) : usces_remove_filter(); ?>

	<div class="post" id="wc_<?php usces_page_name(); ?>">

		<h1 class="member_page_title"><?php _e('Completion', 'usces'); ?></h1>
		<div class="entry">

			<div id="memberpages">

				<div class="header_explanation">
				<?php do_action('usces_action_membercompletion_page_header'); ?>
				</div>

				<?php $member_compmode = usces_page_name('return'); ?>
				<?php if ( 'newcompletion' == $member_compmode ) : ?>
				<p><?php _e('Thank you in new membership.', 'usces'); ?></p>

				<?php elseif ( 'editcompletion' == $member_compmode ) : ?>
				<p><?php _e('Membership information has been updated.', 'usces'); ?></p>

				<?php elseif ( 'lostcompletion' == $member_compmode ) : ?>
				<p><?php _e('I transmitted an email.', 'usces'); ?></p>
				<p><?php _e('Change your password by following the instruction in this mail.', 'usces'); ?></p>

				<?php elseif ( 'changepasscompletion' == $member_compmode ) : ?>
				<p><?php _e('Password has been changed.', 'usces'); ?></p>

				<?php endif; ?>


				<div class="footer_explanation">
				<?php do_action('usces_action_membercompletion_page_footer'); ?>
				</div>

				<p><a href="<?php usces_url('member'); ?>"><?php _e('to vist membership information page', 'usces'); ?></a></p>

				<div class="send"><a href="<?php echo home_url(); ?>" class="back_to_top_button"><?php _e('Back to the top page.', 'usces'); ?></a></div>
			</div><!-- end of memberpages -->

		</div><!-- end of entry -->
	</div><!-- end of post -->
<?php else: ?>
<p><?php _e('Sorry, no posts matched your criteria.', 'usces'); ?></p>
<?php endif; ?>

</div>

</main>
<!-- / main -->

<?php //get_sidebar( 'other' ); ?>

<?php get_footer(); ?>

