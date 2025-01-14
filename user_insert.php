<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>会員登録</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #eee;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    p {
      font-size: 40px;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }

    form {
      border-radius: 10px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  height: 500px; /* 高さを指定して縦長に */
  width: 400px;
  margin: 4em auto;
  padding: 4em 2em; /* パディングを増やして内部スペースを拡大 */
  background: #fafafa;
  border: 2px solid #f5f5f5	;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 4px;
  text-align: center;
    }

    input[type="text"], input[type="submit"] {
      font-size: 16px;
      margin: 15px 0;
      padding: 10px;
      width: 100%;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    input[type="text"]:focus {
      border-color: #4a89dc;
      outline: none;
      background: #fefefe;
    }

    input[type="submit"] {
      background: #4a89dc;
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
      background: #357bd8;
    }
    .button051{
      position: absolute;
text-decoration: none;
font-size:17px;
font-weight: bold;
width: 330px;
display: block;
text-align: center;
margin-bottom: 20px;
padding: 1rem 4rem;
bottom:320px;
transition: 0.5s;
color:#4a89dc;

}
.button051:hover{
  text-decoration: underline;

}

  </style>
</head>
<body>
<a href=./login.php class="button051">ログインへ</a>
<form action="user_authentication.php" method="POST">
<p>ユーザー登録</p>
<input type="text" name=username placeholder="ユーザー名">
<input type="submit" name="ans" value="ユーザー登録">

</body>
</html>
