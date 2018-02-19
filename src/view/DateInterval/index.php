<title>Provectus test</title>
<?php header('Content-Type: text/html; charset=utf-8');
/** Index - default
 * view/DateInterval/index.php - displays the result of the method index of controller in the DateIntervalController
 */
$params = $controllerParams;
echo '<pre>$firstDate = ', var_dump($params[0]), '</pre>';
echo '<pre>$secondDate = ', var_dump($params[1]), '</pre>';
echo '<pre>$interval = ', var_dump($params[2]), '</pre>',"<hr>";
?>



