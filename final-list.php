<?php
session_start();

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


?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Your final words list</title>
    </head>

<body>
	<h1>Here is your final list !</h1>
	<table border="1">
		<tr>
			<td><strong>#</strong></td>
			<td><strong>Word</strong></td>
		</tr>
<?php foreach ($final_list as $single_word) : ?>
		<tr>
			<td><?php echo $num; ?></td>
			<td><?php echo $single_word; $num++; ?></td>
		</tr>
<?php endforeach; ?>
</body>
</html>