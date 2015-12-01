<?php
	
	// replay42 // Dec. 2nd, 2015
	// postbooster.php
	// Post Booster
	
	// + + + NOTE + + +
	// Currently not sure if it's working
	// + + + NOTE + + +

	include('jodel.class.php');

	if(isset($_GET['amount'])) {
		$amount = intval($_GET['amount']);
	} else {
		$amount = 5;
	}

	if(!isset($_GET['postid'])) {
		die("Missing get-parameter postid");
	} else {
		$postid = $_GET['postid'];
	}

	for($i = 0; $i < $amount; $i++) {
		$jodel = new Jodel;
		$jodel->setUdid('');
		$jodel->setPos(50.1183, 8.7011, 'Frankfurt am Main', 'DE');
		$jodel->upVote( $postid );

		sleep(1);
	}

	echo "Post boosted " . $amount ." times.";
?>
