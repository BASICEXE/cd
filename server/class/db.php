<?php

// データベースの設定ファイルを読み込み
require_once 'core/config.php';

class connect{
    function pdo(){
        try {
            $pdo = new PDO(DB_HOST,DB_USERNAME,DB_PASSWORD,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES => false));
            } catch (PDOException $e) {
            exit('データベース接続失敗。'.$e->getMessage());
            die();
        }
        //エラーを表示してくれる。
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        return $pdo;
    }
    function select($sql){
        $select = $this->pdo();
        $stmt = $select->query($sql);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $items;
    }

    // テーブルの設定
    function set_table(){

$table[0] = <<< __SQL__
CREATE TABLE IF NOT EXISTS user (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(255),
password VARCHAR(255)
)engine=innodb default charset=utf8mb4;
__SQL__;


$table[1] = <<< __SQL__
CREATE TABLE IF NOT EXISTS code (
codeId INT AUTO_INCREMENT PRIMARY KEY,
code1 CHAR(4),
code2 CHAR(4),
code3 CHAR(4),
codeCheck VARCHAR(255),
postNumber CHAR(8),
address VARCHAR(255),
name VARCHAR(255),
tel VARCHAR(255),
free VARCHAR(400),
codeDatetime VARCHAR(255),
cdNumber INT,
checkPrint BOOLEAN,
furagu BOOLEAN,
stop BOOLEAN
)engine=innodb default charset=utf8mb4;
__SQL__;


        for($i = 0;$i < count($table); $i++){
        $db[$i] = $this->pdo()->exec($table[$i]);
            if($db[$i] === false) {
                $message = $this->pdo()->errorInfo(); exit;
            }
        }

    }

}



