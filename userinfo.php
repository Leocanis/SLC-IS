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
                <table>
                    <tr><td>
                            Atgal į <a href="index.php">Pradžia</a>
                        </td></tr></table>               
                <br> 
                <?php
                /* Requested Username error checking */
                if (isset($session->username)) {
                    $req_user = trim($session->username);
                } else {
                    $req_user = null;
                }
                if (!$req_user || strlen($req_user) == 0 ||
                        !preg_match("/^([0-9a-zA-Z])+$/", $req_user) ||
                        !$database->usernameTaken($req_user)) {
                    echo "<br><br>";
                    die("Vartotojas nėra užsiregistravęs");
                }

                /* Display requested user information */
                $req_user_info = $database->getUserInfo($req_user);

                echo "<br><table class=\"table table-bordered\">"
				. "<tr><td><b>Vartotojo vardas: </b></td>"
                . "<td>" . $req_user_info['username'] . "</td></tr>"
                . "<tr><td><b>Vardas:</b></td>"
                . "<td>" . $req_user_info['Vardas'] . "</td></tr>" 
                . "<tr><td><b>Pavarė</b></td>"
                . "<td>" . $req_user_info['Pavarde'] . "</td></tr>" 
                . "<tr><td><b>E-paštas:</b></td>"
                . "<td>" . $req_user_info['email'] . "</td></tr>" 
                . "<tr><td><b>Universitetas:</b></td>"
                . "<td>" . $req_user_info['university'] . "</td></tr>"
                . "<tr><td><b>Kursas:</b></td>"
                . "<td>" . $req_user_info['course'] . "</td></tr>" 
                . "<tr><td><b>Fakultetas:</b></td>"
                . "<td>" . $req_user_info['faculty'] . "</td></tr>" 
                . "<tr><td><b>Telefonas:</b></td>"
                . "<td>" . $req_user_info['phone'] . "</td></tr>" 
                . "<tr><td><b>Adresas:</b></td>"
                . "<td>" . $req_user_info['address'] . "</td></tr>" 
                . "<tr><td><b>Miestas:</b></td>"
                . "<td>" . $req_user_info['city'] . "</td></tr>" 
                . "<tr><td><b>Sukūrimo data:</b></td>"
                . "<td>" . $req_user_info['created'] . "</td></tr>" 
                		."</table><br>";
                echo "<a href=\"" . $path . "useredit.php\">Redaguoti paskyrą</a>";
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