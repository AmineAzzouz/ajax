<?php

class User{
	
	public $id;
	public $nom;
	public $login;
	public $mdp;
	public $type;
	
	function __construct($id, $nom, $login, $mdp, $type){
		$this->id 		= $id;
		$this->nom 		= $nom;
		$this->login	= $login;
		$this->mdp		= $mdp;
		$this->type		= $type;
	}
	
}

?>