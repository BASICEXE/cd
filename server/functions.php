<?php

require_once __DIR__ . '/core/config.php';

// クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
// ファイル名
$file_name = basename($_SERVER['PHP_SELF']);

