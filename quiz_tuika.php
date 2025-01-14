<?php
$message = ""; // メッセージ初期化

try {
    // データベース接続
    $ddh = new PDO('mysql:host=localhost;dbname=quiz', 'root', 'AdminDef');
    $ddh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $allowed_columns = ['id', 'content', 'is_Answer'];

    $data = $_POST;

    // フォームデータが送信された場合
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $question_content = isset($_POST['question_content']) ? $_POST['question_content'] : null;
        $choices = isset($_POST['choices']) ? $_POST['choices'] : [];
        $isAnswers = isset($_POST['is_Answers']) ? $_POST['is_Answers'] : []; // チェックされた項目のみ受け取る

        if ($question_content && !empty($choices)) {
            // 質問を `question` テーブルに挿入
            $stmt = $ddh->prepare("INSERT INTO question (content) VALUES (:content)");
            $stmt->execute([':content' => $question_content]);
            $question_id = $ddh->lastInsertId();

            // 選択肢を `choice` テーブルに挿入
            foreach ($choices as $index => $choice_content) {
                $isAnswer = in_array((string) $index, $isAnswers, true) ? "true" : "false";
                $stmt = $ddh->prepare("INSERT INTO choice (content1, is_Answer, question_id) VALUES (:content1, :is_Answer, :question_id)");
                $stmt->execute([
                    ':content1' => $choice_content,
                    ':is_Answer' => $isAnswer,
                    ':question_id' => $question_id
                ]);
            }

            // 成功メッセージを設定
            $message = "データが正常に追加されました。";
        } else {
            $message = "問題内容と選択肢を入力してください。";
        }
    }
} catch (Exception $e) {
    $message = "エラー: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題追加</title>
    <style>
        * {
            box-sizing: border-box;
        }

        p {
            font-size: 40px;
            color: #333;
            text-align: center;
            margin-bottom: 0px;
            vertical-align: top;
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

        form {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            height: 850px;
            width: 600px;
            margin: 4em auto;
            padding: 4em 2em;
            background: #fafafa;
            border: 2px solid #f5f5f5;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 4px;
            text-align: center;
        }

        input[type="text"] {
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
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            width: 150px;
        }

        input[type="submit"]:hover {
            background: #357bd8;
        }

        .button {
            background: #4a89dc;
            text-decoration: none;
            color: white;
            border: none;
            transition: background 0.3s ease;
            margin: 15px;
            padding: 13px 20px;
            font-size: 16px;
            border-radius: 5px;
            width: 150px;
        }

        .button:hover {
            background: #357bd8;
        }

        .message {
            color: green;
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <p>問題追加</p>
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <div>
            <label for="question_content">問題:</label>
            <input type="text" id="question_content" name="question_content" required>
        </div>

        <!-- 最初から4つの選択肢フォーム -->
        <div id="choices">
            <div>
                <label>選択肢 1:</label>
                <label>正解:</label>
                <input type="checkbox" name="is_Answers[]" value="0">
                <input type="text" name="choices[]" required>

            </div>
            <div>
                <label>選択肢 2:</label>
                <label>正解:</label>
                <input type="checkbox" name="is_Answers[]" value="1">
                <input type="text" name="choices[]" required>
            </div>
            <div>
                <label>選択肢 3:</label>
                <label>正解:</label>
                <input type="checkbox" name="is_Answers[]" value="2">
                <input type="text" name="choices[]" required>
            </div>
            <div>
                <label>選択肢 4:</label>
                <label>正解:</label>
                <input type="checkbox" name="is_Answers[]" value="3">
                <input type="text" name="choices[]" required>

            </div>
        </div>

        <!-- 送信ボタンをinput[type="submit"]に変更 -->
        <input type="submit" value="送信">
        <a href="./calendar.php" class="button">カレンダーに戻る</a>
    </form>
</body>

</html>