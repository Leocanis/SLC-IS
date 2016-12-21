<?php
include("../include/session.php");

if(isset($_POST["papildoma_info"])) {
    //insert

}

if(isset($_POST["pavadinimas"])) {
    //insert
    $result = $database->query("insert into renginiai (pavadinimas, pradzia, pabaiga, aprasymas, statusas) values ('".$_POST["pavadinimas"]."', '".$_POST["pradzia"]."', '".$_POST["pabaiga"]."', '".$_POST["aprasymas"]."', '".$_POST["statusas"]."')");
    $_POST = array();
}

function show_form() {
    global $session;
	global $database;
    $naudotojoID = $database->selectUserID($session->username);
    if(isset($_POST["papildoma_info"])) {
        $result = $database->query("insert into renginiu_dalyviai (naudotojo_id, renginio_id, patvirtinimas, papildoma_info) values (".$naudotojoID['id'].", ".$_POST["rngid"].", 0, '".$_POST["papildoma_info"]."')");
        echo 'Registracija sėkminga <a href="renginys.php?rngid='.$_POST["rngid"].'">Atgal</a>';
        $_POST = array();
    } else {
        if(isset($_GET["rngid"])) {
            $result = $database->query("select * from renginiu_dalyviai rd where rd.renginio_id =".$_GET["rngid"]." and rd.naudotojo_id = ".$naudotojoID['id']);
            if($dalyvis = $result->fetch_assoc()) {
                echo 'Jau užsiregistravote į šį renginį';
            } else {
                echo '<form method="post">';
                echo '<input type="hidden" name="rngid" value="'.$_GET["rngid"].'">';
                echo '<div class="form-group"><label for="papildoma_info">Papildoma informacija</label><textarea class="form-control" rows="10" id="papildoma_info" name="papildoma_info"></textarea></div>';
                echo '<button type="submit" class="btn btn-default">Registruotis</button></form>';
            }
        }
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