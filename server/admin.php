<?php

require_once __DIR__ . '/functions.php';
// logined_session();

require_once 'class/html.php';
$html = new html();

require_once 'class/user.php';
$user = new user();


require_once 'class/code.php';
$code = new code();

$user->admin_user_logined();

if($_REQUEST['code_add'] == true){
  if (!empty($_POST['number']) && !empty($_POST['cdNumber'])) {
    $number = $html->h($_POST['number']);
    $cdNumber = $html->h($_POST['cdNumber']);

    // コードを作成し結果を取得
    $message = $code->add_code($cdNumber,$number);

  }else{
    $errorMessage = '<div class="alert alert-warning" role="alert">発行数の数値を入力してください</div>';
  }
}

function codePrint($number){
  // global $pdo;
  // $sql = "SELECT COUNT(*) FROM code WHERE cdNumber = :cdNumber AND checkPrint IS NULL";
  // $stmt = $pdo->prepare($sql);
  // $stmt->bindValue(':cdNumber',$number, PDO::PARAM_INT);
  // $stmt->execute();
  // $print = $stmt->fetchColumn();
  $print = $code->get_print_count();
  if($print!==0){
    $result = '<a class="btn btn-outline-primary" href="codePrint.php?cd='.$number.'" target=”_blank”>一括印刷</a>';
  }else{
    $result = '';
  }
  return $result;
}


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


    <h1 class="title">シリアルコード追加画面</h1>

    <form action="admin.php" method="post" class="code_add form-row">
      <div class="col-sm-12 col-md-6 mb-3">
        <label class="" for="inlineFormCustomSelect">CD枚数</label>
        <select class="custom-select col-6" id="inlineFormCustomSelect" name="cdNumber">
          <option value="1" selected>1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
        <span id="emailHelp" class="form-text text-muted">CD枚数〇〇枚用のコードを発行します。</span>
      </div>
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="input-group">
          <input type="number" class="form-control" name="number" min="1" max="300" placeholder="発行数を入力" required="required">
          <div class="input-group-append">
            <input class="btn btn-outline-success" name="code_add" type="submit" value="コードを追加">
          </div>
        </div>
        <span id="emailHelp" class="form-text text-muted">1〜300までの間で入力してください。</span>

        <?php echo $html->errorMessage($errorMessage); ?>
      </div>
    </form>

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

    <?php
      $complete_code_number = $code->get_activate_code_num();
      $all_code_number = $code->get_all_code_num();
      // $thml->progress($all_code_number,$complete_code_number);
    ?>

    <?php echo $html->message($message); ?>


    <div class="row">
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title codeC1">1枚用</div>
            <div class="card-subtitle mb-2 text-muted">発行数 <?php echo $code->get_total(1);?></div>
            <div class="card-subtitle mb-2 text-muted">完了数 <?php echo $code->get_complete_num(1);?></div>
            <a class="btn btn-outline-primary" href="list.php?cd=1">一覧画面へ</a>
            <?php
            $print = $code->get_print_count(1);
            echo $html->print_btn($print,1);?>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title codeC2">2枚用</div>
            <div class="card-subtitle mb-2 text-muted">発行数 <?php echo $code->get_total(2);?></div>
            <div class="card-subtitle mb-2 text-muted">完了数 <?php echo $code->get_complete_num(2);?></div>
            <a class="btn btn-outline-primary" href="list.php?cd=2">一覧画面へ</a>
            <?php
            $print = $code->get_print_count(2);
            echo $html->print_btn($print,2);?>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title codeC3">3枚用</div>
            <div class="card-subtitle mb-2 text-muted">発行数 <?php echo $code->get_total(3);?></div>
            <div class="card-subtitle mb-2 text-muted">完了数 <?php echo $code->get_complete_num(3);?></div>
            <a class="btn btn-outline-primary" href="list.php?cd=3">一覧画面へ</a>
            <?php
            $print = $code->get_print_count(3);
            echo $html->print_btn($print,3);?>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title codeC4">4枚用</div>
            <div class="card-subtitle mb-2 text-muted">発行数 <?php echo $code->get_total(4);?></div>
            <div class="card-subtitle mb-2 text-muted">完了数 <?php echo $code->get_complete_num(4);?></div>
            <a class="btn btn-outline-primary" href="list.php?cd=4">一覧画面へ</a>
            <?php
            $print = $code->get_print_count(4);
            echo $html->print_btn($print,4);?>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title codeC5">5枚用</div>
            <div class="card-subtitle mb-2 text-muted">発行数 <?php echo $code->get_total(5);?></div>
            <div class="card-subtitle mb-2 text-muted">完了数 <?php echo $code->get_complete_num(5);?></div>
            <a class="btn btn-outline-primary" href="list.php?cd=5">一覧画面へ</a>
            <?php
            $print = $code->get_print_count(5);
            echo $html->print_btn($print,5);?>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>


<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
