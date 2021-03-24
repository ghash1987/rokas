<?php
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );


$checkpoints = get_checkpoints($term);

$check_time=current_time( 'Y-m-d H:i:s', 0 );

$metas = get_post_meta( $checkpoints[0]->ID, false );






?>



<script>


function mainFunction() {
  var x=  document.getElementsByClassName('display-text');
  var i;
  for (i = 0; i < x.length; i++) {
    x[i].innerHTML = "";
  }
  document.getElementById('buttons').innerHTML="Kis türelmet kérünk amíg lekérjük a helyzetedet";
  var timeo=0;
  var count=0; 
  do {
    count++; 
    timeo=100+count*10;
    setTimeout( function () {
      // document.getElementById('buttons').innerHTML+=".";
      handlePermission();
    }
    , timeo);
    user();
    
    
  } while (count<4);
  setTimeout( function () {
    //document.getElementById("demo").innerHTML=document.getElementById('geo_lat').value;
    document.getElementById("myForm").submit();
  }
  , 3000);
  
  
}

</script>

<p id="demo"></p>
<form id="myForm" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="hidden" name="geo_lat" id="geo_lat" value="1">
<input type="hidden" name="geo_long" id="geo_long" value="1">
<input type="hidden" name="hiba" id="hiba" value="1">
<input type="hidden" name="hiba2" id="hiba2" value="1">
<input type="hidden" name="rajt" id="rajt" value="1">
<input type="hidden" name="osnamer" id="osnamer" value="1">
<input type="hidden" name="os_version" id="os_version" value="1">
<input type="hidden" name="browser_name" id="browser_name" value="1">
<input type="hidden" name="browser_version" id="browser_version" value="1">
<input type="hidden" name="geo_acc" id="geo_acc" value="1">
</form>

<?php


if (!isset($_POST["geo_lat"])) {
  
  ?>
  
  <br>
  <div class="display-text">
  A helyzeted megállapításához kattints a gombra!<br>
  </div>
  <script type="text/javascript" src=" <?php echo get_stylesheet_directory_uri()."/js/qrhiker-js.js" ?>"></script>
  
  <script>getCurrentLocation();</script>
  
  
  
  <?php
} else {
  
  if ($_POST['geo_lat']==1) {
    echo 'Az oldal nem kap megfelelő GPS koordinátákat.<br>Kérjük ellenőrizd, hogy megadtad-e a helyadatokhoz való hozzáférést az oldal számára!<br><br>Amennyiben megadtad, kérjük ellenőrizd egy térkép alkalmazásban a pozíciódat (pl. Google Maps), majd lépj vissza és próbáld ismét!';
  } else { 
    
  }
  
  if ($_POST['hiba2']=='permission denied-low') {
    
    echo '<br>Nem adtál engedélyt a helyadatok lekéréséhez!<br>';
  }
  
  
  require('arrange.php');
  if ($current_cp!=-1) {
    $curr_db=$checkpoints[$current_cp]->post_name;
  } else {
    $curr_db=$qrh_distance;
  }
  
  if ($accepted) {
    $curr_db.='-check';
  }
  
  $gps_test_db='gps_test_db';
  $wpdb->insert( 
    $gps_test_db, 
    array
    ( 
      'geo_long' => $geo_long,
      'geo_lat'  => $geo_lat,
      'hiba'  => $_POST['hiba'],
      'hiba2'  => $_POST['hiba2'],
      'race_ID' => $race_ID,
      'name' => $userdata->name,
      'os_name' => $_POST['osnamer'],
      'os_version' => $_POST['os_version'],
      'browser_name' => $_POST['browser_name'],
      'browser_version' => $_POST['browser_version'],
      'geo_acc' => $_POST['geo_acc'],
      'current_cp' => $curr_db
      )
      
    );
    
    
  }