<?php
require_once 'includes/db.php';
session_start();

if (isset($_SESSION["upload-report"])) {
	$text = file_get_contents($_SESSION['file_uploaded']);
	}
	else {
	$text = filter_input(INPUT_POST, 'text', FILTER_SANITIZE_STRING);
	}
$uwords = filter_input(INPUT_POST, 'preferredlang', FILTER_SANITIZE_STRING);
$words = array();
$text_lowered = strtolower($text);
$words = str_word_count($text_lowered, 1);
$wordsnumber = count($words);
$wordslist=array_count_values($words);


reset($wordslist);

$sql = $db->prepare('
ALTER TABLE wordslist DROP id
');
$sql->execute();

$sql = $db->prepare('
ALTER TABLE wordslist ADD id INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST
');
$sql->execute();

$sql = $db->prepare('
DELETE FROM wordslist
WHERE id >= 0
');
$sql->execute();

$sql_commands = array();

foreach  (array_keys($wordslist) as $value)
{	
	$c_frq = current($wordslist);
	next($wordslist);
	$sql_commands[] = '("'.$value.'", '.$c_frq.')';
}

$sql_string = 'INSERT INTO wordslist (word, frq) VALUES ' . implode(',', $sql_commands);
$db->query($sql_string);

$title = 'Get started';
$page = 'getstarted';

include 'includes/nav.php';

?>
<article class="clearfix">
	<h1>Let's get started!</h1>
	<div id="entertextform">
		<h2>Step 1: Enter or upload your text</h2>
		<p><strong>You can enter your text in the text field below</strong></p>
		<form method="post" action="getstarted.php">
		<label for="text" id="text_field">Input text here</label>
		<textarea id="text" name="text"></textarea>
		<button type="submit" id="text_submit_button">Submit</button>
		</form>
		<strong>Or upload a text file (up to 500kb)</strong>
		<form method='post' enctype='multipart/form-data' action='upload.php'>
			<strong>File: </strong><input type='file' name='file_upload'>
			<button type="submit">Upload</button>
		</form>
		<strong><?php if(isset($_SESSION["upload-report"])){
						 echo ($_SESSION["upload-report"]);
						 if($_SESSION["upload-report"] == 'File uploaded successfully.') {unlink($_SESSION['file_uploaded']);}
						 unset($_SESSION["upload-report"]); 
						 unset($_SESSION["file_uploaded"]);}
						 ?></strong>
		
		<strong>Words entered: <?php 
			echo $wordsnumber;
			$sql = $db->query('
			SELECT total_words_number
			FROM words_number
			WHERE id = 1
			');
			$total_words_number_db = $sql->fetch();
			$increase_twn = $total_words_number_db[0] + $wordsnumber;
			$sql = $db-> prepare ('
			UPDATE words_number
			SET stat = :wordsnumber
			WHERE id = 1;
			UPDATE words_number
			SET stat = stat+1
			WHERE id = 2;
			');
			$sql->bindValue(':wordsnumber', $increase_twn , PDO::PARAM_INT);
			$sql->execute();
			
			?></strong>
			<form method="post" action="getlist.php">
				<div>
				  <fieldset class="exclusion1">
					<legend>Exclude most used words from the list:</legend>
					<input type="radio" id="100words" name="uwords" value="100"<?php if ($uwords == '100') { echo ' checked'; } ?>>
					<label for="100words">100 words</label>
					<input type="radio" id="500words" name="uwords" value="500"<?php if ($uwords == '500') { echo ' checked'; } ?>>
					<label for="500words">500 words</label>
					<input type="radio" id="1000words" name="uwords" value="1000"<?php if ($uwords == '1000') { echo ' checked'; } ?>>
					<label for="1000words">1000 words</label>
				  </fieldset>
				</div>
						
				<div>
					<p>Exclude also:</p>
					<input type="checkbox" id="articles" name="articles" value="1">
					<label for="articles">Articles</label>
					<input type="checkbox" id="pronouns" name="pronouns" value="1">
					<label for="articles">Pronouns</label>
					<input type="checkbox" id="prepos" name="prepos" value="1">
					<label for="articles">Prepositions</label>
				</div>
					<button type="submit" id="getlist_button">Get list</button>
		</form>
	</div>
</article>
<?php
include 'includes/wrap-bottom.php';
?>