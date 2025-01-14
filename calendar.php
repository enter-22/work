<?php
session_start();

$today = filter_input(INPUT_POST, 'today');
$monthNext = filter_input(INPUT_POST, 'monthNext');
$yearNext = filter_input(INPUT_POST, 'yearNext');
$monthPrev = filter_input(INPUT_POST, 'monthPrev');
$yearPrev = filter_input(INPUT_POST, 'yearPrev');
$in = filter_input(INPUT_POST, 'in');

if ($today == 1) {
  $month = date('n');
  $year = date('Y');
}
if ($monthNext > 12) {
  $monthNext = 1;
  $yearNext++;
}
if ($monthPrev === "0") {
  $monthPrev = 12;
  $yearPrev--;
}
$month = $monthNext ?? $monthPrev ?? date('n');
$year = $yearNext ?? $yearPrev ?? date('Y');

$today_date = date('j');

$last_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));
$calendar = array();
$j = 0;



for ($i = 1; $i < $last_day + 1; $i++) {
  $week = date('w', mktime(0, 0, 0, $month, $i, $year));
  if ($i == 1) {
    for ($s = 1; $s <= $week; $s++) {
      $calendar[$j]['day'] = '';
      $j++;
    }
  }
  $calendar[$j]['day'] = $i;
  $j++;
  if ($i == $last_day) {
    for ($e = 1; $e <= 6 - $week; $e++) {
      $calendar[$j]['day'] = '';
      $j++;
    }
  }
}


if ($in == "present" && $month == date('n') && $year == date('Y')) {
  if (!isset($_SESSION['highlight_days'])) {
    $_SESSION['highlight_days'] = [];
  }
  if (!in_array($today_date, $_SESSION['highlight_days'])) {
    $_SESSION['highlight_days'][] = $today_date;
  }
}


$highlight_days = isset($_SESSION['highlight_days']) ? $_SESSION['highlight_days'] : [];
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>カレンダー</title>
  <style>
    body {
      font-family: Helvetica, Arial, sans-serif;
      background: #eee;
      -webkit-font-smoothing: antialiased;
      margin: 0;
      padding: 0;
      display: flex;
      /* フレックスボックスを有効化 */
      justify-content: center;
      /* 水平方向中央揃え */
      align-items: center;
      /* 垂直方向中央揃え */
    }

    table {
      border: 2px solid black;
      border-collapse: collapse;
      margin: 50px auto;
      width: 80%;
      background-color: #ffffff;
    }

    thead {
      background: #DDFFFF;
    }

    thead tr:first-child {
      width: 50px;
      height: 70px;
      text-align: center;
      line-height: 70px;
    }

    thead tr:nth-child(2) {
      width: 50px;
      height: 30px;
      text-align: center;
      line-height: 30px;
    }

    #prev,
    #next {
      background-color: #FFEEFF;
      border: 0px none;
      cursor: pointer;
      user-select: none;
      font-size: 30px;
    }

    tbody td {
      border: 2px solid black;
      position: relative;
      height: 80px;
      width: 80px;
    }

    tbody td:last-child,
    .blue {
      color: blue;
    }

    tbody td:first-child,
    .red {
      color: red;
    }

    tbody .schedules {
      margin-top: 25px;
    }

    tbody .schedule {
      margin: 0 auto 5px;
      text-align: center;
    }

    tbody button {
      border: none;
      background-color: transparent;
      font-weight: bold;
      text-decoration: underline;
    }

    tbody button:hover {
      background-color: #EEFFFF;
    }

    tbody p {
      position: absolute;
      top: 3px;
      left: 3px;
    }

    tfoot {
      background: #FFEEFF;
      font-weight: bold;
      text-align: center;
    }

    tfoot tr {
      width: 50px;
      height: 70px;
      text-align: center;
      line-height: 70px;
    }

    td.today {
      background-color: #00ff00;
    }

    #today {
      cursor: pointer;
      user-select: none;
      font-size: 40px;
      background-color: #00ff00;
      border: 0px none;
    }

    #title {
      font-size: 30px;
    }

    .btn-container {
      margin-bottom: 20px;
    }

    .btn {
      position: absolute;
      display: inline-block;
      text-decoration: none;
      font-size: 70px;
      font-weight: bold;
      width: 330px;
      border-radius: 5px;
      border: none;
      text-align: center;
      padding: 1rem 4rem;
      bottom: 120px;
      transition: 0.5s;
      color: #4a89dc;
      left: 600px;
    }

    .que {
      position: fixed;
      display: inline-block;
      text-decoration: none;
      padding: 1rem 2rem;
      font-size: 50px;
      text-align: center;
      bottom: 80px;
      right: 450px;
      width: 450px;
      transition: 0.5s;
      background-color: #ffffff;
    }

    .que:focus {
      background-color: gray;
    }

    .que:hover {
      background-color: #c0c0c0;
    }

    .insert {
      position: fixed;
      display: inline-block;
      text-decoration: none;
      padding: 1rem 2rem;
      font-size: 50px;
      text-align: center;
      width: 450px;
      bottom: 200px;
      right: 450px;
      transition: 0.5s;
      background-color: #ffffff;
    }

    .insert:focus {
      background-color: gray;
    }

    .insert:hover {
      background-color: #c0c0c0;
    }

    .present {
      background-color: #4CAF50;
      color: white;
    }

    .present:hover {
      background-color: #45a049;
    }

    .highlight {
      background-color: lightgreen;
    }
  </style>
</head>

<body>
  <table>
    <thead>
      <tr>
        <form action="" method="post">
          <th><button type="submit" id="prev">
              &laquo;
              <input type="hidden" name="monthPrev" value="<?php echo $month - 1; ?>">
              <input type="hidden" name="yearPrev" value="<?php echo $year; ?>">
            </button></th>
        </form>
        <th id="title" colspan="5"><?php echo $year; ?>年<?php echo $month; ?>月
        </th>
        <form action="" method="post">
          <th><button type="submit" id="next">
              &raquo;
              <input type="hidden" name="monthNext" value="<?php echo $month + 1; ?>">
              <input type="hidden" name="yearNext" value="<?php echo $year; ?>">
            </button></th>
        </form>
        <form action="" method="post">
          <button type="submit" name="in" value="present" class="btn present">出席</button>
        </form>
        <form action="que.php" method="post">
          <button type="submit" name="in" value="present" class="que">問題演習を開始</button>
        </form>
        <form action="quiz_tuika.php" method="post">
          <button type="submit" class="insert">問題追加</button>
        </form>

      </tr>
      <tr>
        <th class="red">日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th class="blue">土</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php $cnt = 0; ?>
        <?php foreach ($calendar as $key => $value): ?>
          <td <?php
          if (in_array($value['day'], $highlight_days)) {
            echo 'class="highlight"';
          }
          ?>>

            <p>
              <?php $cnt++; ?>
              <?php echo $value['day']; ?>
            </p>
          </td>
          <?php if ($cnt == 7): ?>
          </tr>
          <tr>
            <?php $cnt = 0; ?>
          <?php endif; ?>
        <?php endforeach; ?>
      </tr>
    </tbody>
    </tfoot>
  </table>
</body>

</html>