<div class="display-text">
 <?php

        echo '<br>';


        $cp_lat = get_post_meta( $checkpoints[$next_index]->ID, '_latitude_value_key', true );
        $cp_long = get_post_meta( $checkpoints[$next_index]->ID, '_longitude_value_key', true );
        $qrh_distance=1000*(round(get_distance($geo_lat_eredeti, $geo_long_eredeti, $cp_lat, $cp_long, false), 3));

        $direction=getCompassDirection(getRhumbLineBearing($geo_lat_eredeti, $geo_long_eredeti, $cp_lat, $cp_long));



 
      $email=$userdata->email;
      $sex=$userdata->sex;
      $vehicle=$userdata->vehicle;
      $first_cp_time=$userdata->first_cp_time;
      $szintido=get_post_meta( $checkpoints[0]->ID, $userdata->vehicle, true )*60;


      $time_passed=strtotime($check_time)-strtotime($first_cp_time);
      $left_time=$szintido-$time_passed;

 

        if ($left_time<0) {
          if (!empty($first_cp_time)) {
            echo 'kifutottál a szintidőből';
          }
        } else {
          echo 'Hátralévő szintidő: '.secondstotime($left_time);
          br();
        }

        if ($is_started!='' || $_POST["rajt"]==2) {
          if ($geo_long!=1) {
             echo '<br>A következő ellenőrzőpont: ';
             echo $checkpoints[$next_index]->post_title;
            br();
            echo 'Légvonalban '.$qrh_distance.' méterre van '.$direction.' irányban.<br>';

            echo '<br>A pontnál a frissítés gombbal jelentkezhetsz be!';

            echo '<br>A GPS jel pontossága: '.ceil($_POST['geo_acc']).' méter<br>';
        }
        } else if($enable_rajt_button) {

        }  else {
          if ($geo_long!=1) {
          
          echo 'Az első ellenőrzőpont '.$qrh_distance.' méterre van '.$direction.' irányban.<br>';
            echo '<br>A GPS jel pontossága: '.ceil($_POST['geo_acc']).' méter<br>';
            echo '<br>Amennyiben jó helyen vagy, de a telefonod mást mutat, kérjük ellenőrizd egy térkép alkalmazásban a pozíciódat (pl. Google Maps), majd lépj vissza és próbáld meg ismét';
          }
        }
?>
</div>