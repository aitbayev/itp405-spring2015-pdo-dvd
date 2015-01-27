<?php
if (!isset($_GET['dvd_title'])) {
    header('Location: search.php');
}


$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass = 'ttrojan';


$dvd_title = $_GET['dvd_title'];


$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

echo "You searched for '" .$_GET['dvd_title'] . "'";

$sql = "
  SELECT title, genre, format, rating
  FROM dvds, genres, formats, ratings
  INNER JOIN genres
  ON dvds.genre_id= genres.id
  INNER JOIN formats
  ON dvds.format_id= formats.id
  INNER JOIN ratings
  ON dvds.rating_id = ratings.id;
  WHERE title LIKE ?
";

$statement = $pdo->prepare($sql);
$like = '%'.$dvd_title.'%';
$statement->bindParam(1, $like);


$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<?php foreach($dvds as $dvd) : ?>
    <h3>
        <?php echo $dvd->title ?>

    </h3>
    <p>Genre: <?php echo $dvd->genre ?></p>
    <p>Format: <?php echo $dvd->format ?></p>
    <p>Rating: <?php echo $dvd->rating ?></p>
<?php endforeach; ?>