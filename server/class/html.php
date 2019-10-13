<?php
class html{
    public function h($str){
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    public function value($value){
        if( !empty($_POST[$value]) ){
            return $this->h($_POST[$value]);
        }
    }
    public function message($message){
        if($message){
            return  '<div class="alert alert-success" role="alert">'. $this->h($message) .'</div>';
        }
    }
    public function errorMessage($errorMessage){
        if($errorMessage){
            return  '<div class="alert alert-danger" role="alert">'. $this->h($errorMessage) .'</div>';
        }else {
            return '';
        }
    }
    public function progress($all_code_number,$complete_code_number){
        if(! $complete_code_number == 0){
            $progress = $complete_code_number / $all_code_number * 100;
            $progressbar= '<div class="progressBar"><span>進捗率　全体 '.$all_code_number.'</span> / <span>完了 '.$complete_code_number.'</span><div class="progress"><div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: '. ceil($progress) .'%" aria-valuenow="'. ceil($progress) .'" aria-valuemin="0" aria-valuemax="100"></div></div></div>';
        }else{
            $progressbar = '';
        }
        return $progressbar;
    }
    // コードがあったら印刷用のボタンを表示
    public function print_btn($print,$cdNumber){
        if($print!==0){
            $result = '<a class="btn btn-outline-primary" href="codePrint.php?cd='.$cdNumber.'" target=”_blank”>一括印刷</a>';
        }else{
            $result = '';
        }
        return $result;
    }
    // ページネーション
    public function pagination($pagination,$cdNumber){
        $item = '';
        for ($x=1; $x <= $pagination ; $x++) {
            $item .= '<li class="page-item"><a class="page-link" href="?page='. $x . '&cd='. $cdNumber .'">'.$x.'</a></li>';
        }
        return '<nav aria-label="Page navigation example"><ul class="pagination">'.$item.'</ul></nav>';
    }
}