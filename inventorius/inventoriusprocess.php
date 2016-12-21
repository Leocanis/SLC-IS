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
		else if(isset($_POST['subaddrad']))
		{
			$this->procAddRadinys();
		}
		else if(isset($_GET['rr']))
		{
			$this->procRemRadinys();
		}
		else if(isset($_POST['subaddcompany']))
		{
			$this->procAddImone();
		}
		else if(isset($_POST['subaddreservationimone']))
		{
			$this->procAddReservationImone();
		}
		/**
		 * Should not get here, which means user is viewing this page
		 * by mistake and therefore is redirected.
		 */ else {
		 header("Location: index.php");
		}
	}
	
	function procAddReservationImone()
	{
		global $session, $form;
			
		$itemArray = array();
			
		$itemArray['compid'] = $_POST['compid'];
		$itemArray['resdate'] = $_POST['resdate'];
		$itemArray['respagsk'] = $_POST['respagsk'];
			
		$retval = $session->addReservationImone($itemArray);
			
		if ($retval) {
			$_SESSION['newcompres'] = true;
			header("Location: " . $session->referrer);
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
	
	function procAddImone()
	{
		global $session, $form;
			
		$itemArray = array();
			
		$itemArray['compname'] = $_POST['compname'];
		$itemArray['compcode'] = $_POST['compcode'];
		$itemArray['compadd'] = $_POST['compadd'];
		$itemArray['compcity'] = $_POST['compcity'];
		$itemArray['compper'] = $_POST['compper'];
		$itemArray['compphone'] = $_POST['compphone'];
		$itemArray['compemail'] = $_POST['compemail'];
		$itemArray['compbac'] = $_POST['compbac'];
			
		$retval = $session->addImone($itemArray);
			
		if ($retval) {
			$_SESSION['newcomp'] = true;
			header("Location: " . $session->referrer);
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
	
	function procRemRadinys()
	{
		global $session;
		
		$radid = $_REQUEST['radid'];			
			
		
		$retval = $session->remRadinys($radid);
			
		if ($retval) {
			$_SESSION['remrad'] = true;
			header("Location: " . $session->referrer);
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
	
	function procAddRadinys()
	{
		global $session, $form;
			
		$itemArray = array();
			
		$itemArray['radname'] = $_POST['radname'];
		$itemArray['radplace'] = $_POST['radplace'];
		$itemArray['radkom'] = $_POST['radkom'];
			
		$retval = $session->addRadinys($itemArray);
			
		if ($retval) {
			$_SESSION['newrad'] = true;
			header("Location: " . $session->referrer);
		}
		/* Error found with form */
		else {
			$_SESSION['value_array'] = $_POST;
			$_SESSION['error_array'] = $form->getErrorArray();
			header("Location: " . $session->referrer);
		}
	}
	
	function procAddNewInventor()
	{
		global $session, $form;
		 
		$itemArray = array();
		 
		$itemArray['invName'] = $_POST['invName'];
		$itemArray['invPlace'] = $_POST['invPlace'];
		$itemArray['invBusena'] = $_POST['invBusena'];
		$itemArray['invPadetis'] = $_POST['invPadetis'];
		$itemArray['invPastabos'] = $_POST['invPastabos'];
		 
		$retval = $session->addNewInventory($itemArray);
		 
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