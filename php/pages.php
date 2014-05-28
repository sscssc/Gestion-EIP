<?php

function add_quest(){
	echo '	<article class="ContenuBas">	
					<header>
						<h2>Ajouter un objectif</h2>
					</header>
					<form action="" method="post">
						<li><a href="#"></a> Nom: </li>					
						<textarea name="quest_name" id="comments" style="width:400px;height:20px;"></textarea><br />
						</article>
				
						<article class="ContenuBas">	
						<header>
							<h2>Détailler l objectif: </h2>
						</header>
						<textarea name="quest_obj" id="comments" style="width:90% ;height:480px;"></textarea><br />
						<input type="submit" class="myButton" value="Envoyer" />
					</form>';
}

function find_proj(){
	echo '<article class="ContenuBas">	
			<header>
				<h2>Trouver un Projet</h2>
			</header>
			<form action="../home.php?p=lp" method="post">
  				<input name="f" type="text" style="width:400px;height:20px;" /><br />
 				<input type="submit" class ="myButton" name="sa" value="Search" />
			</form></br>';
			if (isset($_POST["f"])){
				$bdd = create_bdd();
				$search = sql_select($bdd, "*", "projects", "WHERE name='".$_POST["f"]."'");
				if ($search[0][0]){
					echo "<li style='font-size: 1.2em'><a href='../home.php?p=dp&id=".$search[0][0]."'>".$search[0][1]." :</a></li>";
					echo "Date de Création : ".$search[0][3];
				}else
					echo "Aucun resulta pour la recherche : ".$_POST["f"];
			}else
				list_eip();
	echo '</article>
			<article class="ContenuBas">	
				<header>
					<h2>Derniers projets ajoutés</h2>
				</header>';
				block_last_add();
			echo '</article>
			
			<article class="ContenuBas">	
				<header>
					<h2>Derniers projets validés</h2>
				</header>';
				block_last_valid();
	echo "	</article>";
}

function detail_proj($id){
	$bdd = create_bdd();
	$req = sql_select($bdd, '*', 'projects', "WHERE ID=".$id);
	$user = sql_select($bdd, '*', 'members', "WHERE login='".$_SESSION['login']."'");
	
	if ($req[0][7] == -1){
		$stat = "en attents";
	}else if($req[0][7] == 1){
		$timeout = split(" ", $req[0][3]);
		$timeout = split("-", $timeout[0]);

		$timeout = $timeout[2]."/".$timeout[1]."/".$timeout[0];
		$total_prof = sql_select($bdd, 'count(*)', 'Members', "WHERE type='2'");
		$stat = "Vote en cours</label>, fin du vote dans ".$timeout."<br><li><label style='color: green'>".$req[0][5]."</label> vote favorable sur ".$total_prof[0][0]."</li></br>";
		$color = "blue";
		if ($req[0][5] >= $total_prof[0][0]/2){
			sql_update($bdd, "projects", "valid = '2'", "ID = '".$id."'" );
		}
	}else if ($req[0][7] == 2){
		$stat = "Valider.";
		$color = "green";
	}else{
		$stat = "Refusé";
		$color = "red";
	}
		echo '
		<article class="ContenuBas">	
			<header>
				<h2>Fiche Projet: </h2>Validation : <label style="color: '.$color.'">'.$stat.'</label>';
				if ($req[0][7] <= 1){
					if ($user[0][7] == 2){
						$sql = sql_select($bdd, "count(*)", "vote", "WHERE id_prof='".$user[0][0]."' AND id_project='".$id."'");
						if ($sql[0][0] == NULL){
							if (!isset($_POST["vote"])){
								echo "<form method='POST' action='home.php?p=dp&id=".$id."'>
										<left><input name='vote'type='submit' value='Vote +1'></left>
									</form>";
							}else
								sql_insert_v($bdd, $user[0][0], $id, $req);
						}
					}
				}
	echo ' 		</header>
 			<li>Nom: <a href="#">'.$req[0][1].'</a></li>';
 			if (isset($_SESSION["login"])){
 				//$user_pid = $sql_select($bdd, "*", "members", "WHERE login='".$_SESSION['login']."'");
 				if ($id == $user_pid[0][8])
					echo'<button type="button" class="myButton">Modifier</button> ';
			}	
		echo '<header>
				<h3>Description projet:</h3>
				<textarea readonly="readonly" style="width: 98%;height:120px;">'.$req[0][2].'</textarea>
				<button type="button" class="myButton">Modifier</button> 
				<li><a href="#"> Galerie Photos </a></li>
			</header>	
	</article>
		
	<article class="ContenuBas">	
		<header>
			<h2>Commentaires</h2>
		</header>
		<form action="" method="post">
			Comments:<br />
			<textarea name="comments" id="comments" style="width:400px;height:120px;"></textarea><br />
			<input type="submit" class="myButton" value="Envoyer" />
		</form>
	</article>';
}

function home(){
	echo "	<article class='ContenuBas'>	
				<header>
					<h2>L'innovation au coeur de l'école : les EIP</h2>
				</header>
				À l’ETNA, en 2e et 3e année, l'étudiant doit réaliser son projet en entier et tout mettre en œuvre pour qu'il soit utilisable dans le monde professionnel.

				L'EIP est la vitrine personnelle du groupe d’étudiants qui s’y est attelé. Il ne s’agit plus seulement de montrer sa technique, elle est supposée acquise. Le but est de porter à un niveau d’achèvement total, montrable et utilisable à l’extérieur la réalisation produite. Le projet doit avoir son mode d’emploi pour les utilisateurs et sa notice technique pour pouvoir être repris par une autre équipe. C’est un vrai travail d’entreprise, complet : imaginé, conçu, développé, formalisé, finalisé, présenté et	souvent … vendu.
			</article>
			<article class='ContenuBas'>	
				<header>
					<h2>Le Forum des EIP</h2>
				</header>
				Le résultat de ce travail est présenté lors du Forum des EIP ETNA, organisé chaque année à la rentrée, qui offre des tribunes d'expositions aux étudiants.	
			</article>
			<article class='ContenuBas'>
				<header>
					<h2>Derniers projets ajoutés</h2>
				</header>";
				block_last_add();
	echo "	</article>
			<article class='ContenuBas'>	
				<header>
					<h2>Derniers projets validés</h2>
				</header>";
				block_last_valid();
	echo "	</article>";
}

function add_proj($id){
	$bdd = create_bdd();
	$idp = sql_select($bdd, "*", "Members", "WHERE ID = '".$id."'");
	if ($idp[0][8] == NULL){
		if (!isset($_POST["sp"])){
			echo '<article class="ContenuBas">	
					<header>
						<h2>Fiche Projet</h2>
					</header>
		 			<form enctype="multipart/form-data" method="post" action="home.php?p=ap">
						<label>Nom du projet *:</label><br>
						<input name="project_name" type="text" style="width:100%"  value="" /> <br>
						</br><label>Cahier des charges fonctionnelles *:</label><br>
						<input name="cdcf" type="file" /></br>
						</br><label>Objectif *:</label><br>	
						<textarea name="descript" id="comments" style="width:100%;height:120px;"></textarea><br /><br />
						<label>Nombre de participants *:</label>
						<input name="nb_membre" type="text" style="width:5%" value="" /> <br>
						<label>Membre du Projet*: </label><br>
		    			<input name="1_mem" id="_1_mem" /> <br>
						Comments:<br />
						<textarea name="comments" id="comments" style="width:400px;height:120px;"></textarea><br />
						<input type="hidden" name="sp" />
						<input type="submit" class="myButton" value="Envoyer" />
					</form>
				</article>';
		}else{
	      	sql_inser_p($bdd, $id);
	      	$idp = sql_select($bdd, "*", "Members", "WHERE ID = '".$id."'");
	      	header("location: ../home.php?p=dp&id=".$idp[0][8]);
		}
	}else header("location: ../home.php?p=dp&id=".$idp[0][8]);
}	