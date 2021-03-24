<?php



wp_head();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
<meta charset='<?php bloginfo( 'charset' ); ?>'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
</head>

<?php 
require_once("css.php");
?>
<body>


<?php 






$email='';
$show_next_button=true;
$show_direction=true;
$utvonal=get_queried_object();

$accepted=false;





$logout_url=add_query_arg( 'logout', true, home_url().$_SERVER['REQUEST_URI'] );
?>




<?php 

$ut_name='utvonal_'.esc_sql( $utvonal->slug );

$button_text='FRISSÍTÉS';
$enable_rajt_button=false;

require("ut_login.php");


if (isset ($_POST['race_ID']) || isset($_COOKIE["race_ID"]) || isset($_SESSION['userid'])) {
  
  
  
  if (isset ($_POST['race_ID'])) {
    $race_ID=$_POST['race_ID'];
    
    $check_ID=$wpdb->get_var( "SELECT email FROM `$ut_name` WHERE race_ID='$race_ID'" );
    if ($check_ID!='') {
      $_SESSION['userid']=$check_ID;
      $userid=$_SESSION['userid'];
      
      
      
    }
  } else {
    if (!empty($userid)) {
      $race_ID=$wpdb->get_var("SELECT last_race_ID FROM `qrhiker_users` WHERE email='$userid'");
      $cookie_name = "race_ID";
      $cookie_value =$race_ID;
      setcookie($cookie_name, $cookie_value, time() + (14 * 86400), "/"); // 86400 = 1 day
    } 
  }
  
  if (empty($race_ID)) {
    if (isset ($_COOKIE['race_ID'])) {
      $race_ID=$_COOKIE['race_ID'];
    }
    
  }
  
  
  
  if (isset($_POST['quitted'])) {
    $wpdb->update( $ut_name, array ('is_finished' => 'dnf', 'quit_cause' => $_POST['quitcause']), array ('race_ID'=>$race_ID) );
  }
  
  
  $check_email=$wpdb->get_var( "SELECT email FROM `$ut_name` WHERE race_ID='$race_ID'" );
  
  if ($check_email!=NULL) {
    $email=$check_email;
    $is_started=$wpdb->get_var("SELECT first_cp_time FROM `$ut_name` WHERE race_ID='$race_ID'");
    
    $cookie_name = "race_ID";
    $cookie_value = $race_ID;
    setcookie($cookie_name, $cookie_value, time() + (14 * 86400), "/"); // 86400 = 1 day
    $check_scored=$wpdb->get_var("SELECT score_time FROM `$ut_name` WHERE race_ID='$race_ID'");
    $check_dnf=$wpdb->get_var("SELECT is_finished FROM `$ut_name` WHERE race_ID='$race_ID'");
    
    if (!$check_scored && !$check_dnf) {
      
      ?>
      
      <div class=menu-holder>
      <img id="ham-menu" src="<?php  echo get_stylesheet_directory_uri();?>/img/menu.png" alt="" width="30" height="30">
      
      </div>
      
      <?php 
      require("ut_menu.php");
    }
    
    if ($check_scored) {
      echo $CONGRATS;
      br();
      echo 'Teljesítési idő: '.secondstotime(strtotime($check_scored)-strtotime($is_started));
      
    } else {
      
      
      if ($check_dnf=='dnf') {
        echo 'A teljesítést feladtad!';
      } else {
        
        
        $userdata = $wpdb->get_results("SELECT * FROM `$ut_name` INNER JOIN `qrhiker_users` ON `$ut_name`.email=qrhiker_users.email WHERE race_ID='$race_ID';");
        $userdata = $userdata[0];
        require('get-current-position.php');
      }
    }
  } else {
    echo $NO_START;
    ?>
    
    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
    <input type="email" name="login-email" placeholder="email">
    <input type="password" name="login-password" placeholder="jelszó">
    <input type="hidden" name="islogin" value="1">
    <button type="submit" name="submit">OK</button>
    
    </form>
    <?php
  }
  
  
  
} else { 
  require_once("id_unset.php");
}
if (!empty($race_ID)) {
  
  if ($show_next_button) {
    # code...
    
    ?>  
    <br>
    <?php if (isset($race_ID) && !$check_scored && $check_dnf!='dnf'):
      $finished_cp_count=0;
      foreach ($checkpoints as $checkpoint) {
        
        $table='checkpoint_'.$checkpoint->post_name;
        
        $is_finished_cp=$wpdb->get_var( "SELECT check_time FROM `{$table}` WHERE race_ID='$race_ID'" );
        if (!empty($is_finished_cp)) {
          $finished_cp_count++;
        }
      }
      echo '<div class="display-text">';
      echo $finished_cp_count.' ellenőrzőpont teljesítve';
      ?>
      </div>
      <div id="buttons">
      
      <input type="button" id="start" class="blue-bg" value="<?php echo $button_text ?>">
      <?php endif ?>
      
      <script>
      <?php 
      if ($enable_rajt_button) {
        ?>
        document.getElementById('start').onclick = alertmainFunction;
        document.getElementById('start').ontouchstart= alertmainFunction;
        <?php
      } else {
        ?>
        document.getElementById('start').onclick = mainFunction;
        document.getElementById('start').ontouchstart= mainFunction;
        //  	document.getElementById('buttondiv').onclick = mainFunction;
        //	document.getElementById('buttondiv').ontouchstart= mainFunction;
        <?php } ?>
        function alertmainFunction() {
          alert(" <?php echo $START_TOUR ?>");
          mainFunction();
        }
        </script>
        
        <?php if ($is_started=='') {
          $button_class=$enable_rajt_button? 'grey-bg' : 'blue-bg';
          
          ?>
          
          <?php if ($enable_rajt_button) { ?>
            <input type="button" id="rajtbutton" class="<?php echo $button_class ?>" value="rajt">
            <script>
            function rajter() {
              document.getElementById("rajt").value = 2;
              setTimeout( function () {
                mainFunction();
              }
              , 1500);
              
            }
            
            
            document.getElementById('rajtbutton').onclick = rajter;
            document.getElementById('rajtbutton').ontouchstart = rajter;
            <?php
          } ?>
          
          
          </script>
          </div>
          <?php 
        } ?>
        
        <?php }} 
        
        wp_footer(); ?>
        </body>
        
        </html>