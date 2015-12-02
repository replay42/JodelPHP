<?php
	// showkarma.php
	header("Content-Type: text/plain");
	include('../jodel.class.php');

	// Setting Position to Frankfurt / Germany
	$position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE');

	// Creating fixed udid so that we have only one "account"
	$udid = hash('sha256', 'december2015');
	
	// Creating Jodel Instance
	$jodel = new Jodel($udid, $position);

	// Make getKarma()-Call
	$sKarma = $jodel->getKarma();

	// Print Results
	print_r($sKarma);
	
?>
