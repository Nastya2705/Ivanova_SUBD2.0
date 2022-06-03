<?php
	$conn = new mysqli("localhost","root","", "db_checkout");
	if($conn->connect_error){
		die("Ошибка соединения! ".$conn->connect_error);
	}
