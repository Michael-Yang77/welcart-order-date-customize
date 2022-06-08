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
	<h1>会員ログイン<div class="en">MEMBER LOGIN</div>
	</h1>
	<!-- sns -->
	<?php get_template_part('template-parts/sns'); ?>
	<!-- / sns -->
</div>
<!-- / page_head -->

<!-- main -->
<main id="main">

	<!-- content -->
	<div class="content">

		<?php if (have_posts()) : usces_remove_filter(); ?>


			<!-- login -->
			<section id="login" class="section">
				<div class="container">
					<div class="login_entry">

						<!-- login box -->
						<div class="login">
						<?php if ( usces_is_error_message() ): ?>
						<div class="error_message" style="margin-bottom:60px;">メールアドレスまたはパスワードが違います</div>
						<?php endif; ?>

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
											<?php if (!usces_is_login()) : ?>
												<br><a href="<?php usces_url('newmember') . apply_filters('usces_filter_newmember_urlquery', NULL); ?>" title="<?php _e('New enrollment for membership.', 'usces'); ?>"><?php _e('New enrollment for membership.', 'usces'); ?></a>
											<?php endif; ?>

										</div>



									</form>

								<?php endif; ?>

								<?php do_action('usces_action_login_page_footer'); ?>

								<script type="text/javascript">
									<?php if (usces_is_login()) : ?>
										setTimeout(function() {
											try {
												d = document.getElementById('loginpass');
												d.value = '';
												d.focus();
											} catch (e) {}
										}, 200);
									<?php else : ?>
										try {
											document.getElementById('loginmail').focus();
										} catch (e) {}
									<?php endif; ?>
								</script>


							<?php else : ?>
								<p><?php _e('Sorry, no posts matched your criteria.', 'usces'); ?></p>
							<?php endif; ?>


						</div>
						<!-- / login box -->

					</div>
				</div>
			</section>
			<!-- / login -->

		<?php else : ?>
			<p><?php _e('Sorry, no posts matched your criteria.', 'usces'); ?></p>
		<?php endif; ?>

	</div>

</main>
<!-- / main -->

<?php //get_sidebar( 'other' ); 
?>

<?php get_footer(); ?>