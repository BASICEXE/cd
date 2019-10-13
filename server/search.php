<?php

require_once __DIR__ . '/functions.php';

require_once 'class/user.php';
$user = new user();
$user->admin_user_logined();

require_once 'class/html.php';
$html = new html();

require_once 'class/code.php';
$code = new code();

if($_REQUEST['search'] == true && $_POST['mode']){
  if (!empty($_POST['search-text'])) {
    $query = $html->h($_POST['search-text']);
    $query2 = $html->h($_POST['search-text']);
    $mode = $html->h($_POST['mode']);

    // 検索を結果を取得
    $result = $code->search($query,$query2,$mode);

  }

}

if($_REQUEST['stop'] == true){
  if (!empty($_POST['stop-id'])) {
    $stop = $html->h($_POST['stop-id']);

    $message = $code->stop($stop);

  }

}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>管理画面 - 検索画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="site.css">

</head>
<body>

<?php include("template/header.php"); ?>


<div class="container">
  <div class="section">


    <h1 class="title">検索画面</h1>

    <form action="search.php" method="post" class="form-row code_add">
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="input-group">
          <input type="text" class="form-control" name="search-text" placeholder="名前もしくは電話番号" required="required">
          <div class="input-group-append">
            <input class="btn btn-outline-success" name="search" type="submit" value="検索">
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mode" id="mode" value="option1" checked>
          <label class="form-check-label" for="mode">完全一致検索</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="mode" id="mode2" value="option2">
          <label class="form-check-label" for="mode2">あいまい検索</label>
        </div>
      </div>

    </form>


    <?php echo $html->message($message); ?>

    <?php
      if($result == true){

      echo '<div class="table-responsive">';
      echo '<table class="table table-striped table-hover">';
      echo '<tr>';
      echo '<th scope="col">無効化</th><th scope="col">コード</th><th scope="col">お名前</th><th scope="col">電話番号</th><th scope="col">印刷</th><th scope="col">登録完了</th>';
      echo '</tr>';
      foreach($result as $row){
      echo '<tr>';
      echo '<td><form action="search.php" method="post"><input type="hidden" name="stop-id" value="'.$row['codeId'].'"><input class="btn btn-link" name="stop" type="submit" value="Stop"></form></td>';
      if($row["stop"] == 1){ $stop = 'stop';}else{ $stop = 'go';};
      echo '<td><a class="link '.$stop.'" data-toggle="modal" data-target="#exampleModal'. $html->h($row['codeId']) .'">'. 'XXXX' . '-' . $html->h($row['code2']) . '-' . $html->h($row['code3']) .'</a></td>';
      echo '<td>' . $html->h($row['name']) . '</td>';
      echo '<td><a class="link" data-toggle="modal" data-target="#tel'. $html->h($row['codeId']) .'">表示</a></td>';
      if( $row['checkPrint'] == null ){$print = 'まだ';}else{$print = '済';};
      echo '<td>'. $print .'</td>';
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

      }elseif($_REQUEST['search'] == true){
        echo '<div class="alert alert-warning" role="alert">該当なし</div>';
      }
    ?>


    <?php
      if($result == true){
        foreach($result as $row){ ?>
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
    <?php
        }
      };?>


    <?php
      if($result == true){
        foreach($result as $row){ ?>
      <div class="modal fade" id="tel<?php echo $html->h($row['codeId']);?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">

    <?php echo $html->h($row['tel']) ;?>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    <?php
        }
      };?>





    <a class="btn btn-outline-primary" href="admin.php">管理画面へ</a>
  </div>
</div>


<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
