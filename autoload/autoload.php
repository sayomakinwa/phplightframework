<?php
include 'system/system_autoload.php';
include 'helpers/Utility.php';

#key is the url to match, value is where it should match to
#note: This should be done in a paarticular order, ie, a re reouted part of the url should now bear the rerouted destination in next array entity
$routes = array(
				'unilorinapartment/logout' => 'student/logout',
				'unilorinapartment/login' => 'student/login',
				'unilorinapartment/passport' => 'student/passport',
				'unilorinapartment/profile/edit' => 'student/profile/edit',
				'unilorinapartment/profile/print' => 'student/profile/print',
				'unilorinapartment/register' => 'student/register',
				'unilorinapartment/' => ''
			);
/*
$routes = array(
				'logout' => 'student/logout',
				'admin/student/logout' => 'admin/logout',
				'login' => 'student/login',
				'passport' => 'student/passport',
				'profile/edit' => 'student/profile/edit',
				'profile/print' => 'student/profile/print',
				'profile/upload' => 'student/profile/upload',
				'register' => 'student/register',
				'features' => 'student/features'
			);
*/
?>
