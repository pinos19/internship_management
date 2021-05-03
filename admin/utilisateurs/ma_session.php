
<?php
	session_start();
	if(!isset($_SESSION['user'])) { // si l'utilisateur n'est pas conn�ct�
		//si la variable $_SESSION['user'] n'existe pas			
		header("location:../utilisateurs/login.php");
		//exit();
	}
?>