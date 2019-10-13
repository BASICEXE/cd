<?php

require_once __DIR__ . '/functions.php';

require_once 'class/user.php';
$user = new user();
$user->admin_user_logined();

require_once 'class/html.php';
$html = new html();

require_once 'class/code.php';
$code = new code();

// 一ページに表示するコードの数
$limit = 25;

// 現在のページ数
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// 表示するCD枚数
$cdNumber = isset($_GET['cd']) ? (int)$_GET['cd'] : 1;


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面 - シリアルコード追加</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="site.css">

</head>
<body>

<?php include("template/header.php"); ?>

<div class="container">
  <div class="section">

    <h1 class="title"><?php echo $cdNumber; ?>枚用シリアルコード一覧画面</h1>
    <?php
      // コンテンツを取得
      $result = $code->get_pages_item($cdNumber,$page,$limit);
      echo '<div class="table-responsive">';
      echo '<table class="table table-striped table-hover">';
      echo '<tr>';
      echo '<th scope="col">コード</th><th scope="col">印刷</th><th scope="col">登録完了</th>';
      echo '</tr>';
      foreach($result as $row){
      echo '<tr>';
      // echo '<td>'. h($row['code1']) . '-' . h($row['code2']) . '-' . h($row['code3']) .'</td>';
      if($row["stop"] == 1){ $stop = 'stop';}else{ $stop = 'go';};
      echo '<td><a class="link '. $stop .'" data-toggle="modal" data-target="#exampleModal'. $html->h($row['codeId']) .'">'. 'XXXX' . '-' . $html->h($row['code2']) . '-' . $html->h($row['code3']) .'</a></td>';
      if( $row['checkPrint'] == null ){$print = 'まだ';}else{$print = '済';};
      echo '<td>'. $print .'</td>';
      // echo '<td>'. h($row['name']) .'</td>';
      // echo '<td>'. h($row['postNumber']) .'</td>';
      // echo '<td>'. h($row['address']) .'</td>';
      // echo '<td>'. $row['free'] .'</td>';
      $check = $html->h($row['furagu']);
      if($check == true){
        echo '<td><a href="pages.php?code='. $html->h($row['codeId']) .'">完了</a></td>';
      }else{
        echo '<td>受付中</td>';
      }
      echo '</tr>';
      };
      echo '</table>';
      echo '</div>';
    ?>

    <?php foreach($result as $row){ ?>
      <div class="modal fade" id="exampleModal<?php echo $html->h($row['codeId']);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">

    <?php echo $html->h($row['code1']) . '-' . $html->h($row['code2']) . '-' . $html->h($row['code3']);?>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <?php };?>

    <?php // ページネーションを取得
    $pagination = $code->get_pages($limit,$cdNumber);
    echo $html->pagination($pagination,$cdNumber); ?>

    <a class="btn btn-outline-primary" href="admin.php">管理画面へ</a>

  </div>
</div>

<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
