<?php

include("constants.php");

class MySQLDB {

    var $connection;         //The MySQL database connection
    var $num_active_users;   //Number of active users viewing site
    var $num_active_guests;  //Number of active guests viewing site
    var $num_members;        //Number of signed-up users

    /* Note: call getNumMembers() to access $num_members! */

    /* Class constructor */

    function MySQLDB() {
        /* Make connection to database */
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
                or die(mysql_error() . '<br><h1>Faile include/constants.php suveskite savo MySQLDB duomenis.</h1>');

        /**
         * Only query database to find out number of members
         * when getNumMembers() is called for the first time,
         * until then, default value set.
         */
        $this->num_members = -1;

        if (TRACK_VISITORS) {
            /* Calculate number of users at site */
            $this->calcNumActiveUsers();

            /* Calculate number of guests at site */
            $this->calcNumActiveGuests();
        }
    }

    /**
     * confirmUserPass - Checks whether or not the given
     * username is in the database, if so it checks if the
     * given password is the same password in the database
     * for that user. If the user doesn't exist or if the
     * passwords don't match up, it returns an error code
     * (1 or 2). On success it returns 0.
     */
    function confirmUserPass($username, $password) {
        /* Add slashes if necessary (for query) */
        if (!get_magic_quotes_gpc()) {
            $username = addslashes($username);
        }

        /* Verify that user is in database */
        $q = "SELECT password FROM " . TBL_USERS . " WHERE username = '$username'";
        $result = mysqli_query($this->connection, $q);
        if (!$result || (mysqli_num_rows($result) < 1)) {
            return 1; //Indicates username failure
        }

        /* Retrieve password from result, strip slashes */
        $dbarray = mysqli_fetch_array($result);
        $dbarray['password'] = stripslashes($dbarray['password']);
        $password = stripslashes($password);

        /* Validate that password is correct */
        if ($password === $dbarray['password']) {
            return 0; //Success! Username and password confirmed
        } else {
            return 2; //Indicates password failure
        }
    }

    /**
     * confirmUserID - Checks whether or not the given
     * username is in the database, if so it checks if the
     * given userid is the same userid in the database
     * for that user. If the user doesn't exist or if the
     * userids don't match up, it returns an error code
     * (1 or 2). On success it returns 0.
     */
    function confirmUserID($username, $userid) {
        /* Add slashes if necessary (for query) */
    	return 0;
        if (!get_magic_quotes_gpc()) {
            $username = addslashes($username);
        }

        /* Verify that user is in database */
        $q = "SELECT userid FROM " . TBL_USERS . " WHERE username = '$username'";
        $result = mysqli_query($this->connection, $q);
        if (!$result || (mysqli_num_rows($result) < 1)) {
            return 1; //Indicates username failure
        }

        /* Retrieve userid from result, strip slashes */
        $dbarray = mysqli_fetch_array($result);
        $dbarray['userid'] = stripslashes($dbarray['userid']);
        $userid = stripslashes($userid);

        /* Validate that userid is correct */
       // if ($userid == $dbarray['userid']) {
            return 0; //Success! Username and userid confirmed
       // } else {
       //     return 2; //Indicates userid invalid
       // }
        
    }
    
    function addNewInventory($itemArray)
    {
    	$q = "INSERT into " . TBL_INVENTORY . " (pavadinimas, vieta, busena, padetis, pastabos, ar_mobilus) values " .
    	"('".$itemArray['invName']."', '".$itemArray['invPlace']."', '".$itemArray['invBusena']."', '".$itemArray['invPadetis']."', '".$itemArray['invPastabos']."', ".$itemArray['invMobilus'].")";
    	
    	return mysqli_query($this->connection, $q);
    }
    
    function editInventory($itemArray)
    {
    	$q = "UPDATE " . TBL_INVENTORY . " SET pavadinimas = '".$itemArray['invName']."', vieta = '".$itemArray['invPlace']."', busena = '".$itemArray['invBusena']."',". 
        "padetis = '".$itemArray['invPadetis']."', pastabos = '".$itemArray['invPastabos']."', ar_mobilus = ".$itemArray['invMobilus']." where pavadinimas = '".$_SESSION['oldinvpav']."'";
    			
    	
    	return mysqli_query($this->connection, $q);
    }
    
    function selectInvID($pavadinimas) {
    	$q = "select id from " . TBL_INVENTORY . " WHERE pavadinimas = '$pavadinimas'";
    	$result = mysqli_query($this->connection, $q);
    	return mysqli_fetch_array($result);
    }
    
    function addRadinys($itemArray)
    {
    	$q = "INSERT into " . TBL_RADINYS . " (naudotojo_id, kur_rasta, name, komentaras) values " .
    	"('".$itemArray['userID']."', '".$itemArray['radplace']."', '".$itemArray['radname']."', '".$itemArray['radkom']."')";
    	
    	return mysqli_query($this->connection, $q);
    }
    
    function addImone($itemArray)
    {
    	$q = "INSERT into " . TBL_COMPANY . " (pavadinimas, imones_kodas, imones_adresas, imones_miestas, imones_kontaktinis_email, imones_kontaktinis_telnr, ".
    	"imones_kontaktinis_asmuo, banko_saskaita) values (" .
    	"'".$itemArray['compname']. "', ".
    	"'".$itemArray['compcode']. "', ".
    	"'".$itemArray['compadd']. "', ".
    	"'".$itemArray['compcity']. "', ".
    	"'".$itemArray['compper']. "', ".
    	"'".$itemArray['compphone']. "', ".
    	"'".$itemArray['compemail']. "', ".
    	"'".$itemArray['compbac']."')";
    	 
    	return mysqli_query($this->connection, $q);
    }
    
    function addReservationImone($itemArray)
    {
    	$q = "INSERT into " . TBL_RESERVATIONCOMPANY . " (imones_id, data, pagalbininkai) values (" .
    			"'".$itemArray['compid']. "', ".
    			"'".$itemArray['resdate']. "', ".
    			"".$itemArray['respagsk'].")";
    
    	return mysqli_query($this->connection, $q);
    }
    
    function remRadinys($radid)
    {
    	$q = "DELETE FROM " . TBL_RADINYS . " WHERE id = ".$radid;
    	return mysqli_query($this->connection, $q);
    }
    
    function remReservation($resid)
    {
    	$q = "DELETE FROM " . TBL_RESERVATION . " WHERE id = ".$resid;
    	return mysqli_query($this->connection, $q);
    }
    
    function addReservation($itemArray)
    {
    	$q = "INSERT into " . TBL_RESERVATION . " (naudotojo_id, inventoriaus_id, galioja_nuo, galioja_iki, komentaras, zmoniu_kieks) values " .
    			"('".$itemArray['userID']."', '".$itemArray['invID']."', '".$itemArray['invNuo']."', '".$itemArray['invIki'].
    			"', '".$itemArray['invKom']."', ".$itemArray['invKiekis'].")";
    	 
       
    	return mysqli_query($this->connection, $q);
    }
    
    function checkReservation($itemArray)
    {
    	$q = "select id from  " . TBL_RESERVATION . " where galioja_iki > '".
    	$itemArray['invNuo'] . "' and galioja_nuo < '" .$itemArray['invIki'] ."' and inventoriaus_id = " . $itemArray['invID'];
    	
    	$_SESSION['query1'] = $q;
    	$result = mysqli_query($this->connection, $q);
    	return mysqli_num_rows($result);
    }

    /**
     * usernameTaken - Returns true if the username has
     * been taken by another user, false otherwise.
     */
    function usernameTaken($username) {
        if (!get_magic_quotes_gpc()) {
            $username = addslashes($username);
        }
        $q = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username'";
        $result = mysqli_query($this->connection, $q);
        return (mysqli_num_rows($result) > 0);
    }

    /**
     * usernameBanned - Returns true if the username has
     * been banned by the administrator.
     */
    function usernameBanned($username) {
        if (!get_magic_quotes_gpc()) {
            $username = addslashes($username);
        }
        $q = "SELECT username FROM " . TBL_USERS . " WHERE username = '$username' and busena = 'B'";
        $result = mysqli_query($this->connection, $q);
        return (mysqli_num_rows($result) > 0);
    }

    /**
     * addNewUser - Inserts the given (username, password, email)
     * info into the database. Appropriate user level is set.
     * Returns true on success, false otherwise.
     */
    function addNewUser($username, $password, $email, $level) {        
        
        $q = "INSERT INTO " . TBL_USERS . " (username, password, userlevel, email, created) VALUES ('$username', '$password', $level, '$email', now())";
        $_SESSION['query'] = $q;
        return mysqli_query($this->connection, $q);
    }

    /**
     * updateUserField - Updates a field, specified by the field
     * parameter, in the user's row of the database.
     */
    function updateUserField($username, $field, $value) {
        $q = "UPDATE " . TBL_USERS . " SET " . $field . " = '$value' WHERE username = '$username'";
        return mysqli_query($this->connection, $q);
    }
    
    function selectUserID($username) {
    	$q = "select id from " . TBL_USERS . " WHERE username = '$username'";
    	$result = mysqli_query($this->connection, $q);
    	return mysqli_fetch_array($result);
    }
    
    function selectTimeNow() {
    	$q = "select now() from dual";
    	$result = mysqli_query($this->connection, $q); 
    	$time = mysqli_fetch_array($result);
    	return $time['now()'];
    }
    
    function setLoginHistory($id, $ip) {
    	$q = "insert into " . TBL_LOGIN_HISTORY . " (naudotojo_id, ip, data) values (". $id .", '". $ip ."', now()) ";
    	return mysqli_query($this->connection, $q);
    }
    
    function setStatusHistory($id, $busena) {
    	$q = "insert into " . TBL_STATUS_HISTORY . " (naudotojo_id, busena, data) values (". $id .", '". $busena ."', now()) ";
    	return mysqli_query($this->connection, $q);
    }
    
    function setPasswordHistory($id, $password) {
    	$q = "insert into " . TBL_PASSWORD_HISTORY . " (naudotojo_id, password, data) values (". $id .", '". $password ."', now()) ";
    	return mysqli_query($this->connection, $q);
    }
    

    /**
     * getUserInfo - Returns the result array from a mysql
     * query asking for all information stored regarding
     * the given username. If query fails, NULL is returned.
     */
    function getUserInfo($username) {
        $q = "SELECT * FROM " . TBL_USERS . " WHERE username = '$username' ";
        $result = mysqli_query($this->connection, $q);
        /* Error occurred, return given name by default */
        if (!$result || (mysqli_num_rows($result) < 1)) {
            return NULL;
        }
        /* Return result array */
        $dbarray = mysqli_fetch_array($result);
        return $dbarray;
    }

    /**
     * getNumMembers - Returns the number of signed-up users
     * of the website, banned members not included. The first
     * time the function is called on page load, the database
     * is queried, on subsequent calls, the stored result
     * is returned. This is to improve efficiency, effectively
     * not querying the database when no call is made.
     */
    function getNumMembers() {
        if ($this->num_members < 0) {
            $q = "SELECT * FROM " . TBL_USERS;
            $result = mysqli_query($this->connection, $q);
            $this->num_members = mysqli_num_rows($result);
        }
        return $this->num_members;
    }

    /**
     * calcNumActiveUsers - Finds out how many active users
     * are viewing site and sets class variable accordingly.
     */
    function calcNumActiveUsers() {
        /* Calculate number of users at site */
        $q = "SELECT * FROM " . TBL_ACTIVE_USERS;
        $result = mysqli_query($this->connection, $q);
        $this->num_active_users = mysqli_num_rows($result);
    }

    /**
     * calcNumActiveGuests - Finds out how many active guests
     * are viewing site and sets class variable accordingly.
     */
    function calcNumActiveGuests() {
        /* Calculate number of guests at site */
        $q = "SELECT * FROM " . TBL_ACTIVE_GUESTS;
        $result = mysqli_query($this->connection, $q);
        $this->num_active_guests = mysqli_num_rows($result);
    }

    /**
     * addActiveUser - Updates username's last active timestamp
     * in the database, and also adds him to the table of
     * active users, or updates timestamp if already there.
     */
    function addActiveUser($username, $time) {
        $q = "UPDATE " . TBL_USERS . " SET timestamp = '$time' WHERE username = '$username'";
        mysqli_query($this->connection, $q);

        if (!TRACK_VISITORS)
            return;
        $q = "REPLACE INTO " . TBL_ACTIVE_USERS . " VALUES ('$username', '$time')";
        mysqli_query($this->connection, $q);
        $this->calcNumActiveUsers();
    }

    /* addActiveGuest - Adds guest to active guests table */

    function addActiveGuest($ip, $time) {
        if (!TRACK_VISITORS)
            return;
        $q = "REPLACE INTO " . TBL_ACTIVE_GUESTS . " VALUES ('$ip', '$time')";
        mysqli_query($this->connection, $q);
        $this->calcNumActiveGuests();
    }

    /* These functions are self explanatory, no need for comments */

    /* removeActiveUser */

    function removeActiveUser($username) {
        if (!TRACK_VISITORS)
            return;
        $q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE username = '$username'";
        mysqli_query($this->connection, $q);
        $this->calcNumActiveUsers();
    }

    /* removeActiveGuest */

    function removeActiveGuest($ip) {
        if (!TRACK_VISITORS)
            return;
        $q = "DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE ip = '$ip'";
        mysqli_query($this->connection, $q);
        $this->calcNumActiveGuests();
    }

    /* removeInactiveUsers */

    function removeInactiveUsers() {
        if (!TRACK_VISITORS)
            return;
        $timeout = time() - USER_TIMEOUT * 60;
        $q = "DELETE FROM " . TBL_ACTIVE_USERS . " WHERE timestamp < $timeout";
        mysqli_query($this->connection, $q);
        $this->calcNumActiveUsers();
    }

    /* removeInactiveGuests */

    function removeInactiveGuests() {
        if (!TRACK_VISITORS)
            return;
        $timeout = time() - GUEST_TIMEOUT * 60;
        $q = "DELETE FROM " . TBL_ACTIVE_GUESTS . " WHERE timestamp < $timeout";
        mysqli_query($this->connection, $q);
        $this->calcNumActiveGuests();
    }

    /**
     * query - Performs the given query on the database and
     * returns the result, which may be false, true or a
     * resource identifier.
     */
    function query($query) {
        return mysqli_query($this->connection, $query);
    }

}

/* Create database connection */
$database = new MySQLDB;
?>