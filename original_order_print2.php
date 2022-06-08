<?php require_once('../../../../system/require.php'); ?>
<?php

if(empty($_GET['token']) || $_GET['token']!=md5('mirai_is_great')){
  //echo md5('mirai_is_great');
  exit();
  
}

require_once "../../../../system/TCPDF/tcpdf.php";
$tcpdf = new TCPDF("P", "mm", "A4", true, "UTF-8");
$tcpdf->setPrintHeader(false); // 追加する

$tcpdf->setPrintFooter(false); // 追加する
$tcpdf->SetMargins(5,5);
$tcpdf->setFooterMargin(5);
$tcpdf->SetAutoPageBreak(TRUE, 5);

$tcpdf->AddPage();
$tcpdf->SetFont("kozgopromedium", "", 10);

// 文字列をescapeする
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if (empty($_GET['date']) || empty($_GET['shop'])) {
  // echo '<br><br><br>注文管理のカレンダーから開いてください<br><br><br>';
  exit();
}
// DB:ユーザーのデータを取得
$where = [
  'order_delivery_date' => date('Y-m-d', strtotime(h($_GET['date']))),
  //'order_status[!]' => 'cancel,', 
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

// 長すぎるフィールド文字を変換
function str_key_replace($str_key)
{

  $str_key = str_replace('商品コード / 商品名', '商品', $str_key);
  $str_key = str_replace('ケーキお祝いメッセージ(25文字まで)', 'メッセージ', $str_key);
  $str_key = str_replace('ケーキお祝いメッセージネームプレート', 'ネームプレート', $str_key);
  $str_key = str_replace('ケーキ ろうそく', 'ろうそく', $str_key);
  $str_key = str_replace('ケーキ ナンバーズキャンドル', 'ナンバーズ', $str_key);
  $str_key = str_replace('ケーキ受取希望店舗', '受取店舗', $str_key);

  return $str_key;
}
ob_start();
?>
<style>
  .waku {
    width: 100%;
  }

  .waku th {
    text-align: center;
    font-weight: bold;
  }

  .waku td {
    width: 50%;
    height: 143.5mm;
  }
  .inner{
    width: 100%;
  }
  .inner th{
    width: 38%;
    font-weight: bold;
  }
  .inner td{
    width: 62%;
  }

</style>
<table class="waku" cellpadding="0">
  <tr>
    <?php $count = 0; ?>
    <?php foreach ($orders as $order) : ?>
      <?php

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
      $order_carts = urldecode($order['order_cart']);

      if(strpos($order_carts, $shop_name_1) !== false && strpos($order_carts, $shop_name_2) !== false):

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
        <td <?php if ($order['order_status'] === 'cancel,') : ?>style="color:silver"<?php endif; ?>>
        
          <h3>&nbsp;　<?php if ($order['order_status'] === 'completion,') : ?>
          【完了】
        <?php elseif ($order['order_status'] === 'cancel,') : ?>
          【キャンセル】
        <?php endif; ?><?php echo $order['order_delivery_date']; ?> <?php echo $order['order_delivery_time']; ?> お渡し予定 (<?php echo $i; ?>/<?php echo $order_carts_count; ?>)</h3>
          <p style="font-weight: bold">&nbsp;　<?php echo $order_cart['sku_code']; ?> / <?php echo str_replace("?", "〜", $order_cart['sku_name']); ?></p>

          <table class="inner" cellpadding="5">
            <tr>
              <th>単価（税込）</th>
              <td><?php echo number_format($order_cart['price']); ?>円（数量：<?php echo $order_cart['quantity']; ?>個）</td>
            </tr>
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
            <tr>
              <th><?php echo str_key_replace($option['meta_key']); ?></th>
              <td><?php echo $option['meta_value']; ?></td>
            </tr>
            <?php endforeach; ?>
            <?php $i++; ?>

            <tr>
              <th>総合計（税込）</th>
              <td><?php echo number_format($order['order_item_total_price'] + $order['order_shipping_charge']); ?>円</td>
            </tr>
            <tr>
              <th>氏名</th>
              <td><?php
              if(!$order['order_name3'] || !$order['order_name4']){
                $name = $order['order_name1'].' '.$order['order_name2'];
              }
              else{
                $name = $order['order_name3'].' '.$order['order_name4'];
              }
              echo $name; ?> 様</td>
            </tr>
            <tr>
              <th>TEL</th>
              <td><?php echo $order['order_tel']; ?></td>
            </tr>

          </table>   

        </td>
        <?php $count++; ?>
        <?php if ($count % 2 == 0) : ?>
      </tr>
      <tr>
        <?php endif; ?>
        <?php endforeach; ?>
   
  <?php endif; //if(strpos($order_carts, $shop_name[h($_GET['shop'])]) !== false) ?>
  <?php endforeach; ?>

  </tr>
</table>

<?php
$html = ob_get_contents(); // バッファリング取得
ob_end_clean(); // バッファリング終了
$tcpdf->writeHTML($html);
$tcpdf->Output("print.pdf", "I");
?>