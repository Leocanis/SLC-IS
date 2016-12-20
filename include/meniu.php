<?php
//Formuojamas meniu.
if (isset($session) && $session->logged_in) {
    $path = "";
    if (isset($_SESSION['path'])) {
        $path = $_SESSION['path'];
        unset($_SESSION['path']);
    }
    ?>
	
    <table class="meniu" width="100%">
        <?php
		
        echo "<tr><td>";
        echo "Prisijungęs vartotojas: <b>$session->username</b> <br>";
        echo "</td></tr><tr><td>";
		echo ""
		."<nav class=\"navbar navbar-inverse\"> "
		 . "<div class=\"container-fluid\">"			
			."<ul class=\"nav navbar-nav\">"
			  ."<li class=\"dropdown\">"
			  ."<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Inventorius<span class=\"caret\"></span></a>"
			  ."<ul class=\"dropdown-menu\">"
			  ."<li><a href=\"" . $path ."inventorius/inventorius.php\">Naujas inventorius</a></li> "
			  ."<li><a href=\"" . $path ."inventorius/inventoriuslist.php\">Inventoriaus sąrašas</a></li> "
			  ."<li><a href=\"" . $path ."inventorius/radiniai.php\">Radiniai</a></li> ";
			  //Trečia operacija rodoma valdytojui ir administratoriui
				if ($session->isManager() || $session->isAdmin()) {
					echo "<li><a href=\"" . $path . "inventorius/inventoriusrezervacija.php\">Inventoriaus rezervacija</a></li>";
					echo "<li><a href=\"" . $path . "inventorius/reservationlist.php\">Rezervacijų sąrašas</a></li>";
				}
				echo "</ul>";
				echo "</li>";
				if ($session->isAdmin()) {
					echo "<li><a href=\"" . $path . "admin/admin.php\">Administratoriaus sąsaja</a></li>";
				}
				if ($session->isManager() || $session->isAdmin()) {
					echo "<li><a href=\"" . $path . "register.php\">Registracija</a></li> ";
				}
				echo	"</ul>";
				echo "<ul class=\"nav navbar-nav navbar-right\">";
				echo "<li><a href=\"" . $path . "userinfo.php\"><span class=\"glyphicon glyphicon-user\"></span> $session->username</a><li>";
				echo "<li><a href=\"" . $path . "process.php\">Atsijungti</a></li>";
		echo	"</ul>"
		  ."</div>"
		."</nav>";       
        echo "</td></tr>";
        ?>
    </table>
    <?php
}//Meniu baigtas
?>

