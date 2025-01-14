<html>

<head>
    <link rel="stylesheet" href="ans.css" type="text/css">
    <style>
        .ans {
            text-align: center;
            font-size: 40px;
        }

        input[type="submit"] {
            position: center;
            text-align: center;
            color: white;
            background: #4A89DC;
            font-size: 30px;
            position: relative;
            bottom: -40px;
            left: 850px;
            font-size: 16px;
            margin: 15px 0;
            padding: 10px;
            width: 10%;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #4A89DC;
            color: white;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    error_reporting(E_ALL);

    try {
        $ddh = new PDO('mysql:host=localhost;dbname=quiz', 'root', 'AdminDef');
        $ddh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db = "SELECT question.content, choice.content1 
           FROM question 
           INNER JOIN choice ON question.id = choice.question_id 
           WHERE choice.question_id = ? AND choice.is_answer = ?";
        $a = 'true';
        $b = $_SESSION['quiz']['ans'];
        $sql = $ddh->prepare($db);
        $sql->execute([$b, $a]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        echo "<br><br><br><br><br><br><br>";
        $get = $_GET["計算"];
        echo "<div class='ans'>";

        if ($result) {
            echo "正解：" . htmlspecialchars($result['content1'], ENT_QUOTES, 'UTF-8');
        } else {
            echo "正解データが見つかりません。";
        }

        echo "<br>";
        echo "選んだ回答：" . htmlspecialchars($get, ENT_QUOTES, 'UTF-8');
        echo "</div>";
    } catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
    }
    ?>
    <form action="que.php" method="get">
        <input type="submit" value="次の問題へ">
    </form>

</body>

</html>