<?php
$errormessage = array();

$mysqli = new mysqli('localhost', 'root', 'root', 'todolist');

// 追加ボタンを押したとき
if (isset($_POST['add'])) {
  $todo = $_POST['todo'];

  if ($mysqli->connect_errno) {
    $errormessage[] = 'データベース接続に失敗しました';
  } else {
    // データを保存
    $mysqli->query("INSERT INTO todo (text) VALUES ('$todo')");

    $mysqli->close();
  }
}

// 削除ボタンを押したとき
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];

  if ($mysqli->connect_errno) {
    $errormessage[] = 'データベース接続に失敗しました';
  } else {
    // データを削除
    $mysqli->query("DELETE FROM todo WHERE id=$id");

    $mysqli->close();
  }
}
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>ToDoリスト</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <div class="wrapper">

      <h1>ToDoリスト</h1>

      <?php
      if ($errormessage) {
        echo '<div class="errormessage">';
        echo implode("<br>", $errormessage);
        echo '</div>';
      }
      ?>

      <form action="index.php" method="post">
        <div class="add-box">
          <input type="text" name="todo" value="" placeholder="ToDo">
          <input class="addbtn" type="submit" name="add" value="追加">
        </div>
      </form>

      <?php
      $mysqli = new mysqli('localhost', 'root', 'root', 'todolist');
      $result = $mysqli->query("SELECT * FROM todo");
      ?>

      <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
          <li>
            <?php echo $row['text']; ?>
          　<a class="deletebtn" href="index.php?delete=<?php echo $row['id']; ?>">削除</a>
          </li>
        <?php } ?>
      </ul>

    </div>
  </body>
</html>
