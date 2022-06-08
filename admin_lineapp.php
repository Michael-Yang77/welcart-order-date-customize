<?php require_once('../system/require.php'); ?>
<?php //require_once('../system/function.php'); ?>
<?php

// DB:ユーザーのデータを取得
$where = [
	'status' => 'publish',
];
$datas = $database->select('mirai_user', '*', $where);

?>
<div class="wrap">
  <h1 class="wp-heading-inline">LINEアプリ利用者一覧</h1>
  <p>現在のLINEアプリ利用者の一覧を表示します。</p>

  <hr class="wp-header-end">


  <form id="posts-filter" method="get">


    <h2 class="screen-reader-text">投稿リスト</h2>
    <table class="wp-list-table widefat fixed striped posts">
      <thead>
        <tr>
          <th scope="col" id="title" class="manage-column column-author">LINE会員No.</th>
          <th scope="col" id="author" class="manage-column column-title">LINE user_ID</th>
          <th scope="col" id="categories" class="manage-column column-author">ポイント</th>
          <th scope="col" id="date" class="manage-column column-date sortable asc">通販会員ID</th>
          <th scope="col" id="categories" class="manage-column column-author">誕生日登録数</th>
          <th scope="col" id="ratings" class="manage-column column-ratings sortable desc">作成日時</th>
          <th scope="col" id="views" class="manage-column column-views sortable desc">更新日時</th>
        </tr>
      </thead>

      <tbody id="the-list" class="ui-sortable">
        <?php foreach($datas as $data): ?>
        <tr id="post-535" class="iedit author-other level-0 post-535 type-post status-publish format-standard hentry category-news ui-sortable-handle">
          <td class="title column-title has-row-actions column-primary page-title" data-colname="LINE会員No." style="text-align: right">
          <?php echo $data['ID']; ?>
          </td>
          <td class="author column-author" data-colname="LINE user_ID"><?php 
          
          $str = $data['line_userId'];
          $ptn = "/([A-Za-z0-9]{28})([A-Za-z0-9]{4})/";
          $rep = "************$2";
          echo preg_replace($ptn, $rep, $str);

          // 誕生日登録数の取得
          $where = [
            'status' => 'publish',
            'user_ID' => $data['ID'],
          ];
          $count_bd = $database->count('mirai_user_birthday', '*', $where);
          
          //echo $data['line_userId']; ?></td>
          <td class="categories column-categories" data-colname="ポイント" style="text-align: right"><?php echo $data['point']; ?></td>
          <td class="date column-date" data-colname="通販サイト会員ID" style="text-align: right"><a href="./admin.php?page=usces_memberlist&member_action=edit&member_id=<?php echo $data['usces_member_ID']; ?>" target="_blank"><?php echo $data['usces_member_ID']; ?></a></td>
          <td class="categories column-categories" data-colname="ポイント" style="text-align: right"><?php echo $count_bd; ?></td>
          <td class="ratings column-ratings" data-colname="作成日時"><?php echo $data['create_dt']; ?></td>
          <td class="views column-views" data-colname="更新日時"><?php echo $data['update_dt']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>

      

    </table>

  </form>


  <div id="ajax-response"></div>
  <br class="clear">
</div>