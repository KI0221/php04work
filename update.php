<?php

// 0. SESSION開始！！
session_start();

// 1. ログインチェック処理！
require_once('funcs.php');

loginCheck();

//１．関数群の読み込み
require_once('funcs.php');

//２．データ登録SQL作成
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM gs_bookmark_table');
$status = $stmt->execute();

//３．データ表示
if ($status == false) {
    sql_error($stmt);
}

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

// 1.POSTデータ取得
$book_name = $_POST['book_name']; //名前を取得
$book_url = $_POST['book_url']; //URLを取得
$book_comment = $_POST['book_comment']; //コメントを取得
$id = $_POST['id']; //input type ="hidden"

// 2.DB接続
try {
    $db_name = 'gs_db_class';    //データベース名
    $db_id   = 'root';      //アカウント名
    $db_pw   = '';      //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

// 3.データ更新SQL作成
$stmt = $pdo->prepare('UPDATE gs_bookmark_table SET book_name = :book_name, book_url = :book_url, book_comment = :book_comment, date = sysdate() WHERE id=:id;');

// バインド変数を設定
$stmt->bindValue(':book_name', $book_name, PDO::PARAM_STR);// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':book_url', $book_url, PDO::PARAM_STR);
$stmt->bindValue(':book_comment', $book_comment, PDO::PARAM_STR);

$stmt->bindValue(':id', $id, PDO::PARAM_INT);// 数値の場合 PDO::PARAM_INT

//4. データ更新処理を実行する（SQL実行）
// SQL入力画面で実行ボタンを押すのと同じ
// $statusに成功か失敗かの結果が入る（true or false）
$status = $stmt->execute();// 実行

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit();
}

?>
