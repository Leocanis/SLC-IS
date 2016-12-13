<?php
include("include/session.php");
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
<div class = "container">
	<div class="wrapper">	
        <table class="center">
		<tr><td>
		<?php
		include("include/header.php");
		?>				
		</td></tr>
		<tr><td>  
            <?php
            //Jei vartotojas prisijungęs
            if ($session->logged_in) {
                include("include/meniu.php");
                ?>
								<div style="text-align: center; color: green">
									<h1>Pradinis sistemos puslapis (index.php).</h1>
								</div>
						<?php
                //Jei vartotojas neprisijungęs, rodoma prisijungimo forma
                //Jei atsiranda klaidų, rodomi pranešimai.
            } else {
                echo "<div align=\"center\">";
                if ($form->num_errors > 0) {
                    echo "<font size=\"3\" color=\"#ff0000\">Klaidų: " . $form->num_errors . "</font>";
                }
                echo "<table width=\"100%\"><tr><td>";
                include("include/loginForm.php");
                echo "</td></tr></table></div><br></td></tr>";
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