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
	<h1>新規会員登録<div class="en">MEMBER ENTRY</div>
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

	<!-- <h1 class="member_page_title">新規会員登録フォーム</h1> -->
		<div class="entry">

			<div id="memberpages">

				<div id="newmember">

					<div class="header_explanation">
						<ul>
						<li>この新規入会フォームより送信いただく個人情報の取り扱いにつきましては、SSLにより通信を暗号化し細心の注意を払っております。</li>
						<li>お預かりしたお客様の情報は本人様へのお問い合わせ内容についてのご返答や情報のご提供の目的であり、他の目的に使用することはございません。詳しくは「<a href="./privacy" target="_blank">プライバシーポリシー</a>」をご覧ください。</li>
						<li>*印の付いている項目は必須となっております。漏れなくご記入ください。</li>
						<li>英数字は半角での記入をお願いいたします。</li>
						</ul>
						<?php do_action('usces_action_newmember_page_header'); ?>
					</div><!-- end of header_explanation -->

					<div class="error_message"><?php usces_error_message(); ?></div>
					<form action="<?php echo apply_filters('usces_filter_newmember_form_action', usces_url('member', 'return')); ?>" method="post" onKeyDown="if (event.keyCode == 13) {return false;}">
						<table border="0" cellpadding="0" cellspacing="0" class="customer_form">
							<tr>
								<th scope="row"><em><?php _e('*', 'usces'); ?></em><?php _e('e-mail adress', 'usces'); ?></th>
								<td colspan="2"><input name="member[mailaddress1]" id="mailaddress1" type="text" value="<?php usces_memberinfo('mailaddress1'); ?>" /></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e('*', 'usces'); ?></em><?php _e('E-mail address (for verification)', 'usces'); ?></th>
								<td colspan="2"><input name="member[mailaddress2]" id="mailaddress2" type="text" value="<?php usces_memberinfo('mailaddress2'); ?>" /></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e('*', 'usces'); ?></em><?php _e('password', 'usces'); ?></th>
								<td colspan="2"><input class="hidden" value=" " /><input name="member[password1]" id="password1" type="password" value="<?php usces_memberinfo('password1'); ?>" autocomplete="off" /></td>
							</tr>
							<tr>
								<th scope="row"><em><?php _e('*', 'usces'); ?></em><?php _e('Password (confirm)', 'usces'); ?></th>
								<td colspan="2"><input name="member[password2]" id="password2" type="password" value="<?php usces_memberinfo('password2'); ?>" /></td>
							</tr>
							<?php uesces_addressform( 'member', usces_memberinfo(NULL), 'echo' ); ?>
						</table>
						<?php usces_agree_member_field(); ?>
						<div class="send"><?php usces_newmember_button($member_regmode); ?></div>
						<?php do_action('usces_action_newmember_page_inform'); ?>
					</form>

					<div class="footer_explanation">
					<?php do_action('usces_action_newmember_page_footer'); ?>
					</div><!-- end of footer_explanation -->

				</div><!-- end of newmember -->
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
