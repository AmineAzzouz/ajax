<?php
@session_start();

include_once("SQL.php");

//Objet de repense
$rep = [
	"err"=>"",
	"data"=>""
];

if(isset($_POST["login"])&&isset($_POST["mdp"])){
	
	$login 	= $_POST["login"];
	$mdp 	= $_POST["mdp"];
	
	$U = getUserByLM($login, $mdp);
	
	if(count( $U ) == 0){//Objet vide donc l'utilisateur n'exist pas
		$rep["err"] = 1;
	}else{//User exist, creation d'une session
		$_SESSION["user"] = serialize($U);//toute les informations de l'utilisateur dans un seul objet
		$rep["err"] = 0;
	}
	
	echo json_encode($rep); //convertir JSON et envoyer la repense
	
}
?>