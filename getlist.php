<?php
require_once 'includes/db.php';

session_start();

$articles = filter_input(INPUT_POST, 'articles', FILTER_SANITIZE_STRING);
$pronouns = filter_input(INPUT_POST, 'pronouns', FILTER_SANITIZE_STRING);
$prepos = filter_input(INPUT_POST, 'prepos', FILTER_SANITIZE_STRING);
$pronounslist = array('i','you','he','she','it','we','they','him','his','her','their','those','these');
$preposlist = array('to','for','by','on','as','from','of','with','in','and','or','at');
$wordsexclusion = filter_input(INPUT_POST, 'uwords', FILTER_SANITIZE_NUMBER_INT);


if (isset($articles)){
			$sql = $db->prepare('
			DELETE FROM wordslist
			WHERE (word = "the" or word = "a" or word = "an")
			');
			$sql->execute();
};

if (isset($pronouns)){
			foreach ($pronounslist as $p){
			$sql = $db->prepare('
			DELETE FROM wordslist
			WHERE word = :p
			');
			$sql->bindValue(':p', $p, PDO::PARAM_STR);
			$sql->execute();
			}
};

if (isset($prepos)){
			foreach ($preposlist as $pr){
			$sql = $db->prepare('
			DELETE FROM wordslist
			WHERE word = :pr
			');
			$sql->bindValue(':pr', $pr, PDO::PARAM_STR);
			$sql->execute();
			}
};

if ($wordsexclusion > 0 ){
			
			$sql = $db-> prepare ('
			SELECT word
			FROM 1000words
			WHERE id < :wexcl
			ORDER BY id ASC
			');
			$sql->bindValue(':wexcl', $wordsexclusion, PDO::PARAM_INT);
			$sql->execute();
			$excludewords = $sql->fetchAll();
			foreach ($excludewords as $wexclude){
			$sql = $db->prepare('
			DELETE FROM wordslist
			WHERE word = :wexclude
			');
			$sql->bindValue(':wexclude', $wexclude[0], PDO::PARAM_STR);
			$sql->execute();
			}
};

$sql = $db->query('
SELECT id, word, frq
FROM wordslist
ORDER BY frq DESC
');
$results = $sql->fetchAll();
$num = 1;

?><!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<title>List of the words</title>
	</head>

<body>

<h1>List of words used in the text</h1>
<p>Total words used in text: <?php //echo $wordsnumber;?></p>
<p>Excluded: <strong>
	<?php if (isset($articles)) {echo "articles ";};
		  if (isset($pronouns)){echo "pronouns ";};
		  if (isset($prepos)){echo "prepositions ";};
		  if ($wordsexclusion > 0 ) {echo $wordsexclusion; echo " most used words";}; ?></strong></p>
	<form method="post" action="final-list.php">
	<table border="1">
		<tr>
			<td><strong>#</strong></td>
			<td><strong>Word</strong></td>
			<td>Used</td>
			<td>To Final list</td>
		</tr>
<?php foreach ($results as $list) : ?>
		<tr>
			<td><?php echo $num ?></td>
			<td><label for="<?php echo "w"; echo $num;?>"><?php echo $list['word']; ?></label></td>
			<td><?php echo $list['frq'];  ?></td>
			<td><input type="checkbox" id="<?php echo "w"; echo $num;?>" name="<?php echo "w"; echo $num; $num++;?>" value="<?php echo $list['word']; ?>"></td>
		</tr>
<?php endforeach; ?>
	</table>
    <?php $_SESSION['wordscounter']=$num; ?>
	<button type="submit">Get final list</button>
	</form>
</body>
</html>
