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

<?php session_start();?>
<?php
    $ddh=new PDO('mysql:host=localhost;dbname=quiz','root','AdminDef');
    if (isset($_SESSION['user1'])) {
        $id=$_SESSION['user1']['id'];
        $sql= $ddh->prepare('select * from user where id!=? and username=?;');
        $sql->execute([$id,$_REQUEST['username']]);
       
    }
    else{
        $sql=$ddh->prepare('select * from user where username=?;');
        $sql->execute([$_REQUEST['username']]);
    }
if (empty($sql->fetchALL())) {
    if (isset($_SESSION['user1'])) {
        $sql= $ddh->prepare('update user set username=? where id=?');
        $sql->execute([$_REQUEST['username'],$id]);
        $_SESSION['user1']=['id'=>$id,'name'=>$_REQUEST['username']];
        echo "<div class='message'>";
        echo "ユーザ情報を更新しました";
        echo "</div>";
        echo "<a href='./calendar.php' class='calendar'>カレンダー画面</a>";
    }
    else {
        $sql1=$ddh->prepare("insert into user values(null,?)");
         $sql1->execute([$_REQUEST['username']]);
         echo "<div class='message'>";
         echo "ユーザ情報登録完了";
         echo "</div>";
         echo "<a href='./calendar.php' class='calendar'>カレンダー画面</a>";
    }  
    }
    else {
        echo "<div class='message'>同じログイン名があります！変更してください</div>";
        echo "<a href='./user_insert.php' class='calendar'>会員登録</a>";
        
    }
?>

</body>


</html>
