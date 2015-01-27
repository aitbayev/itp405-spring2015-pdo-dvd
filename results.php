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

echo "You searched for '" .$_GET['dvd_title'] . "' </br>";

$sql = "
 SELECT title, rating_name, format_name, genre_name
 FROM dvds
 INNER JOIN genres
 ON dvds.genre_id = genres.id
 INNER JOIN formats
 ON dvds.format_id = formats.id
 INNER JOIN ratings
 ON dvds.rating_id = ratings.id
 WHERE title LIKE ?
";


$statement = $pdo->prepare($sql);
$like = '%' . $dvd_title . '%';
$statement->bindParam(1, $like);


$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

if( empty($dvds)){
    echo " <p> No results found for <a href = 'search.php'> Search page </a> </p>";
}
?>

<table>

<tr>
    <td><strong> Title </strong></td>
    <td><strong> Genre </strong></td>
    <td><strong> Format</strong></td>
    <td><strong> Rating</strong></td>

</tr>
<?php foreach($dvds as $dvd) : ?>
<tr>
    <td><?php echo $dvd->title ?> </td>
    <td><?php echo $dvd->genre_name ?> </td>
    <td><?php echo $dvd->format_name ?> </td>
    <td><a href="ratings.php?rating=<?php echo $dvd->rating_name ?>"> <?php echo $dvd->rating_name ?></a></td>
</tr>
<?php endforeach; ?>
</table>