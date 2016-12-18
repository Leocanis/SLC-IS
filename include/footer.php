<?php

/**
 * Just a little page footer, tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. 
 */
if (isset($database)) {    
	
	echo ""
	. "<div class=\"panel-footer\">"
	. "<b>Registruotų vartotojų kiekis: </b> " . $database->getNumMembers() . ".&nbsp"
	. "</div>";
}
?>