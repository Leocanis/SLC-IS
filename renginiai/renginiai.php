<?php
include("../include/session.php");

function show_list() {
	global $database;
	echo '<table class="table"><thead><tr><th>Pavadinimas</th><th>Pradžia</th><th>Pabaiga</th><th>Statusas</th><th>Turnyras</th><th>Veiksmai</th></tr></thead><tbody>';
	if ($result = $database->query("select * from renginiai")) {
		while ($row = $result->fetch_assoc()) {
	        echo  '<tr><td>'.$row["pavadinimas"].'</td><td>'.$row["pradzia"].'</td><td>'.$row["pabaiga"].'</td><td>'.$row["statusas"].'</td><td><a href="turnyras.php?trnid='.$row["turnyro_dalyviu_lentele"].'">Turnyrinė lentelė</a></td><td><a href="renginiaiform.php?rngid='.$row["id"].'">Keisti</a></td></tr>';
	    }
	} else {
		echo 'tuščia';
	}
    echo '</tbody></table>';
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
                        show_list();
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