<?php

$connection="localhost";
//$connection="lucien";

if ($connection=="lucien") {
	$host="localhost";
	$dname="cdgasq73";
	$user="cdgasq73";
	$password="jayunahCh6";
	$charset='charset=utf8';
}
else {
	$host="localhost";
	$dname="cours_1_bis";
	//$dname="cours_en_ligne_1";
	$user="root";
	$password="";
	$charset="";
}

try {
	$bdd = new PDO('mysql:host='
	.$host.';dbname='.$dname.';'.$charset,
	$user,
	$password,
	array(PDO::ATTR_ERRMODE 
	=> PDO::ERRMODE_EXCEPTION));
}
catch (exception $e) {
	die("Erreur : ".$e->getMessage());
}

?>
