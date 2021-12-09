<?php
/* 
zum Testen
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

for($i=10; $i < 100; $i++) {
	$info = "user anlegen:";
	$username = 'fakeusername'.$i;  // der "Alias" - muss unique sein!
	$password = 'FakePassword#'.$i; // woher kommt das?
	$vorname  = 'Fakefirstname'.$i;
	$nachname = 'Fakelastname'.$i;
	$email = 'Fakeemail'.$i.'@gagamail.com';
	$params = array('users' => array(array( 'username' => $username,
						'password' => $password, 
						'firstname' => $vorname, 
						'lastname' => $nachname, 
						'email' => $email
						))
			); 

	$result = $MoodleRest->request('core_user_create_users', $params);
}

//printresult($info, $result);

$info = "user-ID holen:";
$params = array('criteria' => array(array('key' => 'username', 'value' => $username))); 
$result = $MoodleRest->request('core_user_get_users', $params);
//printresult($i, $result);
$user_id = $result["users"][0]["id"];

$info = "User in Kurs einschreiben:";

$course_id = 3; // die Lernraum-ID
$role_id = 5; //Auth. User Standardrolle
date_default_timezone_set("Europe/Berlin");

$timestart_Stunde = 0;
$timestart_Minute = 0;
$timestart_Sekunde = 0;
$timestart_Monat = 12;
$timestart_Tag = 1;
$timestart_Jahr = 2021;

$timeend_Stunde = 23;
$timeend_Minute = 59;
$timeend_Sekunde = 59;
$timeend_Monat = 6;
$timeend_Tag = 17;
$timeend_Jahr = 2022;

$timestamp_start = mktime($timestart_Stunde, $timestart_Minute, $timestart_Sekunde, $timestart_Monat, $timestart_Tag, $timestart_Jahr);
$timestamp_end = mktime($timeend_Stunde, $timeend_Minute, $timeend_Sekunde, $timeend_Monat, $timeend_Tag, $timeend_Jahr);

$params = array(  
        'enrolments' => array(  
                array(
                'userid' =>$user_id ,
                'courseid' =>$course_id ,
		            'roleid' =>$role_id,
		            'timestart' =>$timestamp_start,
		            'timeend' =>$timestamp_end
                 ))
            );

$result = $MoodleRest->request('enrol_manual_enrol_users', $params);
//printresult($info, $result); // NULL, wenn ok

die();
?>


