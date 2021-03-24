<?php 

if ($checkpoints[$current_cp]->post_title==$indulo_cp) {


        
            if ($_POST["rajt"]==2) {
                require('accept-cp.php');
                    $wpdb->update( $ut_name, array ('first_cp_time' => $check_time), array ('race_ID'=>$race_ID) );
                    $accepted=true;
                echo '<div class="sikeres-check">';
                echo '<br>Sikeresen elrajtoltál!';
                echo '</div>';
            } else {
        
                echo '<div class="display-text">';
                
                echo '<br>A GPS jel pontossága: '.ceil($_POST['geo_acc']).' méter<br><br>';
                echo 'Az induláshoz nyomd meg a rajt gombot és ellenőrizd, hogy a rendszer jóváhagyja-e! A további pontoknál a frissítés gombbal jelentkezhetsz be!';
                echo '</div>';
                $enable_rajt_button=true;
        
            }
    

	

	 


} else {
	echo '<div class="sikertelen-check">';

	echo '<br>Nem ezt az indulási pontot adtad meg!';
		echo '</div>';
	$next_index=$indulo_cp_index;
}

//require ('offline-check.php');