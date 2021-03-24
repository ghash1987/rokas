<script>

jQuery(document).ready(function( $ ) {
  
        document.getElementById('ham-menu').onclick = toggleMenu;

        function toggleMenu() {
        jQuery(".menu-items").toggle(500);

        } 

        document.getElementById('logout').onclick = logout;

        function logout() {
        	document.cookie = "race_ID=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        	document.cookie = "userid=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        	window.location.replace("<?php echo $logout_url; ?>");
        }

        function quitAlert() {
            if (confirm(" <?php echo $FELADAS ?>")) {
        document.getElementById("delete_user_form").submit();
        }
      }

      document.getElementById('quit').onclick = quitConfirm;

      function quitConfirm() {
      	if (confirm( "<?php echo $FELADAS_KERDES ?>" )) {
      		document.body.innerHTML=document.getElementById("quitformwrap").innerHTML;
      		jQuery("#quitform").show();
      	}
      	
      }


  
  
});


</script>

<div class="menu-items">
    
	<div>
    	<div id="quit">Feladás</div> 
          	<div id=quitformwrap>
          	<form id="quitform" style="display:none;" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post">
        		    	<?php echo $FELADAS_OKA ?><br>
          		<select name="quitcause" id="quitcause" style="color: #3C4858">
          			<option value="Sérülés">Sérülés</option>
          			<option value="Fáradtság">Fáradtság</option>
          			<option value="Eltévedás">Eltévedés</option>
          			<option value="Rendszerhiba">Rendszerhiba</option>
                <option value="Szintidőtúllépés">Szintidő túllépése</option>
          		</select>
          		<input type="hidden" name="quitraceid">
          		<input type="hidden" name="quitted" value="1">
          		<input type="submit">
          	</form>
          	</div>
	   </div>

     
    <div id="logout">Kijelentkezés</div>
    <a style="text-decoration: none" href="<?php echo home_url().'/informacio' ?>"><div>Információ</div></a>
        <a style="text-decoration: none" href="<?php echo home_url().'/reszletes-utvonalleiras' ?>"><div>Részletes útvonalleírás</div></a>
</div>
</div>