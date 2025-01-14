<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>PHPを入力してみた</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            text-align: center;
        }

        .b {
            font-size: 35px;
            margin: 20px auto;
            color: #333;
        }

        .c {
            margin: 20px auto;
            text-align: center;
            font-size: 30px;
        }

        .d select {
            width: 80px;
            height: 50px;
            font-size: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }

        input[type="submit"] {
            margin-top: 20px;
            font-size: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #4A89DC;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #357bd8;
        }

        .button {
            margin-top: 40px;
            bottom: 50px;
            font-size: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            background: #4A89DC;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .button:hover {
            background: #357bd8;
        }
    </style>
</head>

<body>
    <form action="answer.php" method="get">
        <div class="d">
            <select name="計算">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        </select>
        </div>
        <p><input type="submit" value="回答を送信"></p>
        <a href="./main.php" class="button">メインメニュー</a>
    </form>
</body>

</html>