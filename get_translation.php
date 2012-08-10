<?php 

$single_word = filter_input(INPUT_POST, 'word', FILTER_SANITIZE_STRING);
$word_to_trans = "http://m.slovari.yandex.ru/translate.xml?text=".$single_word."&lang=en-ru-en";
$get_translation = file_get_contents($word_to_trans,10); 
$string_1 = strstr($get_translation, ')</b> <a href="/translate.xml?text=');
$w1 = strstr(strstr((sprintf("[%10.100s]\n", $string_1)), '&amp;lang=en-ru-en', TRUE),'text=');
$w2 = substr(strrchr($w1, '='), 1 );
echo $w2;