<?php

//echo phpinfo();

require_once('MoodleRest/MoodleRest.php');

$site = 'https://xxx';
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


/*
$info = "bestimmen user ausgeben:";
$params = array('criteria' => array(array('key' => 'email', 'value' => 'Fakeemail@gmail.com'))); 
$result = $MoodleRest->request('core_user_get_users', $params);
printresult($info, $result);
*/

/*
$info = "user anlegen:";
$params = array('users' => array(array( username => 'fakeusername', 
					password => 'FakePassword1#', 
					'firstname' => 'Fakefirstname', 
					'lastname' => 'Fakelastname.2', 
					'email' => 'Fakeemail@gmail.com'
					)
				)
		); 
$result = $MoodleRest->request('core_user_create_users', $params);
printresult($info, $result);
*/

/*
$info = "Gruppen anzeigen:";
$result = $MoodleRest->request('core_group_get_groups', array('groupids' => array(2,3))); 
print "<pre>"; echo "result 1:\n" .print_r($result1, true); print "</pre>";
printresult($info, $result);
*/

/*
$info = "Userprofile aus Kurs anzeigen:";
$params = array('userlist' => array(array('userid' => 2, 'courseid' => 1), array('userid' => 5, 'courseid' => 1))); 
$result = $MoodleRest->request('core_user_get_course_user_profiles', $params);
printresult($info, $result);
*/


die();
?>


