<?php
/**
 * view/DateInterval/view.php
 */
header('Content-Type: text/html; charset=utf-8');
$params = $controllerParams;
echo "<br />- I am a view.php",'<br /><h2>stdClass object:</h2>',"<pre>",var_dump($params),"</pre>","<hr>"
?>