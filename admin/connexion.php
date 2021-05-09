<?php
$pdo = new PDO("mysql: host=localhost;	dbname=ecoledb", "root", "");
$pdo->exec("SET CHARACTER SET utf8");
//echo "connexion :OK";