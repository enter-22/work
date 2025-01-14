<?php
session_start();
error_reporting(E_ALL);

try {
  $ddh = new PDO('mysql:host=localhost;dbname=quiz', 'root', 'AdminDef');
  $ddh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // データベースから最大IDを取得
  $max_id_query = $ddh->query("SELECT MAX(id) AS max_id FROM question");
  $max_id = $max_id_query->fetch(PDO::FETCH_ASSOC)['max_id'];

  if (!$max_id) {
    throw new Exception("問題がデータベースに存在しません。");
  }

  // 存在する問題IDをランダムに選択
  $question_id = rand(1, $max_id);
  $valid_id_query = $ddh->prepare("SELECT id FROM question WHERE id = ?");
  $valid_id_query->execute([$question_id]);

  while ($valid_id_query->rowCount() == 0) {
    $question_id = rand(1, $max_id);
    $valid_id_query->execute([$question_id]);
  }

  $_SESSION['quiz']['ans'] = $question_id;

  // クエリの準備と実行
  $sql = $ddh->prepare("SELECT question.content, choice.content1, choice.is_answer 
                          FROM question 
                          INNER JOIN choice ON question.id = choice.question_id 
                          WHERE question.id = ?");
  $sql->execute([$question_id]);
  $result = $sql->fetchAll(PDO::FETCH_ASSOC);

  // 結果の表示
  if ($result) {
    echo "<div class='b'>" . htmlspecialchars($result[0]['content'], ENT_QUOTES, 'UTF-8') . "</div>";
    foreach ($result as $row) {
      echo "<div class='c'>" . htmlspecialchars($row['content1'], ENT_QUOTES, 'UTF-8') . "</div>";
    }
  } else {
    echo "データが見つかりません。";
  }
} catch (PDOException $e) {
  echo "データベースエラー: " . $e->getMessage();
} catch (Exception $e) {
  echo "エラー: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>問題演習</title>

</head>

<body>
  <?php require "kuizu.php"; ?>
</body>

</html>