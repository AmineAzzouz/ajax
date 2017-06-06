<?php 
include_once("./model/User.php");
@session_start();
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Document sans titre</title>
	</head>
	
	<body>
		
		<style>
			/* vaut mieux mettre les style dans un fichier css : et lui faire appele avec la balize <link hraf="style.css"> */
			/* Zone de messages : sans taille, fixé en (bas, droite) de l'ecran*/
			#msgs{
				position:fixed;
				width:0;
				right:20px;
				bottom:20px;
			}
			/* Style de message : mettez le style que vous voulez*/
			#msgs>div{
				width:200px;
				margin:2px;
				padding:5px;
				background:#0af;
				color:#fff;
				position:relative;
				right: 200px;
				border:#333 solid 3px;
				border-radius:10px;
			}
			body{
				margin:0;
				padding:0;
				border:none;
			}
			*{
				box-sizing:content-box;
			}
			input, select{
				margin:2px;
				padding: 5px;
				width:150px;
			}
		</style>
		<h1>AZUL : MVC $.ajax</h1>
<?php 
	if(!isset($_SESSION["user"])){
		//Si y'a pas de session
?>
		<h2>Login</h2>
		Validez Avec Enter
		<div style="padding:20px;">
		<form id="loginForm" action="javascript:login()">
			<input type="text" 		autocomplete="off" value="" name="login" 	placeholder="Login">
			<input type="password" 	autocomplete="off" value="" name="mdp" 		placeholder="Mot de passe">
			<input type="submit" style="display:none">
		</form>
		<h2>Sign in</h2>
		<form id="signinForm" action="javascript:signin()">
			<input type="text" 		autocomplete="off" value="" name="nom" 		placeholder="Nom"><br>
			<input type="text" 		autocomplete="off" value="" name="login" 	placeholder="Login"><br>
			<input type="password" 	autocomplete="off" value="" name="mdp" 		placeholder="Mot de passe"><br>
			<input type="password" 	autocomplete="off" value="" name="mdpc" 	placeholder="Confirmation"><br>
			<select name="type">
				<option value=""> - Selectionez un type</option>
				<optgroup label="">
					<option value="1">Simple User</option>
					<option value="2">Super User</option>
				</optgroup>
			</select><br>
			<input type="submit" value="Valider">
		</form>
		</div>
		<?php
	}else{
		//Si la session exist
		$u = unserialize($_SESSION["user"]);
		if($u->type==1){?>
			<h2><?php echo "Utilisateur : ". $u->nom ." (". $u->login .")"; ?></h2>
			<div>Espace d'un Simple Utilisateur :)</div>
			<a href="control/dec.php">Deconnexion</a>
		<?php
		}
		
		if($u->type==2){?>
			<h2><?php echo "Utilisateur : ". $u->nom ." (". $u->login .")"; ?></h2>
			<div>Espace du <b style="color:red">Super</b> Utilisateur :)</div>
			<a href="control/dec.php">Deconnexion</a>
			
		<?php
		}
	}
		?>
		
		
		<div id="msgs">
		</div>
		
		<!-- chargement de JQuery -->
		<script src="files/jquery/jquery-3.2.1.min.js"></script>
		<!-- chargement de JQuery-ui Pour les Animation -->
		<script src="files/jquery/jquery-ui.min.js"></script>
		
		
		
		<!-- declaration de fonctions (showMSG, login, segnin) -->
		<script>
			//Vaut mieux mettre les script dans un fichier js, et leur faire appelle avec <script src="sqcript.js">
			function login(){
				var f = document.getElementById("loginForm");
				var loginValue 	= f.login.value;
				var mdpValue 	= f.mdp.value;
				$.ajax(
					{
						type: "POST",
						url:"./control/login.php",
						data:{ login:loginValue, mdp:mdpValue },
						success:function( reponseServer ){
							//Action : lorsque on reçoie la repense de serveur, cette fonction sera automatiquement appeler
							console.log( reponseServer );
							//convertire la repense TXT vers un Object JSON pour faciliter l'utilisation !
							var rep = JSON.parse( reponseServer );
							
							if(rep.err == 0){//Login exist
								//redirection
								location = "./";//redirection vers index.php
							}else{
								$("#loginForm").effect("shake",{distance:10,times:5});//Vibration !!
							}
						},
					}
				);
			}
			function signin(){
				var f = document.getElementById("signinForm");
				
				var nomValue 	= f.nom.value;
				var loginValue 	= f.login.value;
				var mdpValue 	= f.mdp.value;
				var mdpcValue 	= f.mdpc.value;
				var typeValue 	= f.type.value;
				
				$.ajax(
					{
						type: "POST",
						url:"./control/insertUser.php",
						data:{ nom:nomValue, login:loginValue, mdp:mdpValue, mdpc:mdpcValue, type:typeValue },
						success:function( reponseServer ){
							console.log( reponseServer );
							var rep = JSON.parse( reponseServer );
							var err = rep.err;
							if(err==0){
								showMSG("Ajout avec success !!");
							}else{
								if(err.includes(1)){
									showMSG("Nom requis");
								}
								if(err.includes(2)){
									showMSG("Login requis");
								}
								if(err.includes(3)){
									showMSG("Mot de passe requis");
								}
								if(err.includes(4)){
									showMSG("Confirmation de Mot de passe fausse");
								}
								if(err.includes(5)){
									showMSG("Type requis");
								}
								if(err.includes(6)){
									showMSG("Login exist déjà");
								}
							}
						},
					}
				);
			}
			function showMSG(msg){
				var duree = 3000;
				var div = document.createElement("div");
				var msgs = document.querySelector("#msgs");
				div.style.right = "-50px";
				div.innerHTML = msg;
				msgs.appendChild(div);
				$(div).animate({ 
					right: "+=260px",
				}, 500 );
				setTimeout(function(){$(div).animate({ 
					right: "-=260px",
				}, {duration:500,done:function(){div.remove()}} );},duree);
			}

		</script>
	</body>
</html>