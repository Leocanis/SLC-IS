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
                                <?php
                                if(isset($_SESSION['invpav']))
                                {
                                $_SESSION['oldinvpav'] = $_SESSION['invpav'];
                                $q = "select * from inventorius where pavadinimas = '".$_SESSION['invpav']."'";
                                $result = $database->query($q);
                                $invlist = mysqli_fetch_array($result);
                                unset($_SESSION['invpav']);
                                
                                ?>
                                
                         <form action="inventoriusprocess.php" style="text-align:left;" method="POST">
                         <table class="table table-bordered">
                         <tr><td>
                         Pavadinimas:
                         </td><td>
                         <input name="invName" class="inv_input" type="text" size="50" required value="<?php echo $invlist['pavadinimas']; ?>"/>
                         </td></tr>
                         <tr><td>
                         Vieta: 
                         </td><td>
                         <input name="invPlace" class="inv_input" type="text" size="50" value="<?php echo $invlist['vieta']; ?>"/>
                         </td></tr>
                         <tr><td>
                         Būsena:
                         </td><td>
                         <input name="invBusena" class="inv_input" type="text" size="50" value="<?php echo $invlist['busena']; ?>"/>
                         </td></tr>
                         <tr><td>
                         Padėtis:
                         </td><td>
                         <input name="invPadetis" class="inv_input" type="text" size="50" value="<?php echo $invlist['padetis']; ?>"/>
                         </td></tr>
                         <tr><td>
                         Pastabos:
                         </td><td>
                         <textarea name="invPastabos"><?php echo $invlist['pastabos']; ?></textarea>
                         </td></tr> 
                         <tr><td>
                         Ar mobilus:
                         </td><td>
                         <input name="invMobilus" type="checkbox" <?php if($invlist['ar_mobilus'] == 1) {echo "checked";} else {echo "unchecked";} ?>/>
                         </td></tr> 
                         </table>
                         <input type="hidden" name="editinventor" value="1">
                         <input class="btn btn-lg btn-primary btn-block" type="submit" value="Atnaujinti">                                
                                </form>
                                </td></tr>
                                 </table>
            </div>
            </div>
        </body>
    </html>
    
    <?php
                                }
                                else
                                {
                                	header("Location: ../index.php");
                                }
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: ../index.php");
}
?>