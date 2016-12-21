<?php
include("../include/session.php");

if(isset($_POST["rngid"])) {
    //update
    $result = $database->query("update renginiai set pavadinimas = '".$_POST["pavadinimas"]."', pradzia = '".$_POST["pradzia"]."', pabaiga = '".$_POST["pabaiga"]."', aprasymas = '".$_POST["aprasymas"]."', statusas = '".$_POST["statusas"]."' where id =".$_GET["rngid"]);
    $_POST = array();
}

if(isset($_POST["pavadinimas"])) {
    //insert
    $result = $database->query("insert into renginiai (pavadinimas, pradzia, pabaiga, aprasymas, statusas) values ('".$_POST["pavadinimas"]."', '".$_POST["pradzia"]."', '".$_POST["pabaiga"]."', '".$_POST["aprasymas"]."', '".$_POST["statusas"]."')");
    $_POST = array();
}

function show_form() {
    global $session;
	global $database;
    if(isset($_GET["rngid"])) {
        if ($result = $database->query("select * from renginiai where id =".$_GET["rngid"])) {
            $renginys = $result->fetch_assoc();
            //echo '<form method="post">';
            echo '<input name="rngid" value="'.$_GET["rngid"].'" type="hidden">';
            echo '<div class="form-group"><label for="pavadinimas">Pavadinimas</label><input disabled class="form-control" id="pavadinimas" name="pavadinimas" type="text" value="'.$renginys["pavadinimas"].'"></div>';
            $d = new DateTime($renginys["pradzia"]);
            echo '<div class="form-group"><label for="pradzia">Pradžia</label><input disabled class="form-control" id="pradzia" name="pradzia" type="datetime-local" value="'.$d->format('Y-m-d\TH:i').'"></div>';
            $d = new DateTime($renginys["pabaiga"]);
            echo '<div class="form-group"><label for="pabaiga">Pabaiga</label><input disabled class="form-control" id="pabaiga" name="pabaiga" type="datetime-local" value="'.$d->format('Y-m-d\TH:i').'"></div>';
            echo '<div class="form-group"><label for="aprasymas">Aprašymas</label><textarea disabled class="form-control" rows="10" id="aprasymas" name="aprasymas">'.$renginys["aprasymas"].'</textarea></div>';
            echo '<div class="form-group"><label for="statusas">Statusas</label><input disabled class="form-control" id="statusas" name="statusas" type="text" value="'.$renginys["statusas"].'"></div>';
            //echo '<button type="submit" class="btn btn-default">Įvesti</button>';
            $naudotojoID = $database->selectUserID($session->username);
            $result = $database->query("select * from renginiu_dalyviai rd where rd.renginio_id =".$_GET["rngid"]." and rd.naudotojo_id = ".$naudotojoID['id']);
            if($dalyvis = $result->fetch_assoc()) {
                echo 'Jau užsiregistravote į šį renginį';
            } else {
                echo '<a href="registracijairengini.php?rngid='.$_GET["rngid"].'">Registruotis</a>';
            }
            //echo '</form>';
            if ($session->isManager() || $session->isAdmin()) {
                if ($result = $database->query("select rd.id, rd.patvirtinimas, rd.registracijos_data, n.vardas, n.pavarde from renginiu_dalyviai rd, naudotojas n where n.id = rd.naudotojo_id and rd.renginio_id =".$_GET["rngid"]." order by rd.registracijos_data desc")) {
                    echo '<table class="table"><thead><tr><th>Vardas</th><th>Pavardė</th><th>Tvirtinti</th></tr></thead><tbody>';
                    while($dalyvis = $result->fetch_assoc()) {
                        echo '<tr><td>'.$dalyvis["vardas"].'</td><td>'.$dalyvis["pavarde"].'</td><td>';
                        if($dalyvis["patvirtinimas"] != "1") {
                            echo '<a href="patvirtintiregistracija.php?dalid='.$dalyvis["id"].'">Tvirtinti</a>';
                        } else {
                            echo '<a href="panaikintiregistracija.php?dalid='.$dalyvis["id"].'">Atšaukti</a>';
                        }
                        echo '</td></tr>';
                    }
                    echo '</tbody></table>';
                }
            }
        }
    } else {
        echo '<div>Klaida!</div>';
    }
}


if ($session->logged_in) {
    ?>
    <html>
        <head>  
            <meta http-equiv="X-UA-Compatible" content="IE=9; text/html; charset=utf-8"/> 
            <title>SLC ĮS</title>
			<!-- jQuery library -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

			<!-- Latest compiled JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			<link rel="stylesheet" href="../style/style.css">		
		</head>
        <body>
        <div class="container">
		<div class="wrapper"> 
            <table class="center" >
                <tr><td>
                        <?php
						include("../include/header.php");
						?>
                    </td></tr><tr><td> 
                        <?php
                        $_SESSION['path'] = '../';
                        include("../include/meniu.php");
                        ?>  
                        <table><tr><td>
                                    Atgal į <a href="../index.php">Pradžia</a>
                                </td></tr></table>               
                        <br> 
                        
                        <?php 
                        show_form();
                        ?>
                         
                        <br>  
                <tr><td>
                        <?php
                        include("../include/footer.php");
                        ?>
                    </td></tr>      
            </table>
        </div>
        </div>
        </body>        
    </html>
    <?php
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: ../index.php");
}
?>