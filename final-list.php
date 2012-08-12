<?php
session_start();

$translation = filter_input(INPUT_POST, 'translation', FILTER_SANITIZE_STRING);
$wcounter = $_SESSION['wordscounter'];
$num = 1;
$final_list = array();

for ($i = 1; $i <= $wcounter; $i++) {
			$word_variable_name = 'w'.$i;
			$word_checked = filter_input(INPUT_POST, $word_variable_name, FILTER_SANITIZE_STRING);
			if ($word_checked != '') {
				$final_list[$i] = $word_checked;
			}
}

$split_results = array_chunk($final_list, ceil(count($final_list) / 3));

$title = 'Final list';
$page = 'finallist';

include 'includes/nav.php';

?>
<article class="clearfix">
	<div class="clearfix"><h1>Here is your final list !</h1></div>
    <?php foreach($split_results as $final_list) : ?>
	<table border="1">
		<tr>
			<td><strong class="table_header">#</strong></td>
			<td><strong class="table_header">Word</strong></td>
			<td><strong class="table_header">Translation</strong></td>
		</tr>
			<?php foreach ($final_list as $single_word) : ?>
					<tr>
						<td><?php echo $num; ?></td>
						<td><span data-word-id="<?php echo $num;?>" class="original-word"><?php echo $single_word;?></span></td>
						<td>
						<?php
						if (isset($translation)) {
							$word_to_trans = "http://m.slovari.yandex.ru/translate.xml?text=".$single_word."&lang=en-ru-en";
							$get_translation = file_get_contents($word_to_trans,10); 
							$string_1 = strstr($get_translation, ')</b> <a href="/translate.xml?text=');
							$w1 = strstr(strstr((sprintf("[%10.100s]\n", $string_1)), '&amp;lang=en-ru-en', TRUE),'text=');
							$w2 = substr(strrchr($w1, '='), 1 );
							echo $w2;}
							else{
							echo '<a data-word-id="' . $num . '" href="#" class="get-trans">Get translation<a>';
							}
						$num++;?>
						</td>
					</tr>
			<?php endforeach; ?>
		</table>
	<?php endforeach; ?>
</article>
<?php include 'includes/wrap-bottom.php'; ?>