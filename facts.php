<?php
require_once 'includes/db.php';

$title = 'Facts';
$page = 'facts';
include 'includes/nav.php';

$sql = $db->query('
SELECT stat
FROM words_number
');
$results = $sql->fetchAll();

$app_used_times = $results[1][0];
$words_entered = $results[0][0];

?>
<article class="clearfix">
	<h1>Application facts</h1>
		<strong><p>Application used, times: <?php echo $app_used_times; ?></p>
		<p>Words entered, total: <?php echo $words_entered; ?></p>
		<p>List of 1000 most used English words <a href="#">show</a></p><strong>
</article>
<?php
include 'includes/wrap-bottom.php';
?>