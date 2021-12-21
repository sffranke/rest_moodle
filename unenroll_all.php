<?php

/* 
Alle User aus allen Kursen ausschreiben
*/

require_once('MoodleRest/MoodleRest.php');

$site = 'https://xx';
$token = 'xx';

// diese User ignorieren
$ignoriere_ids = [
		"0", // root
		"1", // guest
		"2", // moodleroot
		"3", // s.franke
		"6", // restuser
		];

$MoodleRest = new MoodleRest();
$MoodleRest->setServerAddress($site."/webservice/rest/server.php");
$MoodleRest->setToken($token);
$MoodleRest->setReturnFormat(MoodleRest::RETURN_ARRAY);

function printresult($i, $r){
	print "<pre>"; echo $i."\n" .print_r($r, true); print "</pre>";
}

$info = "alle User ausgeben:";
$params = array('criteria' => array(array('key' => 'ids', 'value' => "%"))); 
$result = $MoodleRest->request('core_user_get_users', $params);

$userarr = array();
for($i=0; $i< count($result["users"]); $i++) {

	if (!in_array($result["users"][$i]["id"], $ignoriere_ids)) {
		array_push($userarr, array("moodle_user_id" => $result["users"][$i]["id"]));
	}
}
//printresult($info, $userarr);

//////////////////
/*
$info = "die User sind eingeschrieben in:";
$params = array("userid"=>'377'); 
$result = $MoodleRest->request('core_enrol_get_users_courses', $params);
//printresult($info, $result);
*/

/////////////////////

$user_enrolled_in = array();
for($i=0; $i< count($userarr); $i++) {
	$params = array("userid"=>$userarr[$i]["moodle_user_id"]);
	$result = $MoodleRest->request('core_enrol_get_users_courses', $params);
	
	array_push($user_enrolled_in,  array("moodle_user_id"=>$userarr[$i]["moodle_user_id"]));
	for($k=0; $k< count($result); $k++) {
		print "User mit moodle_user_id ".$userarr[$i]["moodle_user_id"]. " eingeschr. in ".$result[$k]["id"]."<br>";
		array_push($user_enrolled_in[$i],array("kursid"=>$result[$k]["id"]));
	}
}
//printresult($info, $user_enrolled_in);

$role_id = 5; //Auth. User Standardrolle
for($i=0; $i< count($user_enrolled_in); $i++) {
	for($k=0; $k< count($user_enrolled_in[$i]); $k++) {
		if(isset($user_enrolled_in[$i][$k])){
			//print "moodle_user_id ". $user_enrolled_in[$i]["moodle_user_id"]. " eingeschr. in ".$user_enrolled_in[$i][$k]["kursid"]."<br>";
			$course_id = $user_enrolled_in[$i][$k]["kursid"]; // die Lernraum-ID
			$user_id = $user_enrolled_in[$i]["moodle_user_id"];
			$info = "moodle_user_id ". $user_enrolled_in[$i]["moodle_user_id"]. " ausschreiben. aus ".$user_enrolled_in[$i][$k]["kursid"];
			$params = array(  
					'enrolments' => array(  
						array(
						'userid' =>$user_id ,
						'courseid' =>$course_id ,
						'roleid' =>$role_id
						 ))
					    );

			$result = $MoodleRest->request('enrol_manual_unenrol_users', $params);
		
			//printresult($info, $result); // Leer wenn erfolgreich
		}
	}
}
die();
?>
