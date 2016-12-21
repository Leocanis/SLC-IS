<?php

include("../include/session.php");


function displayReservation()
{
	global $database;

	$q = "SELECT i.pavadinimas, r.data, r.pagalbininkai FROM rezervacija_renginiui r, imones i where r.imones_id = i.id";
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
			<th>Įmones pavadinimas</th>
    		<th>Data</th>
    		<th>Pagalbininkai</th></tr></thead><tbody>";
	for ($i = 0; $i < $num_rows; $i++) {


		echo "<tr>";
		echo "<td>". mysqli_result($result, $i, "pavadinimas") ." </td>";
		echo "<td>". mysqli_result($result, $i, "data") ." </td>";
		echo "<td>". mysqli_result($result, $i, "pagalbininkai") ." </td>";
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