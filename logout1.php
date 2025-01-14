<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>PHPを入力してみた</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eee;
      margin: 0;
      padding: 0;
      display: flex; /* 中央揃えの準備 */
      justify-content: center; /* 水平方向に中央揃え */
      align-items: center; /* 垂直方向に中央揃え */
      height: 100vh; /* 画面全体をカバー */
      text-align: center; /* テキスト中央揃え */
    }

    .message {
      font-size: 80px; /* フォントサイズを大きく */
      color: #333; /* テキストカラー */
      position:relative;
      margin-bottom: 200px; /* 余白 */
      text-align: center;
    }

    .main {
      display: inline-block;
      padding: 10px 20px;
      text-decoration: none;
      font-size: 40px;
      color: #4a89dc; 
      position:absolute;
      bottom: 400px;
    }

    .main:hover {
        text-decoration:underline;
    }
  </style>
</head>
<body>

<?php session_cache_limiter('none');?>
<?php session_start();?>
<?php
   if(isset($_SESSION['user1'])){
    unset($_SESSION['user1']);
    echo "<div class='message'>";
    echo 'ログアウトしました';
    echo "</div>";
    echo "<a href='./main.php' class='main'>メインメニューへ戻る</a>";
   }
   else{
    echo "<div class='message'>";
    echo 'ログインしていません';
    echo "</div>";
    echo "<a href='./main.php' class='main'>メインメニューへ戻る</a>";


   }
?>
</body>
</html>
