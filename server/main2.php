<?php

require_once __DIR__ . '/functions.php';

require_once 'class/code.php';
$code = new code();
$code->code_logined();


require_once 'class/html.php';
$html = new html();

if ($_REQUEST['add2'] == true) {


  if (!empty($_POST['name']) && !empty($_POST['postNumber']) && !empty($_POST['address']) && !empty($_POST['tel']) && $_POST['ok'] == true) {

    $id = $_SESSION['code']['id'];
    $name = $html->h($_POST['name']);
    $tel = $html->h($_POST['tel']);
    $postNumber = $html->h($_POST['postNumber']);
    $address = $html->h($_POST['address']);
    $free = nl2br($html->h($_POST['free']));

    $result = $code->add_address($id, $name, $tel, $postNumber, $address, $free);

    if ($result === true) {
      header("Location: complete.php");
      exit;
    };
  } else {
    $errorMessage = "項目に入力してください。";
  };
};

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>&amp;antique CD予約 - 確認画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="site.css">
  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>

</head>

<body>

  <?php include("template/header.php"); ?>

  <div class="container">
    <div class="section code_section">
      <h1 class="title">送り先は間違いないですか？</h1>
      <form class="h-adr" action="main2.php" method="post" data-validate>
        <span class="p-country-name" style="display:none;">japan</span>
        <div class="form-row">
          <div class="form-group col-5">
            <label for="name">お名前</label>
            <input type="text" class="form-control mb-3" name="name" value="<?php echo $html->value('name'); ?>" required="required" readonly>
          </div>
          <div class="w-100"></div>
          <div class="form-group col-5">
            <label for="tel">電話番号</label>
            <input type="text" class="form-control mb-3" name="tel" value="<?php echo $html->value('tel'); ?>" required="required" readonly>
            <span id="emailhelp" class="form-text text-muted">000-0000-00000</span>
          </div>
          <div class="w-100"></div>
          <div class="form-group col-3">
            <label for="postnumber">郵便番号</label>
            <input type="text" class="form-control p-postal-code" name="postNumber" maxlength="8" value="<?php echo $html->value('postNumber'); ?>" pattern="\d{3}-\d{4}" required="required" readonly>
            <span id="emailhelp" class="form-text text-muted">000-0000</span>
          </div>
          <div class="form-group col-12">
            <label for="address">住所</label>
            <input type="text" class="form-control p-region p-locality p-street-address p-extended-address" name="address" value="<?php echo $html->value('address'); ?>" required="required" readonly>
          </div>
          <div class="form-group col-12">
            <label for="free">コメント欄（自由記入）</label>
            <textarea class="form-control" name="free" cols="30" rows="10" readonly><?php echo $html->value('free'); ?></textarea>
          </div>
        </div>
        <div class="form-group col-12">
          <p>このコードは一度しか使用できません。よろしいですか？</p>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="customcheck1" name="ok" required="required">
            <label class="custom-control-label" for="customcheck1">はい</label>
          </div>
        </div>
        <span class="info">※ 送料はお客様負担となります。</span>
        <?php echo $html->errormessage($errormessage); ?>
        <input class="btn btn-md btn-success" name="add2" type="submit" value="登録">
        <a href="main.php" class="btn btn-md btn-success">再入力</a>
      </form>
    </div>
  </div>

  <?php include("template/footer.php"); ?>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
