<?php 
function create_bdd(){
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=EIP', 'root', '');
	}catch (Exception $e){
   		die('Erreur : ' . $e->getMessage());
   	}
   	return $bdd;
}

function page(){
	if (isset($_GET["p"])){
		switch ($_GET["p"]) {
			case 'h':
				home();
				break;
			case 'aq':
				add_quest();
				break;
			case 'c':
				break;
			case 'd':
				$_SESSION = array();
				session_destroy();
				header("Location: ../index.php");
				break;
			case 'dp':
				detail_proj($_GET["id"]);
				break;
			case 'lp':
				find_proj();
				break;
			case 'ap':
				$bdd = create_bdd();
				$client = new client();
				$client->down_info($bdd, $_SESSION["login"]);
				//$id = $client->get_ID();
				add_proj($client->get_ID());
				break;
			default:
				home();
				break;
		}
	}else home();
}

function list_eip(){
	if (isset($_GET["v"])){
		$precision = "WHERE Valid='2' ORDER BY ID DESC";
		echo "<h4>Liste des E.I.P valider.</h4>";
		listing($precision);
	}else if(isset($_GET["s"])){
		$precision = "WHERE Valid='1' ORDER BY ID DESC";
		echo "<h4>Liste des E.I.P en cours de validation.</h4>";
		listing($precision);
	}else if(isset($_GET["w"])){
		$precision = "WHERE valid='-1' ORDER BY ID DESC";
		echo "<h4>Liste des E.I.P en attents de validation.</h4>";
		listing($precision);
	}else{
		$precision = "ORDER BY ID DESC";
		echo "<h4>Liste des E.I.P.</h4>";
		listing($precision);
	}
}

function listing($precision){
	$bdd = create_bdd();
	$result = sql_select($bdd, "*", "Projects", $precision);
	for ($i=0; isset($result[$i]); $i++) {
		echo "<li style='font-size: 1.2em'><a href='../home.php?p=dp&id=" .$result[$i][0] ."'>" .$result[$i][1] ." :</a></li>";
	    echo "Date de Création : " .$result[$i][3];
	}
}