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
$split_results = array_chunk($results, ceil(count($results) / 3));

$num = 1;

/*$sql_string = "INSERT INTO `words`.`app_most_used_words` (`id`, `word`, `frq`) VALUES ('2', 'two', '2');";
$db->query($sql_string);
*/
$title = 'Words list';
$page = 'wordslist';

include 'includes/nav.php';

?>
<article class="clearfix">
	<h1>Make your final list!</h1>
	<h2>Please select the words you want to include to your final list.</h2>
	<p>Here are the words used in text:</p>
	<p>Excluded: <strong>
		<?php if (isset($articles)) {$e=1; echo "articles ";};
			  if (isset($pronouns)){$e=1; echo "pronouns ";};
			  if (isset($prepos)){$e=1; echo "prepositions ";};
			  if ($wordsexclusion > 0 ){$e=1; echo $wordsexclusion; echo " most used words";}; 
			  if (!isset($e)){echo "Nothing";};?></strong></p>
		<form method="post" action="final-list.php">
        <?php foreach($split_results as $results) : ?>
		<table border="1">
			<tr>
				<td><strong>#</strong></td>
				<td class="selection_list"><strong>Word</strong></td>
				<td class="selection_list"><strong>Used</strong></td>
				<td class="selection_list"><strong>!</strong></td>
			</tr>
				<?php foreach ($results as $list) : ?>
						<tr>
							<td class="selection_list"><?php echo $num ?></td>
							<td><label for="<?php echo "w"; echo $num;?>"><?php echo $list['word']; ?></label></td>
							<td class="selection_list"><?php echo $list['frq'];  ?></td>
							<td class="selection_list"><input type="checkbox" id="<?php echo "w"; echo $num;?>" name="<?php echo "w"; echo $num; $num++;?>" value="<?php echo $list['word']; ?>"></td>
						</tr>
				<?php endforeach; ?>
		</table>
        <?php endforeach; ?>
<!--    <input type="checkbox" id="translation" name="translation" value="1">
        <label for="translation">Translate to Russian</label> -->		
		<?php $_SESSION['wordscounter']=$num; ?>
		<div class="clearfix"></div>
		<button id="get_final_bitton" type="submit">Get final list</button>
		</form>
	</article>
<?php
include 'includes/wrap-bottom.php';
?>