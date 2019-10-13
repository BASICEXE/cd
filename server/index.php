<?php

require_once __DIR__ . '/functions.php';


require_once 'class/code.php';
$code = new code();
$code->code_unlogined();

require_once 'class/html.php';
$html = new html();

if($_REQUEST['sineup'] == true){

  if (!empty($_POST['code1']) && !empty($_POST['code2']) && !empty($_POST['code3'])) {

    $code1 = $html->h($_POST['code1']);
    $code2 = $html->h($_POST['code2']);
    $code3 = $html->h($_POST['code3']);

    $check_code = $code1.$code2.$code3;
    // コードを取得
    $result = $code->get_not_activate_code($check_code);
    // コードがあれば
    if(!empty($result)){
      foreach($result as $row){

        $_SESSION["code"] = array("id" => $row["codeId"]);
        header("Location: main.php");
        exit;

      };
    }else{
      $errorMessage = "有効なコードを入力してください。";
    }

  }else{
    $errorMessage = "コードを入力してください。";
  };

};


?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>&amp;antique CD予約 - シリアルコードを入力してください</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">
  <link rel="stylesheet" href="site.css">

</head>
<body>

<?php include("template/header.php"); ?>

<div class="container">
  <div class="section code_section">
    <h1 class="title">シークレットコードを入力してください</h1>
    <form action="index.php" method="post" oninput="checkAll(this)">
      <div class="row">
        <div class=" col-12 col-md-4 form-group">
          <input class="code1 form-control" type="text" maxlength="4" name="code1" value="<?php echo $html->value('code1'); ?>" pattern=".{4,}" required="required">
        </div>
        <div class=" col-12 col-md-4 form-group">
          <input class="code2 form-control" type="text" maxlength="4" name="code2" value="<?php echo $html->value('code2'); ?>" pattern=".{4,}" required="required">
        </div>
        <div class=" col-12 col-md-4 form-group">
          <input class="code3 form-control" type="text" maxlength="4" name="code3" value="<?php echo $html->value('code3'); ?>" pattern=".{4,}" required="required">
        </div>
      </div>
      <?php echo $html->errorMessage($errorMessage); ?>
      <input class="btn btn-success" type="submit" name="sineup" value="照会">
    </form>
  </div>
</div>

<?php include("template/footer.php"); ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$('input[name^="code1"]').keyup(function() {
  var txt = $(this).val().toUpperCase();
  $(this).val(txt);
  if ($(this).val().length >= $(this).attr('maxlength')) {
    $('input[name^="code2"]').focus();
  }
});
$('input[name^="code2"]').keyup(function() {
  var txt = $(this).val().toUpperCase();
  $(this).val(txt);
  if ($(this).val().length >= $(this).attr('maxlength')) {
    $('input[name^="code3"]').focus();
  }
});
$('input[name^="code3"]').keyup(function() {
  var txt = $(this).val().toUpperCase();
  $(this).val(txt);
});

$('form[data-validate]').on('input', function () {
  $(this).find(':submit').attr('disabled', !this.checkValidity());
});
</script>
</body>
</html>
