<?php require_once('../system/require.php'); ?>
<?php //require_once('../system/function.php'); 
?>
<?php

// 文字列をescapeする
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if(empty($_GET['date']) || empty($_GET['shop'])){
  echo '<br><br><br>注文管理のカレンダーから開いてください<br><br><br>';
  exit();
}


// DB:ユーザーのデータを取得
$where = [
  'order_delivery_date' => date('Y-m-d', strtotime(h($_GET['date']))), //先月初め
  "ORDER" => ["order_delivery_time" => "ASC"],
  //'order_delivery_date[<]' => '******',
];
$orders = $database->select('wp_usces_order', '*', $where);
$checker = [];
$order_count = [];
$shop_name = [
  '1' => '清末',
  '2' => '一の宮',
  '3' => '両店舗',
];

?>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<style>
  dd,
  li {
    margin-bottom: 0px;
  }

  .list-group-item {
    position: relative;
  }

  form .list-group-item {
    background-color: transparent;
  }

  .check_order {
    position: absolute;
    right: 20px;
    top: 20px;
  }

  .list_header{
    cursor: pointer;
  }

 

</style>

<script src='../../assets/vendor/fullcalendar/jquery.min.js'></script>
<script>
  $(document).ready(function() {
/*
    $('.list_body').hide();
    $('.check_order').hide();

    $('.list_header h3').on('click', function(){
      $(this).parents('.list-group-item').find('.list_body').slideToggle(function () {
        if ($(this).is(':visible')) {
          $(this).parent().find('.check_order').fadeIn();
        } else {
          $(this).parent().find('.check_order').hide();
        }
    });

    });
*/
  });
</script>

<div class="container mt-4">
  <h2 class="bd-title mb-3"><?php echo date('Y/n/j', strtotime(h($_GET['date']))); ?>のケーキお渡し予定一覧（<?php echo $shop_name[$_GET['shop']]; ?>）<a class="btn btn-info" href="../wp-content/themes/anne_shirley/original_order_print.php?date=<?php echo h($_GET['date']); ?>&shop=<?php echo h($_GET['shop']); ?>&token=16d3eaba9f8d5bba7a6f6db9998e2b6f" target="_blank">印刷する</a></h2>
  <div class="row">
    <div class="col-sm-12">
      <ul class="list-group">
        <?php foreach ($orders as $order) : ?>
          <?php

          // お渡し完了していたら、完了バッジをつける
          if ($order['order_status'] === 'completion,') {
            $status = 'list-group-item-success';
          }
          elseif ($order['order_status'] === 'cancel,') {
            $status = 'list-group-item-dark';
          }

           // $shop_name_1または$shop_name_2の店舗が含まれる注文なら印字する
          if($_GET['shop']==1){
            $shop_name_1 = '下関清末店';
            $shop_name_2 = '下関清末店';
          }
          else if($_GET['shop']==2){
            $shop_name_1 = '下関一の宮店';
            $shop_name_2 = '下関一の宮店';
          }
          else if($_GET['shop']==3){
            $shop_name_1 = '下関清末店';
            $shop_name_2 = '下関一の宮店';
          }

          // table 'wp_usces_order' の'order_cart'はその後の更新（設定変更）が反映されないらしいので、
          // 'wp_usces_ordercart_meta'　から抽出することにした20200731

          // 1. orderからorder_cartを求める
          $cart_id = $database->get('wp_usces_ordercart', 'cart_id', ['order_id' => $order['ID']]);
      
          // 2. order_cartからordercart_metaを求める
          $where_meta = [
            'cart_id' => $cart_id,
            'meta_key' => 'ケーキ受取希望店舗', 
          ];
          $meta_value = $database->get('wp_usces_ordercart_meta', 'meta_value', $where_meta);
          $order_carts = $meta_value;

          //旧手法
          //$order_carts = urldecode($order['order_cart']);

          if(strpos($order_carts, $shop_name_1) !== false && strpos($order_carts, $shop_name_2) !== false):
          
          ?>
          <li class="list-group-item list-group-item-action pt-4 <?php echo $status; ?>">

            <!-- list header -->
            <div class="list_header">

              <h3>
                <?php if ($order['order_status'] === 'completion,') : ?>
                  <span class="badge badge-success">完了</span>
                <?php elseif ($order['order_status'] === 'cancel,') : ?>
                  <span class="badge badge-dark">キャンセル</span>  
                <?php endif; ?>
                <?php echo $order['order_delivery_date']; ?> <?php echo $order['order_delivery_time']; ?></h3>
              <a class="check_order btn btn-light" href="./admin.php?page=usces_orderlist&order_action=edit&order_id=<?php echo $order['ID']; ?>" target="_blank">受注データを開く</a>

            </div>
            <!-- / list body -->

            <!-- href="./admin.php?page=usces_orderlist&order_action=edit&order_id=<?php echo $order['ID']; ?>" target="_blank" -->

            <!-- list body -->
            <div class="list_body">

              <?php

              // 注文詳細を取得
              //$order_carts = unserialize($order['order_cart']);
              $where = [
                'order_ID' => $order['ID'],
              ];
              $order_carts = $database->select('wp_usces_ordercart', '*', $where);

              // 注文内の商品数を取得する
              $order_carts_count = $database->count('wp_usces_ordercart', '*', $where);

              $i = 1;
              ?>
              <?php foreach ($order_carts as $order_cart) : ?>
                <h4>商品  (<?php echo $i; ?>/<?php echo $order_carts_count; ?>)</h4>
                <form class="form-horizontal list-group list-group-flush mb-4">

                  <ul class="list-group list-group-flush">
                    <li class=" list-group-item">

                      <div class="row">
                        <label class="col-sm-4 control-label">商品コード / 商品名</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" value="<?php echo $order_cart['sku_code']; ?> / <?php echo str_replace("?", "〜", $order_cart['sku_name']); ?>" readonly>
                        </div>
                      </div>
                    </li>
                    <li class=" list-group-item">

                      <div class="row">
                        <label class="col-sm-4 control-label">商品数量</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" value="<?php echo $order_cart['quantity']; ?>" readonly>
                        </div>
                      </div>

                    </li>
                    <li class=" list-group-item">

                      <div class="row">
                        <label class="col-sm-4 control-label">商品単価（税込）</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" value="<?php echo number_format($order_cart['price']); ?>" readonly>
                        </div>
                      </div>

                    </li>


                    <?php

                    // 注文詳細を取得
                    //$order_carts = unserialize($order['order_cart']);
                    $where = [
                      'cart_id' => $order_cart['cart_id'],
                      'meta_type' => 'option',
                      'meta_value[!]' => '--- 不要 ---',
                    ];
                    $order_cart_options = $database->select('wp_usces_ordercart_meta', '*', $where);
                    ?>
                    <?php foreach ($order_cart_options as $option) : ?>
                      <?php //if ($option['meta_value'] !== '--- 不要 ---') : 
                      ?>
                      <li class=" list-group-item">
                        <div class="row">
                          <label class="col-sm-4 control-label"><?php echo $option['meta_key']; ?></label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php echo $option['meta_value']; ?>" readonly>
                          </div>
                        </div>
                      </li>
                      <?php //endif; 
                      ?>
                    <?php endforeach; ?>
                  </ul>
                </form>

                <?php $i++; ?>
              <?php endforeach; ?>

              <h4>総合計</h4>

              <form class="form-horizontal list-group list-group-flush mb-4">
                <ul class="list-group list-group-flush">
                    <!-- <li class=" list-group-item">
                      <div class="row">
                        <label class="col-sm-4 control-label">商品合計（税込）</label>
                        <div class="col-sm-8">
                          <input type="text" name="text" class="form-control" value="<?php echo number_format($order['order_item_total_price']); ?>">
                        </div>
                      </div>
                    </li>
                    <li class=" list-group-item">
                      <div class="row">
                        <label class="col-sm-4 control-label">送料（税込）</label>
                        <div class="col-sm-8">
                          <input type="text" name="text" class="form-control" value="<?php echo number_format($order['order_shipping_charge']); ?>">
                        </div>
                      </div>
                    </li> -->
                    <li class=" list-group-item">
                      <div class="row">
                        <label class="col-sm-4 control-label">総合計（税込）</label>
                        <div class="col-sm-8">
                          <input type="text" name="text" class="form-control" value="<?php echo number_format($order['order_item_total_price']+$order['order_shipping_charge']); ?>" readonly>
                        </div>
                      </div>
                    </li>
                </ul>   
              </form>



              <h4>お客様情報</h4>

              <form class="form-horizontal list-group list-group-flush">

                <ul class="list-group list-group-flush">
                  <li class=" list-group-item">
                    <div class="row">
                      <label class="col-sm-4 control-label">氏名</label>
                      <div class="col-sm-8">
                        <?php
                          if(!$order['order_name3']){
                            $order['order_name3'] = $order['order_name1'];
                          }
                          if(!$order['order_name4']){
                            $order['order_name4'] = $order['order_name2'];
                          }
                        ?>
                        <input type="text" name="text" class="form-control" value="<?php echo $order['order_name3']; ?>　<?php echo $order['order_name4']; ?> 様" readonly>
                      </div>
                    </div>
                  </li>
                  <li class=" list-group-item">
                    <div class="row">
                      <label class="col-sm-4 control-label">電話番号</label>
                      <div class="col-sm-8">
                        <input type="text" name="text" class="form-control" value="<?php echo $order['order_tel']; ?>" readonly>
                      </div>
                    </div>
                  </li>
                  <li class=" list-group-item">
                    <div class="row">
                      <label class="col-sm-4 control-label">備考</label>
                      <div class="col-sm-8">
			<textarea readonly><?php echo $order['order_note']; ?></textarea>
                      </div>
                    </div>
                  </li>
                </ul>

              </form>

            </div>
            <!-- / list body -->

          </li>
          <?php endif; //if(strpos($order_carts, $shop_name[h($_GET['shop'])]) !== false) ?>
        <?php endforeach; ?>
      </ul>
    </div>

  </div>

</div>

<style>
.list-group-item textarea {
    width: 100%;
    height: 130px;
}

@media print{
  #wpadminbar,
  #adminmenumain,
  #adminmenuback,
  #adminmenuwrap,
  #wpfooter,
  .check_order, 
  .message, 
  .update-nag{
    display: none;
  }
  #wpcontent{
    margin-left: 0px;
  }
  .list-group-item{
    
  }
  .list-group-item-action{
    height: 370mm;
  }
} 
</style>  