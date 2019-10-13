<?php

require_once __DIR__ . '/functions.php';
// unlogined_session();


require_once 'class/user.php';
$user = new user();

require_once 'class/html.php';
$html = new html();

$user->admin_user_unlogined();

if($_REQUEST['sineup'] == true){

  if (!empty($_POST['user']) && !empty($_POST['pass'])) {
    $name = $html->h($_POST['user']);

    // 管理者のパスワードを取得
    $db_hashed_pwd = $user->get_admin_user_pass($name);
    // ハッシュ化されたパスワードがマッチするかどうかを確認
    if (password_verify($html->h($_POST['pass']), $db_hashed_pwd)) {

      $_SESSION["login"] = array("user" => $name);

      header("Location: admin.php");
      exit;
    }else{
      $errorMessage = "名前かパスワードが間違っています。";
    }

  }

};
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面 - ログイン画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="site.css">

</head>
<body>

<?php include("template/header.php"); ?>


<div class="login_form">
  <h1 class="title">ログイン</h1>
  <form action="login.php" method="post">
    <div class="form-group">
      <label for="user">user name</label>
      <input type="text" name="user" class="form-control">
    </div>
    <div class="form-group">
      <label for="user">password</label>
      <input type="password" name="pass" class="form-control">
    </div>
    <?php echo $html->errorMessage($errorMessage); ?>
    <input type="submit" value="ログイン" name="sineup" class="btn btn-primary">
  </form>
</div>

<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
