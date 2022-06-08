<?php require_once('../../../../system/require.php'); ?>
<?php require_once('../../../../system/function.php'); ?>
<?php

// DB:ユーザーのデータを取得（先月分より後しか読み込まない）
$where = [
  'order_delivery_date[>]' => date('Y-m-d', strtotime('first day of previous month')), //先月初め
  //'order_status[!]' => 'cancel,',
  //'order_delivery_date[<]' => '******',
];
$orders = $database->select('wp_usces_order', '*', $where);
$checker = [];
$order_count = [];
$order_is_cancel = [];
$shop_name = [
  '1' => '清末',
  '2' => '一の宮',
  '3' => '両店舗',
];


//$orders = array();
foreach ($orders as $order) {

    //受け取り希望店舗を取得する
    $shop_flag1 = false;
    $shop_flag2 = false;
    $shop_flag_which = false;
    $event_color = '#cccccc';
    $shop_flag_dummy_time = '';
    
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
    //$test = $order['ID'].':'.$meta_value.'<-->'.urldecode($order['order_cart']);
    //$test = $order['ID'].':'.$meta_value;
    //echo '<!-- '.$order_carts2.' -->';

    //旧手法
    //$order_carts = urldecode($order['order_cart']);

    if(strpos($order_carts,'下関清末店') !== false){
      $shop_flag1 = true;
      //$test .= $test.'->'.'@下関清末店';
    } 
    if(strpos($order_carts,'下関一の宮店') !== false){
      $shop_flag2 = true;
      //$test .= $test.'->'.'@下関一の宮店';
    }


        // 清末店
        if($shop_flag1){
          $event_color = '#7eb243';
          $shop_flag_which = 1;
          $shop_flag_dummy_time = '11:00';
        }
        // 一の宮店
        if($shop_flag2){
          $event_color = '#ed9500';
          $shop_flag_which = 2;
          $shop_flag_dummy_time = '12:00';
        }
        // 混在
        if($shop_flag1 && $shop_flag2){
          $event_color = '#ea7b74';
          $shop_flag_which = 3;
          $shop_flag_dummy_time = '13:00';
        }
        
        // 同じ日同じ店舗のイベントは集約するのでチェック
        $soeji = $order['order_delivery_date'].'#'.$shop_flag_which; 

        // 注文にキャンセルが含まれれば
        if($order['order_status'] === 'cancel,'){
          $order_is_cancel[$soeji]++;
        }

        // その日のイベント数
        $order_count[$soeji]++;

          // カレンダー用イベントデータを生成
          $data_title = $shop_name[$shop_flag_which].' ('.$order_count[$soeji].')';

          if($order_is_cancel[$soeji]>0){
            $data_title .= ' / ｷｬﾝｾﾙ('.$order_is_cancel[$soeji].')';
          }

          $data[$soeji] = [
            'flag' => 1,
            'place' => '',
            'id' => $order['ID'],
            'title' => $data_title,
            //'start' =>  $order['order_delivery_date'].'T'.$order['order_delivery_time'],
            //'end' => $order['order_delivery_date'].'T'.$order['order_delivery_time'],
            'start' =>  $order['order_delivery_date'].'T'.$shop_flag_dummy_time,
            'end' => $order['order_delivery_date'].'T'.$shop_flag_dummy_time ,
            'allDay' => false,
            'color' => $event_color,
            'shop' => $shop_flag_which,
            //'test' => $test,
          ];

          //検査用配列を生成
          $checker[$soeji] = 1;



    /*
    // 清末店
    if($shop_flag1){
      $event_color = '#7eb243';
      $shop_flag_which = 1;
    }
    // 一の宮店
    if($shop_flag2){
      $event_color = '#ed9500';
      $shop_flag_which = 2;
    }
    // 混在
    if($shop_flag1 && $shop_flag2){
      $event_color = '#ea7b74';
      $shop_flag_which = 3;
    }

    $order_count[$order['order_delivery_date']][$shop_flag_which]++;

    $data[] = [
        'flag' => 1,
        'place' => '',
        'id' => $order['ID'],
        'title' => '時　'.$order['order_name1'].' 様'.$shop,
        'start' =>  $order['order_delivery_date'].'T'.$order['order_delivery_time'],
        'end' => $order['order_delivery_date'].'T'.$order['order_delivery_time'],
        'allDay' => false,
        'color' => $event_color,
    ];*/

}
//return $data;

header('Content-type: application/json; charset=utf-8');
echo json_encode($data);

?>