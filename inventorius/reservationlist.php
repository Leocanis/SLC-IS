<?php

include("../include/session.php");


function displayReservation()
{
	global $database;

	$q = "SELECT i.pavadinimas, n.username, r.galioja_nuo, r.galioja_iki, r.komentaras, r.zmoniu_kieks FROM rezervacija r, naudotojas n, inventorius i where i.id = r.inventoriaus_id and r.naudotojo_id = n.id";
	$result = $database->query($q);

	$num_rows = mysqli_num_rows($result);
	if (!$result || ($num_rows < 0)) {
		echo "Error displaying info";
		return;
	}
	if ($num_rows == 0) {
		echo "Lentelė tuščia.";
		return;
	}



	echo "<table class=\"table\">";
	echo "<thead class=\"table-hover\"><tr>
			<th>Inventorius</th>
    		<th>Naudotojas</th>
    		<th>Galioja nuo</th>
    		<th>Galioja iki</th>
			<th>Komentaras</th>
			<th>Žmonių kiekis</th></tr></thead><tbody>";
	for ($i = 0; $i < $num_rows; $i++) {


		echo "<tr>";
		echo "<td>". mysqli_result($result, $i, "pavadinimas") ." </td>";
		echo "<td>". mysqli_result($result, $i, "username") ." </td>";
		echo "<td>". mysqli_result($result, $i, "galioja_nuo") ." </td>";
		echo "<td>". mysqli_result($result, $i, "galioja_iki") ." </td>";
		echo "<td>". mysqli_result($result, $i, "komentaras") ." </td>";
		echo "<td>". mysqli_result($result, $i, "zmoniu_kieks") ." </td>";		
		echo "</tr>";

	}
	echo "</tbody></table>";
}

function mysqli_result($res, $row, $field=0) {
	$res->data_seek($row);
	$datarow = $res->fetch_array();
	return $datarow[$field];
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
                        displayReservation();
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