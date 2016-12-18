<?php
include("include/session.php");
if (!$session->logged_in) {
    header("Location: index.php");
} else {
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
			<link rel="stylesheet" href="style/style.css">	
		
        </head>
        <body>
         <div class="container">
		 <div class="wrapper"> 
            <table class="center">
            <tr><td>
                        <?php
						include("include/header.php");
						?>	
                    </td></tr>
                    <tr><td>
                    <?php 
				        include ("include/meniu.php");
				        ?>  
                    </td></tr> 
                    <tr><td>
                        <table><tr><td>
                                    Atgal į <a href="index.php">Pradžia</a>
                        </td></tr></table>  
                        </td></tr>
                        <tr><td>             
                        <?php
                        /**
                         * The user has submitted the registration form and the
                         * results have been processed.
                         */ if (isset($_SESSION['regsuccess'])) {
                            /* Registracija sėkminga */
                            if ($_SESSION['regsuccess']) {
                                echo "<p><b>" . $_SESSION['reguname'] . "</b> duomenys buvo sėkmingai įvesti į duomenų bazę. "
                                . "</p><br>";
                            }
                            /* Registracija nesėkminga */ else {
                                echo "<p>Atsiprašome, bet vartotojo <b>" . $_SESSION['reguname'] . $_SESSION['lygis'] . $_SESSION['query'] .   "</b>, "
                                . " registracija nebuvo sėkmingai baigta.<br>Bandykite vėliau.</p>";
                            }
                            unset($_SESSION['regsuccess']);
                            unset($_SESSION['reguname']);
                        }
                        /**
                         * The user has not filled out the registration form yet.
                         * Below is the page with the sign-up form, the names
                         * of the input fields are important and should not
                         * be changed.
                         */ else {
                            ?>
                            <div align="center">
                                <?php
                                if ($form->num_errors > 0) {
                                    echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                                }
                                ?>                            
                                
                                            <form action="process.php" method="POST" class="login">
                                                <?php echo $form->error("user"); ?>
                                                <?php echo $form->error("pass"); ?>     
                                                <?php echo $form->error("email"); ?>     
                                                <center style="font-size:18pt;"><b>Registracija</b></center></td></tr>
                                                <tr><td>
                                                <table class="table table-bordered">
                                                <tr><td>
                                                Vartotojo vardas:
                                                </td><td>
                                                    <input class ="s1" name="user" type="text" size="15"
                                                           value="<?php echo $form->value("user"); ?>"/>
                                                </td></tr>
                                                <tr><td>
                                                Slaptažodis: 
                                                </td><td>
                                                    <input class ="s1" name="pass" type="password" size="15"
                                                           value="<?php echo $form->value("pass"); ?>"/>
                                                </td></tr>
                                                <tr><td>
                                                E-paštas:
                                                </td><td>
                                                    <input class ="s1" name="email" type="text" size="15"
                                                           value="<?php echo $form->value("email"); ?>"/>
                                                </td></tr>                                                
                                                 <tr><td>
                                                Lygis:
                                                </td><td>                                                    
                                                    <select name="level">
                                                    <?php if($session->isAdmin()) { 
													  echo "<option value=\"9\">Administratorius</option>";
													  echo "<option value=\"5\">Budėtojas</option>";
                                                    }
													  ?>
													  <option value="1">Lankytojas</option>
													</select>     
                                                      
                                                </td></tr>
                                                </table> 
                                                <p class="center_align">                                                
                                                    <input type="hidden" name="subjoin" value="1">
                                                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Registruotis">                                                    
                                                </p>                                               
                                            </form>
                                        
                            </div>
                            <?php
                        }
                        echo "<tr><td>";
                        include("include/footer.php");
                        echo "</td></tr>";
                        ?>
                    </td></tr>
            </table>  
            </div>
            </div>         
        </body>
    </html>
    <?php
}
?>
