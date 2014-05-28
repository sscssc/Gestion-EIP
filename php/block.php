<?php
include "fonction.php";
include "client.php";

function block_login(){
	if (!isset($_POST["co"])){
		if (isset($_GET["e"])){
			$error = $_GET["m"];
			$color[$_GET["e"]] = "red";
		}
		if (!isset($_SESSION["login"])){
			echo "
			<aside class='Colonne1'>
				<article class='ContenuHaut'>	
					<header>
						<h5 style='color: red' >".(isset($error) ? $error : NULL)."<h5>
					</header>
					<div>
						<form method='POST' action='home.php'>
							<label style='color: ".(isset($color[1]) ? $color[1] : NULL)."'>Username *:    </label>
							<input name='login' type='text' maxlength='50' id='login_name'/><br><br>
							<label style='color: ".(isset($color[2]) ? $color[2] : NULL)."''>Password *:</label>
							<input name='pwd' type='password' id='pswrd'/><br><br>
							<input type='Submit' value='Valider'>
							<a href='home.php?p=r' ><button type='button' >Register</button></a>
							<input type='hidden' name='co'>
						</form>
					</div>
				</article>
			</aside>";
		}else{
			echo "<aside class='Colonne1'>
					<article class='ContenuHaut'>
						<h4><center>Bienvenu ".$_SESSION["login"]."</center></h4>";
			$bdd = create_bdd();
			$client = new client();
			$client->down_info($bdd, $_SESSION["login"]);
			$lvl = $client->get_type();

			if ($lvl == 3){
				echo "	<h2>Administration</h2>
						<a href='home.php?p=ma'>modifier message d'acceuil</a>
						</article>
					</aside>";
			}else if ($lvl == 2){
				block_pmenu();
			}else if ($lvl == 1)
				block_emenu($client);
		}
	}else{
		if ($_POST["login"] != NULL){
			if ($_POST["pwd"] != NULL){
				$bdd = create_bdd();
				$client = new client();
				$connect = $client->connection($bdd, $_POST["login"], $_POST["pwd"]);
				if ($connect){
					session_start();
					$_SESSION["login"] = $client->get_login();
					header ("Location: ../home.php");
				}else header ("Location: ../home.php?e=3&m=Erreur login / password");
			}else header ("Location: ../home.php?e=2&m=password vide");
		}else header ("Location: ../home.php?e=1&m=login vide");
	}
}

function block_register(){
	
	if (!isset($_POST["reg"])){

		if (isset($_GET["e"])){
			$color[$_GET["e"]] = "red";
			$error = "<h5 style='color: red; text-align: center;'>".$_GET["m"]." !<h5>";
		}

		echo "	
			<aside class='Colonne1'>
				<article class='ContenuHaut'>	
				<header>
						<h2><center>Entrez vos identifiants: </center></h2>
						".(isset($error) ? $error : NULL)."
				</header>
				<div>
					<form action='home.php?p=r' method='post'>
						<label style='color:".(isset($color[1]) ? $color[1] : NULL)."'>Login *:</label><br>
						<input name='login' type='text' maxlength='50' id='login_name'  value='' /> <br>
						<label style='color:".(isset($color[2]) ? $color[2] : NULL)."'>Nom *: </label><br>
					    <input name='name' type='text'/> <br>
						<label style='color:".(isset($color[3]) ? $color[3] : NULL)."'>Prénom *: </label><br>
					    <input name='subname' type='text'/> <br>
						<label style='color:".(isset($color[4]) ? $color[4] : NULL)."'>E-Mail *:</label><br>
						<input name='email' type='text' id='_email' class='text' /> <br>
						<label style='color:".(isset($color[5]) ? $color[5] : NULL)."'>Mot de passe *:</label><br>
						<input name='pwd' type='password' maxlength='50' id='_login_password' /> <br>
						<label style='color:".(isset($color[6]) ? $color[6] : NULL)."'>Vérifier *:</label><br>
						<input name='pwdv' type='password' id='_password_conf' class='text' /> <br>
						<label>Téléphone:</label><br>
						<input name='phone' type='text' maxlength='50' id='_phone' value='' class='text'  /><br>
						<input type='submit' name='regformsubmit' value='Envoyer'></br>
						<center><a href='home.php' style='color: blue' >Vous etre déja inscrit ?</a>
						</center><input type='hidden' name='reg'>
					</form>
				</div>
				</article>
			</aside>";
	}else{
	/*	$bdd = create_bdd();
		for ($i = 1; $i < 8; $i++){
			if (isset($_POST[$i]) && $_POST[$i] != NULL){
				if ($i = 1 || $i = 4){
					if (sql_select($bdd, "login", "Members", "WHERE ".($i == 4 ? "passwrd" : "login")."='".$_POST[$i]."'") == NULL){
						if ($i == 7){
							$phone = (isset($_POST["phone"]) && $_POST["phone"] != NULL ? $_POST["phone"] : '');
											
							$client = new client('', $_POST[1], $_POST[2], $_POST[3], md5($_POST[5]), $_POST[4], $phone, '', '');
							$client->register($bdd);
						}
					}else return ($i == 4 ? header ("Location: ../home.php?p=r&e=7&m=email deja utiliser") : header ("Location: ../home.php?p=r&e=1&m=Login deja utiliser"));
				}
			}else return header ("Location: ../home.php?p=r&e=".$i."&m=".$error[$i]);
		}*/
		$bdd = create_bdd();
		if (isset($_POST["login"]) && $_POST["login"] != NULL){
			$lsearch = sql_select($bdd, "*", "Members", "WHERE login = '".$_POST["login"]."'");
			if ($lsearch[0][0] == NULL){
				if (isset($_POST["name"]) && $_POST["name"] != NULL){
					if (isset($_POST["subname"]) && $_POST["subname"] != NULL){
						if (isset($_POST["pwd"]) && $_POST["pwd"] != NULL){
							if (isset($_POST["pwdv"]) && $_POST["pwdv"] == $_POST["pwd"]){
								if (isset($_POST["email"]) && $_POST["email"] != NULL){
									$esearch = sql_select($bdd, "email", "Members", "WHERE email='".$_POST["email"]."'");
									if ($esearch[0][0] == NULL){ 

										$phone = (isset($_POST["phone"]) && $_POST["phone"] != NULL ? $_POST["phone"] : '-1');
										
										$client = new client('', $_POST["login"], $_POST["name"], $_POST["subname"], md5($_POST["pwd"]), $_POST["email"], $phone, '1', '');
										$client->register($bdd);
										session_start();
										$_SESSION["login"] = $_POST["login"]; 
										header ("Location: ../home.php");
							
									}else header ("Location: ../home.php?p=r&e=7&m=email deja utiliser");
								}else header ("Location: ../home.php?p=r&e=6&m=email vide");
							}else header ("Location: ../home.php?p=r&e=5&m=verification pwd failed");
						}else header ("Location: ../home.php?p=r&e=4&m=pwd vide");
					}else header ("Location: ../home.php?p=r&e=3&m=nom vide");
				}else header ("Location: ../home.php?p=r&e=2&m=nom vide");
			}else header ("Location: ../home.php?p=r&e=1&m=login deja utiliser");
		}else header ("Location: ../home.php?p=r&e=1&m=login vide");
	}
}

function block_emenu(&$client = NULL){
	$id = $client->get_project_ID();
	echo '	<h2><center>Menu</center></h2>';
	if ($id == 0){
		echo '<center><a href="./home.php?p=ap">Déposer un Projet</a></center></br>';
	}else{
		echo '<center><a href="../home.php?p=dp&id='.$id.'">Detail de votre projet</a></center> <br>';
	}
		echo '
			</article>
		</aside>';
}

function block_pmenu(){
	echo "	<h2><center>Menu Prof</center></h2><center>
			<a href='home.php?p=lp'>Liste des E.I.P</a></br>
			<a href='home.php?p=lp&w'>Liste des E.I.P attents</a></br>
			<a href='home.php?p=lp&s'>Liste des vote E.I.P</a></br>
			<a href='home.php?p=lp&v'>Liste des E.I.P validés</a></br>
			<a href='home.php?p=aq'> Ajouté une quete à un E.I.P</A></br></br></center>
		</article>
	</aside>";
}

function block_groupe(){
	$bdd = create_bdd();
	$user = sql_select($bdd, "*", "members", "WHERE login='".$_SESSION["login"]."'");
	if ($user[0][7] == 1 && $user[0][8] != NULL){
		if (isset($_SESSION["login"])){
			echo '
			<aside class="Colonne1">
				<article class="ContenuHaut">
					<h2>Groupe projet</h2>';
		                $precision = "WHERE project_ID = 1";
	                    $result = sql_select($bdd, "*", "Members", $precision);
	                        
	                    echo "<dt>Membres : </dt>";
	                        
	                    for ($i=0; isset($result[$i]); $i++) {
	               			echo "<dd>" .$result[$i][3] ." " 
	               			.$result[$i][2] ."<br>   contact : " .$result[$i][5] ."\n</dd>";
	                    }

	                    $precision = "WHERE ID = 1";
	                    $result = sql_select($bdd, "Coach_ID", "Projects", $precision);
	                    
	                    $precision = "WHERE ID = '" .$result[0][0] ."'";
	                    $result = sql_select($bdd, "*", "Members", $precision);
	                    echo "<br><dt>Coach : </dt>
	                    <dd>" .$result[0][3] ." " .$result[0][2]
	                    ."<br>   contact : " .$result[0][5] ."\n</dd>";
						
					echo '
				</article>
			</aside>';
		}
	}
}

function block_bar(){
	$p[(isset($_GET["p"]) ? $_GET["p"] : "a")] = "active";
	echo '<header class="HeaderPrim">
	<nav><ul>
		<li class="'.$p["a"].'"><a href="home.php"> Accueil </a></li>
		<li class="'.$p["lp"].'"><a href="home.php?p=lp">Liste des projets</a></li>';
			if (isset($_SESSION["login"]))
				echo '<li><a href="home.php?p=d">Déconexion</a></li>';
			else
				echo '<li><a href="home.php?p=r">Créer son Compte</a></li>';	
	echo '</ul></nav></header>';
}

function block_objectif(){
	$bdd = create_bdd();
	$user = sql_select($bdd, "*", "members", "WHERE login='".$_SESSION["login"]."'");
	if ($user[0][7] == 1 && $user[0][8] != NULL){
		if (isset($_SESSION["login"])){
			echo '
			<aside class="Colonne1">
				<article class="ContenuHaut">	
					<h2>Objectifs à valider </h2>
					<dl>';
	                    $precision = "WHERE project_ID = 1 ORDER BY number ASC";
	                    $result = sql_select($bdd, "*", "Steps", $precision);

                        for ($i=0; isset($result[$i]); $i++) {
                        	if ($result[$i][7] == 1){
                        		$color = "green";
                        		$image = "<img src='img/valid.png' style='width:15px; height:15px;'>";
                        	}else if ($result[$i][7] == -1){
                        		$color = "red";
                        		$image = "<img src='img/cross.gif' style='width:15px; height:15px;'>";
                        	}else{
                        		$color = "blue";
                        		$image = "";
                        	}
                            echo "<dt style='color: ".$color."'> Étape n°" .$result[$i][1] ." : " .$result[$i][2] .$image ."\n</dt>";
                            echo "<dd>Date de création:" .$result[$i][4] ."<br>";
                            echo "Date de rendu :" .$result[$i][5] ."\n</dd><br>";
                        }   						
						echo '
					</dl>
				</article>
			</aside>';
		}
	}
}

function block_last_add(){
	$bdd = create_bdd();
    $precision = "ORDER BY ID DESC LIMIT 3";
    $result = sql_select($bdd, "*", "Projects", $precision);
    
	for ($i=0; isset($result[$i]); $i++) {
		echo "<li style='font-size: 1.2em'><a href='../home.php?p=dp&id=" .$result[$i][0] ."'>" .$result[$i][1] ." :</a></li>";
		echo "Date de Création : " .$result[$i][3];
	}
}

function block_last_valid(){
	$bdd = create_bdd();
    $precision = "WHERE Valid='2' ORDER BY ID DESC LIMIT 3";
    $result = sql_select($bdd, "*", "Projects", $precision);
    
	for ($i=0; isset($result[$i]); $i++) {
		echo "<li style='font-size: 1.2em'><a href='../home.php?p=dp&id=" .$result[$i][0] ."'>" .$result[$i][1] ." :</a></li>";
		echo "Date de Création : " .$result[$i][3];
	}
}