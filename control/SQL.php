<?php

include_once("../model/User.php");
@session_start();
function connect(){
	return mysqli_connect("127.0.0.1","root","","mydatabase");
}

function getUserByLM($login,$mdp){//return 0 ou 1 Utilisateur
	$O = [];//initialiser a un Objet vide
	
	$db = connect();
	$stmt = mysqli_prepare($db, "SELECT * FROM user WHERE login=? AND mdp=?");
	mysqli_stmt_bind_param($stmt, "ss", $login, $mdp);
	mysqli_stmt_bind_result($stmt, $id, $nom, $login, $mdp, $type);
	mysqli_stmt_execute($stmt);
	
	while(mysqli_stmt_fetch($stmt)){
		$O = new User($id, $nom, $login, $mdp, $type);
	}
	
	return $O;
}

function getUserByLogin($login){//return 0 ou 1 Utilisateur
	$O = [];//initialiser a un Objet vide
	
	$db = connect();
	$stmt = mysqli_prepare($db, "SELECT * FROM user WHERE login=?");
	mysqli_stmt_bind_param($stmt, "s", $login);
	mysqli_stmt_bind_result($stmt, $id, $nom, $login, $mdp, $type);
	mysqli_stmt_execute($stmt);
	
	while(mysqli_stmt_fetch($stmt)){
		$O = new User($id, $nom, $login, $mdp, $type);
	}
	
	return $O;
}

function getUsers(){//return 0 ou *** Utilisateur
	$O = [];//initialiser a une List vide
	
	$db = connect();
	$stmt = mysqli_prepare($db, "SELECT * FROM user WHERE login=? AND mdp=?");
	mysqli_stmt_bind_param($stmt, "ss", $login, $mdp);
	mysqli_stmt_bind_result($stmt, $id, $nom, $login, $mdp, $type);
	mysqli_stmt_execute($stmt);
	
	while(mysqli_stmt_fetch($stmt)){
		array_push( $O , new User($id, $nom, $login, $mdp, $type) );
	}
	
	return $O;
}

function insertUser($nom, $login, $mdp, $type){
	
	$db = connect();
	$stmt = mysqli_prepare($db, "INSERT INTO user VALUES (NULL, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($stmt, "sssi", $nom, $login, $mdp, $type);
	mysqli_stmt_execute($stmt);
	
	return mysqli_insert_id($db);//id (valeur de l'auto increment) si on veut
}


?>