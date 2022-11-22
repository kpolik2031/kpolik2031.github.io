<?php

	include ($_SERVER['DOCUMENT_ROOT'].'/app/store/config.php');

	@$mysqli = new mysqli($database['host'], $database['user'], $database['password'], $database['dbname']);

	if ($mysqli->connect_error) {
		exit('<center>Ошибка подключении к базе данных - <b>' . $mysqli->connect_error . '</b></center>');
	}

	function selectAll ($sql = '') {
		global $mysqli;
		$query = $mysqli->query($sql);
		return ($query) ? $query->fetch_all(MYSQLI_ASSOC) : null;
	}

	function selectOne ($sql = '') {
		global $mysqli;
		$query = $mysqli->query($sql);
		return ($query) ? $query->fetch_assoc() : null;
	}

	function sql_request ($sql = '') {
		global $mysqli;
		return $mysqli->query($sql);
	}

?>