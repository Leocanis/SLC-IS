<?php

include("../include/session.php");

class Process {
	
	function Process() {
		global $session;
		/* User submitted login form */
		
		if (isset($_POST['subaddinventor'])) {
			$this->procAddNewInventor();
		}
		
		else if(isset($_GET['e']))
		{
			$this->procToEditInventor();
		}
		
		else if(isset($_GET['d']))
		{
			$this->procDeleteInventor();
		}
		
		else if(isset($_POST['editinventor']))
		{
			$this->procEditInventor();
		}		
		else if(isset($_POST['subaddreservation']))
		{
			$this->procAddReservation();
		}
		
		/**
		 * Should not get here, which means user is viewing this page
		 * by mistake and therefore is redirected.
		 */ else {
		 header("Location: index.php");
		}
	}
	
	function procAddNewInventor()
	{
		global $session, $form;
		 
		$itemArray = array();
		 
		$itemArray['invName'] = $_POST['invName'];
		$itemArray['invPlace'] = $_POST['invNuo'];
		$itemArray['invBusena'] = $_POST['invIki'];
		$itemArray['invPadetis'] = $_POST['invKom'];
		$itemArray['invPastabos'] = $_POST['invKiekis'];
		 
		
		 
		if ($retval) {
			$_SESSION['newinv'] = true;
			header("Location: " . $session->referrer);
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
	
	function procToEditInventor()
	{
		$_SESSION['invpav'] = $_REQUEST['invedit'];
		
		header("Location: " . $path . "inventoriusedit.php");
	}
	
	function procDeleteInventor()
	{
		global $database;
	
		$q = "DELETE FROM " . TBL_INVENTORY . " WHERE pavadinimas = '".$_REQUEST['invdel']."'";
		$database->query($q);
		
		header("Location: " . $path . "inventoriuslist.php");
	}
	
	function procEditInventor()
	{		
		global $session, $form;
			
		$itemArray = array();
			
		$itemArray['invName'] = $_POST['invName'];
		$itemArray['invPlace'] = $_POST['invPlace'];
		$itemArray['invBusena'] = $_POST['invBusena'];
		$itemArray['invPadetis'] = $_POST['invPadetis'];
		$itemArray['invPastabos'] = $_POST['invPastabos'];
		$itemArray['invMobilus'] = (isset($_POST['invMobilus'])) ? 1 : 0;
		
		$retval = $session->editInventory($itemArray);
		
		if ($retval) {
			$_SESSION['newinv'] = true;
			header("Location: " . $path . "inventoriuslist.php");
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
	
	function procAddReservation()
	{
		global $session, $form;
			
		$itemArray = array();
			
		$itemArray['invName'] = $_POST['invName'];
		$itemArray['invNuo'] = $_POST['invNuo'];
		$itemArray['invIki'] = $_POST['invIki'];
		$itemArray['invKom'] = $_POST['invKom'];
		$itemArray['invKiekis'] = $_POST['invKiekis'];
	
		$retval = $session->addReservation($itemArray);
	
		if ($retval) {
			$_SESSION['newrez'] = true;
			header("Location: " . $path . "inventoriusrezervacija.php");
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
}

$process = new Process;

?>