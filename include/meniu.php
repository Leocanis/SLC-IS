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
			  ."<li><a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a></li> "
			  ."<li class=\"dropdown\">"
			  ."<a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">Operacijos<span class=\"caret\"></span></a>"
			  ."<ul class=\"dropdown-menu\">"
			  ."<li><a href=\"" . $path . "operacija1.php\">Demo operacija1</a></li> "
			  ."<li><a href=\"" . $path . "operacija2.php\">Demo operacija2</a></li> ";
			  //Trečia operacija rodoma valdytojui ir administratoriui
				if ($session->isManager() || $session->isAdmin()) {
					echo "<li><a href=\"" . $path . "operacija3.php\">Demo operacija3</a></li>";
				}
				echo "</ul>";
				echo "</li>";
				if ($session->isAdmin()) {
					echo "<li><a href=\"" . $path . "admin/admin.php\">Administratoriaus sąsaja</a></li>";
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

<?php
/*
  //Arba galime padaryti tą patį meniu aprašydami klase, ir sukurdami jos tipo objektą.
  class Meniu {

  function Meniu($session) {
  if (isset($session) && $session->logged_in) {
  $path = "";
  if (isset($_SESSION['path'])) {
  $path = $_SESSION['path'];
  unset($_SESSION['path']);
  }
  ?>
  <table width=100% border="0" cellspacing="1" cellpadding="3" class="meniu">
  <?php
  echo "<tr><td>";
  echo "Prisijungęs vartotojas: <b>$session->username</b> <br>";
  echo "</td></tr><tr><td>";
  echo "[<a href=\"" . $path . "userinfo.php?user=$session->username\">Mano paskyra</a>] &nbsp;&nbsp;"
  . "[<a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a>] &nbsp;&nbsp;"
  . "[<a href=\"" . $path . "operacija1.php\">Demo operacija1</a>] &nbsp;&nbsp;"
  . "[<a href=\"" . $path . "operacija2.php\">Demo operacija2</a>] &nbsp;&nbsp;";
  //Trečia operacija rodoma valdytojui ir administratoriui
  if ($session->isManager() || $session->isAdmin()) {
  echo "[<a href=\"" . $path . "operacija3.php\">Demo operacija3</a>] &nbsp;&nbsp;";
  }
  //Administratoriaus sąsaja rodoma tik administratoriui
  if ($session->isAdmin()) {
  echo "[<a href=\"" . $path . "admin/admin.php\">Administratoriaus sąsaja</a>] &nbsp;&nbsp;";
  }
  echo "[<a href=\"" . $path . "process.php\">Atsijungti</a>]";
  echo "</td></tr>";
  ?>
  </table>
  <?php
  }
  }

  }

  //Sukuriamas objektas
  if (isset($session)) {
  $meniu = new Meniu($session);
  }
 */
?>
