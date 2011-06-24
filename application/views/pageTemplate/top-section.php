<?php 
	if(!empty($_COOKIE['uid'])){
		$uid=$_COOKIE['uid'];
	}else{
		header("Location:login.php");	
	}
?>