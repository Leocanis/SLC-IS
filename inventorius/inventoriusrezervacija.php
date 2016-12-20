<?php
include("../include/session.php");
//Jei prisijunges Administratorius ar Valdytojas vykdomas operacija3 kodas
if ($session->logged_in && ($session->isAdmin() || $session->isManager())) {
	
	function mysqli_result($res, $row, $field=0) {
		$res->data_seek($row);
		$datarow = $res->fetch_array();
		return $datarow[$field];
	}
	
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
                        
                        if(isset($_SESSION['newrez']))
                        {
                        	echo "Rezervacija sėkmingai pridėta!";
                        	unset($_SESSION['newrez']);
                        }
                        
                        if(isset($_SESSION['reserror']))
                        {
                        	echo $_SESSION['reserror'];
                        	unset($_SESSION['reserror']);
                        }
                        	
                        	                        
                        ?>
                        
                        <h2><center>Inventoriaus rezervacija</center></h2>
                        
                        <table class="table table-bordered">
                         <tr><td>
                         Inventorius:
                         </td><td>
                         <select name="invName" class="inv_input">
                         	<?php 
                         	$q = "select pavadinimas from inventorius order by pavadinimas";
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
                         		echo "<option value=\"".mysqli_result($result, $i, "pavadinimas")."\">".mysqli_result($result, $i, "pavadinimas")."</option>";
                         	}
                         	?>
                         </select>
                         </td></tr>
                         <tr><td>
                         Nuo: 
                         </td><td>
                         <input name="invNuo" class="inv_input" type="datetime-local" required value=""/>
                         </td></tr>
                         <tr><td>
                         Iki:
                         </td><td>
                         <input name="invIki" class="inv_input" type="datetime-local" required value=""/>
                         </td></tr>
                         <tr><td>
                         Komentaras:
                         </td><td>
                         <textarea name="invKom" class="inv_input"></textarea>
                         </td></tr>
                         <tr><td>
                         Žmonių kiekis:
                         </td>
                         <td>
                         <input name="invKiekis" class="inv_input" type="number" value="0" /> 
                         </td></tr>
                         </table>
                         <input type="hidden" name="subaddreservation" value="1">
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

