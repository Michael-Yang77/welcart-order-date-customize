<?php require_once('../system/require.php'); ?>
<?php //require_once('../system/function.php'); 
?>
<link href='../../assets/vendor/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
<link href='../../assets/vendor/fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />

<style>
  #original_container {
    margin: 30px auto;
  }
  #original_container>h2{
    font-size: 2rem;
    font-weight: 500;
    line-height: 1.2;
    margin: 1em 0 0.5em;
  }
  #original_container>p{
    margin: 0 0 2em;
  }  

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

  /* 日曜日 */
  .fc-sun {
    color: red;
    background-color: #fff0f0;
  }

  /* 土曜日 */
  .fc-sat {
    color: blue;
    background-color: #f0f0ff;
  }

  .fc-view-container {
    background: #fff;
  }

  .fc-day-grid-event{
    cursor: pointer;
  }
  .container{
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
  }
  @media (min-width: 992px){
    .container {
      max-width: 960px;
    }
  }

</style>

<script src='../../assets/vendor/fullcalendar/moment.min.js'></script>
<script src='../../assets/vendor/fullcalendar/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/locale/ja.js'></script>

<script>

    $(document).ready(function() {

      $.ajax({
        url: '../wp-content/themes/anne_shirley/original_order/get_order.php',
        method: "POST",
        datatype: "json",
      }).done(function(data) {

        var events = [];

        //console.log(data);

        $.each(data, function(i, v) {

          events.push({
            title: v.title,
            start: moment(v.start),
            color: v.color,
            shop: v.shop
          });

          //console.log(v.test);

        });

        $('#calendar').fullCalendar({
          selectable: true,
          editable: false,
          events: events, //Pass the new collection of events to the FullCalendar initialization function, targeting the #calendar div.
          locale: 'ja',
          eventRender: function(event, element){ 
              element.find('.fc-time').hide();
              //console.log(event);
          },
          eventClick: function(info) {
            //alert('click!');

            location.href="./admin.php?page=original_order_system_detail&date=" + moment(info.start).format('YYYY-MM-DD') + "&shop=" + info.shop;
            //console.log(info.start);
          },
        });
      });

    });

</script>

<div id="original_container" class="container">
  <h2>ケーキお渡し予定カレンダー</h2>
  <div id='calendar'></div>
</div>

<?php

$order['order_cart'] = 'a:1:{i:0;a:7:{s:6:"serial";s:1632:"a:1:{i:485;a:1:{s:5:"bd1_5";a:9:{s:143:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%2825%E6%96%87%E5%AD%97%E3%81%BE%E3%81%A7%29";s:49:"%E3%81%91%E3%81%84%E3%81%99%E3%81%91happybirthday";s:162:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%E3%83%8D%E3%83%BC%E3%83%A0%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88";s:57:"1.+%E3%83%8F%E3%83%BC%E3%83%88%EF%BC%88%E5%A4%A7%EF%BC%89";s:81:"%E3%82%B1%E3%83%BC%E3%82%AD%E5%8F%97%E5%8F%96%E5%B8%8C%E6%9C%9B%E5%BA%97%E8%88%97";s:117:"%E3%82%A2%E3%83%B3%E3%83%BB%E3%82%B7%E3%83%A3%E3%83%BC%E3%83%AA%E3%83%BC%E4%B8%8B%E9%96%A2%E6%B8%85%E6%9C%AB%E5%BA%97";s:64:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F";s:18:"%E9%80%9A%E5%B8%B8";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%A4%A7%EF%BC%89";s:1:"5";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%B0%8F%EF%BC%89";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%281%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%282%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%283%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";}}}";s:7:"post_id";i:485;s:3:"sku";s:5:"bd1_5";s:7:"options";a:9:{s:143:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%2825%E6%96%87%E5%AD%97%E3%81%BE%E3%81%A7%29";s:49:"%E3%81%91%E3%81%84%E3%81%99%E3%81%91happybirthday";s:162:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%E3%83%8D%E3%83%BC%E3%83%A0%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88";s:57:"1.+%E3%83%8F%E3%83%BC%E3%83%88%EF%BC%88%E5%A4%A7%EF%BC%89";s:64:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F";s:18:"%E9%80%9A%E5%B8%B8";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%A4%A7%EF%BC%89";s:1:"5";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%B0%8F%EF%BC%89";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%281%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%282%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%283%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:81:"%E3%82%B1%E3%83%BC%E3%82%AD%E5%8F%97%E5%8F%96%E5%B8%8C%E6%9C%9B%E5%BA%97%E8%88%97";s:117:"%E3%82%A2%E3%83%B3%E3%83%BB%E3%82%B7%E3%83%A3%E3%83%BC%E3%83%AA%E3%83%BC%E4%B8%8B%E9%96%A2%E6%B8%85%E6%9C%AB%E5%BA%97";}s:5:"price";i:3719;s:8:"quantity";i:1;s:7:"advance";s:0:"";}}';

$order_carts = urldecode($order['order_cart']);

    if(strpos($order_carts,'下関清末店') !== false){
      $shop .= '[清末]';
    } 
    if(strpos($order_carts,'下関一の宮店') !== false){
      $shop .= '[一の宮]';
    } 
//echo $shop;

//$us = unserialize('a:1:{i:0;a:7:{s:6:"serial";s:1632:"a:1:{i:485;a:1:{s:5:"bd1_5";a:9:{s:143:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%2825%E6%96%87%E5%AD%97%E3%81%BE%E3%81%A7%29";s:49:"%E3%81%91%E3%81%84%E3%81%99%E3%81%91happybirthday";s:162:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%E3%83%8D%E3%83%BC%E3%83%A0%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88";s:57:"1.+%E3%83%8F%E3%83%BC%E3%83%88%EF%BC%88%E5%A4%A7%EF%BC%89";s:81:"%E3%82%B1%E3%83%BC%E3%82%AD%E5%8F%97%E5%8F%96%E5%B8%8C%E6%9C%9B%E5%BA%97%E8%88%97";s:117:"%E3%82%A2%E3%83%B3%E3%83%BB%E3%82%B7%E3%83%A3%E3%83%BC%E3%83%AA%E3%83%BC%E4%B8%8B%E9%96%A2%E6%B8%85%E6%9C%AB%E5%BA%97";s:64:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F";s:18:"%E9%80%9A%E5%B8%B8";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%A4%A7%EF%BC%89";s:1:"5";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%B0%8F%EF%BC%89";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%281%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%282%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%283%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";}}}";s:7:"post_id";i:485;s:3:"sku";s:5:"bd1_5";s:7:"options";a:9:{s:143:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%2825%E6%96%87%E5%AD%97%E3%81%BE%E3%81%A7%29";s:49:"%E3%81%91%E3%81%84%E3%81%99%E3%81%91happybirthday";s:162:"%E3%82%B1%E3%83%BC%E3%82%AD%E3%81%8A%E7%A5%9D%E3%81%84%E3%83%A1%E3%83%83%E3%82%BB%E3%83%BC%E3%82%B8%E3%83%8D%E3%83%BC%E3%83%A0%E3%83%97%E3%83%AC%E3%83%BC%E3%83%88";s:57:"1.+%E3%83%8F%E3%83%BC%E3%83%88%EF%BC%88%E5%A4%A7%EF%BC%89";s:64:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F";s:18:"%E9%80%9A%E5%B8%B8";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%A4%A7%EF%BC%89";s:1:"5";s:110:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%82%8D%E3%81%86%E3%81%9D%E3%81%8F+%E9%80%9A%E5%B8%B8%EF%BC%88%E5%B0%8F%EF%BC%89";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%281%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%282%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:143:"%E3%82%B1%E3%83%BC%E3%82%AD+%E3%83%8A%E3%83%B3%E3%83%90%E3%83%BC%E3%82%BA%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%89%E3%83%AB%283%E6%9C%AC%E7%9B%AE%29";s:26:"---+%E4%B8%8D%E8%A6%81+---";s:81:"%E3%82%B1%E3%83%BC%E3%82%AD%E5%8F%97%E5%8F%96%E5%B8%8C%E6%9C%9B%E5%BA%97%E8%88%97";s:117:"%E3%82%A2%E3%83%B3%E3%83%BB%E3%82%B7%E3%83%A3%E3%83%BC%E3%83%AA%E3%83%BC%E4%B8%8B%E9%96%A2%E6%B8%85%E6%9C%AB%E5%BA%97";}s:5:"price";i:3719;s:8:"quantity";i:1;s:7:"advance";s:0:"";}}');

////echo '<pre>';
//echo urldecode($us[0]['options']['%E3%82%B1%E3%83%BC%E3%82%AD%E5%8F%97%E5%8F%96%E5%B8%8C%E6%9C%9B%E5%BA%97%E8%88%97']);
//echo '</pre>';

//echo urldecode('---+%E4%B8%8D%E8%A6%81+---%E3%82%B1%E3%83%BC%E3%82%AD%E5%8F%97%E5%8F%96%E5%B8%8C%E6%9C%9B%E5%BA%97%E8%88%97');

?>