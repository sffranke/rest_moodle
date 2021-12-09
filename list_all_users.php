<?php

/* 
Listet alle User
*/

require_once('MoodleRest/MoodleRest.php');

$site = 'https://lmsrest.xxx.com';
$token = 'xxx';

$MoodleRest = new MoodleRest();
$MoodleRest->setServerAddress($site."/webservice/rest/server.php");
$MoodleRest->setToken($token);
$MoodleRest->setReturnFormat(MoodleRest::RETURN_ARRAY);

function printresult($i, $r){
	print "<pre>"; echo $i."\n" .print_r($r, true); print "</pre>";
}

$info = "alle user ausgeben:";
$params = array('criteria' => array(array('key' => 'lastname', 'value' => "%"))); 
$result = $MoodleRest->request('core_user_get_users', $params);
printresult($i, $result);
die();
?>
