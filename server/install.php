<?php

require_once 'class/html.php';
$html = new html();

require_once 'class/db.php';
$db = new connect();
// テーブルを設定
$db->set_table();

require_once 'class/user.php';
$user = new user();

if( $user->check_user() == false && $_REQUEST['submit'] == true){
  if (!empty($_POST['adminUser']) && !empty($_POST['passWord']) && !empty($_POST['passWord2'])) {
    $adminUser = $html->h($_POST['adminUser']);
    $passWord = $html->h($_POST['passWord']);
    $passWord2 = $html->h($_POST['passWord2']);

    if($passWord === $passWord2){
      // adminユーザーを作成
      $user->create_user($adminUser,$passWord);

      // ユーザー作成後はログイン画面へ
      header("Location: login.php");
    }else{
      $errorMessage = "パスワードの値が違います。";
    }
  }else{
    $errorMessage = "入力してください。";
  }
}elseif($user->check_user() == true){
  // 管理ユーザーが作成されていたらこの画面には行けない
  header("Location: login.php");
  exit;
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面 - インストール</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="site.css">

</head>
<body>

<?php include("template/header.php"); ?>

<div class="login_form">
  <h1 class="title">インストール</h1>
  <form action="install.php" method="post">
    <div class="form-group">
      <label for="user">admin user name</label>
      <input type="text" name="adminUser" class="form-control">
    </div>
    <div class="form-group">
      <label for="user">password</label>
      <input type="password" name="passWord" class="form-control">
    </div>
    <div class="form-group">
      <input type="password" name="passWord2" class="form-control">
    </div>
    <?php echo $html->errorMessage($errorMessage); ?>
    <input type="submit" value="ログイン" name="submit" class="btn btn-primary">
  </form>
</div>

<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
