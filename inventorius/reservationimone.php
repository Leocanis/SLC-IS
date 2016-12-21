<?php
include("../include/session.php");
//Jei prisijunges Administratorius ar Valdytojas vykdomas operacija3 kodas

function mysqli_result($res, $row, $field=0) {
	$res->data_seek($row);
	$datarow = $res->fetch_array();
	return $datarow[$field];
}

if ($session->logged_in && ($session->isAdmin() || $session->isManager())) {
	
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
            <table class="center"><tr><td>
                        <?php
						include("../include/header.php");
						?>
                    </td></tr>
                    <tr><td> 
                        <?php
                        $_SESSION['path'] = '../';
                        include("../include/meniu.php");
                        ?>                   
                        <table><tr><td>
                                    Atgal į <a href="../index.php">Pradžia</a>
                                </td></tr></table>               
                        <br> 
                        <form action="inventoriusprocess.php" style="text-align:left;" method="POST">
                        <?php 
						if(isset($_SESSION['newcompres']))    
						{
							echo "Sėkmingai pridėta inventoriaus rezervacija renginiui!";
							unset($_SESSION['newcompres']);
						}
                        	                        
                        ?>
                        
                        <h2><center>Inventoriaus rezervacija renginiui</center></h2>
                        
                        <table class="table table-bordered">
                         <tr><td>
                         Pavadinimas: 
                         </td><td>
                         <select name="compid">
                         <?php 
                         $q = "select id, pavadinimas from imones order by pavadinimas";
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
                         for ($i = 0; $i < $num_rows; $i++) {
                         	echo "<option value=\"".mysqli_result($result, $i, "id")."\">".mysqli_result($result, $i, "pavadinimas")."</option>";
                         }
                         ?>
                         </select>
                         </td></tr>
                         <tr><td>
                         Data: 
                         </td><td>
                         <input name="resdate" class="inv_input" type="date" required value=""/>
                         </td></tr>                         
                         <tr><td>
                         Reikalingas pagalbininkų skaičius: 
                         </td><td>
                         <input name="respagsk" class="inv_input" type="number" required value=""/>
                         </td></tr>                                               
                         </table>
                         <input type="hidden" name="subaddreservationimone" value="1">
                         <input class="btn btn-lg btn-primary btn-block" type="submit" value="Pridėti">                        
                        </form>
                        </td></tr> 
                        <br> 
                        </td></tr>                        
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
    //Jei vartotojas neprisijungęs arba prisijunges, bet ne Administratorius 
    //ar ne Valdytojas - užkraunamas pradinis puslapis   
} else {
    header("Location: ../index.php");
}
?>
