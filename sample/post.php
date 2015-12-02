<?php
	// showposts.php
	header("Content-Type: text/plain");
	include('../jodel.class.php');

	// Setting Position to Frankfurt / Germany
	$position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE');

	// Creating fixed udid so that we have only one "account"
	$udid = hash('sha256', 'december2015');
	
	// Creating Jodel Instance
	$jodel = new Jodel($udid, $position);

	// Now we can post to our account with udid "december2015"
	$text = "Random sample Jodel-text."
	$aPosts = $jodel->post( $text );

	// Print Results
	// Prints result of showPosts() including our submitted post.
	print_r($aPosts);
	
?>
