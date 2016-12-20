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
                       
                        	                        
                        ?>
                        
                        <h2><center>Naujas radinys</center></h2>
                        
                        <table class="table table-bordered">
                         <tr><td>
                         Pavadinimas: 
                         </td><td>
                         <input name="radname" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Radimo vieta:
                         </td><td>
                         <input name="radplace" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Komentaras:
                         </td><td>
                         <textarea name="radkom" class="inv_input"></textarea>
                         </td></tr>                         
                         </table>
                         <input type="hidden" name="subaddrad" value="1">
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
