<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">&amp;antique CD予約</a>
    <?php if (isset($_SESSION['login'])) { echo '<span class="navbar-text"><a class="btn btn-link" href="logout.php">ログアウト</a></span>'; };?>
  </div>
</nav>
