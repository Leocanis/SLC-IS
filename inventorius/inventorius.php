<?php
include("../include/session.php");
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
            <table class="center"><tr><td>
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
                        <tr><td>
                        <?php
                        if(isset($_SESSION['newinv']))
                        {
                        	if($_SESSION['newinv'])
                        	{
                        		echo "Naujas inventorius sėkmingai pridėtas!";
                        		
                        	}
                        	else
                        	{
                        		echo "Nepavyko prideti naujo invetoriaus";
                        	}
                        	unset($_SESSION['newinv']);
                        }
                        else 
                        {
                        
                        ?>
                        <form action="inventoriusprocess.php" style="text-align:left;" method="POST">
                        <h2><center>Naujas inventorius</center></h2>
                        
                        <table class="table table-bordered">
                         <tr><td>
                         Pavadinimas:
                         </td><td>
                         <input name="invName" class="inv_input" type="text" size="50" required value=""/>
                         </td></tr>
                         <tr><td>
                         Vieta: 
                         </td><td>
                         <input name="invPlace" class="inv_input" type="text" size="50" value=""/>
                         </td></tr>
                         <tr><td>
                         Būsena:
                         </td><td>
                         <input name="invBusena" class="inv_input" type="text" size="50" value=""/>
                         </td></tr>
                         <tr><td>
                         Padėtis:
                         </td><td>
                         <input name="invPadetis" class="inv_input" type="text" size="50" value=""/>
                         </td></tr>
                         <tr><td>
                         Pastabos:
                         </td><td>
                         <textarea name="invPastabos"></textarea>
                         </td></tr> 
                         <tr><td>
                         Ar mobilus:
                         </td><td>
                         <input name="invMobilus" type="checkbox"/>
                         </td></tr> 
                         </table>
                         <input type="hidden" name="subaddinventor" value="1">
                         <input class="btn btn-lg btn-primary btn-block" type="submit" value="Pridėti">                        
                        </form>
                        </td></tr>              
                <tr><td>
                        <?php
                        }
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