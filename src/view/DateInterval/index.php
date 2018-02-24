<title>Provectus test</title>
<?php header('Content-Type: text/html; charset=utf-8');
/** Index - default
 * view/DateInterval/index.php - displays the result of the method index of controller in the DateIntervalController
 */
$params = $controllerParams;

echo '<br/>','/***********************************check***********************************/';
echo '<pre>$d1 = ', var_dump($params[0]), '</pre>';
echo '<pre>$d2 = ', var_dump($params[1]), '</pre>';
echo '<pre>var_dump($d1->diff($d2)) = <br/>', var_dump($params[2]), '</pre>';

echo '<pre>', $params[3], '</pre>';
echo '<pre>', $params[4], '</pre>';
echo '<pre>var_dump($td1->diff($td2)) = <br/>', var_dump($params[5]), '</pre>';
echo '/***********************************check***********************************/';


echo '<br/>','/***********************************more illustrative example***********************************/';
echo '<pre>$d1 = ', var_dump($params[6]), '</pre>';
echo '<pre>$d2 = ', var_dump($params[7]), '</pre>';
echo '<pre>var_dump($d1->diff($d2)) = ', var_dump($params[8]), '</pre>';

echo '<pre>', $params[9], '</pre>';
echo '<pre>', $params[10], '</pre>';
echo '<pre>var_dump($td1->diff($td2)) = <br/>', var_dump($params[11]), '</pre>';
echo '/***********************************more illustrative example***********************************/';


echo '<br/>','/***********************************3rd verification example***********************************/';
echo '<pre>$d1 = ', var_dump($params[12]), '</pre>';
echo '<pre>$d2 = ', var_dump($params[13]), '</pre>';
echo '<pre>var_dump($d1->diff($d2)) = <br/>', var_dump($params[14]), '</pre>';

echo '<pre>', $params[15], '</pre>';
echo '<pre>', $params[16], '</pre>';
echo '<pre>var_dump($td1->diff($td2)) = <br/>', var_dump($params[17]), '</pre>';
echo '/***********************************3rd verification example***********************************/';


echo '<br/>','/***********************************(invert = 1) && ($d1->year > $d2->year)***********************************/';
echo '<pre>$d1 = ', var_dump($params[18]), '</pre>';
echo '<pre>$d2 = ', var_dump($params[19]), '</pre>';
echo '<pre>var_dump($d1->diff($d2)) = <br/>', var_dump($params[20]), '</pre>';

echo '<pre>', $params[21], '</pre>';
echo '<pre>', $params[22], '</pre>';
echo '<pre>var_dump($td1->diff($td2)) = <br/>', var_dump($params[23]), '</pre>';
echo '/***********************************(invert = 1) && ($d1->year > $d2->year)***********************************/';
echo "<hr>";
?>



