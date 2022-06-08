<!-- nav sp -->
<nav class="nav_sp">
  <ul>
    <li class="btn_home"><a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a></li>
    <li class="btn_user">ユーザーメニュー

      <!-- aside menu sp -->
      <div class="aside_menu_sp">
        <div class="sec_user">
          <div class="user_name">ユーザー</div>
        </div>
        <nav class="sec_nav">
          <ul>
            <li class="btn_profile"><a href="<?php echo esc_url(home_url('/')); ?>usces-member">プロフィール</a></li>
            <li class="btn_history"><a href="<?php echo esc_url(home_url('/')); ?>usces-member#history">購入履歴</a></li>
          </ul>
        </nav>
        <div class="sec_cart">
          <a class="cart" href="<?php echo esc_url(home_url('/')); ?>usces-cart">買い物カゴ</a>
        </div>
      </div>
      <!-- / aside menu sp -->

    </li>
  </ul>
</nav>
<!-- / nav sp -->

<!-- footer -->
<footer id="footer">
  <div class="container">
    <nav class="fnav">
      <ul>
        <li><a href="<?php echo esc_url(home_url('/')); ?>guide">ショッピングガイド</a></li>
        <li><a href="<?php echo esc_url(home_url('/')); ?>privacy">プライバシーポリシー</a></li>
        <li><a href="<?php echo esc_url(home_url('/')); ?>law">特定商取引法に関する表記</a></li>
      </ul>　　 　　　
    </nav>
    <div class="sns">
      <ul>
        <li><a class="btn_facebook" href="https://www.facebook.com/sizenanne/" target="_blank">facebook</a></li>
        <li><a class="btn_twitter" href="https://twitter.com/ANNESHIRLEY1993" target="_blank">twitter</a></li>
        <li><a class="btn_instagram" href="https://www.instagram.com/anneshirleykiyosueten/" target="_blank">Instagram</a></li>
      </ul>　　　 　　　
    </div>
    <div class="logo"><a href="<?php echo esc_url(home_url('/')); ?>">アンシャーリー</a></div>
  </div>
  <div class="copyright">1993 © ANNE SHIRLEY</div>
</footer>
<!-- / footer -->


</div>
<!-- / wrapper -->

<?php wp_footer(); ?>

<script type="text/javascript">
  $(document).ready(function(){
    
  });
</script>
</body>

</html>