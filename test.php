<?php 
$get_translation = file_get_contents("http://m.slovari.yandex.ru/translate.xml?text=brick&lang=en-ru-en",10); 
$string_1 = strstr($get_translation, ')</b> <a href="/translate.xml?text=');
$w1 = strstr(strstr((sprintf("[%10.100s]\n", $string_1)), '&amp;lang=en-ru-en', TRUE),'text=');
$w2 = substr(strrchr($w1, '='), 1 );
echo $w2;
