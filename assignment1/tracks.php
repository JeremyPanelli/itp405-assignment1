<?php
    $pdo = new PDO('sqlite:chinook.db');
    $sql = "
      SELECT  genres.Name As genre, tracks.Name AS trackname, albums.Title AS albumtitle, artists.Name AS artistname, tracks.UnitPrice AS unitprice
      FROM genres
      INNER JOIN tracks
      ON genres.GenreID = tracks.GenreId
      INNER JOIN albums
      ON albums.AlbumId = tracks.AlbumId
      INNER JOIN artists
      ON  artists.ArtistId = albums.ArtistId
    ";
    if (isset($_GET['genre'])) {
      $sql = $sql . 'WHERE genre = ?';
    }
    $statement = $pdo->prepare($sql);
    if (isset($_GET['genre'])) {
      $statement->bindParam(1,$_GET['genre']);
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
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <button>  <a href="/"> ← </a> </button> <br>
<h1>
<?php if (isset($_GET['genre'])) {
   print_r($_GET['genre']);
 }
 else{
    echo "All Genres";}
  ?>
</h1>
  <table class="table">
    <tr>
      <th> Track Name </th>
      <th> Album Title </th>
      <th> Artist Name </th>
      <th> Price </th>
    </tr>
<?php foreach($genres as $genre) : ?>
    <tr>
      <td> <?php echo $genre->trackname ?> </td>
      <td> <?php echo $genre->albumtitle ?> </td>
      <td> <?php echo $genre->artistname ?> </td>
      <td> <?php echo $genre->unitprice ?> </td>
    </tr>
  <?php endforeach ?>
  <?php if(count($genres)=== 0) : ?>
    <?php header("Location: /tracks.php"); ?>
  <?php endif ?>
  </table>
</body>
</html>
