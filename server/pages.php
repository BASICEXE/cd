<?php

require_once __DIR__ . '/functions.php';

require_once 'class/code.php';
$code = new code();

require_once 'class/html.php';
$html = new html();

require_once 'class/user.php';
$user = new user();
$user->admin_user_logined();

$codeN = isset($_GET['code']) ? (int)$_GET['code'] : 1;


$result = $code->get_data($codeN);

foreach($result as $row){

$code_id = $row["codeId"];
$name = $row["name"];
$tel = $row["tel"];
$code = $html->h($row['code1']) . '-' . $html->h($row['code2']) . '-' . $html->h($row['code3']);
$postNumber = $html->h($row['postNumber']);
$address = $html->h($row['address']);
$free = $row['free'];

}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面 - 内容確認画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="site.css">

</head>
<body>

<?php include("template/header.php"); ?>


<div class="container">
  <div class="section">

    <h1 class="title">シリアルコード一覧画面</h1>

    <div class="code_page row">
        <div class="col-5">
          <div class="label">お名前</div>
          <div class="mb-3 waku">
            <?php echo $name;?>
          </div>
        </div>
        <div class="w-100"></div>
        <div class="col-5">
          <div class="label">電話番号</div>
          <div class="mb-3 waku">
            <?php echo $tel;?>
          </div>
        </div>
        <div class="w-100"></div>
        <div class="col-3">
          <div class="label">郵便番号</div>
          <div class=" waku">
            <?php echo $postNumber;?>
          </div>
        </div>
        <div class="col-12">
          <div class="label">住所</div>
          <div class=" waku">
            <?php echo $address;?>
          </div>
        </div>
        <div class="col-12">
          <div class="label">コメント欄（自由記入）</div>
          <div class=" waku">
            <?php echo $free;?>
          </div>
        </div>

    </div>

    <a class="btn btn-outline-primary" href="admin.php">管理画面TOPへ</a>
    <a class="btn btn-outline-primary" href="list.php">リスト表示画面へ</a>

  </div>
</div>


<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
