<?php
	// showposts.php
	header("Content-Type: text/plain");
	include('../jodel.class.php');

	// Setting Position to Frankfurt / Germany
	$position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE');

	// Creating random udid
	$udid = hash('sha256', microtime());
	
	// Creating Jodel Instance
	$jodel = new Jodel($udid, $position);

	// Make getPosts()-Call
	$aPosts = $jodel->getPosts();

	// Print Results
	print_r($aPosts);
	
?>
