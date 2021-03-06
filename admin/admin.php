<?php
include("../include/session.php");


//Iš pradžių aprašomos funkcijos, po to jos naudojamos.

/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
function displayUsers() {
    global $database;
    $q = "SELECT * "
            . "FROM " . TBL_USERS . " ORDER BY userlevel DESC,username";
    $result = $database->query($q);
    /* Error occurred, return given name by default */
    $num_rows = mysqli_num_rows($result);
    if (!$result || ($num_rows < 0)) {
        echo "Error displaying info";
        return;
    }
    if ($num_rows == 0) {
        echo "Lentelė tuščia.";
        return;
    }    
    /* Display table contents */
    echo "<table class=\"table table-hover\">";
    echo "<thead><tr><th>Vartotojo vardas</th>
    		<th>Lygis</th>
    		<th>E-paštas</th>
    		<th>Paskutinį kartą aktyvus</th>
    		<th>Veiksmai</th></tr></thead><tbody>";
    for ($i = 0; $i < $num_rows; $i++) {
        $uid =
        $uname = mysqli_result($result, $i, "username");
        $ulevel = mysqli_result($result, $i, "userlevel");
        $last_login = mysqli_result($result, $i, "last_login");
        $ulevelname = '';
        switch ($ulevel)
        {
            case ADMIN_LEVEL:
                $ulevelname = ADMIN_NAME;
                break;
            case MANAGER_LEVEL:
                $ulevelname = MANAGER_NAME;
                break;
            case USER_LEVEL:
                $ulevelname = USER_NAME;
                break;
            default :
                $ulevelname = 'Neegzistuojantis tipas';
        }
        
        $email = mysqli_result($result, $i, "email");
        //$time = date("Y-m-d G:i", mysqli_result($result, $i, "timestamp"));
        $ulevelchange = '<form action="adminprocess.php" method="POST">
                        
                                <input type="hidden" name="upduser" value="'.$uname.'">
                                <input type="hidden" name="subupdlevel" value="1">
                                <select name="updlevel" onChange="alert(\'Pakeistas vartotojo lygis!\');submit();">
                                    <option value="'.USER_LEVEL.'" '.($ulevel == USER_LEVEL? 'selected':'').'>'.USER_NAME.'</option>
                                    <option value="'.MANAGER_LEVEL.'" '.($ulevel == MANAGER_LEVEL? 'selected':'').'>'.MANAGER_NAME.'</option>
                                    <option value="'.ADMIN_LEVEL.'" '.($ulevel == ADMIN_LEVEL? 'selected':'').'>'.ADMIN_NAME.'</option>
                                </select>
                                

                    </form>';
        echo "<tr>
        <td>$uname</td>
        <td>$ulevelchange</td>
        <td>$email</td>
        <td>$last_login</td>
        <td><a href='AdminProcess.php?b=1&banuser=$uname' onclick='return confirm(\"Ar tikrai norite blokuoti?\");'"; 
        if(mysqli_result($result, $i, "busena") == 'B' || mysqli_result($result, $i, "busena") == 'D') { echo "class=\"not-active\""; } 
        echo  ">Blokuoti</a> | <a href='AdminProcess.php?d=1&deluser=$uname' onclick='return confirm(\"Ar tikrai norite trinti?\");'";
        if(mysqli_result($result, $i, "busena") == 'D') { echo "class=\"not-active\""; }
        echo ">Trinti</a></td>
        </tr>\n";
    }
    echo "</tbody></table><br>\n";
}

function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
} 
/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayBannedUsers() {
    global $database;
    $q = "SELECT username,last_login "
            . "FROM " . TBL_USERS . " where busena = 'B' ORDER BY username";
    $result = $database->query($q);
    /* Error occurred, return given name by default */
    $num_rows = mysqli_num_rows($result);
    if (!$result || ($num_rows < 0)) {
        echo "Error displaying info";
        return;
    }
    if ($num_rows == 0) {
        echo "Lentelė tuščia.";
        return;
    }
    /* Display table contents */
    echo "<table class=\"table table-hover\">\n";
    echo "<tr><td><b>Vartotojo vardas</b></td><td><b>Blokavimo laikas</b></td><td><b>Veiksmai</b></td></tr>\n";
    for ($i = 0; $i < $num_rows; $i++) {
        $uname = mysqli_result($result, $i, "username");
        $time = mysqli_result($result, $i, "last_login");
        echo "<tr><td>$uname</td>
        <td>$time</td>
        <td><a href='AdminProcess.php?ub=1&unbanuser=$uname' onclick='return confirm(\"Ar tikrai norite atblokuoti?\");'>Atblokuoti</a> | <a href='AdminProcess.php?db=1&delbanuser=$uname' onclick='return confirm(\"Ar tikrai norite Šalinti?\");'>Šalinti</a></td></tr>\n";
    }
    echo "</table><br>\n";
}

function displayDeletedUsers() {
	global $database;
	$q = "SELECT username,last_login "
			. "FROM " . TBL_USERS . " where busena = 'D' ORDER BY username";
			$result = $database->query($q);
			/* Error occurred, return given name by default */
			$num_rows = mysqli_num_rows($result);
			if (!$result || ($num_rows < 0)) {
				echo "Error displaying info";
				return;
			}
			if ($num_rows == 0) {
				echo "Lentelė tuščia.";
				return;
			}
			/* Display table contents */
			echo "<table class=\"table table-hover\">\n";
			echo "<tr><td><b>Vartotojo vardas</b></td><td><b>Blokavimo laikas</b></td><td><b>Veiksmai</b></td></tr>\n";
			for ($i = 0; $i < $num_rows; $i++) {
				$uname = mysqli_result($result, $i, "username");
				$time = mysqli_result($result, $i, "last_login");
				echo "<tr><td>$uname</td>
				<td>$time</td>
				<td><a href='AdminProcess.php?ub=1&unbanuser=$uname' onclick='return confirm(\"Ar tikrai norite atstatyti?\");'>Atstatyti</a></td></tr>\n";
			}
			echo "</table><br>\n";
}

function ViewActiveUsers() {
    global $database;
    if (!defined('TBL_USERS')) {
        die("");
    }
    $q = "SELECT username FROM " . TBL_USERS
            . " ORDER BY last_login DESC,username";
    $result = $database->query($q);
    /* Error occurred, return given name by default */
    $num_rows = mysqli_num_rows($result);
    if (!$result || ($num_rows < 0)) {
        echo "Error displaying info";
    } else if ($num_rows > 0) {
        /* Display active users, with link to their info */
        echo "<br><table border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
        echo "<tr><td><b>Vartotojų vardai</b></td></tr>";
        echo "<tr><td><font size=\"2\">\n";
        for ($i = 0; $i < $num_rows; $i++) {
            $uname = mysqli_result($result, $i, "username");
            if ($i > 0)
                echo ", ";
            echo "<a href=\"../userinfo.php?user=$uname\">$uname</a>";
        }
        echo ".";
        echo "</font></td></tr></table>";
    }
}

if (!$session->isAdmin()) {
    header("Location: ../index.php");
} else { //Jei administratorius
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
                        //Nuoroda į pradžią
                        ?>
                        <table><tr><td>
                                    Atgal į <a href="../index.php">Pradžia</a>
                                </td></tr></table>               
                        <br> 
                        <?php
                        if ($form->num_errors > 0) {
                            echo "<font size=\"4\" color=\"#ff0000\">"
                            . "!*** Error with request, please fix</font><br><br>";
                        }
                        ?>
                        <table class="center">
                            <tr><td>
                            <div class="container">
                                    <?php
                                    /**
                                     * Display Users Table
                                     */
                                    ?>
                                    <h3>Sistemos vartotojai:</h3>
                                    <?php
                                    displayUsers();
                                    ?>
                                    <br>
                                    </div>
                                </td>
                            </tr>
                            <tr><td><hr></td></tr>           
        <tr><td>
                <?php
                /**
                 * Display Banned Users Table
                 */
                ?>
                <h3>Blokuoti vartotojai:</h3>
                <?php
                displayBannedUsers();
                ?>

            </td></tr>
                            <tr><td><hr></td></tr>
                            
           <tr><td><hr></td></tr>           
        <tr><td><h3>Panaikinti naudotojai:</h3>                 
                <?php 
                displayDeletedUsers();
                ?>             
                             
                             </td></tr> 
                             <tr><td><hr></td></tr>
                             
    </table>
    </td></tr>
    <?php
    echo "<tr><td>";
    include("../include/footer.php");
    echo "</td></tr>";
    ?>
    </table>
    </div>
    </div>       
    </body>
    </html>
    <?php
}
?>