<?php

require_once 'db.php';

class code extends connect{
    function code_logined(){
        @session_start();
        if (!isset($_SESSION['code'])) {
            header('Location: index.php');
            exit;
        }
    }
    function code_unlogined(){
        @session_start();
        if (isset($_SESSION['code'])) {
            header('Location: main.php');
            exit;
        }
    }

    // ログアウト
    public function code_user_logout(){
        @session_start();
        if (isset($_SESSION["code"])) {
        $message = "ログアウトしました。";
        } else {
        $message = "セッションがタイムアウトしました。";
        };
        // セッション変数のクリア
        $_SESSION = array();
        // クッキーの削除
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        // セッションのクリア
        @session_destroy();
    }
    // 入力文字数のランダムなコードを作成
    public function makeRandStr($length) {
        $str = array_merge(range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }
    // コードがあるか確認
    public function check_code($code){
        try {
          $sql = "SELECT COUNT(codeCheck) FROM code WHERE codeCheck = :codeCheck";
          $codeCheck = $this->pdo()->prepare($sql);
          $codeCheck->bindParam(':codeCheck',$code, PDO::PARAM_STR);
          $result = $codeCheck->execute();
        } catch (PDOException $e) {
          exit('データベース接続失敗。'.$e->getMessage());
        }
        if($result['codeCheck']==null){$result = false;}else{$result = true;};
        return $result;
    }
    // コードを追加
    public function add_code($cdNumber,$number){
        $pdo = $this->pdo();
        // トランザクションを開始
        $pdo->beginTransaction();

        $i = 0;
        while($i < $number){
            $code1 = $this->makeRandStr(4);
            $code2 = $this->makeRandStr(4);
            $code3 = $this->makeRandStr(4);
            $codeCheck = $code1 . $code2 . $code3;

            if($this->check_code($codeCheck) === false){
                // クエリの実行
                $stmt = $pdo->prepare('INSERT INTO code (code1,code2,code3,codeCheck,cdNumber) VALUES (:code1,:code2,:code3,:codeCheck,:cdNumber)');
                $stmt->bindValue(':code1',$code1, PDO::PARAM_STR);
                $stmt->bindValue(':code2',$code2, PDO::PARAM_STR);
                $stmt->bindValue(':code3',$code3, PDO::PARAM_STR);
                $stmt->bindValue(':codeCheck',$codeCheck, PDO::PARAM_STR);
                $stmt->bindValue(':cdNumber',$cdNumber, PDO::PARAM_STR);
                $stmt->execute();
                $i++;
            }
            if($i > 10000){
                break;
            }

        };
        $pdo->commit();

        return $cdNumber .'枚用のコードが追加されました。';
    }
    // ユーザー情報を書き込み
    public function add_address($id,$name,$tel,$postNumber,$address,$free){
        $pdo = $this->pdo();
        date_default_timezone_set('Asia/Tokyo');
        $day = new DateTime('now');
        $dateTime = $day->format('Y年m月d日 H時i分s秒');
        $furagu = true;
        // クエリの実行
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE code SET name = :name , tel = :tel ,postNumber = :postNumber , address = :address , free = :free , codeDatetime = :codeDatetime , furagu = :furagu WHERE codeId = :id');
        $stmt->bindParam(':name',$name, PDO::PARAM_STR);
        $stmt->bindParam(':tel',$tel, PDO::PARAM_STR);
        $stmt->bindParam(':postNumber',$postNumber, PDO::PARAM_STR);
        $stmt->bindParam(':address',$address, PDO::PARAM_STR);
        $stmt->bindParam(':free',$free, PDO::PARAM_STR);
        $stmt->bindValue(':id',$id, PDO::PARAM_INT);
        $stmt->bindParam(':codeDatetime',$dateTime, PDO::PARAM_STR);
        $stmt->bindParam(':furagu',$furagu, PDO::PARAM_INT);
        $result = $stmt->execute();
        $pdo->commit();

        return $result;
    }
    // コードの情報を追加
    public function get_data($codeN){
        $sql = "SELECT * FROM code WHERE codeId = :codeId";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':codeId',$codeN, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    // CD枚数ごとの総数を取得
    function get_total($number){
        $stmt = $this->pdo()->prepare('SELECT COUNT(*) FROM code WHERE cdNumber = :cdNumber');
        $stmt->bindValue(':cdNumber',$number, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result;
    }
    // 入力が完了したコードの数
    function get_complete_num($number){
        $sql = "SELECT COUNT(*) FROM code WHERE cdNumber = :cdNumber AND furagu = true";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':cdNumber',$number, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if($result === null){
          $result = 0;
        }
        return $result;
    }
    // すべてのコード数
    function get_all_code_num(){
        $stmt = $this->pdo()->prepare('SELECT COUNT(*) FROM code');
        $stmt->execute();
        $all_code_number = $stmt->fetchColumn();

        return $all_code_number;
    }
    // 使用されていないコードを取得
    public function get_not_activate_code($check_code){
        $stmt = $this->pdo()->prepare('SELECT * FROM code WHERE codeCheck = ? AND furagu IS NULL');
        $stmt->execute([$check_code]);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    // 使用されたコード数
    function get_activate_code_num(){
        $stmt = $this->pdo()->prepare('SELECT furagu FROM code WHERE furagu = true');
        $stmt->execute();
        $complete_code_number = $stmt->fetchColumn();

        if($complete_code_number == NULL){
            $complete_code_number = 0;
        }
        return $complete_code_number;
    }
    // コードを名前か電話番号で検索
    public function search($query,$query2,$mode='option2'){
        if($mode==='option2'){
            $query = '%'.$query.'%';
            $query2 = '%'.$query2.'%';
            $stmt = $this->pdo()->prepare('SELECT * FROM code WHERE name like :query OR tel like :query2');
        }else{
            $stmt = $this->pdo()->prepare('SELECT * FROM code WHERE name = :query OR tel = :query2');
        }
        // クエリの実行
        $stmt->bindParam(':query',$query, PDO::PARAM_STR);
        $stmt->bindParam(':query2',$query2, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    // コードを無効化
    public function stop($stop_id){
        $stmt = $this->pdo()->prepare('UPDATE code SET stop = true WHERE codeId = :id');
        // クエリの実行
        $stmt->bindParam(':id',$stop_id, PDO::PARAM_STR);
        $stmt->execute();

        return '停止されました。';
    }
    //　プリントしていないコードを取得
    public function get_print_count($number){
        $sql = "SELECT COUNT(*) FROM code WHERE cdNumber = :cdNumber AND checkPrint IS NULL";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':cdNumber',$number, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    // プリントしていないコードのデータを取得
    public function get_print_item($cdNumber){
        $sql = "SELECT * FROM code WHERE cdNumber = :cdNumber AND checkPrint IS NULL";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':cdNumber',$cdNumber, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }
    public function activate_print($code_id){
        $stmt = $this->pdo()->prepare('UPDATE code SET checkPrint = 1 WHERE codeId = :id');
        $stmt->bindValue(':id',$code_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    // ページネーション
    public function get_pages($limit,$cdNumber){
        // CDごとの総数を取得
        $page_num = $this->get_total($cdNumber);
        // ページ送りが何ページ必要か計算
        return ceil($page_num / $limit);
    }
    // ページネーションのコンテンツを取得
    public function get_pages_item($cdNumber,$page,$limit){
        if($page > 1){
            $start = ($page * $limit) - $limit;
        }else{ $start = 0; }
        $sql = "SELECT * FROM code WHERE cdNumber = :cdNumber limit :number ,:limit";
        $stmt = $this->pdo()->prepare($sql);
        $stmt->bindValue(':cdNumber',$cdNumber, PDO::PARAM_INT);
        $stmt->bindValue(':number',$start, PDO::PARAM_INT);
        $stmt->bindValue(':limit',$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }

}
