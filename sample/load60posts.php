<?php
	// load60posts.php
	header("Content-Type: text/plain");
	include('../jodel.class.php');

	// Setting Position to Frankfurt / Germany
	$position = array(50.1183, 8.7011, 'Frankfurt am Main', 'DE');

	// Creating random udid
	$udid = hash('sha256', microtime());
	
	// Creating Jodel Instance
	$jodel = new Jodel($udid, $position);

	// Make getPosts()-Call
	$aPosts = $jodel->getPosts()->posts;
	
	// Skip those loaded posts
  $jodel->skip(30);
  
  // Load next 30 posts
  $aPosts2 = $jodel->getPosts()->posts;
  
  // Merge both arrays
  $aResult = array_merge($aPosts, $aPosts2);
  
	// Print Results
	print_r($aResult);
	
?>
