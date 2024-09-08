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
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ブックマーク表示</title>
  <link rel="stylesheet" href="css/range.css">
  <link href="css/style.css" rel="stylesheet">
</head>

<body id="main">
  <header>
    <nav>
      <a href="index.php">ブックマーク登録</a>
　　　　<form method="POST" action="logout.php">
    　　　<button type="submit">ログアウト</button>
　　　　</form>
    </nav>
  </header>

  <main>
    <div class="container">
      <h1>ブックマーク一覧</h1>
      <div class="survey-list">
        <!-- PHP でデータを取得し、以下の形式で表示する -->
         <!-- //while：繰り返し文 -->
        <?php while ($result = $stmt->fetch(PDO::FETCH_ASSOC)): ?> 
          <p> 
          <a href="detail.php?id=<?php echo htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8')?>">
            <?= htmlspecialchars($result['date'], ENT_QUOTES, 'UTF-8') ?> : 
            <?= htmlspecialchars($result['book_name'], ENT_QUOTES, 'UTF-8') ?> -
            <?= htmlspecialchars($result['book_comment'], ENT_QUOTES, 'UTF-8') ?> 
          </a>
          <form method="POST" action="delete.php">
		        <input type="hidden" name="id" value="<?= htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8') ?>">
		        <input type="submit" value="削除">
		      </form>
          </p>
        <?php endwhile; ?>

      </div>
    </div>
  </main>

</body>

</html>