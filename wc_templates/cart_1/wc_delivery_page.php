<?php
/**
 * <meta content="charset=UTF-8">
 * @package Welcart
 * @subpackage Welcart Default Theme
 */
get_header();
?>

<?php usces_delivery_info_script(); ?>


<!-- page_head -->
<div class="page_head">
	<h1>カートの中<div class="en">SHOPPING CART</div>
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

	<div class="post" id="wc_<?php usces_page_name(); ?>">

		<h1 class="cart_page_title"><?php _e('Shipping / Payment options', 'usces'); ?></h1>
		<div class="entry">

			<div id="delivery-info">

				<div class="usccart_navi">
					<ol class="ucart">
					<li class="ucart usccart"><?php _e('1.Cart','usces'); ?></li>
					<li class="ucart usccustomer"><?php _e('2.Customer Info','usces'); ?></li>
					<!--<li class="ucart uscdelivery usccart_delivery"><?php _e('3.Deli. & Pay.','usces'); ?></li>-->
					<li class="ucart uscdelivery usccart_delivery"><?php _e('発送方法','usces'); ?></li>
					<li class="ucart uscconfirm"><?php _e('4.Confirm','usces'); ?></li>
					</ol>
				</div>

				<div class="header_explanation">
			<?php do_action('usces_action_delivery_page_header'); ?>
				</div>

				<div class="error_message"><?php usces_error_message(); ?></div>
				<form action="<?php usces_url('cart'); ?>" method="post">
				<table class="customer_form">
					<tr>
						<th rowspan="2" scope="row"><?php _e('shipping address', 'usces'); ?></th>
						<td><input name="delivery[delivery_flag]" type="radio" id="delivery_flag1" onclick="document.getElementById('delivery_table').style.display = 'none';" value="0"<?php if($usces_entries['delivery']['delivery_flag'] == 0) echo ' checked'; ?> onKeyDown="if (event.keyCode == 13) {return false;}" /> <label for="delivery_flag1"><?php _e('same as customer information', 'usces'); ?></label></td>
					</tr>
					<tr style="display:none">
						<td><input name="delivery[delivery_flag]" id="delivery_flag2" onclick="document.getElementById('delivery_table').style.display = 'table'" type="radio" value="1"<?php if($usces_entries['delivery']['delivery_flag'] == 1) echo ' checked'; ?> onKeyDown="if (event.keyCode == 13) {return false;}" /> <label for="delivery_flag2"><?php _e('Chose another shipping address.', 'usces'); ?></label></td>
					</tr>
				</table>
				<div style="font-size: 14px; color:#ff0000;display:none">※バースデーケーキ（期間限定ケーキ含む）は店舗でのお渡しのみとなります。<br>　ご購入商品にギフト商品とケーキが混在する場合、ギフト商品のみ地方発送させていただきます。</div>

				<?php do_action( 'usces_action_delivery_flag' ); ?>

				<table class="customer_form" id="delivery_table">
			<?php echo uesces_addressform( 'delivery', $usces_entries ); ?>
				</table>
				<table class="customer_form" id="time">
					<tr>
						<!--sod<th scope="row">配送方法（ギフト）<br>受取場所（バースデーケーキ）</th>-->
						<th scope="row">お受け取り店舗（バースデーケーキ）</th>
						<td colspan="2"><?php usces_the_delivery_method( $usces_entries['order']['delivery_method']); ?></td>
					</tr>
					<tr>
						<!--sod<th scope="row">配送希望日（ギフト）<br>受取希望日（バースデーケーキ）</th>-->
						<th scope="row">受取希望日（バースデーケーキ）</th>
						<td colspan="2"><?php usces_the_delivery_date( $usces_entries['order']['delivery_date']); ?><!--<br>※期間限定「母の日ケーキ」の受取希望日は5/10までの日にちで選択してください--></td>
					</tr>
					<tr>
						<!--sod<th scope="row">配送希望時間（ギフト）<br>受取希望時間（バースデーケーキ）</th>-->
						<th scope="row">受取希望時間（バースデーケーキ）</th>
						<td colspan="2"><?php usces_the_delivery_time( $usces_entries['order']['delivery_time']); ?></td>
					</tr>
					<?php /*
					<tr style="visibility: hidden;">
						<th scope="row"><em><?php _e('*', 'usces'); ?></em><?php _e('payment method', 'usces'); ?></th>
						<td colspan="2"><?php usces_the_payment_method( $usces_entries['order']['payment_name']); ?></td>
					</tr>
					*/
					?>
				</table>
				<div style="display: none;">
					<?php usces_the_payment_method( $usces_entries['order']['payment_name']); ?>
				</div>

			<?php usces_delivery_secure_form(); ?>

			

			<?php $meta = usces_has_custom_field_meta('order'); ?>
			<?php if(!empty($meta) and is_array($meta)) : ?>
				<table class="customer_form" id="custom_order">
				<?php usces_custom_field_input($usces_entries, 'order', ''); ?>
				</table>
			<?php endif; ?>

			<?php $entry_order_note = empty($usces_entries['order']['note']) ? apply_filters('usces_filter_default_order_note', NULL) : $usces_entries['order']['note']; ?>
				<table class="customer_form" id="notes_table">
					<tr>
						<th scope="row"><?php _e('Notes', 'usces'); ?></th>
						<td colspan="2"><textarea name="offer[note]" id="note" class="notes"><?php echo esc_html($entry_order_note); ?></textarea>
						<br>ご購入にあたり特記事項があればご入力ください。<br>例：納品書が必要な場合、ギフトののし書きで選択肢以外のものをご希望の場合 など
					</td>
					</tr>
				</table>

				

				<div class="send"><input name="offer[cus_id]" type="hidden" value="" />
				<input name="backCustomer" type="submit" class="back_to_customer_button" value="<?php _e('Back', 'usces'); ?>"<?php echo apply_filters('usces_filter_deliveryinfo_prebutton', NULL); ?> />  
				<input name="confirm" type="submit" class="to_confirm_button" value="<?php _e(' Next ', 'usces'); ?>"<?php echo apply_filters('usces_filter_deliveryinfo_nextbutton', NULL); ?> /></div>
				<?php do_action('usces_action_delivery_page_inform'); ?>
				</form>

				<div class="footer_explanation">
			<?php do_action('usces_action_delivery_page_footer'); ?>
				</div>
			</div>

		</div><!-- end of entry -->
	</div><!-- end of post -->
<?php else: ?>
<p><?php _e('Sorry, no posts matched your criteria.', 'usces'); ?></p>
<?php endif; ?>

</div>

</main>
<!-- / main -->


<?php //get_sidebar( 'cartmember' ); ?>



<?php get_footer(); ?>

<script>

$(window).on('load', function() {


	$('#delivery_time_limit_message').hide();

	// 鯉のぼりの時だけ指定
	
	$('#delivery_date_select').children('option[value='+ getNowYMD() +']').remove();
	console.log($('#delivery_date_select'));

	function getNowYMD(){
		var dt = new Date();
		var y = dt.getFullYear();
		var m = ("00" + (dt.getMonth()+1)).slice(-2);
		var d = ("00" + dt.getDate()).slice(-2);
		var result = y + "-" + m + "-" + d;
		return result;
	}
	
});


</script>	