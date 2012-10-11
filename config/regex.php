<?php
define("REGEX_ALPHANUMERIC_ONLY","/^[A-Za-z0-9]+\z/");
define("REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES","^\w+$^");
define("REGEX_EMAIL","^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$^");
/*
echo "Sanitization test<br><br>";

echo preg_match(REGEX_ALPHANUMERIC_ONLY,"prova.")." expected: 0<br>";
echo preg_match(REGEX_ALPHANUMERIC_ONLY,"prova")." expected: 1<br>";
echo preg_match(REGEX_ALPHANUMERIC_ONLY,"prova!")." expected: 0<br>";
echo preg_match(REGEX_ALPHANUMERIC_ONLY,"prova-")." expected: 0<br>";

echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"")." expected: 0<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"0")." expected: 1<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,0)." expected: 1<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"asd")." expected: 1<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"-LOL-_")." expected: 1<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"lol!")." expected: 0<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"simone$")." expected: 0<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,"true")." expected: 1<br>";
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,true)." expected: 0<br>"; //invece � 1
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES," asd")." expected: 0<br>"; //invece � 1 (!!!) ma si risolve con trim()
echo preg_match(REGEX_ALPHANUMERIC_WITH_HYPHENS_AND_UNDERSCORES,null)." expected: 0<br>";
*/