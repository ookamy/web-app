$(document).ready(function () {
	$('#show_list').on('click', function(ev) {
		ev.preventDefault();
		$('#1000_list').load('1000.php');
	});
});