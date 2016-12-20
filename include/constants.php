<?php
/**
 * Constants.php
 *
 * This file is intended to group all constants to
 * make it easier for the site administrator to tweak
 * the login script.
 *
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */

define ( "DB_SERVER", "db.if.ktu.lt" );
define ( "DB_USER", "tomkuz" );
define ( "DB_PASS", "EeNgeihoh9uphe8t" );
define ( "DB_NAME", "tomkuz" );

//define ( "DB_SERVER", "localhost" );
//define ( "DB_USER", "stud" );
//define ( "DB_PASS", "stud" );
//define ( "DB_NAME", "slc" );

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
define ( "TBL_USERS", "naudotojas" );
define ( "TBL_LOGIN_HISTORY", "prisijungimo_istorija" );
define ( "TBL_STATUS_HISTORY", "busenu_istorija" );
define ( "TBL_PASSWORD_HISTORY", "slaptazodzio_istorija" );
define ( "TBL_INVENTORY", "inventorius");
define ( "TBL_RESERVATION", "Rezervacija");
define ( "TBL_RADINYS", "radiniai");


/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level.
 * Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
define ( "ADMIN_NAME", "Administratorius" );
define ( "MANAGER_NAME", "Būdėtojas" );
define ( "USER_NAME", "Lankytojas" );
define ( "GUEST_NAME", "Svečias" );
define ( "ADMIN_LEVEL", 9 );
define ( "MANAGER_LEVEL", 5 );
define ( "USER_LEVEL", 1 );
define ( "GUEST_LEVEL", 0 );

/**
 * This boolean constant controls whether or
 * not the script keeps track of active users
 * and active guests who are visiting the site.
 */
define ( "TRACK_VISITORS", false );

/**
 * Timeout Constants - these constants refer to
 * the maximum amount of time (in minutes) after
 * their last page fresh that a user and guest
 * are still considered active visitors.
 */
define ( "USER_TIMEOUT", 10 );
define ( "GUEST_TIMEOUT", 5 );

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website.
 * If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
define ( "COOKIE_EXPIRE", 60 * 60 * 24 * 100 ); // 100 days by default
define ( "COOKIE_PATH", "/" ); // Avaible in whole domain

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define ( "EMAIL_FROM_NAME", "Demo" );
define ( "EMAIL_FROM_ADDR", "demo@ktu.lt" );
define ( "EMAIL_WELCOME", false );

/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
define ( "ALL_LOWERCASE", false );
?>
