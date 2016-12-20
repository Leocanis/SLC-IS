<?php
include("../include/session.php");
//Jei prisijunges Administratorius ar Valdytojas vykdomas operacija3 kodas
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
                       
						if(isset($_SESSION['newcomp']))    
						{
							echo "Sėkmingai pridėta nauja įmonė!";
							unset($_SESSION['newcomp']);
						}
                        	                        
                        ?>
                        
                        <h2><center>Nauja įmonė</center></h2>
                        
                        <table class="table table-bordered">
                         <tr><td>
                         Pavadinimas: 
                         </td><td>
                         <input name="compname" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Įmonės kodas: 
                         </td><td>
                         <input name="compcode" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Įmonės adresas: 
                         </td><td>
                         <input name="compadd" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Įmonės miestas: 
                         </td><td>
                         <input name="compcity" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Kontaktinis asmuo: 
                         </td><td>
                         <input name="compper" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Kontaktinis telefono numeris: 
                         </td><td>
                         <input name="compphone" class="inv_input" type="text" required value=""/>
                         </td></tr>
                         <tr><td>
                         Kontaktinis el. paštas: 
                         </td><td>
                         <input name="compemail" class="inv_input" type="email" required value=""/>
                         </td></tr>
                         <tr><td>
                         Banko sąskaita: 
                         </td><td>
                         <input name="compbac" class="inv_input" type="text" value=""/>
                         </td></tr>                        
                         </table>
                         <input type="hidden" name="subaddcompany" value="1">
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
