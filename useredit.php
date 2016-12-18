<?php
include("include/session.php");
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
			<link rel="stylesheet" href="style/style.css">	
        </head>
        <body>
        <div class="container">
		<div class="wrapper">       
	
            <table class="center"><tr><td>
                        <?php
						include("include/header.php");
						?>		
                    </td></tr><tr><td> 
                        <?php
                        /**
                         * User has submitted form without errors and user's
                         * account has been edited successfully.
                         */
                        include("include/meniu.php");
                        ?>
                        <table><tr><td>
                                    Atgal į <a href="index.php">Pradžia</a>
                                </td></tr></table>               
                        <br> 
                        <?php                        
                            echo "<div align=\"center\">";
                            if ($form->num_errors > 0) {
                                echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                            } else {
                                echo "";
                            }
                            ?>
                            <table>
                                <tr><td>
                                        <form action="process.php" style="text-align:left;" method="POST">
                                        <?php 
                                        echo $form->error("email");
                                        echo $form->error("newpass"); 
                                        echo $form->error("curpass"); ?>
                                        <table class="table table-bordered">
			                            <tr><td>
			                            <p>Dabartinis slaptažodis:</p>
			                            </td><td>
			                            <input type="password" name="curpass" maxlength="30" size="25" value="">
			                            </td></tr>
			                            <tr><td>
			                            <p>Naujas slaptažodis:</p></td>
			                            <td><input type="password" name="newpass" maxlength="30" size="25" value="">
			                            </td></tr>
			                            <tr><td><p>E-paštas:<br></p></td><td>
			                            <input type="text" name="email" maxlength="30" size="25" value="<?php  echo $session->userinfo['email']; ?>"> 
			                            </td></tr>
			                            <tr><td>
			                            <p>Vardas:</p>
			                            </td><td>
			                            <input type="text" name="vardas" maxlength="30" size="25" value="<?php echo $session->userinfo['Vardas']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Pavardė:<br>
			                            </td><td>
			                            <input type="text" name="pavarde" maxlength="30" size="25" value="<?php echo $session->userinfo['Pavarde']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Universitetas:<br>
			                            </td><td>
			                            <input type="text" name="university" maxlength="30" size="25" value="<?php echo $session->userinfo['university']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Kursas:<br>
			                            </td><td>
			                            <input type="text" name="course" maxlength="30" size="25" value="<?php echo $session->userinfo['course']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Fakultetas:<br>
			                            </td><td>
			                            <input type="text" name="faculty" maxlength="30" size="25" value="<?php echo $session->userinfo['faculty']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Telefonas:<br>
			                            </td><td>
			                            <input type="text" name="phone" maxlength="30" size="25" value="<?php echo $session->userinfo['phone']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Adresas:<br>
			                            </td><td>
			                            <input type="text" name="address" maxlength="30" size="25" value="<?php echo $session->userinfo['address']; ?>"><br>
			                            </td></tr>
			                            <tr><td>
			                            <p>Miestas:<br>
			                            </td><td>
			                            <input type="text" name="city" maxlength="30" size="25" value="<?php echo $session->userinfo['city']; ?>"><br>
			                            </td></tr>
			                            </table>
                                            <input type="hidden" name="subedit" value="1">
                                            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Atnaujinti">
                                        </form>
                                    </td></tr>
                            </table>

                            <?php
                            echo "</div>";
                        
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
    header("Location: index.php");
}
?>