<?php 
	include "php/pages.php"; 
	include "php/block.php";
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Suivi E.I.P</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<?php block_bar(); ?>
<body class="body">
	<div class="Contenue">
		<div class="Contenu">	
			<?php page(); ?>
		</div>
	</div>
		<div class="ContenuSec">
		<div align='left' class="Contenue">
		<?php	
			if (isset($_GET["p"]) && $_GET["p"] == 'r'){
				block_register();
				echo "testtest";
			}else 
				block_login();
			block_groupe();
			block_objectif();			
		?>	
		</div>
	</div>
</body>
</html>