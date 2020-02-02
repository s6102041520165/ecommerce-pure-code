<?php 
session_start();
$hostname = "localhost";
$dbname = "shop";
$dns = "mysql:host=$hostname;dbname=$dbname;charset=utf8";
$pdo=new PDO($dns,"root","");
//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
require_once __DIR__.'/vendor/autoload.php';