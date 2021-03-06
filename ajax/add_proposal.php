<?php

/*
 * Author: Marko Bratkovič (marko@lunca.com)
 */

include_once ("../config/config.php");

//	TODO: User check
//	if (empty ($_SESSION['user_id'])) die ('gtfo');
$user_id = 0;

$right_id	= (int)$_POST['right_id'];
$title		= (string)$_POST['title'];
$content	= (string)$_POST['content'];

$returnArr	= array ();

if (empty ($returnArr) && empty ($title)) {
	$returnArr = array (
		'success'		=> 0,
		'description'	=> 'Prosimo, vnesite naziv predloga.'
	);
}

if (empty ($returnArr) && empty ($content)) {
	$returnArr = array (
		'success'		=> 0,
		'description'	=> 'Prosimo, vnesite vsebino predloga.'
	);
}

if (empty ($returnArr)) {

	$mysqli = new mysqli ($dbhost, $dbuser, $dbpassword, $dbname);

	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	$sql = "
		INSERT INTO
			proposal
		(`id_right`, `id_user`, `title`, `text`, `timestamp`)
		VALUES
		('" . $right_id . "', '" . $user_id . "', '" . mysqli_real_escape_string ($mysqli, $title) . "', '" . mysqli_real_escape_string ($mysqli, $content) . "', NOW())
	";
	mysqli_query ($mysqli, $sql);
	if (mysqli_affected_rows ($mysqli) <= 0) {
		$returnArr = array (
			'success'		=> 0,
			'description'	=> 'Pri dodajanju predloga je prišlo do napake. Prosimo, poskusite ponovno ali o tem obvestite urednika.'
		);
	} else {
		$returnArr = array (
			'success'		=> 1,
			'description'	=> 'Hvala, vaš predlog je uspešno dodan in čaka na potrditev objave.'
		);
	}

}

/* close connection */
$mysqli->close();

echo json_encode ($returnArr);
