<?php
/* 
loescht alle User, die NICHT in der Liste sind.
*/

// diese User niemals loeschen
$loesche_nie = [
		"guest",
		"moodleroot",
		"restuser",
		"s.franke",
		"maxmuster"
		];

// diese User nicht loeschen
$liste = [
	"fakeusername",
	"fakeusername_0"
	];

$loesche_nicht =array_merge($loesche_nie, $liste);

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

//printresult("DEL: ", $deleteme);

$info = "alle user ausgeben:";
$params = array('criteria' => array(array('key' => 'userid', 'value' => "%"))); 
$result = $MoodleRest->request('core_user_get_users', $params);

$deleteme = [];
for($i=0; $i < count($result["users"]); $i++) {
	$user_name = $result["users"][$i]["username"];
	$user_id = $result["users"][$i]["id"];
	if (!in_array($user_name, $loesche_nicht)) {
		array_push($deleteme, $user_id);
	}
}

//printresult("DEL: ", $deleteme);

$info = "user loeschen:";
$userid = $deleteme[0];  

$userids = $deleteme;
$params = array( 'userids' => $userids );

$result = $MoodleRest->request('core_user_delete_users', $params);
// printresult($info, $result);  // NULL wenn ok
die();
?>


