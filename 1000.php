<?php
require_once 'includes/db.php';
$num = 1;
$sql = $db->query('
SELECT id, word
FROM 1000words
');
$results = $sql->fetchAll();
$split_results = array_chunk($results, ceil(count($results) / 5));

foreach($split_results as $results) : ?>
		<table border="1">
			<tr>
				<td><strong>#</strong></td>
				<td class="selection_list"><strong>Word</strong></td>
			</tr>
				<?php foreach ($results as $list) : ?>
						<tr>
							<td class="selection_list"><?php echo $num ?></td>
							<td><label for="<?php echo "w"; echo $num;?>"><?php echo $list['word']; $num++?></label></td>
						</tr>
				<?php endforeach; ?>
		</table>
<?php endforeach; ?>
