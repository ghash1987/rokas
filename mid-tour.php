<?php

if ($current_cp==0) {
  $previous_cp_num=$checkpoints_length-1;
} else {
  $previous_cp_num=$current_cp-1;
}
$prev_table=esc_sql('checkpoint_'.$checkpoints[$previous_cp_num]->post_name);
$previous_cp_check_time=$wpdb->get_var( "SELECT check_time FROM `{$prev_table}` WHERE race_ID='$race_ID'" );

if ($previous_cp_check_time=='') {
	?> 	<div class="sikertelen-check">	<?php
	echo 'nincs meg az előző ellenőrzőpont!';
	?> 	</div>	<?php


	$next_index=$last_checked_cp_index;

} else {
	require ('accept-cp.php');
	br();
	        ?>
      <div class="display-text">
      	<div class="sikeres-check">
	 Sikeres ellenőrzőpont érintés!
	 </div>
      </div>
      <?php
	br();
} 