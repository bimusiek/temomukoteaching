<?php
header('Content-Type: text/html; charset=utf-8');
$skladniki = implode(',', $_GET['s']);
$url = 'http://przyprawiony.pl/znajdz-skladniki/szukaj,'.$skladniki.',0,0,0,0,1,0.html';

$out = file_get_contents($url);
preg_match('!Znaleziono (.*?) przepisów(.*?)<div id="rigistration_box">!is', $out, $mat);
preg_match_all('!\<a href\="/przepis/(.*?)"!is', $mat[0], $matches);
$rand = rand(0, count($matches[0])-1);
if($matches[1][$rand]) {
$przepis = 'http://przyprawiony.pl/przepis/'.$matches[1][$rand];

$p = file_get_contents($przepis);
preg_match('!<small>Autor:(.*?)h2 class="left">Komentarze:</h2>!is', $p, $m);
preg_match('!<h2>.*?przygotowania:</h2>.*?<p>(.*?)</p>!is', $m[0], $sposob);

preg_match('!class="bigImage".*?src="(.*?)"!is', $p, $image);

echo '<img width="480px" src="http://przyprawiony.pl/'.$image[1].'">';


preg_match('!<h2>.*?adniki:</h2>.*?<ul>(.*?)</ul>!is', $m[0], $skl);
preg_match_all('!<li>(.*?)</li>!is', $skl[1], $skl2);
$skladniki = array();
echo '<h2>Składniki:</h2><ul>';
foreach($skl2[1] AS $v) {
	$skladniki[] = $v;
	echo '<li>'.$v.'</li>';
}
echo '</ul> <h2>Przygotowanie:</h2>';
echo $sposob[1];

} else {
	echo 'Nie znaleziono przepisu';	
}
?>

