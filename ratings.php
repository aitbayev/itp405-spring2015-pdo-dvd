<?php

if (!isset($_GET['rating'])) {
    header('Location: search.php');
}

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass = 'ttrojan';


$rating = $_GET['rating'];


$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

$sql = "
    SELECT title, rating_name, genre_name, format_name
    FROM dvds
    INNER JOIN genres
    ON dvds.genre_id = genres.id
    INNER JOIN formats
    ON dvds.format_id = formats.id
    INNER JOIN ratings
    ON dvds.rating_id = ratings.id
    WHERE rating_name ='".$rating."'";


$statement = $pdo->prepare($sql);


$statement->execute();
$results = $statement->fetchAll(PDO::FETCH_OBJ);
echo "All movies with '" .$rating . "' rating: ";
?>

<?php foreach($results as $result) : ?>

        <?php echo "<p> <strong>" .$result->title."</p> </strong>"?>
        <p>Genre: <?php echo $result->genre_name ?></p>
        <p>Format: <?php echo $result->format_name ?></p>

<?php endforeach; ?>