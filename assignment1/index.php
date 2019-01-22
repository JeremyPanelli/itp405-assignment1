<?php
  $pdo = new PDO('sqlite:chinook.db');
  $sql = "
    SELECT
      genres.Name
    FROM genres
  ";
  if (isset($_GET['search'])) {
    $sql = $sql . ' WHERE genres.Name = ?';
  }
  $statement = $pdo->prepare($sql);
  if (isset($_GET['search'])) {
    $statement->bindParam(1, $_GET['search']);
  }
  $statement->execute();
  $genres = $statement->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Week 2</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
</head>
<body>
  <form action="index.php" method="get">
    <input
      type="text"
      name="search"
      value="<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>">
    <button type="submit">Search</button>
    <a href="/" class="btn btn-default">Clear</a>
  </form>
  <table class="table">
    <tr>
      <th>Genres</th>
    </tr>
    <?php foreach($genres as $genre) : ?>
      <tr>
        <td>
            <?php echo "<a href='tracks.php?genre=$genre->Name'>$genre->Name</a>" ?>
        </td>
      </tr>
    <?php endforeach ?>
  </table>
</body>
</html>
