<?php



$first_cp_time=date("Y-m-d H:i:s");
$last_cp_time = date ("2009-10-16 21:30:45");
$all_cp_finished=true;
$no_cp_finished=true;



$geo_lat=$_POST['geo_lat'];
$geo_lat_eredeti=$geo_lat;


unset($_POST['geo_lat']);

$geo_long=$_POST['geo_long'];
$geo_long_eredeti=$geo_long;


unset($_POST['geo_long']);

$first_checked_cp_index=0;
$count_checked=0;

$indulo_cp=$userdata->sorrend;

foreach ($checkpoints as $checkpoint) {
    $table='checkpoint_'.$checkpoint->post_name;
    
    $cp_check_time=$wpdb->get_var( "SELECT check_time FROM `{$table}` WHERE race_ID='$race_ID'" );
    if ($cp_check_time!='') {
        if ($first_cp_time>$cp_check_time) { // a legkisebb check_time a kiindulópont
            $first_cp_time=$cp_check_time;
            $first_checked_cp_index=array_search($checkpoint, $checkpoints);
        }
        if ($last_cp_time<$cp_check_time) { // a legnagyobb check_time az ustó csekk helye
            $last_cp_time=$cp_check_time;
            $last_checked_cp_index=array_search($checkpoint, $checkpoints);
            $count_checked++;
        }
        $no_cp_finished=false; // ha bármelyik cp-nél nincs kiírva teljesítési idő akkor nincs vége a túrának
    } else {
        $all_cp_finished=false;
        
        
    }
    $indulo_cp_index=array_search($checkpoint, $checkpoints);
    $next_index=$indulo_cp_index;
    
}



$checkpoints_length=count($checkpoints);


$i=$first_checked_cp_index;
$current_cp=-1;

if (isset($last_checked_cp_index)) {
    $next_index=$last_checked_cp_index+1;
    if ($next_index==$checkpoints_length) {
        $next_index=0;
    }
}


do  {
    
    $checkpoint=$checkpoints[$i];
    
    
    $cp_lat = get_post_meta( $checkpoint->ID, '_latitude_value_key', true );
    $cp_long = get_post_meta( $checkpoint->ID, '_longitude_value_key', true );
    $qrh_distance=1000*(round(get_distance($geo_lat_eredeti, $geo_long_eredeti, $cp_lat, $cp_long, false), 3));
    
    
    
    $cp_lat = get_post_meta( $checkpoint->ID, '_latitude_value_key', true );
    $cp_long = get_post_meta( $checkpoint->ID, '_longitude_value_key', true );
    
    
    $cpradius=100;
    
    if (get_post_meta( $checkpoints[0]->ID, 'hatosugar', true)!="") {
        $cpradius= get_post_meta( $checkpoints[0]->ID, 'hatosugar', true);
    }
    
    if ($qrh_distance<$cpradius) {   
        
        $current_cp=array_search($checkpoint, $checkpoints);
        if ($current_cp==$next_index) {
            $next_index++;
        }
        
        if ($next_index==$checkpoints_length) {
            $next_index=0;
        }
        ?>
        <div class="display-text">
        <?php
        br();
        echo $checkpoint->post_title.' ellenőrzőponton vagy.' ;
        br();
        ?>
        </div>
        <?php
        
    } else {
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    $i++;
    
    if ($i==$checkpoints_length) {
        $i=0;
    }
    
} while ($i!=$first_checked_cp_index);










if ($current_cp==-1) {
    if ($geo_long!=1) { 
        ?>
        <div class="display-text">
        <div class="sikertelen-check">
        Nincs sikeres pontérintés, menj tovább a megadott irányban!
        </div>
        </div>
        <?php
    }
    
} else {
    
    $table=esc_sql('checkpoint_'.$checkpoints[$current_cp]->post_name);
    $cp_check_time=$wpdb->get_var( "SELECT check_time FROM `{$table}` WHERE race_ID='$race_ID'" );
    if ($all_cp_finished) {
        require('last-cp.php');
        
    } else {
        if ($cp_check_time!='') {
            if ($_POST["rajt"]==2) {
                ?>
                <div class="display-text">
                <div class="sikeres-check">
                Sikeresen elrajtoltál, jó túrát!
                </div>
                </div>
                <?php
            } else {
                ?>
                <div class="display-text">
                <div class="sikertelen-check">
                Nincs sikeres pontérintés, menj tovább a megadott irányban!
                </div>
                </div>
                <?php
            }
            
        } else {
            
            if ($no_cp_finished) {
                require('first_cp.php');
                
            } else {
                
                
                require('mid-tour.php');
                
                
            }
        }
    }
}



if ($show_direction) {
    require('direction-and-left-time.php');
}
