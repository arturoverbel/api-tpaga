<?php
	
	session_start();

	$data = $_GET['data'];
	$field = $_GET['field'];

	$_SESSION[$field] = $data;

	die();
