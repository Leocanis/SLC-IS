<?php
include("../include/session.php");

function show_form() {
    global $session;
    global $database;
    $naudotojoID = $database->selectUserID($session->username);
    if(isset($_POST["dalid"])) {
        $result = $database->query("update renginiu_dalyviai set patvirtinimas = 1 where naudotojo_id = ".$naudotojoID['id']." and renginio_id = ".$_POST["rngid"]);
        echo 'Registracija sėkminga <a href="renginys.php?rngid='.$_POST["rngid"].'">Atgal</a>';
        $_POST = array();
    } else {
        if(isset($_GET["dalid"])) {
            $result = $database->query("select rd.papildoma_info, n.vardas, n.pavarde, rd.renginio_id from renginiu_dalyviai rd, naudotojas n where rd.naudotojo_id = n.id and rd.naudotojo_id = ".$naudotojoID['id']." and rd.patvirtinimas = 0");
            if($dalyvis = $result->fetch_assoc()) {
                echo '<form method="post">';
                echo '<input type="hidden" name="rngid" value="'.$dalyvis["renginio_id"].'">';
                echo '<input type="hidden" name="dalid" value="'.$_GET["dalid"].'">';
                echo '<div class="form-group"><label for="vardas">Vardas</label><input disabled class="form-control" id="vardas" name="vardas" type="text" value="'.$dalyvis["vardas"].'"></div>';
                echo '<div class="form-group"><label for="pavarde">Pavardė</label><input disabled class="form-control" id="pavarde" name="pavarde" type="text" value="'.$dalyvis["pavarde"].'"></div>';
                echo '<div class="form-group"><label for="papildoma_info">Papildoma informacija</label><textarea disabled class="form-control" rows="10" id="papildoma_info" name="papildoma_info">'.$dalyvis["papildoma_info"].'</textarea></div>';
                echo '<button type="submit" class="btn btn-default">Patvirtinti</button></form>';
            } else {
                echo 'Dalyvis negalima patvirtinti';
            }
        } else {
            echo 'Klaida!';
        }
    }
}


if ($session->logged_in && ($session->isManager() || $session->isAdmin())) {
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
            <table class="center" >
                <tr><td>
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
                        <br> 
                        
                        <?php 
                        show_form();
                        ?>
                         
                        <br>  
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
    //Jei vartotojas neprisijungęs, užkraunamas pradinis puslapis  
} else {
    header("Location: ../index.php");
}
?>