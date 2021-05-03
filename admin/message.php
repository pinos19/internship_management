
<?php // on prend en compte un cas de succès, ça n'a pas trop de sens car une fois arrivé sur cette page, c'est forcément que 
//l'utilisateur n'est pas dans la base de données
	
	/*if(isset($_GET['msg']))
		$msg=$_GET['msg'];
	else
		$msg="";
	
	if(isset($_GET['color']))
		$color=$_GET['color'];
	else
		$color="v";
	
	if(isset($_GET['url']))
		$url=$_GET['url'];
	else
		$url=$_SERVER['HTTP_REFERER']; // ancien code
		
	if($color=="v")
		$alerte='alert alert-success';
	else
		$alerte='alert alert-danger';


	*/
	// on prend pour hypothèse qu'il n'y auncun utilisateurs malveillants pour l'instant donc on a :
	$msg=$_GET['msg'];
	$color=$_GET['color'];
	$url=$_GET['url'];
	$alerte='alert alert-danger';



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>  Les messages </title> 
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	</head>
		
	<body>
	<br><br><br>
		<div class="container col-md-6 col-md-offset-3">
			
			<div class="<?php echo $alerte ?>">
				<h2>
					<?php
						echo $msg;
						header("refresh:1;url=$url");
					?>
				</h2>
			</div>
			
		</div>
	</body>
</html>