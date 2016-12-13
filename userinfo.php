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
            <table class="center" ><tr><td>
                <?php
				include("include/header.php");
				?>		
            </td></tr><tr><td>  
                <?php
                //Jei vartotojas prisijungęs

                include("include/meniu.php");
                ?>
                <table style="border-width: 2px; border-style: dotted;">
                    <tr><td>
                            Atgal į [<a href="index.php">Pradžia</a>]
                        </td></tr></table>               
                <br> 
                <?php
                /* Requested Username error checking */
                if (isset($_GET['user'])) {
                    $req_user = trim($_GET['user']);
                } else {
                    $req_user = null;
                }
                if (!$req_user || strlen($req_user) == 0 ||
                        !preg_match("/^([0-9a-z])+$/", $req_user) ||
                        !$database->usernameTaken($req_user)) {
                    echo "<br><br>";
                    die("Vartotojas nėra užsiregistravęs");
                }

                /* Display requested user information */
                $req_user_info = $database->getUserInfo($req_user);

                echo "<br><table border=1 style=\"text-align:left;\" cellspacing=\"0\" cellpadding=\"3\"><tr><td><b>Vartotojo vardas: </b></td>"
                . "<td>" . $req_user_info['username'] . "</td></tr>"
                . "<tr><td><b>E-paštas:</b></td>"
                . "<td>" . $req_user_info['email'] . "</td></tr></table><br>";
                //Jei vartotojas neprisijungęs, rodoma prisijungimo forma
                //Jei atsiranda klaidų, rodomi pranešimai.
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