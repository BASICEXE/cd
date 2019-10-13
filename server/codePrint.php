<?php

require_once __DIR__ . '/functions.php';


require_once 'class/user.php';
$user = new user();
$user->admin_user_logined();

require_once 'class/code.php';
$code = new code();

require_once 'class/html.php';
$html = new html();

// 表示するCD枚数
$cdNumber = isset($_GET['cd']) ? (int)$_GET['cd'] : 1;

// CDナンバーによって色設定を変更
switch($cdNumber){
case 1:
  $cdColorR = 46;
  $cdColorG = 125;
  $cdColorB = 50;
  break;
case 2:
  $cdColorR = 255;
  $cdColorG = 111;
  $cdColorB = 0;
  break;
case 3:
  $cdColorR = 3;
  $cdColorG = 169;
  $cdColorB = 224;
  break;
case 4:
  $cdColorR = 239;
  $cdColorG = 83;
  $cdColorB = 80;
  break;
case 5:
  $cdColorR = 74;
  $cdColorG = 20;
  $cdColorB = 140;
  break;
}



use setasign\Fpdi;
require_once __DIR__ . '/lib/tcpdf/tcpdf.php';
require_once __DIR__ . '/lib/pdfi/src/autoload.php';

// プリントされていないコードを取得
$print = $code->get_print_count($cdNumber);

if($print!==0){

// プリントされていないコードのデータを取得
$result = $code->get_print_item($cdNumber);


// $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
// $pdf = new setasign\Fpdi\Fpdi();

class Pdf extends Fpdi\TcpdfFpdi{};
$pdf = new Pdf();

// フォントを登録

$pdf->SetFont('kozgopromedium', '', 18);

$pdf->SetMargins(0,0,0); // 上左右マージンの設定
$pdf->SetCellPadding(0); // セルパディングの設定
$pdf->SetAutoPageBreak(false); // 自動改ページを無効
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// ページを追加
foreach($result as $row){

  $txt = $html->h($row['code1']) . '  ' . $html->h($row['code2']) . '  ' . $html->h($row['code3']);

  $pdf->AddPage('L','A6');
  $pdf->SetXY(45, 43);
  // 文字列を書き込む
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFontSize(20);
  $pdf->Write(0, $txt);
  $pdf->SetFontSize(12);
  $pdf->SetTextColor($cdColorR,$cdColorG,$cdColorB);
  $pdf->Text( 55, 38, "シークレットコード" );
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFontSize(24);
  $pdf->Text( 40, 20, "&antique CD予約" );
  $pdf->SetFontSize(14);
  $pdf->Text( 60, 65, "https://andantique.online/" );
  $pdf->SetFontSize(12);
  $pdf->Text( 60, 73, "サイトからCDの予約が行えます。" );
  $x = $pdf->getX();
  $y = $pdf->getY();
  $pdf->Image(__DIR__ . '/images/f00671_2.png', 6, 5, 135);
  $pdf->Image(__DIR__ . '/images/andantique.png', 28, 58, 30);

  // pdf化したデータをプリント済みとして登録
  $code->activate_print($row['codeId']);
}


$day = new DateTime();
$time = $day->format('Y-m-d-H-i-s');
$pdf->Output($time."cd".$cdNumber.".pdf",'D');

}else{
  echo "<script type='text/javascript'>window.close();</script>";
};

?>
