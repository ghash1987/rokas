<?php 

if ($indulo_cp==$checkpoints[$current_cp]->post_title) {

	$check_already_in_db=$userdata->score_time;
	if (empty($check_already_in_db)) {
		$wpdb->update( $ut_name, array ('score_time' => $check_time), array ('race_ID'=>$race_ID) );
	} else {
		$check_time=$check_already_in_db;
	}

setcookie("race_ID", "", time() - 3600);


$userdata->score_time = $check_time;

	if (inTime($userdata, $ut_name)) {
		echo 'Célba értél! Gratulálunk a szintidőn túli teljesítéshez!<br>';
	} else {
		echo 'Sikeres teljesítés, gratulálunk!<br>';
	}

echo 'Teljesítési idő: '.secondstotime(strtotime($check_time)-strtotime($userdata->first_cp_time));




br();
$show_next_button=false;


$show_direction=false;
} else {
	echo 'menj vissza a kezdőcheckpointhoz';
}