<?php
function inTime($teljesites, $trailname) {
   $cp=get_checkpoints($trailname)[0];
   $szintido=get_post_meta( $cp->ID, $teljesites->vehicle, true )*60;
   $gyors=strtotime($teljesites->score_time)-strtotime($teljesites->first_cp_time);
   return $gyors-$szintido<0 ? true : false; 
}