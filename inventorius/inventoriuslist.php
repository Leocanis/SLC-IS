<?php
include("../include/session.php");

function displayInventor()
{
	global $database;
	
	if(isset($_SESSION['search']))
	{
		$q = "select * from inventorius where pavadinimas like '%". $_SESSION['search'] ."%' order by pavadinimas";
	}
	else
	{
		$q = "select * from inventorius order by pavadinimas";
	}
	$result = $database->query($q);
	unset($_SESSION['search']);
	
	$num_rows = mysqli_num_rows($result);
	if (!$result || ($num_rows < 0)) {
		echo "Error displaying info";
		return;
	}
	if ($num_rows == 0) {
		echo "Lentelė tuščia.";
		return;
	}
	
	echo "<form action=\"inventoriusprocess.php\" style=\"text-align:left;\" method=\"POST\">";
	echo "<p>Paieška:</p>";
	echo "<input name=\"invSearch\" class=\"inv_input\" type=\"text\" size=\"50\" required value=\"\"/>";
	echo "<input type=\"hidden\" name=\"subsearch\" value=\"1\">";
    echo "<input type=\"submit\" value=\"Ieškoti\">"; 
    echo "</from>";
	
	echo "<table class=\"table\">";
	echo "<thead class=\"table-hover\"><tr>
			<th>Pavadinimas</th>
    		<th>Vieta</th>
    		<th>Būsena</th>
    		<th>Padėtis</th>
    		<th>Pastabos</th>
			<th>Ar mobilus</th>
			<th>Veiksmai</th></tr></thead><tbody>";
	for ($i = 0; $i < $num_rows; $i++) {
		
		
		echo "<tr>";
		echo "<td>". mysqli_result($result, $i, "pavadinimas") ." </td>";
		echo "<td>". mysqli_result($result, $i, "vieta") ." </td>";
		echo "<td>". mysqli_result($result, $i, "busena") ." </td>";
		echo "<td>". mysqli_result($result, $i, "padetis") ." </td>";
		echo "<td>". mysqli_result($result, $i, "pastabos") ." </td>";
		echo "<td> <input type=\"checkbox\" disabled "; 
		if(mysqli_result($result, $i, "ar_mobilus") == 1){
			echo " checked ";
		}
		else{
			echo " unchecked ";
		}
		echo " ></td>";
		echo "<td><a href='inventoriusprocess.php?e=1&invedit=".mysqli_result($result, $i, "pavadinimas")."'";
		echo ">Redaguoti</a> | <a href='inventoriusprocess.php?d=1&invdel=".mysqli_result($result, $i, "pavadinimas")."'>Trinti</a></td>";
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
                        displayInventor();
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