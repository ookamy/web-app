// JavaScript Document
$(document).ready(function () {
	
	$('.get-trans').on('click', function (ev) {
		ev.preventDefault();
		var wordId = $(this).attr('data-word-id');
		var word = $('.original-word[data-word-id="' + wordId + '"]').text();
		
		$(this).load('get_translation.php', {
			'word': word
		});
	});
});