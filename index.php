<?php
session_start();
include_once("php/header.php");
include_once("php/classes.php");
var_dump($_SESSION['admin']);
if(isset($_GET['page'])){
	$page=$_GET['page'];
	if($page == 1)include_once('php/aboutUs.php');
	if($page == 2)include_once('php/aboutBallroom.php');
	if($page == 3)include_once('php/news.php');
	if($page == 4)include_once('php/schedule.php');
	if($page == 5)include_once('php/gallery.php');
	if($page==6 && isset($_SESSION['sport'])){
		include_once("php/sport.php");
	}
	if ($page==6 && !isset($_SESSION['sport']) && !isset($_SESSION['admin'])){
		include_once("php/sportLogin.php");
	}
	if ($page==6 && isset($_SESSION['admin'])){
		include_once("php/admin.php");
	}
}
	include_once("php/footer.php");?>
