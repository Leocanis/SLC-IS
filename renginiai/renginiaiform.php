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
	global $database;
    echo '<form method="post">';
    if(isset($_GET["rngid"])) {
        if ($result = $database->query("select * from renginiai where id =".$_GET["rngid"])) {
            $renginys = $result->fetch_assoc();
            echo '<input name="rngid" value="'.$_GET["rngid"].'" type="hidden">';
            echo '<div class="form-group"><label for="pavadinimas">Pavadinimas</label><input class="form-control" id="pavadinimas" name="pavadinimas" type="text" value="'.$renginys["pavadinimas"].'"></div>';
            $d = new DateTime($renginys["pradzia"]);
            echo '<div class="form-group"><label for="pradzia">Pradžia</label><input class="form-control" id="pradzia" name="pradzia" type="datetime-local" value="'.$d->format('Y-m-d\TH:i').'"></div>';
            $d = new DateTime($renginys["pabaiga"]);
            echo '<div class="form-group"><label for="pabaiga">Pabaiga</label><input class="form-control" id="pabaiga" name="pabaiga" type="datetime-local" value="'.$d->format('Y-m-d\TH:i').'"></div>';
            echo '<div class="form-group"><label for="aprasymas">Aprašymas</label><textarea class="form-control" rows="10" id="aprasymas" name="aprasymas">'.$renginys["aprasymas"].'</textarea></div>';
            echo '<div class="form-group"><label for="statusas">Statusas</label><input class="form-control" id="statusas" name="statusas" type="text" value="'.$renginys["statusas"].'"></div>';
        }
    } else {
        echo '<div class="form-group"><label for="pavadinimas">Pavadinimas</label><input class="form-control" id="pavadinimas" name="pavadinimas" type="text"></div>';
        echo '<div class="form-group"><label for="pradzia">Pradžia</label><input class="form-control" id="pradzia" name="pradzia" type="datetime-local"></div>';
        echo '<div class="form-group"><label for="pabaiga">Pabaiga</label><input class="form-control" id="pabaiga" name="pabaiga" type="datetime-local"></div>';
        echo '<div class="form-group"><label for="aprasymas">Aprašymas</label><textarea class="form-control" rows="10" id="aprasymas" name="aprasymas"></textarea></div>';
        echo '<div class="form-group"><label for="statusas">Statusas</label><input class="form-control" id="statusas" name="statusas" type="text"></div>';
    }
    echo '<button type="submit" class="btn btn-default">Įvesti</button>';
    echo '</form>';
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