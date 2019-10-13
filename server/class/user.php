<?php

require_once 'db.php';

class user extends connect{
    // 管理者ユーザーの作成
    public function create_user($adminUser,$passWord){
        // Hashの計算コストを指定
        $options = array('cost' => 15);
        $hash = password_hash($passWord,PASSWORD_DEFAULT,$options);

        // ユーザーを作成
        $create_user = $this->pdo()->prepare("INSERT INTO user (name,password) VALUES ( :name ,:password )");
        $create_user->bindParam(':name',$adminUser, PDO::PARAM_STR);
        $create_user->bindParam(':password',$hash, PDO::PARAM_STR);
        $user = $create_user->execute();
        return $user;
    }
    // 管理者ユーザーがあるかチェック
    public function check_user(){
        $sql = "SELECT name FROM user";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();

        if(!empty($result)){
            return true;
        }else{
            return false;
        }
    }
    public function admin_user_logout(){
        @session_start();
        // セッション変数のクリア
        $_SESSION = array();
        // クッキーの削除
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        // セッションのクリア
        @session_destroy();

        if (!isset($_SESSION["login"])) {
            return "ログアウトしました。";
        }
    }
    public function admin_user_logined(){
        @session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: login.php');
            exit;
        }
    }
    public function admin_user_unlogined(){
        @session_start();
        if (isset($_SESSION['login'])) {
            header('Location: admin.php');
            exit;
        }
    }
    public function get_admin_user_pass($user_name){
        // クエリの実行
        $stmt = $this->pdo()->prepare('SELECT * FROM user WHERE name = ?');
        $stmt->execute([$user_name]);
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        $db_hashed_pwd = $row["password"];
        };
        return $db_hashed_pwd;
    }
}