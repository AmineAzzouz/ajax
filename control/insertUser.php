<?php
@session_start();

include_once("SQL.php");

//Objet de repense
$rep = [
	"err"=>"",
	"data"=>""
];

if(isset($_POST["nom"])&&isset($_POST["login"])&&isset($_POST["mdp"])&&isset($_POST["mdpc"])&&isset($_POST["type"])){
	
	$nom 	= $_POST["nom"];
	$login 	= $_POST["login"];
	$mdp 	= $_POST["mdp"];
	$mdpc 	= $_POST["mdpc"];
	$type 	= $_POST["type"];
	
	//controle de champs
	if(empty($nom)){// champ nom vide en return par exemple code d'erreur 1
		$rep["err"] .= 1;
	}
	if(empty($login)){// code d'erreur 2 si login vide
		$rep["err"] .= 2;
	}
	if(empty($mdp)){// code d'erreur 3 si mdp vide
		$rep["err"] .= 3;
	}else{
		if($mdp != $mdpc){// code d'erreur 4 si la confirmation de mot de passe est fausse
			$rep["err"] .= 4;
		}
	}
	if(empty($type)){// code d'erreur 5 si type vide
		$rep["err"] .= 5;
	}
	
	if(empty($rep["err"])){//Y a pas d'erreur les champs ne sans pas vide
		
		//Si login exist
		$U = getUserByLogin($login);
		if( count($U) != 0){// code d'erreur 6 si le Login exist déjà dans la BDD
			$rep["err"] .= "6";
		}else{//Login n'exist pas, donc on peut inserer a la base de donnée
			insertUser($nom, $login, $mdp, $type);
			$rep["err"]	= "0";// Code d'erreur 0 : y a pas d'erreur
		}
		
	}
	
	echo json_encode($rep); //convertir JSON et envoyer la repense
	
}

?>