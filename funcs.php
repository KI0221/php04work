<?php

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続
function db_conn()
{
    try {
        $db_name = 'gs_db_class';    //データベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = '';      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = 'localhost'; //DBホスト
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}

//リダイレクト
function redirect($file_name)
{
    header('Location: ' . $file_name);
    exit();
}


// ログインチェク処理 loginCheck()
function loginCheck()
{
    // ログインチェック処理！
    // 以下、セッションID持ってたら、ok
    // 持ってなければ、閲覧できない処理にする。
    // 「!」は「≠」を示す
    // 「｜｜」は「or」を示す
    if (!isset($_SESSION['chk_ssid']) ||$_SESSION['chk_ssid']!= session_id()){
        header('Location:login.php');
        exit('LOGIN ERROR');
    }
    
    // session idを変更して保存し直す
    session_regenerate_id();
    $_SESSION['chk_ssid'] = session_id();
}
