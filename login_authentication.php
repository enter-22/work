<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
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

    .calendar {
      display: inline-block;
      padding: 10px 20px;
      text-decoration: none;
      font-size: 40px;
      color: #4a89dc; 
      position:absolute;
      bottom: 400px;
    }

    .calendar:hover {
        text-decoration:underline;
    }
  </style>
</head>
<body>
  <?php session_start(); ?>
  <?php 
    $post = $_POST['user'];
    $ddh = new PDO('mysql:host=localhost;dbname=quiz', 'root', 'AdminDef');
    $db = "select * from user where username = ?;";
    $sql = $ddh->prepare($db);
    $sql->execute(array($post));
    if ($sql->rowCount() > 0) {
        foreach ($sql as $row) {
            $_SESSION['user1'] = array(     
                'id' => $row['id'],  
                'name' => $row['username']
            );
        }
    }
    if (isset($_SESSION['user1'])) {
      echo "<div class='message'>";
      echo 'ようこそ', $_SESSION['user1']['name'], 'さん。';
      echo "</div>";
      echo "<a href='./calendar.php' class='calendar'>カレンダー画面</a>";
    } else {
      echo "<div class='message'>ログイン名が違います。</div>";
      echo "<a href='./login.php' class='calendar'>ログイン</a>";

    }
  ?>
</body>
</html>