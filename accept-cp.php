<?php 
$accepted=true;
$sorrend='132';
if ($qrh_distance==0) {
  $sorrend="TÚL PONTOS!-, ";
} else {
  $sorrend='ok-';
}


$count_checked++;
$wpdb->insert( 
  $table,
  array
  ( 
    'check_time' => $check_time,
    'race_ID' => $race_ID,
    'geo_lat' => $geo_lat,
    'geo_long' => $geo_long,
    'sorrend' => $sorrend
    
    )
    
  );